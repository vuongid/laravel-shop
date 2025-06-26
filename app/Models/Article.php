<?php

namespace App\Models;

use App\Enums\GeneralStatus;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Illuminate\Support\Str;

class Article extends Model implements HasMedia
{
    use InteractsWithMedia;
    protected $table = 'articles';
    protected $fillable = ['title', 'category_id', 'description', 'content', 'status', 'slug'];
    protected function casts(): array
    {
        return [
            'status' => GeneralStatus::class,
        ];
    }

    public function registerMediaCollections(): void
    {
        $this
            ->addMediaCollection($this->table)
            ->singleFile()
            ->useFallbackUrl(asset('media/default.png'));
    }

    public function scopeActive($query)
    {
        $query->where('status', GeneralStatus::ACTIVE);
    }

    public function scopeMyActive($query)
    {
        $query->where('status', GeneralStatus::ACTIVE);
    }

    public function listItems($params = null, $options = null)
    {
        $result = null;

        if ($options['task'] == 'list-items') {
            $query = self::select('id', 'title', 'description', 'slug', 'status', 'created_at', 'updated_at');

            if (!empty($params['keyword'])) {
                $query->where(function ($q) use ($params) {
                    $q->where('title', 'LIKE', '%' . $params['keyword'] . '%')
                        ->orWhere('description', 'LIKE', '%' . $params['keyword'] . '%');
                });
            }
            if (!empty($params['slug'])) {
                $query->where('slug', 'LIKE', "%{$params['slug']}%");
            }
            if (!empty($params['datefilter'])) {
                $dates = explode(' - ', $params['datefilter']);
                $startDate = \Carbon\Carbon::createFromFormat('m/d/Y', trim($dates[0]))->startOfDay();
                $endDate = \Carbon\Carbon::createFromFormat('m/d/Y', trim($dates[1]))->endOfDay();
                $query->whereBetween('created_at', [$startDate, $endDate]);
            }
            if (!empty($params['created_at'])) {
                $query->where('created_at', '>=', "{$params['created_at']}");
            }
            if (!empty($params['updated_at'])) {
                $query->where('updated_at', '<=', "{$params['updated_at']}");
            }
            if (!empty($params['status']) && ($params['status'] == GeneralStatus::ACTIVE->value || $params['status'] == GeneralStatus::INACTIVE->value)) {
                $query->where('status', "{$params['status']}");
            }

            $result = $query->orderBy('id', 'desc')->paginate($params['pagination']['totalItemsPerPage']);
        }

        if ($options['task'] == 'list-items-article-category') {
            return ArticleCategory::pluck('name', 'id')->toArray();
        }

        if ($options['task'] == 'list-items-tag') {
            return Tag::pluck('name', 'id')->toArray();
        }

        if ($options['task'] == 'list-article-tag-ids') {
            return ArticleTag::where('article_id', $params['item']->id)
                ->pluck('tag_id')
                ->toArray();
        }



        return $result;
    }

    public function saveItem($params = null, $options = null)
    {
        if ($options['task'] == 'change-status') {
            self::where('id', $params['id'])->update(['status' => $params['status']]);
        }
        if ($options['task'] == 'create-item') {
            $params['slug'] = $this->generateUniqueSlug($params['slug']);

            return $item = self::create($params);
        }

        if ($options['task'] == 'edit-item') {
            $item = self::find($params['item']->id);
            $params['slug'] = $this->generateUniqueSlug($params['slug'], $params['item']->id);
            $item->update($params);

            return $item;
        }

        if ($options['task'] == 'create-article-tag') {
            foreach ($params['tags'] as $tag) {
                ArticleTag::create([
                    'article_id' => $params['item']->id,
                    'tag_id' => $tag,
                ]);
            }
            return;
        }
    }

    public function deleteItem($params = null, $options = null)
    {
        if ($options['task'] == 'delete-item') {
            $item = $params['item'];
            $item->delete();
        }

        if ($options['task'] == 'delete-tags-of-article') {
            ArticleTag::where('article_id', $params['item']->id)->delete();
        }
    }

    public function uploadImage($file)
    {
        $ext = $file->getClientOriginalExtension();
        $randomName = Str::random(10) . '.' . $ext;

        $this->addMedia($file)
            ->usingFileName($randomName)
            ->toMediaCollection($this->getTable());
    }

    private function generateUniqueSlug($slug, $excludeId = null)
    {
        $originalSlug = Str::slug($slug);
        $slug = $originalSlug;
        $counter = 1;

        do {
            $query = self::where('slug', $slug);

            if ($excludeId) {
                $query->where('id', '!=', $excludeId);
            }

            $exists = $query->exists();

            if ($exists) {
                $slug = $originalSlug . '-' . $counter;
                $counter++;
            }
        } while ($exists);

        return $slug;
    }
}

<?php

namespace App\Models;

use App\Enums\GeneralStatus;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class ArticleTag extends Model
{
    protected $table = 'article_tag';
    protected $fillable = ['tag_id', 'article_id', 'status'];
    protected function casts(): array
    {
        return [
            'status' => GeneralStatus::class,
        ];
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
        if (($options['task'] ?? '') === 'list-items') {
            $query = self::join('articles', 'article_tag.article_id', '=', 'articles.id')
                ->join('tags', 'article_tag.tag_id', '=', 'tags.id')
                ->select([
                    'article_tag.article_id',
                    'article_tag.tag_id',
                    'articles.title as article_title',
                    'tags.name as tag_name',
                    'article_tag.status',
                    'article_tag.id',
                ]);

            // if (!empty($params['title'])) {
            //     $query->where('title', 'LIKE', "%{$params['title']}%");
            // }
            // if (!empty($params['description'])) {
            //     $query->where('description', 'LIKE', "%{$params['description']}%");
            // }
            // if (!empty($params['slug'])) {
            //     $query->where('slug', 'LIKE', "%{$params['slug']}%");
            // }
            // if (!empty($params['created_at'])) {
            //     $query->where('created_at', '>=', "{$params['created_at']}");
            // }
            // if (!empty($params['updated_at'])) {
            //     $query->where('updated_at', '<=', "{$params['updated_at']}");
            // }
            // if (!empty($params['status']) && ($params['status'] == GeneralStatus::ACTIVE->value || $params['status'] == GeneralStatus::INACTIVE->value)) {
            //     $query->where('status', "{$params['status']}");
            // }

            return $query->orderBy('article_tag.article_id', 'desc')->paginate($params['pagination']['totalItemsPerPage']);
        }


        if ($options['task'] == 'list-items-article') {
            return Article::pluck('title', 'id')->toArray();
        }

        if ($options['task'] == 'list-items-tag') {
            return Tag::pluck('name', 'id')->toArray();
        }
    }

    public function saveItem($params = null, $options = null)
    {
        if ($options['task'] == 'change-status') {

            $status = ($params['currentStatus'] == GeneralStatus::ACTIVE->value) ? GeneralStatus::INACTIVE->value : GeneralStatus::ACTIVE->value;
            self::where('id', $params['id'])->update(['status' => $status]);
        }
        if ($options['task'] == 'create-item') {
            return self::create($params);
        }

        if ($options['task'] == 'edit-item') {

            return $params['item']->update($params);
        }
    }

    public function deleteItem($params = null, $options = null)
    {
        if ($options['task'] == 'delete-item') {
            $params['item']->delete();
        }
    }

    private function generateUniqueSlug($name, $excludeId = null)
    {
        $slug = Str::slug($name);
        $originalSlug = $slug;
        $counter = 1;

        $query = self::where('slug', $slug);
        if ($excludeId) {
            $query->where('id', '!=', $excludeId);
        }

        while ($query->exists()) {
            $slug = $originalSlug . '-' . $counter;
            $counter++;

            $query = self::where('slug', $slug);
            if ($excludeId) {
                $query->where('id', '!=', $excludeId);
            }
        }

        return $slug;
    }
}

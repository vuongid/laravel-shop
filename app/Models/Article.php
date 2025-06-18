<?php

namespace App\Models;

use App\Enums\GeneralStatus;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

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
            $query = self::select('id', 'title', 'status', 'created_at', 'updated_at');

            if (!empty($params['title'])) {
                $query->where('title', 'LIKE', "%{$params['title']}%");
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

        return $result;
    }

    public function saveItem($params = null, $options = null)
    {
        if ($options['task'] == 'change-status') {

            $status = ($params['currentStatus'] == GeneralStatus::ACTIVE->value) ? GeneralStatus::INACTIVE->value : GeneralStatus::ACTIVE->value;
            self::where('id', $params['id'])->update(['status' => $status]);
        }
        if ($options['task'] == 'create-item') {
            return $item = self::create($params);
        }

        if ($options['task'] == 'edit-item') {
            $item = self::find($params['item']->id);
            $item->update($params);

            return $item;
        }
    }

    public function deleteItem($params = null, $options = null)
    {
        if ($options['task'] == 'delete-item') {
            $item = $params['item'];
            $item->delete();
        }
    }

    public function uploadImage($requestKey = 'image')
    {
        $this->addMediaFromRequest($requestKey)->toMediaCollection($this->getTable());
    }
}

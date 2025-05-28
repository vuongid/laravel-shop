<?php

namespace App\Models;

use App\Enums\GeneralStatus;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Slider extends Model implements HasMedia
{
    use InteractsWithMedia;
    protected $table = 'sliders';
    protected $fillable = ['title', 'url', 'status'];
    protected $fieldSearchAccepted = ['title', 'id'];
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
        $result = null;

        if ($options['task'] == 'list-items') {
            $query = self::select('id', 'title', 'url', 'status', 'created_at', 'updated_at');

            if (!empty($params['search']['value'])) {
                if ($params['search']['field'] == 'all') {
                    $query->where(function ($query) use ($params) {
                        foreach ($this->fieldSearchAccepted as $column) {
                            $query->orWhere($column, 'LIKE', "%{$params['search']['value']}%");
                        }
                    });
                } elseif (in_array($params['search']['field'], $this->fieldSearchAccepted)) {
                    $query->where($params['search']['field'], 'LIKE', "%{$params['search']['value']}%");
                }
            }

            // $query->active();
            // $query->myActive();

            $result = $query->orderBy('id', 'desc')->paginate($params['pagination']['totalItemsPerPage']);
        }

        return $result;
    }

    public function saveItem($params = null, $options = null)
    {
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
            $item = self::find($params['item']->id);
            $item->delete();
        }
    }
}

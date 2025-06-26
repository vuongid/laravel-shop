<?php

namespace App\Models;

use App\Enums\GeneralStatus;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
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
            $query = self::select('id', 'title', 'url', 'status', 'created_at', 'updated_at');

            if (!empty($params['title'])) {
                $query->where('title', 'LIKE', "%{$params['title']}%");
            }
            if (!empty($params['url'])) {
                $query->where('url', 'LIKE', "%{$params['url']}%");
            }
            if (!empty($params['datefilter'])) {
                $dates = explode(' - ', $params['datefilter']);
                $startDate = \Carbon\Carbon::createFromFormat('m/d/Y', trim($dates[0]))->startOfDay();
                $endDate = \Carbon\Carbon::createFromFormat('m/d/Y', trim($dates[1]))->endOfDay();
                $query->whereBetween('created_at', [$startDate, $endDate]);
            }
            if (!empty($params['status']) && ($params['status'] == GeneralStatus::ACTIVE->value || $params['status'] == GeneralStatus::INACTIVE->value)) {
                $query->where('status', "{$params['status']}");
            }

            // $query->active();
            // $query->myActive();

            $result = $query->orderBy('id', 'desc')->paginate($params['pagination']['totalItemsPerPage']);
        }

        return $result;
    }

    public function saveItem($params = null, $options = null)
    {
        if ($options['task'] == 'change-status') {
            self::where('id', $params['id'])->update(['status' => $params['status']]);
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

    public function uploadImage($file)
    {
        $ext = $file->getClientOriginalExtension();
        $randomName = Str::random(10) . '.' . $ext;

        $this->addMedia($file)
            ->usingFileName($randomName)
            ->toMediaCollection($this->getTable());
    }
}

<?php

namespace App\Models;

use App\Enums\GeneralStatus;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Tag extends Model
{
    protected $table = 'tags';
    protected $fillable = ['name', 'slug'];
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
        if ($options['task'] == 'list-items') {
            $query = self::select('id', 'name', 'slug', 'status', 'created_at', 'updated_at');

            if (!empty($params['name'])) {
                $query->where('name', 'LIKE', "%{$params['name']}%");
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
            if (!empty($params['status']) && ($params['status'] == GeneralStatus::ACTIVE->value || $params['status'] == GeneralStatus::INACTIVE->value)) {
                $query->where('status', "{$params['status']}");
            }

            return $query->orderBy('id', 'desc')->paginate($params['pagination']['totalItemsPerPage']);
        }

        if ($options['task'] == 'list-items-article-category') {
            return ArticleCategory::pluck('name', 'id')->toArray();
        }
    }

    public function saveItem($params = null, $options = null)
    {
        if ($options['task'] == 'change-status') {

            $status = ($params['currentStatus'] == GeneralStatus::ACTIVE->value) ? GeneralStatus::INACTIVE->value : GeneralStatus::ACTIVE->value;
            self::where('id', $params['id'])->update(['status' => $status]);
        }
        if ($options['task'] == 'create-item') {
            if (empty($params['slug'])) {
                $params['slug'] = $this->generateUniqueSlug($params['name']);
            }
            return self::create($params);
        }

        if ($options['task'] == 'edit-item') {
            if (empty($params['slug'])) {
                $params['slug'] = $this->generateUniqueSlug($params['name']);
            }
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

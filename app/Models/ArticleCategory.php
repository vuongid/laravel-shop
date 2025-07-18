<?php

namespace App\Models;

use App\Enums\GeneralStatus;
use Illuminate\Database\Eloquent\Model;
use Kalnoy\Nestedset\NodeTrait;
use Illuminate\Support\Str;

class ArticleCategory extends Model
{
    use NodeTrait;

    protected $table = 'article_categories';
    protected $fillable = ['name', 'status', 'slug'];
    protected $fieldSearchAccepted = ['name', 'id'];
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
            $query = self::withDepth()->having('depth', '>', 0)->defaultOrder();

            if (!empty($params['name'])) {
                $query->where('name', 'LIKE', "%{$params['name']}%");
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

            $result = $query->get()->toTree();
        }

        if ($options['task'] == 'list-categories') {
            $result = self::withDepth()->defaultOrder()->get()->toFlatTree()->pluck('name_with_depth', 'id');
        }

        if ($options['task'] == 'list-categories-edit') {
            $result = self::withDepth()->defaultOrder()
                ->where('_lft', '<', $params['item']->_lft)
                ->orWhere('_rgt', '>', $params['item']->_rgt)
                ->get()->toFlatTree()->pluck('name_with_depth', 'id');
        }

        return $result;
    }

    public function saveItem($params = null, $options = null)
    {
        if ($options['task'] == 'change-status') {
            self::where('id', $params['id'])->update(['status' => $params['status']]);
        }
        if ($options['task'] == 'create-item') {
            if (empty($params['slug'])) {
                $params['slug'] = $this->generateUniqueSlug($params['name']);
            }
            $parent = self::find($params['parent_id']);

            return $item = self::create($params, $parent);
        }

        if ($options['task'] == 'edit-item') {
            $item = $currentNode = self::find($params['item']->id);
            if (empty($params['slug'])) {
                $params['slug'] = $this->generateUniqueSlug($params['name'], $item->id);
            }
            $item->update($params);

            $parent = self::find($params['parent_id']);
            if ($currentNode->parent_id != $params['parent_id']) $item->appendToNode($parent)->save();

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

    public function getNameWithDepthAttribute()
    {
        return str_repeat('/----- ', $this->depth) . $this->name;
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

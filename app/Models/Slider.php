<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Slider extends Model
{
    protected $table = 'sliders';
    protected $fillable = ['title', 'url', 'status'];

    public function listItems($params = null, $options = null)
    {
        $result = null;

        if ($options['task'] == 'list-items') {
            $query = self::select('id', 'title', 'url', 'status', 'created_at', 'updated_at');

            $result = $query->orderBy('id', 'desc')->paginate($params['pagination']['totalItemsPerPage']);
        }

        return $result;
    }

    public function saveItem($params = null, $options = null)
    {
        if ($options['task'] == 'create-item') {
            self::create($params);
        }

        if ($options['task'] == 'edit-item') {
            $item = self::find($params['item']->id);
            $item->update($params);
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

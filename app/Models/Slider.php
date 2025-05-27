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

    public function save($params = null, $options = null) {}
}

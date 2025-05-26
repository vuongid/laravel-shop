<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Slider;
use Illuminate\Http\Request;

class SliderController extends Controller
{
    public $params = [];
    public $viewAction = '';
    private $model;

    public function __construct(Request $request)
    {
        $this->model = new Slider();
        $routeAs = $request->route()->getAction()['as'];
        $routeArr = explode('.', $routeAs);
        $module = $routeArr[0];
        $controller = $routeArr[1];
        $action = $routeArr[2];
        $this->params = $request->all();
        $this->viewAction =  $module . '.pages.' . $controller . '.' . $action;
        $this->params['pagination']['totalItemsPerPage'] = 5;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $items = $this->model->listItems($this->params, ['task' => 'admin-list-items']);
        $this->params['items'] = $items;

        return view($this->viewAction, [
            'params' => $this->params,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view($this->viewAction, [
            'params' => $this->params,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Slider $slider)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Slider $slider)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Slider $slider)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Slider $slider)
    {
        //
    }
}

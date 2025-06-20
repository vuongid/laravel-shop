<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreTagRequest;
use App\Http\Requests\UpdateTagRequest;
use App\Models\Tag;
use Illuminate\Http\Request;

class TagController extends Controller
{
    public $params = [];
    public $viewAction = '';
    private $model;

    public function __construct(Request $request)
    {
        $this->model = new Tag();
        $routeAs = $request->route()->getAction()['as'];
        $routeArr = explode('.', $routeAs);
        $module = $routeArr[0];
        $controller = $routeArr[1];
        $action = $routeArr[2];
        $this->params = $request->all();
        $this->params['module'] = $module;
        $this->params['controller'] = $controller;
        $this->params['action'] = $action;
        $this->params['routeBase'] = "$module.$controller.";
        $this->viewAction =  "$module.pages.$controller.$action";
        $this->params['pagination']['totalItemsPerPage'] = 5;
        $this->params['table'] = 'tags';
        $this->params['langPath'] = 'modules/tag.';
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $items = $this->model->listItems($this->params, ['task' => 'list-items']);
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
        $this->params['articleCategories'] = $this->model->listItems($this->params, ['task' => 'list-items-article-category']);

        return view($this->viewAction, [
            'params' => $this->params,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTagRequest $request)
    {
        $item = $this->model->saveItem($this->params, ['task' => 'create-item']);
        $item->uploadImage($request->file('image'));
        return redirect()->route($this->params['routeBase'] . 'index')->with('notify', 'Thêm dữ liệu thành công!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Tag $tag)
    {
        $this->params['item'] = $tag;

        return view($this->viewAction, [
            'params' => $this->params,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Tag $tag)
    {
        $this->params['item'] = $tag;
        $this->params['articleCategories'] = $this->model->listItems($this->params, ['task' => 'list-items-article-category']);

        return view($this->viewAction, [
            'params' => $this->params,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTagRequest $request, Tag $tag)
    {
        $item = $this->model->saveItem(['item' => $tag] + $this->params, ['task' => 'edit-item']);
        if ($request->has('image')) {
            $item->uploadImage($request->file('image'));
        }
        return redirect()->route($this->params['routeBase'] . 'index')->with('notify', 'Cập nhật dữ liệu thành công!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Tag $tag)
    {
        $this->model->deleteItem(['item' => $tag], ['task' => 'delete-item']);
        return redirect()->route($this->params['routeBase'] . 'index')->with('notify', 'Xóa dữ liệu thành công!');
    }

    public function status($status, $id)
    {
        $this->params['currentStatus'] = $status;
        $this->params['id'] = $id;
        $this->model->saveItem($this->params, ['task' => 'change-status']);

        return redirect()->route($this->params['routeBase'] . 'index')->with('notify', 'Cập nhật dữ liệu thành công!');
    }
}

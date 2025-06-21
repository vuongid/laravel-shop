<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreArticleTagRequest;
use App\Http\Requests\StoreTagRequest;
use App\Http\Requests\UpdateArticleTagRequest;
use App\Http\Requests\UpdateTagRequest;
use App\Models\ArticleTag;
use App\Models\Tag;
use Illuminate\Http\Request;

class ArticleTagController extends Controller
{
    public $params = [];
    public $viewAction = '';
    private $model;

    public function __construct(Request $request)
    {
        $this->model = new ArticleTag();
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
        $this->params['langPath'] = 'modules/articleTag.';
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

        return view($this->viewAction, [
            'params' => $this->params,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreArticleTagRequest $request)
    {
        $item = $this->model->saveItem($this->params, ['task' => 'create-item']);
        return redirect()->route($this->params['routeBase'] . 'index')->with('notify', 'Thêm dữ liệu thành công!');
    }

    /**
     * Display the specified resource.
     */
    public function show(ArticleTag $articleTag)
    {
        $this->params['item'] = $articleTag;

        return view($this->viewAction, [
            'params' => $this->params,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ArticleTag $articleTag)
    {
        $this->params['item'] = $articleTag;

        return view($this->viewAction, [
            'params' => $this->params,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateArticleTagRequest $request, ArticleTag $articleTag)
    {
        $this->model->saveItem(['item' => $articleTag] + $this->params, ['task' => 'edit-item']);

        return redirect()->route($this->params['routeBase'] . 'index')->with('notify', 'Cập nhật dữ liệu thành công!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ArticleTag $ArticleTag)
    {
        $this->model->deleteItem(['item' => $ArticleTag], ['task' => 'delete-item']);
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

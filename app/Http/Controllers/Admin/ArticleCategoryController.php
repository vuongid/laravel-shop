<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreArticleCategoryRequest;
use App\Http\Requests\UpdateArticleCategoryRequest;
use App\Models\ArticleCategory;
use Illuminate\Http\Request;

class ArticleCategoryController extends Controller
{
    public $params = [];
    public $viewAction = '';
    private $model;

    public function __construct(Request $request)
    {
        $this->model = new ArticleCategory();
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
        $this->params['langPath'] = 'modules/articleCategory.';
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
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
        $this->params['categories'] = $this->model->listItems($this->params, ['task' => 'list-categories']);
        return view($this->viewAction, [
            'params' => $this->params,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreArticleCategoryRequest $request)
    {
        $item = $this->model->saveItem($this->params, ['task' => 'create-item']);
        return redirect()->route($this->params['routeBase'] . 'index')->with('notify', 'Thêm dữ liệu thành công!');
    }

    /**
     * Display the specified resource.
     */
    public function show(ArticleCategory $articleCategory)
    {
        $this->params['item'] = $articleCategory;

        return view($this->viewAction, [
            'params' => $this->params,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ArticleCategory $articleCategory)
    {
        $this->params['item'] = $articleCategory;
        $this->params['categories'] = $this->model->listItems($this->params, ['task' => 'list-categories-edit']);

        return view($this->viewAction, [
            'params' => $this->params,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateArticleCategoryRequest $request, ArticleCategory $articleCategory)
    {
        $item = $this->model->saveItem(['item' => $articleCategory] + $this->params, ['task' => 'edit-item']);

        return redirect()->route($this->params['routeBase'] . 'index')->with('notify', 'Cập nhật dữ liệu thành công!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ArticleCategory $articleCategory)
    {
        $this->model->deleteItem(['item' => $articleCategory], ['task' => 'delete-item']);
        return redirect()->route($this->params['routeBase'] . 'index')->with('notify', 'Xóa dữ liệu thành công!');
    }

    public function status($status, $id)
    {
        $this->params['currentStatus'] = $status;
        $this->params['id'] = $id;
        $this->model->saveItem($this->params, ['task' => 'change-status']);

        return redirect()->route($this->params['routeBase'] . 'index')->with('notify', 'Cập nhật dữ liệu thành công!');
    }

    public function move(ArticleCategory $articleCategory, $type)
    {
        if ($type == 'up') {
            $articleCategory->up();
        } else {
            $articleCategory->down();
        }

        return redirect()->route($this->params['routeBase'] . 'index')->with('notify', 'Cập nhật dữ liệu thành công!');
    }

    public function updateTree(Request $request)
    {
        $data = $request->data;
        $root = ArticleCategory::find(1);
        ArticleCategory::rebuildSubtree($root, $data);
        return response()->json($data);
    }
}

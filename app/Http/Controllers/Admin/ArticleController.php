<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreArticleRequest;
use App\Http\Requests\UpdateArticleRequest;
use App\Http\Requests\UpdateSliderRequest;
use App\Models\Article;
use Illuminate\Http\Request;

class ArticleController extends Controller
{
    public $params = [];
    public $viewAction = '';
    private $model;

    public function __construct(Request $request)
    {
        $this->model = new Article();
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
        $this->params['table'] = 'articles';
        $this->params['langPath'] = 'modules/article.';
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
    public function store(StoreArticleRequest $request)
    {
        $item = $this->model->saveItem($this->params, ['task' => 'create-item']);
        $item->uploadImage($request->file('image'));
        return redirect()->route($this->params['routeBase'] . 'index')->with('notify', 'Thêm dữ liệu thành công!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Article $article)
    {
        $this->params['item'] = $article;

        return view($this->viewAction, [
            'params' => $this->params,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Article $article)
    {
        $this->params['item'] = $article;
        $this->params['articleCategories'] = $this->model->listItems($this->params, ['task' => 'list-items-article-category']);

        return view($this->viewAction, [
            'params' => $this->params,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateArticleRequest $request, Article $article)
    {
        $item = $this->model->saveItem(['item' => $article] + $this->params, ['task' => 'edit-item']);
        if ($request->has('image')) {
            $item->uploadImage($request->file('image'));
        }
        return redirect()->route($this->params['routeBase'] . 'index')->with('notify', 'Cập nhật dữ liệu thành công!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Article $article)
    {
        $this->model->deleteItem(['item' => $article], ['task' => 'delete-item']);
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

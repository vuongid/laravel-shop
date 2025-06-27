<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreArticleCategoryRequest;
use App\Http\Requests\UpdateArticleCategoryRequest;
use App\Models\ArticleCategory;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public $params = [];
    public $viewAction = '';
    private $model;

    public function __construct(Request $request)
    {
        $this->model = new ArticleCategory();
        $routeAs = $request->route()->getAction()['as'];
        $routeArr = explode('.', $routeAs);
        $module = 'admin';
        $controller = $routeArr[0];
        $action = $routeArr[1];
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
    public function register()
    {
        return view($this->viewAction, [
            'params' => $this->params,
        ]);
    }
}

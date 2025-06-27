<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\StoreUserRequest;
use App\Models\ArticleCategory;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
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
        $this->params['routeBase'] = "$controller.";
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

    public function postRegister(StoreUserRequest $request)
    {
        User::create($request->all());
        return redirect()->route($this->params['routeBase'] . 'register')->with('notify', 'Thêm dữ liệu thành công!');
    }

    public function login()
    {
        return view($this->viewAction, [
            'params' => $this->params,
        ]);
    }

    public function postLogin(LoginRequest $request)
    {
        $credentials = $request->validated();

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            return redirect()->route('admin.slider.index');
        }

        return back()->with('notify', 'Đăng nhập thất bại');
    }
}

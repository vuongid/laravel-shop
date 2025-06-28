<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ChangePasswordRequest;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\ProfileRequest;
use App\Http\Requests\StoreUserRequest;
use App\Models\ArticleCategory;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

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

    public function profile()
    {
        $this->params['user'] = Auth::user();

        return view('admin.pages.auth.profile', [
            'params' => $this->params,
        ]);
    }

    public function postProfile(ProfileRequest $request)
    {
        $user = Auth::user();

        $user->update($request->validated());
        if ($request->hasFile('avatar')) {
            $user->uploadImage($request->file('avatar')); // ← gọi hàm bạn tạo
        }

        return back()->with('notify', 'Cập nhật thành công');
    }

    public function changePassword()
    {
        return view('admin.pages.auth.changePassword', [
            'params' => $this->params,
        ]);
    }

    public function postChangePassword(ChangePasswordRequest $request)
    {
        $user = Auth::user();

        if (!Hash::check($request->current_password, $user->password)) {
            return back()->with('notify', 'Mật khẩu hiện tại không đúng');
        }

        $user->password = Hash::make($request->password);
        $user->save();

        return back()->with('notify', 'Đổi mật khẩu thành công');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('auth.login');
    }
}

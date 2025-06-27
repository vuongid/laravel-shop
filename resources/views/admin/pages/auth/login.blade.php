@php
    $routeBase = $params['routeBase'];
@endphp

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <title>
        Admin -
        {{ __('admin.controller.' . $params['controller']) }} -
        {{ __('admin.action.' . $params['action']) }}
    </title>
    <link href="{{ asset('admin/css/tabler.min.css') }}" rel="stylesheet" />
    <link href="https://unpkg.com/filepond@^4/dist/filepond.css" rel="stylesheet" />
    <link href="https://unpkg.com/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.css"
        rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/tom-select@2.4.3/dist/css/tom-select.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
    <link href="{{ asset('admin/css/jquery.nestable.min.css') }}" rel="stylesheet" />
    <script src="{{ asset('admin/js/tinymce/tinymce.min.js') }}"></script>
    <style>
        @import url("https://rsms.me/inter/inter.css");
    </style>
    <link href="{{ asset('admin/css/my-css.css') }}" rel="stylesheet">
</head>

<body>
    @include('admin.partials.notify')
    <div class="page page-center">
        <div class="container container-tight py-4">
            <form class="card card-md" action="{{ route($routeBase . 'postRegister') }}" method="POST"
                autocomplete="off" novalidate="">
                @csrf
                <div class="card-body">
                    <h2 class="card-title text-center mb-4">Login</h2>
                    <x-input label="Email" type="text" name="email" />
                    <div class="mb-3">
                        <label class="form-label">Password</label>
                        <div class="input-group input-group-flat">
                            <input type="password" class="form-control" autocomplete="off" name="password">
                            <span class="input-group-text">
                                <a href="#" class="link-secondary" data-bs-toggle="tooltip"
                                    aria-label="Show password"
                                    data-bs-original-title="Show password"><!-- Download SVG icon from http://tabler.io/icons/icon/eye -->
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round" class="icon icon-1">
                                        <path d="M10 12a2 2 0 1 0 4 0a2 2 0 0 0 -4 0"></path>
                                        <path
                                            d="M21 12c-2.4 4 -5.4 6 -9 6c-3.6 0 -6.6 -2 -9 -6c2.4 -4 5.4 -6 9 -6c3.6 0 6.6 2 9 6">
                                        </path>
                                    </svg></a>
                            </span>
                        </div>
                    </div>
                    <div class="form-footer">
                        <button type="submit" class="btn btn-primary w-100">Login</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</body>

</html>

<meta charset="utf-8" />

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

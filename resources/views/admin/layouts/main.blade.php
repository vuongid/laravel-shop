<!doctype html>
<!--
* Tabler - Premium and Open Source dashboard template with responsive and high quality UI.
* @version 1.3.0
* @link https://tabler.io
* Copyright 2018-2025 The Tabler Authors
* Copyright 2018-2025 codecalm.net Paweł Kuna
* Licensed under MIT (https://github.com/tabler/tabler/blob/master/LICENSE)
-->
<html lang="en">

@include('admin.layouts.head')
@stack('style')

<body class="layout-fluid">
    <div class="page">
        @include('admin.layouts.sidebar')
        <div class="page-wrapper">
            @include('admin.layouts.header')
            <div class="page-body">
                @yield('content')
            </div>
        </div>
    </div>

    @include('admin.layouts.script')
    @stack('script')
</body>

</html>

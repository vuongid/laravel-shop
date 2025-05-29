@php
    use App\Helpers\Template;
    use App\Helpers\Form;

    $item = $params['item'];

    $statusValue = [
        '1' => config('shop.template.status.1.name'),
        '2' => config('shop.template.status.2.name'),
    ];

    $elements = [
        Form::input('text', 'title', 'Tên', ['value' => $item['title']]),
        Form::input('text', 'url', 'Url', ['value' => $item['url']]),
        Form::select('status', $statusValue, $item['status'], 'Trạng thái'),
        Form::input('file', 'image', 'Upload'),
    ];
@endphp
@extends('admin.layouts.main')
@section('content')
    <div class="page-header d-print-none mt-0 mb-4" aria-label="Page header">
        <div class="container-xl">
            <div class="row g-2 align-items-center">
                <div class="col">
                    <!-- Page pre-title -->
                    <h2 class="page-title">Sửa Slider</h2>
                </div>
                <!-- Page title actions -->
                <div class="col-auto ms-auto d-print-none">
                    <div class="btn-list">
                        <a href="{{ route('admin.slider.index') }}" class="btn btn-primary">Quay về</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('admin.partials.error')
    <div class="container-xl">
        <div class="row row-cards">
            <div class="col-md-6">
                <form method="POST" action="{{ route('admin.slider.update', $item) }}" class="card"
                    enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="card-header">
                        <h4 class="card-title">Form</h4>
                    </div>
                    <div class="card-body">
                        {!! Form::show($elements) !!}
                    </div>
                    <div class="card-footer text-end">
                        <button type="submit" class="btn btn-primary ms-auto">Cập nhật</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

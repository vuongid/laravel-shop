@php
    use App\Helpers\Template;
    use App\Helpers\Form;
    use App\Enums\GeneralStatus;

    $item = $params['item'];
    $routeBase = $params['routeBase'];

    $statuses = GeneralStatus::toArray();

    $elements = [
        Form::input('text', 'title', __('modules/slider.fields.title'), ['value' => $item->title]),
        Form::input('text', 'url', __('modules/slider.fields.url'), ['value' => $item->url]),
        Form::select('status', $statuses, $item->status->value, __('modules/slider.fields.status')),
        Form::input('file', 'image', __('modules/slider.fields.image')),
    ];
@endphp
@extends('admin.layouts.main')
@section('content')
    <div class="page-header d-print-none mt-0 mb-4" aria-label="Page header">
        <div class="container-xl">
            <div class="row g-2 align-items-center">
                <div class="col">
                    <!-- Page pre-title -->
                    <h2 class="page-title">{{ __('modules/slider.actions.edit', ['name' => $item->title]) }}</h2>
                </div>
                <!-- Page title actions -->
                <div class="col-auto ms-auto d-print-none">
                    <div class="btn-list">
                        <a href="{{ route($routeBase . 'index') }}"
                            class="btn btn-primary">{{ __('modules/slider.button.back') }}</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('admin.partials.error')
    <div class="container-xl">
        <div class="row row-cards">
            <div class="col-md-6">
                <form method="POST" action="{{ route($routeBase . 'update', $item) }}" class="card"
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
                        <button type="submit"
                            class="btn btn-primary ms-auto">{{ __('modules/slider.button.update') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

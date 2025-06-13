@php
    use App\Helpers\Template;
    use App\Helpers\Form;
    use App\Enums\GeneralStatus;

    $routeBase = $params['routeBase'];
    $categories = $params['categories'];
    $statuses = GeneralStatus::toArray();

@endphp
@extends('admin.layouts.main')
@section('content')
    <x-page-header title="{{ __('modules/slider.actions.create') }}">
        <a href="{{ route($routeBase . 'index') }}" class="btn btn-primary">{{ __('modules/slider.button.back') }}</a>
    </x-page-header>
    @include('admin.partials.error')
    <div class="container-xl">
        <div class="row row-cards">
            <div class="col-md-6">
                <form method="POST" action="{{ route($routeBase . 'store') }}" class="card" enctype="multipart/form-data">
                    @csrf
                    <div class="card-header">
                        <h4 class="card-title">Form</h4>
                    </div>
                    <div class="card-body">
                        <x-input label="{{ __('modules/slider.fields.title') }}" name="name" type="text" />
                        <x-input label="slug" name="slug" type="text" />
                        <x-select label="{{ __('modules/slider.fields.status') }}" :options="$statuses" name="status" />
                        <x-select label="{{ __('modules/slider.fields.status') }}" :options="$categories" name="parent_id" />
                    </div>
                    <div class="card-footer text-end">
                        <button type="submit"
                            class="btn btn-primary ms-auto">{{ __('modules/slider.button.add') }}</button>
                    </div>
                </form>
            </div>
        </div>


    </div>
@endsection


@push('script')
    <style>
        .filepond--item {
            width: calc(150px - 0.5em);
        }
    </style>

    <script>
        FilePond.registerPlugin(FilePondPluginImagePreview);
        // Get a reference to the file input element
        const inputElement = document.querySelector('.filepond-image');

        // Create a FilePond instance
        const pond = FilePond.create(inputElement, {
            // Only accept images
            acceptedFileTypes: ['image/*'],
            allowReorder: true,
            storeAsFile: true
        });
    </script>
@endpush

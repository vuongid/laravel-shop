@php
    use App\Helpers\Template;
    use App\Helpers\Form;
    use App\Enums\GeneralStatus;

    $item = $params['item'];
    $routeBase = $params['routeBase'];
    $statuses = GeneralStatus::toArray();

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
                        <x-input label="{{ __('modules/slider.fields.title') }}" name="title" type="text"
                            value="{{ $item->title }}" />
                        <x-input label="{{ __('modules/slider.fields.url') }}" name="url" type="text"
                            value="{{ $item->url }}" />
                        <x-select label="{{ __('modules/slider.fields.status') }}" :options="$statuses" name="status"
                            value="{{ $item->status->value }}" />
                        <x-input type="file" class="filepond-image" name="image" data-url="s"
                            data-image="{{ $item->getFirstMediaUrl('sliders') }}" />
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
        const imageCurrent = inputElement.dataset.image;
        // Create a FilePond instance
        const pond = FilePond.create(inputElement, {
            // Only accept images
            acceptedFileTypes: ['image/*'],
            allowReorder: true,
            storeAsFile: true,
            files: [{
                source: imageCurrent,
            }]
        });
    </script>
@endpush

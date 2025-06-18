@php
    use App\Helpers\Template;
    use App\Helpers\Form;
    use App\Enums\GeneralStatus;

    $routeBase = $params['routeBase'];
    $statuses = GeneralStatus::toArray();

@endphp
@extends('admin.layouts.main')
@section('content')
    <x-page-header title="{{ __('modules/slider.actions.create') }}">
        <a href="{{ route($routeBase . 'index') }}" class="btn btn-primary">{{ __('modules/slider.button.back') }}</a>
    </x-page-header>
    <div class="container-xl">
        <div class="row row-cards">
            <div class="col-md-12">
                <form method="POST" action="{{ route($routeBase . 'store') }}" class="card" enctype="multipart/form-data">
                    @csrf
                    <div class="card-header">
                        <h4 class="card-title">Form</h4>
                    </div>
                    <div class="card-body">
                        <x-input label="{{ __('modules/slider.fields.title') }}" name="title" type="text" />
                        <x-input label="description" name="description" type="text" />
                        <x-input label="{{ __('modules/slider.fields.url') }}" name="url" type="text" />
                        <x-input label="slug" name="slug" type="text" />
                        <x-select label="{{ __('modules/slider.fields.status') }}" :options="$statuses" name="status" />
                        <x-input type="file" class="filepond-image" name="image" />
                        <textarea id="tinymce" name="content"></textarea>
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

@push('style')
    <style>
        .filepond--item {
            width: calc(150px - 0.5em);
        }
    </style>
@endpush

@push('script')
    <script>
        var editor_config = {
            path_absolute: "/",
            selector: "textarea#tinymce",
            plugins: "link image media table code",
            toolbar: "undo redo | styleselect | bold italic | alignleft aligncenter alignright | bullist numlist | link image media | code",
            relative_urls: false,
            file_picker_callback: function(callback, value, meta) {
                var x = window.innerWidth || document.documentElement.clientWidth || document.body.clientWidth;
                var y = window.innerHeight || document.documentElement.clientHeight || document.body.clientHeight;

                var cmsURL = editor_config.path_absolute + 'laravel-filemanager?editor=' + meta.fieldname;
                if (meta.filetype == 'image') {
                    cmsURL = cmsURL + "&type=Images";
                } else {
                    cmsURL = cmsURL + "&type=Files";
                }

                tinyMCE.activeEditor.windowManager.openUrl({
                    url: cmsURL,
                    title: 'Quản lý tập tin',
                    width: x * 0.8,
                    height: y * 0.8,
                    resizable: "yes",
                    close_previous: "no",
                    onMessage: (api, message) => {
                        callback(message.content);
                    }
                });
            }
        };

        tinymce.init(editor_config);
    </script>

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

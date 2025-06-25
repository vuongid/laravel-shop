@php
    use App\Helpers\Template;
    use App\Helpers\Form;
    use App\Enums\GeneralStatus;

    $item = $params['item'];
    $routeBase = $params['routeBase'];
    $statuses = GeneralStatus::toArray();
    $langPath = $params['langPath'];
    $articles = $params['articles'];
    $tags = $params['tags'];

@endphp
@extends('admin.layouts.main')
@section('content')
    <div class="page-header d-print-none mt-0 mb-4" aria-label="Page header">
        <div class="container-xl">
            <div class="row g-2 align-items-center">
                <div class="col">
                    <!-- Page pre-title -->
                    <h2 class="page-title">{{ __($langPath . 'actions.edit', ['name' => $item->title]) }}</h2>
                </div>
                <!-- Page title actions -->
                <div class="col-auto ms-auto d-print-none">
                    <div class="btn-list">
                        <a href="{{ route($routeBase . 'index') }}"
                            class="btn btn-primary">{{ __($langPath . 'button.back') }}</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container-xl">
        <div class="row row-cards">
            <div class="col-md-12">
                <form method="POST" action="{{ route($routeBase . 'update', $item) }}" class="card"
                    enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="card-header">
                        <h4 class="card-title">Form</h4>
                    </div>
                    <div class="card-body">
                        <x-select label="{{ __($langPath . 'table.article') }}" :options="$articles" name="article_id"
                            value="{{ $item->article_id }}" />
                        <x-select label="{{ __($langPath . 'table.tag') }}" :options="$tags" name="tag_id"
                            value="{{ $item->tag_id }}" />
                        <x-select label="{{ __($langPath . 'fields.status') }}" :options="$statuses" name="status"
                            value="{{ $item->status->value }}" />
                    </div>
                    <div class="card-footer text-end">
                        <button type="submit"
                            class="btn btn-primary ms-auto">{{ __($langPath . 'button.update') }}</button>
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

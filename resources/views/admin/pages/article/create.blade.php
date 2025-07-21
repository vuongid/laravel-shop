@php
    use App\Helpers\Template;
    use App\Helpers\Form;
    use App\Enums\GeneralStatus;

    $routeBase = $params['routeBase'];
    $statuses = GeneralStatus::toArray();
    $articleCategories = $params['articleCategories'];
    $tags = $params['tags'];
    $langPath = $params['langPath'];

@endphp
@extends('admin.layouts.main')
@section('content')
    <x-page-header title="{{ __($langPath . 'actions.create') }}">
        <a id="btnAdd" class="btn btn-primary">{{ __($langPath . 'button.add') }}</a>
        <a href="{{ route($routeBase . 'index') }}" class="btn btn-primary">{{ __($langPath . 'button.back') }}</a>
    </x-page-header>
    <div class="container-xl">
        <div class="row row-cards">
            <div class="col-12">
                <form id="formMain" method="POST" action="{{ route($routeBase . 'store') }}" class="card"
                    enctype="multipart/form-data">
                    @csrf
                    <div class="card-body">
                        <div class="row g-5">
                            <div class="col-md-9">
                                <x-input label="{{ __($langPath . 'fields.title') }}" name="title" id="title"
                                    type="text" />
                                <x-input label="{{ __($langPath . 'fields.slug') }}" name="slug" id="slug"
                                    type="text" />
                                <x-input label="{{ __($langPath . 'fields.description') }}" name="description"
                                    type="text" />
                                <textarea id="tinymce" class="tinymce" name="content"></textarea>
                            </div>
                            <div class="col-md-3">
                                <x-select label="{{ __($langPath . 'fields.status') }}" :options="$statuses" name="status" />
                                <x-select label="Danh mục bài viết" :options="$articleCategories" name="category_id" />
                                <x-select label="Thẻ" id="tag-select" name="tags[]" :options="$tags" multiple />
                                <x-input label="{{ __($langPath . 'fields.image') }}" type="file" class="filepond-image"
                                    name="image" />
                            </div>
                        </div>
                    </div>
                    <div class="card-footer text-end">
                        <button type="submit" class="btn btn-primary ms-auto">{{ __($langPath . 'button.add') }}</button>
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


    <script>
        document.addEventListener('DOMContentLoaded', function() {
            new TomSelect('#tag-select', {
                plugins: ['remove_button'],
                persist: false,
                create: false // hoặc true nếu muốn thêm tag mới
            });
        });
    </script>
@endpush


@push('script')
    <script>
        const titleInput = document.getElementById('title');
        const slugInput = document.getElementById('slug');

        console.log(titleInput);
        titleInput.addEventListener('blur', function() {
            console.log(1);
            const title = titleInput.value.trim();

            if (title === '') return;

            axios.get('/admin/slug/generate', {
                    params: {
                        title: title
                    }
                })
                .then(function(response) {
                    slugInput.value = response.data.slug;
                })
                .catch(function(error) {
                    console.error('Lỗi tạo slug:', error);
                });
        });

        FilePond.registerPlugin(FilePondPluginImagePreview);
        // Get a reference to the file input element
        const inputElement = document.querySelector(".filepond-image");
        // Create a FilePond instance
        const pond = FilePond.create(inputElement, {
            // Only accept images
            acceptedFileTypes: ["image/*"],
            allowReorder: true,
            storeAsFile: true,
        });

        const btnAdd = document.getElementById('btnAdd');
        const elmForm = document.getElementById('formMain');

        btnAdd.addEventListener('click', function(e) {
            e.preventDefault();
            elmForm.submit();
        })
    </script>
@endpush

@php
    use App\Helpers\Template;
    use App\Helpers\Form;
    use App\Enums\GeneralStatus;

    $item = $params['item'];
    $routeBase = $params['routeBase'];
    $statuses = GeneralStatus::toArray();
    $tags = $params['tags'];
    $currentTags = $params['currentTags'];
    $articleCategories = $params['articleCategories'];
    $langPath = $params['langPath'];
    // dd($tags, $currentTags);
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
                        {{-- <button type="submit" class="btn btn-primary ms-auto">{{ __($langPath . 'button.update') }}</button> --}}
                        <a id="btnUpdate" href="{{ route($routeBase . 'index') }}"
                            class="btn btn-primary">{{ __($langPath . 'button.update') }}</a>
                        <a href="{{ route($routeBase . 'index') }}"
                            class="btn btn-primary">{{ __($langPath . 'button.back') }}</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container-xl">
        <div class="row row-cards">
            <div class="col-12">
                <form id="formMain" method="POST" action="{{ route($routeBase . 'update', $item) }}" class="card"
                    enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="card-body">
                        <div class="row g-5">
                            <div class="col-md-9">
                                <x-input label="{{ __($langPath . 'fields.title') }}" name="title" id="title"
                                    type="text" value="{{ $item->title }}" />
                                <x-input label="{{ __($langPath . 'fields.slug') }}" name="slug" id="slug"
                                    type="text" value="{{ $item->slug }}" />
                                <x-input label="{{ __($langPath . 'fields.description') }}" name="description"
                                    type="text" value="{{ $item->description }}" />
                                <textarea id="tinymce" class="tinymce" name="content">{{ $item->content }}</textarea>
                            </div>
                            <div class="col-md-3">
                                <x-select label="{{ __($langPath . 'fields.status') }}" :options="$statuses" name="status"
                                    value="{{ $item->status->value }}" />
                                <x-select label="Danh mục bài viết" :options="$articleCategories" name="category_id"
                                    value="{{ $item->category_id }}" />
                                <x-select label="Thẻ" id="tag-select" name="tags[]" :options="$tags" :value="$currentTags"
                                    multiple />
                                <x-input label="{{ __($langPath . 'fields.image') }}" type="file" class="filepond-image"
                                    name="image" data-url="s" data-image="{{ $item->getFirstMediaUrl('articles') }}" />
                            </div>
                        </div>
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

@push('script')
    <script>
        new TomSelect('#tag-select', {
            plugins: ['remove_button'],
            persist: false,
            create: false
        });

        const titleInput = document.getElementById('title');
        const slugInput = document.getElementById('slug');

        titleInput.addEventListener('blur', function() {
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

        const btnUpdate = document.getElementById('btnUpdate');
        const elmForm = document.getElementById('formMain');

        btnUpdate.addEventListener('click', function(e) {
            e.preventDefault();
            elmForm.submit();
        })

        FilePond.registerPlugin(FilePondPluginImagePreview);
        // Get a reference to the file input element
        const inputElement = document.querySelector(".filepond-image");
        // console.log(inputElement);
        const imageCurrent = inputElement.dataset.image;
        // Create a FilePond instance
        const pond = FilePond.create(inputElement, {
            // Only accept images
            acceptedFileTypes: ["image/*"],
            allowReorder: true,
            storeAsFile: true,
            files: [{
                source: imageCurrent,
            }, ],
        });
    </script>
@endpush

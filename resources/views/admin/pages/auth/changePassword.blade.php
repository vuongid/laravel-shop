@php
    use App\Helpers\Template;
    use App\Helpers\Form;
    use App\Enums\GeneralStatus;

    $routeBase = $params['routeBase'];

@endphp
@extends('admin.layouts.main')
@section('content')
    <x-page-header title="{{ __('modules/slider.actions.create') }}">
        <a href="" class="btn btn-primary">{{ __('modules/slider.button.back') }}</a>
    </x-page-header>
    <div class="container-xl">
        <div class="row row-cards">
            <div class="col-md-6">
                <form method="POST" action="{{ route('admin.auth.postProfile') }}" class="card"
                    enctype="multipart/form-data">
                    @csrf
                    <div class="card-body">
                        <x-input label="Mật khẩu hiện tại" type="text" name="current_password" />
                        <x-input label="Mật khẩu mới" type="text" name="password" />
                        <x-input label="Xác nhận mật khẩu mới" type="text" name="password_confirmation" />

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

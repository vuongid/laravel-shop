@php
    use App\Helpers\Template;
    use App\Helpers\Form;
    use App\Enums\GeneralStatus;

    $routeBase = $params['routeBase'];
    $user = $params['user'];
    $name = $user->name ?? '';
    $phone = $user->phone ?? '';
    $email = $user->email;

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
                        <x-input label="Email" type="text" value="{{ $email }}" disabled />
                        <x-input label="tên" name="name" type="text" value="{{ $name }}" />
                        <x-input label="phone" name="phone" type="text" value="{{ $phone }}" />
                        <x-input label="avatar" type="file" class="filepond-image" name="avatar"
                            data-image="{{ $user->getFirstMediaUrl('users') }}" />
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

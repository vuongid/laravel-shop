<div class="page-header d-print-none mt-0 mb-4" aria-label="Page header">
    <div class="container-xl">
        <div class="row g-2 align-items-center">
            <div class="col">
                <!-- Page pre-title -->
                <h2 class="page-title">{{ $title }}</h2>
            </div>
            <!-- Page title actions -->
            <div class="col-auto ms-auto d-print-none">
                <div class="btn-list">
                    {{-- <a href="#" class="btn btn-primary">{{ __('modules/slider.button.add_new') }}</a> --}}
                    {{ $slot }}
                </div>
            </div>
        </div>
    </div>
</div>

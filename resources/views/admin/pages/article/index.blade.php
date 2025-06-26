@php
    use App\Helpers\Form;
    use App\Enums\GeneralStatus;

    $items = $params['items'];
    $routeBase = $params['routeBase'];
    $langPath = $params['langPath'];
    $statuses = GeneralStatus::toArray(true);

    $keyword = $params['keyword'] ?? '';
    $status = $params['status'] ?? '';
    $dateFilter = $params['datefilter'] ?? '';
    $description = $params['description'] ?? '';

@endphp

@extends('admin.layouts.main')
@section('content')
    <x-page-header title="{{ __($langPath . 'title') }}">
        <a href="{{ route($routeBase . 'create') }}" class="btn btn-primary">{{ __($langPath . 'button.add_new') }}</a>
    </x-page-header>
    @include('admin.partials.notify')
    <div class="container-xl">
        <button class="btn btn-outline-secondary mb-3" type="button" data-bs-toggle="collapse" data-bs-target="#searchCollapse"
            aria-expanded="false" aria-controls="searchCollapse">
            {{ __($langPath . 'button.filters') }}
        </button>
        <div class="collapse" id="searchCollapse">
            <form action="{{ route($routeBase . 'index') }}">
                <div class="row mb-4">
                    <div class="col-lg-6">
                        <x-input label="{{ __('admin.filter.keyword') }}" type="text" value="{{ $keyword }}"
                            name="keyword" />
                    </div>
                    <div class="col-lg-6">
                        <x-input label="{{ __('admin.filter.createAt') }}" type="text" value="{{ $dateFilter }}"
                            name="datefilter" />
                    </div>
                    <div class="col-lg-6">
                        <x-select label="{{ __($langPath . 'fields.status') }}" name="status" :options="$statuses"
                            value="{{ $status }}" />
                    </div>
                    <div class="col-lg-12">
                        <input type="submit" class="btn btn-primary" value="{{ __($langPath . 'button.find') }}">
                        <a href="{{ route($routeBase . 'index') }}"
                            class="btn btn-primary">{{ __($langPath . 'button.rest') }}</a>
                    </div>
                </div>
            </form>
        </div>

        <div class="row row-cards mb-4">

            <div class="col-lg-12">
                <div class="card">
                    <div class="table-responsive">
                        <table class="table table-vcenter card-table">
                            <thead>
                                <tr>
                                    <th>{{ __($langPath . 'fields.image') }}</th>
                                    <th>{{ __($langPath . 'table.info') }}</th>
                                    <th>{{ __($langPath . 'fields.status') }}</th>
                                    <th>{{ __($langPath . 'action') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($items as $item)
                                    @php
                                        $checked = $item->status == GeneralStatus::ACTIVE ? 'checked' : '';
                                    @endphp
                                    <tr>
                                        <td width="10%">
                                            <img src="{{ $item->getFirstMediaUrl($params['table']) }}"
                                                alt="{{ $item->name }}">
                                        </td>
                                        <td class="text-secondary">
                                            <p>{{ __($langPath . 'fields.title') }} : {{ $item->title }}</p>
                                            <p>{{ __($langPath . 'fields.description') }} : {{ $item->description }}</p>
                                            <p>{{ __($langPath . 'fields.slug') }} : {{ $item->slug }}</p>
                                        </td>
                                        <td>
                                            <label class="form-check form-switch">
                                                <input class="form-check-input toggleStatus" type="checkbox"
                                                    data-id={{ $item->id }} {{ $checked }} />
                                            </label>
                                        </td>
                                        <td>
                                            <a href="{{ route($routeBase . 'show', $item) }}"
                                                class="btn btn-indigo">{{ __($langPath . 'button.detail') }}</a>
                                            <a href="{{ route($routeBase . 'edit', $item) }}"
                                                class="btn btn-info">{{ __($langPath . 'button.edit') }}</a>
                                            <form action="{{ route($routeBase . 'destroy', $item) }}" method="POST"
                                                class="d-inline-block">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                    class="btn btn-danger">{{ __($langPath . 'button.delete') }}</button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        {!! $items->appends(request()->input())->links('admin.partials.paginator') !!}
    </div>
@endsection

@push('script')
    <script>
        const cbsStatus = document.querySelectorAll('input.toggleStatus');

        cbsStatus.forEach(function(cb) {
            cb.addEventListener('change', function() {
                const id = this.dataset.id;
                const status = this.checked ? 1 : 2;

                axios.post(`/admin/article/${id}/toggleStatus`, {
                    status: status,
                }).then(function(res) {
                    console.log(res.data);
                })
            })
        });
    </script>
@endpush

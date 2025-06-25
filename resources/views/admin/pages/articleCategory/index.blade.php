@php
    use App\Helpers\Form;
    use App\Enums\GeneralStatus;

    $items = $params['items'];
    $routeBase = $params['routeBase'];
    $statuses = GeneralStatus::toArray(true);
    $langPath = $params['langPath'];

    $name = $params['name'] ?? '';
    $status = $params['status'] ?? '';
    $createdAt = $params['created_at'] ?? '';
    $updatedAt = $params['updated_at'] ?? '';

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
                        <x-input label="{{ __($langPath . 'fields.name') }}" type="text" value="{{ $name }}"
                            name="name" />
                    </div>
                    <div class="col-lg-6">
                        <x-select label="{{ __($langPath . 'fields.status') }}" name="status" :options="$statuses"
                            value="{{ $status }}" />
                    </div>
                    <div class="col-lg-6">
                        <x-input label="{{ __($langPath . 'table.startDate') }}" type="datetime-local"
                            value="{{ $createdAt }}" name="created_at" />
                    </div>
                    <div class="col-lg-6">
                        <x-input label="{{ __($langPath . 'table.endDate') }}" type="datetime-local"
                            value="{{ $createdAt }}" name="updated_at" />
                    </div>
                    <div class="col-lg-12">
                        <input type="submit" class="btn btn-primary" value="{{ __($langPath . 'button.find') }}">
                        <a href="{{ route($routeBase . 'index') }}" class="btn btn-primary">Rest</a>
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
                                    <th>{{ __($langPath . 'fields.name') }}</th>
                                    <th>order</th>
                                    <th>{{ __($langPath . 'fields.status') }}</th>
                                    <th>{{ __($langPath . 'action') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($items as $item)
                                    <tr>
                                        <td class="text-secondary">
                                            {{ str_repeat('/-----', $item->depth) . $item->name }}
                                        </td>
                                        <td>@include('admin.pages.articleCategory.partials.index.order')</td>
                                        <td>
                                            <a href="{{ route($routeBase . 'status', ['status' => $item->status, 'id' => $item->id]) }}"
                                                class="btn btn-round {{ $item->status->color() }}">{{ $item->status->label() }}
                                            </a>
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

            <div class="dd" id="nestable-category" data-url="{{ route($routeBase . 'updateTree') }}">
                <ol class="dd-list">
                    @foreach ($items as $item)
                        @include('admin.pages.articleCategory.partials.index.list_item', ['item' => $item])
                    @endforeach

                </ol>
            </div>
        </div>
    </div>
@endsection

@push('script')
    <script>
        $(document).ready(function() {
            let categoryTree = $('#nestable-category');
            categoryTree.nestable({}).on('change', function() {
                let dataSend = categoryTree.nestable('serialize');
                $.ajax({
                    type: "POST",
                    url: categoryTree.data('url'),
                    data: {
                        data: dataSend,
                        _token: $('meta[name="csrf-token"]').attr("content"),
                    },
                    dateType: "json",
                    success: function(response) {
                        console.log(response);
                    }
                })
            });

        });
    </script>
@endpush

@php
    use App\Helpers\Template;

    $items = $params['items'];
    $routeBase = $params['routeBase'];

    $xhtmlAreaSearch = Template::showAreaSearch('slider', $params['search']);
@endphp

@extends('admin.layouts.main')
@section('content')
    <div class="page-header d-print-none mt-0 mb-4" aria-label="Page header">
        <div class="container-xl">
            <div class="row g-2 align-items-center">
                <div class="col">
                    <!-- Page pre-title -->
                    <h2 class="page-title">{{ __('modules/slider.title') }}</h2>
                </div>
                <!-- Page title actions -->
                <div class="col-auto ms-auto d-print-none">
                    <div class="btn-list">
                        <a href="{{ route($routeBase . 'create') }}"
                            class="btn btn-primary">{{ __('modules/slider.button.add_new') }}</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('admin.partials.notify')
    <div class="container-xl">
        <div class="row mb-4">
            <div class="col-md-7"></div>
            <div class="col-md-5">{!! $xhtmlAreaSearch !!}</div>
        </div>
        <div class="row row-cards mb-4">
            <div class="col-lg-12">
                <div class="card">
                    <div class="table-responsive">
                        <table class="table table-vcenter card-table">
                            <thead>
                                <tr>
                                    <th>{{ __('modules/slider.fields.image') }}</th>
                                    <th>{{ __('modules/slider.fields.title') }}</th>
                                    <th>{{ __('modules/slider.fields.status') }}</th>
                                    <th>{{ __('modules/slider.fields.created_at') }}</th>
                                    <th>{{ __('modules/slider.fields.updated_at') }}</th>
                                    <th>{{ __('modules/slider.action') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($items as $item)
                                    @php
                                        $createdAt = date(
                                            config('shop.format.short_time'),
                                            strtotime($item->created_at),
                                        );
                                        $updateAt = date(
                                            config('shop.format.short_time'),
                                            strtotime($item->updated_at),
                                        );
                                    @endphp
                                    <tr>
                                        <td width="10%">
                                            <img src="{{ $item->getFirstMediaUrl('sliders') }}" alt="{{ $item->name }}">
                                        </td>
                                        <td class="text-secondary">{{ $item->title }}</td>
                                        <td>
                                            <a href="#"
                                                class="btn btn-round {{ $item->status->color() }}">{{ $item->status->label() }}
                                            </a>
                                        </td>
                                        <td class="text-secondary">{{ $createdAt }}</td>
                                        <td class="text-secondary">{{ $updateAt }}</td>
                                        <td>
                                            <a href="{{ route($routeBase . 'show', $item) }}"
                                                class="btn btn-indigo">{{ __('modules/slider.button.detail') }}</a>
                                            <a href="{{ route($routeBase . 'edit', $item) }}"
                                                class="btn btn-info">{{ __('modules/slider.button.edit') }}</a>
                                            <form action="{{ route($routeBase . 'destroy', $item) }}" method="POST"
                                                class="d-inline-block">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                    class="btn btn-danger">{{ __('modules/slider.button.delete') }}</button>
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

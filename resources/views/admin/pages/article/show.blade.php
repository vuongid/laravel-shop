@php
    use App\Helpers\Template;

    $item = $params['item'];
    $routeBase = $params['routeBase'];

    $createdAt = date(config('shop.format.short_time'), strtotime($item->created_at));
    $updateAt = date(config('shop.format.short_time'), strtotime($item->updated_at));
@endphp

@extends('admin.layouts.main')
@section('content')
    <div class="page-header d-print-none mt-0 mb-4" aria-label="Page header">
        <div class="container-xl">
            <div class="row g-2 align-items-center">
                <div class="col">
                    <!-- Page pre-title -->
                    <h2 class="page-title">{{ __('modules/slider.actions.show') }}</h2>
                </div>
                <!-- Page title actions -->
                <div class="col-auto ms-auto d-print-none">
                    <div class="btn-list">
                        <a href="{{ route($routeBase . 'index') }}"
                            class="btn btn-primary">{{ __('modules/slider.button.back') }}</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('admin.partials.notify')
    <div class="container-xl">
        <div class="row row-cards mb-4">
            <div class="col-lg-12">
                <div class="card">
                    <div class="table-responsive">
                        <table class="table table-vcenter card-table">
                            <tbody>
                                <tr>
                                    <th>{{ __('modules/slider.fields.id') }}</th>
                                    <td class="text-secondary">{{ $item->id }}</td>
                                </tr>
                                <tr>
                                    <th>{{ __('modules/slider.fields.image') }}</th>
                                    <td>
                                        <img src="{{ $item->getFirstMediaUrl('articles') }}" alt="{{ $item->name }}"
                                            style="max-width: 200px; max-height: 150px; object-fit: contain;">
                                    </td>
                                </tr>
                                <tr>
                                    <th>{{ __('modules/slider.fields.title') }}</th>
                                    <td class="text-secondary">{{ $item->title }}</td>
                                </tr>
                                <tr>
                                    <th>description</th>
                                    <td class="text-secondary">{{ $item->description }}</td>
                                </tr>
                                <tr>
                                    <th>slug</th>
                                    <td class="text-secondary">{{ $item->slug }}</td>
                                </tr>
                                <tr>
                                    <th>{{ __('modules/slider.fields.status') }}</th>
                                    <td>
                                        <a href="#" class="btn btn-round {{ $item->status->color() }}">
                                            {{ $item->status->label() }}
                                        </a>
                                    </td>
                                </tr>
                                <tr>
                                    <th>{{ __('modules/slider.fields.url') }}</th>
                                    <td class="text-secondary">{{ $item->url }}</td>
                                </tr>
                                <tr>
                                    <th>{{ __('modules/slider.fields.created_at') }}</th>
                                    <td class="text-secondary">{{ $createdAt }}</td>
                                </tr>
                                <tr>
                                    <th>{{ __('modules/slider.fields.updated_at') }}</th>
                                    <td class="text-secondary">{{ $updateAt }}</td>
                                </tr>
                                <tr>
                                    <th>{{ __('modules/slider.action') }}</th>
                                    <td>
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
                                <tr>
                                    <td>{!! $item->content !!}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

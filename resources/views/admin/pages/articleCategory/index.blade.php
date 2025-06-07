@php
    use App\Helpers\Form;
    use App\Enums\GeneralStatus;

    $items = $params['items'];
    $routeBase = $params['routeBase'];
    $statuses = GeneralStatus::toArray(true);

    $title = $params['title'] ?? '';
    $url = $params['url'] ?? '';
    $status = $params['status'] ?? '';
    $createdAt = $params['created_at'] ?? '';
    $updatedAt = $params['updated_at'] ?? '';

    $selectStatus = Form::select('status', $statuses, $status, __('modules/slider.fields.status'));

@endphp

@extends('admin.layouts.main')
@section('content')
    <x-page-header title="{{ __('modules/slider.title') }}">
        <a href="{{ route($routeBase . 'create') }}" class="btn btn-primary">{{ __('modules/slider.button.add_new') }}</a>
    </x-page-header>
    @include('admin.partials.notify')
    <div class="container-xl">
        <form action="{{ route($routeBase . 'index') }}">
            <div class="row mb-4">
                <div class="col-lg-6">
                    <x-input label="{{ __('modules/slider.fields.title') }}" type="text" value="{{ $title }}"
                        name="name" />
                </div>
                <div class="col-lg-6">
                    {!! $selectStatus !!}
                </div>
                <div class="col-lg-6">
                    <x-input label="Ngày bắt đầu" type="datetime-local" value="{{ $createdAt }}" name="created_at" />
                </div>
                <div class="col-lg-6">
                    <x-input label="Ngày kết thúc" type="datetime-local" value="{{ $createdAt }}" name="updated_at" />
                </div>
                <div class="col-lg-12">
                    <input type="submit" class="btn btn-primary" value="Tìm kiếm">
                    <a href="{{ route($routeBase . 'index') }}" class="btn btn-primary">Rest</a>
                </div>
            </div>
        </form>
        <div class="row row-cards mb-4">

            <div class="col-lg-12">
                <div class="card">
                    <div class="table-responsive">
                        <table class="table table-vcenter card-table">
                            <thead>
                                <tr>
                                    <th>name</th>
                                    <th>order</th>
                                    <th>{{ __('modules/slider.fields.status') }}</th>
                                    <th>{{ __('modules/slider.action') }}</th>
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
    </div>
@endsection

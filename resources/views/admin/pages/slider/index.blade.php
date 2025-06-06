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
                        name="title" />
                </div>
                <div class="col-lg-6">
                    <x-input label="{{ __('modules/slider.fields.url') }}" type="text" value="{{ $url }}"
                        name="url" />
                </div>
                <div class="col-lg-6">
                    <x-input label="Ngày bắt đầu" type="datetime-local" value="{{ $createdAt }}" name="created_at" />
                </div>
                <div class="col-lg-6">
                    <x-input label="Ngày kết thúc" type="datetime-local" value="{{ $createdAt }}" name="updated_at" />
                </div>
                <div class="col-lg-6">
                    {!! $selectStatus !!}
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
                                    <th>{{ __('modules/slider.fields.image') }}</th>
                                    <th>Thông tin</th>
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
                                        <td class="text-secondary">
                                            <p>{{ __('modules/slider.fields.title') }} : {{ $item->title }}</p>
                                            <p>{{ __('modules/slider.fields.url') }} : {{ $item->url }}</p>
                                        </td>
                                        <td>
                                            <a href="{{ route($routeBase . 'status', ['status' => $item->status, 'id' => $item->id]) }}"
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

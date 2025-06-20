@php
    use App\Helpers\Form;
    use App\Enums\GeneralStatus;

    $items = $params['items'];
    $routeBase = $params['routeBase'];
    $langPath = $params['langPath'];
    $statuses = GeneralStatus::toArray(true);

    $title = $params['title'] ?? '';
    $slug = $params['slug'] ?? '';
    $status = $params['status'] ?? '';
    $description = $params['description'] ?? '';
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
                        <x-input label="{{ __($langPath . 'fields.title') }}" type="text" value="{{ $title }}"
                            name="title" />
                    </div>
                    <div class="col-lg-6">
                        <x-input label="slug" type="text" value="{{ $slug }}" name="slug" />
                    </div>
                    <div class="col-lg-6">
                        <x-input label="description" type="text" value="{{ $description }}" name="description" />
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
                                    <th>{{ __($langPath . 'fields.name') }}</th>
                                    <th>{{ __($langPath . 'fields.slug') }}</th>
                                    <th>{{ __($langPath . 'fields.status') }}</th>
                                    <th>{{ __($langPath . 'action') }}</th>
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
                                        <td class="text-secondary">
                                            <p>{{ __($langPath . 'fields.title') }} : {{ $item->title }}</p>
                                            <p>{{ __($langPath . 'fields.description') }} : {{ $item->description }}</p>
                                            <p>{{ __($langPath . 'fields.slug') }} : {{ $item->slug }}</p>
                                        </td>
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
        </div>
        {!! $items->appends(request()->input())->links('admin.partials.paginator') !!}
    </div>
@endsection

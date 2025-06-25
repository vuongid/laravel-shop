@php
    use App\Helpers\Form;
    use App\Enums\GeneralStatus;

    $items = $params['items'];
    $routeBase = $params['routeBase'];
    $langPath = $params['langPath'];
    $statuses = GeneralStatus::toArray(true);

    $name = $params['name'] ?? '';
    $slug = $params['slug'] ?? '';
    $description = $params['description'] ?? '';
    $dateFilter = $params['datefilter'] ?? '';

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
                        <x-input label="{{ __('admin.filter.createAt') }}" type="text" value="{{ $dateFilter }}"
                            name="datefilter" />
                    </div>
                    <div class="col-lg-6">
                        <x-input label="slug" type="text" value="{{ $slug }}" name="slug" />
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
                                    <th>{{ __($langPath . 'action') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($items as $item)
                                    <tr>
                                        <td class="text-secondary">
                                            <p>{{ $item->name }}</p>
                                        </td>
                                        <td class="text-secondary">
                                            <p>{{ $item->slug }}</p>
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

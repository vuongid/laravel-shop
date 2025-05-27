@php
    use App\Helpers\Template;

    $item = $params['item'];
@endphp

@extends('admin.layouts.main')
@section('content')
    <div class="page-header d-print-none mt-0 mb-4" aria-label="Page header">
        <div class="container-xl">
            <div class="row g-2 align-items-center">
                <div class="col">
                    <!-- Page pre-title -->
                    <h2 class="page-title">Quản Lý Slider</h2>
                </div>
                <!-- Page title actions -->
                <div class="col-auto ms-auto d-print-none">
                    <div class="btn-list">
                        <a href="{{ route('admin.slider.index') }}" class="btn btn-primary">Quay về</a>
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
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Tên</th>
                                    <th>Trạng thái</th>
                                    <th>URL</th>
                                    <th>Ngày tạo</th>
                                    <th>Ngày sửa</th>
                                    <th>Chức năng</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $status = Template::showItemStatus('slider', $item['id'], $item['status']);
                                    $createdAt = date(config('shop.format.short_time'), strtotime($item['created_at']));
                                    $updateAt = date(config('shop.format.short_time'), strtotime($item['updated_at']));
                                @endphp
                                <tr>
                                    <td class="text-secondary">{{ $item['id'] }}</td>
                                    <td class="text-secondary">{{ $item['title'] }}</td>
                                    <td class="text-secondary">{!! $status !!}</td>
                                    <td class="text-secondary">{{ $item['url'] }}</td>
                                    <td class="text-secondary">{{ $createdAt }}</td>
                                    <td class="text-secondary">{{ $updateAt }}</td>
                                    <td>
                                        <a href="{{ route('admin.slider.edit', $item) }}" class="btn btn-info">Edit</a>
                                        <form action="{{ route('admin.slider.destroy', $item) }}" method="POST"
                                            class="d-inline-block">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

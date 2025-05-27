@php
    use App\Helpers\Template;

    $items = $params['items'];
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
                        <a href="{{ route('admin.slider.create') }}" class="btn btn-primary">Thêm mới</a>
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
                                    <th>Tên</th>
                                    <th>Trạng thái</th>
                                    <th>Ngày tạo</th>
                                    <th>Ngày sửa</th>
                                    <th>Chức năng</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($items as $item)
                                    @php
                                        $status = Template::showItemStatus('slider', $item['id'], $item['status']);
                                        $createdAt = date(
                                            config('shop.format.short_time'),
                                            strtotime($item['created_at']),
                                        );
                                        $udpatedAt = date(
                                            config('shop.format.short_time'),
                                            strtotime($item['updated_at']),
                                        );
                                    @endphp
                                    <tr>
                                        <td class="text-secondary">{{ $item['title'] }}</td>
                                        <td class="text-secondary">{!! $status !!}</td>
                                        <td class="text-secondary">{{ $createdAt }}</td>
                                        <td class="text-secondary">{{ $udpatedAt }}</td>
                                        <td>
                                            <a href="#" class="btn btn-info">Edit</a>
                                            <a href="#" class="btn btn-danger">Delete</a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        {!! $items->links('admin.partials.paginator') !!}
    </div>
@endsection

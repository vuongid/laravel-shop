<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Module Slider
    |--------------------------------------------------------------------------
    */

    'title' => 'Quản lý Tag',
    'single' => 'Tag',
    'plural' => 'Tags',
    'action' => 'hành động',

    // Tên các field
    'fields' => [
        'id'          => 'ID',
        'name'        => 'Tên',
        'slug'        => 'Slug',
        'status'      => 'Trạng thái',
        'created_at'  => 'Thời điểm tạo',
        'updated_at'  => 'Thời điểm cập nhật',
    ],

    // Tên các action
    'actions' => [
        'index' => 'Danh sách Tag',
        'create' => 'Thêm mới Tag',
        'edit' => 'Cập nhật Tag: :name',
        'show' => 'Chi tiết Tag',
    ],

    // Các thông báo
    'messages' => [
        'created' => 'Tag đã được tạo thành công!',
        'updated' => 'Tag đã được cập nhật thành công!',
        'deleted' => 'Tag đã được xóa thành công!',
    ],

    'button' => [
        'delete'  => 'Xóa',
        'detail'  => 'Chi tiết',
        'edit'    => 'Sửa',
        'add'     => 'Thêm',
        'back'    => 'Quay về',
        'add_new' => 'Thêm mới',
        'update'  => 'Cập nhật',
        'find'    => 'Tìm kiếm',
        'rest'    => 'Rest',
        'filters' => 'Bộ lọc'
    ],

    'table' => [
        'info'      => 'Thông tin',
        'startDate' => 'Ngày bắt đầu',
        'endDate'   => 'Ngày kết thúc',
    ]
];

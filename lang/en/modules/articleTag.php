<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Module Slider
    |--------------------------------------------------------------------------
    */

    'title' => 'Quản lý Article Tag',
    'single' => 'Article Tag',
    'plural' => 'Article Tag',
    'action' => 'hành động',

    // Tên các field
    'fields' => [
        'id'          => 'ID',
        'name'        => 'Tên',
        'status'      => 'Trạng thái',
        'created_at'  => 'Thời điểm tạo',
        'updated_at'  => 'Thời điểm cập nhật',
    ],

    // Tên các action
    'actions' => [
        'index' => 'Danh sách Article Tag',
        'create' => 'Thêm mới Article Tag',
        'edit' => 'Cập nhật Article Tag: :name',
        'show' => 'Chi tiết Article Tag',
    ],

    // Các thông báo
    'messages' => [
        'created' => 'Article Tag đã được tạo thành công!',
        'updated' => 'Article Tag đã được cập nhật thành công!',
        'deleted' => 'Article Tag đã được xóa thành công!',
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
        'article'  => 'Bài viết',
        'tag'      => 'Thẻ',
        'startDate' => 'Ngày bắt đầu',
        'endDate'   => 'Ngày kết thúc',
    ]
];

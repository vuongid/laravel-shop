<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Module Slider
    |--------------------------------------------------------------------------
    */

    'title' => 'Quản lý Article Category',
    'single' => 'ArticleCategory',
    'plural' => 'ArticleCategories',
    'action' => 'hành động',

    // Tên các field
    'fields' => [
        'id'          => 'ID',
        'name'        => 'Tên',
        'slug'        => 'Slug',
        'parent_id'   => 'Article Category',
        'status'      => 'Trạng thái',
        'created_at'  => 'Thời điểm tạo',
        'updated_at'  => 'Thời điểm cập nhật',
    ],

    // Tên các action
    'actions' => [
        'index' => 'Danh sách Article Category',
        'create' => 'Thêm mới Article Category',
        'edit' => 'Cập nhật Article Category: :name',
        'show' => 'Chi tiết Article Category',
    ],

    // Các thông báo
    'messages' => [
        'created' => 'Article Category đã được tạo thành công!',
        'updated' => 'Article Category đã được cập nhật thành công!',
        'deleted' => 'Article Category đã được xóa thành công!',
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
        'info'  => 'Thông tin',
        'startDate' => 'Ngày bắt đầu',
        'endDate' => 'Ngày kết thúc',
    ]
];

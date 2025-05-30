<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Module Slider
    |--------------------------------------------------------------------------
    */

    'title' => 'Quản lý Slider',
    'single' => 'Slider',
    'plural' => 'Sliders',
    'action' => 'hành động',

    // Tên các field
    'fields' => [
        'id' => 'ID',
        'title' => 'Tiêu đề',
        'url' => 'URL',
        'status' => 'Trạng thái',
        'image' => 'Ảnh',
        'created_at' => 'Thời điểm tạo',
        'updated_at' => 'Thời điểm cập nhật',
    ],

    // Tên các action
    'actions' => [
        'index' => 'Danh sách Slider',
        'create' => 'Thêm mới Slider',
        'edit' => 'Cập nhật Slider: :name',
        'show' => 'Chi tiết Slider',
    ],

    // Các thông báo
    'messages' => [
        'created' => 'Slider đã được tạo thành công!',
        'updated' => 'Slider đã được cập nhật thành công!',
        'deleted' => 'Slider đã được xóa thành công!',
    ],

    'button' => [
        'delete' => 'Xóa',
        'detail' => 'Chi tiết',
        'edit'   => 'Sửa',
        'add'    => 'Thêm',
        'back'   => 'Quay về',
        'add_new' => 'Thêm mới',
        'update' => 'Cập nhật',
    ]
];

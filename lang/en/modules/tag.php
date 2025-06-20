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
        'title'       => 'Tiêu đề',
        'description' => 'Miêu tả',
        'content'     => 'Nội dung',
        'slug'        => 'Slug',
        'status'      => 'Trạng thái',
        'image'       => 'Ảnh',
        'created_at'  => 'Thời điểm tạo',
        'updated_at'  => 'Thời điểm cập nhật',
    ],

    // Tên các action
    'actions' => [
        'index' => 'Danh sách Article',
        'create' => 'Thêm mới Article',
        'edit' => 'Cập nhật Article: :name',
        'show' => 'Chi tiết Article',
    ],

    // Các thông báo
    'messages' => [
        'created' => 'Article đã được tạo thành công!',
        'updated' => 'Article đã được cập nhật thành công!',
        'deleted' => 'Article đã được xóa thành công!',
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

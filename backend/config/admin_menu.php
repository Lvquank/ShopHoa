<?php

// Đường dẫn: config/admin_menu.php

return [
    [
        'name' => 'Bảng điều khiển',
        'icon' => '<i class="bi bi-speedometer2"></i>',
        'route' => 'admin.dashboard',
        'active' => 'admin.dashboard',
    ],
    [
        'section' => 'Quản lý dữ liệu',
    ],
    [
        'name' => 'Cấu hình',
        'icon' => '<i class="bi bi-gear-wide-connected"></i>',
        'route' => 'admin.config',
        'active' => 'admin.config*',
    ],
    [
        'name' => 'Danh mục sản phẩm',
        'icon' => '<i class="bi bi-menu-button-wide"></i>',
        'active' => ['admin.category.product*', 'admin.styles.*'],
        'submenu' => [
            [
                'name' => 'Danh sách danh mục',
                'route' => 'admin.category.product',
                'active' => ['admin.category.product'],
            ],
            [
                'name' => 'Danh sách kiểu dáng',
                'route' => 'admin.styles.index',
                'active' => ['admin.styles.*'],
            ],
            [
                'name' => 'Thêm danh mục',
                'route' => 'admin.category.product.add',
                'active' => ['admin.category.product.add'],
            ],
        ],
    ],
    [
        'name' => 'Sản phẩm',
        'icon' => '<i class="bi bi-bag"></i>',
        'active' => ['admin.product*', 'admin.comment*'],
        'submenu' => [
            [
                'name' => 'Danh sách sản phẩm',
                'route' => 'admin.product',
                'active' => ['admin.product'],
            ],
            [
                'name' => 'Thêm sản phẩm',
                'route' => 'admin.product.add',
                'active' => ['admin.product.add'],
            ],
            [
                'name' => 'Đánh giá',
                'route' => 'admin.comment',
                'active' => ['admin.comment'],
            ],
            [
                'name' => 'Doanh thu',
                'route' => 'admin.product.revenue',
                'active' => ['admin.product.revenue'],
            ],
        ],
    ],
    [
        'name' => 'Bài viết',
        'icon' => '<i class="bi bi-pencil-square"></i>',
        'active' => ['admin.post*', 'admin.category.post*'],
        'submenu' => [
            [
                'name' => 'Danh mục bài viết',
                'route' => 'admin.category.post',
                'active' => 'admin.category.post*',
            ],
            [
                'name' => 'Danh sách bài viết',
                'route' => 'admin.post',
                'active' => 'admin.post',
            ],
            [
                'name' => 'Bình luận bài viết',
                'route' => 'admin.post-review.list',
                'active' => ['admin.post-review.*'],
            ],
        ],
    ],
    [
        'name' => 'Khách hàng',
        'icon' => '<i class="bi bi-people-fill"></i>',
        'active' => ['admin.user*'],
        'submenu' => [
            [
                'name' => 'Danh sách khách hàng',
                'route' => 'admin.user',
                'active' => ['admin.user'],
            ],
        ],
    ],
    [
        'name' => 'Đơn hàng',
        'icon' => '<i class="bi bi-bag-check"></i>',
        'route' => 'admin.order',
        'active' => 'admin.order*',
    ],
    [
        'name' => 'Tỉnh thành phố',
        'icon' => '<i class="bi bi-geo-alt-fill"></i>',
        'active' => ['admin.address*'],
        'submenu' => [
            [
                'name' => 'Tỉnh/thành phố',
                'route' => 'admin.address.province',
                'active' => ['admin.address.province'],
            ],
            [
                'name' => 'Quận/huyện',
                'route' => 'admin.address.district',
                'active' => ['admin.address.district'],
            ]
        ],
    ],
];

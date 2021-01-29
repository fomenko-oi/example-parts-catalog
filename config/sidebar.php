<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Sidebar configuration
    |--------------------------------------------------------------------------
    |
    | Use this configuration format for a static sidebar menu by adding or
    | removing items. This config is loaded from
    | Http\ViewComposers\SidebarViewComposer.php
    | In that file you can change how to get the sidebar menu configuration,
    | instead of using a static file, you can use a Model to obtain the
    | menu items dinamically from database applying own business logic.
    |
    */
    [
        'text' => 'Main Navigation',
        'heading' => true,
        'translate' => 'sidebar.heading.HEADER'
    ],
    [
        'text' => 'Dashboard',
        'route' => 'admin',
        'icon' => 'icon-speedometer',
        'alert' => '3',
        'label' => 'badge badge-info',
        'translate' => 'sidebar.nav.DASHBOARD'
    ],
    [
        'text' => 'Sections',
        'heading' => true,
        'translate' => 'sidebar.heading.COMPONENTS'
    ],
    [
        'text' => 'Catalog',
        'route' => 'admin/catalog',
        'icon' => 'icon-grid',
    ],
    [
        'text' => 'Configs',
        'route' => 'admin/configs',
        'icon' => 'icon-settings',
    ],
    [
        'text' => 'Delivery',
        'heading' => true,
        'translate' => 'sidebar.heading.COMPONENTS'
    ],
    [
        'text' => 'Countries',
        'route' => 'admin/countries',
        'icon' => 'icon-flag',
    ],
    [
        'text' => 'Delivery methods',
        'route' => 'admin/delivery_methods',
        'icon' => 'fas fa-truck-moving',
    ],
    [
        'text' => 'User',
        'heading' => true,
        'translate' => 'sidebar.heading.COMPONENTS'
    ],
    [
        'text' => 'Users',
        'route' => 'admin/users/users',
        'icon' => 'fas fa-user-alt',
    ],
    [
        'text' => 'Payments',
        'count' => function() {
            return countWaitingPayments();
        },
        'count_class' => 'warning',
        'route' => 'admin/users/payments',
        'icon' => 'fab fa-cc-paypal',
    ],
    [
        'text' => 'Orders',
        'count' => function() {
            return countWaitingOrders();
        },
        'count_class' => 'primary',
        'route' => 'admin/users/orders',
        'icon' => 'fas fa-shopping-basket',
    ],
    [
        'text' => 'Detail Requests',
        'count' => function() {
            return countWaitingDetailRequests();
        },
        'count_class' => 'secondary',
        'route' => 'admin/users/request_orders',
        'icon' => 'far fa-sun',
    ],
];

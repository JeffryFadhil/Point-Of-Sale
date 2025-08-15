<?php

namespace App\View\Components\Admin;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Aside extends Component
{
    /**
     * Create a new component instance.
     */
    public $routes;
    public function __construct()
    {
       $this->routes = [
            [
                'label' => 'Dashboard',
                'icon' => 'fas fa-tachometer-alt',
                'route_name' => 'dashboard',
                'route_active' => 'dashboard',
                'is_dropdown' => false,
            ],
            [
                'label' => 'Users',
                'icon' => 'fas fa-users',
                'route_name' => 'users.index',
                'route_active' => 'users.*',
                'is_dropdown' => false,
            ],
            [
                'label' => 'Master Data',
                'icon' => 'fas fa-database',
                'route_name' => null,
                'route_active' => 'master-data.*',
                'is_dropdown' => true,
                'dropdown' => [
                    [
                        'label' => 'Kategori',
                        'icon' => 'fas fa-list',
                        'route_name' => 'master-data.kategori.index',
                        'route_active' => 'master-data.kategori.*',
                    ],
                    [
                        'label' => 'Produk',
                        'icon' => 'fas fa-box',
                        'route_name' => 'master-data.product.index',
                        'route_active' => 'master-data.product.*',
                    ],
                ],
            ],
            [
                'label' => 'Penerimaan Barang',
                'icon' => 'fas fa-archive',
                'route_name' => 'penerimaan-barang.index',
                'route_active' => 'penerimaan-barang.*',
                'is_dropdown' => false,
            ],
        ];
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.admin.aside');
    }
}

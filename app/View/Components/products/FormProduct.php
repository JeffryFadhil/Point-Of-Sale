<?php

namespace App\View\Components\products;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;
use App\Models\Product;
use App\Models\kategori; 

class FormProduct extends Component
{
    /**
     * Create a new component instance.
     */
    public $id , $name_product, $harga_jual, $harga_beli_pokok, $stok, $stok_minimal, $is_active, $kategori_id , $kategori;
    public function __construct( $id = null)
    {
        $this->kategori = kategori::all();

        if ($id) {
            $product = Product::find($id);
            $this->id = $product->id;
            $this->name_product = $product->name_product;
            $this->harga_jual = $product->harga_jual;
            $this->harga_beli_pokok = $product->harga_beli_pokok;
            $this->stok = $product->stok;
            $this->stok_minimal = $product->stok_minimal;
            $this->is_active = $product->is_active;
            $this->kategori_id = $product->kategori_id;
        }
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.products.form-product');
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::all();
        return view('product.index', compact('products'));
    }

    public function store(Request $request)
    {
        $id = $request->id;
        $request->validate([
            'name_product' => 'required|unique:products,name_product,' . $request->id,
            'harga_jual' => 'required|numeric',
            'harga_beli_pokok' => 'required|numeric',
            'kategori_id' => 'required|exists:kategoris,id',
            'stok' => 'required|integer',
            'stok_minimal' => 'required|integer',
            'is_active' => 'required',
        ], [
            'name_product.required' => 'Nama produk harus diisi.',
            'name_product.unique' => 'Nama produk sudah ada.',
            'harga_jual.required' => 'Harga jual harus diisi.',
            'harga_beli_pokok.required' => 'Harga beli pokok harus diisi.',
            'kategori_id.required' => 'Kategori harus dipilih.',
            'stok.required' => 'Stok harus diisi.',
            'stok_minimal.required' => 'Stok minimal harus diisi.',
            'is_active.required' => 'Status aktif harus dipilih.',
        ]);

        $newRequest = [
            'name_product' => $request->name_product,
            'harga_jual' => $request->harga_jual,
            'harga_beli_pokok' => $request->harga_beli_pokok,
            'kategori_id' => $request->kategori_id,
            'stok' => $request->stok,
            'stok_minimal' => $request->stok_minimal,
            'is_active' => $request->is_active ? true : false,
        ];


        if (empty($id)) {
            $newRequest['Sku'] = Product::nomorSku();
        }




        $product = Product::updateOrCreate(

            ['id' => $id],

            $newRequest


        );

        toast()->success('Produk berhasil disimpan!', 'Success');

        return redirect()->route('master-data.product.index');
    }

    public function destroy(string $id)
    {
        $product = Product::findOrFail($id);
        $product->delete();
        toast()->success('Produk berhasil dihapus!', 'Success');
        return redirect()->route('master-data.product.index');
    }

    public function getData()
    {
        $products = request()->query('search');
        $query = Product::query();
       $product = $query->where('name_product', 'like', '%' . $products . '%')->get();
        return response()->json($product);
    }
}
<?php

namespace App\Http\Controllers;

use App\Http\Middleware\Auth;
use App\Models\PenerimaanBarang;
use App\Models\itemPenerimaanBarang;
use App\Models\product;
use Illuminate\Http\Request;

class PenerimaanBarangController extends Controller
{
    public function index(){
        return view('penerimaan-barang.index'); // Assuming you have a view for this
    }

    public function store(Request $request){
       $request->validate(
        [
            'distributor'   => 'required',
            'nomor_faktur'  => 'required',
            'produk'      => 'required',
        ],
        [
            'distributor.required'  => 'Distributor harus diisi.',
            'nomor_faktur.required' => 'Nomor faktur harus diisi.',
            'produk.required'     => 'Produk harus ditambahkan.',
        ]
       );

        // Create a new PenerimaanBarang record

       $newData = PenerimaanBarang::create([
            'nomor_penerimaan' => PenerimaanBarang::nomorPenerimaan(),
            'distributor'      => $request->distributor,
            'nomor_faktur'     => $request->nomor_faktur,
            'petugas_penerima' => Auth()->user()->name, 
        ]);

        $produk = $request->produk;
        foreach ($produk as $item) {
           itemPenerimaanBarang::create([
                'nomor_penerimaan' => $newData->nomor_penerimaan,
                'nama_produk'      => $item['name_product'],
                'qty'              => $item['qty'],
                'harga_beli'       => $item['harga_beli'],
                'sub_total'        => $item['sub_total'],
            ]);
            product::where('id', $item['id'])->increment('stok', $item['qty']);
        }

     
         toast()->success('Data berhasil disimpan!');
        return redirect()->route('penerimaan-barang.index');
    }
}

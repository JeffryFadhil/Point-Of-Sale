<?php

namespace App\Http\Controllers;

use App\Http\Middleware\Auth;
use App\Models\PenerimaanBarang;
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
            'products'      => 'required',
        ],
        [
            'distributor.required'  => 'Distributor harus diisi.',
            'nomor_faktur.required' => 'Nomor faktur harus diisi.',
            'products.required'     => 'Produk harus ditambahkan.',
        ]
       );

        PenerimaanBarang::create([
            'nomor_penerimaan' => PenerimaanBarang::nomorPenerimaan(),
            'distributor'      => $request->distributor,
            'nomor_faktur'     => $request->nomor_faktur,
            'petugas_penerima' => Auth()->user()->name, 
        ]);

    }
}

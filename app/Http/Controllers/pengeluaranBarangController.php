<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class pengeluaranBarangController extends Controller
{
     public function index(){
        return view('pengeluaran-barang.index'); // Assuming you have a view for this
    }
        public function store(Request $request){
           dd($request->all());
        }
}

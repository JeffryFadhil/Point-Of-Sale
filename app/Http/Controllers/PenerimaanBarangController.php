<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PenerimaanBarangController extends Controller
{
    public function index(){
        return view('penerimaan-barang.index'); // Assuming you have a view for this
    }
}

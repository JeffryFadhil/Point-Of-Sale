<?php

namespace App\Http\Controllers;

use App\Models\itemPenerimaanBarang;
use App\Models\pengeluaranBarang;
use App\Models\product;
use App\Models\User;
use Carbon\Carbon;
use Carbon\CarbonImmutable;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $bulanIni = Carbon::now()->month;
        $tahunIni = Carbon::now()->year;
        
         
        $totalUser = User::count();
        $totalProduct = product::count();
        $totalOrder = pengeluaranBarang::whereMonth('created_at', $bulanIni)
        ->whereYear('created_at' , $tahunIni)->count();
        $totalPendapatan = pengeluaranBarang::whereMonth('created_at',$bulanIni)->whereYear('created_at',$tahunIni)->sum('total_harga');
        $totalPendapatan = "Rp.". number_format($totalPendapatan);
        $latesOrder = pengeluaranBarang::latest()->take(5)->get()->map(function($item){
            $item->tanggal_transaksi = Carbon::parse($item->created_at)->locale('id')->translatedFormat('l,d-m-y');
            return $item;
        });
        $productTerlaris = itemPenerimaanBarang::select('nama_produk')
        ->selectRaw('SUM(qty) as total_terjual')
        ->whereMonth('created_at' , $bulanIni)
        ->whereYear('created_at' , $tahunIni)
        ->groupBy('nama_produk')
        ->orderByDesc('total_terjual')
        ->limit(5)
        ->get();

        return view('dashboard.index', compact('totalUser','totalProduct' , 'totalOrder' , 'totalPendapatan','latesOrder','productTerlaris'));
    }
}

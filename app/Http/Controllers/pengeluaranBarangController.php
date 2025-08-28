<?php

namespace App\Http\Controllers;

use App\Http\Middleware\Auth;
use App\Models\itemPengeluaranBarang;
use App\Models\pengeluaranBarang;
use App\Models\product;
use Carbon\Carbon;
use Illuminate\Http\Request;

class pengeluaranBarangController extends Controller
{
   public function index()
   {
      return view('pengeluaran-barang.index'); // Assuming you have a view for this
   }
   public function store(Request $request)
   {

      if (empty($request->produk)) {
         toast()->error('tidak ada product yang di pilih!');
         return redirect()->back();
      }

      $request->validate([
         'produk' => 'required|array|min:1',
         'bayar' => 'required|numeric|min:1',
      ], [
         // 2. Pesan Error Kustom (Opsional)
         'produk.required' => 'Mohon pilih setidaknya satu produk.',
         'produk.array' => 'Data produk tidak valid.',
         'produk.min' => 'Anda harus memilih setidaknya satu produk.',
         'bayar.required' => 'Jumlah pembayaran wajib diisi.',
         'bayar.numeric' => 'Jumlah pembayaran harus berupa angka.',
         'bayar.min' => 'Jumlah pembayaran harus lebih dari 0.',
      ]);

      $produk = collect($request->produk);
      $bayar = $request->bayar;
      $total = $produk->sum('sub_total');
      $kembalian = intval($bayar) - intval($total);

      if ($bayar < $total) {
         toast()->error('total pembayaran kurang');
         return back()->withInput([
            'produk' => $produk,
            'bayar' => $bayar,
            'total' => $total,
            'kembalian' => $kembalian,

         ]);


      }

      $data = pengeluaranBarang::create([
         'nomor_pengeluaran' => pengeluaranBarang::nomorPengeluaran(),
         'nama_petugas' => Auth()->user()->name,
         'total_harga' => $total,
         'bayar' => $bayar,
         'kembalian' => $kembalian,
      ]);

      foreach ($produk as $item) {
         itemPengeluaranBarang::create([
            'nomor_pengeluaran' => $data->nomor_pengeluaran,
            'name_product' => $item['name_product'],
            'qty' => $item['qty'],
            'harga' => $item['harga'],
            'sub_total' => $item['sub_total'],
         ]);

         product::where('id', $item['id'])->decrement('stok', $item['qty']);
      }

      toast()->success('Transaksi Berhasil');
      return redirect()->route('pengeluaran-barang.index');

   }
    public function laporan(){
        $pengeluaranBarang = pengeluaranBarang::orderBy('created_at', 'desc')->get()->map(function($item){
            $item->tanggal_pengeluaran = Carbon::parse($item->created_at)->locale('id')->translatedFormat('l,d F Y');
            return $item;
        });
        return view('laporan.pengeluaran-barang.laporan', compact('pengeluaranBarang'));
    }
    public function detailLaporan($nomor_pengeluaran){
        $data = pengeluaranBarang::with('items')->where('nomor_pengeluaran', $nomor_pengeluaran)->first();
        $data->tanggal_pengeluaran = Carbon::parse($data->created_at)->locale('id')->translatedFormat('l,d F Y');
        $data->total_harga = $data->items->sum('sub_total');
        return view('laporan.pengeluaran-barang.detail', compact('data'));
    }
}

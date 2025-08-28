@extends('layouts.app')
@section('content_title', 'Laporan pengeluaran Barang')
@section('content')
<div>
    <table class="table " id="table2">
        <thead>
            <tr>
                <th>No</th>
                <th>nomor pengeluaran</th>
                <th>tanggal transaksi</th>
                <th>Total Transaksi</th>
                <th>pembayaran</th>
                <th>kembalian</th>
                <th>nama petugas</th>
                <th>aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($pengeluaranBarang as $index => $item)
            <tr>
                    <td>{{ $index +1 }}</td>
                    <td>{{ $item->nomor_pengeluaran }}</td>
                    <td>{{ $item->tanggal_pengeluaran }}</td>
                    <td>{{ $item->total_harga }}</td>
                    <td>{{ $item->bayar }}</td>
                    <td>{{ $item->kembalian }}</td>
                    <td>{{ $item->nama_petugas }}</td>
                   <td>
                     <a href="{{ route('laporan.pengeluaran-barang.detail-laporan' , $item->nomor_pengeluaran) }}" class="taxt-primary"> Detail </a>
                   </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    
</div>
@endsection
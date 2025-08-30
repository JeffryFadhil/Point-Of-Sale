@extends('layouts.app')
@section('content_title', 'Dashboard')
@section('content')
    <div class="row">
        <div class="col-lg-3 col-md-6 mb-3">
            <x-dashboard-card type="bg-info" label="Total Users" icon="fas fa-users" value="{{ $totalUser }}" />
        </div>
        <div class="col-lg-3 col-md-6 mb-3">
            <x-dashboard-card type="bg-warning" label="Total Produk" icon="fas fa-briefcase" value="{{ $totalProduct }}" />
        </div>
        <div class="col-lg-3 col-md-6 mb-3">
            <x-dashboard-card type="bg-success" label="Total Order" icon="fas fa-shopping-cart" value="{{ $totalOrder }}" />
        </div>
        <div class="col-lg-3 col-md-6 mb-3">
            <x-dashboard-card type="bg-teal" label="Total Pendapatan" icon="fas fa-dollar-sign"
                value="{{ $totalPendapatan }}" />
        </div>
    </div>
    <div class="row">
        <div class="col-8">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Transaksi Terakhir</h4>
                </div>
                <div class="card-body">
                    <table class="table table-sm">
                        <thead>
                            <tr>
                                <th>Tanggal Transaksi</th>
                                <th>Nomor transaksi</th>
                                <th>Jumblah item</th>
                                <th>Total Harga</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($latesOrder as $item)
                                <tr>
                                    <th>{{ $item->tanggal_transaksi }}</th>
                                    <th>{{ $item->nomor_pengeluaran }}</th>
                                    <th>{{ $item->items->count() }} <small> item</small></th>
                                    <th>Rp. {{ number_format($item->total_harga) }}</th>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="card-footer">
                    Menampilkan 5 data transaksi terbaru
                </div>
            </div>
        </div>
        <div class="col-4">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">product terlaris</h4>
                </div>
                <div class="card-body">
                    <table class="table table-sm">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>nama Produk</th>
                                <th>Jumblah Terjual</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($productTerlaris as $index => $item)
                                <tr>
                                    <th>{{ $index + 1 }}</th>
                                    <th>{{ $item->nama_produk }}</th>
                                    <th>{{ $item->total_terjual }}</th>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="card-footer">
                    Menampilkan 5 produk terlaris
                </div>
            </div>
        </div>
    </div>

@endsection
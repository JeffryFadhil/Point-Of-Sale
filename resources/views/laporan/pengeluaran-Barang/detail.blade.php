@extends('layouts.app')
@section('content_title', 'Laporan Pengeluaran Barang')
@section('content')
<div class="card shadow-sm rounded-3">
    <div class="d-flex justify-content-between align-items-start p-4 border-bottom bg-light">
        <div>
            <h3 class="fw-bold mb-1">PT APP POS</h3>
            <h5 class="text-muted">Detail Laporan Pengeluaran Barang</h5>
        </div>
        <div class="text-end">
            <span class="badge bg-danger fs-6 mb-2">
                Nomor Pengeluaran: {{ $data->nomor_pengeluaran }}
            </span><br>
            <strong>Petugas Pengeluar:</strong> {{ $data->nama_petugas }}<br>
             <strong>Jumblah Bayar : </strong>Rp. {{ number_format($data->bayar) }} <br>
             <strong>Kembalian : </strong>Rp. {{  number_format($data->kembalian) }} <br>
             <strong>Total Bayar : </strong>Rp. {{  number_format($data->total_harga) }} <br>
            <small class="text-muted">
                Tanggal:{{ $data->tanggal_pengeluaran }}
            </small>
        </div>
    </div>
    <div class="card-body">
        <table class="table table-bordered table-striped table-hover align-middle">
            <thead class="table-secondary">
                <tr>
                    <th class="text-center" width="5%">No</th>
                    <th>Produk</th>
                    <th class="text-center" width="10%">Qty</th>
                    <th class="text-end" width="15%">Harga Satuan</th>
                    <th class="text-end" width="15%">sub total</th>
                </tr>
            </thead>
            <tbody>
                @php $grandTotal = 0; @endphp
                @foreach ($data->items as $index => $item)
                @php 
                $total = $item->qty * $item->harga; 
                $grandTotal += $total;
            @endphp
                <tr>
                    <td class="text-center">{{ $index + 1 }}</td>
                    <td>{{ $item->name_product }}</td>
                    <td class="text-center">{{ $item->qty }}</td>
                    <td>{{ number_format($item->harga,0,',','.') }}</td>
                <td>{{ number_format($item->sub_total,0,',','.') }}</td>
                </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <th colspan="4" class="text-end">Total Harga</th>
                     <td><strong>Rp. {{ number_format($grandTotal,0,',','.') }}</strong></td>
                </tr>
            </tfoot>
        </table>
    </div>
</div>
@endsection

@extends('layouts.app')
@section('content_title', 'Detail Laporan Penerimaan Barang')
@section('content')
<div class="card shadow-sm rounded-3">
    <div class="d-flex justify-content-between align-items-start p-4 border-bottom bg-light">
        <div>
            <h3 class="fw-bold mb-1">PT APP POS</h3>
            <h5 class="text-muted">Detail Laporan Penerimaan Barang</h5>
        </div>
        <div class="text-end">
            <span class="badge bg-primary fs-6 mb-2">Nomor Penerimaan: {{ $data->nomor_penerimaan }}</span><br>
            <strong>Distributor:</strong> {{ $data->distributor }}<br>
            <strong>Nomor Faktur:</strong> {{ $data->nomor_faktur }}<br>
            <strong>Petugas Penerima:</strong> {{ $data->petugas_penerima }}<br>
            <small class="text-muted">Tanggal: {{ $data->tanggal_penerimaan }}</small>
        </div>
    </div>
    <div class="card-body">
        <table class="table table-bordered table-striped table-hover align-middle">
            <thead class="table-secondary">
                <tr>
                    <th class="text-center" width="5%">No</th>
                    <th>Produk</th>
                    <th class="text-center" width="10%">Qty</th>
                    <th class="text-end" width="15%">Harga Beli</th>
                    <th class="text-end" width="15%">Total Harga</th>
                </tr>
            </thead>
            <tbody>
                @php $grandTotal = 0; @endphp
                @foreach ($data->items as $index => $item)
                @php $total = $item->qty * $item->harga_beli; $grandTotal += $total; @endphp
                <tr>
                    <td class="text-center">{{ $index + 1 }}</td>
                    <td>{{ $item->nama_produk }}</td>
                    <td class="text-center">{{ $item->qty }}</td>
                    <td class="text-end">{{ number_format($item->harga_beli, 0, ',', '.') }}</td>
                    <td class="text-end">{{ number_format($total, 0, ',', '.') }}</td>
                </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <th colspan="4" class="text-end">Grand Total</th>
                    <th class="text-end text-primary fw-bold">{{ number_format($grandTotal, 0, ',', '.') }}</th>
                </tr>
            </tfoot>
        </table>
    </div>
</div>
@endsection

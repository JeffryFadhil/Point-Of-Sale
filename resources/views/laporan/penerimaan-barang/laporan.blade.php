@extends('layouts.app')
@section('content_title', 'Laporan Penerimaan Barang')
@section('content')
<div>
    <table class="table " id="table2">
        <thead>
            <tr>
                <th>No</th>
                <th>nomor Penerimaan</th>
                <th>nomor faktur</th>
                <th>petugas penerima</th>
                <th>distributor</th>
                <th>tanggal penerimaan</th>
                <th>aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($penerimaanBarang as $index => $item)
            <tr>
                    <td>{{ $index +1 }}</td>
                    <td>{{ $item->nomor_penerimaan }}</td>
                    <td>{{ $item->nomor_faktur }}</td>
                    <td>{{ $item->petugas_penerima }}</td>
                    <td>{{ $item->distributor }}</td>
                    <td>{{ $item->tanggal_penerimaan }}</td>
                   <td>
                     <a href="{{ route('laporan.penerimaan-barang.detail-laporan' , $item->nomor_penerimaan) }}" class="taxt-primary"> Detail </a>
                   </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    
</div>
@endsection
@extends('layouts.app')
@section('content_title', 'Product List')
@section('content')
    <div class="card">
        <div class="card-header">
            <div class="card-body">
               <x-alert :errors="$errors" type="danger" />
                <div class="d-flex justify-content-end mb-3">
                    <x-products.form-product />
                </div>
                <table class="table table-bordered" id="table2">
                    <thead>
                        <tr>
                           <th>no</th>
                           <th>Sku</th>
                           <th>nama product</th>
                           <th>harga jual</th>
                           <th>harga beli</th>
                           <th>stok</th>
                           <th>stok minimal</th>
                           <th>is_active</th>
                           <th>aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($products as $index => $product)
                            <tr>
                                <td>{{ $index +1 }}</td>
                                <td>{{ $product->Sku }}</td>
                                <td>{{ $product->name_product}}</td>
                                <td>Rp. {{ number_format($product->harga_jual) }}</td>
                                <td>Rp. {{ number_format($product->harga_beli_pokok) }}</td>
                                <td>{{ number_format($product->stok) }}</td>
                                <td>{{ number_format($product->stok_minimal) }}</td>
                                <td>{{ $product->is_active ? 'Active' : 'Inactive' }}</td>
                                <td>
                                    <!-- Add action buttons here -->
                                    <div class="d-flex align-items-center gap-2">
                                        <x-products.form-product :id="$product->id" />
                                        <a href="#" class="btn btn-danger" onclick="deleteData({{ $product->id }})">
                                            <i class="fas fa-trash"></i> Delete
                                        </a>

                                        <form id="delete-form-{{ $product->id }}"
                                            action="{{ route('master-data.product.destroy', $product->id) }}" method="POST"
                                            style="display: none;">
                                            @csrf
                                            @method('DELETE')
                                        </form>

                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

@endsection

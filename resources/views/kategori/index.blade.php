@extends('layouts.app')
@section('content_title', 'Data Kategori')
@section('content')
    <div class="card">
        <div class="card-header">
            <div class="card-body">
                @if ($errors->any())
                    <div class="alert alert-danger d-flex flex-column">
                        @foreach ($errors->all() as $error)
                            <small class="text-white">{{ $error }}</small>
                        @endforeach
                    </div>

                @endif
                <div class="d-flex justify-content-end mb-3">
                    <x-kategori.form-kategori />
                </div>
                <table class="table table-bordered" id="table2">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Description</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($kategori as $index => $item)
                            <tr>
                                <td>{{ $index +1 }}</td>
                                <td>{{ $item->nama_kategori }}</td>
                                <td>{{ $item->deskripsi }}</td>
                                <td>
                                    <!-- Add action buttons here -->
                                    <div class="d-flex align-items-center gap-2">
                                        <x-kategori.form-kategori :id="$item->id" />
                                        <a href="#" class="btn btn-danger" onclick="deleteData({{ $item->id }})">
                                            <i class="fas fa-trash"></i> Delete
                                        </a>

                                        <form id="delete-form-{{ $item->id }}"
                                            action="{{ route('master-data.kategori.destroy', $item->id) }}" method="POST"
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
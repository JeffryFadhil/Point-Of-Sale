@extends('layouts.app')
@section('content_title', 'Data Users')
@section('content')
    <div class="card">
        <div class="card-header">
            <div class="card-body">
               <x-alert :errors="$errors" type="danger" />
                <div class="d-flex justify-content-end mb-3">
                    <x-users.form-users />
                </div>
                <table class="table table-bordered" id="table2">
                    <thead>
                        <tr>
                            <th>no</th>
                            <th>Name</th>
                            <th>email</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($users as $index => $user)
                            <tr>
                                <td>{{ $index +1 }}</td>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->email }}</td>
                                <td>
                                    <!-- Add action buttons here -->
                                    <div class="d-flex align-items-center gap-5">
                                        <x-users.form-users :id="$user->id" />
                                        <a href="#" class="btn btn-danger" onclick="deleteData({{ $user->id }})">
                                            <i class="fas fa-trash"></i> Delete
                                        </a>

                                        <form id="delete-form-{{ $user->id }}"
                                            action="{{ route('users.destroy', $user->id) }}" method="POST"
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
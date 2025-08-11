<div>
    <button type="button" class="btn {{ $id ? 'btn-default' : 'btn-primary' }}" data-toggle="modal"
        data-target="#FormUser{{ $id ?? '' }}">
        {{ $id ? 'Edit User' : 'Tambah User' }}
    </button>
    <div class="modal fade" id="FormUser{{ $id ?? '' }}">
        <form action="{{ route('users.store') }}" method="POST">
            @csrf
            <input type="hidden" placeholder="id" name="id" value="{{ $id ?? '' }}">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">{{ $id ? 'Edit User' : 'Tambah User' }}</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="email">email</label>
                            <input class="form-control" id="email" name="email"  rows="3"
                                value="{{ $id ? $email : old('email') }}">
                        </div>

                        <div class="form-group">
                            <label for="name">Nama User</label>
                            <input type="text" class="form-control" id="name" name="name"
                                value="{{ $id ? $name : old('$name') }}">
                        </div>
                    </div>
                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </form>
    </div>
</div>
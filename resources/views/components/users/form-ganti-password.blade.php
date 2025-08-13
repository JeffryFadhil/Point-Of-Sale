<!-- Modal -->
<div class="modal fade" id="formGantiPassword" tabindex="-1" aria-labelledby="formGantiPassword" aria-hidden="true">
    <form action="{{ route('users.ganti-password') }}" method="POST">
        @csrf
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="formGantiPassword">{{ auth()->user()->name }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="current_password">Password Lama</label>
                        <input type="password" class="form-control" id="old_password" name="old_password"
                            placeholder="Masukkan Password Lama">
                    </div>
                    @error('old_password')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                    <div class="form-group">
                        <label for="new_password">Password Baru</label>
                        <input type="password" class="form-control" id="password" name="password"
                            placeholder="Masukkan Password Baru">
                    </div>
                   @error('password')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                    <div class="form-group">
                        <label for="password_confirmation">Konfirmasi Password Baru</label>
                        <input type="password" class="form-control" id="password_confirmation" name="password_confirmation"
                            placeholder="Konfirmasi Password Baru">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Ganti password</button>
                </div>
            </div>
        </div>
    </form>
</div>
<div>
    <button type="button" class="btn {{ $id ? 'btn-default' : 'btn-primary' }}" data-toggle="modal"
        data-target="#FormProduct{{ $id ?? '' }}">
        {{ $id ? 'Edit product' : 'Tambah product' }}
    </button>
    <div class="modal fade" id="FormProduct{{ $id ?? '' }}">
        <form action="{{ route('master-data.product.store') }}" method="POST">
            @csrf
            <input type="hidden" name="id" value="{{ $id ?? '' }}">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">{{ $id ? 'Edit product' : 'Tambah product' }}</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">

                        <div class="form-group">
                            <label for="name_product">Nama Product</label>
                            <input type="text" class="form-control" id="name_product" name="name_product"
                                value="{{ $id ? $name_product : old('$name_product') }}">
                        </div>
                        <div class="form-group">
                            <label for="kategori_id">Kategori</label>
                            <select class="form-control" id="kategori_id" name="kategori_id">
                                <option value="">Pilih Kategori</option>
                                @foreach ($kategori as $item)
                                    <option value="{{ $item->id }}" {{ $id && $item->id == $item->id ? 'selected' : '' }}>
                                        {{ $item->nama_kategori }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="harga_jual">Harga Jual</label>
                            <input type="number" class="form-control" id="harga_jual" name="harga_jual"
                                value="{{ $id ? $harga_jual : old('$harga_jual') }}">
                        </div>
                        <div class="form-group">
                            <label for="harga_beli_pokok">Harga Beli</label>
                            <input type="number" class="form-control" id="harga_beli_pokok" name="harga_beli_pokok"
                                value="{{ $id ? $harga_beli_pokok : old('$harga_beli_pokok') }}">
                        </div>
                        <div class="form-group">
                            <label for="stok">Stok</label>
                            <input type="number" class="form-control" id="stok" name="stok"
                                value="{{ $id ? $stok : old('$stok') }}">
                        </div>
                        <div class="form-group">
                            <label for="stok_minimal">Stok minimal</label>
                            <input type="number" class="form-control" id="stok_minimal" name="stok_minimal"
                                value="{{ $id ? $stok_minimal : old('$stok_minimal') }}">
                        </div>
                        <div class="form-group my1 d-flex flex-column">
                            <div class="d-flex "> 
                                <label for="is_active" class="mr-4">Status</label>
                               <input type="hidden" name="is_active" value="0">
<input type="checkbox" name="is_active" value="1" {{ old('is_active', $is_active ?? false) ? 'checked' : '' }}>

                                    
                                </div>
                                <i class="text-danger">jika product active maka akan di tampikkan </i>
                            </div>
                    </div>    
                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save changes</button>
                    </div>
                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </form>
    </div>
</div>
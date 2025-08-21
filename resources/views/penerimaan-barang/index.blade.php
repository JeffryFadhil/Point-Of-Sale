@extends('layouts.app')
@section('content_title', 'Penerimaan Barang')
@section('content')
    <div class="card">
      <form action="{{ route('penerimaan-barang.store') }}" method="POST" id="form-penerimaan-barang">
        @csrf
        <div id="data-hidden"></div>
          <div class="d-flex justify-content-between align-items-center p-4 border-bottom">
            <h3 class="card-title">Penerimaan Barang</h3>
            <div>
                <button type="submit" class="btn btn-primary">Simpan Penerimaan Barang</button>
            </div>
        </div>
        <div class="card-body">
            <div class="w-50">
                <div class="form-group">
                    <label for="">Distributor</label>
                    <input type="text" name="distributor" id="distributor" class="form-control">
                    @error('distributor')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="">Nomor Fakture</label>
                    <input type="text" name="nomor_faktur" id="nomor_faktur" class="form-control">
                    @error('nomor_faktur')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>
            </div>
            <div class=" d-flex">
                <div class="w-100">
                    <label for="select2">Product</label>
                    <select name="select2" id="select2" class="form-control"></select>
                </div>
                <div>
                    <label for="">Stok Tersedia</label>
                    <input type="number"  id="current_stok" class="form-control mx-2"
                        style="width: 100px;" readonly>
                </div>
                <div>
                    <label for="qty">Qty</label>
                    <input type="number"  id="qty" class="form-control mx-2" style="width: 100px;" min="1">
                </div>
                <div style="padding-top: 32px">
                    <button type="button" class="btn btn-primary" id="btn-add">Tambah</button>
                </div>
            </div>
        </div>
      </form>
        <div class="card-body">
            <table class="table table-sm" id="table_product">
                <thead>
                    <tr>
                        <th>Product</th>
                        <th>Qty</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>

                </tbody>
            </table>
        </div>
@endsection
    @push('scripts')
        <script>
            $(document).ready(function () {
                let selectedProduct = {};
                $('#select2').select2({
                    theme: 'bootstrap',
                    placeholder: 'Pilih Barang',
                    ajax: {
                        url: '{{ route('get-data.product') }}',
                        dataType: 'json',
                        delay: 250,
                        data: (params) => {
                            return {
                                search: params.term,
                            };

                        },
                        processResults: (data) => {
                            data.forEach(item => {
                                selectedProduct[item.id] = item;
                            })
                            return {
                                results: data.map((item) => {
                                    return {
                                        id: item.id,
                                        text: item['name_product'],
                                    };

                                }),
                            };
                        },
                        cache: true,

                    },
                    minimumInputLength: 2,
                })

                $("#select2").on('change', function (e) {
                    let id = $(this).val();

                    // Tambahkan validasi ini
                    if (id) {
                        $.ajax({
                            type: "GET",
                            url: "{{ route('get-data.cek-stok') }}",
                            data: {
                                id: id
                            },
                            dataType: "json",
                            success: function (response) {
                                $("#current_stok").val(response.stok);
                            }
                        });
                    } else {
                        // Jika id kosong, reset nilai stok atau tampilkan pesan
                        $("#current_stok").val('');
                    }
                });
                $('#btn-add').on('click', function () {
                    let productId = $('#select2').val();
                    let qty = $('#qty').val();
                    let currentStok = $('#current_stok').val();

                    let product = selectedProduct[productId];

                    if (!productId || !qty || qty <= 0) {
                        alert('Mohon lengkapi data produk dan qty!');
                        return;
                    }

                    if (parseInt(qty) > parseInt(currentStok)) {
                        alert('Qty melebihi stok yang tersedia!');
                        return;
                    }

                    let exist = false;
                    $('#table_product tbody tr').each(function () {
                        const rowProduct = $(this).find('td:first').text();

                        if (rowProduct === product.name_product) {
                            let currentQty = parseInt($(this).find("td:eq(1)").text());
                            let newQty = currentQty + parseInt(qty);

                            $(this).find("td:eq(1)").text(newQty);
                            exist = true;
                            return false; // Break the loop
                        }

                    })

                    if (!exist) {
                        const row = `
                                    <tr>
                                        <td>${product.name_product}</td>
                                        <td>${qty}</td>
                                        <td>
                                            <button class="btn btn-danger btn-sm btn-delete">Hapus</button>
                                        </td>
                                    </tr>`
                        $('#table_product tbody').append(row);
                    }


                    $('#select2').val(null).trigger('change');
                    $('#qty').val('');
                    $('#current_stok').val('');

                });


                $('#table_product').on('click', '.btn-delete', function () {
                    $(this).closest('tr').remove();
                });

                $('#form-penerimaan-barang').on("submit", function () {
                    $('#data-hidden').html("");

                    $('#table_product tbody tr').each(function (index , row ){
                        const nameproduct = $(row).find('td:eq(0)').text();
                        const qty = $(row).find('td:eq(1)').text();
                        const productId = $(row).data("id");

                        const inputProduct = `<input type="hidden" name="produk[${index}]['name_product']" value="${nameproduct}"/>`;
                        const inputQty = `<input type="hidden" name="produk[${index}]['qty']" value="${qty}"/>`;

                        $('#data-hidden').append(inputProduct).append(inputQty);

                    });
                });
            });
        </script>
    @endpush
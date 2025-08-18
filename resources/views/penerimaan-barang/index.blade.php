@extends('layouts.app')
@section('content_title', 'Penerimaan Barang')
@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Penerimaan Barang</h3>
        </div>
        <div class="card-body">
            <div class=" d-flex">
                <div class="w-100">
                    <label for="select2">Product</label>
                    <select name="select2" id="select2" class="form-control"></select>
                </div>
                <div>
                    <label for="">Stok Tersedia</label>
                    <input type="number" name="current_stok" id="current_stok" class="form-control mx-2"
                        style="width: 100px;" readonly>
                </div>
                <div>
                    <label for="qty">Qty</label>
                    <input type="number" name="qty" id="qty" class="form-control mx-2" style="width: 100px;" min="1">
                </div>
                <div style="padding-top: 32px">
                    <button class="btn btn-primary" id="btn-add">Tambah</button>
                </div>
            </div>
        </div>
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
            });
        </script>
    @endpush
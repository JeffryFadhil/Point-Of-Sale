@extends('layouts.app')
@section('content_title', 'Pengeluaran Barang')
@section('content')
    <div class="card">
        <form action="{{ route('pengeluaran-barang.store') }}" method="POST" id="form-pengeluaran-barang">
            @csrf
            <div id="data-hidden"></div>
            <div class="d-flex justify-content-between align-items-center p-4 border-bottom">
                <h3 class="card-title">Pengeluaran Barang</h3>

            </div>
            <div class="card-body">
                <div class=" d-flex">
                    <div class="w-100">
                        <label for="select2">Product</label>
                        <select name="select2" id="select2" class="form-control"></select>
                    </div>
                    <div>
                        <label for="">Stok Tersedia</label>
                        <input type="number" id="current_stok" class="form-control mx-2" style="width: 100px;" readonly>
                    </div>
                    <div>
                        <label for="">Harga</label>
                        <input type="number" id="harga" class="form-control mx-2" style="width: 100px;" readonly>
                    </div>
                    <div>
                        <label for="qty">Qty</label>
                        <input type="number" id="qty" class="form-control mx-2" style="width: 100px;" min="1">
                    </div>
                    <div style="padding-top: 32px">
                        <button type="button" class="btn btn-primary" id="btn-add">Tambah</button>
                    </div>
                </div>
            </div>
    </div>

    <div class="row">
        <div class=" card col-md-8">
            <table class="table table-sm" id="table_product">
                <thead>
                    <tr>
                        <th>Product</th>
                        <th>Qty</th>
                        <th>Sub Total</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>
        <div class="card col-md-4">
            <div>
                <label for="">total</label>
                <input type="number" class="form-control" id="total" readonly>
            </div>
            <div>
                <label for="">Total Pebayaran</label>
                <input type="number" class="form-control" name="bayar" id="bayar">
            </div>
            <div>
                <label for="">Kembalian</label>
                <input type="number" class="form-control" id="kembalian" readonly>
            </div>
            <div class="my-3">
                <button type="submit" class="btn btn-primary w-100">Simpan Transaksi</button>
            </div>
        </div>
        </form>
    </div>

@endsection
@push('scripts')
    <script>
        $(document).ready(function () {
            let selectedProduct = {};
 
            function hitungTotal() {
                let total = 0;
                $('#table_product tbody tr').each(function () {
                    const subTotal = parseInt($(this).find('td:eq(2)').text());
                    total += subTotal;
                });
                $('#total').val(total);
            }

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
                    $.ajax({
                        type: "GET",
                        url: "{{ route('get-data.cek-harga') }}",
                        data: {
                            id: id
                        },
                        dataType: "json",
                        success: function (response) {
                            $("#harga").val(response.harga);
                        }
                    });
                } else {
                    // Jika id kosong, reset nilai stok atau tampilkan pesan
                    $("#current_stok").val('');
                    $("#harga").val('');
                }
            });
            $('#btn-add').on('click', function () {
                let productId = $('#select2').val();
                let qty = $('#qty').val();
                let currentStok = $('#current_stok').val();
                let harga = $('#harga').val();
                let SubTotal = parseInt(qty) * parseInt(harga);

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
                                            <tr data-id="${productId}">
                                                <td>${product.name_product}</td>
                                                <td>${qty}</td>
                                                <td>${SubTotal}</td>
                                                <td>
                                                    <button class="btn btn-danger btn-sm btn-delete">Hapus</button>
                                                </td>
                                            </tr>`
                    $('#table_product tbody').append(row);
                }


                $('#select2').val(null).trigger('change');
                $('#qty').val('');
                $('#harga').val('');
                $('#current_stok').val('');
                hitungTotal();

            });


            $('#table_product').on('click', '.btn-delete', function () {
                $(this).closest('tr').remove();
                hitungTotal();
            });

            $('#form-pengeluaran-barang').on("submit", function () {
                $('#data-hidden').html("");

                $('#table_product tbody tr').each(function (index, row) {
                    const nameproduct = $(row).find('td:eq(0)').text();
                    const qty = $(row).find('td:eq(1)').text();
                    const productId = $(row).data("id");
                    const SubTotal = $(row).find('td:eq(2)').text();

                    const inputProduct = `<input type="hidden" name="produk[${index}][name_product]" value="${nameproduct}"/>`;
                    const inputQty = `<input type="hidden" name="produk[${index}][qty]" value="${qty}"/>`;
                    const inputProductId = `<input type="hidden" name="produk[${index}][id]" value="${productId}"/>`;
                    const inputSubTotal = `<input type="hidden" name="produk[${index}][sub_total]" value="${$(row).find('td:eq(2)').text()}"/>`;

                    $('#data-hidden').append(inputProduct).append(inputQty).append(inputProductId).append(inputSubTotal);

                });
            });

            $("#bayar").on("input", function () {
                let total = parseInt($("#total").val()) || 0;
                let bayar = parseInt($(this).val()) || 0;
                let kembalian = bayar - total;


                $("#kembalian").val(kembalian);
            });
        });
    </script>
@endpush
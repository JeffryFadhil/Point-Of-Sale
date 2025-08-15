@extends('layouts.app')
@section('content_title', 'Penerimaan Barang')
@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Penerimaan Barang</h3>
        </div>
        <div class="card-body">
            <div class=" d-flex">
                <select name="select2" id="select2" class="form-control"></select>
                <input type="number" name="current_stok" id="current_stok" class="form-control mx-2" style="width: 100px;"
                    readonly>
            </div>
        </div>
@endsection
    @push('scripts')
        <script>
            $(document).ready(function () {
                $('#select2').select2(
                    {
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
                    }
                )

            });
        </script>
    @endpush
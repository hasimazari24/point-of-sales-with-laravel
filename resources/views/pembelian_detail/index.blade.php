@extends('layouts.master')

@section('title')
Transaksi Pembelian
@endsection

@section('breadcrumb')
@parent
<li class="active">Transaksi Pembelian</li>
@endsection

@push('css')
<style>
    .tampil-bayar {
        font-size: 5em;
        text-align: center;
        height: 100px;
    }

    .tampil-terbilang {
        padding: 10px;
        background: #f0f0f0;
    }

    .table-pembelian tbody tr:last-child {
        display: none;
    }

    @media(max-width: 768px) {
        .tampil-bayar {
            font-size: 3em;
            height: 70px;
            padding-top: 5px;
        }
    }
</style>
@endpush

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="box">
            <div class="box-header with-border">
                <table>
                    <tr>
                        <td>Supplier</td>
                        <td>: {{ $supplier->nama }}</td>
                    </tr>
                    <tr>
                        <td>Telepon</td>
                        <td>: {{ $supplier->telepon }}</td>
                    </tr>
                    <tr>
                        <td>Alamat</td>
                        <td>: {{ $supplier->alamat }}</td>
                    </tr>
                </table>
                
            </div>
            <div class="box-body">
                <form class="form-produk">
                    @csrf
                    <div class="form-group row">
                        {{-- <div class="col-xs-3">
                            
                        </div> --}}
                        <label class="col-xs-2 control-label" for="kode_produk">Masukkan Kode Produk</label>
                        <div class="col-xs-4">
                            <div class="input-group">
                                <input type="hidden" name="id_pembelian" id="id_pembelian" value="{{ $id_pembelian }}">
                                <input type="hidden" name="id_produk" id="id_produk">
                                <input type="text" class="form-control" name="kode_produk" id="kode_produk">
                                <span class="input-group-btn">
                                    <button onclick="tampilProduk()" class="btn btn-info btn-flat" type="button"><i class="fa fa-arrow-right"></i></button>
                                </span>
                            </div>
                        </div>
                        
                    </div>
                </form>
                <div class="row">
                    <div class="col-md-12">
                        <table class="table table-stiped table-bordered table-pembelian">
                            <thead>
                                <th width="5%">No</th>
                                <th>Kode</th>
                                <th>Nama</th>
                                <th>Harga</th>
                                <th width="15%">Jumlah</th>
                                <th>Subtotal</th>
                                <th width="15%"><i class="fa fa-cog"></i></th>
                            </thead>
                        </table>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-8" style="padding-top:10px;">
                        <div class="tampil-bayar bg-primary">
                            
                        </div>
                        <div class="tampil-terbilang">
                            
                        </div>
                    </div>
                    <div class="col-md-4" style="padding-top:10px;">
                        <form action="{{ route('pembelian.store') }}" method="POST" class="form-pembelian" id="form-pembelian">
                            @csrf
                            <input type="hidden" name="id_pembelian" value="{{ $id_pembelian }}">
                            <input type="hidden" name="total" id="total">
                            <input type="hidden" name="total_item" id="total_item">
                            <input type="hidden" name="bayar" id="bayar">

                            <div class="form-group row">
                                <label for="totalrp" class="col-xs-3 control-label" style="text-align:right;">Total</label>
                                <div class="col-xs-9">
                                    <div class="input-group">
                                        <span class="input-group-addon">Rp.</span>
                                        <input type="text" id="totalrp" class="form-control" readonly>
                                    </div>
                                    
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="diskon" class="col-xs-3 control-label" style="text-align:right;">Diskon</label>
                                <div class="col-xs-9">
                                    <div class="input-group">
                                        <input type="number" name="diskon" id="diskon" class="form-control" value="{{ $diskon }}">
                                        <span class="input-group-addon">%</span>
                                    </div>
                                    
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="bayar" class="col-xs-3 control-label" style="text-align:right;">Bayar</label>
                                <div class="col-xs-9">
                                    <div class="input-group">
                                        <span class="input-group-addon">Rp.</span>
                                        <input type="text" id="bayarrp" class="form-control">
                                    </div>
                                    
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="box-footer">
                <button type="submit" class="btn btn-primary btn-sm btn-flat pull-right btn-simpan"><i class="fa fa-floppy-o"></i> Simpan Transaksi</button>
            </div>
        </div>
    </div>
</div>
@include('pembelian_detail.produk')
@endsection

@push('scripts') {{-- mempush/menambah assets ke scripts master layout --}}
    <script>
        //$('.table').DataTable();

        let table,table2;

        table = $('.table-pembelian').DataTable({
            processing: true,
            autoWidth: false,
            ajax: {
                url: '{{ route('pembelian_detail.data', $id_pembelian) }}',
            },
            columns: [
                {data: 'DT_RowIndex', searchable: false, sortable: false},
                {data: 'kode_produk'},
                {data: 'nama_produk'},
                {data: 'harga_beli'},
                {data: 'jumlah'},
                {data: 'sub_total'},
                {data: 'aksi', searchable: false, sortable: false},
            ],
            dom: 'Brt',
            bSort: false,
            paginate: false
        })
        .on('draw.dt', function () {
            loadForm($('#diskon').val());
        });
        // .on('draw.dt', function () {
        //     loadForm($('#diskon').val());
        // });
        table2 = $('.table-produk').DataTable();

        $(document).on('input', '.quantity', function(){
            let id_pembelian_detail = $(this).data('id');
            let jumlah = parseInt($(this).val());

            if(!$(this).val()){
                $(this).val(1);
            }

            if (jumlah < 1 ){
                $(this).val(1);
                const Toast = Swal.mixin({
                    toast: true,
                    position: 'top-right',
                    showConfirmButton: false,
                    timer: 3000,
                    timerProgressBar: true
                });
                Toast.fire({
                    icon: 'error',
                    text: 'Jumlah tidak boleh kurang dari 1'
                });
                return;
            }
            if(jumlah > 10000){
                $(this).val(10000);
                const Toast = Swal.mixin({
                    toast: true,
                    position: 'top-right',
                    showConfirmButton: false,
                    timer: 3000,
                    timerProgressBar: true
                    });
                Toast.fire({
                    icon: 'error',
                    text: 'Jumlah maksimal 10.000'
                });
                
                return;
            }

            // $.ajax({
            //     headers : 
            //     {
            //         'X-CSRF-TOKEN': $('[name=csrf-token]').attr('content')
            //     },
            //     url: `{{ url('/pembelian_detail/update') }}`,
            //     type : 'put',
            //     data: {
            //         'id_pembelian_detail' : id_pembelian_detail,
            //         'jumlah'  : jumlah
            //     },
            //     success: function (results) {
            //         $(".quantity").on('mouseout', function(){
            //             table.ajax.reload();
            //         })
                    
            //     },
            //     error: function (xhr) {
            //         swal.fire({
            //             icon : 'error',
            //             title: 'Terjadi Kesalahan!',
            //             text : xhr.responseJSON.message,
            //         });
            //         return;
            //     }
            // });
            $.post(`{{ url('/pembelian_detail/update') }}`, {
                    '_token': $('[name=csrf-token]').attr('content'),
                    '_method': 'put',
                    'id_pembelian_detail' : id_pembelian_detail,
                    'jumlah': jumlah
                })
                .done(response => {
                    $(this).on('mouseout', function () {
                        table.ajax.reload(()=> loadForm($('#diskon').val()));
                    });
                })
                .fail(errors => {
                    swal.fire('Terjadi Kesalahan!',errors.responseJSON.message,'error');
                    return;
                });
        })
        
        function tampilProduk(){
            $('#modal-produk').modal('show');
        }

        function hideProduk() {
            $('#modal-produk').modal('hide');
        }

        function pilihProduk(id, kode){
            if($('#id_produk').val() == id){
                swal.fire('Peringatan!','Produk sudah dimasukkan, pilih yang lain!','warning');
            }else{
                hideProduk();
                $('#id_produk').val(id);
                $('#kode_produk').val(kode);
                tambahProduk();
            }
        }

        function tambahProduk(){
            $.ajax({
                url: '{{ route('pembelian_detail.store') }}',
                type: 'post',
                data: $('.form-produk').serialize(),
                success: function (results) {
                    $('#kode_produk').focus();
                    table.ajax.reload(()=> loadForm($('#diskon').val()));
                },
                error: function (xhr) {
                    swal.fire({
                        icon : 'error',
                        title: 'Terjadi Kesalahan!',
                        text : xhr.responseJSON.message,
                    });
                    return;
                }
            });
             
        }

        $(document).on('input', '#diskon', function () {
            if ($(this).val() == "") {
                $(this).val(0).select();
            }

            loadForm($(this).val());
        });

        function deleteData(url){
            swal.fire({
                icon : 'question',
                title: 'Yakin hapus data terpilih?',
                showDenyButton: true,
                showCancelButton: false,
                confirmButtonText: 'Ya',
                denyButtonText: 'Tidak',
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url : url,
                        type : 'delete',
                        data : {_token : $('[name=csrf-token]').attr('content')},
                        success: function (results) {
                            table.ajax.reload(() => loadForm($('#diskon').val()));
                            $('#id_produk').val(0);
                        },
                        error: function (xhr) {
                            swal.fire('Terjadi Kesalahan!',xhr.responseJSON.message,'error');
                            return;
                        }
                    });
                }
            })
        }

        function loadForm(diskon = 0) {
            $('#total').val($('.total').text());
            $('#total_item').val($('.total_item').text());

            $.get(`{{ url('/pembelian_detail/loadform') }}/${diskon}/${$('.total').text()}`)
                .done(response => {
                    $('#totalrp').val(response.totalrp);
                    $('#bayarrp').val(response.bayarrp);
                    $('#bayar').val(response.bayar);
                    $('.tampil-bayar').text('Rp. '+ response.bayarrp);
                    $('.tampil-terbilang').text(response.terbilang);
                })
                .fail(errors => {
                    swal.fire('Terjadi Kesalahan!',errors.responseJSON.message,'error');
                    return;
                })
        }

        $('.btn-simpan').on('click', function () {
            //var data = table2.fnGetData();
            // console.log($('#total_item').val());
            if ($('#total_item').val() < 1){
                swal.fire({
                    icon : 'error',
                    title: 'Terjadi Kesalahan!',
                    text : 'Produk masih kosong, silahkan isi!',
                });
                return;
            } else {
                $.ajax({
                    url: $('#form-pembelian').attr('action'),
                    type: 'post',
                    data: $('#form-pembelian').serialize(),
                    success: function (results) {
                        swal.fire({
                            icon : 'success',
                            title: 'Sukses!',
                            text : results.message,
                        }).then(function() {
                            window.location.href = "{{ route('pembelian.index')}}";
                        });
                        
                    },
                    error: function (xhr) {
                        swal.fire({
                            icon : 'error',
                            title: 'Terjadi Kesalahan!',
                            text : xhr.responseJSON.message,
                        });
                        return;
                    }
                });
                // $('.form-pembelian').submit();
            }
            
        });

    </script>
@endpush
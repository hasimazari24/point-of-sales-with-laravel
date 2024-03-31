@extends('layouts.master')

@section('title')
Transaksi penjualan
@endsection

@section('breadcrumb')
@parent
<li class="active">Transaksi penjualan</li>
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

    .table-penjualan tbody tr:last-child {
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
            
            <div class="box-body">
                <form class="form-produk">
                    @csrf
                    <div class="form-group row">
                        <label for="kode_produk" class="col-lg-2">Kode Produk</label>
                        <div class="col-lg-5">
                            <div class="input-group">
                                <input type="hidden" name="id_penjualan" id="id_penjualan" value="{{ $id_penjualan }}">
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
                        <table class="table table-stiped table-bordered table-penjualan">
                            <thead>
                                <th width="5%">No</th>
                                <th>Kode</th>
                                <th>Nama</th>
                                <th>Harga</th>
                                <th width="15%">Jumlah</th>
                                <th>Diskon</th>
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
                        <form action="{{ route('transaksi.simpan') }}"  class="form-penjualan" method="post">
                            @csrf
                            <input type="hidden" name="id_penjualan" value="{{ $id_penjualan }}">
                            <input type="hidden" name="total" id="total">
                            <input type="hidden" name="total_item" id="total_item">
                            <input type="hidden" name="total_diskon" id="total_diskon">
                            <input type="hidden" name="bayar" id="bayar">
                            <input type="hidden" name="id_member" id="id_member" value="{{ $memberSelected->id_member }}">
                            {{-- diskon member --}}
                            <input type="hidden" name="diskon" id="diskon" class="form-control" 
                                        value="{{ !empty($memberSelected->id_member) ? $diskon : 0  }}">

                            <div class="form-group row">
                                <label for="totalrp" class="col-xs-3 control-label">Total</label>
                                <div class="col-xs-9">
                                    <div class="input-group">
                                        <span class="input-group-addon">Rp.</span>
                                        <input type="text" id="totalrp" class="form-control" readonly>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="kode_member" class="col-xs-3 control-label">Member</label>
                                <div class="col-xs-9">
                                    <div class="input-group">
                                        <input type="text" class="form-control" id="kode_member" 
                                            value="{{ $memberSelected->kode_member }}"
                                            {{-- value="" --}}
                                            >
                                        <span class="input-group-btn">
                                            <button onclick="tampilMember()" class="btn btn-info btn-flat" type="button"><i class="fa fa-arrow-right"></i></button>
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="diskon" class="col-xs-3 control-label">Diskon</label>
                                <div class="col-xs-9">
                                    <div class="input-group">
                                        <span class="input-group-addon">Rp. </span>
                                        <input type="number" name="diskonRp" id="diskonRp" class="form-control" readonly>
                                        
                                    </div>
                                    
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="bayarrp" class="col-xs-3 control-label">Bayar</label>
                                <div class="col-xs-9">
                                    <div class="input-group">
                                        <span class="input-group-addon">Rp.</span>
                                        <input type="text" id="bayarrp" class="form-control" readonly>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="diterima" class="col-xs-3 control-label">Diterima</label>
                                <div class="col-xs-9">
                                    <div class="input-group">
                                        <span class="input-group-addon">Rp.</span>
                                         <input type="number" id="diterima" class="form-control" name="diterima" value="{{ $penjualan->diterima ?? 0 }}">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="kembali" class="col-xs-3 control-label">Kembali</label>
                                <div class="col-xs-9">
                                    <div class="input-group">
                                        <span class="input-group-addon">Rp.</span>
                                        <input type="text" id="kembali" name="kembali" class="form-control" value="0" readonly>
                                    </div>
                                    
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="box-footer">
                <button type="button" class="btn btn-primary btn-sm btn-flat pull-right btn-simpan"><i class="fa fa-floppy-o"></i> Simpan Transaksi</button>
            </div>
        </div>
    </div>
</div>
@include('penjualan_detail.produk')
@include('penjualan_detail.member')
@endsection

@push('scripts') {{-- mempush/menambah assets ke scripts master layout --}}
    <script>
        //$('.table').DataTable();

        let table,table2;

        table = $('.table-penjualan').DataTable({
            responsive: true,
            processing: true,
            serverSide: true,
            autoWidth: false,
            ajax: {
                url: '{{ route('transaksi.data', $id_penjualan) }}',
            },
            columns: [
                {data: 'DT_RowIndex', searchable: false, sortable: false},
                {data: 'kode_produk'},
                {data: 'nama_produk'},
                {data: 'harga_jual'},
                {data: 'jumlah'},
                {data: 'diskon'},
                {data: 'subtotal'},
                {data: 'aksi', searchable: false, sortable: false},
            ],
            dom: 'Brt',
            bSort: false,
            paginate: false
        })
        .on('draw.dt', function () {
            loadForm($('#diskon').val());
            setTimeout(() => {
                $('#diterima').trigger('input');
            }, 300);
        });
        
        table2 = $('.table-produk').DataTable();

        $(document).on('input', '.quantity', function(){
            let id_penjualan_detail = $(this).data('id');
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

            $.post(`{{ url('/transaksi/update') }}`, {
                    '_token': $('[name=csrf-token]').attr('content'),
                    '_method': 'put',
                    'id_penjualan_detail' : id_penjualan_detail,
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
        });

        $(document).on('input', '#diskon', function () {
            if ($(this).val() == "") {
                $(this).val(0).select();
            }

            loadForm($(this).val());
        });

        $('#diterima').on('input', function () {
            if ($(this).val() == "") {
                $(this).val(0).select();
            }

            loadForm($('#diskon').val(), $(this).val());
        }).focus(function () {
            $(this).select();
        });
        
        function tampilProduk(){
            $('#modal-produk').modal('show');
        }

        function hideProduk() {
            $('#modal-produk').modal('hide');
        }

        function pilihProduk(id, kode){
            // if($('#id_produk').val() == id){
            //     swal.fire('Peringatan!','Produk sudah dimasukkan, pilih yang lain!','warning');
            // }else{
                hideProduk();
                $('#id_produk').val(id);
                $('#kode_produk').val(kode);
                tambahProduk();
            // }
        }

        function tambahProduk() {
            $.post('{{ route('transaksi.store') }}', $('.form-produk').serialize())
                .done(response => {
                    if(response.message == "produksama"){

                        // console.log(response['id_penjualan_detail']);
                        // $('input.quantity[data-id="'+ response['id_penjualan_detail'] +'"]').focus();
                        table.ajax.reload(function(){
                            loadForm($('#diskon').val());
                            $('input.quantity[data-id="'+ response['id_penjualan_detail'] +'"]').focus();
                        });
                        // $('.quantity').each(function(){
                        //     $(this).focus(function(){
                        //         $(this).data('id') = response['id_penjualan_detail'];
                        //     })
                        // });

                        // $(document).on('focus', '.quantity', function () {
                        //      $(this).data('id') = response['id_penjualan_detail'];
                        // });
                        // $( document ).ready(function() {
                        //     console.log( "ready!" );
                        //     $('input.quantity[data-id="'+ response['id_penjualan_detail'] +'"]').focus();
                        // })
                        


                    } else {
                        $('#kode_produk').focus();
                        table.ajax.reload(() => loadForm($('#diskon').val()));
                    }
                })
                .fail(errors => {
                    swal.fire('Terjadi Kesalahan!',errors.responseJSON.message,'error');
                    return;
                });
        }

        function tampilMember(){
            // 
            $('#modal-member').modal('show');
        }

        function pilihMember(id, kode) {
            $('#id_member').val(id);
            $('#kode_member').val(kode);
            $('#diskon').val('{{ $diskon }}');
            loadForm($('#diskon').val());
            $('#diterima').val(0).focus().select();
            hideMember();
        }

        function hideMember() {
            $('#modal-member').modal('hide');
        }

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
                            // $('#diterima').val(0);
                        },
                        error: function (xhr) {
                            swal.fire('Terjadi Kesalahan!',xhr.responseJSON.message,'error');
                            return;
                        }
                    });
                }
            })
        }

        function loadForm(diskon = 0, diterima = 0) {
            $('#total').val($('.total').text());
            $('#total_item').val($('.total_item').text());

            $.get(`{{ url('/transaksi/loadform') }}/${diskon}/${$('.total').text()}/${diterima}`)
                .done(response => {
                    // $('#totalrp').val(response.totalrp);
                    // $('#bayarrp').val(response.bayarrp);
                    // $('#bayar').val(response.bayar);
                    // $('.tampil-bayar').text('Bayar: Rp. '+ response.bayarrp);
                    // $('.tampil-terbilang').text(response.terbilang);

                    // $('#kembali').val('Rp.'+ response.kembalirp);
                    // if ($('#diterima').val() != 0) {
                    //     $('.tampil-bayar').text('Kembali: Rp. '+ response.kembalirp);
                    //     $('.tampil-terbilang').text(response.kembali_terbilang);
                    // }
                    $('#totalrp').val(response[0]['totalrp']);
                    $('#diskonRp').val(response[0]['diskonrp']);
                    $('#bayarrp').val(response[0]['bayarrp']);
                    $('#bayar').val(response[0]['bayar']);
                    $('.tampil-bayar').text('Bayar: Rp. ' + response[0]['bayarrp']);
                    $('.tampil-terbilang').text(response[0]['terbilang']);

                    $('#kembali').val(response[0]['kembalirp']);
                    if ($('#diterima').val() != 0) {
                        $('.tampil-bayar').text('Kembali: Rp. '+ response[0]['kembalirp']);
                        $('.tampil-terbilang').text(response[0]['kembali_terbilang']);
                    }
                })
                .fail(errors => {
                    swal.fire('Terjadi Kesalahan!', errors.responseJSON.message,'error');
                    return;
                })
        }

        $('.btn-simpan').on('click', function () {
            if ($('#total_item').val() < 1){
                swal.fire({
                    icon : 'error',
                    title: 'Terjadi Kesalahan!',
                    text : 'Produk masih kosong, silahkan isi!',
                });
                return;
            }else if ($('#diterima').val() < $('#bayarrp').val()){
                swal.fire({
                    icon : 'error',
                    title: 'Terjadi Kesalahan!',
                    text : 'Total diterima kurang dari total harus bayar!',
                });
                return;
            } else {
                $.post('{{ route('transaksi.simpan') }}', $('.form-penjualan').serialize())
                    .done(response => {
                        swal.fire({
                            icon : 'success',
                            title: 'Sukses!',
                            text : response.message,
                        }).then(function() {
                            window.location.href = "{{ route('transaksi.selesai')}}";
                        });
                    })
                    .fail(errors => {
                        swal.fire('Terjadi Kesalahan!',errors.responseJSON.message,'error');
                        return;
                    });
                // $('.form-penjualan').submit();
            }
        });

    </script>
@endpush
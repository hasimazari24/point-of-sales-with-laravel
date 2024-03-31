@extends('layouts.master')

@section('title')
Produk
@endsection

@section('breadcrumb')
@parent
<li class="active">Produk</li>
@endsection

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="box">
            <div class="box-header with-border">
                {{-- <div class="btn-group"> --}}
                    <button onclick="addForm('{{ route('produk.store') }}')" class="btn btn-success btn-xs btn-flat"><i class="fa fa-plus-circle"></i> Tambah</button>
                    <button onclick="deleteSelected('{{ route('produk.delete_selected') }}')" class="btn btn-danger btn-xs btn-flat"><i class="fa fa-trash"></i> Hapus</button>
                    <button onclick="cetakBarcode('{{ route('produk.cetak_barcode') }}')" class="btn bg-teal btn-xs btn-flat"><i class="fa fa-barcode"></i> Cetak Barcode</button>
                {{-- </div> --}}
                
            </div>
            <div class="box-body table-responsive">
                <form action="" method="post" class="form-produk">
                    @csrf
                    <table class="table table-stiped table-bordered">
                        <thead>
                            <th>
                                <input type="checkbox" name="select_all" id="select_all" checked>
                            </th>
                            <th width="5%">No</th>
                            <th>Kode Produk</th>
                            <th>Nama Produk</th>
                            <th>Kategori</th>
                            <th>Merk</th>
                            <th>Harga Beli</th>
                            <th>Harga Jual</th>
                            <th>Diskon</th>
                            <th>Stok</th>
                            <th width="15%"><i class="fa fa-cog"></i></th>
                        </thead>
                    </table>
                </form>
            </div>
        </div>
    </div>
</div>
@include('produk.form')
@endsection

@push('scripts') {{-- mempush/menambah assets ke scripts master layout --}}
    <script>
        //$('.table').DataTable();

        let table;
        $('input[type=checkbox]').removeAttr('checked');

        $(function(){
            $('#modal-form').validator();
            table = $('.table').DataTable({
                processing : true,
                autoWidth : false,
                ajax : {
                    url : '{{ route('produk.data') }}', //memperoleh data melalui route yg sudah dibuat
                },
                columns : [
                    {data : 'select_all',searchable:false, sortable:false},
                    {data : 'DT_RowIndex', searchable:false, sortable:false},
                    {data : 'kode_produk'},
                    {data : 'nama_produk'},
                    {data : 'nama_kategori'},
                    {data : 'merk'},
                    {data : 'harga_beli'},
                    {data : 'harga_jual'},
                    {data : 'diskon'},
                    {data : 'stok'},
                    {data : 'aksi',searchable:false, sortable:false},
                ]
            });
                        
            
            $('#modal-form').validator().on('submit', function (e){
                if (! e.preventDefault()) {
                    $.ajax({
                        url: $('#modal-form form').attr('action'),
                        type: 'post',
                        data: $('#modal-form form').serialize(),
                        success: function (results) {
                            swal.fire({
                                icon : 'success',
                                title: 'Sukses!',
                                text : results.message,
                            });
                            $('#modal-form').modal('hide');
                            table.ajax.reload();
                            $('input[type=checkbox]').removeAttr('checked');
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
            });
            
            //trigger agar satu checkbox bisa checked semua box
            $('[name=select_all]').on('click', function(){
                $(':checkbox').prop('checked', this.checked);
            });
            
        });
        
        function addForm(url){
            $('#modal-form').modal('show');
            $('#modal-form .modal-title').text("Tambah Produk");

            $('#modal-form form')[0].reset();
            $('#modal-form form').attr('action', url);
            $('#modal-form [name=_method]').val('post');
            $('#modal-form [name=nama_produk]').focus();
        }

        function editForm(url){
            $('#modal-form').modal('show');
            $('#modal-form .modal-title').text("Edit Produk");

            $('#modal-form form')[0].reset();
            $('#modal-form form').attr('action', url);
            $('#modal-form [name=_method]').val('put');
            $('#modal-form [name=nama_produk]').focus();
            
            $.get(url)
            .done((response) => {
                //console.log((response));
                $('#modal-form [name=nama_produk]').val(response.nama_produk);
                $('#modal-form [name=id_kategori]').val(response.id_kategori);
                $('#modal-form [name=merk]').val(response.merk);
                $('#modal-form [name=harga_beli]').val(response.harga_beli);
                $('#modal-form [name=harga_jual]').val(response.harga_jual);
                $('#modal-form [name=diskon]').val(response.diskon);
                $('#modal-form [name=stok]').val(response.stok);
            })
            .fail((errors) =>{
                swal.fire("Error!", "Tidak dapat tampil", "error");
                return;
            })
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
                            swal.fire('Sukses!',results.message,'success');
                            table.ajax.reload();
                        },
                        error: function (xhr) {
                            swal.fire('Terjadi Kesalahan!',xhr.responseJSON.message,'error');
                            return;
                        }
                    });
                }
            })
        }

        function deleteSelected(url){ 
            if ($('.idcheck:checked').length > 1) {
                swal.fire({
                    icon : 'question',
                    title: 'Yakin hapus data terpilih?',
                    showDenyButton: true,
                    showCancelButton: false,
                    confirmButtonText: 'Ya',
                    denyButtonText: 'Tidak',
                }).then((result) => {
                    if (result.isConfirmed) {
                        var data = $('.form-produk').serialize();
                        $.ajax({
                            headers : {
                                'X-CSRF-TOKEN': $('[name=csrf-token]').attr('content')
                            },
                            url : url,
                            type : 'post',
                            data : $('.form-produk').serialize(),
                            success: function (results) {
                                swal.fire('Sukses!',results.message,'success');
                                table.ajax.reload();
                            },
                            error: function (xhr) {
                                swal.fire('Terjadi Kesalahan!',xhr.responseJSON.message,'error');
                                return;
                            }
                        });
                    }
                })
                // if(confirm('Yakin ingin menghapus data terpilih?')){
                //     $.post(url, $('.form-produk').serialize())
                //         .done((response) => {
                //             table.ajax.reload();
                //         })
                //         .fail((errors) => {
                //             alert('Tidak dapat hapus');
                //             return;
                //         });
                // }
            } else {
                swal.fire("Peringatan!", "Pilih lebih dari 1 data yang mau dihapus!", "warning");
                return;
            }
        }

        function cetakBarcode(url){
            if ($('.idcheck:checked').length < 1) {
                swal.fire("Peringatan!", "Pilih data yang akan dicetak!", "warning");
                return;
            } else if ($('.idcheck:checked').length < 3) {
                swal.fire("Peringatan!", "Pilih minimal 3 data untuk dicetak!", "warning");
                return;
            } else {
                $('.form-produk')
                    .attr('target', '_blank')
                    .attr('action', url)
                    .submit();
            }
        }

    </script>
@endpush
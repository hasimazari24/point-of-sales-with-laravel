@extends('layouts.master')

@section('title')
Supplier
@endsection

@section('breadcrumb')
@parent
<li class="active">Supplier</li>
@endsection

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="box">
            <div class="box-header with-border">
                {{-- <div class="btn-group"> --}}
                    <button onclick="addForm('{{ route('supplier.store') }}')" class="btn btn-success btn-xs btn-flat"><i class="fa fa-plus-circle"></i> Tambah</button>
                    
                {{-- </div> --}}
                
            </div>
            <div class="box-body table-responsive">
                <form action="" method="post" class="form-member">
                    @csrf
                    <table class="table table-stiped table-bordered">
                        <thead>
                            <th width="5%">No</th>
                            <th>Nama Supplier</th>
                            <th>Alamat</th>
                            <th>Telepon</th>
                            <th width="15%"><i class="fa fa-cog"></i></th>
                        </thead>
                    </table>
                </form>
            </div>
        </div>
    </div>
</div>
@include('supplier.form')
@endsection

@push('scripts') {{-- mempush/menambah assets ke scripts master layout --}}
    <script>
        //$('.table').DataTable();

        let table;

        $(function(){
            $('#modal-form').validator();
            table = $('.table').DataTable({
                processing : true,
                autoWidth : false,
                ajax : {
                    url : '{{ route('supplier.data') }}', //memperoleh data melalui route yg sudah dibuat
                },
                columns : [
                    {data : 'DT_RowIndex', searchable:false, sortable:false},
                    {data : 'nama'},
                    {data : 'alamat'},
                    {data : 'telepon'},
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
        });
        
        function addForm(url){
            $('#modal-form').modal('show');
            $('#modal-form .modal-title').text("Tambah Supplier");

            $('#modal-form form')[0].reset();
            $('#modal-form form').attr('action', url);
            $('#modal-form [name=_method]').val('post');
            $('#modal-form [name=nama_supplier]').focus();
        }

        function editForm(url){
            $('#modal-form').modal('show');
            $('#modal-form .modal-title').text("Edit Supplier");

            $('#modal-form form')[0].reset();
            $('#modal-form form').attr('action', url);
            $('#modal-form [name=_method]').val('put');
            $('#modal-form [name=nama_supplier]').focus();
            
            $.get(url)
            .done((response) => {
                console.log((response));
                $('#modal-form [name=nama_supplier]').val(response.nama);
                $('#modal-form [name=alamat]').val(response.alamat);
                $('#modal-form [name=telepon]').val(response.telepon);
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

    </script>
@endpush
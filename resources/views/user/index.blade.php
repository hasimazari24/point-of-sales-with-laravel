@extends('layouts.master')

@section('title')
Manajamen User
@endsection

@section('breadcrumb')
@parent
<li class="active">Manajamen User</li>
@endsection

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="box">
            <div class="box-header with-border">
                {{-- <div class="btn-group"> --}}
                    <button onclick="addForm('{{ route('user.store') }}')" class="btn btn-success btn-xs btn-flat"><i class="fa fa-plus-circle"></i> Tambah</button>
                    
                {{-- </div> --}}
                
            </div>
            <div class="box-body table-responsive">
                <form action="" method="post" class="form-member">
                    @csrf
                    <table class="table table-stiped table-bordered">
                        <thead>
                            <th width="5%">No</th>
                            <th>Nama</th>
                            <th>E-mail</th>
                            <th width="15%"><i class="fa fa-cog"></i></th>
                        </thead>
                    </table>
                </form>
            </div>
        </div>
    </div>
</div>
@include('user.form')
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
                    url : '{{ route('user.data') }}', //memperoleh data melalui route yg sudah dibuat
                },
                columns : [
                    {data : 'DT_RowIndex', searchable:false, sortable:false},
                    {data : 'name'},
                    {data : 'email'},
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
            $('#modal-form .modal-title').text("Tambah user");

            $('#modal-form form')[0].reset();
            $('#modal-form form').attr('action', url);
            $('#modal-form [name=_method]').val('post');
            $('#modal-form [name=name]').focus();

            $('#password, #password_confirmation').attr('required', true);
        }

        function editForm(url){
            $('#modal-form').modal('show');
            $('#modal-form .modal-title').text("Edit user");

            $('#modal-form form')[0].reset();
            $('#modal-form form').attr('action', url);
            $('#modal-form [name=_method]').val('put');
            $('#modal-form [name=name]').focus();

            $('#password, #password_confirmation').attr('required', false);
            
            $.get(url)
            .done((response) => {
                console.log((response));
                $('#modal-form [name=name]').val(response.name);
                $('#modal-form [name=email]').val(response.email);
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
                            if(results.message == 'Admin1'){
                                swal.fire('Peringatan!','Tidak bisa dihapus karena user admin level 1','warning');
                            } else {
                                swal.fire('Sukses!',results.message,'success');
                            }
                            
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
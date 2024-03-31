@extends('layouts.master')

@section('title')
Kategori
@endsection

@section('breadcrumb')
@parent
<li class="active">Kategori</li>
@endsection

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="box">
            <div class="box-header with-border">
                <button onclick="addForm('{{ route('kategori.store') }}')" class="btn btn-success btn-xs btn-flat"><i class="fa fa-plus-circle"></i> Tambah</button>
            </div>
            <div class="box-body table-responsive">
                <table class="table table-stiped table-bordered">
                    <thead>
                        <th width="5%">No</th>
                        <th>Kategori</th>
                        <th width="15%"><i class="fa fa-cog"></i></th>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@include('kategori.form')
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
                    url : '{{ route('kategori.data') }}', //memperoleh data melalui route yg sudah dibuat
                },
                columns : [
                    {data : 'DT_RowIndex', searchable:false, sortable:false},
                    {data : 'nama_kategori'},
                    {data : 'aksi',searchable:false, sortable:false},
                ]
            });
                        
            
            $('#modal-form').validator().on('submit', function (e){
                // if (! e.preventDefault()) {
                    
                //     swal.fire({
                //         icon: 'info',
                //           title: 'Simpan Data',
                //           showDenyButton: false,
                //           showCancelButton: false,
                //           confirmButtonText: 'Yes'
                //     }).then((result) => {
                //         $.ajax({
                //             url: $('#modal-form form').attr('action'),
                //             type: 'post',
                //             data: $('#modal-form form').serialize(),
                //             success: function (results) {
                //                 if (results.success === true) {
                //                     swal.fire("Done!", results.message, "success");
                //                     // refresh page after 2 seconds
                //                     // setTimeout(function(){
                //                     //     location.reload();
                //                     // },2000);
                //                 } else {
                //                     swal.fire("Error!", results.message, "error");
                //                 }
                //             }
                //         });
                //     });
                // }
                
                // if (! e.preventDefault()) {
                //     $.ajax({
                //         url: $('#modal-form form').attr('action'),
                //         type: 'post',
                //         data: $('#modal-form form').serialize()
                //     })
                    // .done((response) => {
                    //     $('#modal-form').modal('hide');
                    //     table.ajax.reload();
                    // })
                    // .fail((errors) => {
                    //     alert('Tidak dapat menyimpan data');
                    //     return;
                    // });
                // }
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
            $('#modal-form .modal-title').text("Tambah Kategori");

            $('#modal-form form')[0].reset();
            $('#modal-form form').attr('action', url);
            $('#modal-form [name=_method]').val('post');
            $('#modal-form [name=nama_kategori]').focus();
        }

        function editForm(url){
            $('#modal-form').modal('show');
            $('#modal-form .modal-title').text("Edit Kategori");

            $('#modal-form form')[0].reset();
            $('#modal-form form').attr('action', url);
            $('#modal-form [name=_method]').val('put');
            $('#modal-form [name=nama_kategori]').focus();
            
            $.get(url)
            .done((response) => {
                //console.log((response));
                $('#modal-form [name=nama_kategori]').val(response.nama_kategori);
            })
            .fail((errors) =>{
                swal.fire("Error!", "Tidak dapat tampil", "error");
                return;
            })
        }

        function deleteData(url){
            var urls = url;
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
                        url : urls,
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
            // if(confirm('Yakin hapus data terpilih?')){
            //     $.post(url, {
            //         '_token' : $('[name=csrf-token]').attr('content'),
            //         '_method' : 'delete'
            //     })
            //     .done((response) => {
            //         table.ajax.reload();
            //     })
            //     .fail((errors) => {
            //         alert('Tidak dapat menghapus data');
            //         return;
            //     });
            // }
        }

    </script>
@endpush
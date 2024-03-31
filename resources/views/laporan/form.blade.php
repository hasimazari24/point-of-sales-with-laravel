<!-- Modal -->
<div class="modal fade" id="modal-form" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <form action="{{ route('laporan.index') }}" method="get" data-toggle="validator" class="form-horizontal">
            @csrf
            @method('post')
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Modal title</h4>
                </div>
                <div class="modal-body">

                    <div class="form-group">
                        <label for="tanggal_awal" class="col-sm-3 control-label">Tanggal Awal</label>
                        <div class="col-sm-8">
                            <div class="input-group">
                            <div class="input-group-addon">
                                <i class="fa fa-calendar"></i>
                            </div>
                            <input type="text" class="form-control datepicker" id="tanggal_awal" name="tanggal_awal" 
                            value="{{ request('tanggal_awal') ?? $tanggalAwal }}">
                        </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="tanggal_awal" class="col-sm-3 control-label">Tanggal Akhir</label>
                        <div class="col-sm-8">
                            <div class="input-group">
                            <div class="input-group-addon">
                                <i class="fa fa-calendar"></i>
                            </div>
                            <input type="text" class="form-control datepicker" id="tanggal_akhir" name="tanggal_akhir"
                            value="{{ request('tanggal_akhir') ?? date('Y-m-d') }}">
                            </div>
                        </div>
                    </div>
                    
                </div>
                <div class="modal-footer">
                    <button class="btn btn-sm btn-flat btn-primary"><i class="fa fa-save"></i> Simpan</button>
                    <button type="button" class="btn btn-sm btn-flat btn-warning" data-dismiss="modal"><i class="fa fa-arrow-circle-left"> </i>&nbsp;Batal</button>

                </div>
            </div>
        </form>
    </div>
</div>
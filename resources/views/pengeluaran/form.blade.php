<!-- Modal -->
<div class="modal fade" id="modal-form" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <form role="form" action="" method="post" class="form-horizontal">
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
                        <label for="deskripsi" class="col-sm-3 control-label">Deskripsi</label>
                        <div class="col-sm-8">
                            <input class="form-control" id="deskripsi" name="deskripsi" required autofocus>
                            <span class="help-block with-errors"></span>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="nominal" class="col-sm-3 control-label">Nominal</label>
                        <div class="col-sm-8">
                            <div class="input-group">
                                <span class="input-group-addon">Rp.</span>
                                <input type="number" class="form-control" id="nominal" name="nominal" required>
                                <span class="help-block with-errors"></span>
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
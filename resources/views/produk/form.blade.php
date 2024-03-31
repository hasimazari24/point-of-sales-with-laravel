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
                        <label for="nama_produk" class="col-sm-3 control-label">Nama Produk</label>
                        <div class="col-sm-8">
                            <input class="form-control" id="nama_produk" name="nama_produk" required autofocus>
                            <span class="help-block with-errors"></span>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="id_kategori" class="col-sm-3 control-label">Kategori</label>
                        <div class="col-sm-8">
                            <select name="id_kategori" id="id_kategori" class="form-control" required>
                                <option value="">Pilih Kategori</option>
                                @foreach ($kategori as $key => $item)
                                    <option value="{{ $key }}">{{ $item }}</option>
                                @endforeach
                            </select>
                            <span class="help-block with-errors"></span>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="merk" class="col-sm-3 control-label">Merk</label>
                        <div class="col-sm-8">
                            <input class="form-control" id="merk" name="merk">
                            <span class="help-block with-errors"></span>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="harga_beli" class="col-sm-3 control-label">Harga Beli</label>
                        <div class="col-sm-8">
                            <div class="input-group">
                                <span class="input-group-addon">Rp.</span>
                                <input type="number" class="form-control" id="harga_beli" name="harga_beli" required>
                                <span class="help-block with-errors"></span>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="harga_jual" class="col-sm-3 control-label">Harga Jual</label>
                        <div class="col-sm-8">
                            <div class="input-group">
                                <span class="input-group-addon">Rp.</span>
                                <input type="number" class="form-control" id="harga_jual" name="harga_jual" required>
                                <span class="help-block with-errors"></span>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="diskon" class="col-sm-3 control-label">Diskon</label>
                        <div class="col-sm-8">
                            <input type="number" class="form-control" id="diskon" name="diskon" value="0">
                            <span class="help-block with-errors"></span>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="stok" class="col-sm-3 control-label">Stok</label>
                        <div class="col-sm-8">
                            <input type="number" class="form-control" id="stok" name="stok" required>
                            <span class="help-block with-errors"></span>
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
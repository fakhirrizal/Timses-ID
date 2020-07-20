<form role="form" class="form-horizontal" action="<?=base_url('member_side/perbarui_target_suara');?>" method="post"  enctype='multipart/form-data'>
    <input type="hidden" name="id_event" value="<?=$id_event;?>">
    <input type="hidden" name="id_desa" value="<?=$id_desa;?>">
    <input type="hidden" name="id_kecamatan" value="<?=$data_desa['idKecamatan'];?>">
    <input type="hidden" name="namadesa" value="<?=$data_desa['namaDesa'];?>">
    <div class="form-body">
        <div class="form-group form-md-line-input has-danger">
            <label class="col-md-2 control-label" for="form_control_1">Desa/ Kelurahan </label>
            <div class="col-md-10">
                <div class="input-icon">
                    <input type="text" class="form-control" value='<?= $data_desa['namaDesa']; ?>' readonly>
                    <div class="form-control-focus"> </div>
                    <span class="help-block">Some help goes here...</span>
                    <i class="icon-pin"></i>
                </div>
            </div>
        </div>
        <div class="form-group form-md-line-input has-danger">
            <label class="col-md-2 control-label" for="form_control_1">Target Relawan <span class="required"> * </span></label>
            <div class="col-md-10">
                <div class="input-icon">
                    <input type="number" class="form-control" name="relawan" placeholder="Type something" value='<?= $data_utama->relawan; ?>' required>
                    <div class="form-control-focus"> </div>
                    <span class="help-block">Some help goes here...</span>
                    <i class="icon-layers"></i>
                </div>
            </div>
        </div>
        <div class="form-group form-md-line-input has-danger">
            <label class="col-md-2 control-label" for="form_control_1">Target Rekrutmen <span class="required"> * </span></label>
            <div class="col-md-10">
                <div class="input-icon">
                    <input type="number" class="form-control" name="rekrutmen" placeholder="Type something" value='<?= $data_utama->rekrutmen; ?>' required>
                    <div class="form-control-focus"> </div>
                    <span class="help-block">Some help goes here...</span>
                    <i class="icon-layers"></i>
                </div>
            </div>
        </div>
    </div>
    <br>
    <div class="form-actions margin-top-10">
        <div class="row">
            <div class="col-md-offset-2 col-md-10">
                <button type="reset" class="btn default">Batal</button>
                <button type="submit" class="btn blue">Simpan</button>
            </div>
        </div>
    </div>
</form>
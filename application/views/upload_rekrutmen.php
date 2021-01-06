<form role="form" action="<?php echo base_url()."User/impor"; ?>" method='post' enctype="multipart/form-data">
    <div class="modal-body">
        <div class="form-body">
            <div class="form-group form-md-line-input has-danger">
                <label class="col-md-3 control-label" for="form_control_1">File Import <span class="required"> * </span></label>
                <div class="col-md-9">
                    <div class="input-icon">
                        <input class="form-control" type="file" name='fmasuk' required>
                        <input type="hidden" name="<?=$this->security->get_csrf_token_name();?>" value="<?=$this->security->get_csrf_hash();?>">
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
        <button type="submit" class="btn btn-primary">Unggah</button>
    </div>
</form>
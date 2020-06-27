<div class="row">
            <!-- Column -->
    <div class="col-lg-12 col-md-12">
        <div class="card">
            <div class="card-block">
                <div class="row">
                    <div class="col-12">
                        <div align="center" class="d-flex flex-wrap">
                            <div align="center">
                                <h2 class="card-title" align="center">Struktur Organisasi</h2>
                            </div>
                            <?php if ($this->session->userdata('admin_level') == '1' OR $this->session->userdata('admin_level') == '2') { ?>
                            <div class="ml-auto">
                                <a href="<?= base_url()."admin/master/sturktur_or/edit/1" ?>" class="btn waves-effect waves-light btn-danger pull-right hidden-sm-down">Ubah Data</a>
                            </div>
                            <?php } ?>
                        </div>
                    </div>
                    <div class="col-12">
                        <p> <?= $data['struktur_organisasi'] ?> </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
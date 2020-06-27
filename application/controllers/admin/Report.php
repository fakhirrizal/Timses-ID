<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Report extends CI_Controller {
    function __construct() {
        parent::__construct();
    }
    /* Kube (Kelompok Usaha Bersama) */
    public function kube(){
        $data['parent'] = 'report';
        $data['child'] = 'kube';
        $data['grand_child'] = '';
        $this->load->view('admin/template/header',$data);
        $this->load->view('admin/report/kube',$data);
        $this->load->view('admin/template/footer');
    }
    public function json_kube(){
        $jumlah_indikator = $this->Main_model->getSelectedData('indikator a', 'a.*')->result();
        $get_data = $this->Main_model->getSelectedData('kube a', 'a.*,b.jenis_usaha,c.nm_provinsi,d.nm_kabupaten,e.nm_kecamatan,f.nm_desa,g.*',array('a.deleted'=>'0'),'','','','',array(
            array(
                'table' => 'jenis_usaha b',
                'on' => 'a.id_jenis_usaha=b.id_jenis_usaha',
                'pos' => 'LEFT'
            ),
            array(
                'table' => 'provinsi c',
                'on' => 'a.id_provinsi=c.id_provinsi',
                'pos' => 'LEFT'
            ),
            array(
                'table' => 'kabupaten d',
                'on' => 'a.id_kabupaten=d.id_kabupaten',
                'pos' => 'LEFT'
            ),
            array(
                'table' => 'kecamatan e',
                'on' => 'a.id_kecamatan=e.id_kecamatan',
                'pos' => 'LEFT'
            ),
            array(
                'table' => 'desa f',
                'on' => 'a.id_desa=f.id_desa',
                'pos' => 'LEFT'
            ),
            array(
                'table' => 'status_laporan_kube g',
                'on' => 'a.id_kube=g.id_kube',
                'pos' => 'RIGHT'
            )
        ))->result();
        $data_tampil = array();
        $no = 1;
        foreach ($get_data as $key => $value) {
            // $get_realisasi_fisik = ($value->jumlah_fisik/count($jumlah_indikator))*100;
            // $get_total_uang_keluar = ($value->jumlah_uang/$value->rencana_anggaran)*100;
            $isi['checkbox'] =	'
                                <label class="mt-checkbox mt-checkbox-single mt-checkbox-outline">
                                    <input type="checkbox" class="checkboxes" name="selected_id[]" value="'.$value->id_kube.'"/>
                                    <span></span>
                                </label>
                                ';
            $isi['number'] = $no++.'.';
            $isi['id_kube'] = $value->nama_tim;
            $isi['realisasi_fisik'] = number_format($value->persentase_fisik,2).'%';
            $isi['rencana_anggaran'] = 'Rp '.number_format($value->rencana_anggaran,2);
            $isi['realisasi_anggaran'] = 'Rp '.number_format($value->anggaran,2);
            $isi['persentase_anggaran'] = number_format($value->persentase_anggaran,2).'%';
            $isi['aksi'] =	'
                                <div class="dropdown">
                                    <button class="btn btn-xs green dropdown-toggle" type="button" data-toggle="dropdown" aria-expanded="false"> Aksi
                                        <i class="fa fa-angle-down"></i>
                                    </button>
                                    <ul class="dropdown-menu pull-right" role="menu">
                                        <li>
                                            <a href="'.site_url('admin_side/detil_laporan_kube/'.md5($value->id_kube)).'">
                                                <i class="icon-eye"></i> Detil Data </a>
                                        </li>
                                    </ul>
                                </div>
                                ';
            // $isi['persentase_realisasi'] = number_format($value->persentase_realisasi,2).'%';
            $data_tampil[] = $isi;
        }
        $results = array(
            "sEcho" => 1,
            "iTotalRecords" => count($data_tampil),
            "iTotalDisplayRecords" => count($data_tampil),
            "aaData"=>$data_tampil);
        echo json_encode($results);
    }
    public function add_kube_report(){
        $data['parent'] = 'report';
        $data['child'] = 'kube';
        $data['grand_child'] = '';
        $data['kube'] = $this->Main_model->getSelectedData('kube a', 'a.*,e.nm_kabupaten', array('a.deleted'=>'0'),'','','','',array(
            'table' => 'kabupaten e',
            'on' => 'a.id_kabupaten=e.id_kabupaten',
            'pos' => 'left'
        ))->result();
        $data['indikator'] = $this->Main_model->getSelectedData('master_indikator a', 'a.*')->result();
        $this->load->view('admin/template/header',$data);
        $this->load->view('admin/report/add_kube_report',$data);
        $this->load->view('admin/template/footer');
    }
    public function save_kube_report(){
        $this->db->trans_start();
        $get_id_laporan_kube = $this->Main_model->getLastID('laporan_kube','id_laporan_kube');
        $get_data_kube = $this->Main_model->getSelectedData('kube a', 'a.*,(SELECT k.id_anggota_kube FROM anggota_kube k WHERE k.id_kube=a.id_kube AND k.jabatan_kelompok="Ketua") AS ketua,(SELECT i.user_id FROM anggota_kube i WHERE i.id_kube=a.id_kube AND i.jabatan_kelompok="Ketua") AS id_ketua', array('a.id_kube'=>$this->input->post('id_kube')))->row();
        $indikator = $this->Main_model->getSelectedData('master_indikator a', 'a.*')->result();
        $data_indikator = $this->Main_model->getSelectedData('indikator a', 'a.*', array('a.program'=>'1'))->result();
        $total_uang = 0;
        $get_indikator = array();
        foreach ($indikator as $key => $value) {
            $push = $this->input->post('progres_keuangan_'.$value->id_master_indikator);
            if($push==NULL){
                echo'';
            }else{
                $total_uang += $this->input->post('progres_keuangan_'.$value->id_master_indikator);
                $data_insert2b = array(
                    'id_laporan_kube' => $get_id_laporan_kube['id_laporan_kube']+1,
                    'id_master_indikator' => $value->id_master_indikator,
                    'progres_keuangan' => $this->input->post('progres_keuangan_'.$value->id_master_indikator)
                );
                // print_r($data_insert2b);
                $this->Main_model->insertData('detail_laporan_kube_aspek_keuangan',$data_insert2b);
            }
        }
        foreach ($data_indikator as $key => $value) {
            $push = $this->input->post('indikator_progres_fisik_'.$value->id_indikator);
            if($push==NULL){
                echo'';
            }else{
                array_push($get_indikator,implode(',',$this->input->post('indikator_progres_fisik_'.$value->id_indikator)));
                $data_insert2a = array(
                    'id_laporan_kube' => $get_id_laporan_kube['id_laporan_kube']+1,
                    'id_master_indikator' => $value->id_master_indikator,
                    'indikator_progres_fisik' => $value->id_indikator,
                    'penjelasan_progres_fisik' => $this->input->post('penjelasan_progres_fisik_'.$value->id_indikator)
                );
                // print_r($data_insert2a);
                $this->Main_model->insertData('detail_laporan_kube_aspek_fisik',$data_insert2a);
            }
        }
        $tampung_indikator = implode(',',$get_indikator);
        $explode_indikator = explode(',',$tampung_indikator);
        $get_status_laporan_kube = $this->Main_model->getSelectedData('status_laporan_kube a', 'a.*', array('a.id_kube'=>$this->input->post('id_kube')))->row();
        $persentase_fisik = (count($explode_indikator)/count($data_indikator))*100;
        $data_insert1 = array(
            'id_laporan_kube' => $get_id_laporan_kube['id_laporan_kube']+1,
            'id_anggota_kube' => $get_data_kube->ketua,
            'user_id' => $get_data_kube->id_ketua,
            'id_kube' => $this->input->post('id_kube'),
            'indikator' => $tampung_indikator,
            'persentase_fisik' => $persentase_fisik,
            'anggaran' => $total_uang,
            'persentase_anggaran' => ($total_uang/$get_data_kube->rencana_anggaran)*100,
            'persentase_realisasi' => ((($total_uang/$get_data_kube->rencana_anggaran)*100)+$persentase_fisik)/2,
            'keterangan' => $this->input->post('keterangan'),
            'created_at' => date('Y-m-d H:i:s'),
            'created_by' => $this->session->userdata('id')
        );
        // print_r($data_insert1);
        $this->Main_model->insertData('laporan_kube',$data_insert1);
        if($get_status_laporan_kube==NULL){
            $persentase_anggaran = ($total_uang/$get_data_kube->rencana_anggaran)*100;
            $persentase_realisasi = ($persentase_anggaran+$persentase_fisik)/2;
            $data_insert3 = array(
                'id_kube' => $this->input->post('id_kube'),
                'indikator' => $tampung_indikator,
                'persentase_fisik' => $persentase_fisik,
                'anggaran' => $total_uang,
                'persentase_anggaran' => $persentase_anggaran,
                'persentase_realisasi' => $persentase_realisasi
            );
            // print_r($data_insert3);
            $this->Main_model->insertData('status_laporan_kube',$data_insert3);
        }else{
            $bb = explode(',',$get_status_laporan_kube->indikator);
            $c = array_unique(array_merge($get_indikator,$bb));
            $d = implode(',',$c);
            $persentase_fisik2 = (count($c)/count($data_indikator))*100;
            $persentase_anggaran = (($total_uang+$get_status_laporan_kube->anggaran)/$get_data_kube->rencana_anggaran)*100;
            $persentase_realisasi = ($persentase_anggaran+$persentase_fisik2)/2;
            $data_update1 = array(
                'indikator' => $d,
                'persentase_fisik' => $persentase_fisik2,
                'anggaran' => $total_uang+$get_status_laporan_kube->anggaran,
                'persentase_anggaran' => $persentase_anggaran,
                'persentase_realisasi' => $persentase_realisasi
            );
            // print_r($data_update1);
            $this->Main_model->updateData('status_laporan_kube',$data_update1,array('id_kube'=>$get_status_laporan_kube->id_kube));
        }
        $this->Main_model->log_activity($this->session->userdata('id'),'Adding data',"Add Kube's report data (".$get_data_kube->nama_tim.")",$this->session->userdata('location'));
        $this->db->trans_complete();
        if($this->db->trans_status() === false){
            $this->session->set_flashdata('gagal','<div class="alert alert-warning"><button type="button" class="close" data-dismiss="alert"><i class="ace-icon fa fa-times"></i></button><strong></i>Oops! </strong>data gagal ditambahkan.<br /></div>' );
            echo "<script>window.location='".base_url()."admin_side/tambah_laporan_kube/'</script>";
        }
        else{
            $this->session->set_flashdata('sukses','<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert"><i class="ace-icon fa fa-times"></i></button><strong></i>Yeah! </strong>data telah berhasil ditambahkan.<br /></div>' );
            echo "<script>window.location='".base_url()."admin_side/laporan_kube/'</script>";
        }
    }
    public function detail_kube_report()
    {
        $data['parent'] = 'report';
        $data['child'] = 'kube';
        $data['grand_child'] = '';
        $data['status_laporan'] = $this->Main_model->getSelectedData('status_laporan_kube a', 'a.*', array('md5(a.id_kube)'=>$this->uri->segment(3)))->row();
        $data['data_detail_laporan'] = $this->Main_model->getSelectedData('laporan_kube a', 'a.*,b.fullname',array('md5(a.id_kube)'=>$this->uri->segment(3),'a.deleted'=>'0'),'','','','',array(
            'table' => 'user_profile b',
            'on' => 'a.user_id=b.user_id',
            'pos' => 'LEFT',
        ))->result();
        $data['data_utama'] = $this->Main_model->getSelectedData('kube a', 'a.*,f.nm_provinsi,b.nm_kabupaten,c.nm_kecamatan,d.nm_desa,e.jenis_usaha', array('md5(a.id_kube)'=>$this->uri->segment(3),'a.deleted'=>'0'),'','','','',array(
            array(
                'table' => 'provinsi f',
                'on' => 'a.id_provinsi=f.id_provinsi',
                'pos' => 'left',
            ),
            array(
                'table' => 'kabupaten b',
                'on' => 'a.id_kabupaten=b.id_kabupaten',
                'pos' => 'left',
            ),
            array(
                'table' => 'kecamatan c',
                'on' => 'a.id_kecamatan=c.id_kecamatan',
                'pos' => 'left',
            ),
            array(
                'table' => 'desa d',
                'on' => 'a.id_desa=d.id_desa',
                'pos' => 'left',
            ),
            array(
				'table' => 'jenis_usaha e',
				'on' => 'a.id_jenis_usaha=e.id_jenis_usaha',
				'pos' => 'left'
			)
        ))->result();
        $this->load->view('admin/template/header',$data);
        $this->load->view('admin/report/detail_kube_report',$data);
        $this->load->view('admin/template/footer');
    }
    public function edit_kube_report(){
        $data['parent'] = 'report';
        $data['child'] = 'kube';
        $data['grand_child'] = '';
        $get_id_kube = $this->Main_model->getSelectedData('laporan_kube a', 'a.*,b.fullname',array('md5(a.id_laporan_kube)'=>$this->uri->segment(3),'a.deleted'=>'0'),'','','','',array(
            'table' => 'user_profile b',
            'on' => 'a.user_id=b.user_id',
            'pos' => 'LEFT'
        ))->row();
        $data['data_detail_laporan'] = $get_id_kube;
        $data['status_laporan'] = $this->Main_model->getSelectedData('status_laporan_kube a', 'a.*', array('a.id_kube'=>$get_id_kube->id_kube))->row();
        $data['data_utama'] = $this->Main_model->getSelectedData('kube a', 'a.*,f.nm_provinsi,b.nm_kabupaten,c.nm_kecamatan,d.nm_desa,e.jenis_usaha', array('a.id_kube'=>$get_id_kube->id_kube,'a.deleted'=>'0'),'','','','',array(
            array(
                'table' => 'provinsi f',
                'on' => 'a.id_provinsi=f.id_provinsi',
                'pos' => 'left',
            ),
            array(
                'table' => 'kabupaten b',
                'on' => 'a.id_kabupaten=b.id_kabupaten',
                'pos' => 'left',
            ),
            array(
                'table' => 'kecamatan c',
                'on' => 'a.id_kecamatan=c.id_kecamatan',
                'pos' => 'left',
            ),
            array(
                'table' => 'desa d',
                'on' => 'a.id_desa=d.id_desa',
                'pos' => 'left',
            ),
            array(
				'table' => 'jenis_usaha e',
				'on' => 'a.id_jenis_usaha=e.id_jenis_usaha',
				'pos' => 'left'
			)
        ))->row();
        $data['indikator'] = $this->Main_model->getSelectedData('master_indikator a', 'a.*')->result();
        $this->load->view('admin/template/header',$data);
        $this->load->view('admin/report/edit_kube_report',$data);
        $this->load->view('admin/template/footer');
    }
    public function update_kube_report(){
        $this->db->trans_start();
        $get_id_laporan_kube = $this->Main_model->getSelectedData('laporan_kube a', 'a.*', array('md5(a.id_laporan_kube)'=>$this->input->post('id_laporan_kube')))->row_array();
        $get_data_kube = $this->Main_model->getSelectedData('kube a', 'a.*', array('md5(a.id_kube)'=>$this->input->post('id_kube')))->row();
        $indikator = $this->Main_model->getSelectedData('master_indikator a', 'a.*')->result();
        $data_indikator = $this->Main_model->getSelectedData('indikator a', 'a.*', array('a.program'=>'1'))->result();
        $total_uang = 0;
        $get_indikator = array();

        foreach ($indikator as $key => $value) {
            $push = $this->input->post('progres_keuangan_'.$value->id_master_indikator);
            if($push==NULL){
                $check_value = $this->Main_model->getSelectedData('detail_laporan_kube_aspek_keuangan a', 'a.*', array('md5(a.id_laporan_kube)'=>$this->input->post('id_laporan_kube'),'a.id_master_indikator'=>$value->id_master_indikator))->row();
                if($check_value==NULL){
                    echo'';
                }else{
                    $total_uang -= $check_value->progres_keuangan;
                    $this->Main_model->deleteData('detail_laporan_kube_aspek_keuangan',array('id_detail_laporan_kube'=>$check_value->id_detail_laporan_kube));
                }
            }else{
                $check_value = $this->Main_model->getSelectedData('detail_laporan_kube_aspek_keuangan a', 'a.*', array('md5(a.id_laporan_kube)'=>$this->input->post('id_laporan_kube'),'a.id_master_indikator'=>$value->id_master_indikator))->row();
                if($check_value==NULL){
                    $total_uang += $this->input->post('progres_keuangan_'.$value->id_master_indikator);
                    $data_insert2b = array(
                        'id_laporan_kube' => $get_id_laporan_kube['id_laporan_kube'],
                        'id_master_indikator' => $value->id_master_indikator,
                        'progres_keuangan' => $this->input->post('progres_keuangan_'.$value->id_master_indikator)
                    );
                    // print_r($data_insert2b);
                    $this->Main_model->insertData('detail_laporan_kube_aspek_keuangan',$data_insert2b);
                }else{
                    $total_uang += $this->input->post('progres_keuangan_'.$value->id_master_indikator);
                    $data_insert2b = array(
                        'progres_keuangan' => $this->input->post('progres_keuangan_'.$value->id_master_indikator)
                    );
                    // print_r($data_insert2b);
                    $this->Main_model->updateData('detail_laporan_kube_aspek_keuangan',$data_insert2b,array('id_detail_laporan_kube'=>$check_value->id_detail_laporan_kube));
                }
            }
        }

        foreach ($data_indikator as $key => $value) {
            $push = $this->input->post('indikator_progres_fisik_'.$value->id_indikator);
            if($push==NULL){
                $check_value = $this->Main_model->getSelectedData('detail_laporan_kube_aspek_fisik a', 'a.*', array('md5(a.id_laporan_kube)'=>$this->input->post('id_laporan_kube'),'a.indikator_progres_fisik'=>$value->id_indikator))->row();
                if($check_value==NULL){
                    echo'';
                }else{
                    $this->Main_model->deleteData('detail_laporan_kube_aspek_fisik',array('id_detail_laporan_kube'=>$check_value->id_detail_laporan_kube));
                }
            }else{
                array_push($get_indikator,implode(',',$this->input->post('indikator_progres_fisik_'.$value->id_indikator)));
                $check_value = $this->Main_model->getSelectedData('detail_laporan_kube_aspek_fisik a', 'a.*', array('md5(a.id_laporan_kube)'=>$this->input->post('id_laporan_kube'),'a.indikator_progres_fisik'=>$value->id_indikator))->row();
                if($check_value==NULL){
                    $data_insert2a = array(
                        'id_laporan_kube' => $get_id_laporan_kube['id_laporan_kube'],
                        'id_master_indikator' => $value->id_master_indikator,
                        'indikator_progres_fisik' => $value->id_indikator,
                        'penjelasan_progres_fisik' => $this->input->post('penjelasan_progres_fisik_'.$value->id_indikator)
                    );
                    // print_r($data_insert2a);
                    $this->Main_model->insertData('detail_laporan_kube_aspek_fisik',$data_insert2a);
                }else{
                    $data_insert2a = array(
                        'penjelasan_progres_fisik' => $this->input->post('penjelasan_progres_fisik_'.$value->id_indikator)
                    );
                    // print_r($data_insert2a);
                    $this->Main_model->updateData('detail_laporan_kube_aspek_fisik',$data_insert2a,array('id_detail_laporan_kube'=>$check_value->id_detail_laporan_kube));
                }
            }
        }

        $tampung_indikator = implode(',',$get_indikator);
        $explode_indikator = explode(',',$tampung_indikator);
        $persentase_fisik = (count($explode_indikator)/count($data_indikator))*100;
        $data_insert1 = array(
            'indikator' => $tampung_indikator,
            'persentase_fisik' => $persentase_fisik,
            'anggaran' => $total_uang,
            'persentase_anggaran' => ($total_uang/$get_data_kube->rencana_anggaran)*100,
            'persentase_realisasi' => ((($total_uang/$get_data_kube->rencana_anggaran)*100)+$persentase_fisik)/2,
            'keterangan' => $this->input->post('keterangan')
        );
        // print_r($data_insert1);
        $this->Main_model->updateData('laporan_kube',$data_insert1,array('id_laporan_kube'=>$get_id_laporan_kube['id_laporan_kube']));
        
        $get_total_uang = $this->Main_model->getSelectedData('kube a', 'a.*,(SELECT SUM(b.anggaran) FROM laporan_kube b WHERE b.id_kube=a.id_kube AND b.deleted="0") AS total_uang', array('md5(a.id_kube)'=>$this->input->post('id_kube'),'a.deleted'=>'0'))->row();
        $get_total_indikator = $this->Main_model->getSelectedData('detail_laporan_kube_aspek_fisik a', 'a.*', array('md5(b.id_kube)'=>$this->input->post('id_kube'),'b.deleted'=>'0'),'','','','a.indikator_progres_fisik',array(
            'table' => 'laporan_kube b',
            'on' => 'a.id_laporan_kube=b.id_laporan_kube',
            'pos' => 'LEFT'
        ))->result();
        $total_indikator = array();
        foreach ($get_total_indikator as $key => $value) {
            array_push($total_indikator,$value->indikator_progres_fisik);
        }
        $persentase_realisasi = ((($get_total_uang->total_uang/$get_data_kube->rencana_anggaran)*100)+((count($total_indikator)/count($data_indikator))*100))/2;
        $data_update1 = array(
            'indikator' => implode(',',$total_indikator),
            'persentase_fisik' => (count($total_indikator)/count($data_indikator))*100,
            'anggaran' => $get_total_uang->total_uang,
            'persentase_anggaran' => ($get_total_uang->total_uang/$get_data_kube->rencana_anggaran)*100,
            'persentase_realisasi' => $persentase_realisasi
        );
        // print_r($data_update1);
        $this->Main_model->updateData('status_laporan_kube',$data_update1,array('md5(id_kube)'=>$this->input->post('id_kube')));

        $this->Main_model->log_activity($this->session->userdata('id'),'Updating data',"Update Kube's report data (".$get_data_kube->nama_tim.")",$this->session->userdata('location'));
        $this->db->trans_complete();
        if($this->db->trans_status() === false){
            $this->session->set_flashdata('gagal','<div class="alert alert-warning"><button type="button" class="close" data-dismiss="alert"><i class="ace-icon fa fa-times"></i></button><strong></i>Oops! </strong>data gagal diperbarui.<br /></div>' );
            echo "<script>window.location='".base_url()."admin_side/ubah_data_laporan_kube/".$this->input->post('id_laporan_kube')."'</script>";
        }
        else{
            $this->session->set_flashdata('sukses','<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert"><i class="ace-icon fa fa-times"></i></button><strong></i>Yeah! </strong>data telah berhasil diperbarui.<br /></div>' );
            echo "<script>window.location='".base_url()."admin_side/detil_laporan_kube/".$this->input->post('id_kube')."'</script>";
        }
    }
    public function delete_kube_report(){
        $this->db->trans_start();
        $get_data = $this->Main_model->getSelectedData('laporan_kube a', 'a.*',array('md5(a.id_laporan_kube)'=>$this->uri->segment(3)))->row();
        $get_status_laporan_kube = $this->Main_model->getSelectedData('status_laporan_kube a', 'a.*',array('a.id_kube'=>$get_data->id_kube))->row();
        $indikator_status = explode(',',$get_status_laporan_kube->indikator);
        $indikator_laporan = explode(',',$get_data->indikator);

        $array_indikator_update = array();
        $status = '';
        for ($i=0; $i < count($indikator_status); $i++) { 
            for ($j=0; $j < count($indikator_laporan); $j++) { 
                if($indikator_laporan[$j]==$indikator_status[$i]){
                    $status = '0';
                    break;
                }else{
                    $status = '1';
                }	
            }
            if($status=='0'){
                echo'';
            }else{
                $array_indikator_update[] = $indikator_status[$i];
            }
        }

        $this->Main_model->updateData('laporan_kube',array('deleted'=>'1'),array('md5(id_laporan_kube)'=>$this->uri->segment(3)));
        $data_update = array(
            'indikator' => implode(',',array_unique($array_indikator_update)),
            'persentase_fisik' => ($get_status_laporan_kube->persentase_fisik)-($get_data->persentase_fisik),
            'anggaran' => ($get_status_laporan_kube->anggaran)-($get_data->anggaran),
            'persentase_anggaran' => ($get_status_laporan_kube->persentase_anggaran)-($get_data->persentase_anggaran),
            'persentase_realisasi' => ($get_status_laporan_kube->persentase_realisasi)-($get_data->persentase_realisasi)
        );
        // print_r($data_update);
        $this->Main_model->updateData('status_laporan_kube',$data_update,array('id_kube'=>$get_status_laporan_kube->id_kube));

        $this->Main_model->log_activity($this->session->userdata('id'),"Deleting kube's report","Delete kube's report",$this->session->userdata('location'));
        $this->db->trans_complete();
        if($this->db->trans_status() === false){
            $this->session->set_flashdata('gagal','<div class="alert alert-warning"><button type="button" class="close" data-dismiss="alert"><i class="ace-icon fa fa-times"></i></button><strong></i>Oops! </strong>data gagal dihapus.<br /></div>' );
            echo "<script>window.location='".base_url()."admin_side/detil_laporan_kube/".md5($get_data->id_kube)."'</script>";
        }
        else{
            $this->session->set_flashdata('sukses','<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert"><i class="ace-icon fa fa-times"></i></button><strong></i>Yeah! </strong>data telah berhasil dihapus.<br /></div>' );
            echo "<script>window.location='".base_url()."admin_side/detil_laporan_kube/".md5($get_data->id_kube)."'</script>";
        }
    }
    /* Rutilahu (Rumah Tidak Layak Huni) */
    public function rutilahu(){
        $data['parent'] = 'report';
        $data['child'] = 'rutilahu';
        $data['grand_child'] = '';
        $this->load->view('admin/template/header',$data);
        $this->load->view('admin/report/rutilahu',$data);
        $this->load->view('admin/template/footer');
    }
    public function json_rutilahu(){
        $jumlah_indikator = $this->Main_model->getSelectedData('indikator a', 'a.*')->result();
        $get_data = $this->Main_model->getSelectedData('rutilahu a', 'a.*,c.nm_provinsi,d.nm_kabupaten,e.nm_kecamatan,f.nm_desa,g.*',array('a.deleted'=>'0'),'','','','',array(
            array(
                'table' => 'provinsi c',
                'on' => 'a.id_provinsi=c.id_provinsi',
                'pos' => 'LEFT'
            ),
            array(
                'table' => 'kabupaten d',
                'on' => 'a.id_kabupaten=d.id_kabupaten',
                'pos' => 'LEFT'
            ),
            array(
                'table' => 'kecamatan e',
                'on' => 'a.id_kecamatan=e.id_kecamatan',
                'pos' => 'LEFT'
            ),
            array(
                'table' => 'desa f',
                'on' => 'a.id_desa=f.id_desa',
                'pos' => 'LEFT'
            ),
            array(
                'table' => 'status_laporan_rutilahu g',
                'on' => 'a.id_rutilahu=g.id_rutilahu',
                'pos' => 'RIGHT'
            )
        ))->result();
        $data_tampil = array();
        $no = 1;
        foreach ($get_data as $key => $value) {
            // $get_realisasi_fisik = ($value->jumlah_fisik/count($jumlah_indikator))*100;
            // $get_total_uang_keluar = ($value->jumlah_uang/$value->rencana_anggaran)*100;
            $isi['checkbox'] =	'
                                <label class="mt-checkbox mt-checkbox-single mt-checkbox-outline">
                                    <input type="checkbox" class="checkboxes" name="selected_id[]" value="'.$value->id_rutilahu.'"/>
                                    <span></span>
                                </label>
                                ';
            $isi['number'] = $no++.'.';
            $isi['nama_kelompok'] = $value->nama_kelompok;
            $isi['realisasi_fisik'] = number_format($value->persentase_fisik,2).'%';
            $isi['rencana_anggaran'] = 'Rp '.number_format($value->rencana_anggaran,2);
            $isi['realisasi_anggaran'] = 'Rp '.number_format($value->anggaran,2);
            $isi['persentase_anggaran'] = number_format($value->persentase_anggaran,2).'%';
            $isi['aksi'] =	'
                                <div class="dropdown">
                                    <button class="btn btn-xs green dropdown-toggle" type="button" data-toggle="dropdown" aria-expanded="false"> Aksi
                                        <i class="fa fa-angle-down"></i>
                                    </button>
                                    <ul class="dropdown-menu pull-right" role="menu">
                                        <li>
                                            <a href="'.site_url('admin_side/detil_laporan_rutilahu/'.md5($value->id_rutilahu)).'">
                                                <i class="icon-eye"></i> Detil Data </a>
                                        </li>
                                    </ul>
                                </div>
                                ';
            // $isi['persentase_realisasi'] = number_format($value->persentase_realisasi,2).'%';
            $data_tampil[] = $isi;
        }
        $results = array(
            "sEcho" => 1,
            "iTotalRecords" => count($data_tampil),
            "iTotalDisplayRecords" => count($data_tampil),
            "aaData"=>$data_tampil);
        echo json_encode($results);
    }
    public function add_rutilahu_report(){
        $data['parent'] = 'report';
        $data['child'] = 'rutilahu';
        $data['grand_child'] = '';
        $data['rutilahu'] = $this->Main_model->getSelectedData('rutilahu a', 'a.*,e.nm_kabupaten', array('a.deleted'=>'0'),'','','','',array(
            'table' => 'kabupaten e',
            'on' => 'a.id_kabupaten=e.id_kabupaten',
            'pos' => 'left'
        ))->result();
        $data['indikator'] = $this->Main_model->getSelectedData('master_indikator a', 'a.*')->result();
        $this->load->view('admin/template/header',$data);
        $this->load->view('admin/report/add_rutilahu_report',$data);
        $this->load->view('admin/template/footer');
    }
    public function save_rutilahu_report(){
        $this->db->trans_start();
        $get_id_laporan_rutilahu = $this->Main_model->getLastID('laporan_rutilahu','id_laporan_rutilahu');
        $get_data_rutilahu = $this->Main_model->getSelectedData('rutilahu a', 'a.*,(SELECT k.id_anggota_rutilahu FROM anggota_rutilahu k WHERE k.id_rutilahu=a.id_rutilahu AND k.jabatan_kelompok="Ketua") AS ketua,(SELECT i.user_id FROM anggota_rutilahu i WHERE i.id_rutilahu=a.id_rutilahu AND i.jabatan_kelompok="Ketua") AS id_ketua', array('a.id_rutilahu'=>$this->input->post('id_rutilahu')))->row();
        $indikator = $this->Main_model->getSelectedData('master_indikator a', 'a.*')->result();
        $data_indikator = $this->Main_model->getSelectedData('indikator a', 'a.*', array('a.program'=>'2'))->result();
        $total_uang = 0;
        $get_indikator = array();
        foreach ($indikator as $key => $value) {
            $push = $this->input->post('progres_keuangan_'.$value->id_master_indikator);
            if($push==NULL){
                echo'';
            }else{
                $total_uang += $this->input->post('progres_keuangan_'.$value->id_master_indikator);
                $data_insert2b = array(
                    'id_laporan_rutilahu' => $get_id_laporan_rutilahu['id_laporan_rutilahu']+1,
                    'id_master_indikator' => $value->id_master_indikator,
                    'progres_keuangan' => $this->input->post('progres_keuangan_'.$value->id_master_indikator)
                );
                // print_r($data_insert2b);
                $this->Main_model->insertData('detail_laporan_rutilahu_aspek_keuangan',$data_insert2b);
            }
        }
        foreach ($data_indikator as $key => $value) {
            $push = $this->input->post('indikator_progres_fisik_'.$value->id_indikator);
            if($push==NULL){
                echo'';
            }else{
                array_push($get_indikator,implode(',',$this->input->post('indikator_progres_fisik_'.$value->id_indikator)));
                $data_insert2a = array(
                    'id_laporan_rutilahu' => $get_id_laporan_rutilahu['id_laporan_rutilahu']+1,
                    'id_master_indikator' => $value->id_master_indikator,
                    'indikator_progres_fisik' => $value->id_indikator,
                    'penjelasan_progres_fisik' => $this->input->post('penjelasan_progres_fisik_'.$value->id_indikator)
                );
                // print_r($data_insert2a);
                $this->Main_model->insertData('detail_laporan_rutilahu_aspek_fisik',$data_insert2a);
            }
        }
        $tampung_indikator = implode(',',$get_indikator);
        $explode_indikator = explode(',',$tampung_indikator);
        $get_status_laporan_rutilahu = $this->Main_model->getSelectedData('status_laporan_rutilahu a', 'a.*', array('a.id_rutilahu'=>$this->input->post('id_rutilahu')))->row();
        $persentase_fisik = (count($explode_indikator)/count($data_indikator))*100;
        $data_insert1 = array(
            'id_laporan_rutilahu' => $get_id_laporan_rutilahu['id_laporan_rutilahu']+1,
            'id_anggota_rutilahu' => $get_data_rutilahu->ketua,
            'user_id' => $get_data_rutilahu->id_ketua,
            'id_rutilahu' => $this->input->post('id_rutilahu'),
            'indikator' => $tampung_indikator,
            'persentase_fisik' => $persentase_fisik,
            'anggaran' => $total_uang,
            'persentase_anggaran' => ($total_uang/$get_data_rutilahu->rencana_anggaran)*100,
            'persentase_realisasi' => ((($total_uang/$get_data_rutilahu->rencana_anggaran)*100)+$persentase_fisik)/2,
            'keterangan' => $this->input->post('keterangan'),
            'created_at' => date('Y-m-d H:i:s'),
            'created_by' => $this->session->userdata('id')
        );
        // print_r($data_insert1);
        $this->Main_model->insertData('laporan_rutilahu',$data_insert1);
        if($get_status_laporan_rutilahu==NULL){
            $persentase_anggaran = ($total_uang/$get_data_rutilahu->rencana_anggaran)*100;
            $persentase_realisasi = ($persentase_anggaran+$persentase_fisik)/2;
            $data_insert3 = array(
                'id_rutilahu' => $this->input->post('id_rutilahu'),
                'indikator' => $tampung_indikator,
                'persentase_fisik' => $persentase_fisik,
                'anggaran' => $total_uang,
                'persentase_anggaran' => $persentase_anggaran,
                'persentase_realisasi' => $persentase_realisasi
            );
            // print_r($data_insert3);
            $this->Main_model->insertData('status_laporan_rutilahu',$data_insert3);
        }else{
            $bb = explode(',',$get_status_laporan_rutilahu->indikator);
            $c = array_unique(array_merge($get_indikator,$bb));
            $d = implode(',',$c);
            $persentase_fisik2 = (count($c)/count($data_indikator))*100;
            $persentase_anggaran = (($total_uang+$get_status_laporan_rutilahu->anggaran)/$get_data_rutilahu->rencana_anggaran)*100;
            $persentase_realisasi = ($persentase_anggaran+$persentase_fisik2)/2;
            $data_update1 = array(
                'indikator' => $d,
                'persentase_fisik' => $persentase_fisik2,
                'anggaran' => $total_uang+$get_status_laporan_rutilahu->anggaran,
                'persentase_anggaran' => $persentase_anggaran,
                'persentase_realisasi' => $persentase_realisasi
            );
            // print_r($data_update1);
            $this->Main_model->updateData('status_laporan_rutilahu',$data_update1,array('id_rutilahu'=>$get_status_laporan_rutilahu->id_rutilahu));
        }
        $this->Main_model->log_activity($this->session->userdata('id'),'Adding data',"Add Rutilahu's report data (".$get_data_rutilahu->nama_kelompok.")",$this->session->userdata('location'));
        $this->db->trans_complete();
        if($this->db->trans_status() === false){
            $this->session->set_flashdata('gagal','<div class="alert alert-warning"><button type="button" class="close" data-dismiss="alert"><i class="ace-icon fa fa-times"></i></button><strong></i>Oops! </strong>data gagal ditambahkan.<br /></div>' );
            echo "<script>window.location='".base_url()."admin_side/tambah_laporan_rutilahu/'</script>";
        }
        else{
            $this->session->set_flashdata('sukses','<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert"><i class="ace-icon fa fa-times"></i></button><strong></i>Yeah! </strong>data telah berhasil ditambahkan.<br /></div>' );
            echo "<script>window.location='".base_url()."admin_side/laporan_rutilahu/'</script>";
        }
    }
    public function detail_rutilahu_report()
    {
        $data['parent'] = 'report';
        $data['child'] = 'rutilahu';
        $data['grand_child'] = '';
        $data['status_laporan'] = $this->Main_model->getSelectedData('status_laporan_rutilahu a', 'a.*', array('md5(a.id_rutilahu)'=>$this->uri->segment(3)))->row();
        $data['data_detail_laporan'] = $this->Main_model->getSelectedData('laporan_rutilahu a', 'a.*,b.fullname',array('md5(a.id_rutilahu)'=>$this->uri->segment(3),'a.deleted'=>'0'),'','','','',array(
            'table' => 'user_profile b',
            'on' => 'a.user_id=b.user_id',
            'pos' => 'LEFT',
        ))->result();
        $data['data_utama'] = $this->Main_model->getSelectedData('rutilahu a', 'a.*,f.nm_provinsi,b.nm_kabupaten,c.nm_kecamatan,d.nm_desa', array('md5(a.id_rutilahu)'=>$this->uri->segment(3),'a.deleted'=>'0'),'','','','',array(
            array(
                'table' => 'provinsi f',
                'on' => 'a.id_provinsi=f.id_provinsi',
                'pos' => 'left',
            ),
            array(
                'table' => 'kabupaten b',
                'on' => 'a.id_kabupaten=b.id_kabupaten',
                'pos' => 'left',
            ),
            array(
                'table' => 'kecamatan c',
                'on' => 'a.id_kecamatan=c.id_kecamatan',
                'pos' => 'left',
            ),
            array(
                'table' => 'desa d',
                'on' => 'a.id_desa=d.id_desa',
                'pos' => 'left',
            )
        ))->result();
        $this->load->view('admin/template/header',$data);
        $this->load->view('admin/report/detail_rutilahu_report',$data);
        $this->load->view('admin/template/footer');
    }
    public function edit_rutilahu_report(){
        $data['parent'] = 'report';
        $data['child'] = 'rutilahu';
        $data['grand_child'] = '';
        $get_id_rutilahu = $this->Main_model->getSelectedData('laporan_rutilahu a', 'a.*,b.fullname',array('md5(a.id_laporan_rutilahu)'=>$this->uri->segment(3),'a.deleted'=>'0'),'','','','',array(
            'table' => 'user_profile b',
            'on' => 'a.user_id=b.user_id',
            'pos' => 'LEFT'
        ))->row();
        $data['data_detail_laporan'] = $get_id_rutilahu;
        $data['status_laporan'] = $this->Main_model->getSelectedData('status_laporan_rutilahu a', 'a.*', array('a.id_rutilahu'=>$get_id_rutilahu->id_rutilahu))->row();
        $data['data_utama'] = $this->Main_model->getSelectedData('rutilahu a', 'a.*,f.nm_provinsi,b.nm_kabupaten,c.nm_kecamatan,d.nm_desa', array('a.id_rutilahu'=>$get_id_rutilahu->id_rutilahu,'a.deleted'=>'0'),'','','','',array(
            array(
                'table' => 'provinsi f',
                'on' => 'a.id_provinsi=f.id_provinsi',
                'pos' => 'left',
            ),
            array(
                'table' => 'kabupaten b',
                'on' => 'a.id_kabupaten=b.id_kabupaten',
                'pos' => 'left',
            ),
            array(
                'table' => 'kecamatan c',
                'on' => 'a.id_kecamatan=c.id_kecamatan',
                'pos' => 'left',
            ),
            array(
                'table' => 'desa d',
                'on' => 'a.id_desa=d.id_desa',
                'pos' => 'left',
            )
        ))->row();
        $data['indikator'] = $this->Main_model->getSelectedData('master_indikator a', 'a.*')->result();
        $this->load->view('admin/template/header',$data);
        $this->load->view('admin/report/edit_rutilahu_report',$data);
        $this->load->view('admin/template/footer');
    }
    public function update_rutilahu_report(){
        $this->db->trans_start();
        $get_id_laporan_rutilahu = $this->Main_model->getSelectedData('laporan_rutilahu a', 'a.*', array('md5(a.id_laporan_rutilahu)'=>$this->input->post('id_laporan_rutilahu')))->row_array();
        $get_data_rutilahu = $this->Main_model->getSelectedData('rutilahu a', 'a.*', array('md5(a.id_rutilahu)'=>$this->input->post('id_rutilahu')))->row();
        $indikator = $this->Main_model->getSelectedData('master_indikator a', 'a.*')->result();
        $data_indikator = $this->Main_model->getSelectedData('indikator a', 'a.*', array('a.program'=>'2'))->result();
        $total_uang = 0;
        $get_indikator = array();

        foreach ($indikator as $key => $value) {
            $push = $this->input->post('progres_keuangan_'.$value->id_master_indikator);
            if($push==NULL){
                $check_value = $this->Main_model->getSelectedData('detail_laporan_rutilahu_aspek_keuangan a', 'a.*', array('md5(a.id_laporan_rutilahu)'=>$this->input->post('id_laporan_rutilahu'),'a.id_master_indikator'=>$value->id_master_indikator))->row();
                if($check_value==NULL){
                    echo'';
                }else{
                    $total_uang -= $check_value->progres_keuangan;
                    $this->Main_model->deleteData('detail_laporan_rutilahu_aspek_keuangan',array('id_detail_laporan_rutilahu'=>$check_value->id_detail_laporan_rutilahu));
                }
            }else{
                $check_value = $this->Main_model->getSelectedData('detail_laporan_rutilahu_aspek_keuangan a', 'a.*', array('md5(a.id_laporan_rutilahu)'=>$this->input->post('id_laporan_rutilahu'),'a.id_master_indikator'=>$value->id_master_indikator))->row();
                if($check_value==NULL){
                    $total_uang += $this->input->post('progres_keuangan_'.$value->id_master_indikator);
                    $data_insert2b = array(
                        'id_laporan_rutilahu' => $get_id_laporan_rutilahu['id_laporan_rutilahu'],
                        'id_master_indikator' => $value->id_master_indikator,
                        'progres_keuangan' => $this->input->post('progres_keuangan_'.$value->id_master_indikator)
                    );
                    // print_r($data_insert2b);
                    $this->Main_model->insertData('detail_laporan_rutilahu_aspek_keuangan',$data_insert2b);
                }else{
                    $total_uang += $this->input->post('progres_keuangan_'.$value->id_master_indikator);
                    $data_insert2b = array(
                        'progres_keuangan' => $this->input->post('progres_keuangan_'.$value->id_master_indikator)
                    );
                    // print_r($data_insert2b);
                    $this->Main_model->updateData('detail_laporan_rutilahu_aspek_keuangan',$data_insert2b,array('id_detail_laporan_rutilahu'=>$check_value->id_detail_laporan_rutilahu));
                }
            }
        }

        foreach ($data_indikator as $key => $value) {
            $push = $this->input->post('indikator_progres_fisik_'.$value->id_indikator);
            if($push==NULL){
                $check_value = $this->Main_model->getSelectedData('detail_laporan_rutilahu_aspek_fisik a', 'a.*', array('md5(a.id_laporan_rutilahu)'=>$this->input->post('id_laporan_rutilahu'),'a.indikator_progres_fisik'=>$value->id_indikator))->row();
                if($check_value==NULL){
                    echo'';
                }else{
                    $this->Main_model->deleteData('detail_laporan_rutilahu_aspek_fisik',array('id_detail_laporan_rutilahu'=>$check_value->id_detail_laporan_rutilahu));
                }
            }else{
                array_push($get_indikator,implode(',',$this->input->post('indikator_progres_fisik_'.$value->id_indikator)));
                $check_value = $this->Main_model->getSelectedData('detail_laporan_rutilahu_aspek_fisik a', 'a.*', array('md5(a.id_laporan_rutilahu)'=>$this->input->post('id_laporan_rutilahu'),'a.indikator_progres_fisik'=>$value->id_indikator))->row();
                if($check_value==NULL){
                    $data_insert2a = array(
                        'id_laporan_rutilahu' => $get_id_laporan_rutilahu['id_laporan_rutilahu'],
                        'id_master_indikator' => $value->id_master_indikator,
                        'indikator_progres_fisik' => $value->id_indikator,
                        'penjelasan_progres_fisik' => $this->input->post('penjelasan_progres_fisik_'.$value->id_indikator)
                    );
                    // print_r($data_insert2a);
                    $this->Main_model->insertData('detail_laporan_rutilahu_aspek_fisik',$data_insert2a);
                }else{
                    $data_insert2a = array(
                        'penjelasan_progres_fisik' => $this->input->post('penjelasan_progres_fisik_'.$value->id_indikator)
                    );
                    // print_r($data_insert2a);
                    $this->Main_model->updateData('detail_laporan_rutilahu_aspek_fisik',$data_insert2a,array('id_detail_laporan_rutilahu'=>$check_value->id_detail_laporan_rutilahu));
                }
            }
        }

        $tampung_indikator = implode(',',$get_indikator);
        $explode_indikator = explode(',',$tampung_indikator);
        $persentase_fisik = (count($explode_indikator)/count($data_indikator))*100;
        $data_insert1 = array(
            'indikator' => $tampung_indikator,
            'persentase_fisik' => $persentase_fisik,
            'anggaran' => $total_uang,
            'persentase_anggaran' => ($total_uang/$get_data_rutilahu->rencana_anggaran)*100,
            'persentase_realisasi' => ((($total_uang/$get_data_rutilahu->rencana_anggaran)*100)+$persentase_fisik)/2,
            'keterangan' => $this->input->post('keterangan')
        );
        // print_r($data_insert1);
        $this->Main_model->updateData('laporan_rutilahu',$data_insert1,array('id_laporan_rutilahu'=>$get_id_laporan_rutilahu['id_laporan_rutilahu']));
        
        $get_total_uang = $this->Main_model->getSelectedData('rutilahu a', 'a.*,(SELECT SUM(b.anggaran) FROM laporan_rutilahu b WHERE b.id_rutilahu=a.id_rutilahu AND b.deleted="0") AS total_uang', array('md5(a.id_rutilahu)'=>$this->input->post('id_rutilahu'),'a.deleted'=>'0'))->row();
        $get_total_indikator = $this->Main_model->getSelectedData('detail_laporan_rutilahu_aspek_fisik a', 'a.*', array('md5(b.id_rutilahu)'=>$this->input->post('id_rutilahu'),'b.deleted'=>'0'),'','','','a.indikator_progres_fisik',array(
            'table' => 'laporan_rutilahu b',
            'on' => 'a.id_laporan_rutilahu=b.id_laporan_rutilahu',
            'pos' => 'LEFT'
        ))->result();
        $total_indikator = array();
        foreach ($get_total_indikator as $key => $value) {
            array_push($total_indikator,$value->indikator_progres_fisik);
        }
        $persentase_realisasi = ((($get_total_uang->total_uang/$get_data_rutilahu->rencana_anggaran)*100)+((count($total_indikator)/count($data_indikator))*100))/2;
        $data_update1 = array(
            'indikator' => implode(',',$total_indikator),
            'persentase_fisik' => (count($total_indikator)/count($data_indikator))*100,
            'anggaran' => $get_total_uang->total_uang,
            'persentase_anggaran' => ($get_total_uang->total_uang/$get_data_rutilahu->rencana_anggaran)*100,
            'persentase_realisasi' => $persentase_realisasi
        );
        // print_r($data_update1);
        $this->Main_model->updateData('status_laporan_rutilahu',$data_update1,array('md5(id_rutilahu)'=>$this->input->post('id_rutilahu')));

        $this->Main_model->log_activity($this->session->userdata('id'),'Updating data',"Update Rutilahu's report data (".$get_data_rutilahu->nama_kelompok.")",$this->session->userdata('location'));
        $this->db->trans_complete();
        if($this->db->trans_status() === false){
            $this->session->set_flashdata('gagal','<div class="alert alert-warning"><button type="button" class="close" data-dismiss="alert"><i class="ace-icon fa fa-times"></i></button><strong></i>Oops! </strong>data gagal diperbarui.<br /></div>' );
            echo "<script>window.location='".base_url()."admin_side/ubah_data_laporan_rutilahu/".$this->input->post('id_laporan_rutilahu')."'</script>";
        }
        else{
            $this->session->set_flashdata('sukses','<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert"><i class="ace-icon fa fa-times"></i></button><strong></i>Yeah! </strong>data telah berhasil diperbarui.<br /></div>' );
            echo "<script>window.location='".base_url()."admin_side/detil_laporan_rutilahu/".$this->input->post('id_rutilahu')."'</script>";
        }
    }
    public function delete_rutilahu_report(){
        $this->db->trans_start();
        $get_data = $this->Main_model->getSelectedData('laporan_rutilahu a', 'a.*',array('md5(a.id_laporan_rutilahu)'=>$this->uri->segment(3)))->row();
        $get_status_laporan_rutilahu = $this->Main_model->getSelectedData('status_laporan_rutilahu a', 'a.*',array('a.id_rutilahu'=>$get_data->id_rutilahu))->row();
        $indikator_status = explode(',',$get_status_laporan_rutilahu->indikator);
        $indikator_laporan = explode(',',$get_data->indikator);

        $array_indikator_update = array();
        $status = '';
        for ($i=0; $i < count($indikator_status); $i++) { 
            for ($j=0; $j < count($indikator_laporan); $j++) { 
                if($indikator_laporan[$j]==$indikator_status[$i]){
                    $status = '0';
                    break;
                }else{
                    $status = '1';
                }	
            }
            if($status=='0'){
                echo'';
            }else{
                $array_indikator_update[] = $indikator_status[$i];
            }
        }

        $this->Main_model->updateData('laporan_rutilahu',array('deleted'=>'1'),array('md5(id_laporan_rutilahu)'=>$this->uri->segment(3)));
        $data_update = array(
            'indikator' => implode(',',array_unique($array_indikator_update)),
            'persentase_fisik' => ($get_status_laporan_rutilahu->persentase_fisik)-($get_data->persentase_fisik),
            'anggaran' => ($get_status_laporan_rutilahu->anggaran)-($get_data->anggaran),
            'persentase_anggaran' => ($get_status_laporan_rutilahu->persentase_anggaran)-($get_data->persentase_anggaran),
            'persentase_realisasi' => ($get_status_laporan_rutilahu->persentase_realisasi)-($get_data->persentase_realisasi)
        );
        // print_r($data_update);
        $this->Main_model->updateData('status_laporan_rutilahu',$data_update,array('id_rutilahu'=>$get_status_laporan_rutilahu->id_rutilahu));

        $this->Main_model->log_activity($this->session->userdata('id'),"Deleting rutilahu's report","Delete rutilahu's report",$this->session->userdata('location'));
        $this->db->trans_complete();
        if($this->db->trans_status() === false){
            $this->session->set_flashdata('gagal','<div class="alert alert-warning"><button type="button" class="close" data-dismiss="alert"><i class="ace-icon fa fa-times"></i></button><strong></i>Oops! </strong>data gagal dihapus.<br /></div>' );
            echo "<script>window.location='".base_url()."admin_side/detil_laporan_rutilahu/".md5($get_data->id_rutilahu)."'</script>";
        }
        else{
            $this->session->set_flashdata('sukses','<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert"><i class="ace-icon fa fa-times"></i></button><strong></i>Yeah! </strong>data telah berhasil dihapus.<br /></div>' );
            echo "<script>window.location='".base_url()."admin_side/detil_laporan_rutilahu/".md5($get_data->id_rutilahu)."'</script>";
        }
    }
    /* Sarling (Sarana Lingkungan) */
    public function sarling(){
        $data['parent'] = 'report';
        $data['child'] = 'sarling';
        $data['grand_child'] = '';
        $this->load->view('admin/template/header',$data);
        $this->load->view('admin/report/sarling',$data);
        $this->load->view('admin/template/footer');
    }
    public function json_sarling(){
        $jumlah_indikator = $this->Main_model->getSelectedData('indikator a', 'a.*')->result();
        $get_data = $this->Main_model->getSelectedData('sarling a', 'a.*,c.nm_provinsi,d.nm_kabupaten,e.nm_kecamatan,f.nm_desa,g.*',array('a.deleted'=>'0'),'','','','',array(
            array(
                'table' => 'provinsi c',
                'on' => 'a.id_provinsi=c.id_provinsi',
                'pos' => 'LEFT'
            ),
            array(
                'table' => 'kabupaten d',
                'on' => 'a.id_kabupaten=d.id_kabupaten',
                'pos' => 'LEFT'
            ),
            array(
                'table' => 'kecamatan e',
                'on' => 'a.id_kecamatan=e.id_kecamatan',
                'pos' => 'LEFT'
            ),
            array(
                'table' => 'desa f',
                'on' => 'a.id_desa=f.id_desa',
                'pos' => 'LEFT'
            ),
            array(
                'table' => 'status_laporan_sarling g',
                'on' => 'a.id_sarling=g.id_sarling',
                'pos' => 'RIGHT'
            )
        ))->result();
        $data_tampil = array();
        $no = 1;
        foreach ($get_data as $key => $value) {
            // $get_realisasi_fisik = ($value->jumlah_fisik/count($jumlah_indikator))*100;
            // $get_total_uang_keluar = ($value->jumlah_uang/$value->rencana_anggaran)*100;
            $isi['checkbox'] =	'
                                <label class="mt-checkbox mt-checkbox-single mt-checkbox-outline">
                                    <input type="checkbox" class="checkboxes" name="selected_id[]" value="'.$value->id_sarling.'"/>
                                    <span></span>
                                </label>
                                ';
            $isi['number'] = $no++.'.';
            $isi['nama_kelompok'] = $value->nama_tim;
            $isi['realisasi_fisik'] = number_format($value->persentase_fisik,2).'%';
            $isi['rencana_anggaran'] = 'Rp '.number_format($value->rencana_anggaran,2);
            $isi['realisasi_anggaran'] = 'Rp '.number_format($value->anggaran,2);
            $isi['persentase_anggaran'] = number_format($value->persentase_anggaran,2).'%';
            $isi['aksi'] =	'
                                <div class="dropdown">
                                    <button class="btn btn-xs green dropdown-toggle" type="button" data-toggle="dropdown" aria-expanded="false"> Aksi
                                        <i class="fa fa-angle-down"></i>
                                    </button>
                                    <ul class="dropdown-menu pull-right" role="menu">
                                        <li>
                                            <a href="'.site_url('admin_side/detil_laporan_sarling/'.md5($value->id_sarling)).'">
                                                <i class="icon-eye"></i> Detil Data </a>
                                        </li>
                                    </ul>
                                </div>
                                ';
            // $isi['persentase_realisasi'] = number_format($value->persentase_realisasi,2).'%';
            $data_tampil[] = $isi;
        }
        $results = array(
            "sEcho" => 1,
            "iTotalRecords" => count($data_tampil),
            "iTotalDisplayRecords" => count($data_tampil),
            "aaData"=>$data_tampil);
        echo json_encode($results);
    }
    public function add_sarling_report(){
        $data['parent'] = 'report';
        $data['child'] = 'sarling';
        $data['grand_child'] = '';
        $data['sarling'] = $this->Main_model->getSelectedData('sarling a', 'a.*,e.nm_kabupaten', array('a.deleted'=>'0'),'','','','',array(
            'table' => 'kabupaten e',
            'on' => 'a.id_kabupaten=e.id_kabupaten',
            'pos' => 'left'
        ))->result();
        $data['indikator'] = $this->Main_model->getSelectedData('master_indikator a', 'a.*')->result();
        $this->load->view('admin/template/header',$data);
        $this->load->view('admin/report/add_sarling_report',$data);
        $this->load->view('admin/template/footer');
    }
    public function save_sarling_report(){
        $this->db->trans_start();
        $get_id_laporan_sarling = $this->Main_model->getLastID('laporan_sarling','id_laporan_sarling');
        $get_data_sarling = $this->Main_model->getSelectedData('sarling a', 'a.*,(SELECT k.id_anggota_sarling FROM anggota_sarling k WHERE k.id_sarling=a.id_sarling AND k.jabatan_kelompok="Ketua") AS ketua,(SELECT i.user_id FROM anggota_sarling i WHERE i.id_sarling=a.id_sarling AND i.jabatan_kelompok="Ketua") AS id_ketua', array('a.id_sarling'=>$this->input->post('id_sarling')))->row();
        $indikator = $this->Main_model->getSelectedData('master_indikator a', 'a.*')->result();
        $data_indikator = $this->Main_model->getSelectedData('indikator a', 'a.*', array('a.program'=>'3'))->result();
        $total_uang = 0;
        $get_indikator = array();
        foreach ($indikator as $key => $value) {
            $push = $this->input->post('progres_keuangan_'.$value->id_master_indikator);
            if($push==NULL){
                echo'';
            }else{
                $total_uang += $this->input->post('progres_keuangan_'.$value->id_master_indikator);
                $data_insert2b = array(
                    'id_laporan_sarling' => $get_id_laporan_sarling['id_laporan_sarling']+1,
                    'id_master_indikator' => $value->id_master_indikator,
                    'progres_keuangan' => $this->input->post('progres_keuangan_'.$value->id_master_indikator)
                );
                // print_r($data_insert2b);
                $this->Main_model->insertData('detail_laporan_sarling_aspek_keuangan',$data_insert2b);
            }
        }
        foreach ($data_indikator as $key => $value) {
            $push = $this->input->post('indikator_progres_fisik_'.$value->id_indikator);
            if($push==NULL){
                echo'';
            }else{
                array_push($get_indikator,implode(',',$this->input->post('indikator_progres_fisik_'.$value->id_indikator)));
                $data_insert2a = array(
                    'id_laporan_sarling' => $get_id_laporan_sarling['id_laporan_sarling']+1,
                    'id_master_indikator' => $value->id_master_indikator,
                    'indikator_progres_fisik' => $value->id_indikator,
                    'penjelasan_progres_fisik' => $this->input->post('penjelasan_progres_fisik_'.$value->id_indikator)
                );
                // print_r($data_insert2a);
                $this->Main_model->insertData('detail_laporan_sarling_aspek_fisik',$data_insert2a);
            }
        }
        $tampung_indikator = implode(',',$get_indikator);
        $explode_indikator = explode(',',$tampung_indikator);
        $get_status_laporan_sarling = $this->Main_model->getSelectedData('status_laporan_sarling a', 'a.*', array('a.id_sarling'=>$this->input->post('id_sarling')))->row();
        $persentase_fisik = (count($explode_indikator)/count($data_indikator))*100;
        $data_insert1 = array(
            'id_laporan_sarling' => $get_id_laporan_sarling['id_laporan_sarling']+1,
            'id_anggota_sarling' => $get_data_sarling->ketua,
            'user_id' => $get_data_sarling->id_ketua,
            'id_sarling' => $this->input->post('id_sarling'),
            'indikator' => $tampung_indikator,
            'persentase_fisik' => $persentase_fisik,
            'anggaran' => $total_uang,
            'persentase_anggaran' => ($total_uang/$get_data_sarling->rencana_anggaran)*100,
            'persentase_realisasi' => ((($total_uang/$get_data_sarling->rencana_anggaran)*100)+$persentase_fisik)/2,
            'keterangan' => $this->input->post('keterangan'),
            'created_at' => date('Y-m-d H:i:s'),
            'created_by' => $this->session->userdata('id')
        );
        // print_r($data_insert1);
        $this->Main_model->insertData('laporan_sarling',$data_insert1);
        if($get_status_laporan_sarling==NULL){
            $persentase_anggaran = ($total_uang/$get_data_sarling->rencana_anggaran)*100;
            $persentase_realisasi = ($persentase_anggaran+$persentase_fisik)/2;
            $data_insert3 = array(
                'id_sarling' => $this->input->post('id_sarling'),
                'indikator' => $tampung_indikator,
                'persentase_fisik' => $persentase_fisik,
                'anggaran' => $total_uang,
                'persentase_anggaran' => $persentase_anggaran,
                'persentase_realisasi' => $persentase_realisasi
            );
            // print_r($data_insert3);
            $this->Main_model->insertData('status_laporan_sarling',$data_insert3);
        }else{
            $bb = explode(',',$get_status_laporan_sarling->indikator);
            $c = array_unique(array_merge($get_indikator,$bb));
            $d = implode(',',$c);
            $persentase_fisik2 = (count($c)/count($data_indikator))*100;
            $persentase_anggaran = (($total_uang+$get_status_laporan_sarling->anggaran)/$get_data_sarling->rencana_anggaran)*100;
            $persentase_realisasi = ($persentase_anggaran+$persentase_fisik2)/2;
            $data_update1 = array(
                'indikator' => $d,
                'persentase_fisik' => $persentase_fisik2,
                'anggaran' => $total_uang+$get_status_laporan_sarling->anggaran,
                'persentase_anggaran' => $persentase_anggaran,
                'persentase_realisasi' => $persentase_realisasi
            );
            // print_r($data_update1);
            $this->Main_model->updateData('status_laporan_sarling',$data_update1,array('id_sarling'=>$get_status_laporan_sarling->id_sarling));
        }
        $this->Main_model->log_activity($this->session->userdata('id'),'Adding data',"Add sarling's report data (".$get_data_sarling->nama_tim.")",$this->session->userdata('location'));
        $this->db->trans_complete();
        if($this->db->trans_status() === false){
            $this->session->set_flashdata('gagal','<div class="alert alert-warning"><button type="button" class="close" data-dismiss="alert"><i class="ace-icon fa fa-times"></i></button><strong></i>Oops! </strong>data gagal ditambahkan.<br /></div>' );
            echo "<script>window.location='".base_url()."admin_side/tambah_laporan_sarling/'</script>";
        }
        else{
            $this->session->set_flashdata('sukses','<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert"><i class="ace-icon fa fa-times"></i></button><strong></i>Yeah! </strong>data telah berhasil ditambahkan.<br /></div>' );
            echo "<script>window.location='".base_url()."admin_side/laporan_sarling/'</script>";
        }
    }
    public function detail_sarling_report()
    {
        $data['parent'] = 'report';
        $data['child'] = 'sarling';
        $data['grand_child'] = '';
        $data['status_laporan'] = $this->Main_model->getSelectedData('status_laporan_sarling a', 'a.*', array('md5(a.id_sarling)'=>$this->uri->segment(3)))->row();
        $data['data_detail_laporan'] = $this->Main_model->getSelectedData('laporan_sarling a', 'a.*,b.fullname',array('md5(a.id_sarling)'=>$this->uri->segment(3),'a.deleted'=>'0'),'','','','',array(
            'table' => 'user_profile b',
            'on' => 'a.user_id=b.user_id',
            'pos' => 'LEFT',
        ))->result();
        $data['data_utama'] = $this->Main_model->getSelectedData('sarling a', 'a.*,z.jenis_sarling,f.nm_provinsi,b.nm_kabupaten,c.nm_kecamatan,d.nm_desa', array('md5(a.id_sarling)'=>$this->uri->segment(3),'a.deleted'=>'0'),'','','','',array(
            array(
                'table' => 'provinsi f',
                'on' => 'a.id_provinsi=f.id_provinsi',
                'pos' => 'left',
            ),
            array(
                'table' => 'kabupaten b',
                'on' => 'a.id_kabupaten=b.id_kabupaten',
                'pos' => 'left',
            ),
            array(
                'table' => 'kecamatan c',
                'on' => 'a.id_kecamatan=c.id_kecamatan',
                'pos' => 'left',
            ),
            array(
                'table' => 'desa d',
                'on' => 'a.id_desa=d.id_desa',
                'pos' => 'left',
            ),
            array(
                'table' => 'jenis_sarling z',
                'on' => 'a.id_jenis_sarling=z.id_jenis_sarling',
                'pos' => 'left'
            )
        ))->result();
        $this->load->view('admin/template/header',$data);
        $this->load->view('admin/report/detail_sarling_report',$data);
        $this->load->view('admin/template/footer');
    }
    public function edit_sarling_report(){
        $data['parent'] = 'report';
        $data['child'] = 'sarling';
        $data['grand_child'] = '';
        $get_id_sarling = $this->Main_model->getSelectedData('laporan_sarling a', 'a.*,b.fullname',array('md5(a.id_laporan_sarling)'=>$this->uri->segment(3),'a.deleted'=>'0'),'','','','',array(
            'table' => 'user_profile b',
            'on' => 'a.user_id=b.user_id',
            'pos' => 'LEFT'
        ))->row();
        $data['data_detail_laporan'] = $get_id_sarling;
        $data['status_laporan'] = $this->Main_model->getSelectedData('status_laporan_sarling a', 'a.*', array('a.id_sarling'=>$get_id_sarling->id_sarling))->row();
        $data['data_utama'] = $this->Main_model->getSelectedData('sarling a', 'a.*,f.nm_provinsi,b.nm_kabupaten,c.nm_kecamatan,d.nm_desa', array('a.id_sarling'=>$get_id_sarling->id_sarling,'a.deleted'=>'0'),'','','','',array(
            array(
                'table' => 'provinsi f',
                'on' => 'a.id_provinsi=f.id_provinsi',
                'pos' => 'left',
            ),
            array(
                'table' => 'kabupaten b',
                'on' => 'a.id_kabupaten=b.id_kabupaten',
                'pos' => 'left',
            ),
            array(
                'table' => 'kecamatan c',
                'on' => 'a.id_kecamatan=c.id_kecamatan',
                'pos' => 'left',
            ),
            array(
                'table' => 'desa d',
                'on' => 'a.id_desa=d.id_desa',
                'pos' => 'left',
            )
        ))->row();
        $data['indikator'] = $this->Main_model->getSelectedData('master_indikator a', 'a.*')->result();
        $this->load->view('admin/template/header',$data);
        $this->load->view('admin/report/edit_sarling_report',$data);
        $this->load->view('admin/template/footer');
    }
    public function update_sarling_report(){
        $this->db->trans_start();
        $get_id_laporan_sarling = $this->Main_model->getSelectedData('laporan_sarling a', 'a.*', array('md5(a.id_laporan_sarling)'=>$this->input->post('id_laporan_sarling')))->row_array();
        $get_data_sarling = $this->Main_model->getSelectedData('sarling a', 'a.*', array('md5(a.id_sarling)'=>$this->input->post('id_sarling')))->row();
        $indikator = $this->Main_model->getSelectedData('master_indikator a', 'a.*')->result();
        $data_indikator = $this->Main_model->getSelectedData('indikator a', 'a.*', array('a.program'=>'3'))->result();
        $total_uang = 0;
        $get_indikator = array();

        foreach ($indikator as $key => $value) {
            $push = $this->input->post('progres_keuangan_'.$value->id_master_indikator);
            if($push==NULL){
                $check_value = $this->Main_model->getSelectedData('detail_laporan_sarling_aspek_keuangan a', 'a.*', array('md5(a.id_laporan_sarling)'=>$this->input->post('id_laporan_sarling'),'a.id_master_indikator'=>$value->id_master_indikator))->row();
                if($check_value==NULL){
                    echo'';
                }else{
                    $total_uang -= $check_value->progres_keuangan;
                    $this->Main_model->deleteData('detail_laporan_sarling_aspek_keuangan',array('id_detail_laporan_sarling'=>$check_value->id_detail_laporan_sarling));
                }
            }else{
                $check_value = $this->Main_model->getSelectedData('detail_laporan_sarling_aspek_keuangan a', 'a.*', array('md5(a.id_laporan_sarling)'=>$this->input->post('id_laporan_sarling'),'a.id_master_indikator'=>$value->id_master_indikator))->row();
                if($check_value==NULL){
                    $total_uang += $this->input->post('progres_keuangan_'.$value->id_master_indikator);
                    $data_insert2b = array(
                        'id_laporan_sarling' => $get_id_laporan_sarling['id_laporan_sarling'],
                        'id_master_indikator' => $value->id_master_indikator,
                        'progres_keuangan' => $this->input->post('progres_keuangan_'.$value->id_master_indikator)
                    );
                    // print_r($data_insert2b);
                    $this->Main_model->insertData('detail_laporan_sarling_aspek_keuangan',$data_insert2b);
                }else{
                    $total_uang += $this->input->post('progres_keuangan_'.$value->id_master_indikator);
                    $data_insert2b = array(
                        'progres_keuangan' => $this->input->post('progres_keuangan_'.$value->id_master_indikator)
                    );
                    // print_r($data_insert2b);
                    $this->Main_model->updateData('detail_laporan_sarling_aspek_keuangan',$data_insert2b,array('id_detail_laporan_sarling'=>$check_value->id_detail_laporan_sarling));
                }
            }
        }

        foreach ($data_indikator as $key => $value) {
            $push = $this->input->post('indikator_progres_fisik_'.$value->id_indikator);
            if($push==NULL){
                $check_value = $this->Main_model->getSelectedData('detail_laporan_sarling_aspek_fisik a', 'a.*', array('md5(a.id_laporan_sarling)'=>$this->input->post('id_laporan_sarling'),'a.indikator_progres_fisik'=>$value->id_indikator))->row();
                if($check_value==NULL){
                    echo'';
                }else{
                    $this->Main_model->deleteData('detail_laporan_sarling_aspek_fisik',array('id_detail_laporan_sarling'=>$check_value->id_detail_laporan_sarling));
                }
            }else{
                array_push($get_indikator,implode(',',$this->input->post('indikator_progres_fisik_'.$value->id_indikator)));
                $check_value = $this->Main_model->getSelectedData('detail_laporan_sarling_aspek_fisik a', 'a.*', array('md5(a.id_laporan_sarling)'=>$this->input->post('id_laporan_sarling'),'a.indikator_progres_fisik'=>$value->id_indikator))->row();
                if($check_value==NULL){
                    $data_insert2a = array(
                        'id_laporan_sarling' => $get_id_laporan_sarling['id_laporan_sarling'],
                        'id_master_indikator' => $value->id_master_indikator,
                        'indikator_progres_fisik' => $value->id_indikator,
                        'penjelasan_progres_fisik' => $this->input->post('penjelasan_progres_fisik_'.$value->id_indikator)
                    );
                    // print_r($data_insert2a);
                    $this->Main_model->insertData('detail_laporan_sarling_aspek_fisik',$data_insert2a);
                }else{
                    $data_insert2a = array(
                        'penjelasan_progres_fisik' => $this->input->post('penjelasan_progres_fisik_'.$value->id_indikator)
                    );
                    // print_r($data_insert2a);
                    $this->Main_model->updateData('detail_laporan_sarling_aspek_fisik',$data_insert2a,array('id_detail_laporan_sarling'=>$check_value->id_detail_laporan_sarling));
                }
            }
        }

        $tampung_indikator = implode(',',$get_indikator);
        $explode_indikator = explode(',',$tampung_indikator);
        $persentase_fisik = (count($explode_indikator)/count($data_indikator))*100;
        $data_insert1 = array(
            'indikator' => $tampung_indikator,
            'persentase_fisik' => $persentase_fisik,
            'anggaran' => $total_uang,
            'persentase_anggaran' => ($total_uang/$get_data_sarling->rencana_anggaran)*100,
            'persentase_realisasi' => ((($total_uang/$get_data_sarling->rencana_anggaran)*100)+$persentase_fisik)/2,
            'keterangan' => $this->input->post('keterangan')
        );
        // print_r($data_insert1);
        $this->Main_model->updateData('laporan_sarling',$data_insert1,array('id_laporan_sarling'=>$get_id_laporan_sarling['id_laporan_sarling']));
        
        $get_total_uang = $this->Main_model->getSelectedData('sarling a', 'a.*,(SELECT SUM(b.anggaran) FROM laporan_sarling b WHERE b.id_sarling=a.id_sarling AND b.deleted="0") AS total_uang', array('md5(a.id_sarling)'=>$this->input->post('id_sarling'),'a.deleted'=>'0'))->row();
        $get_total_indikator = $this->Main_model->getSelectedData('detail_laporan_sarling_aspek_fisik a', 'a.*', array('md5(b.id_sarling)'=>$this->input->post('id_sarling'),'b.deleted'=>'0'),'','','','a.indikator_progres_fisik',array(
            'table' => 'laporan_sarling b',
            'on' => 'a.id_laporan_sarling=b.id_laporan_sarling',
            'pos' => 'LEFT'
        ))->result();
        $total_indikator = array();
        foreach ($get_total_indikator as $key => $value) {
            array_push($total_indikator,$value->indikator_progres_fisik);
        }
        $persentase_realisasi = ((($get_total_uang->total_uang/$get_data_sarling->rencana_anggaran)*100)+((count($total_indikator)/count($data_indikator))*100))/2;
        $data_update1 = array(
            'indikator' => implode(',',$total_indikator),
            'persentase_fisik' => (count($total_indikator)/count($data_indikator))*100,
            'anggaran' => $get_total_uang->total_uang,
            'persentase_anggaran' => ($get_total_uang->total_uang/$get_data_sarling->rencana_anggaran)*100,
            'persentase_realisasi' => $persentase_realisasi
        );
        // print_r($data_update1);
        $this->Main_model->updateData('status_laporan_sarling',$data_update1,array('md5(id_sarling)'=>$this->input->post('id_sarling')));

        $this->Main_model->log_activity($this->session->userdata('id'),'Updating data',"Update Sarling's report data (".$get_data_sarling->nama_tim.")",$this->session->userdata('location'));
        $this->db->trans_complete();
        if($this->db->trans_status() === false){
            $this->session->set_flashdata('gagal','<div class="alert alert-warning"><button type="button" class="close" data-dismiss="alert"><i class="ace-icon fa fa-times"></i></button><strong></i>Oops! </strong>data gagal diperbarui.<br /></div>' );
            echo "<script>window.location='".base_url()."admin_side/ubah_data_laporan_sarling/".$this->input->post('id_laporan_sarling')."'</script>";
        }
        else{
            $this->session->set_flashdata('sukses','<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert"><i class="ace-icon fa fa-times"></i></button><strong></i>Yeah! </strong>data telah berhasil diperbarui.<br /></div>' );
            echo "<script>window.location='".base_url()."admin_side/detil_laporan_sarling/".$this->input->post('id_sarling')."'</script>";
        }
    }
    public function delete_sarling_report(){
        $this->db->trans_start();
        $get_data = $this->Main_model->getSelectedData('laporan_sarling a', 'a.*',array('md5(a.id_laporan_sarling)'=>$this->uri->segment(3)))->row();
        $get_status_laporan_sarling = $this->Main_model->getSelectedData('status_laporan_sarling a', 'a.*',array('a.id_sarling'=>$get_data->id_sarling))->row();
        $indikator_status = explode(',',$get_status_laporan_sarling->indikator);
        $indikator_laporan = explode(',',$get_data->indikator);

        $array_indikator_update = array();
        $status = '';
        for ($i=0; $i < count($indikator_status); $i++) { 
            for ($j=0; $j < count($indikator_laporan); $j++) { 
                if($indikator_laporan[$j]==$indikator_status[$i]){
                    $status = '0';
                    break;
                }else{
                    $status = '1';
                }	
            }
            if($status=='0'){
                echo'';
            }else{
                $array_indikator_update[] = $indikator_status[$i];
            }
        }

        $this->Main_model->updateData('laporan_sarling',array('deleted'=>'1'),array('md5(id_laporan_sarling)'=>$this->uri->segment(3)));
        $data_update = array(
            'indikator' => implode(',',array_unique($array_indikator_update)),
            'persentase_fisik' => ($get_status_laporan_sarling->persentase_fisik)-($get_data->persentase_fisik),
            'anggaran' => ($get_status_laporan_sarling->anggaran)-($get_data->anggaran),
            'persentase_anggaran' => ($get_status_laporan_sarling->persentase_anggaran)-($get_data->persentase_anggaran),
            'persentase_realisasi' => ($get_status_laporan_sarling->persentase_realisasi)-($get_data->persentase_realisasi)
        );
        // print_r($data_update);
        $this->Main_model->updateData('status_laporan_sarling',$data_update,array('id_sarling'=>$get_status_laporan_sarling->id_sarling));

        $this->Main_model->log_activity($this->session->userdata('id'),"Deleting sarling's report","Delete sarling's report",$this->session->userdata('location'));
        $this->db->trans_complete();
        if($this->db->trans_status() === false){
            $this->session->set_flashdata('gagal','<div class="alert alert-warning"><button type="button" class="close" data-dismiss="alert"><i class="ace-icon fa fa-times"></i></button><strong></i>Oops! </strong>data gagal dihapus.<br /></div>' );
            echo "<script>window.location='".base_url()."admin_side/detil_laporan_sarling/".md5($get_data->id_sarling)."'</script>";
        }
        else{
            $this->session->set_flashdata('sukses','<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert"><i class="ace-icon fa fa-times"></i></button><strong></i>Yeah! </strong>data telah berhasil dihapus.<br /></div>' );
            echo "<script>window.location='".base_url()."admin_side/detil_laporan_sarling/".md5($get_data->id_sarling)."'</script>";
        }
    }
}
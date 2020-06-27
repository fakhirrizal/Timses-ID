<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Report extends CI_Controller {
    function __construct() {
        parent::__construct();
    }
    public function rekap_isu(){
        $data['parent'] = 'task';
        $data['child'] = 'issue';
        $data['grand_child'] = '';
        $this->load->view('relawan/template/header',$data);
        $this->load->view('relawan/report/rekap_isu',$data);
        $this->load->view('relawan/template/footer');
    }
    public function json_issue_data(){
		$get_info = $this->Main_model->getSelectedData('user_to_role a', 'a.*', array('a.user_id'=>$this->session->userdata('id')))->row();
		$url1 = 'http://kertasfolio.id:99/api/relawanisu/all/'.$get_info->id_event;
		$data = $this->Main_model->getAPI($url1);
		$data_tampil = array();
		$no = 1;
		foreach ($data as $key => $value) {
            $isi['number'] = $no++.'.';
            $isi['judul'] = $value['judul'];
            $isi['desc'] = $value['deskripsi'];
            $url2 = 'http://kertasfolio.id:99/api/relawanprofiles/getProfile/'.$value['idRelawan'];
            $data_relawan = $this->Main_model->getAPI($url2);
            $isi['nama'] = $data_relawan['namaRelawan'];
            $isi['date'] = $this->Main_model->convert_tanggal(substr($value['createdDate'],0,10));
            $wilayah = '';
            if(strlen($value['idWilayah'])=='2'){
                $url2 = 'http://kertasfolio.id:99/api/prov/id/'.$value['idWilayah'];
                $data_prov = $this->Main_model->getAPI($url2);
                $wilayah = $data_prov['namaProvinsi'];
            }elseif(strlen($value['idWilayah'])=='4'){
                $url2 = 'http://kertasfolio.id:99/api/kab/id/'.$value['idWilayah'];
                $data_kab = $this->Main_model->getAPI($url2);
                $wilayah = $data_kab['namaKabupaten'];
            }elseif(strlen($value['idWilayah'])=='7'){
                $url2 = 'http://kertasfolio.id:99/api/kec/id/'.$value['idWilayah'];
                $data_kab = $this->Main_model->getAPI($url2);
                $wilayah = $data_kab['namaKecamatan'];
            }else{
                echo'';
            }
            $isi['wilayah'] = $wilayah;
            $return_on_click = "return confirm('Anda yakin?')";
            $isi['action'] =	'
                            <div class="dropdown">
                                <button class="btn btn-xs green dropdown-toggle" type="button" data-toggle="dropdown" aria-expanded="false"> Aksi
                                    <i class="fa fa-angle-down"></i>
                                </button>
                                <ul class="dropdown-menu pull-right" role="menu">
                                    <li>
                                        <a onclick="'.$return_on_click.'" href="'.site_url('relawan_side/hapus_data_isu/'.$value['idIsu']).'">
                                            <i class="icon-trash"></i> Hapus Data </a>
                                    </li>
                                </ul>
                            </div>
                            ';
            
            $data_tampil[] = $isi;
		}
		$results = array(
			"sEcho" => 1,
			"iTotalRecords" => count($data_tampil),
			"iTotalDisplayRecords" => count($data_tampil),
			"aaData"=>$data_tampil);
		echo json_encode($results);
    }
    public function hapus_data_isu(){
		$this->db->trans_start();
		$where = $this->uri->segment(3);
		$url1 = 'http://kertasfolio.id:99/api/relawanisu/delete/'.$where;
		$this->Main_model->deleteAPI($url1);
		$this->db->trans_complete();
		if($this->db->trans_status() === false){
			$this->session->set_flashdata('gagal','<div class="alert alert-warning"><button type="button" class="close" data-dismiss="alert"><i class="ace-icon fa fa-times"></i></button><strong></i>Oops! </strong>data gagal dihapus.<br /></div>' );
			echo "<script>window.location='".base_url()."relawan_side/rekap_isu/'</script>";
		}
		else{
			$this->session->set_flashdata('sukses','<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert"><i class="ace-icon fa fa-times"></i></button><strong></i>Yeah! </strong>data telah berhasil dihapus.<br /></div>' );
			echo "<script>window.location='".base_url()."relawan_side/rekap_isu/'</script>";
		}
	}
}
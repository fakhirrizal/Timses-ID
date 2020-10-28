<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Master extends CI_Controller {
	function __construct() {
		parent::__construct();
	}
	/* Relawan */
	public function relawan_data()
	{
		$data['parent'] = 'relawan';
		$data['child'] = '';
		$data['grand_child'] = '';
		// $data['data_tabel'] = $this->Main_model->getSelectedData('kube a', 'a.*', array('a.deleted'=>'0'), "a.fullname ASC")->result();
		$this->load->view('relawan/template/header',$data);
		$this->load->view('relawan/master/relawan_data',$data);
		$this->load->view('relawan/template/footer');
	}
	public function json_relawan_data(){
		$get_info = $this->Main_model->getSelectedData('user_to_role a', 'a.*', array('a.user_id'=>$this->session->userdata('id')))->row();
		$url1 = 'http://pradi.is-very-good.org:7733/api/relawandatas/byevent/'.$get_info->id_event;
		$data = $this->Main_model->getAPI($url1);
		$url2 = 'http://pradi.is-very-good.org:7733/api/event/id/'.$get_info->id_event;
		$data_event = $this->Main_model->getAPI($url2);
		$url3 = 'http://pradi.is-very-good.org:7733/api/rolesevent/id/'.$data_event['roleEvent'];
		$role_event = $this->Main_model->getAPI($url3);
		$data_tampil = array();
		$no = 1;
		$keterangan = '';
		if($get_info->keterangan=='ADMIN KABUPATEN'){
			$keterangan = 'PILKADA KAB/KOTA';
		}else{
			$keterangan = $get_info->keterangan;
		}
		if($keterangan==$role_event['namaRoleEvent']){
			foreach ($data as $key => $value) {
				$isi['checkbox'] =	'
									<label class="mt-checkbox mt-checkbox-single mt-checkbox-outline">
										<input type="checkbox" class="checkboxes" name="selected_id[]" value="'.$value['idRelawan'].'"/>
										<span></span>
									</label>
									';
				$isi['number'] = $no++.'.';
				$url2 = 'http://pradi.is-very-good.org:7733/api/relawanprofiles/getProfile/'.$value['idRelawan'];
				$data_r = $this->Main_model->getAPI($url2);
				$isi['nama'] = $data_r['namaRelawan'];
				$isi['nik'] = $data_r['NIK'];
				$isi['no_hp'] = $value['telepon'];
				$isi['pekerjaan'] = $data_r['pekerjaan'];
				
				$url5 = 'http://pradi.is-very-good.org:7733/api/kec/id/'.$data_r['idKecamatan'];
				$data_kec = $this->Main_model->getAPI($url5);
				$url6 = 'http://pradi.is-very-good.org:7733/api/desa/id/'.$data_r['idDesa'];
				$data_desa = $this->Main_model->getAPI($url6);
				
				$isi['wilayah'] = $data_desa['namaDesa'].', '.$data_kec['namaKecamatan'];
				$return_on_click = "return confirm('Anda yakin?')";
				$isi['aksi'] =	'
									<div class="btn-group">
										<button class="btn btn-xs green dropdown-toggle" type="button" data-toggle="dropdown" aria-expanded="false"> Aksi
											<i class="fa fa-angle-down"></i>
										</button>
										<ul class="dropdown-menu pull-right" role="menu">
											<li>
												<a href="'.site_url('relawan_side/ubah_data_relawan/'.$value['idRelawan']).'">
													<i class="icon-wrench"></i> Ubah Data </a>
											</li>
											<li>
												<a onclick="'.$return_on_click.'" href="'.site_url('relawan_side/hapus_data_relawan/'.$value['idRelawan']).'">
													<i class="icon-trash"></i> Hapus Data </a>
											</li>
										</ul>
									</div>
									';
				$data_tampil[] = $isi;
			}
		}elseif($keterangan=='ADMIN KECAMATAN'){
			foreach ($data as $key => $value) {
				$url2 = 'http://pradi.is-very-good.org:7733/api/relawanprofiles/getProfile/'.$value['idRelawan'];
				$data_r = $this->Main_model->getAPI($url2);
				if($data_r['idKecamatan']==$get_info->wilayah){
					$isi['number'] = $no++.'.';
					
					$isi['nama'] = $data_r['namaRelawan'];
					$isi['nik'] = $data_r['NIK'];
					$isi['no_hp'] = $value['telepon'];
					$isi['pekerjaan'] = $data_r['pekerjaan'];
					
					$url5 = 'http://pradi.is-very-good.org:7733/api/kec/id/'.$data_r['idKecamatan'];
					$data_kec = $this->Main_model->getAPI($url5);
					$url6 = 'http://pradi.is-very-good.org:7733/api/desa/id/'.$data_r['idDesa'];
					$data_desa = $this->Main_model->getAPI($url6);
					
					$isi['wilayah'] = $data_desa['namaDesa'].', '.$data_kec['namaKecamatan'];
					$return_on_click = "return confirm('Anda yakin?')";
					$isi['aksi'] =	'
										<div class="btn-group">
											<button class="btn btn-xs green dropdown-toggle" type="button" data-toggle="dropdown" aria-expanded="false"> Aksi
												<i class="fa fa-angle-down"></i>
											</button>
											<ul class="dropdown-menu pull-right" role="menu">
												<li>
													<a href="'.site_url('relawan_side/ubah_data_relawan/'.$value['idRelawan']).'">
														<i class="icon-wrench"></i> Ubah Data </a>
												</li>
												<li>
													<a onclick="'.$return_on_click.'" href="'.site_url('relawan_side/hapus_data_relawan/'.$value['idRelawan']).'">
														<i class="icon-trash"></i> Hapus Data </a>
												</li>
											</ul>
										</div>
										';
					$data_tampil[] = $isi;
				}else{
					echo'';
				}
			}
		}else{
			echo'';
		}
		$results = array(
			"sEcho" => 1,
			"iTotalRecords" => count($data_tampil),
			"iTotalDisplayRecords" => count($data_tampil),
			"aaData"=>$data_tampil);
		echo json_encode($results);
	}
	public function add_relawan_data()
	{
		$data['parent'] = 'relawan';
		$data['child'] = '';
		$data['grand_child'] = '';
		$role_event = $this->Main_model->getSelectedData('user_to_role a', 'a.*', array('a.user_id'=>$this->session->userdata('id')))->row();
		$url1 = 'http://pradi.is-very-good.org:7733/api/event/id/'.$role_event->id_event;
		$data['get_info'] = $this->Main_model->getAPI($url1);
		$this->load->view('relawan/template/header',$data);
		$this->load->view('relawan/master/add_relawan_data',$data);
		$this->load->view('relawan/template/footer');
	}
	public function save_relawan_data(){
		$cek_data = $this->Main_model->getSelectedData('user a', 'a.*', array('a.username'=>$this->input->post('no_hp')))->result();
		if($cek_data==NULL){
			$get_info = $this->Main_model->getSelectedData('user_to_role a', 'a.*', array('a.user_id'=>$this->session->userdata('id')))->row();
			$url0 = 'http://pradi.is-very-good.org:7733/api/event/id/'.$get_info->id_event;
			$data_event = $this->Main_model->getAPI($url0);
			$user_id = $this->Main_model->getLastID('user','id');
			$url_insert1 = 'http://pradi.is-very-good.org:7733/api/userdatas/register';
			$id = $user_id['id']+1;
			$data_insert1 = array(
				"idUserDatas"=> $id.random_string('alnum', 4),
				"idEvent"=> $this->input->post('id_event'),
				"idWilayah"=> $this->input->post('desa'),
				"username"=> $this->input->post('no_hp'),
				"password"=> $this->input->post('nik'),
				"telepon"=> $this->input->post('no_hp'),
				"namaUser"=> $this->input->post('nama'),
				"roleEvent"=> $data_event['roleEvent'],
				"roleUser"=> 'C28A1E26-19BD-4813-9247-8333F7ED917D',
				"isActive"=> true,
				'keterangan' => $id,
				'createdDate'=> date("Y-m-d").'T05:39:56.757Z'
			);
			// print_r($data_insert1);
			$url_insert2 = 'http://pradi.is-very-good.org:7733/api/relawandatas/register';
			$data_insert2 = array(
				"idRelawan"=> $id.random_string('alnum', 4),
				"idEvent"=> $this->input->post('id_event'),
				"telepon"=> $this->input->post('no_hp'),
				"password"=> $this->input->post('nik'),
				"isActive"=> 'true',
				"namaRelawan"=> $this->input->post('nama'),
				"NIK"=> $this->input->post('nik'),
				"pekerjaan"=> $this->input->post('pekerjaan'),
				"idDesa"=> $this->input->post('desa'),
				"idKecamatan"=> $this->input->post('kecamatan'),
				"idKabupaten"=> $this->input->post('kabupaten'),
				"idProvinsi"=> $this->input->post('provinsi'),
				'createdDate'=> date("Y-m-d").'T05:39:56.757Z'
			);
			// print_r($data_insert2);
			$this->db->trans_start();
			$data1 = array(
						'id' => $id,
						'username' => $this->input->post('no_hp'),
						'pass' => $this->input->post('nik'),
						'username_api' => $this->input->post('no_hp'),
						'password_api' => $this->input->post('nik'),
						'total_login' => '1',
						'is_active' => '1',
						'created_at' => date('Y-m-d H:i:s'),
						'created_by' => $id
					);
			// print_r($data1);
			$this->Main_model->insertData('user',$data1);
	
			$data2 = array(
				'user_id' => $id,
				'fullname' => $this->input->post('nama'),
				'nin' => $this->input->post('nik')
			);
			// print_r($data2);
			$this->Main_model->insertData('user_profile',$data2);
	
			$data3 = array(
				'user_id' => $id,
				'role_id' => '5',
				'id_event' => $this->input->post('id_event'),
				'keterangan' => 'Relawan',
				'wilayah' => $this->input->post('wilayah')
			);
			// print_r($data3);
			$this->Main_model->insertData('user_to_role',$data3);
			$this->Main_model->log_activity($this->session->userdata('id'),'Inserting data',"Insert relawan data (".$this->input->post('nama').")",$this->session->userdata('location'));
			$this->db->trans_complete();
			$hasil_insert = $this->Main_model->insertAPI($url_insert1,$data_insert1);
			$hasil_insert = $this->Main_model->insertAPI($url_insert2,$data_insert2);
			if($hasil_insert>0){
				$this->session->set_flashdata('sukses','<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert"><i class="ace-icon fa fa-times"></i></button><strong></i>Yeah! </strong>data telah berhasil ditambahkan.<br /></div>' );
				echo "<script>window.location='".base_url()."relawan_side/daftar_relawan'</script>";
			}
			else{
				$this->session->set_flashdata('gagal','<div class="alert alert-warning"><button type="button" class="close" data-dismiss="alert"><i class="ace-icon fa fa-times"></i></button><strong></i>Oops! </strong>data gagal ditambahkan.<br /></div>' );
				echo "<script>window.location='".base_url()."relawan_side/tambah_data_relawan/'</script>";
			}
		}else{
			$this->session->set_flashdata('gagal','<div class="alert alert-warning"><button type="button" class="close" data-dismiss="alert"><i class="ace-icon fa fa-times"></i></button><strong></i>Oops! </strong>Username telah digunakan.<br /></div>' );
			echo "<script>window.location='".base_url()."relawan_side/tambah_data_relawan/'</script>";
		}
	}
	public function detail_relawan_data()
	{
		$data['parent'] = 'relawan';
		$data['child'] = '';
		$data['grand_child'] = '';
		// $data['data_utama'] =  $this->Main_model->getSelectedData('kube a', 'a.*', array('md5(a.user_id)'=>$this->uri->segment(3),'a.deleted'=>'0'))->result();
		// $data['riwayat_pembayaran'] = $this->Main_model->getSelectedData('purchasing a', 'a.*', array('md5(a.user_id)'=>$this->uri->segment(3),'a.deleted'=>'0'))->result();
		// $data['riwayat_kehadiran'] = $this->Main_model->getSelectedData('presence a', 'a.*', array('md5(a.user_id)'=>$this->uri->segment(3)))->result_array();
		$this->load->view('relawan/template/header',$data);
		$this->load->view('relawan/master/detail_relawan_data',$data);
		$this->load->view('relawan/template/footer');
	}
	public function edit_relawan_data($id)
	{
		$data['parent'] = 'relawan';
		$data['child'] = '';
		$data['grand_child'] = '';
		$url = 'http://pradi.is-very-good.org:7733/api/relawanprofiles/getDatas/'.$id;
		$data['data_utama'] = $this->Main_model->getAPI($url);;
		$this->load->view('relawan/template/header',$data);
		$this->load->view('relawan/master/edit_relawan_data',$data);
		$this->load->view('relawan/template/footer');
	}
	public function update_relawan_data(){
		$url_insert = 'http://pradi.is-very-good.org:7733/api/relawanprofiles/update';
		$data_insert = array(
			"idRelawan"=> $this->input->post('id_relawan'),
			"idEvent"=> $this->input->post('id_event'),
			"namaRelawan"=> $this->input->post('nama'),
			"NIK"=> $this->input->post('nik'),
			"pekerjaan"=> $this->input->post('pekerjaan'),
			"idDesa"=> $this->input->post('id_desa'),
			"idKecamatan"=> $this->input->post('id_kecamatan'),
			"idKabupaten"=> $this->input->post('id_kabupaten'),
			"idProvinsi"=> $this->input->post('id_provinsi'),
			'createdDate'=> $this->input->post('created_at')
		);
		// print_r($data_insert);
		$this->Main_model->log_activity($this->session->userdata('id'),'Updating data',"Update relawan data (".$this->input->post('nama').")",$this->session->userdata('location'));
		$hasil_insert = $this->Main_model->updateAPI($url_insert,$data_insert);
		if($hasil_insert!='1'){
			$this->session->set_flashdata('gagal','<div class="alert alert-warning"><button type="button" class="close" data-dismiss="alert"><i class="ace-icon fa fa-times"></i></button><strong></i>Oops! </strong>data gagal diubah.<br /></div>' );
			echo "<script>window.location='".base_url()."relawan_side/ubah_data_relawan/".$this->input->post('user_id')."'</script>";
		}
		else{
			$this->session->set_flashdata('sukses','<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert"><i class="ace-icon fa fa-times"></i></button><strong></i>Yeah! </strong>data telah berhasil diubah.<br /></div>' );
			echo "<script>window.location='".base_url()."relawan_side/daftar_relawan/'</script>";
		}
	}
	public function reset_password_relawan_account(){
		$this->db->trans_start();
		// do something your code
		$this->db->trans_complete();
		if($this->db->trans_status() === false){
			$this->session->set_flashdata('gagal','<div class="alert alert-warning"><button type="button" class="close" data-dismiss="alert"><i class="ace-icon fa fa-times"></i></button><strong></i>Oops! </strong>data gagal diubah.<br /></div>' );
			echo "<script>window.location='".base_url()."relawan_side/daftar_relawan/'</script>";
		}
		else{
			$this->session->set_flashdata('sukses','<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert"><i class="ace-icon fa fa-times"></i></button><strong></i>Yeah! </strong>data telah berhasil diubah.<br /></div>' );
			echo "<script>window.location='".base_url()."relawan_side/daftar_relawan/'</script>";
		}
	}
	public function delete_relawan_data(){
		$this->db->trans_start();
		$where = $this->uri->segment(3);
		$url2 = 'http://pradi.is-very-good.org:7733/api/relawandatas/id/'.$where;
		$getuserdata = $this->Main_model->getAPI($url2);
		$url1 = 'http://pradi.is-very-good.org:7733/api/relawandatas/delete/'.$where.'/'.$getuserdata['telepon'];
		$this->Main_model->deleteAPI($url1);
		$this->db->trans_complete();
		if($this->db->trans_status() === false){
			$this->session->set_flashdata('gagal','<div class="alert alert-warning"><button type="button" class="close" data-dismiss="alert"><i class="ace-icon fa fa-times"></i></button><strong></i>Oops! </strong>data gagal dihapus.<br /></div>' );
			echo "<script>window.location='".base_url()."relawan_side/daftar_relawan/'</script>";
		}
		else{
			$this->session->set_flashdata('sukses','<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert"><i class="ace-icon fa fa-times"></i></button><strong></i>Yeah! </strong>data telah berhasil dihapus.<br /></div>' );
			echo "<script>window.location='".base_url()."relawan_side/daftar_relawan/'</script>";
		}
	}
	/* Recruitment */
	public function recruitment_data()
	{
		$data['parent'] = 'rekrutmen';
		$data['child'] = '';
		$data['grand_child'] = '';
		// $data['data_tabel'] = $this->Main_model->getSelectedData('kube a', 'a.*', array('a.deleted'=>'0'), "a.fullname ASC")->result();
		$this->load->view('relawan/template/header',$data);
		$this->load->view('relawan/master/recruitment_data',$data);
		$this->load->view('relawan/template/footer');
	}
	public function json_recruitment_data(){
		$get_info = $this->Main_model->getSelectedData('user_to_role a', 'a.*', array('a.user_id'=>$this->session->userdata('id')))->row();
		$url2 = 'http://pradi.is-very-good.org:7733/api/rekrutmen/kec/'.$get_info->wilayah.'/'.$get_info->id_event;
		$data2 = $this->Main_model->getAPI($url2);
		$data_tampil = array();
		$no = 1;
		foreach ($data2 as $key => $value2) {
			$isi['checkbox'] =	'
								<label class="mt-checkbox mt-checkbox-single mt-checkbox-outline">
									<input type="checkbox" class="checkboxes" name="selected_id[]" value="'.$value2['idRekrutmen'].'"/>
									<span></span>
								</label>
								';
			$isi['number'] = $no++.'.';
			$isi['nama'] = $value2['namaRekrutmen'];
			$isi['nik'] = $value2['NIK'];
			$isi['no_hp'] = $value2['telepon'];

			$url_d = 'http://pradi.is-very-good.org:7733/api/desa/id/'.$value2['idDesa'];
			$data_kel = $this->Main_model->getAPI($url_d);
			$isi['wilayah'] = $data_kel['namaDesa'];
			
			$return_on_click = "return confirm('Anda yakin?')";
			$isi['aksi'] =	'
							<div class="btn-group">
								<button class="btn btn-xs green dropdown-toggle" type="button" data-toggle="dropdown" aria-expanded="false"> Aksi
									<i class="fa fa-angle-down"></i>
								</button>
								<ul class="dropdown-menu pull-right" role="menu">
									<li>
										<a href="'.site_url('relawan_side/ubah_data_rekrutan/'.$value2['idRekrutmen']).'">
											<i class="icon-wrench"></i> Ubah Data </a>
									</li>
									<li>
										<a onclick="'.$return_on_click.'" href="'.site_url('relawan_side/hapus_data_rekrutan/'.$value2['idRekrutmen']).'">
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
	public function add_administrator_data()
	{
		$data['parent'] = 'master';
		$data['child'] = 'administrator';
		$data['grand_child'] = '';
		$this->load->view('relawan/template/header',$data);
		$this->load->view('relawan/master/add_administrator_data',$data);
		$this->load->view('relawan/template/footer');
	}
	public function save_administrator_data(){
		$this->db->trans_start();
		// do something your code
		$this->db->trans_complete();
		if($this->db->trans_status() === false){
			$this->session->set_flashdata('gagal','<div class="alert alert-warning"><button type="button" class="close" data-dismiss="alert"><i class="ace-icon fa fa-times"></i></button><strong></i>Oops! </strong>data gagal ditambahkan.<br /></div>' );
			echo "<script>window.location='".base_url()."relawan_side/tambah_data_admin/'</script>";
		}
		else{
			$this->session->set_flashdata('sukses','<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert"><i class="ace-icon fa fa-times"></i></button><strong></i>Yeah! </strong>data telah berhasil ditambahkan.<br /></div>' );
			echo "<script>window.location='".base_url()."relawan_side/administrator/'</script>";
		}
	}
	public function detail_administrator_data()
	{
		$data['parent'] = 'master';
		$data['child'] = 'administrator';
		$data['grand_child'] = '';
		// $data['data_utama'] =  $this->Main_model->getSelectedData('kube a', 'a.*', array('md5(a.user_id)'=>$this->uri->segment(3),'a.deleted'=>'0'))->result();
		// $data['riwayat_pembayaran'] = $this->Main_model->getSelectedData('purchasing a', 'a.*', array('md5(a.user_id)'=>$this->uri->segment(3),'a.deleted'=>'0'))->result();
		// $data['riwayat_kehadiran'] = $this->Main_model->getSelectedData('presence a', 'a.*', array('md5(a.user_id)'=>$this->uri->segment(3)))->result_array();
		$this->load->view('relawan/template/header',$data);
		$this->load->view('relawan/master/detail_administrator_data',$data);
		$this->load->view('relawan/template/footer');
	}
	public function edit_administrator_data()
	{
		$data['parent'] = 'master';
		$data['child'] = 'administrator';
		$data['grand_child'] = '';
		// $data['data_utama'] = $this->Main_model->getSelectedData('user a', 'a.*', array('md5(a.user_id)'=>$this->uri->segment(3),'a.deleted'=>'0'))->result();
		$this->load->view('relawan/template/header',$data);
		$this->load->view('relawan/master/edit_administrator_data',$data);
		$this->load->view('relawan/template/footer');
	}
	public function update_administrator_data(){
		$this->db->trans_start();
		// do something your code
		$this->db->trans_complete();
		if($this->db->trans_status() === false){
			$this->session->set_flashdata('gagal','<div class="alert alert-warning"><button type="button" class="close" data-dismiss="alert"><i class="ace-icon fa fa-times"></i></button><strong></i>Oops! </strong>data gagal diubah.<br /></div>' );
			echo "<script>window.location='".base_url()."relawan_side/ubah_data_admin/".$this->input->post('user_id')."'</script>";
		}
		else{
			$this->session->set_flashdata('sukses','<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert"><i class="ace-icon fa fa-times"></i></button><strong></i>Yeah! </strong>data telah berhasil diubah.<br /></div>' );
			echo "<script>window.location='".base_url()."relawan_side/administrator/'</script>";
		}
	}
	public function reset_password_administrator_account(){
		$this->db->trans_start();
		// do something your code
		$this->db->trans_complete();
		if($this->db->trans_status() === false){
			$this->session->set_flashdata('gagal','<div class="alert alert-warning"><button type="button" class="close" data-dismiss="alert"><i class="ace-icon fa fa-times"></i></button><strong></i>Oops! </strong>data gagal diubah.<br /></div>' );
			echo "<script>window.location='".base_url()."relawan_side/administrator/'</script>";
		}
		else{
			$this->session->set_flashdata('sukses','<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert"><i class="ace-icon fa fa-times"></i></button><strong></i>Yeah! </strong>data telah berhasil diubah.<br /></div>' );
			echo "<script>window.location='".base_url()."relawan_side/administrator/'</script>";
		}
	}
	public function delete_administrator_data(){
		$this->db->trans_start();
		// do something your code
		$this->db->trans_complete();
		if($this->db->trans_status() === false){
			$this->session->set_flashdata('gagal','<div class="alert alert-warning"><button type="button" class="close" data-dismiss="alert"><i class="ace-icon fa fa-times"></i></button><strong></i>Oops! </strong>data gagal dihapus.<br /></div>' );
			echo "<script>window.location='".base_url()."relawan_side/administrator/'</script>";
		}
		else{
			$this->session->set_flashdata('sukses','<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert"><i class="ace-icon fa fa-times"></i></button><strong></i>Yeah! </strong>data telah berhasil dihapus.<br /></div>' );
			echo "<script>window.location='".base_url()."relawan_side/administrator/'</script>";
		}
	}
	/* Other Function */
	public function ajax_function(){
		if($this->input->post('modul')=='get_kabupaten_by_id_provinsi'){
			$url1 = 'http://pradi.is-very-good.org:7733/api/kab/prov/'.$this->input->post('id');
			$data = $this->Main_model->getAPI($url1);
			foreach ($data as $key => $value) {
				echo'<option value="'.$value['idKabupaten'].'">'.$value['namaKabupaten'].'</option>';
			}
		}
		elseif($this->input->post('modul')=='get_kecamatan_by_id_kabupaten'){
			$url1 = 'http://pradi.is-very-good.org:7733/api/kec/kab/'.$this->input->post('id');
			$data = $this->Main_model->getAPI($url1);
			foreach ($data as $key => $value) {
				echo'<option value="'.$value['idKecamatan'].'">'.$value['namaKecamatan'].'</option>';
			}
		}
		elseif($this->input->post('modul')=='get_desa_by_id_kecamatan'){
			$url1 = 'http://pradi.is-very-good.org:7733/api/desa/kec/'.$this->input->post('id');
			$data = $this->Main_model->getAPI($url1);
			foreach ($data as $key => $value) {
				echo'<option value="'.$value['idDesa'].'">'.$value['namaDesa'].'</option>';
			}
		}
		elseif($this->input->post('modul')=='get_wilayah_by_role_event'){
			if($this->input->post('id')=='1a'){
				$url1 = 'http://pradi.is-very-good.org:7733/api/prov/all/asc';
				$data = $this->Main_model->getAPI($url1);
				echo'
				<div class="form-group form-md-line-input has-danger">
					<label class="col-md-2 control-label" for="form_control_1"></label>
					<div class="col-md-10">
						<div class="input-icon">
							<select name="wilayah" class="form-control select2-allow-clear" required>
								<option value="">-- Pilih Provinsi --</option>';
								foreach ($data as $key => $value) {
									echo'<option value="'.$value['idProvinsi'].'">'.$value['namaProvinsi'].'</option>';
								}
								
				echo'		</select>
						</div>
					</div>
				</div>
				';
			}elseif($this->input->post('id')=='2a'){
				$url1 = 'http://pradi.is-very-good.org:7733/api/prov/all/asc';
				$data = $this->Main_model->getAPI($url1);
				echo'
				<div class="form-group form-md-line-input has-danger">
					<label class="col-md-2 control-label" for="form_control_1"></label>
					<div class="col-md-10">
						<div class="input-icon">
							<select id="provinsi" class="form-control select2-allow-clear" required>
								<option value="">-- Pilih Provinsi --</option>';
								foreach ($data as $key => $value) {
									echo'<option value="'.$value['idProvinsi'].'">'.$value['namaProvinsi'].'</option>';
								}
								
				echo'		</select>
						</div>
					</div>
				</div>
				<div class="form-group form-md-line-input has-danger">
					<label class="col-md-2 control-label" for="form_control_1"></label>
					<div class="col-md-10">
						<div class="input-icon">
							<select name="wilayah" id="kabupaten" class="form-control select2-allow-clear" required>
								<option value="">-- Pilih Kabupaten/ Kota --</option>
							</select>
						</div>
					</div>
				</div>
				';
			}elseif($this->input->post('id')=='3a'){
				$url1 = 'http://pradi.is-very-good.org:7733/api/prov/all/asc';
				$data = $this->Main_model->getAPI($url1);
				echo'
				<div class="form-group form-md-line-input has-danger">
					<label class="col-md-2 control-label" for="form_control_1"></label>
					<div class="col-md-10">
						<div class="input-icon">
							<select id="provinsi" class="form-control select2-allow-clear" required>
								<option value="">-- Pilih Provinsi --</option>';
								foreach ($data as $key => $value) {
									echo'<option value="'.$value['idProvinsi'].'">'.$value['namaProvinsi'].'</option>';
								}
								
				echo'		</select>
						</div>
					</div>
				</div>
				<div class="form-group form-md-line-input has-danger">
					<label class="col-md-2 control-label" for="form_control_1"></label>
					<div class="col-md-10">
						<div class="input-icon">
							<select id="kabupaten" class="form-control select2-allow-clear" required>
								<option value="">-- Pilih Kabupaten/ Kota --</option>
							</select>
						</div>
					</div>
				</div>
				<div class="form-group form-md-line-input has-danger">
					<label class="col-md-2 control-label" for="form_control_1"></label>
					<div class="col-md-10">
						<div class="input-icon">
							<select name="wilayah" id="kecamatan" class="form-control select2-allow-clear" required>
								<option value="">-- Pilih Kecamatan --</option>
							</select>
						</div>
					</div>
				</div>
				';
			}elseif($this->input->post('id')=='1b'){
				$data = $this->Main_model->getSelectedData('user_to_role a', 'a.*', array('a.user_id'=>$this->session->userdata('id')))->row();
				echo'<input type="hidden" name="wilayah" value="'.$data->wilayah.'"/>';
			}elseif($this->input->post('id')=='2b'){
				$getdata = $this->Main_model->getSelectedData('user_to_role a', 'a.*', array('a.user_id'=>$this->session->userdata('id')))->row();
				$url1 = 'http://pradi.is-very-good.org:7733/api/kab/prov/'.$getdata->wilayah;
				$data = $this->Main_model->getAPI($url1);
				echo'
				<div class="form-group form-md-line-input has-danger">
					<label class="col-md-2 control-label" for="form_control_1"></label>
					<div class="col-md-10">
						<div class="input-icon">
							<select name="wilayah" class="form-control select2-allow-clear" required>
								<option value="">-- Pilih Kabupaten/ Kota --</option>';
								foreach ($data as $key => $value) {
									echo'<option value="'.$value['idKabupaten'].'">'.$value['namaKabupaten'].'</option>';
								}
								
				echo'		</select>
						</div>
					</div>
				</div>
				';
			}elseif($this->input->post('id')=='3b'){
				$getdata = $this->Main_model->getSelectedData('user_to_role a', 'a.*', array('a.user_id'=>$this->session->userdata('id')))->row();
				$url1 = 'http://pradi.is-very-good.org:7733/api/kab/prov/'.$getdata->wilayah;
				$data = $this->Main_model->getAPI($url1);
				echo'
				<div class="form-group form-md-line-input has-danger">
					<label class="col-md-2 control-label" for="form_control_1"></label>
					<div class="col-md-10">
						<div class="input-icon">
							<select id="kabupaten" class="form-control select2-allow-clear" required>
								<option value="">-- Pilih Kabupaten/ Kota --</option>';
								foreach ($data as $key => $value) {
									echo'<option value="'.$value['idKabupaten'].'">'.$value['namaKabupaten'].'</option>';
								}
								
				echo'		</select>
						</div>
					</div>
				</div>
				<div class="form-group form-md-line-input has-danger">
					<label class="col-md-2 control-label" for="form_control_1"></label>
					<div class="col-md-10">
						<div class="input-icon">
							<select name="wilayah" id="kecamatan" class="form-control select2-allow-clear" required>
								<option value="">-- Pilih Kecamatan --</option>
							</select>
						</div>
					</div>
				</div>
				';
			}elseif($this->input->post('id')=='2c'){
				$data = $this->Main_model->getSelectedData('user_to_role a', 'a.*', array('a.user_id'=>$this->session->userdata('id')))->row();
				echo'<input type="hidden" name="wilayah" value="'.$data->wilayah.'"/>';
			}elseif($this->input->post('id')=='3c'){
				$getdata = $this->Main_model->getSelectedData('user_to_role a', 'a.*', array('a.user_id'=>$this->session->userdata('id')))->row();
				$url1 = 'http://pradi.is-very-good.org:7733/api/kec/kab/'.$getdata->wilayah;
				$data = $this->Main_model->getAPI($url1);
				echo'
				<div class="form-group form-md-line-input has-danger">
					<label class="col-md-2 control-label" for="form_control_1"></label>
					<div class="col-md-10">
						<div class="input-icon">
							<select name="wilayah" class="form-control select2-allow-clear" required>
								<option value="">-- Pilih Kecamatan --</option>';
								foreach ($data as $key => $value) {
									echo'<option value="'.$value['idKecamatan'].'">'.$value['namaKecamatan'].'</option>';
								}
								
				echo'		</select>
						</div>
					</div>
				</div>
				';
			}else{
				echo'';
			}
		}
	}
}
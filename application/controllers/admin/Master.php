<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Master extends CI_Controller {
	function __construct() {
		parent::__construct();
	}
	/* Event */
	public function event_data()
	{
		$data['parent'] = 'master';
		$data['child'] = 'event';
		$data['grand_child'] = '';
		$this->load->view('admin/template/header',$data);
		$this->load->view('admin/master/event_data',$data);
		$this->load->view('admin/template/footer');
	}
	public function json_event_data(){
		$url1 = 'http://kertasfolio.id:99/api/event/all/asc';
		$data = $this->Main_model->getAPI($url1);
		$data_tampil = array();
		$no = 1;
		foreach ($data as $key => $value) {
			$isi['checkbox'] =	'
								<label class="mt-checkbox mt-checkbox-single mt-checkbox-outline">
									<input type="checkbox" class="checkboxes" name="selected_id[]" value="'.$value['idEvent'].'"/>
									<span></span>
								</label>
								';
			$isi['number'] = $no++.'.';
			$url2 = 'http://kertasfolio.id:99/api/rolesevent/id/'.$value['roleEvent'];
			$nama_role_event = $this->Main_model->getAPI($url2);
			$isi['nama_event'] = $value['namaEvent'];
			$isi['role_event'] = $nama_role_event['namaRoleEvent'];
			$wilayah = '';
			if(strlen($value['idWilayahEvent'])=='2'){
				$url3 = 'http://kertasfolio.id:99/api/prov/id/'.$value['idWilayahEvent'];
				$data_prov = $this->Main_model->getAPI($url3);
				$wilayah = $data_prov['namaProvinsi'];
			}elseif(strlen($value['idWilayahEvent'])=='4'){
				$url3 = 'http://kertasfolio.id:99/api/kab/id/'.$value['idWilayahEvent'];
				$data_kab = $this->Main_model->getAPI($url3);
				$wilayah = $data_kab['namaKabupaten'];
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
											<a onclick="'.$return_on_click.'" href="'.site_url('admin_side/hapus_data_event/'.$value['idEvent']).'">
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
	public function add_event_data()
	{
		$data['parent'] = 'master';
		$data['child'] = 'event';
		$data['grand_child'] = '';
		$this->load->view('admin/template/header',$data);
		$this->load->view('admin/master/add_event_data',$data);
		$this->load->view('admin/template/footer');
	}
	public function save_event_data(){
		$url_insert = 'http://kertasfolio.id:99/api/event/insert';
		$data_insert = array(
			"namaEvent"=> $this->input->post('namaEvent'),
			"roleEvent"=> $this->input->post('roleEvent'),
			"idWilayahEvent"=> $this->input->post('idWilayahEvent'),
			'createdDate'=> date("Y-m-d").'T05:39:56.757Z',
		);
		$hasil_insert = $this->Main_model->insertAPI($url_insert,$data_insert);
		$this->Main_model->log_activity($this->session->userdata('id'),'Inserting data',"Insert event data (".$this->input->post('namaEvent').")",$this->session->userdata('location'));
		if($hasil_insert>0){
			$this->session->set_flashdata('sukses','<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert"><i class="ace-icon fa fa-times"></i></button><strong></i>Yeah! </strong>data telah berhasil ditambahkan.<br /></div>' );
            echo "<script>window.location='".site_url()."admin_side/event/'</script>";
		}
		else{
			$this->session->set_flashdata('gagal','<div class="alert alert-warning"><button type="button" class="close" data-dismiss="alert"><i class="ace-icon fa fa-times"></i></button><strong></i>Oops! </strong>data gagal ditambahkan.<br /></div>' );
            echo "<script>window.location='".site_url()."admin_side/tambah_data_event/'</script>";
		}
	}
	public function edit_event_data(){
		$data['parent'] = 'master';
		$data['child'] = 'event';
		$data['grand_child'] = '';
		$url = 'http://kertasfolio.id:99/api/event/id/'.$this->uri->segment(3);
		$data['data_event'] = $this->Main_model->getAPI($url);
		$this->load->view('admin/template/header',$data);
		$this->load->view('admin/master/edit_event_data',$data);
		$this->load->view('admin/template/footer');
	}
	public function update_event_data(){

	}
	public function delete_event_data(){
		$where = $this->uri->segment(3);
		$url2 = 'http://kertasfolio.id:99/api/event/id/'.$where;
		$get_event = $this->Main_model->getAPI($url2);
		$url1 = 'http://kertasfolio.id:99/api/event/delete/'.$where.'/'.$get_event['namaEvent'];
		$this->Main_model->deleteAPI($url1);
		$this->session->set_flashdata('sukses','<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert"><i class="ace-icon fa fa-times"></i></button><strong></i>Yeah! </strong>data telah berhasil dihapus.<br /></div>' );
		echo "<script>window.location='".site_url()."admin_side/event/'</script>";
	}
	/* Administrator */
	public function administrator_data()
	{
		$data['parent'] = 'master';
		$data['child'] = 'user';
		$data['grand_child'] = '';
		// $data['data_tabel'] = $this->Main_model->getSelectedData('kube a', 'a.*', array('a.deleted'=>'0'), "a.fullname ASC")->result();
		$this->load->view('admin/template/header',$data);
		$this->load->view('admin/master/administrator_data',$data);
		$this->load->view('admin/template/footer');
	}
	public function json_administrator_data(){
		$url1 = 'http://kertasfolio.id:99/api/userdatas/all/asc';
		$data = $this->Main_model->getAPI($url1);
		$data_tampil = array();
		$no = 1;
		foreach ($data as $key => $value) {
			if($value['roleUser']=='1019ce17-9c80-4beb-8e61-d064fb872cea'){
				$isi['checkbox'] =	'
									<label class="mt-checkbox mt-checkbox-single mt-checkbox-outline">
										<input type="checkbox" class="checkboxes" name="selected_id[]" value="'.$value['idUserDatas'].'"/>
										<span></span>
									</label>
									';
				$isi['number'] = $no++.'.';
				$isi['nama'] = $value['namaUser'];
				$isi['hp'] = $value['telepon'];
				if($value['idEvent']==NULL){
					$isi['event'] = '-';
				}else{
					$url2 = 'http://kertasfolio.id:99/api/event/id/'.$value['idEvent'];
					$data_e = $this->Main_model->getAPI($url2);
					$isi['event'] = $data_e['namaEvent'];
				}
				$return_on_click = "return confirm('Anda yakin?')";
				$isi['action'] =	'
								<div class="dropdown">
									<button class="btn btn-xs green dropdown-toggle" type="button" data-toggle="dropdown" aria-expanded="false"> Aksi
										<i class="fa fa-angle-down"></i>
									</button>
									<ul class="dropdown-menu pull-right" role="menu">
										<li>
											<a href="'.site_url('admin_side/ubah_data_pengguna/'.$value['idUserDatas']).'">
												<i class="icon-wrench"></i> Ubah Data </a>
										</li>
										<li>
											<a onclick="'.$return_on_click.'" href="'.site_url('admin_side/hapus_data_pengguna/'.$value['idUserDatas']).'">
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
		$data['child'] = 'user';
		$data['grand_child'] = '';
		$data['prov'] = $this->Main_model->getSelectedData('provinsi a', 'a.*')->result();
		$this->load->view('admin/template/header',$data);
		$this->load->view('admin/master/add_administrator_data',$data);
		$this->load->view('admin/template/footer');
	}
	public function save_administrator_data(){
		$cek_data = $this->Main_model->getSelectedData('user a', 'a.*', array('a.username'=>$this->input->post('username')))->result();
		if($cek_data==NULL){
			$user_id = $this->Main_model->getLastID('user','id');
			$url_insert = 'http://kertasfolio.id:99/api/userdatas/register';
			$data_insert = array(
				"idEvent"=> $this->input->post('event'),
				"username"=> $this->input->post('username'),
				"password"=> $this->input->post('pass'),
				"telepon"=> $this->input->post('no_hp'),
				"namaUser"=> $this->input->post('nama'),
				"roleEvent"=> $this->input->post('role'),
				"roleUser"=> '1019ce17-9c80-4beb-8e61-d064fb872cea',
				'keterangan' => $user_id['id']+1,
				'createdDate'=> date("Y-m-d").'T05:39:56.757Z'
			);
			print_r($data_insert);
			$this->db->trans_start();
			$data1 = array(
						'id' => $user_id['id']+1,
						'username' => $this->input->post('username'),
						'pass' => $this->input->post('pass'),
						'username_api' => $this->input->post('username'),
						'password_api' => $this->input->post('pass'),
						'total_login' => '1',
						'is_active' => '1',
						'created_at' => date('Y-m-d H:i:s'),
						'created_by' => $user_id['id']+1
					);
			// print_r($data1);
			$this->Main_model->insertData('user',$data1);
	
			$data2 = array(
				'user_id' => $user_id['id']+1,
				'fullname' => $this->input->post('nama')
			);
			// print_r($data2);
			$this->Main_model->insertData('user_profile',$data2);
	
			$role = '';
			if($this->input->post('role')=='dbabb74d-df5b-4b79-820b-057abdf99b1a'){
				$role = 'PILKADA KAB/KOTA';
			}elseif($this->input->post('role')=='5469458f-8760-45b1-b05a-a4ca3aab2461'){
				$role = 'PILKADA PROVINSI';
			}else{echo'SELURUH PILKADA';}
			$data3 = array(
				'user_id' => $user_id['id']+1,
				'role_id' => '1',
				'id_event' => $this->input->post('event'),
				'keterangan' => $role,
				'wilayah' => $this->input->post('wilayah')
			);
			// print_r($data3);
			$this->Main_model->insertData('user_to_role',$data3);
			$this->Main_model->log_activity($this->session->userdata('id'),'Inserting data',"Insert admin data (".$this->input->post('nama').")",$this->session->userdata('location'));
			$this->db->trans_complete();
			$hasil_insert = $this->Main_model->insertAPI($url_insert,$data_insert);
			if($hasil_insert>0){
				$this->session->set_flashdata('sukses','<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert"><i class="ace-icon fa fa-times"></i></button><strong></i>Yeah! </strong>data telah berhasil ditambahkan.<br /></div>' );
				echo "<script>window.location='".base_url()."admin_side/pengguna/'</script>";
			}
			else{
				$this->session->set_flashdata('gagal','<div class="alert alert-warning"><button type="button" class="close" data-dismiss="alert"><i class="ace-icon fa fa-times"></i></button><strong></i>Oops! </strong>data gagal ditambahkan.<br /></div>' );
				echo "<script>window.location='".base_url()."admin_side/tambah_data_pengguna/'</script>";
			}
		}else{
			$this->session->set_flashdata('gagal','<div class="alert alert-warning"><button type="button" class="close" data-dismiss="alert"><i class="ace-icon fa fa-times"></i></button><strong></i>Oops! </strong>Username telah digunakan.<br /></div>' );
			echo "<script>window.location='".base_url()."admin_side/tambah_data_pengguna/'</script>";
		}
	}
	public function detail_administrator_data()
	{
		$data['parent'] = 'master';
		$data['child'] = 'user';
		$data['grand_child'] = '';
		$this->load->view('admin/template/header',$data);
		$this->load->view('admin/master/detail_administrator_data',$data);
		$this->load->view('admin/template/footer');
	}
	public function edit_administrator_data()
	{
		$data['parent'] = 'master';
		$data['child'] = 'user';
		$data['grand_child'] = '';
		$url = 'http://kertasfolio.id:99/api/userdatas/user/'.$this->uri->segment(3);
		$data['data_user'] = $this->Main_model->getAPI($url);
		$this->load->view('admin/template/header',$data);
		$this->load->view('admin/master/edit_administrator_data',$data);
		$this->load->view('admin/template/footer');
	}
	public function update_administrator_data(){
		$url_insert = 'http://kertasfolio.id:99/api/userdatas/update';
		if($this->input->post('pass')=='' OR $this->input->post('pass')==NULL){
			$data_insert = array(
					"idUserDatas"=> $this->input->post('iduser'),
					"idEvent"=> $this->input->post('idevent'),
					"idWilayah"=> $this->input->post('id_wilayah'),
					"username"=> $this->input->post('uname'),
					"password"=> $this->input->post('pass_lama'),
					"telepon"=> $this->input->post('no_hp'),
					"namaUser"=> $this->input->post('nama'),
					"roleEvent"=> $this->input->post('role_event'),
					"roleUser"=> $this->input->post('roleUser'),
					"isActive"=> $this->input->post('isactive'),
					"keterangan"=> $this->input->post('userid_keterangan'),
					"createdDate"=> $this->input->post('createdat')
			);
		}else{
			$data_insert = array(
				"idUserDatas"=> $this->input->post('iduser'),
				"idEvent"=> $this->input->post('idevent'),
				"idWilayah"=> $this->input->post('id_wilayah'),
				"username"=> $this->input->post('uname'),
				"password"=> $this->input->post('pass'),
				"telepon"=> $this->input->post('no_hp'),
				"namaUser"=> $this->input->post('nama'),
				"roleEvent"=> $this->input->post('role_event'),
				"roleUser"=> $this->input->post('roleUser'),
				"isActive"=> $this->input->post('isactive'),
				"keterangan"=> $this->input->post('userid_keterangan'),
				"createdDate"=> $this->input->post('createdat')
			);
		}
		// print_r($data_insert);
		$this->db->trans_start();
		if($this->input->post('pass')=='' OR $this->input->post('pass')==NULL){
			$data1 = array(
				'updated_by' => $this->input->post('userid_keterangan'),
				'updated_at' => date('Y-m-d H:i:s'),
			);
		}else{
			$data1 = array(
				'pass' => $this->input->post('pass'),
				'password_api' => $this->input->post('pass'),
				'updated_by' => $this->input->post('userid_keterangan'),
				'updated_at' => date('Y-m-d H:i:s'),
			);
		}
		// print_r($data1);
		$this->Main_model->updateData('user',$data1,array('id'=>$this->input->post('userid_keterangan')));

		$data2 = array(
			'fullname' => $this->input->post('nama')
		);
		// print_r($data2);
		$this->Main_model->updateData('user_profile',$data2,array('user_id'=>$this->input->post('userid_keterangan')));
		$this->Main_model->log_activity($this->session->userdata('id'),'Updating data',"Update admin data (".$this->input->post('nama').")",$this->session->userdata('location'));
		$this->db->trans_complete();
		$hasil_insert = $this->Main_model->updateAPI($url_insert,$data_insert);
		if($hasil_insert>0){
			$this->session->set_flashdata('sukses','<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert"><i class="ace-icon fa fa-times"></i></button><strong></i>Yeah! </strong>data telah berhasil diperbarui.<br /></div>' );
			echo "<script>window.location='".base_url()."admin_side/pengguna/'</script>";
		}
		else{
			$this->session->set_flashdata('gagal','<div class="alert alert-warning"><button type="button" class="close" data-dismiss="alert"><i class="ace-icon fa fa-times"></i></button><strong></i>Oops! </strong>data gagal diperbarui.<br /></div>' );
			echo "<script>window.location='".base_url()."admin_side/ubah_data_pengguna/".$this->input->post('iduser')."'</script>";
		}
	}
	public function reset_password_administrator_account(){
		$this->db->trans_start();
		// do something your code
		$this->db->trans_complete();
		if($this->db->trans_status() === false){
			$this->session->set_flashdata('gagal','<div class="alert alert-warning"><button type="button" class="close" data-dismiss="alert"><i class="ace-icon fa fa-times"></i></button><strong></i>Oops! </strong>data gagal diubah.<br /></div>' );
			echo "<script>window.location='".base_url()."admin_side/administrator/'</script>";
		}
		else{
			$this->session->set_flashdata('sukses','<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert"><i class="ace-icon fa fa-times"></i></button><strong></i>Yeah! </strong>data telah berhasil diubah.<br /></div>' );
			echo "<script>window.location='".base_url()."admin_side/administrator/'</script>";
		}
	}
	public function delete_administrator_data(){
		$this->db->trans_start();
		$where = $this->uri->segment(3);
		$url2 = 'http://kertasfolio.id:99/api/userdatas/user/'.$where;
		$getuserdata = $this->Main_model->getAPI($url2);
		$url1 = 'http://kertasfolio.id:99/api/userdatas/delete?idUser='.$where.'&email='.$getuserdata['username'];
		$this->Main_model->deleteAPI($url1);
		$this->Main_model->deleteData('user',array('id'=>$getuserdata['keterangan']));
		$this->Main_model->deleteData('user_profile',array('user_id'=>$getuserdata['keterangan']));
		$this->Main_model->deleteData('user_to_role',array('user_id'=>$getuserdata['keterangan']));
		$this->db->trans_complete();
		if($this->db->trans_status() === false){
			$this->session->set_flashdata('gagal','<div class="alert alert-warning"><button type="button" class="close" data-dismiss="alert"><i class="ace-icon fa fa-times"></i></button><strong></i>Oops! </strong>data gagal dihapus.<br /></div>' );
			echo "<script>window.location='".base_url()."admin_side/pengguna/'</script>";
		}
		else{
			$this->session->set_flashdata('sukses','<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert"><i class="ace-icon fa fa-times"></i></button><strong></i>Yeah! </strong>data telah berhasil dihapus.<br /></div>' );
			echo "<script>window.location='".base_url()."admin_side/pengguna/'</script>";
		}
	}
	/* Other Function */
	public function ajax_function(){
		if($this->input->post('modul')=='get_wilayah_by_role_event'){
			if($this->input->post('id')=='SELURUH PILKADA'){
				echo'';
			}elseif($this->input->post('id')=='5469458f-8760-45b1-b05a-a4ca3aab2461'){
				$url = 'http://kertasfolio.id:99/api/prov/all/asc';
				$data_prov = $this->Main_model->getAPI($url);
				echo'
				<div class="form-group form-md-line-input has-danger">
					<label class="col-md-2 control-label" for="form_control_1">Provinsi <span class="required"> * </span></label>
					<div class="col-md-10">
						<div class="input-icon">
							<select name="idWilayahEvent" class="form-control select2-allow-clear" required>
								<option value="">-- Pilih --</option>';
								foreach ($data_prov as $key => $value) {
									echo'<option value="'.$value['idProvinsi'].'">'.$value['namaProvinsi'].'</option>';
								}
							echo'</select>
						</div>
					</div>
				</div>';
			}elseif($this->input->post('id')=='dbabb74d-df5b-4b79-820b-057abdf99b1a'){
				$url = 'http://kertasfolio.id:99/api/prov/all/asc';
				$data_prov = $this->Main_model->getAPI($url);
				echo'
				<div class="form-group form-md-line-input has-danger">
					<label class="col-md-2 control-label" for="form_control_1">Provinsi <span class="required"> * </span></label>
					<div class="col-md-10">
						<div class="input-icon">
							<select id="id_provinsi" class="form-control select2-allow-clear" required>
								<option value="">-- Pilih --</option>';
								foreach ($data_prov as $key => $value) {
									echo'<option value="'.$value['idProvinsi'].'">'.$value['namaProvinsi'].'</option>';
								}
							echo'</select>
						</div>
					</div>
				</div><div id="tampil_kabupaten"></div>';
			}else{
				echo'';
			}
		}elseif($this->input->post('modul')=='get_tampil_kabupaten_by_id_provinsi'){
			$url = 'http://kertasfolio.id:99/api/kab/prov/'.$this->input->post('id');
			$data_kab = $this->Main_model->getAPI($url);
			echo'
			<div class="form-group form-md-line-input has-danger">
				<label class="col-md-2 control-label" for="form_control_1">Kabupaten/ Kota <span class="required"> * </span></label>
				<div class="col-md-10">
					<div class="input-icon">
						<select name="idWilayahEvent" class="form-control select2-allow-clear" required>
							<option value="">-- Pilih --</option>';
							foreach ($data_kab as $key => $value) {
								echo'<option value="'.$value['idKabupaten'].'">'.$value['namaKabupaten'].'</option>';
							}
						echo'</select>
					</div>
				</div>
			</div>';
		}elseif($this->input->post('modul')=='get_role_event_by_id_event'){
			$url2 = 'http://kertasfolio.id:99/api/event/id/'.$this->input->post('id');
			$data_e = $this->Main_model->getAPI($url2);
			echo'<input type="hidden" name="role" value="'.$data_e['roleEvent'].'" />';
			echo'<input type="hidden" name="wilayah" value="'.$data_e['idWilayahEvent'].'" />';
		}
	}
}
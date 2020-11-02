<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Master extends CI_Controller {
	function __construct() {
		parent::__construct();
	}
	/* Relawan Rekrutmen */
	public function import_rekrutmen(){
		$data['parent'] = 'master';
		$data['child'] = '';
		$data['grand_child'] = '';
		$this->load->view('member/template/header',$data);
		$this->load->view('member/master/import_rekrutmen',$data);
		$this->load->view('member/template/footer');
	}
	public function proses_import_rekrutmen(){
		include APPPATH.'third_party/PHPExcel/PHPExcel.php';
		$namafile = 'bilper'.date('YmdHis').'.xlsx';
		$config['upload_path'] = 'data_upload/';
		$config['allowed_types'] = 'xlsx';
		$config['max_size']	= '7048';
		$config['overwrite'] = true;
		$config['file_name'] = $namafile;

		$this->upload->initialize($config);
		if($this->upload->do_upload('fmasuk')){
			$excelreader = new PHPExcel_Reader_Excel2007();
			$loadexcel = $excelreader->load('data_upload/'.$namafile);
			$sheet = $loadexcel->getActiveSheet()->toArray(null, true, true ,true);
			$numrow = 1;
			foreach($sheet as $row){
				if($numrow > 1){
					$url = 'http://localhost:8181/api/rekrutmen/relawan/'.$this->input->post('relawan');
					$data_user = $this->Main_model->getAPI($url);
					$tanda = 0;
					foreach ($data_user as $key => $value) {
						if($value['NIK']==$row['C']){
							$tanda = 1;
							break;
						}else{
							echo'';
						}
					}
					if($tanda==1){
						// update
						$url2 = 'http://pradi.is-very-good.org:7733/api/rekrutmen/update/';
						$data_array = array(
							"idRekrutmen"=> $data['idRekrutmen'],
							"idRelawan"=> $data['idRelawan'],
							"idEvent"=> $data['idEvent'],
							"namaRekrutmen"=> $data['namaRekrutmen'],
							"telepon"=> $data['telepon'],
							"NIK"=> $data['NIK'],
							"pekerjaan"=> $data['pekerjaan'],
							"idDesa"=> $data['idDesa'],
							"idKecamatan"=> $data['idKecamatan'],
							"idKabupaten"=> $data['idKabupaten'],
							"idProvinsi"=> $data['idProvinsi'],
							"fotoKTP"=> $data['idProvinsi'],
							"isVerified"=> true,
							"createdDate"=> $data['createdDate']
						);
						$data_update = $this->Main_model->updateAPI($url2,$data_array);
					}else{
						// insert
						$url_insert = 'http://pradi.is-very-good.org:7733/api/rekrutmen/insert/';
						$data_insert = array(
							"idRekrutmen"=> $data['idRekrutmen'],
							"idRelawan"=> $data['idRelawan'],
							"idEvent"=> $data['idEvent'],
							"namaRekrutmen"=> $data['namaRekrutmen'],
							"telepon"=> $data['telepon'],
							"NIK"=> $data['NIK'],
							"pekerjaan"=> $data['pekerjaan'],
							"idDesa"=> $data['idDesa'],
							"idKecamatan"=> $data['idKecamatan'],
							"idKabupaten"=> $data['idKabupaten'],
							"idProvinsi"=> $data['idProvinsi'],
							"fotoKTP"=> $data['idProvinsi'],
							"isVerified"=> true,
							"createdDate"=> $data['createdDate']
						);
						$hasil_insert = $this->Main_model->insertAPI($url_insert,$data_insert);
					}
				}
				$numrow++;
            }
            unlink(base_url().'data_upload/'.$namafile);
		}else{
			echo'';
		}
	}
	/* Target Suara */
	public function target_suara(){
		$data['parent'] = 'master';
		$data['child'] = 'target_suara';
		$data['grand_child'] = '';
		$this->load->view('member/template/header',$data);
		$this->load->view('member/master/target_suara',$data);
		$this->load->view('member/template/footer');
	}
	public function json_target_suara(){
		$get_info = $this->Main_model->getSelectedData('user_to_role a', 'a.*', array('a.user_id'=>$this->session->userdata('id')))->row();
		if($get_info->keterangan=='PILKADA KAB/KOTA'){
			$url1 = 'http://pradi.is-very-good.org:7733/api/kec/kab/'.$get_info->wilayah;
			$data = $this->Main_model->getAPI($url1);
		}else{
			echo'';
		}
		
		$data_tampil = array();
		$no = 1;
		foreach ($data as $key => $value) {
			$relawan = 0;
			$isi['number'] = $no++.'.';
			$isi['nama'] = $value['namaKecamatan'];
			$target_relawan = 0;
			$target_rekrutmen = 0;
			$get_target = $this->Main_model->getSelectedData('data_target a', 'a.*', array('a.id_event'=>$get_info->id_event,'a.id_kecamatan'=>$value['idKecamatan']))->result();
			foreach ($get_target as $key => $t) {
				$target_relawan += $t->relawan;
				$target_rekrutmen += $t->rekrutmen;
			}
			$url2 = 'http://pradi.is-very-good.org:7733/api/relawandatas/byevent/'.$get_info->id_event;
			$data_relawan = $this->Main_model->getAPI($url2);
			foreach ($data_relawan as $key => $d) {
				$url3 = 'http://pradi.is-very-good.org:7733/api/relawanprofiles/getProfile/'.$d['idRelawan'];
				$data_relawan_detail = $this->Main_model->getAPI($url3);
				if($data_relawan_detail['idKecamatan']==$value['idKecamatan']){
					$relawan++;
				}else{
					echo'';
				}
			}
			$url4 = 'http://pradi.is-very-good.org:7733/api/rekrutmen/kec/'.$value['idKecamatan'].'/'.$get_info->id_event;
			$data_rekrutmen = $this->Main_model->getAPI($url4);
			$isi['relawan'] = number_format($target_relawan,0).' / '.number_format($relawan,0);
			$isi['rekrutmen'] = number_format($target_rekrutmen,0).' / '.number_format(count($data_rekrutmen),0);
			$isi['action'] =	'
			<div class="btn-group">
				<button class="btn btn-xs green dropdown-toggle" type="button" data-toggle="dropdown" aria-expanded="false"> Aksi
					<i class="fa fa-angle-down"></i>
				</button>
				<ul class="dropdown-menu pull-right" role="menu">
					<li>
						<a href="'.site_url('member_side/target_per_desa/'.$value['idKecamatan']).'/'.$get_info->id_event.'">
							<i class="icon-eye"></i> Detail Data </a>
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
	public function verif_rekrutmen(){
		$url1 = 'http://pradi.is-very-good.org:7733/api/rekrutmen/get/'.$this->uri->segment(5);
		$url2 = 'http://pradi.is-very-good.org:7733/api/rekrutmen/update/';
		$data = $this->Main_model->getAPI($url1);
		$data_array = array(
			"idRekrutmen"=> $data['idRekrutmen'],
			"idRelawan"=> $data['idRelawan'],
			"idEvent"=> $data['idEvent'],
			"namaRekrutmen"=> $data['namaRekrutmen'],
			"telepon"=> $data['telepon'],
			"NIK"=> $data['NIK'],
			"pekerjaan"=> $data['pekerjaan'],
			"idDesa"=> $data['idDesa'],
			"idKecamatan"=> $data['idKecamatan'],
			"idKabupaten"=> $data['idKabupaten'],
			"idProvinsi"=> $data['idProvinsi'],
			"fotoKTP"=> $data['idProvinsi'],
			"isVerified"=> true,
			"createdDate"=> $data['createdDate']
		);
		$data_update = $this->Main_model->updateAPI($url2,$data_array);
		$this->session->set_flashdata('sukses','<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert"><i class="ace-icon fa fa-times"></i></button><strong></i>Yeah! </strong>data telah berhasil diubah.<br /></div>' );
		echo "<script>window.location='".base_url()."member_side/target_detail/".$this->uri->segment(3)."/".$this->uri->segment(4)."'</script>";
	}
	public function target_per_desa(){
		$data['parent'] = 'master';
		$data['child'] = 'target_suara';
		$data['grand_child'] = '';
		$url1 = 'http://pradi.is-very-good.org:7733/api/kec/id/'.$this->uri->segment(3);
		$data['datakecamatan'] = $this->Main_model->getAPI($url1);
		$this->load->view('member/template/header',$data);
		$this->load->view('member/master/target_per_desa',$data);
		$this->load->view('member/template/footer');
	}
	public function json_target_suara_per_desa(){
		$url1 = 'http://pradi.is-very-good.org:7733/api/desa/kec/'.$this->input->post('id_kecamatan');
		$data = $this->Main_model->getAPI($url1);
		$data_tampil = array();
		$no = 1;
		foreach ($data as $key => $value) {
			$relawan = 0;
			$isi['number'] = $no++.'.';
			$isi['nama'] = $value['namaDesa'];
			$get_target = $this->Main_model->getSelectedData('data_target a', 'a.*', array('a.id_event'=>$this->input->post('id_event'),'a.id_desa'=>$value['idDesa']))->row();
			$url2 = 'http://pradi.is-very-good.org:7733/api/relawandatas/byevent/'.$this->input->post('id_event');
			$data_relawan = $this->Main_model->getAPI($url2);
			foreach ($data_relawan as $key => $d) {
				$url3 = 'http://pradi.is-very-good.org:7733/api/relawanprofiles/getProfile/'.$d['idRelawan'];
				$data_relawan_detail = $this->Main_model->getAPI($url3);
				if($data_relawan_detail['idDesa']==$value['idDesa']){
					$relawan++;
				}else{
					echo'';
				}
			}
			$url4 = 'http://pradi.is-very-good.org:7733/api/rekrutmen/desa/'.$value['idDesa'].'/'.$this->input->post('id_event');
			$data_rekrutmen = $this->Main_model->getAPI($url4);
			$isi['relawan'] = number_format($get_target->relawan,0).' / '.number_format($relawan,0);
			$isi['rekrutmen'] = number_format($get_target->rekrutmen,0).' / '.number_format(count($data_rekrutmen),0);
			$isi['action'] =	'
			<div class="btn-group">
				<button class="btn btn-xs green dropdown-toggle" type="button" data-toggle="dropdown" aria-expanded="false"> Aksi
					<i class="fa fa-angle-down"></i>
				</button>
				<ul class="dropdown-menu pull-right" role="menu">
					<li>
						<a href="'.site_url('member_side/target_detail/'.$value['idDesa']).'/'.$this->input->post('id_event').'">
							<i class="icon-eye"></i> Detail Data </a>
					</li>
					<li>
						<a class="detaildata" id="'.$this->input->post('id_event').'/'.$value['idDesa'].'">
						<i class="icon-note"></i> Ubah Data </a>
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
	public function target_suara_desa(){
		$data['parent'] = 'master';
		$data['child'] = 'target_suara';
		$data['grand_child'] = '';
		$data['id_event'] = $this->uri->segment(4);
		$data['id_desa'] = $this->uri->segment(3);
		$url1 = 'http://pradi.is-very-good.org:7733/api/desa/id/'.$this->uri->segment(3);
		$data['data_desa'] = $this->Main_model->getAPI($url1);
		$url2 = 'http://pradi.is-very-good.org:7733/api/relawandatas/byevent/'.$this->uri->segment(4);
		$data['data_relawan'] = $this->Main_model->getAPI($url2);
		$url3 = 'http://pradi.is-very-good.org:7733/api/rekrutmen/desa/'.$this->uri->segment(3).'/'.$this->uri->segment(4);
		$data['data_rekrutmen'] = $this->Main_model->getAPI($url3);
		$this->load->view('member/template/header',$data);
		$this->load->view('member/master/target_suara_desa',$data);
		$this->load->view('member/template/footer');
	}
	public function edit_target_suara()
	{
		$data['parent'] = 'master';
		$data['child'] = 'target_suara';
		$data['grand_child'] = '';
		$this->load->view('member/template/header',$data);
		$this->load->view('member/master/edit_target_suara',$data);
		$this->load->view('member/template/footer');
	}
	public function update_target_suara(){
		$this->db->trans_start();
		$data = $this->Main_model->getSelectedData('data_target a', 'a.*', array('a.id_event'=>$this->input->post('id_event'),'a.id_desa'=>$this->input->post('id_desa')))->row();
		if($data==NULL){
			$data1 = array(
				'id_event' => $this->input->post('id_event'),
				'id_kecamatan' => $this->input->post('id_kecamatan'),
				'id_desa' => $this->input->post('id_desa'),
				'relawan' => $this->input->post('relawan'),
				'rekrutmen' => $this->input->post('rekrutmen')
			);
			// print_r($data1);
			$this->Main_model->insertData('data_target',$data1);
		}else{
			$data1 = array(
				'relawan' => $this->input->post('relawan'),
				'rekrutmen' => $this->input->post('rekrutmen')
			);
			// print_r($data1);
			$this->Main_model->updateData('data_target',$data1,array('id_event'=>$this->input->post('id_event'),'id_desa'=>$this->input->post('id_desa')));
		}
		$this->Main_model->log_activity($this->session->userdata('id'),'Updating data',"Update target relawan dan struktur (".$this->input->post('namadesa').")",$this->session->userdata('location'));
		$this->db->trans_complete();
		if($this->db->trans_status() === false){
			$this->session->set_flashdata('gagal','<div class="alert alert-warning"><button type="button" class="close" data-dismiss="alert"><i class="ace-icon fa fa-times"></i></button><strong></i>Oops! </strong>data gagal ditambahkan.<br /></div>' );
			echo "<script>window.location='".base_url()."member_side/target_per_desa/".$this->input->post('id_kecamatan')."/".$this->input->post('id_event')."'</script>";
		}
		else{
			$this->session->set_flashdata('sukses','<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert"><i class="ace-icon fa fa-times"></i></button><strong></i>Yeah! </strong>data telah berhasil ditambahkan.<br /></div>' );
			echo "<script>window.location='".base_url()."member_side/target_per_desa/".$this->input->post('id_kecamatan')."/".$this->input->post('id_event')."'</script>";
		}
	}
	/* Admin Wilayah */
	public function admin_data()
	{
		$data['parent'] = 'master';
		$data['child'] = 'admin';
		$data['grand_child'] = '';
		$this->load->view('member/template/header',$data);
		$this->load->view('member/master/admin_data',$data);
		$this->load->view('member/template/footer');
	}
	public function json_admin_data(){
		$get_info = $this->Main_model->getSelectedData('user_to_role a', 'a.*', array('a.user_id'=>$this->session->userdata('id')))->row();
		$url1 = 'http://pradi.is-very-good.org:7733/api/userdatas/event/'.$get_info->id_event;
		$data = $this->Main_model->getAPI($url1);
		$data_tampil = array();
		$no = 1;
		foreach ($data as $key => $value) {
			if($value['keterangan']==$this->session->userdata('id') OR $value['roleUser']=='C28A1E26-19BD-4813-9247-8333F7ED917D' OR $value['roleUser']=='c28a1e26-19bd-4813-9247-8333f7ed917d' OR $value['keterangan']==$this->session->userdata('id')){
				echo'';
			}else{
				$isi['checkbox'] =	'
									<label class="mt-checkbox mt-checkbox-single mt-checkbox-outline">
										<input type="checkbox" class="checkboxes" name="selected_id[]" value="'.$value['idUserDatas'].'"/>
										<span></span>
									</label>
									';
				$isi['number'] = $no++.'.';
				$isi['nama'] = $value['namaUser'];
				$role = '';
				if($value['roleUser']=='a51da1de-e8b0-47ca-aa60-829b6925b8c7'){
					$role = 'SUPERADMIN';
				}elseif($value['roleUser']=='d168d3f4-7e1e-4dc6-8ed6-be28388afb93'){
					$role = 'ADMIN KECAMATAN';
				}elseif($value['roleUser']=='8d5d0ee6-d80c-44d3-a611-5c806f6980a3'){ // kurang admin provinsi
					$role = 'ADMIN PROVINSI';
				}elseif($value['roleUser']=='1019ce17-9c80-4beb-8e61-d064fb872cea'){
					$role = 'ADMIN PILKADA';
				}elseif($value['roleUser']=='0f7d8a46-9ae5-4938-94e0-7dba527042da'){
					$role = 'ADMIN KABUPATEN';
				}elseif($value['roleUser']=='c28a1e26-19bd-4813-9247-8333f7ed917d'){
					$role = 'RELAWAN';
				}else{echo'';}
				$isi['keterangan'] = $role;
				$wilayah = '';
				if(strlen($value['idWilayah'])=='2'){
					$url2 = 'http://pradi.is-very-good.org:7733/api/prov/id/'.$value['idWilayah'];
					$data_prov = $this->Main_model->getAPI($url2);
					$wilayah = $data_prov['namaProvinsi'];
				}elseif(strlen($value['idWilayah'])=='4'){
					$url2 = 'http://pradi.is-very-good.org:7733/api/kab/id/'.$value['idWilayah'];
					$data_kab = $this->Main_model->getAPI($url2);
					$wilayah = $data_kab['namaKabupaten'];
				}elseif(strlen($value['idWilayah'])=='7'){
					$url2 = 'http://pradi.is-very-good.org:7733/api/kec/id/'.$value['idWilayah'];
					$data_kab = $this->Main_model->getAPI($url2);
					$wilayah = $data_kab['namaKecamatan'];
				}else{
					echo'';
				}
				$isi['wilayah'] = $wilayah;
				$return_on_click = "return confirm('Anda yakin?')";
				if($value['roleUser']=='1019ce17-9c80-4beb-8e61-d064fb872cea'){
					$isi['action'] =	'
					<div class="btn-group">
						<button class="btn btn-xs green dropdown-toggle" type="button" data-toggle="dropdown" aria-expanded="false" disabled> Aksi
							<i class="fa fa-angle-down"></i>
						</button>
					</div>
					';
				}else{
					$isi['action'] =	'
									<div class="btn-group">
										<button class="btn btn-xs green dropdown-toggle" type="button" data-toggle="dropdown" aria-expanded="false"> Aksi
											<i class="fa fa-angle-down"></i>
										</button>
										<ul class="dropdown-menu pull-right" role="menu">
											<li>
												<a href="'.site_url('member_side/ubah_data_admin/'.$value['idUserDatas']).'">
													<i class="icon-wrench"></i> Ubah Data </a>
											</li>
											<li>
												<a onclick="'.$return_on_click.'" href="'.site_url('member_side/hapus_data_admin/'.$value['idUserDatas']).'">
													<i class="icon-trash"></i> Hapus Data </a>
											</li>
										</ul>
									</div>
									';
				}
				
				$data_tampil[] = $isi;
			}
		}
		$results = array(
			"sEcho" => 1,
			"iTotalRecords" => count($data_tampil),
			"iTotalDisplayRecords" => count($data_tampil),
			"aaData"=>$data_tampil);
		echo json_encode($results);
	}
	public function add_admin_data()
	{
		$data['parent'] = 'master';
		$data['child'] = 'admin';
		$data['grand_child'] = '';
		$data['get_info'] = $this->Main_model->getSelectedData('user_to_role a', 'a.*', array('a.user_id'=>$this->session->userdata('id')))->row();
		$this->load->view('member/template/header',$data);
		$this->load->view('member/master/add_admin_data',$data);
		$this->load->view('member/template/footer');
	}
	public function save_admin_data(){
		$cek_data = $this->Main_model->getSelectedData('user a', 'a.*', array('a.username'=>$this->input->post('username')))->result();
		if($cek_data==NULL){
			$r_u = '';
			$ket = '';
			$role_id = '';
			if($this->input->post('role_name')=='1a' OR $this->input->post('role_name')=='1b'){
				$r_u = '8d5d0ee6-d80c-44d3-a611-5c806f6980a3';
				$ket = 'ADMIN PROVINSI';
				$role_id = '2';
			}elseif($this->input->post('role_name')=='2a' OR $this->input->post('role_name')=='2b' OR $this->input->post('role_name')=='2c'){
				$r_u = '0f7d8a46-9ae5-4938-94e0-7dba527042da';
				$ket = 'ADMIN KABUPATEN';
				$role_id = '3';
			}elseif($this->input->post('role_name')=='3a' OR $this->input->post('role_name')=='3b' OR $this->input->post('role_name')=='3c'){
				$r_u = 'd168d3f4-7e1e-4dc6-8ed6-be28388afb93';
				$ket = 'ADMIN KECAMATAN';
				$role_id = '4';
			}else{echo'';}
			$url_insert = 'http://pradi.is-very-good.org:7733/api/userdatas/register';
			
			$this->db->trans_start();
			$user_id = $this->Main_model->getLastID('user','id');
			$data_insert = array(
				"idUserDatas"=> $user_id['id']+1,
				"idEvent"=> $this->input->post('id_event'),
				"idWilayah"=> $this->input->post('wilayah'),
				"username"=> $this->input->post('username'),
				"password"=> $this->input->post('pass'),
				"telepon"=> $this->input->post('no_hp'),
				"namaUser"=> $this->input->post('nama'),
				"roleEvent"=> $this->input->post('role'),
				"roleUser"=> $r_u,
				"isActive"=> true,
				"keterangan"=> $user_id['id']+1,
				'createdDate'=> date("Y-m-d").'T05:39:56.757Z'
			);
			// print_r($data_insert);
			$data1 = array(
						'id' => $user_id['id']+1,
						'username' => $this->input->post('username'),
						'pass' => $this->input->post('pass'),
						'username_api' => $this->input->post('username'),
						'password_api' => $this->input->post('pass'),
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

			$data3 = array(
				'user_id' => $user_id['id']+1,
				'role_id' => $role_id,
				'id_event' => $this->input->post('id_event'),
				'keterangan' => $ket,
				'wilayah' => $this->input->post('wilayah')
			);
			// print_r($data3);
			$this->Main_model->insertData('user_to_role',$data3);
			$this->Main_model->log_activity($this->session->userdata('id'),'Inserting data',"Insert admin data (".$this->input->post('nama').")",$this->session->userdata('location'));
			$this->db->trans_complete();
			$hasil_insert = $this->Main_model->insertAPI($url_insert,$data_insert);
			if($hasil_insert>0){
				$this->session->set_flashdata('sukses','<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert"><i class="ace-icon fa fa-times"></i></button><strong></i>Yeah! </strong>data telah berhasil ditambahkan.<br /></div>' );
				echo "<script>window.location='".base_url()."member_side/admin'</script>";
			}
			else{
				$this->session->set_flashdata('gagal','<div class="alert alert-warning"><button type="button" class="close" data-dismiss="alert"><i class="ace-icon fa fa-times"></i></button><strong></i>Oops! </strong>data gagal ditambahkan.<br /></div>' );
				echo "<script>window.location='".base_url()."member_side/tambah_data_admin/'</script>";
			}
		}else{
			$this->session->set_flashdata('gagal','<div class="alert alert-warning"><button type="button" class="close" data-dismiss="alert"><i class="ace-icon fa fa-times"></i></button><strong></i>Oops! </strong>Username telah digunakan.<br /></div>' );
			echo "<script>window.location='".base_url()."member_side/tambah_data_admin/'</script>";
		}
	}
	public function edit_admin_data()
	{
		$data['parent'] = 'master';
		$data['child'] = 'admin';
		$data['grand_child'] = '';
		$url = 'http://pradi.is-very-good.org:7733/api/userdatas/user/'.$this->uri->segment(3);
		$data_user = $this->Main_model->getAPI($url);
		$data['data_from_db'] = $this->Main_model->getSelectedData('user_to_role a', 'a.*', array('a.user_id'=>$data_user['keterangan']))->row();
		$data['data_user'] = $data_user;
		$this->load->view('member/template/header',$data);
		$this->load->view('member/master/edit_admin_data',$data);
		$this->load->view('member/template/footer');
	}
	public function update_admin_data(){
		$url_insert = 'http://pradi.is-very-good.org:7733/api/userdatas/update';
		if($this->input->post('pass')=='' OR $this->input->post('pass')==NULL){
			$data_insert = array(
				"idUserDatas"=> $this->input->post('iduser'),
				"telepon"=> $this->input->post('no_hp'),
				"namaUser"=> $this->input->post('nama')
			);
		}else{
			$data_insert = array(
				"idUserDatas"=> $this->input->post('iduser'),
				"password"=> $this->input->post('pass'),
				"telepon"=> $this->input->post('no_hp'),
				"namaUser"=> $this->input->post('nama')
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
			echo "<script>window.location='".base_url()."member_side/admin/'</script>";
		}
		else{
			$this->session->set_flashdata('gagal','<div class="alert alert-warning"><button type="button" class="close" data-dismiss="alert"><i class="ace-icon fa fa-times"></i></button><strong></i>Oops! </strong>data gagal diperbarui.<br /></div>' );
			echo "<script>window.location='".base_url()."member_side/ubah_data_admin/".$this->input->post('iduser')."'</script>";
		}
	}
	public function delete_admin_data(){
		$this->db->trans_start();
		$where = $this->uri->segment(3);
		$url2 = 'http://pradi.is-very-good.org:7733/api/userdatas/user/'.$where;
		$getuserdata = $this->Main_model->getAPI($url2);
		$url1 = 'http://pradi.is-very-good.org:7733/api/userdatas/delete/'.$where.'/'.$getuserdata['username'];
		$this->Main_model->deleteAPI($url1);
		$this->Main_model->deleteData('user',array('id'=>$getuserdata['keterangan']));
		$this->Main_model->deleteData('user_profile',array('user_id'=>$getuserdata['keterangan']));
		$this->Main_model->deleteData('user_to_role',array('user_id'=>$getuserdata['keterangan']));
		$this->db->trans_complete();
		if($this->db->trans_status() === false){
			$this->session->set_flashdata('gagal','<div class="alert alert-warning"><button type="button" class="close" data-dismiss="alert"><i class="ace-icon fa fa-times"></i></button><strong></i>Oops! </strong>data gagal dihapus.<br /></div>' );
			echo "<script>window.location='".base_url()."member_side/admin/'</script>";
		}
		else{
			$this->session->set_flashdata('sukses','<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert"><i class="ace-icon fa fa-times"></i></button><strong></i>Yeah! </strong>data telah berhasil dihapus.<br /></div>' );
			echo "<script>window.location='".base_url()."member_side/admin/'</script>";
		}
	}
	/* Relawan */
	public function relawan_data()
	{
		$data['parent'] = 'master';
		$data['child'] = 'relawan';
		$data['grand_child'] = '';
		$this->load->view('member/template/header',$data);
		$this->load->view('member/master/relawan_data',$data);
		$this->load->view('member/template/footer');
	}
	public function json_relawan_data(){
		$get_info = $this->Main_model->getSelectedData('user_to_role a', 'a.*', array('a.user_id'=>$this->session->userdata('id')))->row();
		$url1 = 'http://pradi.is-very-good.org:7733/api/relawandatas/byevent/'.$get_info->id_event;
		$data = $this->Main_model->getAPI($url1);
		$data_tampil = array();
		$no = 1;
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
											<a href="'.site_url('member_side/detail_data_relawan/'.$value['idRelawan']).'">
												<i class="icon-eye"></i> Detail Data </a>
										</li>
										<li>
											<a href="'.site_url('member_side/ubah_data_relawan/'.$value['idRelawan']).'">
												<i class="icon-wrench"></i> Ubah Data </a>
										</li>
										<li>
											<a onclick="'.$return_on_click.'" href="'.site_url('member_side/hapus_data_relawan/'.$value['idRelawan']).'">
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
	public function add_relawan_data()
	{
		$data['parent'] = 'master';
		$data['child'] = 'relawan';
		$data['grand_child'] = '';
		$data['get_info'] = $this->Main_model->getSelectedData('user_to_role a', 'a.*', array('a.user_id'=>$this->session->userdata('id')))->row();
		$this->load->view('member/template/header',$data);
		$this->load->view('member/master/add_relawan_data',$data);
		$this->load->view('member/template/footer');
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
				echo "<script>window.location='".base_url()."member_side/relawan/'</script>";
			}
			else{
				$this->session->set_flashdata('gagal','<div class="alert alert-warning"><button type="button" class="close" data-dismiss="alert"><i class="ace-icon fa fa-times"></i></button><strong></i>Oops! </strong>data gagal ditambahkan.<br /></div>' );
				echo "<script>window.location='".base_url()."member_side/tambah_data_relawan/'</script>";
			}
		}else{
			$this->session->set_flashdata('gagal','<div class="alert alert-warning"><button type="button" class="close" data-dismiss="alert"><i class="ace-icon fa fa-times"></i></button><strong></i>Oops! </strong>Username telah digunakan.<br /></div>' );
			echo "<script>window.location='".base_url()."member_side/tambah_data_relawan/'</script>";
		}
	}
	public function detail_relawan_data()
	{
		$data['parent'] = 'master';
		$data['child'] = 'relawan';
		$data['grand_child'] = '';
		$url1 = 'http://pradi.is-very-good.org:7733/api/relawanprofiles/getDatas/'.$this->uri->segment(3);
		$data['data_relawan'] = $this->Main_model->getAPI($url1);
		$url2 = 'http://pradi.is-very-good.org:7733/api/rekrutmen/relawan/'.$this->uri->segment(3);
		$data['data_rekrutmen'] = $this->Main_model->getAPI($url2);
		$this->load->view('member/template/header',$data);
		$this->load->view('member/master/detail_relawan_data',$data);
		$this->load->view('member/template/footer');
	}
	public function edit_relawan_data($id)
	{
		$data['parent'] = 'master';
		$data['child'] = 'relawan';
		$data['grand_child'] = '';
		$url = 'http://pradi.is-very-good.org:7733/api/relawanprofiles/getDatas/'.$id;
		$data['data_utama'] = $this->Main_model->getAPI($url);;
		$this->load->view('member/template/header',$data);
		$this->load->view('member/master/edit_relawan_data',$data);
		$this->load->view('member/template/footer');
	}
	public function update_relawan_data(){
		$url_insert = 'http://pradi.is-very-good.org:7733/api/relawanprofiles/update';
		$data_insert = array(
			"idRelawan"=> $this->input->post('id_relawan'),
			"idEvent"=> $this->input->post('id_event'),
			"telepon"=> $this->input->post('no_hp'),
			"password"=> $this->input->post('password'),
			"namaRelawan"=> $this->input->post('nama'),
			"NIK"=> $this->input->post('nik'),
			"pekerjaan"=> $this->input->post('pekerjaan'),
			"idDesa"=> $this->input->post('id_desa'),
			"idKecamatan"=> $this->input->post('id_kecamatan'),
			"idKabupaten"=> $this->input->post('id_kabupaten'),
			"idProvinsi"=> $this->input->post('id_provinsi'),
			"desa"=> $this->input->post('desa'),
			"kecamatan"=> $this->input->post('kecamatan'),
			"kabupaten"=> $this->input->post('kabupaten'),
			"provinsi"=> $this->input->post('provinsi'),
			"isActive"=> $this->input->post('is_active'),
			'createdDate'=> $this->input->post('created_at')
		);
		// print_r($data_insert);
		$this->Main_model->log_activity($this->session->userdata('id'),'Updating data',"Update relawan data (".$this->input->post('nama').")",$this->session->userdata('location'));
		$hasil_insert = $this->Main_model->updateAPI($url_insert,$data_insert);
		if($hasil_insert!='1'){
			$this->session->set_flashdata('gagal','<div class="alert alert-warning"><button type="button" class="close" data-dismiss="alert"><i class="ace-icon fa fa-times"></i></button><strong></i>Oops! </strong>data gagal diubah.<br /></div>' );
			echo "<script>window.location='".base_url()."member_side/ubah_data_relawan/".$this->input->post('user_id')."'</script>";
		}
		else{
			$this->session->set_flashdata('sukses','<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert"><i class="ace-icon fa fa-times"></i></button><strong></i>Yeah! </strong>data telah berhasil diubah.<br /></div>' );
			echo "<script>window.location='".base_url()."member_side/relawan/'</script>";
		}
	}
	public function reset_password_relawan_account(){
		$this->db->trans_start();
		$this->db->trans_complete();
		if($this->db->trans_status() === false){
			$this->session->set_flashdata('gagal','<div class="alert alert-warning"><button type="button" class="close" data-dismiss="alert"><i class="ace-icon fa fa-times"></i></button><strong></i>Oops! </strong>data gagal diubah.<br /></div>' );
			echo "<script>window.location='".base_url()."member_side/relawan/'</script>";
		}
		else{
			$this->session->set_flashdata('sukses','<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert"><i class="ace-icon fa fa-times"></i></button><strong></i>Yeah! </strong>data telah berhasil diubah.<br /></div>' );
			echo "<script>window.location='".base_url()."member_side/relawan/'</script>";
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
			echo "<script>window.location='".base_url()."member_side/relawan/'</script>";
		}
		else{
			$this->session->set_flashdata('sukses','<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert"><i class="ace-icon fa fa-times"></i></button><strong></i>Yeah! </strong>data telah berhasil dihapus.<br /></div>' );
			echo "<script>window.location='".base_url()."member_side/relawan/'</script>";
		}
	}
	/* Other Function */
	public function ajax_page(){
		if($this->input->post('modul')=='modul_ubah_data_target'){
			$pecah_data = explode('/',$this->input->post('id'));
			$data['id_event'] = $pecah_data[0];
			$data['id_desa'] = $pecah_data[1];
			$url1 = 'http://pradi.is-very-good.org:7733/api/desa/id/'.$pecah_data[1];
			$data['data_desa'] = $this->Main_model->getAPI($url1);
			$data['data_utama'] = $this->Main_model->getSelectedData('data_target a', 'a.*', array('a.id_event'=>$pecah_data[0],'a.id_desa'=>$pecah_data[1]))->row();
			$this->load->view('member/master/ajax_page/form_ubah_data_target',$data);
		}
	}
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
		elseif($this->input->post('modul')=='modul_detail_foto_ktp'){
			$get_info = $this->Main_model->getSelectedData('user_to_role a', 'a.*', array('a.user_id'=>$this->session->userdata('id')))->row();
			$url1 = 'http://pradi.is-very-good.org:7733/api/rekrutmen/all/'.$get_info->id_event;
			$data_ = $this->Main_model->getAPI($url1);
			foreach ($data_ as $key => $value) {
				if($value['idRekrutmen']==$this->input->post('id')){
					echo '<img src="data:image/png;base64,' . $value['fotoKTP'] . '" alt="" width="100%"/>';
				}else{
					echo'';
				}
			}
        }
	}
}
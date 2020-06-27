<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Main_model extends CI_Model{
	function getSelectedData($tbl_name, $select = '', $where = '', $order = '', $limit = '', $start = '0', $group = '', $join = '') {
		if (!empty($select))
			$this->db->select($select, false);
		if (!empty($where))
			$this->db->where($where);
		if (!empty($order))
			$this->db->order_by($order);
		if (!empty($limit))
			$this->db->limit($limit, $start);
		if (!empty($group))
			$this->db->group_by($group);
		if (!empty($join) && is_array($join)) {
			if (!empty($join['table']) && !empty($join['on'])) {
				$join = array($join);
			}

			foreach ($join as $item) {
				if (!empty($item['table']) && !empty($item['on'])) {
					if (!empty($item['pos'])) {
						$this->db->join($item['table'], $item['on'], $item['pos']);
					} else {
						$this->db->join($item['table'], $item['on']);
					}
				}
			}
		}

		return $this->db->get($tbl_name);
	}
	function insertData($table,$data){
		$res = $this->db->insert($table,$data);
		return $res;
		}
	function cleanData($table){
		$q = $this->db->query("TRUNCATE TABLE $table");
		return $q;
	}
	function getAlldata($table){
		return $this->db->get($table)->result();
	}
	function updateData($table,$data,$field_key)
	{
		$this->db->update($table,$data,$field_key);
	}
	function deleteData($table,$data)
	{
		$this->db->delete($table,$data);
	}
	function log_activity($user_id,$activity_type,$activity_data,$location = ''){
		$device = '';
		if ($this->agent->is_browser()){
			$device = 'PC';
		}elseif ($this->agent->is_mobile()){
			$device = $this->agent->mobile();
		}else{
			$device = '';
		}
		$activity_log = array(
			'user_id' => $user_id,
			'activity_type' => $activity_type,
			'activity_data' => $activity_data,
			'activity_time' => date('Y-m-d H-i-s'),
			'activity_ip_address' => $this->input->ip_address(),
			'activity_device' => $device,
			'activity_os' => $this->agent->platform(),
			'activity_browser' => $this->agent->browser().' '.$this->agent->version(),
			'activity_location' => $location
		);
		$this->insertData('activity_logs',$activity_log);
	}
	function getLastID($table,$column){
		return $this->db->query('SELECT '.$column.' FROM '.$table.' ORDER BY '.$column.' DESC LIMIT 1')->row_array();
	}
	function convert_tanggal($tanggalan){
		$tanggal_tampil = '';
		$waktu = explode('-', $tanggalan);
		if ($waktu[1]=="01") {
			$tanggal_tampil = $waktu[2]." Januari ".$waktu[0];
		}elseif ($waktu[1]=="02") {
			$tanggal_tampil = $waktu[2]." Februari ".$waktu[0];
		}elseif ($waktu[1]=="03") {
			$tanggal_tampil = $waktu[2]." Maret ".$waktu[0];
		}elseif ($waktu[1]=="04") {
			$tanggal_tampil = $waktu[2]." April ".$waktu[0];
		}elseif ($waktu[1]=="05") {
			$tanggal_tampil = $waktu[2]." Mei ".$waktu[0];
		}elseif ($waktu[1]=="06") {
			$tanggal_tampil = $waktu[2]." Juni ".$waktu[0];
		}elseif ($waktu[1]=="07") {
			$tanggal_tampil = $waktu[2]." Juli ".$waktu[0];
		}elseif ($waktu[1]=="08") {
			$tanggal_tampil = $waktu[2]." Agustus ".$waktu[0];
		}elseif ($waktu[1]=="09") {
			$tanggal_tampil = $waktu[2]." September ".$waktu[0];
		}elseif ($waktu[1]=="10") {
			$tanggal_tampil = $waktu[2]." Oktober ".$waktu[0];
		}elseif ($waktu[1]=="11") {
			$tanggal_tampil = $waktu[2]." November ".$waktu[0];
		}elseif ($waktu[1]=="12") {
			$tanggal_tampil = $waktu[2]." Desember ".$waktu[0];
		}
		return $tanggal_tampil;
	}
	public function convert_hari($date){
		$daftar_hari = array(
			'Sunday' => 'Minggu',
			'Monday' => 'Senin',
			'Tuesday' => 'Selasa',
			'Wednesday' => 'Rabu',
			'Thursday' => 'Kamis',
			'Friday' => 'Jumat',
			'Saturday' => 'Sabtu'
		);
		$namahari = date('l', strtotime($date));
		return $daftar_hari[$namahari];
	}
	function getAPI($url){
		$ch2 = curl_init($url);
		$token = 'authentication:'.$this->session->userdata('token');
		curl_setopt($ch2, CURLOPT_HTTPHEADER, array('Content-Type:application/json',$token));
		curl_setopt($ch2, CURLOPT_RETURNTRANSFER, true);curl_setopt($ch2, CURLOPT_SSL_VERIFYPEER, false);
		$tes2 = curl_exec($ch2);
		curl_close($ch2);
		$hasil = json_decode($tes2, true);
		return $hasil;
	}
	function deleteAPI($url){
		$ch = curl_init($url);
		$token = 'authentication:'.$this->session->userdata('token');
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE"); 
		curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json',$token));
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		$tes = curl_exec($ch);
		if(curl_error($ch))
			{
			    echo 'error:' . curl_error($ch);
			}
		curl_close($ch);
		$hasil = json_decode($tes, true);
		return $hasil;
	}
	function updateAPI($url,$data){
		$ch = curl_init($url);
		$token = 'authentication:'.$this->session->userdata('token');
		$payload = json_encode($data);
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
		curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
		curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json',$token));
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		$result = curl_exec($ch);
		$hasil = json_decode($result, true);
		return $hasil;
	}
	function insertAPI($url,$data){
		$ch = curl_init($url);
		$token = 'authentication:'.$this->session->userdata('token');
		$payload = json_encode($data);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
		curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json',$token));
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		$result = curl_exec($ch);
		curl_close($ch);
		$hasil = json_decode($result, true);
		return $hasil;
	}
}
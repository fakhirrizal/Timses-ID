<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
| example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
| https://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There are three reserved routes:
|
| $route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
| $route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router which controller/method to use if those
| provided in the URL cannot be matched to a valid route.
|
| $route['translate_uri_dashes'] = FALSE;
|
| This is not exactly a route, but allows you to automatically route
| controller and method names that contain dashes. '-' isn't a valid
| class or method name character, so it requires translation.
| When you set this option to TRUE, it will replace ALL dashes in the
| controller and method URI segments.
|
| Examples: my-controller/index -> my_controller/index
|   my-controller/my-method -> my_controller/my_method
*/
// $route['default_controller'] = 'User';
$route['default_controller'] = 'Auth/login';
$route['404_override'] = '';
$route['translate_uri_dashes'] = TRUE;

/* Auth */
$route['login'] = 'Auth/login';
$route['login_process'] = 'Auth/login_process';
$route['registrasi'] = 'Auth/registration';
$route['register_process'] = 'Auth/register_process';

/* Admin */
$route['admin_side/launcher'] = 'admin/App/launcher';
$route['admin_side/beranda'] = 'admin/App/home';
$route['admin_side/menu'] = 'admin/App/menu';
$route['admin_side/log_activity'] = 'admin/App/log_activity';
$route['admin_side/hapus_aktifitas/(:any)'] = 'admin/App/hapus_aktifitas/$1';
$route['admin_side/cleaning_log'] = 'admin/App/cleaning_log';
$route['admin_side/tentang_aplikasi'] = 'admin/App/about';
$route['admin_side/bantuan'] = 'admin/App/helper';

$route['admin_side/pengguna'] = 'admin/Master/administrator_data';
$route['admin_side/tambah_data_pengguna'] = 'admin/Master/add_administrator_data';
$route['admin_side/simpan_data_pengguna'] = 'admin/Master/save_administrator_data';
$route['admin_side/detail_data_pengguna/(:any)'] = 'admin/Master/detail_administrator_data/$1';
$route['admin_side/ubah_data_pengguna/(:any)'] = 'admin/Master/edit_administrator_data/$1';
$route['admin_side/perbarui_data_pengguna'] = 'admin/Master/update_administrator_data';
$route['admin_side/atur_ulang_kata_sandi_pengguna/(:any)'] = 'admin/Master/reset_password_administrator_account/$1';
$route['admin_side/hapus_data_pengguna/(:any)'] = 'admin/Master/delete_administrator_data/$1';

$route['admin_side/event'] = 'admin/Master/event_data';
$route['admin_side/tambah_data_event'] = 'admin/Master/add_event_data';
$route['admin_side/simpan_data_event'] = 'admin/Master/save_event_data';
$route['admin_side/detil_data_kube/(:any)'] = 'admin/Master/detail_kube_data/$1';
$route['admin_side/ubah_data_event/(:any)'] = 'admin/Master/edit_event_data/$1';
$route['admin_side/perbarui_data_event'] = 'admin/Master/update_event_data';
$route['admin_side/hapus_data_event/(:any)'] = 'admin/Master/delete_event_data/$1';

$route['admin_side/data_provinsi'] = 'admin/Map/province';
$route['admin_side/tambah_data_provinsi'] = 'admin/Map/add_province';
$route['admin_side/simpan_data_provinsi'] = 'admin/Map/save_province';
$route['admin_side/ubah_data_provinsi/(:any)'] = 'admin/Map/edit_province/$1';
$route['admin_side/perbarui_data_provinsi'] = 'admin/Map/update_province_data';
$route['admin_side/hapus_data_provinsi/(:any)'] = 'admin/Map/delete_province/$1';
$route['admin_side/data_kabkot'] = 'admin/Map/city';
$route['admin_side/tambah_data_kabkot'] = 'admin/Map/add_city';
$route['admin_side/simpan_data_kabkot'] = 'admin/Map/save_city';
$route['admin_side/ubah_data_kabkot/(:any)'] = 'admin/Map/edit_city/$1';
$route['admin_side/perbarui_data_kabkot'] = 'admin/Map/update_city_data';
$route['admin_side/hapus_data_kabkot/(:any)'] = 'admin/Map/delete_city/$1';
$route['admin_side/data_kecamatan'] = 'admin/Map/sub_district';
$route['admin_side/tambah_data_kecamatan'] = 'admin/Map/add_sub_district';
$route['admin_side/simpan_data_kecamatan'] = 'admin/Map/save_sub_district';
$route['admin_side/ubah_data_kecamatan/(:any)'] = 'admin/Map/edit_sub_district/$1';
$route['admin_side/perbarui_data_kecamatan'] = 'admin/Map/update_sub_district_data';
$route['admin_side/hapus_data_kecamatan/(:any)'] = 'admin/Map/delete_sub_district/$1';
$route['admin_side/data_kelurahan'] = 'admin/Map/village';
$route['admin_side/tambah_data_kelurahan'] = 'admin/Map/add_village';
$route['admin_side/simpan_data_kelurahan'] = 'admin/Map/save_village';
$route['admin_side/ubah_data_kelurahan/(:any)'] = 'admin/Map/edit_village/$1';
$route['admin_side/perbarui_data_kelurahan'] = 'admin/Map/update_village_data';
$route['admin_side/hapus_data_kelurahan/(:any)'] = 'admin/Map/delete_village/$1';

/* Member */
$route['member_side/launcher'] = 'member/App/launcher';
$route['member_side/beranda'] = 'member/App/home';
$route['member_side/menu'] = 'member/App/menu';
$route['member_side/log_activity'] = 'member/App/log_activity';
$route['member_side/hapus_aktifitas/(:any)'] = 'member/App/hapus_aktifitas/$1';
$route['member_side/cleaning_log'] = 'member/App/cleaning_log';
$route['member_side/tentang_aplikasi'] = 'member/App/about';
$route['member_side/bantuan'] = 'member/App/helper';

$route['member_side/dasbor_peta'] = 'member/Dashboard';
$route['member_side/peta_provinsi/(:any)'] = 'member/Dashboard/province/$1';
$route['member_side/peta_kabupaten/(:any)'] = 'member/Dashboard/city/$1';
$route['member_side/peta_kecamatan/(:any)'] = 'member/Dashboard/sub_district/$1';

$route['member_side/dasbor_grafik'] = 'member/Dashboard/main_graph';
$route['member_side/dasbor_grafik_provinsi/(:any)/(:any)'] = 'member/Dashboard/graph_province/$1/$2';
$route['member_side/dasbor_grafik_kabupaten/(:any)/(:any)'] = 'member/Dashboard/graph_region/$1/$2';
$route['member_side/dasbor_grafik_kecamatan/(:any)/(:any)'] = 'member/Dashboard/graph_district/$1/$2';

$route['member_side/admin'] = 'member/Master/admin_data';
$route['member_side/tambah_data_admin'] = 'member/Master/add_admin_data';
$route['member_side/simpan_data_admin'] = 'member/Master/save_admin_data';
$route['member_side/ubah_data_admin/(:any)'] = 'member/Master/edit_admin_data/$1';
$route['member_side/perbarui_data_admin'] = 'member/Master/update_admin_data';
$route['member_side/hapus_data_admin/(:any)'] = 'member/Master/delete_admin_data/$1';

$route['member_side/relawan'] = 'member/Master/relawan_data';
$route['member_side/tambah_data_relawan'] = 'member/Master/add_relawan_data';
$route['member_side/simpan_data_relawan'] = 'member/Master/save_relawan_data';
$route['member_side/detail_data_relawan/(:any)'] = 'member/Master/detail_relawan_data/$1';
$route['member_side/ubah_data_relawan/(:any)'] = 'member/Master/edit_relawan_data/$1';
$route['member_side/perbarui_data_relawan'] = 'member/Master/update_relawan_data';
$route['member_side/atur_ulang_kata_sandi_relawan/(:any)'] = 'member/Master/reset_password_relawan_account/$1';
$route['member_side/hapus_data_relawan/(:any)'] = 'member/Master/delete_relawan_data/$1';

$route['member_side/data_saksi'] = 'member/Master/saksi_data';
$route['member_side/tambah_data_saksi'] = 'member/Master/add_saksi_data';
$route['member_side/ubah_data_saksi/(:any)'] = 'member/Master/edit_saksi_data/$1';

$route['member_side/target_suara'] = 'member/Master/target_suara';
$route['member_side/target_suara_kec/(:any)'] = 'member/Master/target_suara_kecamatan/$1';
$route['member_side/ubah_target_suara'] = 'member/Master/edit_target_suara';
$route['member_side/perbarui_target_suara'] = 'member/Master/update_target_suara';

$route['member_side/data_provinsi'] = 'member/Map/province';
$route['member_side/tambah_data_provinsi'] = 'member/Map/add_province';
$route['member_side/simpan_data_provinsi'] = 'member/Map/save_province';
$route['member_side/ubah_data_provinsi/(:any)'] = 'member/Map/edit_province/$1';
$route['member_side/perbarui_data_provinsi'] = 'member/Map/update_province_data';
$route['member_side/hapus_data_provinsi/(:any)'] = 'member/Map/delete_province/$1';
$route['member_side/data_kabkot'] = 'member/Map/city';
$route['member_side/tambah_data_kabkot'] = 'member/Map/add_city';
$route['member_side/simpan_data_kabkot'] = 'member/Map/save_city';
$route['member_side/ubah_data_kabkot/(:any)'] = 'member/Map/edit_city/$1';
$route['member_side/perbarui_data_kabkot'] = 'member/Map/update_city_data';
$route['member_side/hapus_data_kabkot/(:any)'] = 'member/Map/delete_city/$1';
$route['member_side/data_kecamatan'] = 'member/Map/sub_district';
$route['member_side/tambah_data_kecamatan'] = 'member/Map/add_sub_district';
$route['member_side/simpan_data_kecamatan'] = 'member/Map/save_sub_district';
$route['member_side/ubah_data_kecamatan/(:any)'] = 'member/Map/edit_sub_district/$1';
$route['member_side/perbarui_data_kecamatan'] = 'member/Map/update_sub_district_data';
$route['member_side/hapus_data_kecamatan/(:any)'] = 'member/Map/delete_sub_district/$1';
$route['member_side/data_kelurahan'] = 'member/Map/village';
$route['member_side/tambah_data_kelurahan'] = 'member/Map/add_village';
$route['member_side/simpan_data_kelurahan'] = 'member/Map/save_village';
$route['member_side/ubah_data_kelurahan/(:any)'] = 'member/Map/edit_village/$1';
$route['member_side/perbarui_data_kelurahan'] = 'member/Map/update_village_data';
$route['member_side/hapus_data_kelurahan/(:any)'] = 'member/Map/delete_village/$1';

$route['member_side/daftar_instruksi'] = 'member/Task/daftar_instruksi';
$route['member_side/usulan_instruksi'] = 'member/Task/usulan_instruksi';
$route['member_side/setujui_usulan/(:any)'] = 'member/Task/setujui_usulan/$1';
$route['member_side/cetak_rekap_usulan_relawan'] = 'member/Task/cetak_rekap_usulan_relawan';
$route['member_side/tambah_instruksi'] = 'member/Task/tambah_instruksi';
$route['member_side/simpan_instruksi'] = 'member/Task/simpan_instruksi';
$route['member_side/detail_instruksi/(:any)'] = 'member/Task/detail_instruksi/$1';
$route['member_side/hapus_instruksi/(:any)'] = 'member/Task/hapus_instruksi/$1';
$route['member_side/hapus_usulan_instruksi/(:any)'] = 'member/Task/hapus_usulan_instruksi/$1';

$route['member_side/rekap_laporan'] = 'member/Report/main';
$route['member_side/detil_rekap/(:any)'] = 'member/Report/detail_report/$1';

$route['member_side/analisis'] = 'member/Report/analysis';
$route['member_side/tambah_analisis'] = 'member/Report/add_analysis';
$route['member_side/detil_analisis/(:any)'] = 'member/Report/detail_analysis/$1';

$route['member_side/rekap_isu'] = 'member/Report/rekap_isu';
$route['member_side/hapus_data_isu/(:any)'] = 'member/Report/hapus_data_isu/$1';

/* Relawan */
$route['relawan_side/launcher'] = 'relawan/App/launcher';
$route['relawan_side/beranda'] = 'relawan/App/home';
$route['relawan_side/menu'] = 'relawan/App/menu';
$route['relawan_side/log_activity'] = 'relawan/App/log_activity';
$route['relawan_side/hapus_aktifitas/(:any)'] = 'relawan/App/hapus_aktifitas/$1';
$route['relawan_side/cleaning_log'] = 'relawan/App/cleaning_log';
$route['relawan_side/tentang_aplikasi'] = 'relawan/App/about';
$route['relawan_side/bantuan'] = 'relawan/App/helper';

$route['relawan_side/dasbor_peta'] = 'relawan/Dashboard';
$route['relawan_side/peta_provinsi/(:any)'] = 'relawan/Dashboard/province/$1';
$route['relawan_side/peta_kabupaten/(:any)'] = 'relawan/Dashboard/city/$1';
$route['relawan_side/peta_kecamatan/(:any)'] = 'relawan/Dashboard/sub_district/$1';

$route['relawan_side/dasbor_grafik'] = 'relawan/Dashboard/main_graph';
$route['relawan_side/dasbor_grafik_provinsi/(:any)/(:any)'] = 'relawan/Dashboard/graph_province/$1/$2';
$route['relawan_side/dasbor_grafik_kabupaten/(:any)/(:any)'] = 'relawan/Dashboard/graph_region/$1/$2';
$route['relawan_side/dasbor_grafik_kecamatan/(:any)/(:any)'] = 'relawan/Dashboard/graph_district/$1/$2';

$route['relawan_side/daftar_relawan'] = 'relawan/Master/relawan_data';
$route['relawan_side/tambah_data_relawan'] = 'relawan/Master/add_relawan_data';
$route['relawan_side/simpan_data_relawan'] = 'relawan/Master/save_relawan_data';
$route['relawan_side/detail_data_relawan/(:any)'] = 'relawan/Master/detail_relawan_data/$1';
$route['relawan_side/ubah_data_relawan/(:any)'] = 'relawan/Master/edit_relawan_data/$1';
$route['relawan_side/perbarui_data_relawan'] = 'relawan/Master/update_relawan_data';
$route['relawan_side/atur_ulang_kata_sandi_relawan/(:any)'] = 'relawan/Master/reset_password_relawan_account/$1';
$route['relawan_side/hapus_data_relawan/(:any)'] = 'relawan/Master/delete_relawan_data/$1';

$route['relawan_side/daftar_rekrutan'] = 'relawan/Master/recruitment_data';
$route['relawan_side/tambah_data_admin'] = 'relawan/Master/add_administrator_data';
$route['relawan_side/simpan_data_admin'] = 'relawan/Master/save_administrator_data';
$route['relawan_side/detail_data_admin/(:any)'] = 'relawan/Master/detail_administrator_data/$1';
$route['relawan_side/ubah_data_admin/(:any)'] = 'relawan/Master/edit_administrator_data/$1';
$route['relawan_side/perbarui_data_admin'] = 'relawan/Master/update_administrator_data';
$route['relawan_side/atur_ulang_kata_sandi_admin/(:any)'] = 'relawan/Master/reset_password_administrator_account/$1';
$route['relawan_side/hapus_data_admin/(:any)'] = 'relawan/Master/delete_administrator_data/$1';

$route['relawan_side/tambah_usulan'] = 'relawan/Task/tambah_usulan';
$route['relawan_side/daftar_tugas'] = 'relawan/Task/daftar_tugas';

$route['relawan_side/data_provinsi'] = 'relawan/Map/province';
$route['relawan_side/tambah_data_provinsi'] = 'relawan/Map/add_province';
$route['relawan_side/simpan_data_provinsi'] = 'relawan/Map/save_province';
$route['relawan_side/ubah_data_provinsi/(:any)'] = 'relawan/Map/edit_province/$1';
$route['relawan_side/perbarui_data_provinsi'] = 'relawan/Map/update_province_data';
$route['relawan_side/hapus_data_provinsi/(:any)'] = 'relawan/Map/delete_province/$1';
$route['relawan_side/data_kabkot'] = 'relawan/Map/city';
$route['relawan_side/tambah_data_kabkot'] = 'relawan/Map/add_city';
$route['relawan_side/simpan_data_kabkot'] = 'relawan/Map/save_city';
$route['relawan_side/ubah_data_kabkot/(:any)'] = 'relawan/Map/edit_city/$1';
$route['relawan_side/perbarui_data_kabkot'] = 'relawan/Map/update_city_data';
$route['relawan_side/hapus_data_kabkot/(:any)'] = 'relawan/Map/delete_city/$1';
$route['relawan_side/data_kecamatan'] = 'relawan/Map/sub_district';
$route['relawan_side/tambah_data_kecamatan'] = 'relawan/Map/add_sub_district';
$route['relawan_side/simpan_data_kecamatan'] = 'relawan/Map/save_sub_district';
$route['relawan_side/ubah_data_kecamatan/(:any)'] = 'relawan/Map/edit_sub_district/$1';
$route['relawan_side/perbarui_data_kecamatan'] = 'relawan/Map/update_sub_district_data';
$route['relawan_side/hapus_data_kecamatan/(:any)'] = 'relawan/Map/delete_sub_district/$1';
$route['relawan_side/data_kelurahan'] = 'relawan/Map/village';
$route['relawan_side/tambah_data_kelurahan'] = 'relawan/Map/add_village';
$route['relawan_side/simpan_data_kelurahan'] = 'relawan/Map/save_village';
$route['relawan_side/ubah_data_kelurahan/(:any)'] = 'relawan/Map/edit_village/$1';
$route['relawan_side/perbarui_data_kelurahan'] = 'relawan/Map/update_village_data';
$route['relawan_side/hapus_data_kelurahan/(:any)'] = 'relawan/Map/delete_village/$1';

$route['relawan_side/laporan'] = 'relawan/Report/rekap_laporan';
$route['relawan_side/tambah_laporan'] = 'relawan/Report/tambah_laporan';
$route['relawan_side/ubah_laporan/(:any)'] = 'relawan/Report/ubah_laporan/$1';

$route['relawan_side/daftar_instruksi'] = 'relawan/Task/daftar_instruksi';
$route['relawan_side/usulan_instruksi'] = 'relawan/Task/usulan_instruksi';
$route['relawan_side/setujui_usulan/(:any)'] = 'relawan/Task/setujui_usulan/$1';
$route['relawan_side/cetak_rekap_usulan_relawan'] = 'relawan/Task/cetak_rekap_usulan_relawan';
$route['relawan_side/tambah_instruksi'] = 'relawan/Task/tambah_instruksi';
$route['relawan_side/simpan_instruksi'] = 'relawan/Task/simpan_instruksi';
$route['relawan_side/detail_instruksi/(:any)'] = 'relawan/Task/detail_instruksi/$1';
$route['relawan_side/hapus_instruksi/(:any)'] = 'relawan/Task/hapus_instruksi/$1';
$route['relawan_side/hapus_usulan_instruksi/(:any)'] = 'relawan/Task/hapus_usulan_instruksi/$1';

$route['relawan_side/rekap_isu'] = 'relawan/Report/rekap_isu';
$route['relawan_side/hapus_data_isu/(:any)'] = 'relawan/Report/hapus_data_isu/$1';

/* REST API */
$route['api'] = 'Rest_server/documentation';

/*
| -------------------------------------------------------------------------
| Sample REST API Routes
| -------------------------------------------------------------------------
*/
$route['api/example/users/(:num)'] = 'api/example/users/id/$1'; // Example 4
$route['api/example/users/(:num)(\.)([a-zA-Z0-9_-]+)(.*)'] = 'api/example/users/id/$1/format/$3$4'; // Example 8
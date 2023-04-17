<?php
defined('BASEPATH') or exit('No direct script access allowed');

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
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	https://codeigniter.com/userguide3/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There are three reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router which controller/method to use if those
| provided in the URL cannot be matched to a valid route.
|
|	$route['translate_uri_dashes'] = FALSE;
|
| This is not exactly a route, but allows you to automatically route
| controller and method names that contain dashes. '-' isn't a valid
| class or method name character, so it requires translation.
| When you set this option to TRUE, it will replace ALL dashes in the
| controller and method URI segments.
|
| Examples:	my-controller/index	-> my_controller/index
|		my-controller/my-method	-> my_controller/my_method
*/
$route['default_controller'] = 'home';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;

// Route Auth / Guest

$route['login'] = 'Auth/Login';
$route['signin'] = 'Auth/Login';
$route['_login'] = 'Auth/Login/process';
$route['logout'] = 'Auth/Login/logout';

$route['register'] = 'Auth/Register';
$route['forgot-password'] = 'Auth/Login';


// Route Apps
$route['dashboard'] = 'dashboard';
$route['config/update'] = 'Config/update';
$route['import-massal'] = 'Import';

$route['daftar-user'] = 'User';
$route['user/all'] = 'User/show';

$route['category'] = 'Category';
$route['category/all'] = 'Category/show';

$route['rombel'] = 'Rombel';
$route['rombel/get-santri-rombel'] = 'Rombel/GetSantriRombel';
$route['rombel/getrombelwalikelas'] = 'Rombel/GetRombelWaliKelas';
$route['rombel/all'] = 'Rombel/show';

$route['mapel'] = 'Mapel';
$route['mapel/all'] = 'Mapel/show';
$route['mapel/getAll'] = 'Mapel/all';

$route['jadwal'] = 'Jadwal';
$route['jadwal/all'] = 'Jadwal/show';

$route['maklumat'] = 'Maklumat';
$route['maklumat/all'] = 'Maklumat/show';

$route['product'] = 'Product';
$route['product/all'] = 'Product/show';

$route['santri'] = 'Santri';
$route['santri/all'] = 'Santri/show';

$route['spp'] = 'SPP';
$route['spp/all'] = 'SPP/show';

$route['tabungan'] = 'Tabungan';
$route['tabungan/all'] = 'Tabungan/show';

$route['kehadiran'] = 'Kehadiran';
$route['kehadiran/all'] = 'Kehadiran/show';

$route['ustadz'] = 'Ustadz';
$route['ustadz/all'] = 'Ustadz/show';
$route['ustadz/getAll'] = 'Ustadz/all';

$route['kelas'] = 'Kelas';
$route['kelas/all'] = 'Kelas/show';
$route['kelas/getAll'] = 'Kelas/all';

$route['tahun_ajaran'] = 'TahunAjaran';
$route['tahun_ajaran/all'] = 'TahunAjaran/show';
$route['tahun_ajaran/getAll'] = 'TahunAjaran/all';

$route['walisantri'] = 'WaliSantri';
$route['walisantri/all'] = 'WaliSantri/show';
$route['walisantri/getAll'] = 'WaliSantri/all';

$route['history-spp'] = 'SPP/history_spp';
$route['history-spp/all'] = 'SPP/get_history_spp';

$route['visitor'] = 'Visitor';
$route['visitor/all'] = 'Visitor/show';

$route['laporan-transaksi'] = 'Laporan/transaksi';


$route['order-k'] = 'Order';
$route['transaksi-k'] = '_Kasir/Transaksi';
$route['sembako-k'] = '_Kasir/Sembako';


$route['profil-us'] = '_Ustadz/Profil';
$route['jadwal-us'] = '_Ustadz/Jadwal';
$route['jadwal-us/all'] = '_Ustadz/Jadwal/show';
$route['mapel-us'] = '_Ustadz/Mapel';
$route['mapel-us/all'] = '_Ustadz/Mapel/show';
$route['absensi-us'] = '_Ustadz/Absensi';
$route['absensi-us/jadwal'] = '_Ustadz/Absensi/show';
$route['absensi-us/jadwal-sekarang'] = '_Ustadz/Absensi/GetJadwalWaktuIni';
$route['penilaian-us'] = '_Ustadz/Penilaian';
$route['raport-us'] = '_Ustadz/Raport';
$route['raport-us/all'] = '_Ustadz/Raport/show';

$route['santri-us'] = '_Ustadz/Santri';
$route['santri-us/all'] = '_Ustadz/Santri/show';

$route['laporan-us-absensi'] = '_Ustadz/Laporan';
$route['laporan-us-absensi/all'] = '_Ustadz/Laporan/absensi';


$route['profil-ws'] = '_WaliSantri/Profil';

$route['order-ws'] = '_WaliSantri/Order';
$route['order-ws/all'] = '_WaliSantri/Order/show';

$route['laporan-ws-absensi'] = '_WaliSantri/Laporan';
$route['laporan-ws-absensi/all'] = '_WaliSantri/Laporan/absensi';

$route['santri-ws'] = '_WaliSantri/Santri';
$route['santri-ws/all'] = '_WaliSantri/Santri/show';

$route['tabungan-ws'] = '_WaliSantri/Tabungan';
$route['tabungan-ws/all'] = '_WaliSantri/Tabungan/show';

$route['spp/bayar'] = '_WaliSantri/SPP/bayar';
$route['spp-ws'] = '_WaliSantri/SPP';
$route['spp-ws/all'] = '_WaliSantri/SPP/show';

$route['product-ws'] = '_WaliSantri/Product';
$route['product-ws/all'] = '_WaliSantri/Product/show';

$route['transaksi-ws'] = '_WaliSantri/Transaksi';
$route['saldo-ws'] = '_WaliSantri/Saldo';
$route['maklumat-ws'] = '_WaliSantri/Maklumat';

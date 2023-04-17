<?php
defined('BASEPATH') or exit('No direct script access allowed');

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class Raport extends MY_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('RombelModel');
		$this->load->model('PenilaianModel');
		$this->load->model('TahunAjaranModel');
		$this->load->model('JadwalModel');
		$this->load->model('UstadzModel');
		$this->load->model('SantriModel');
		$this->load->helper('pdf');
	}

	public function index()
	{
		$this->session->set_userdata(['menu_active' => 'raport-us', 'sub_menu_active' => '']);
		$menu = $this->MenusModel->getMenu();

		$data = [
			'content' => 'components/ustadz/raport',
			'plugin' => 'plugins/ustadz/raport',
			'css' => 'css/santri',
			'menus' => fetch_menu($menu)
		];

		$this->load->view('layouts/app', $data);
	}


	public function show()
	{
		$ustadz = $this->UstadzModel->GetUserById($this->session->userdata('id'))->row();
		$where['us.id'] = $ustadz->id_ustadz;

		$list = $this->RombelModel->getAll($where)->result();
		$html = '';

		foreach ($list as $ls) {
			$html .= '<tr>
                        <td>' . $ls->nis . '</td>
                        <td>' . $ls->nama_santri . '</td>
                        <td>' . $ls->nama_kelas . '</td>
                        <td><a href="' . site_url('_Ustadz/Raport/GetRaportBySantri/' . $ls->id_santri) . '" class="btn btn-primary">Lihat Raport</a></td>
                    </tr>';
		}

		echo $html;
	}

	public function template()
	{
		$mapel_html  = '';
		$nilai_html = '';
		$santri_html = '';

		$ustadz = $this->UstadzModel->GetUserById($this->session->userdata('id'))->row();
		$where['us.id'] = $ustadz->id_ustadz;
		$where['k.id'] = $this->input->post('kelas_id');

		$santri = $this->RombelModel->getAll($where);
		$mapel = $this->JadwalModel->GetJadwalByKelas($where['k.id']);
		$tahun_ajaran = $this->TahunAjaranModel->getAktif()->row();

		$mapel_row = 4;
		$total_mapel = $mapel->num_rows();

		$spreadsheet = new Spreadsheet();
		$sheet = $spreadsheet->getActiveSheet();
		$sheet->setCellValue('A1', 'ID');
		$sheet->setCellValue('B1', 'NIS');
		$sheet->setCellValue('C1', 'Nama Lengkap');
		$sheet->setCellValue('D1', 'Kelas');

		$col = 69; // char E
		$colX = 0;

		foreach ($mapel->result() as $mp) {
			$sheet->setCellValue(chr($col++) . '1', $mp->slug_mapel);
		}

		$sheet->setCellValue(chr($col + 1) . '1', 'Total Sakit');
		$sheet->setCellValue(chr($col + 2) . '1', 'Total Izin');
		$sheet->setCellValue(chr($col + 3) . '1', 'Total Tanpa Keterangan');
		$sheet->setCellValue(chr($col + 4) . '1', 'Naik Kelas (ya/tidak)');
		$sheet->setCellValue(chr($col + 5) . '1', 'Akhlak dan Kepribadian');

		$rows = 2;
		foreach ($santri->result() as $s) {
			$sheet->setCellValue('A' . $rows, $s->id_santri);
			$sheet->setCellValue('B' . $rows, $s->nis);
			$sheet->setCellValue('C' . $rows, $s->nama_santri);
			$sheet->setCellValue('D' . $rows, $s->nama_kelas);

			$rows++;
		}

		ob_end_clean();
		// Proses file excel
		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header('Content-Disposition: attachment; filename="Data Siswa.xlsx"'); // Set nama file excel nya
		header('Cache-Control: max-age=0');
		$writer = new Xlsx($spreadsheet);
		$writer->save('php://output');
	}

	public function import()
	{
		$this->load->model('UstadzModel');
		$path         = 'assets/documents/';
		$json         = [];
		$this->upload_config($path);
		$list_nilai =  [];
		if (!$this->upload->do_upload('template')) {
			$json = [
				'error_message' => $this->upload->display_errors(),
			];
		} else {
			$file_data     = $this->upload->data();
			$file_name     = $path . $file_data['file_name'];
			$arr_file     = explode('.', $file_name);
			$extension     = end($arr_file);
			if ('csv' == $extension) {
				$reader     = new \PhpOffice\PhpSpreadsheet\Reader\Csv();
			} else {
				$reader     = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
			}
			$spreadsheet     = $reader->load($file_name);
			$sheet_data     = $spreadsheet->getActiveSheet()->toArray();

			$tahun_ajaran = $this->TahunAjaranModel->getAktif()->row();
			$ustadz = $this->UstadzModel->GetUserById($this->session->userdata('id'))->row();
			$where['us.id'] = $ustadz->id_ustadz;
			$where['k.id'] = $this->input->post('kelas_id');

			$santri = $this->RombelModel->getAll($where);
			$mapel = $this->JadwalModel->GetJadwalByKelas($where['k.id']);

			unset($sheet_data[0]);
			$numrow = 1;
			$list             = [];
			$list_nilai             = [];
			$total_mapel = $mapel->num_rows();

			// echo '<pre>' . print_r($mapel->result(), 1) . '</pre>';
			// die;

			foreach ($sheet_data as $sd) {
				$m = 4;
				$data['santri_id'] = $sd[0];
				$data['total_sakit'] = $sd[$total_mapel + 4];
				$data['total_izin'] = $sd[$total_mapel + 4 + 1];
				$data['total_tanpa_keterangan'] = $sd[$total_mapel + 4 + 2];
				$data['naik_kelas'] = $sd[$total_mapel + 4 + 3];
				$data['akhlak_kepribadian'] = $sd[$total_mapel + 4 + 4];
				$data['tahun_ajaran_id'] = $tahun_ajaran->id;

				$in_raport = $this->db->insert('raport', $data);
				$raport_id = $this->db->insert_id();

				foreach ($mapel->result() as $mp => $key) {
					$nilai[$mp]['nilai_angka'] = $sd[$m];
					$nilai[$mp]['mapel_id'] = $key->id_mapel;
					$nilai[$mp]['raport_id'] = $raport_id;
					$m++;
				}


				// echo '<pre>' . print_r($nilai, 1) . '</pre>';
				// die;
				$list_nilai[$sd[0]] = $nilai;
				$this->db->insert_batch('penilaian', $list_nilai[$sd[0]]);
			}
		}

		echo json_encode($list_nilai);
	}

	public function upload_config($path)
	{
		if (!is_dir($path))
			mkdir($path, 0777, TRUE);
		$config['upload_path']         = './' . $path;
		$config['allowed_types']     = 'csv|CSV|xlsx|XLSX|xls|XLS';
		$config['max_filename']         = '255';
		$config['encrypt_name']     = TRUE;
		$config['max_size']         = 4096;
		$this->load->library('upload', $config);
	}

	public function GetKelas()
	{
		$this->load->model('KelasModel');
		$ustadz = $this->UstadzModel->GetUserById($this->session->userdata('id'))->row();
		$where['wk.id'] = $ustadz->id_ustadz;
		$data = $this->KelasModel->all($where)->result();
		echo json_encode($data);
	}

	public function GetRaportBySantri($id)
	{
		$data['raport'] = $this->PenilaianModel->GetRaportBySantri($id)->row();
		// echo json_encode($tabungan);

		if ($data['raport'] != NULL) {
			$data['penilaian'] = $this->PenilaianModel->GetNilaiByRaport($data['raport']->id_raport)->result();
			if ($data['raport']->semester == 'genap') {
				$html_ = $this->load->view('berkas/raport-genap', $data, true);
			} else {
				$html_ = $this->load->view('berkas/raport-ganjil', $data, true);
			}

			pdf_generator($html_, 'Raport');
		}
		// echo '<pre>' . print_r($data, 1) . '</pre>';
		// die;
	}
}

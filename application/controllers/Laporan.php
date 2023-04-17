<?php
defined('BASEPATH') or exit('No direct script access allowed');

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class Laporan extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('TransaksiModel');
    }

    public function transaksi()
    {
        $this->session->set_userdata(['menu_active' => 'laporan', 'sub_menu_active' => 'laporan-transaksi']);
        $menu = $this->MenusModel->getMenu();

        $data = [
            'content' => 'components/laporan-transaksi',
            'plugin' => 'plugins/laporan-transaksi',
            'menus' => fetch_menu($menu)
        ];

        $this->load->view('layouts/app', $data);
    }

    public function GetAllTransaction()
    {
        $start = str_replace("'", "", htmlspecialchars($this->input->post('start'), ENT_QUOTES));
        $end = str_replace("'", "", htmlspecialchars($this->input->post('end'), ENT_QUOTES));
        $data = $this->TransaksiModel->ReportTransaction($start, $end)->result();

        echo json_encode($data);
    }

    public function ReportTransaction()
    {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        // Buat sebuah variabel untuk menampung pengaturan style dari header tabel
        $style_col = [
            'font' => ['bold' => true], // Set font nya jadi bold
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER, // Set text jadi ditengah secara horizontal (center)
                'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER // Set text jadi di tengah secara vertical (middle)
            ],
            'borders' => [
                'top' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN], // Set border top dengan garis tipis
                'right' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN],  // Set border right dengan garis tipis
                'bottom' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN], // Set border bottom dengan garis tipis
                'left' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN] // Set border left dengan garis tipis
            ]
        ];
        // Buat sebuah variabel untuk menampung pengaturan style dari isi tabel
        $style_row = [
            'alignment' => [
                'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER // Set text jadi di tengah secara vertical (middle)
            ],
            'borders' => [
                'top' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN], // Set border top dengan garis tipis
                'right' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN],  // Set border right dengan garis tipis
                'bottom' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN], // Set border bottom dengan garis tipis
                'left' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN] // Set border left dengan garis tipis
            ]
        ];

        $start = str_replace("'", "", htmlspecialchars($this->input->post('start_date'), ENT_QUOTES));
        $end = str_replace("'", "", htmlspecialchars($this->input->post('end_date'), ENT_QUOTES));

        $sheet->setCellValue('A1', "DATA TRANSAKSI DARI TANGGAL " . date('d-m-Y', strtotime($start)) . " SAMPAI " . date('d-m-Y', strtotime($end))); // Set kolom A1 dengan tulisan "DATA SISWA"
        $sheet->mergeCells('A1:J1'); // Set Merge Cell pada kolom A1 sampai E1
        $sheet->getStyle('A1')->getFont()->setBold(true); // Set bold kolom A1
        // Buat header tabel nya pada baris ke 3
        $sheet->setCellValue('A3', "NO");
        $sheet->setCellValue('B3', "ORDER ID");
        $sheet->setCellValue('C3', "NAMA SANTRI");
        $sheet->setCellValue('D3', "WALI SANTRI");
        $sheet->setCellValue('E3', "JUMLAH");
        $sheet->setCellValue('F3', "BANK");
        $sheet->setCellValue('G3', "BANK ACCOUNT");
        $sheet->setCellValue('H3', "STATUS");
        $sheet->setCellValue('I3', "TANGGAL TRANSAKSI");
        $sheet->setCellValue('J3', "JENIS TRANSAKSI");
        // Apply style header yang telah kita buat tadi ke masing-masing kolom header
        $sheet->getStyle('A3')->applyFromArray($style_col);
        $sheet->getStyle('B3')->applyFromArray($style_col);
        $sheet->getStyle('C3')->applyFromArray($style_col);
        $sheet->getStyle('D3')->applyFromArray($style_col);
        $sheet->getStyle('E3')->applyFromArray($style_col);
        $sheet->getStyle('F3')->applyFromArray($style_col);
        $sheet->getStyle('G3')->applyFromArray($style_col);
        $sheet->getStyle('H3')->applyFromArray($style_col);
        $sheet->getStyle('I3')->applyFromArray($style_col);
        $sheet->getStyle('J3')->applyFromArray($style_col);

        $data = $this->TransaksiModel->ReportTransaction($start, $end)->result();

        $no = 1;
        $numrow = 4;
        foreach ($data as $dt) {
            if ($dt->wali_id != '') {
                $jenis = 'Transaksi Wali Santri';
            } else {
                $jenis = 'Transaksi Santri';
            }

            $sheet->setCellValue('A' . $numrow, $no);
            $sheet->setCellValue('B' . $numrow, $dt->order_id);
            $sheet->setCellValue('C' . $numrow, $dt->name);
            $sheet->setCellValue('D' . $numrow, $dt->wali_santri);
            $sheet->setCellValue('E' . $numrow, $dt->gross_amount);
            $sheet->setCellValue('F' . $numrow, $dt->bank);
            $sheet->setCellValue('G' . $numrow, $dt->bank_account);
            $sheet->setCellValue('H' . $numrow, $dt->status_paid);
            $sheet->setCellValue('I' . $numrow, $dt->created_at);
            $sheet->setCellValue('J' . $numrow, $jenis);

            // Apply style row yang telah kita buat tadi ke masing-masing baris (isi tabel)
            $sheet->getStyle('A' . $numrow)->applyFromArray($style_row);
            $sheet->getStyle('B' . $numrow)->applyFromArray($style_row);
            $sheet->getStyle('C' . $numrow)->applyFromArray($style_row);
            $sheet->getStyle('D' . $numrow)->applyFromArray($style_row);
            $sheet->getStyle('E' . $numrow)->applyFromArray($style_row);
            $sheet->getStyle('F' . $numrow)->applyFromArray($style_row);
            $sheet->getStyle('G' . $numrow)->applyFromArray($style_row);
            $sheet->getStyle('H' . $numrow)->applyFromArray($style_row);
            $sheet->getStyle('I' . $numrow)->applyFromArray($style_row);
            $sheet->getStyle('J' . $numrow)->applyFromArray($style_row);

            $no++; // Tambah 1 setiap kali looping
            $numrow++; // Tambah 1 setiap kali looping
        }

        $sheet->getPageSetup()->setOrientation(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::ORIENTATION_LANDSCAPE);
        // Set judul file excel nya
        $sheet->setTitle("Laporan Data Transaksi");
        // Proses file excel
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="Data Transaksi ' . date('d-m-Y', strtotime($start)) . ' - ' . date('d-m-Y', strtotime($end)) . '.xlsx"'); // Set nama file excel nya
        header('Cache-Control: max-age=0');
        $writer = new Xlsx($spreadsheet);
        $writer->save('php://output');
    }
}

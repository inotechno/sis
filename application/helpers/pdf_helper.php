<?php

// function untuk menampilkan nama hari ini dalam bahasa indonesia
// di buat oleh malasngoding.com
class MYPDF extends TCPDF
{
	//Page header
	public function Header()
	{
		// Logo
		$image_file =   './assets/images/' . _LOGO_MINI;
		// $img = $this->Image($image_file, 10, 10, 30, '', '', '', 'T', false, 300, '', false, false, 0, false, false, false);
		// Set font

		// $this->SetFont('helvetica', 'B', 20);
		// Title
		// $this->Cell(0, 15, strtoupper(_NAMA_PESANTREN), 0, false, 'C', 0, '', 0, false, 'M', 'M');

		$html = '<table width="100%" border="0">
                    <tr>
                        <td width="20%" rowspan="5"><img width="150px" height="150px" src="' . $image_file . '"></td>
                        <td width="80%" style="text-align:center;font-size:25px;font-weight:bold">' . strtoupper(_NAMA_PESANTREN) . '</td>
                    </tr>
                    <tr>
                        <td width="80%" style="text-align:center;">Pendiri ' . _NAMA_PENDIRI . ' Tanggal ' . date_indo(date('Y-m-d', strtotime(_TANGGAL_PENDIRIAN))) . '</td>
                    </tr>
                    <tr>
                        <td width="80%" style="text-align:center;font-size:12px;">' . _ALAMAT . '</td>
                    </tr>
                    <tr>
                        <td width="80%" style="text-align:center;">Telp : ' . _PHONE . ', Email : ' . _EMAIL . '</td>
                    </tr>
                    <tr>
                        <td width="40%" style="text-align:center;line-height:40px;font-size:10px;font-weight:bold;">Nomor SK : ' . _NOMOR_SK . '</td>
                        <td width="40%" style="text-align:center;line-height:40px;font-size:10px;font-weight:bold;">Nomor SK : ' . _NPWP . '</td>
                    </tr>

                </table><hr>';

		$this->writeHTML($html, true, false, true, false, '');

		// $this->Ln(5);

		// $this->Cell(0, 0, 'TEST CELL STRETCH: no stretch', 1, false, 'C', 0, '', 0);
		// $this->Cell(0, 0, 'TEST CELL STRETCH: scaling', 1, false, 'C', 0, '', 1);
		// $this->Cell(0, 0, 'TEST CELL STRETCH: force scaling', 1, 1, 'C', 0, '', 2);
		// $this->Cell(0, 0, 'TEST CELL STRETCH: spacing', 1, 1, 'C', 0, '', 3);
		// $this->Cell(0, 0, 'TEST CELL STRETCH: force spacing', 1, 1, 'C', 0, '', 4);

		// $this->Ln(5);

		// $this->Cell(45, 0, 'TEST CELL STRETCH: scaling', 0, 1, 'C', 0, '', 1);
		// $this->Cell(45, 0, 'TEST CELL STRETCH: force scaling', 0, 1, 'C', 0, '', 2);
		// $this->Cell(45, 0, 'TEST CELL STRETCH: spacing', 0, 1, 'C', 0, '', 3);
		// $this->Cell(45, 0, 'TEST CELL STRETCH: force spacing', 0, 1, 'C', 0, '', 4);
		// $this->writeHTML('hagshjdgashdasdas');
	}

	// Page footer
	public function Footer()
	{
		// Position at 15 mm from bottom
		$this->SetY(-15);
		// Set font
		$this->SetFont('helvetica', 'I', 8);
		// Page number
		$this->Cell(0, 10, 'Page ' . $this->getAliasNumPage() . '/' . $this->getAliasNbPages(), 0, false, 'C', 0, '', 0, false, 'T', 'M');
	}
}

function pdf_generator($html_, $title)
{
	// $CI = &get_instance();

	$pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
	$pdf->SetCreator(PDF_CREATOR);
	$pdf->SetAuthor('Ahmad Fatoni');
	$pdf->SetTitle($title);
	$pdf->SetKeywords('TCPDF, PDF, penilaian, santri, raport, tabungan, spp');

	// set default header data
	$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE . ' 001', PDF_HEADER_STRING, array(0, 64, 255), array(0, 64, 128));
	$pdf->setFooterData(array(0, 64, 0), array(0, 64, 128));

	// set header and footer fonts
	$pdf->setHeaderFont(array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
	$pdf->setFooterFont(array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

	// set default monospaced font
	$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

	// set margins
	$pdf->SetMargins(PDF_MARGIN_LEFT, 40, PDF_MARGIN_RIGHT);

	$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
	$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

	// set auto page breaks
	$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

	// set image scale factor
	$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

	// set some language-dependent strings (optional)
	if (@file_exists(dirname(__FILE__) . '/lang/eng.php')) {
		require_once(dirname(__FILE__) . '/lang/eng.php');
		$pdf->setLanguageArray($l);
	}

	// ---------------------------------------------------------

	// set default font subsetting mode
	$pdf->setFontSubsetting(true);

	// Set font
	// dejavusans is a UTF-8 Unicode font, if you only need to
	// print standard ASCII chars, you can use core fonts like
	// helvetica or times to reduce file size.
	$pdf->SetFont('dejavusans', '', 11, '', true);
	// $pdf->SetX(30);

	// Add a page
	// This method has several options, check the source code documentation for more information.
	$pdf->AddPage();

	// set text shadow effect
	$pdf->setTextShadow(array('enabled' => true, 'depth_w' => 0.2, 'depth_h' => 0.2, 'color' => array(196, 196, 196), 'opacity' => 1, 'blend_mode' => 'Normal'));

	// Set some content to print
	$html = $html_;

	// Print text using writeHTMLCell()
	$pdf->writeHTMLCell(0, 0, '', '', $html, 0, 1, 0, true, '', true);

	// ---------------------------------------------------------
	ob_end_clean();
	// Close and output PDF document
	// This method has several options, check the source code documentation for more information.
	$pdf->Output($title, 'I');

	//============================================================+
	// END OF FILE
	//============================================================+
}

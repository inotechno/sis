<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Raport</title>
</head>

<body>
    <div align="center">
        <strong>LAPORAN HASIL BELAJAR SISWA SEMENTARA</strong><br>
    </div>
    <table width=10%>
        <tbody>
            <tr>
                <td width="20%">Nama Sekolah</td>
                <td width="1%">:</td>
                <td width="40%"><?= _NAMA_PESANTREN ?></td>
                <td width="25%">Kelas</td>
                <td width="1%">:</td>
                <td width="16%"><?= $raport->nama_kelas ?></td>
            </tr>
            <tr>
                <td width="20%">NIS</td>
                <td width="1%">:</td>
                <td width="40%"><?= $raport->nis ?></td>
                <td width="25%">Semester</td>
                <td width="1%">:</td>
                <td width="16%"><?= ucfirst($raport->semester) ?></td>
            </tr>
            <tr>
                <td width="20%">Nama Lengkap</td>
                <td width="1%">:</td>
                <td width="40%"><?= $raport->nama_santri ?></td>
                <td width="25%">Tahun Pelajaran</td>
                <td width="1%">:</td>
                <td width="16%"><?= $raport->tahun_ajaran ?></td>
            </tr>
            <tr>
                <td></td>
            </tr>
            <table border="1">
                <tr>
                    <td rowspan="2" align="center" width="5%">No</td>
                    <td rowspan="2" align="center" width="35%">Mata Pelajaran</td>
                    <td rowspan="2" align="center" width="10%">KKM</td>
                    <td colspan="2" align="center" width="20%">Nilai</td>
                    <td rowspan="2" align="center" width="30%"> Deskripsi Kemajuan Belajar</td>
                </tr>
                <tr>
                    <td align="center">Angka</td>
                    <td align="center">Huruf</td>
                </tr>
                <?php
                $no = 1;
                foreach ($penilaian as $p) { ?>
                    <tr>
                        <td align="center"><?= $no++ ?></td>
                        <td> <?= $p->nama_mapel ?></td>
                        <td align="center"><?= $p->nilai_kkm ?></td>
                        <td align="center"><?= $p->nilai_angka ?></td>
                        <td align="center"><?= $p->nilai_huruf ?></td>
                        <td align="center"><?= $p->deskripsi ?></td>
                    </tr>
                <?php } ?>
                <tr>
                    <td colspan="6"></td>
                </tr>
                <!-- <tr>
                    <td colspan="3" align="center">Kegiatan Pengembangan Diri</td>
                    <td colspan="1" align="center">Nilai</td>
                    <td colspan="2" align="center">Keterampilan</td>
                </tr>
                <tr>
                    <td colspan="3"> 1</td>
                    <td colspan="1"></td>
                    <td colspan="2"></td>
                </tr>
                <tr>
                    <td colspan="3"> 2</td>
                    <td colspan="1"></td>
                    <td colspan="2"></td>
                </tr>
                <tr>
                    <td colspan="3"> 3</td>
                    <td colspan="1"></td>
                    <td colspan="2"></td>
                </tr>
                <tr>
                    <td colspan="6"></td>
                </tr> -->
                <tr>
                    <td colspan="3" align="center">Akhlak dan Kepribadian</td>
                    <td colspan="1"></td>
                    <td colspan="2" align="center">Ketidakhadiran</td>
                </tr>
                <tr>
                    <td colspan="3" rowspan="3"><?= $raport->akhlak_kepribadian ?></td>
                    <td colspan="1"></td>
                    <td colspan="2"> 1. Sakit : <?= $raport->total_sakit ?></td>
                </tr>
                <tr>
                    <td colspan="1"></td>
                    <td colspan="2"> 2. Izin : <?= $raport->total_izin ?></td>
                </tr>
                <tr>
                    <td colspan="1"></td>
                    <td colspan="2"> 3. Tanpa Keterangan : <?= $raport->total_tanpa_keterangan ?></td>
                </tr><br>
                <table border="0" width="100%" style="margin-top: 25px;">
                    <tr align="center">
                        <td width="19%">Mengetahui,</td>
                        <td width="35%">Wali Kelas</td>
                        <td width="60%" align="left">Keputusan,</td>
                    </tr>
                    <tr align="center">
                        <td width=19%>Orang Tua/Wali</td>
                        <td width="35%"></td>
                        <td width="50%" align="left">Berdasarkan hasil yang di capai pada semester 1 dan 2, peserta didik ditetapkan naik ke kelas ..... (.................) tinggal di kelas ..... (.................).</td>
                    </tr><br><br>
                    <tr align="center">
                        <td width="21%"><u>..........................</u></td>
                        <td width="35%"><u><?= $raport->nama_ustadz ?></u></td>
                        <td width="45%" align="left">Jakarta, 25 Mei 2022</td>
                    </tr>
                    <tr>
                        <td width="28%"></td>
                        <td width="44%">NIP : <?= $raport->nip ?></td>
                    </tr><br><br><br><br><br>
                    <tr>
                        <td width="28%"></td>
                        <td width="28%"></td>
                        <td width="45%" align="left" hight><u>Risa Nurhanipah, M.Kom</u></td>
                    </tr>
                    <tr>
                        <td width="28%"></td>
                        <td width="28%"></td>
                        <td width="45%" align="left" hight>NIP. 195707241981031.007</td>
                    </tr>
                </table>
            </table>
        </tbody>
    </table>

</body>

</html>
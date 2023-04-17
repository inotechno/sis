<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SPP</title>
</head>

<body>
    <div align="center">
        <strong>BUKTI PEMBAYARAN</strong>
        <h4>Santriwan/Santriwati Pondok Pesantren Gontor</h4>
        <h6><i>www.gontor//kjfjshf.com</i></h6>
    </div>

    <table width="100%">
        <tbody>
            <tr>
                <td width="20%">Nama</td>
                <td width="3%">:</td>
                <td width=""><?= $nama_santri ?></td>
            </tr>
            <tr>
                <td width="20%">NIS</td>
                <td width="3%">:</td>
                <td width=""><?= $nis ?></td>
            </tr>
            <tr>
                <td width="20%">Bulan</td>
                <td width="3%">:</td>
                <td width=""><?= $bulan ?></td>
            </tr>
            <tr>
                <td width="20%">Nominal</td>
                <td width="3%">:</td>
                <td width="">Rp. <?= number_format($nominal) ?></td>
            </tr>
            <tr>
                <td width="20%">Tanggal Bayar</td>
                <td width="3%">:</td>
                <td width=""><?= date('d-m-Y H:i:s', strtotime($tanggal_bayar)) ?></td>
            </tr>
            <br>
            <tr>
                <td width="20%">Penerima</td>
                <td width="3%">:</td>
                <td width=""><?= $nama_penerima ?></td>
            </tr>
            <h5>Berkas cetak ini merupakan bukti resmi status pembayaran biaya pesantren santri, simpan bukti ini jika suatu saat terjadi kesalahan pencatatan maka bukti ini harus di tunjukan.</h5>
            <h6 align="center"><i>___ tanggal cetak <?= date('d-m-Y H:i:s') ?> ___</i></h6>
        </tbody>
    </table>
</body>

</html>
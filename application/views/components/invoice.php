<!-- Page Content  -->

<?php
$this->load->helper('qrcode');

$status_pembayaran = '';
$qrcode = '';
$link = '';
$check = '';
$batal = '';
// $batal = '<button class="col btn btn-danger my-1">Batalkan Pembayaran</button>';

$payment_type = $this->db->get_where('payment_types', ['name_slug' => $order->bank])->row();

if ($order->status_paid == 203) {
    if ($order->deadline < date('Y-m-d H:i:s')) {
        $status_pembayaran = '<span class="badge badge-danger">Expired</span>';
    } else {
        $batal = '<button class="col btn btn-danger my-1" data-id="' . $order->id . '" id="btn-delete">Batalkan Pembayaran</button>';
        $status_pembayaran = '<span class="badge badge-warning">Belum Di Bayar</span>';
        $check = '<button class="col btn btn-primary my-1" onclick="location.reload();">Cek Status Pembayaran</button>';
    }
} else if ($order->status_paid == 200) {
    $batal = '';
    $status_pembayaran = '<span class="badge badge-primary">Sudah Di Bayar</span>';
}

if ($order->bank == 'QRIS') {
    $qrcode = '<img src="' . generate($order->link) . '">';
}

if ($order->bank == 'ID_DANA' || $order->bank == 'ID_LINKAJA') {
    $link = '<a href="' . $order->link . '" target="_blank" class="col btn btn-success my-1">Klik Untuk Bayar</a>';
}

?>

<div id="content-page" class="content-page mb-2">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-4">
                <div class="iq-card">
                    <div class="iq-card-header d-flex justify-content-between">
                        <div class="iq-header-title">
                            <h4 class="card-title">Informasi Tagihan</h4>
                        </div>
                    </div>

                    <div class="iq-card-body">
                        <p class="text-muted font-weight-bold">No Tagihan</p>
                        <p><?= $order->order_id ?></p>

                        <hr>

                        <p class="text-muted font-weight-bold">Status Tagihan</p>
                        <p><?= $status_pembayaran ?></p>
                        <p>Batas Pembayaran : <?= date('d-m-Y H:i:s', strtotime($order->deadline)) ?></p>
                    </div>
                </div>

                <div class="iq-card">
                    <div class="iq-card-header d-flex justify-content-between">
                        <div class="iq-header-title">
                            <h4 class="card-title">Pembayaran</h4>
                        </div>
                    </div>

                    <div class="iq-card-body">
                        <p class="text-muted font-weight-bold">Metode Pembayaran</p>
                        <p><img class="img-fluid" width="200" src="<?= $payment_type->logo ?>" alt=""></p>

                        <hr>

                        <p class="text-muted font-weight-bold">Kode Pembayaran</p>
                        <p><?= $order->bank_account ?></p>
                        <p class="text-center"><?= $qrcode ?></p>

                        <hr>

                        <p class="text-muted font-weight-bold">Total Pembayaran</p>
                        <p class="text-primary"><?= 'Rp. ' . number_format($order->gross_amount) ?></p>
                    </div>
                </div>

                <?= $link ?>
                <?= $check ?>
                <?= $batal ?>
            </div>

            <div class="col-md">
                <div class="iq-card">
                    <div class="iq-card-header d-flex justify-content-between">
                        <div class="iq-header-title">
                            <h4 class="card-title">Cara Pembayaran</h4>
                        </div>
                    </div>
                    <div class="iq-card-body">
                        <p><?= $payment_type->method ?></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modal-delete-order" tabindex="-1" role="dialog" aria-labelledby="modal-delete" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header bg-danger">
                <h5 class="modal-title text-white">Modal Delete</h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

                <form id="form-delete-order" method="POST">
                    <input type="hidden" name="id">
                </form>

                <p>Apakah anda yakin ingin membatalkan transaksi ini ?</p>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-danger" form="form-delete-order">Hapus</button>
            </div>
        </div>
    </div>
</div>
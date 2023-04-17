<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/v/bs5/jszip-2.5.0/dt-1.11.5/af-2.3.7/b-2.2.2/b-colvis-2.2.2/b-html5-2.2.2/b-print-2.2.2/fc-4.0.2/sl-1.3.4/datatables.min.js"></script>

<script>
    $(document).ready(function() {
        // $('[name="nominal"]').simpleMoneyFormat();
        table = $('#table-santri').DataTable({
            "processing": true,
            "serverSide": true,
            // "scrollX": true,
            // "fixedColumns": {
            // 	 "leftColumns": 1,
            // 	 "rightColumns": 1
            // },
            "responsive": true,
            "lengthChange": false,
            "order": [],
            "bInfo": false,
            "autoWidth": true,
            "ajax": {
                "url": "<?= base_url('tabungan/all') ?>",
                "type": "POST"
            },

            "language": {
                "paginate": {
                    "previous": '<i class="ri-arrow-left-line"></i>',
                    "next": '<i class="ri-arrow-right-line"></i>'
                },
                "aria": {
                    "paginate": {
                        "previous": 'Previous',
                        "next": 'Next'
                    }
                }
            },

            "columnDefs": [{
                className: "text-center align-middle",
                targets: "_all"
            }, {
                "targets": [0],
                "orderable": false,
                "className": "text-center"
            }, ],
        });

        function reload_table() {
            table.ajax.reload();
        }

        function capitalizeFirstLetter(string) {
            return string.charAt(0).toUpperCase() + string.slice(1);
        }

        $('#table-santri').on('click', '.btn-view-tabungan', function() {
            var id = $(this).attr('data-id');
            var nama = $(this).attr('data-nama');
            var nis = $(this).attr('data-nis');

            $('.nama_santri').html(nama);
            $('.nis_santri').html(nis);
            $('#form-add-tabungan [name="santri_id"]').val(id);

            $.ajax({
                type: "GET",
                url: "<?= site_url('Tabungan/GetTabunganBySantri/') ?>" + id,
                dataType: "JSON",
                success: function(data) {
                    var html_tabungan = '';
                    var status = '';
                    var nominal = '';

                    var debit = 0;
                    var kredit = 0;
                    var saldo = 0;

                    // console.log(data);
                    if (data.length > 0) {

                        $.each(data, function(i, val) {
                            if (val.debit_kredit == 'debit') {
                                debit += parseInt(val.nominal);
                                status = '<span class="text-success">Pemasukan</span>';
                                nominal = '<span class="badge badge-success nominal">' + val.nominal + '</span>';
                            } else {
                                kredit += parseInt(val.nominal);
                                status = '<span class="text-danger">Pengeluaran</span>';
                                nominal = '<span class="badge badge-danger nominal">' + val.nominal + '</span>';
                            }
                            html_tabungan += '<tr?>' +
                                '<td>' + nominal + '</td>' +
                                '<td>' + status + '</td>' +
                                '<td>' + val.nama_penerima + '</td>' +
                                '<td><a href="' + base_url + 'Tabungan/CetakTabungan/' + val.id + '" target="_blank"><i class="ri-printer-line"></i></a></td>' +
                                '</tr>'
                        });

                        $('.nominal').simpleMoneyFormat();
                    } else {
                        html_tabungan = '<tr><td colspan="4" class="text-center">Tidak ada data</td></tr>';
                    }

                    $('#table-body-tabungan').html(html_tabungan);
                    $('#modal-view-tabungan').modal('show');
                    // console.log(data);
                    $('.debit').html(debit).simpleMoneyFormat();
                    $('.kredit').html(kredit).simpleMoneyFormat();

                    saldo = debit - kredit;
                    $('.saldo').html(saldo).simpleMoneyFormat();
                }
            });

            // $('#form-add-balance [name="saldo"]').simpleMoneyFormat();
        });

        $('#form-add-tabungan').submit(function() {
            var data = $(this).serialize();

            $.ajax({
                type: "POST",
                url: "<?= site_url('Tabungan/add') ?>",
                data: data,
                dataType: "JSON",
                success: function(response) {

                    if (response.type != 'success') {
                        notification(response.type, response.message);
                    } else {
                        notification(response.type, response.message);

                        $('#modal-view-tabungan').modal('hide');
                        $('#form-add-tabungan')[0].reset();
                    }

                }
            });

            return false;

        });

    });
</script>
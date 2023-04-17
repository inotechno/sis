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
                "url": "<?= base_url('spp-ws/all') ?>",
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

        $('#table-santri').on('click', '.btn-view-spp', function() {
            var id = $(this).attr('data-id');
            var nama = $(this).attr('data-nama');
            var nis = $(this).attr('data-nis');

            $('.nama_santri').html(nama);
            $('#form-add-spp [name="santri_id"]').val(id);

            $.ajax({
                type: "GET",
                url: "<?= site_url('SPP/GetSPPBySantri/') ?>" + id,
                dataType: "JSON",
                success: function(data) {
                    var html_spp = '';
                    var cetak = '';
                    const bulan = ['januari', 'februari', 'maret', 'april', 'mei', 'juni', 'juli', 'agustus', 'september', 'oktober', 'november', 'desember'];
                    for (let o = 0; o < bulan.length; o++) {
                        var _status = '<span class="badge badge-danger">Belum Lunas</span>' +
                            '<a href="' + base_url + 'spp/bayar?santri_id=' + id + '&bulan=' + bulan[o] + '" class="badge badge-success ml-1"><i class="ri-exchange-funds-line"></i> Bayar</a>';

                        html_spp += '<tr>' +
                            '<td>' + capitalizeFirstLetter(bulan[o]) + '</td>';

                        $.each(data, function(i, val) {
                            // console.log(val.status_code);
                            if (val.bulan === bulan[o]) {
                                if (val.status_code == 200) {
                                    _status = '<span class="badge badge-primary">Lunas</span>';
                                } else {
                                    _status = '<span class="badge badge-warning">Sedang Diproses</span>';
                                }
                            }

                            cetak = '<a href="' + base_url + 'SPP/CetakSPP/' + val.id + '" target="_blank"><i class="ri-printer-line"></i></a>';
                        });

                        html_spp += '<td>' + _status + '</td><td>' +
                            cetak + '</td></tr>';

                        $('.nominal').simpleMoneyFormat();
                    }

                    $('#table-body-spp').html(html_spp);
                    $('#modal-view-spp').modal('show');
                    console.log(data);
                }
            });

            // $('#form-add-balance [name="saldo"]').simpleMoneyFormat();
        });

    });
</script>
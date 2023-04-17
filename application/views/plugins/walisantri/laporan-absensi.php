<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/v/bs5/jszip-2.5.0/dt-1.11.5/af-2.3.7/b-2.2.2/b-colvis-2.2.2/b-html5-2.2.2/b-print-2.2.2/fc-4.0.2/sl-1.3.4/datatables.min.js"></script>

<script>
    var table;
    $(document).ready(function() {
        $('.card-hide').hide();

        GetSantri();
        // GetMapel();
        // GetKelas();
        // GetUstadz();

        table = $('#table-kehadiran').DataTable({
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
                "url": "<?= base_url('laporan-ws-absensi/all') ?>",
                "type": "POST",
                "data": function(data) {
                    data.id_santri = $('[name="santri_id"]').val();
                    data.id_mapel = $('[name="mapel_id"]').val();
                },
                "dataSrc": function(json) {
                    $('.jumlah-hadir').html(json.total.hadir);
                    $('.jumlah-izin').html(json.total.izin);
                    $('.jumlah-sakit').html(json.total.sakit);
                    $('.jumlah-tidak-hadir').html(json.total.tidak_hadir);
                    return json.data;
                }
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
                className: "status-filter",
                targets: [4],
            }],

        });

        function reload_table() {
            table.ajax.reload();
        }

        function GetSantri() {
            $.ajax({
                type: "GET",
                url: "<?= site_url('_WaliSantri/Santri/GetSantriByWali') ?>",
                dataType: "JSON",
                success: function(data) {
                    var html = '';
                    var html = '<option value="" readonly>Pilih Santri</option>';
                    $.each(data, function(i, val) {
                        html += '<option value="' + val.id_santri + '">' + val.nis + ' | ' + val.name + '</option>';
                    });

                    $('.select-santri').html(html).trigger('change');
                }
            });
        }

        $('.filter').on('change', function() {
            reload_table();
        })

    });
</script>
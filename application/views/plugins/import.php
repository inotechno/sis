<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/v/bs5/jszip-2.5.0/dt-1.11.5/af-2.3.7/b-2.2.2/b-colvis-2.2.2/b-html5-2.2.2/b-print-2.2.2/fc-4.0.2/sl-1.3.4/datatables.min.js"></script>

<script>
    $('#table-preview-santri').hide();
    $('#table-preview-wali-santri').hide();
    $('#table-preview-mapel').hide();
    $('#table-preview-ustadz').hide();
    $(document).ready(function() {
        $('#template-santri').change(function() {
            var data = new FormData($('#import-santri')[0]);
            $.ajax({
                type: 'POST',
                url: "<?= site_url('Import/preview_santri') ?>",
                data: data,
                dataType: 'HTML',
                contentType: false,
                cache: false,
                processData: false,
                success: function(result) {

                    $('#preview-santri').html(result);
                    $('#table-preview-santri').show();

                    // }
                }
            });
        });

        $('#import-santri').submit(function() {
            var data = new FormData(this);
            $.ajax({
                type: 'POST',
                url: "<?= site_url('Import/import_santri') ?>",
                data: data,
                dataType: 'JSON',
                contentType: false,
                cache: false,
                processData: false,
                beforeSend: function() {
                    $('#btn-upload-santri').prop('disabled', true);
                    $('#btn-upload-santri').html('Loading ...');
                },
                success: function(response) {
                    // console.log(response);
                    $('#import-santri')[0].reset();
                    notification(response.type, response.message);
                    $('#table-preview-santri').hide();

                    $('#btn-upload-santri').prop('disabled', false);
                    $('#btn-upload-santri').html('Upload');
                }
            });

            return false;
        });


        $('#template-wali-santri').change(function() {
            var data = new FormData($('#import-wali-santri')[0]);
            $.ajax({
                type: 'POST',
                url: "<?= site_url('Import/preview_wali_santri') ?>",
                data: data,
                dataType: 'HTML',
                contentType: false,
                cache: false,
                processData: false,

                success: function(result) {

                    $('#preview-wali-santri').html(result);
                    $('#table-preview-wali-santri').show();

                }
            });
        });

        $('#import-wali-santri').submit(function() {
            var data = new FormData(this);
            $.ajax({
                type: 'POST',
                url: "<?= site_url('Import/import_wali_santri') ?>",
                data: data,
                dataType: 'JSON',
                contentType: false,
                cache: false,
                processData: false,
                beforeSend: function() {
                    $('#btn-upload-wali-santri').prop('disabled', true);
                    $('#btn-upload-wali-santri').html('Loading ...');
                },
                success: function(response) {
                    // console.log(response);
                    $('#import-wali-santri')[0].reset();
                    notification(response.type, response.message);
                    $('#table-preview-wali-santri').hide();

                    $('#btn-upload-wali-santri').prop('disabled', false);
                    $('#btn-upload-wali-santri').html('Upload');
                }
            });

            return false;
        });


        $('#template-ustadz').change(function() {
            var data = new FormData($('#import-ustadz')[0]);
            $.ajax({
                type: 'POST',
                url: "<?= site_url('Import/preview_ustadz') ?>",
                data: data,
                dataType: 'HTML',
                contentType: false,
                cache: false,
                processData: false,
                success: function(result) {

                    $('#preview-ustadz').html(result);
                    $('#table-preview-ustadz').show();

                    // }
                }
            });
        });

        $('#import-ustadz').submit(function() {
            var data = new FormData(this);
            $.ajax({
                type: 'POST',
                url: "<?= site_url('Import/import_ustadz') ?>",
                data: data,
                dataType: 'JSON',
                contentType: false,
                cache: false,
                processData: false,
                beforeSend: function() {
                    $('#btn-upload-ustadz').prop('disabled', true);
                    $('#btn-upload-ustadz').html('Loading ...');
                },
                success: function(response) {
                    // console.log(response);
                    notification(response.type, response.message);
                    $('#import-ustadz')[0].reset();
                    $('#table-preview-ustadz').hide();

                    $('#btn-upload-ustadz').prop('disabled', false);
                    $('#btn-upload-ustadz').html('Upload');
                }
            });

            return false;
        });


        $('#template-mapel').change(function() {
            var data = new FormData($('#import-mapel')[0]);
            $.ajax({
                type: 'POST',
                url: "<?= site_url('Import/preview_mapel') ?>",
                data: data,
                dataType: 'HTML',
                contentType: false,
                cache: false,
                processData: false,
                success: function(result) {

                    $('#preview-mapel').html(result);
                    $('#table-preview-mapel').show();

                    // }
                }
            });
        });

        $('#import-mapel').submit(function() {
            var data = new FormData(this);
            $.ajax({
                type: 'POST',
                url: "<?= site_url('Import/import_mapel') ?>",
                data: data,
                dataType: 'JSON',
                contentType: false,
                cache: false,
                processData: false,
                beforeSend: function() {
                    $('#btn-upload-mapel').prop('disabled', true);
                    $('#btn-upload-mapel').html('Loading ...');
                },
                success: function(response) {
                    // console.log(response);
                    notification(response.type, response.message);
                    $('#import-mapel')[0].reset();
                    $('#table-preview-mapel').hide();

                    $('#btn-upload-mapel').prop('disabled', false);
                    $('#btn-upload-mapel').html('Upload');
                }
            });

            return false;
        });

    });
</script>
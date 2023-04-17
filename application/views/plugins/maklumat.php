<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/v/bs5/jszip-2.5.0/dt-1.11.5/af-2.3.7/b-2.2.2/b-colvis-2.2.2/b-html5-2.2.2/b-print-2.2.2/fc-4.0.2/sl-1.3.4/datatables.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.js"></script>

<script>
    $(document).ready(function() {
        getCategory();
        getRoles();

        $('.select-category').select2({
            tags: true,
            theme: 'bootstrap4',
        });

        $('#content').summernote({
            tabsize: 4,
            height: 300,
            toolbar: [
                ['style', ['style']],
                ['font', ['bold', 'underline', 'clear']],
                ['color', ['color']],
                ['para', ['ul', 'ol', 'paragraph']],
                ['table', ['table']],
                ['insert', ['link', 'picture', 'video']],
                ['view', ['codeview', 'help']]
            ],
            callbacks: {
                onImageUpload: function(image) {
                    uploadImage(image[0]);
                },
                onMediaDelete: function(target) {
                    deleteImage(target[0].src);
                }
            }
        });

        function uploadImage(image) {
            var data = new FormData();
            data.append("image", image);
            $.ajax({
                url: "<?= site_url('Maklumat/upload_image') ?>",
                cache: false,
                contentType: false,
                processData: false,
                data: data,
                type: "POST",
                success: function(url) {

                    $('#content').summernote("insertImage", url);
                    console.log(url);
                },
                error: function(data) {
                    console.log(data);
                }
            });
        }

        function deleteImage(src) {
            $.ajax({
                data: {
                    src: src
                },
                type: "POST",
                url: "<?php echo site_url('Maklumat/delete_image') ?>",
                cache: false,
                success: function(response) {
                    console.log(response);
                }
            });
        }

        table = $('#table-maklumat').DataTable({
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
                "url": "<?= base_url('maklumat/all') ?>",
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
                className: "align-middle",
                targets: "_all"
            }, {
                "targets": [0],
                "orderable": false,
                "className": ""
            }, {
                "width": "40%",
                "targets": 2
            }],
        });

        function reload_table() {
            table.ajax.reload();
        }

        function getCategory() {
            $.ajax({
                type: "GET",
                url: "<?= site_url('Maklumat/getCategory') ?>",
                dataType: "JSON",
                success: function(data) {
                    // console.log(data);
                    var html = '';
                    $.each(data, function(i, v) {
                        html += '<option value="' + v.slug + '">' + v.title + '</option>';
                    });

                    $('.select-category').html(html).trigger('change');
                }
            });
        }

        function getRoles() {
            $.ajax({
                type: "GET",
                url: "<?= site_url('Role/all') ?>",
                dataType: "JSON",
                success: function(data) {
                    // console.log(data);
                    var html = '';
                    $.each(data, function(i, v) {
                        html += '<option value="' + v.id + '">' + v.name + '</option>';
                    });

                    $('.select-tujuan').html(html).trigger('change');
                }
            });
        }

        $('#table-maklumat').on('click', '.btn-update', function() {
            var id = $(this).attr('data-id');
            $.ajax({
                type: "GET",
                url: "<?= site_url('Maklumat/GetMaklumatById/') ?>" + id,
                dataType: "JSON",
                success: function(response) {
                    $('#form-update-maklumat [name="id"]').val(response.id);
                    $('#form-update-maklumat [name="title"]').val(response.title);
                    $('#form-update-maklumat [name="category"]').val(response.category_slug).trigger('change');
                    $('#form-update-maklumat [name="tujuan"]').val(response.role_id).trigger('change');
                    $('#form-update-maklumat [name="content"]').summernote('pasteHTML', response.content);

                    $('#modal-update-maklumat').modal('show');
                    // console.log(response);
                }
            });
        });

        $('#table-maklumat').on('click', '.btn-delete', function() {
            var id = $(this).attr('data-id');
            $('#form-delete-maklumat [name="id"]').val(id);
            $('#modal-delete-maklumat').modal('show');
        });

        $('#table-maklumat').on('click', '.btn-post', function() {
            var id = $(this).attr('data-id');
            $('#form-post-maklumat [name="id"]').val(id);
            $('#modal-post-maklumat').modal('show');
        });

        $('#form-add-maklumat').submit(function() {
            var data = new FormData(this);

            $.ajax({
                type: "POST",
                url: "<?= site_url('Maklumat/add') ?>",
                data: data,
                dataType: "JSON",
                contentType: false,
                cache: false,
                processData: false,
                success: function(response) {

                    if (response.type != 'success') {
                        notification(response.type, response.message);
                    } else {
                        notification(response.type, response.message);

                        $('#modal-add-maklumat').modal('hide');
                        $('#form-add-maklumat')[0].reset();

                        reload_table();
                    }

                }
            });

            return false;

        });

        $('#form-update-maklumat').submit(function() {
            var data = new FormData(this);

            $.ajax({
                type: "POST",
                url: "<?= site_url('maklumat/update') ?>",
                data: data,
                dataType: "JSON",
                contentType: false,
                cache: false,
                processData: false,
                success: function(response) {

                    if (response.type != 'success') {
                        notification(response.type, response.message);
                    } else {
                        notification(response.type, response.message);

                        $('#modal-update-maklumat').modal('hide');
                        $('#form-update-maklumat')[0].reset();

                        reload_table();
                    }

                }
            });

            return false;

        });

        $('#form-delete-maklumat').submit(function() {
            var data = $(this).serialize();

            $.ajax({
                type: "POST",
                url: "<?= site_url('maklumat/delete') ?>",
                data: data,
                dataType: "JSON",
                success: function(response) {

                    if (response.type != 'success') {
                        notification(response.type, response.message);
                    } else {
                        notification(response.type, response.message);

                        $('#modal-delete-maklumat').modal('hide');
                        $('#form-delete-maklumat')[0].reset();

                        reload_table();
                    }

                }
            });

            return false;

        });

        $('#form-post-maklumat').submit(function() {
            var data = $(this).serialize();

            $.ajax({
                type: "POST",
                url: "<?= site_url('Maklumat/posting') ?>",
                data: data,
                dataType: "JSON",
                success: function(response) {

                    if (response.type != 'success') {
                        notification(response.type, response.message);
                    } else {
                        notification(response.type, response.message);

                        $('#modal-post-maklumat').modal('hide');
                        $('#form-post-maklumat')[0].reset();

                        reload_table();
                    }

                }
            });

            return false;

        });

        function decodeHTMLEntities(text) {
            return $("<textarea/>")
                .html(text)
                .text();
        }

        function stripHtml(html) {
            let tmp = document.createElement("div");
            tmp.innerHTML = html;
            return tmp.textContent || tmp.innerText || "";
        }

    });
</script>
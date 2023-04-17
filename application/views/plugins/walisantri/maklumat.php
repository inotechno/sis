<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/v/bs5/jszip-2.5.0/dt-1.11.5/af-2.3.7/b-2.2.2/b-colvis-2.2.2/b-html5-2.2.2/b-print-2.2.2/fc-4.0.2/sl-1.3.4/datatables.min.js"></script>

<script>
    $(document).ready(function() {
        getAll();

        function getAll() {
            $.ajax({
                type: "POST",
                url: "<?= site_url('_WaliSantri/Maklumat/all') ?>",
                dataType: "JSON",
                success: function(response) {
                    var html = '';
                    console.log(response);
                    if (response.length != 0) {
                        $.each(response, function(i, val) {
                            // console.log(image);
                            html += '<div class="card iq-mb-3">' +
                                '        <img src="' + base_url + 'assets/images/posts/' + val.thumbnail + '" class="card-img-top" style="width:100%;height:15vw;object-fit:cover;" alt="#">' +
                                '        <div class="card-body">' +
                                '            <a href="#" class="view-post" data-id="' + val.id + '"><h4 class="card-title">' + val.title + '</h4></a>' +
                                '            <p class="card-text">' + stripHtml(decodeHTMLEntities(val.content)).substr(0, 100) + ' ... <a href="#" class="view-post" data-id="' + val.id + '">Baca Lebih Lanjut</a></p>' +
                                '           <div class="row">' +
                                '               <div class="col-md-6">' +
                                '                   <span class="badge badge-primary">' + val.category_name + '</span>' +
                                '               </div>' +
                                '               <div class="col-md">' +
                                '                   <span class="badge badge-danger">' + val.user_name + '</span>' +
                                '                   <span class="badge badge-success ml-1">' + val.created_at + '</span>' +
                                '               </div>' +
                                '           </div>' +
                                '        </div>' +
                                '    </div>';
                        });
                    }

                    $('#maklumat-list').html(html);
                }
            });
        }

        function getAnggota(nis) {
            $.ajax({
                type: "GET",
                url: "<?= site_url('Rombel/GetSantriHaveNotRombel') ?>",
                dataType: "JSON",
                data: {
                    nis: nis
                },
                success: function(data) {
                    var html = '';
                    $.each(data, function(i, val) {
                        html += '<tr>' +
                            '           <td>' + val.nama_santri + '</td>' +
                            '           <td>' + val.nis + '</td>' +
                            '           <td>' +
                            '               <div class="custom-control custom-checkbox">' +
                            '               <input type="checkbox" name="santri_id[]" class="custom-control-input" value="' + val.id_santri + '" id="' + val.nis + '">' +
                            '               <label class="custom-control-label" for="' + val.nis + '"></label>' +
                            '               </div>' +
                            '           </td>' +
                            '<tr>';
                    });

                    $('#table-body-add-anggota').html(html);
                    // console.log(html);
                    $('#modal-add-anggota').modal('show');
                    // console.log(response);
                }
            });
        }

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

        $('#maklumat-list').on('click', '.view-post', function() {
            var id = $(this).attr('data-id');
            $.ajax({
                type: "GET",
                url: "<?= site_url('_WaliSantri/Maklumat/GetMaklumatById/') ?>" + id,
                dataType: "JSON",
                success: function(response) {
                    $('#body-post').html(decodeHTMLEntities(response.content));
                    $('#modal-view').modal('show');
                }
            });
        })

    });
</script>
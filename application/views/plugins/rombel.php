<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/v/bs5/jszip-2.5.0/dt-1.11.5/af-2.3.7/b-2.2.2/b-colvis-2.2.2/b-html5-2.2.2/b-print-2.2.2/fc-4.0.2/sl-1.3.4/datatables.min.js"></script>

<script>
    $(document).ready(function() {
        getAll();

        function getAll() {
            $.ajax({
                type: "POST",
                url: "<?= site_url('rombel/all') ?>",
                dataType: "JSON",
                success: function(response) {
                    var rombel = '';
                    // console.log(response);
                    var select = '';

                    if (response.length != 0) {
                        $.each(response, function(i, val) {
                            select += '<option value="' + val.id + '">' + val.nama_kelas + '</option>';
                            var jumlah = 0;
                            var anggota = '';
                            // console.log(val.nama_kelas);
                            $.each(val.anggota, function(a, s) {
                                // console.log(s);
                                anggota += '<li class="d-flex mb-4 align-items-center" > ' +
                                    '         <div class="user-img img-fluid"><img src="' + base_url + '/assets/images/user/01.jpg" alt="story-img" class="rounded-circle avatar-40"></div>' +
                                    '             <div class="media-support-info ml-3">' +
                                    '                 <h6>' + s.nama_santri + '</h6>' +
                                    '                 <p class="mb-0">' + s.nis + '</p>' +
                                    '             </div>' +
                                    '             <div class="iq-card-header-toolbar d-flex align-items-center">' +
                                    '                 <div class="dropdown">' +
                                    '                     <span class="dropdown-toggle text-primary" id="dropdownMenuButton40" data-toggle="dropdown">' +
                                    '                         <i class="ri-more-2-line"></i>' +
                                    '                     </span>' +
                                    '                     <div class="dropdown-menu dropdown-menu-right" style="">' +
                                    '                         <a class="dropdown-item btn-keluar" href="#" data-id="' + s.id_santri + '" data-nama="' + s.nama_santri + '">Keluarkan</a>' +
                                    '                         <a class="dropdown-item btn-pindah" href="#" data-id="' + s.id_santri + '" data-nama="' + s.nama_santri + '">Pindahkan</a>' +
                                    '                     </div>' +
                                    '                 </div>' +
                                    '             </div>' +
                                    '         </li>';
                                jumlah++

                            });

                            rombel += '<div class="card">' +
                                '        <div class="card-body">' +
                                '            <div class="user-post-data p-1 mb-1" style="cursor: pointer;" data-toggle="collapse" href="#' + val.slug + '" role="button" aria-expanded="false" aria-controls="' + val.slug + '">' +
                                '                <div class="d-flex flex-wrap">' +
                                '                    <div class="media-support-info">' +
                                '                        <h5 class="mb-0"><a href="#" class="">' + val.nama_kelas + '</a></h5>' +
                                '                        <p class="mb-0 text-primary">' + val.wali_kelas + '</p>' +
                                '                    </div>' +
                                '                   <div class="iq-card-header-toolbar d-flex align-items-center">' +
                                '                       <a href="#" class="text-secondary">' + jumlah + ' Anggota</a>' +
                                '                   </div>' +
                                '                </div>' +
                                '            </div>' +
                                '            <div class="iq-todo-right collapse" id="' + val.slug + '">' +
                                '                <div class="iq-todo-friendlist mt-3">' +
                                '                    <ul class="suggestions-lists m-0 p-0">' + anggota + '</ul>' +
                                '                    <a href="#" class="btn btn-primary d-block btn-add-anggota" data-id="' + val.id + '" data-nama="' + val.nama_kelas + '"><i class="ri-add-line"></i> Tambah Anggota</a>' +
                                '                </div>' +
                                '            </div>' +
                                '        </div>' +
                                '    </div>';
                        });
                    }

                    $('#rombel-list').html(rombel);
                    $('.select-kelas').html(select);
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

        $('#rombel-list').on('click', '.btn-add-anggota', function() {
            var id = $(this).attr('data-id');
            var nama = $(this).attr('data-nama');


            $('[name="kelas_id"]').val(id);
            $('.nama_kelas').html(nama);
            getAnggota();
        });

        $('#rombel-list').on('click', '.btn-pindah', function() {
            var id = $(this).attr('data-id');
            var nama = $(this).attr('data-nama');

            $('#form-pindah-anggota [name="santri_id"]').val(id);
            $('#form-pindah-anggota [name="nama_santri"]').val(nama);
            $('#modal-pindah-anggota').modal('show');
        });

        $('#rombel-list').on('click', '.btn-keluar', function() {
            var id = $(this).attr('data-id');
            var nama = $(this).attr('data-nama');

            $('#form-keluar-anggota [name="santri_id"]').val(id);
            $('.nama_santri').html(nama);
            $('#modal-keluar-anggota').modal('show');
        });

        $('#search-anggota').keyup(function(e) {
            getAnggota($(this).val());
        });

        $('#form-add-anggota').submit(function() {
            var data = $(this).serialize();
            $.ajax({
                type: "POST",
                url: "<?= site_url('Rombel/addAnggota') ?>",
                data: data,
                dataType: "JSON",
                success: function(response) {
                    // console.log(response);
                    notification(response.type, response.message);
                    getAll();
                    $('#form-add-anggota')[0].reset();
                    $('#modal-add-anggota').modal('hide');
                }
            });

            return false;
        });

        $('#form-pindah-anggota').submit(function() {
            var data = $(this).serialize();
            $.ajax({
                type: "POST",
                url: "<?= site_url('Rombel/transferAnggota') ?>",
                data: data,
                dataType: "JSON",
                success: function(response) {
                    // console.log(response);
                    notification(response.type, response.message);
                    getAll();
                    $('#form-pindah-anggota')[0].reset();
                    $('#modal-pindah-anggota').modal('hide');
                }
            });

            return false;
        });

        $('#form-keluar-anggota').submit(function() {
            var data = $(this).serialize();
            $.ajax({
                type: "POST",
                url: "<?= site_url('Rombel/delete') ?>",
                data: data,
                dataType: "JSON",
                success: function(response) {
                    // console.log(response);
                    notification(response.type, response.message);
                    getAll();
                    $('#form-keluar-anggota')[0].reset();
                    $('#modal-keluar-anggota').modal('hide');
                }
            });

            return false;
        });

    });
</script>
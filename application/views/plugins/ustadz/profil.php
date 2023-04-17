<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/v/bs5/jszip-2.5.0/dt-1.11.5/af-2.3.7/b-2.2.2/b-colvis-2.2.2/b-html5-2.2.2/b-print-2.2.2/fc-4.0.2/sl-1.3.4/datatables.min.js"></script>

<script>
    $(document).ready(function() {
        GetProfil();

        function GetProfil() {
            $.ajax({
                type: "POST",
                url: base_url + '_Ustadz/Profil/GetProfil',
                dataType: "JSON",
                success: function(response) {
                    $('[name="name"]').val(response.name);
                    $('[name="nik"]').val(response.nik);
                    $('[name="nip"]').val(response.nip);
                    $('[name="jenis_kelamin"]').val(response.jenis_kelamin);
                    $('[name="tempat_lahir"]').val(response.tempat_lahir);
                    $('[name="tanggal_lahir"]').val(response.tanggal_lahir);
                    $('[name="phone"]').val(response.phone);
                    $('[name="email"]').val(response.email);
                    $('[name="id"]').val(response.id);

                    if (response.images != null) {
                        $('#previewImg').attr('src', base_url + 'assets/images/user/' + response.images);
                    }
                    console.log(response);
                }
            });
        }

        $('#form-update-profil').submit(function() {
            var data = new FormData(this);
            $.ajax({
                type: "POST",
                url: base_url + '_Ustadz/Profil/UpdateProfil',
                data: data,
                dataType: "JSON",
                contentType: false,
                cache: false,
                processData: false,
                success: function(response) {
                    notification(response.type, response.message);
                    GetProfil();
                }
            });

            return false;
        })
    });
</script>
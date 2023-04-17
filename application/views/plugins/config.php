<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.js"></script>
<script>
    $(document).ready(function() {
        $('.text-editor').summernote({
            tabsize: 2,
            height: 300
        });

        $('[name="LOGO_FULL"]').on("change", function() {
            ! function(e) {
                if (e.files && e.files[0]) {
                    var t = new FileReader;
                    t.onload = function(e) {
                        $('#preview-logo-full').attr("src", e.target.result)
                    }, t.readAsDataURL(e.files[0])
                }
            }(this)
        }), $('.upload-logo-full').on("click", function() {
            $('[name="LOGO_FULL"]').click();
        });

        $('[name="LOGO_MINI"]').on("change", function() {
            ! function(e) {
                if (e.files && e.files[0]) {
                    var t = new FileReader;
                    t.onload = function(e) {
                        $('#preview-logo-mini').attr("src", e.target.result)
                    }, t.readAsDataURL(e.files[0])
                }
            }(this)
        }), $('.upload-logo-mini').on("click", function() {
            $('[name="LOGO_MINI"]').click();
        })

        $('#form-config').submit(function() {
            var data = new FormData(this);

            $.ajax({
                type: "POST",
                url: "<?= site_url('config/update') ?>",
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
                        window.location.reload();
                    }

                }
            });

            return false;

        });

    });
</script>
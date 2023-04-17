<style>
    .image-upload>input {
        display: none;
    }

    .image-upload>label {
        cursor: pointer;
        border: 1px solid black;
    }
</style>
<script>
    function previewImage(input) {
        // console.log(input);
        var id = $(input).attr('id');

        var img = $('#' + id).parent().find('img');
        // console.log(id);
        var file = $('#' + id).get(0).files[0];

        if (file) {
            var reader = new FileReader();

            reader.onload = function() {
                $(img).attr("src", reader.result);
            }

            reader.readAsDataURL(file);
        }
    }
</script>
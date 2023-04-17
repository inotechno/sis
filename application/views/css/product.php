<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/instantsearch.css@7.3.1/themes/reset-min.css" integrity="sha256-t2ATOGCtAIZNnzER679jwcFcKYfLlw01gli6F6oszk8=" crossorigin="anonymous">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/instantsearch.css@7.3.1/themes/algolia-min.css" integrity="sha256-HB49n/BZjuqiCtQQf49OdZn63XuKFaxcIHWf0HNKte8=" crossorigin="anonymous">
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
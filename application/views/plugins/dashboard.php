<script>
    $(document).ready(function() {
        GetTotal();

        function GetTotal() {
            $.ajax({
                type: "GET",
                url: "<?= site_url('Dashboard/GetTotal') ?>",
                dataType: "JSON",
                success: function(data) {
                    console.log(data);
                    $.each(data, function(i, val) {
                        $('.count_' + i).html(val);
                    });
                }
            });
        }
    });
</script>
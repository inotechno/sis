<script>
    $(document).ready(function() {

        $('#btn-filter').on('click', function(){
            var start = $('[name="start_date"]').val();
            var end = $('[name="end_date"]').val();

            $.ajax({
                type: "POST",
                url: base_url+'Laporan/GetAllTransaction',
                data: {start:start, end:end},
                dataType: "JSON",
                success: function (data) {
                    var html = '';
                    var jenis = '';
                    var no = 1;
                    $.each(data, function (i, v) { 
                        if(v.wali_id != null){
                            jenis = 'Transaksi Wali Santri';
                        }else{
                            jenis = 'Transaksi Santri';
                        }
                         html += '<tr>'+
                                    '<td>'+ no++ +'</td>'+
                                    '<td>'+ v.order_id +'</td>'+
                                    '<td>'+ v.name +'</td>'+
                                    '<td>'+ v.wali_santri +'</td>'+
                                    '<td>'+ v.gross_amount +'</td>'+
                                    '<td>'+ v.bank +'</td>'+
                                    '<td>'+ v.bank_account +'</td>'+
                                    '<td>'+ v.status_paid +'</td>'+
                                    '<td>'+ v.created_at +'</td>'+
                                    '<td>'+ jenis +'</td>'+
                                '</tr>';
                    });

                    $('#table-body-report').html(html);
                }
            });

            return false;
        });
        
    });
</script>
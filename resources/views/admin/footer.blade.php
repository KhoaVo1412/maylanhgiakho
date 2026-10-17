<!-- jQuery -->
<script src="/template/admin/plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="/template/admin/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="/template/admin/dist/js/adminlte.min.js"></script>
{{-- chart --}}
<script src="//cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.min.js"></script>

<script src="/template/admin/js/main.js"></script>

<script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>
<script type="text/javascript">
	$(document).ready(function(){
        chart30daysorder();
        chartsp();
        tonkho();
        trangthai();
        var chart=new Morris.Area({
        element: 'chart',
        lineColors: ['#819C79','#FF6541'],
        // pointFillColors: ['#ffffff'],
        // pointStrokeColors: ['black'],
        // fillOpacity: 0.6,
        parseTime: false,
        hideHover: 'auto',
        xkey: 'thoigian',
        ykeys: ['tongtien'],
        // behaveLikeLine: true,
        labels: ['Tổng Tiền']
        });

        var chartsp=new Morris.Line({
        element: 'chart-sp',
        lineColors: ['#979b9c'],
        // pointFillColors: ['#ffffff'],
        // pointStrokeColors: ['black'],
        // fillOpacity: 0.6,
        parseTime: false,
        hideHover: 'auto',
        xkey: 'product_id',
        ykeys: ['sumsl'],
        // behaveLikeLine: true,
        labels: ['Số Lượng Đã Bán']
        });


        var tonkho=new Morris.Area({
        element: 'tonkho',
        lineColors: ['#34c6eb','#FF6541','#0330fc'],
        parseTime: false,
        hideHover: 'auto',
        xkey: 'name',
        ykeys: ['SL','size','mau'],
        //behaveLikeLine: true,
        labels: ['SL','Size','Màu']
        });



        var trangthai=new Morris.Bar({
        element: 'trangthai',
        lineColors: ['#819C79','#FF6541'],
        // pointFillColors: ['#ffffff'],
        // pointStrokeColors: ['black'],
        // fillOpacity: 0.6,
        parseTime: false,
        hideHover: 'auto',
        xkey: 'tentt',
        ykeys: ['sl'],
        // behaveLikeLine: true,
        labels: ['SL']
        });





        function chart30daysorder(){
            var _token=$('input[name="_token"]').val();
            $.ajax({
            url:" {{url('/days-order')}}", 
            method: "POST",
            dataType: "JSON",
            data: {_token:_token},
            success:function(data)
            {
             chart.setData(data);
            }
            });
        }


        function chartsp(){
            var _token=$('input[name="_token"]').val();
            $.ajax({
            url:" {{url('/chart-sp')}}", 
            method: "POST",
            dataType: "JSON",
            data: {_token:_token},
            success:function(data)
            {
                chartsp.setData(data);
            }
            });
        }


        function tonkho(){
            var _token=$('input[name="_token"]').val();
            $.ajax({
            url:" {{url('/tonkho')}}", 
            method: "POST",
            dataType: "JSON",
            data: {_token:_token},
            success:function(data)
            {
                tonkho.setData(data);
            }
            });
        }

        function trangthai(){
            var _token=$('input[name="_token"]').val();
            $.ajax({
            url:" {{url('/trangthai')}}", 
            method: "POST",
            dataType: "JSON",
            data: {_token:_token},
            success:function(data)
            {
                trangthai.setData(data);
            }
            });
        }


        $('.dashboard-filter').change(function(){
        var dashboard_value = $(this).val();
        var _token = $('input[name="_token"]').val();
        $.ajax({
            url:"{{url('/dashboard-filter')}}", 
            method: "POST",
            dataType: "JSON",
            data: {dashboard_value:dashboard_value,_token:_token},
            success:function(data)
            {
            chart.setData(data);
            }
             });
        });





        $('#btn-dashboard-filter').click(function(){
            var _token= $('input[name="_token"]').val();
            var from_date= $('#datepicker').val();
            var to_date=$('#datepicker2').val();
            $.ajax({
            url:"{{url('/filterbydate')}}",
            method: "POST",
            dataType:"JSON",
            data: {from_date:from_date, to_date:to_date,_token:_token},
            success:function(data)
            {
            chart.setData(data);
            }
        });
    });
});
</script>

<script type="text/javascript"> 
    $(document).ready(function(){
    var colorDanger = "#FF1744";
        Morris.Donut({
        element: 'donut',
        resize: true,
        colors: [
            '#E0F7FA',
            '#B2EBF2',
            '#40c758',
            '#eb2cf5',
            '#26C6DA',
            '#00BCD4',
            '#00ACC1',
            '#0097A7',
            '#00838F',
            '#006064'
        ],
        
        data: [
            {label:"Sản Phẩm", value: {{$spss}} , color:colorDanger},
            {label:"Đơn Hàng", value: {{$hds}} },
            {label:"Đơn Hàng Vãn Lai", value: {{$hdvls}} },
            {label:"Khách Hàng", value: {{$users}}}
        ]
        });
    });
</script>

<script>
    $( function() {
        

      $( "#datepicker" ).datepicker({
            prevText:"Tháng trước",
            nextText:"Tháng sau",
            dateFormat: "yy-mm-dd",
            dayNamesMin: [ "Thứ 2", "Thứ 3", "Thứ 4", "Thứ 5", "Thứ 6", "Thứ 7", "Chủ nhật" ],
            duration: "slow"
        } );

        $( "#datepicker2" ).datepicker({
                prevText:"Tháng trước",
                nextText:"Tháng sau",
                dateFormat: "yy-mm-dd",
                dayNamesMin: [ "Thứ 2", "Thứ 3", "Thứ 4", "Thứ 5", "Thứ 6", "Thứ 7", "Chủ nhật" ],
                duration: "slow"
        } );
    } );
</script>

@yield('footer')
@extends('admin.main')

@section('content')
  <div class="row">
    <form autocomplete="off" style="width:100%;display: inline-flex">
      @csrf
      <div class="col-md-2">
        <p>Từ Ngày: <input type="text" id="datepicker" class="form-control"></p>
        <input type="button" id="btn-dashboard-filter" class="btn btn-primary btn-sm " value="Lọc Kết Quả">
      </div>

      <div class="col-md-2">
        <p>Đến Ngày: <input type="text" id="datepicker2" class="form-control"></p>
      </div>

      <div class="col-md-2">
        <p>Lọc theo: 
          <select class="dashboard-filter form-control">
            <option>--Chọn--</option>
            <option value="7ngay">7 Ngày qua</option>
            <option value="thangtruoc">Tháng trước</option>
            <option value="thangnay">Tháng này</option>
            <option value="365ngayqua">365 ngày qua</option>
          </select>
        </p>
      </div>
    </form>
    <div class="col-md-12" id="chart" style="height: 250px;"></div>
    <div style="width: 610px"><b style="float: right">Biểu đồ thống kê doanh thu từng ngày</b></div>
    <div class="col-md-12" id="chart-sp" style="height: 250px;"></div>
    <div style="width: 610px; margin-bottom: 50px"><b style="float: right">Biểu đồ thống kê sản phẩm bán chạy nhất</b></div>

    <div class="col-md-12" id="tonkho" style="height: 250px;"></div>
    <div style="width: 610px; margin-bottom: 50px"><b style="float: right">Biểu đồ thống kê số lượng sản phẩm tồn kho</b></div>

    <div class="col-md-12" id="trangthai" style="height: 250px;"></div>
    <div style="width: 610px; margin-bottom: 50px"><b style="float: right">Biểu đồ thống kê trạng thái hóa đơn</b></div>

  </div>
  <div class="row">
    <div class="col-md-4 col-xs-12">
      <b class="title_thongke">Thống kê tổng sản phẩm đơn hàng</b>
      <div class="morris-donus-inverse" id="donut"></div>

    </div>

    <div class="col-md-4 col-xs-12">
      <b class="title_thongke">Thống kê 10 sản phẩm được xem nhiều nhất</b>
     <ol class="list-view">
      @foreach ($sp_view as $key=>$sp)
        <li>
          <span>
            {{ $sp->name }} có:
            <span style="color: #332cf5">{{ $sp->view }} lượt xem.</span>
          </span>
        </li>
      @endforeach
     </ol>

    </div>
  </div>
  
  
  

@endsection
@extends('admin.main')

@section('content')

<div class="row w3-res-tb" style="padding: 5px 0 5px 0px;">
    <div class="col-sm-3">
      <form action="tim-kiem-discount" method="POST">
          {{ csrf_field() }}
          <div class="input-group" style="display: flex;">
          <input type="text" name="keywords_submit" class="input-sm form-control" placeholder="Enter Discount">
          <input type="submit" name="search_items" style="color:#ffffff;margin-top: 0; background: #1d1f20"class="btn btn-primary btn-sm" value="Tìm kiếm"/>
          </div>
      </form>
    </div>
    <a class="btn btn-primary btn-sm" href="/admin/giamgia/add" style="width:37px; height:37px; background:#1d1f20">
        <span class="icon" title="Thêm" style="font-size: 19px"><i class="fas fa-plus"></i></span>
    </a>
</div>
    <table class="table">
        <thead>
            <tr>
                <th style="width: 50px">ID</th>
                <th>Tên giảm giá</th>
                <th>Mã giảm giá</th>
                <th>Số lượng</th>
                <th>Tính năng</th>
                <th>Số tiền hoặc %</th>
                <th>Trạng thái</th>
                <th style="width: 50px">&nbsp;</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($sizes as $key =>$size)
                <tr>
                    <td>{{$size->id}}</td>
                    <td>{{$size->tengg}}</td>                    
                    <td>{{$size->magg}}</td>
                    <td>{{$size->slgg}}</td>
                    @if($size->tngg==1)
                    <td>Reduce by Percent (%)</td>
                    @else
                    <td>Reduce by Percent (%)</td>
                    @endif

                    @if($size->tngg==1)
                    <td>{{ $size->sotiengg}} %</td>
                    @else
                    <td>{{ number_format($size->sotiengg)}} VND</td>
                    @endif
                    <td>{!! \App\Helpers\Helper::active($size->active) !!}</td>
                    <td style="text-align: center;display: flex;">
                        <a class="btn btn-primary btn-sm" href="/admin/giamgia/edit/{{$size->id}}" style="width:30px; margin: 0 2px 0 2px;">
                            <span class="icon" title="Sửa"><i class="fas fa-edit"></i></span>
                        </a>
                        <a class="btn btn-danger btn-sm" href="#" 
                            onclick="removeRow({{$size->id}}, '/admin/giamgia/destroy')" style="width:30px">
                            <span class="icon" title="Xóa"><i class="fas fa-trash"></i></span>
                        </a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    {!! $sizes->links() !!}
@endsection
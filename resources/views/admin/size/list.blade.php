@extends('admin.main')

@section('content')
<div class="row w3-res-tb" style="padding: 5px 0 5px 0px;">
    <div class="col-sm-3">
    <form action="tim-kiem-size" method="POST">
        {{ csrf_field() }}
        <div class="input-group" style="display: flex;">
        <input type="text" name="keywords_submit" class="input-sm form-control" placeholder="Nhập Mã Lực">
        <input type="submit" name="search_items" style="color:#ffffff;margin-top: 0; background: #1d1f20"class="btn btn-primary btn-sm" value="Tìm kiếm"/>
        </div>
    </form>
    </div>
    <a class="btn btn-primary btn-sm" href="/admin/size/add" style="width:37px; height:37px; background:#1d1f20">
        <span class="icon" title="Thêm" style="font-size: 19px"><i class="fas fa-plus"></i></span>
    </a>
</div>
    <table class="table">
        <thead>
            <tr>
                <th style="width: 50px">ID</th>
                <th>Mã Lực(HP)</th>
                <th>Trạng thái</th>
                <th style="width: 50px">&nbsp;</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($sizes as $key =>$size)
                
            
                <tr>
                    <td>{{$size->id}}</td>
                    <td>{{$size->tensize}}</td>                    
                    <td>{!! \App\Helpers\Helper::active($size->active) !!}</td>
                    <td style="text-align: center;display: flex;">
                        <a class="btn btn-primary btn-sm" href="/admin/size/edit/{{$size->id}}" style="width:30px; margin: 0 2px 0 2px;">
                            <span class="icon" title="Sửa"><i class="fas fa-edit"></i></span>
                        </a>
                        <a class="btn btn-danger btn-sm" href="#" 
                            onclick="removeRow({{$size->id}}, '/admin/size/destroy')" style="width:30px">
                            <span class="icon" title="Xóa"><i class="fas fa-trash"></i></span>
                        </a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    {!! $sizes->links() !!}
@endsection
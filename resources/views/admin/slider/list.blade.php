@extends('admin.main')

@section('content')
<div class="row w3-res-tb" style="padding: 5px 0 5px 0px;">
    <div class="col-sm-3">
    <form action="tim-kiem-slider" method="POST">
        {{ csrf_field() }}
        <div class="input-group" style="display: flex;">
        <input type="text" name="keywords_submit" class="input-sm form-control" placeholder="Nhập tên Slider">
        <input type="submit" name="search_items" style="color:#ffffff;margin-top: 0; background: #1d1f20"class="btn btn-primary btn-sm" value="Tìm kiếm"/>
        </div>
    </form>
    </div>
    <a class="btn btn-primary btn-sm" href="/admin/sliders/add" style="width:37px; height:37px; background:#1d1f20">
        <span class="icon" title="Thêm" style="font-size: 19px"><i class="fas fa-plus"></i>
    </a>
</div>
    <table class="table">
        <thead>
            <tr>
                <th style="width: 50px">ID</th>
                <th>Tiêu đề</th>
                <th style="width:200px">Url</th>
                <th>Hình ảnh</th>
                <th>Trạng thái</th>
                <th>Thời gian</th>
                <th style="width: 50px">&nbsp;</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($sliders as $key =>$slider)
                
            
                <tr>
                    <td>{{$slider->id}}</td>
                    <td>{{$slider->name}}</td>
                    <td style="width:200px">{{$slider->url}}</td>
                    <td>
                        <a href="{{$slider->thumb}}" target="_blank">
                            <img src="{{$slider->thumb}}" alt="Err" width="50px">
                        </a>
                    </td>
                    <td>{!! \App\Helpers\Helper::active($slider->active) !!}</td>
                    <td>
                        <?php
                        $thoigian=$slider->updated_at;
                        echo date('H:m:s d/m/Y', strtotime($thoigian));
                        ?>

                    </td>

                    <td style="text-align: center; display:flex">
                        <a class="btn btn-primary btn-sm" href="/admin/sliders/edit/{{$slider->id}}" style="width:30px;margin: 0 2px 0 2px;">
                            <span class="icon" title="Sửa"><i class="fas fa-edit"></i>
                        </a>
                        <a class="btn btn-danger btn-sm" href="#" 
                            onclick="removeRow({{$slider->id}}, '/admin/sliders/destroy')" style="width:30px">
                            <span class="icon" title="Xóa"><i class="fas fa-trash"></i>
                        </a>
                    </td>
                    <td>&nbsp;</td>
                </tr>
            @endforeach
        </tbody>
    </table>
    {!! $sliders->links() !!}
@endsection
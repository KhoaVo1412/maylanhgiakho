@extends('admin.main')

@section('content')
<div class="row w3-res-tb" style="padding: 5px 0 5px 0;">
    <div class="col-sm-3">
        <form action="tim-kiem-product" method="POST">
            {{ csrf_field() }}
            <div class="input-group" style="display: flex;">
                <input type="text" name="keywords_submit" class="input-sm form-control" placeholder="Nhập tên sản phẩm">
                <input type="submit" name="search_items" style="color:#ffffff;margin-top: 0; background: #1d1f20" class="btn btn-primary btn-sm" value="Tìm kiếm" />
            </div>
        </form>
    </div>
    <a class="btn btn-primary btn-sm" href="/admin/productts/add" style="width:37px;height: 37px; background:#1d1f20">
        <span class="icon" title="Thêm" style="font-size: 19px"><i class="fas fa-plus"></i></span>
    </a>
</div>
<table class="table">
    <thead>
        <tr>

            <th style="width: 50px">ID</th>
            <th>Tên sản phẩm</th>
            <th>Hình sản phẩm</th>
            <th>Loại sản phẩm</th>
            <th>Giá</th>
            <th>Giá giảm</th>
            <th>Trạng thái</th>
            <th>Thời gian</th>
            <th style="width: 50px">&nbsp;</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($productts as $key =>$productt)
        <tr>

            <td>{{$productt->id}}</td>
            <td> <img src="{{$productt->thumb}}" width="100px" alt="{{$productt->name}}"></td>
            <td>{{$productt->name}}</td>
            <td>{{$productt->menu->name}}</td>
            {{-- <td>{{$productt->SL}}</td> --}}
            <td>{{$productt->price}}</td>
            <td>{{$productt->price_sale}}</td>
            <td>{!! \App\Helpers\Helper::active($productt->active) !!}</td>
            {{-- <td>{{$productt->updated_at}}</td> --}}
            <td>
                <?php
                $thoigian = $productt->updated_at;
                echo date('H:m:s d/m/Y', strtotime($thoigian));
                ?>

            </td>

            <td style="text-align: center; display:flex">
                <a class="btn btn-primary btn-sm" href="/admin/productts/edit/{{$productt->id}}" style="width:30px; margin:0 2px 0 2px;">
                    <span class="icon" title="Sửa"><i class="fas fa-edit"></i></span>
                </a>
                <form action="{{ route('products.destroy', $productt->id) }}" method="POST" style="display: inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger btn-sm" style="width:30px; border:none; background:red;">
                        <span class="icon" title="Xóa"><i class="fas fa-trash"></i></span>
                    </button>
                </form>
            </td>
            <td>&nbsp;</td>
        </tr>
        @endforeach
    </tbody>
</table>
<div class="card-footer clear-fix">
    {!! $productts->links() !!}
</div>

@endsection
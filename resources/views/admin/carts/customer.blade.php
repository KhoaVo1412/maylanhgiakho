@extends('admin.main')

@section('content')
<div class="row w3-res-tb">
    <div class="col-sm-3">
    <form action="tim-kiem-uservl" method="POST">
        {{ csrf_field() }}
        <div class="input-group" style="display: flex; padding: 5px 0 5px 0;">
        <input type="text" name="keywords_submit" class="input-sm form-control" placeholder="Enter Name">
        <input type="submit" name="search_items" style="color:#ffffff;margin-top: 0; background: #1d1f20"class="btn btn-primary btn-sm" value="Tìm kiếm"/>
        </div>
    </form>
    </div>
</div>
    <table class="table">
        <thead>
            <tr>
                <th style="width: 50px">ID</th>
                <th>Tên</th>
                <th>SĐT</th>
                <th>Email</th>
                <th>Ngày đặt</th>
                {{-- <th>PT Thanh Toán</th>
                <th>Trạng Thái ĐH</th> --}}
                <th style="width: 50px">&nbsp;</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($customers as $key =>$customer)
                <tr>
                    <td>{{$customer->id}}</td>
                    <td>{{$customer->name}}</td>
                    <td>{{$customer->phone}}</td>
                    <td>{{$customer->email}}</td>
                    <td>
                        <?php
                        $thoigian=$customer->created_at;
                        echo date('H:m:s d/m/Y', strtotime($thoigian));
                        ?>

                    </td>
                    {{-- <td>{{$customer->pt_thanh_toan_id}}</td>
                    <td>{{$customer->ds_trang_thai_id}}</td> --}}
                    <td>&nbsp;</td>
                    <td style="text-align: center">
                        <a class="btn btn-primary btn-sm" href="/admin/customers/view/{{$customer->id}}" style="width:30px">
                            <span class="icon" title="View"><i class="fas fa-eye"></i></span>
                        </a>
                        <a class="btn btn-danger btn-sm" href="#" 
                            onclick="removeRow({{$customer->id}}, '/admin/customers/destroy')" style="width:30px">
                            <span class="icon" title="Delete"><i class="fas fa-trash"></i></span>
                        </a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <div class="card-footer clear-fix">
        {!! $customers->links() !!}
    </div>
    
@endsection
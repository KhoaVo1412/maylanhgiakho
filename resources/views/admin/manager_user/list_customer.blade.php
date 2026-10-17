@extends('admin.main')

@section('content')
<div class="row w3-res-tb">
    <div class="col-sm-3">
        @if(session()->has('message'))
    <div class="alert alert-success">
        {!!session()->get('message')!!}
    </div>
    @elseif(session()->has('error'))
    <div class="alert alert-danger">
        {!!session()->get('error')!!}
    </div>
    @endif
    <form action="/tim-kiem-user" method="POST">
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
                <th>Email</th>
                {{-- <th>PassWord</th> --}}
                <th  style="width: 125px">Số điện thoại</th>
                <th>Địa chỉ</th>
                <th style="width: 50px">&nbsp;</th>
                
            </tr>
        </thead>
        <tbody>
            @foreach ($Users as $key =>$User)
                <tr>
                    <td>{{$User->id}}</td>
                    <td>{{$User->name}}</td>
                    <td>{{$User->email}}</td>
                    {{-- <td>{{$User->password}}</td> --}}
                    <td>{{$User->phone}}</td>
                    <td>{{$User->address}}</td>
                    
                    <td><span class="text-ellipsis">
                        @if($User->TT==0)
                            <a href="{{URL::to('/unactive/'.$User->id)}}"> <span class="fa-thumb-styling fa fa-thumbs-down" style="color: red"></span> </a>
                        @else
                            <a href="{{URL::to('/active/'.$User->id)}}"> <span class="fa-thumb-styling fa fa-thumbs-up"></span>  </a>
                        @endif
                         </span>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <div class="card-footer clear-fix">
        {!! $Users->links() !!}
    </div>
    
@endsection
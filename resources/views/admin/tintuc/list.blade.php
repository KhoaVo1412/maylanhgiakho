@extends('admin.main')

@section('content')
<div class="row w3-res-tb" style="padding: 5px 0 5px 0;">
    <a class="btn btn-primary btn-sm" href="/admin/tintucs/add" style="width:37px;height: 37px; background:#1d1f20">
        <span class="icon" title="Thêm" style="font-size: 19px"><i class="fas fa-plus"></i></span>
    </a>
</div>
<table class="table">
    <thead>
        <tr>

            <th style="width: 50px">img</th>
            <th>Tên tin</th>
            <th>loai tin</th>
            <th>mo ta</th>
            <th style="width: 50px">&nbsp;</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($tintucs as $key =>$tintuc)
        <tr>

            <td> <img src="{{asset($tintuc->image)}}" width="100px" alt="{{$tintuc->name}}"></td>
            <td>{{$tintuc->name}}</td>
            <td>{{$tintuc->description}}</td>

            <td style="text-align: center; display:flex">
                <a class="btn btn-primary btn-sm" href="/admin/tintucs/edit/{{$tintuc->id}}"
                    style="width:30px; margin:0 2px 0 2px;">
                    <span class="icon" title="Sửa"><i class="fas fa-edit"></i></span>
                </a>
                <form action="{{ route('tintucs.destroy', $tintuc->id) }}" method="POST" style="display: inline;">
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
{{-- <div class="card-footer clear-fix">
    {!! $tintucs->links() !!}
</div> --}}

@endsection
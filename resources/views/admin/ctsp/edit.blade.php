@extends('admin.main')

@section('head')
    <script src="/ckeditor/ckeditor.js"></script>
@endsection

@section('content')
<form action="" method="POST">
    <div class="card-body">
      <div class="form-group">
        <label>Tên sản phẩm</label>
        <select class="form-control" name="san_pham_id">
            @foreach ($sps as $sp)
                <option value="{{$sp->id}}" {{$ctsp->san_pham_id == $sp->id ? 'selected' : ''}}>
                    {{$sp->name}}
                </option>
            @endforeach
        </select>
      </div>
      

      <div class="form-group">
        <label >Mã Lực</label>
        <select class="form-control" name="size_id">
            @foreach ($sizes as $size)
                <option value="{{$size->id}}" {{$ctsp->size_id == $size->id ? 'selected' : ''}}>
                    {{$size->tensize}}
                </option>
            @endforeach
        </select>
      </div>

      <div class="form-group">
        <label>Màu</label>
        <select class="form-control" name="mau_id">
            @foreach ($maus as $mau)
                <option value="{{$mau->id}}" {{$ctsp->mau_id == $mau->id ? 'selected' : ''}}>
                    {{$mau->tenmau}}
                </option>
            @endforeach
        </select>
      </div>

      <div class="form-group">
        <label>Số lượng</label>
        <input type="number" name="SL" value="{{$ctsp->SL}}" class="form-control">
      </div>

      
    <!-- /.card-body -->
    <div class="card-footer">
      <button type="submit" class="btn btn-primary">Lưu</button>
    </div>
    @csrf
  </form>
@endsection

@section('footer')
    <script>
        CKEDITOR.replace('content');
    </script>
@endsection
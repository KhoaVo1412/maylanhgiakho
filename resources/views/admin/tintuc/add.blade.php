@extends('admin.main')

@section('head')
<script src="/ckeditor/ckeditor.js"></script>
@endsection

@section('content')
<form action="" method="POST" enctype="multipart/form-data">
  @csrf
  <div class="card-body">
    <div class="form-group">
      <label for="menu">Tên tin tuc</label>
      <input type="text" name="name" class="form-control" value="{{old('name')}}" placeholder="Enter name">
    </div>

    <div class="form-group">
      <label>Loại danh muc</label>
      <select class="form-control" name="danh_muc_tin_tuc_id">
        <option value="">-Chon danh muc-</option>
        @foreach ($dm as $val)
        <option value="{{$val->id}}">{{$val->name}}</option>
        @endforeach
      </select>
    </div>
    <div class="form-group">
      <label>Mô tả</label>
      <input name="description" class="form-control">{{old('description')}}</input>
    </div>

    <div class="form-group">
      <label>Mô tả chi tiết</label>
      <textarea id="detail_descriptions" name="detail_descriptions"
        class="form-control">{{old('detail_descriptions')}}</textarea>
    </div>
    <div class="form-group">
      <label for="">Hình ảnh</label>
      <input type="file" name="image" class="form-control">
    </div>
  </div>
  </div>
  <!-- /.card-body -->
  <div class="card-footer">
    <button type="submit" class="btn btn-primary">Thêm</button>
  </div>
</form>
@endsection

@section('footer')
<script>
  CKEDITOR.replace('detail_descriptions');
</script>
@endsection
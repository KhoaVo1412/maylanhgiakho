@extends('admin.main')

@section('head')
<script src="/ckeditor/ckeditor.js"></script>
@endsection

@section('content')
<form action="" method="POST" enctype="multipart/form-data">
  @csrf
  <div class="card-body">
    <div class="form-group">
      <label for="menu">Tên dịch vụ</label>
      <input type="text" name="name" class="form-control" value="{{old('name')}}" placeholder="Enter name">
    </div>

    <div class="form-group">
      <label>Loại danh mục</label>
      <select class="form-control" name="type">
        <option value="">-Chon loại-</option>
        <option value="maylanh">Máy Lạnh</option>
        <option value="maygiat">Máy Giặt</option>
        <option value="tulanh">Tủ Lạnh</option>
        <option value="ongdongamtuong">Ống Đồng Âm Tường</option>
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
@extends('admin.main')

@section('head')
<script src="/ckeditor/ckeditor.js"></script>
@endsection

@section('content')
<form action="" method="POST" enctype="multipart/form-data">
  <div class="card-body">
    <div class="form-group">
      <label for="val">Tên tin</label>
      <input type="text" name="name" class="form-control" value="{{$edit_dichvus->name}}" placeholder="Enter name">
    </div>
    <div class="form-group">
      <label>Loại danh mục</label>
      <select class="form-control" name="type">
        <option value="">-Chọn loại-</option>
        <option value="maylanh" {{ old('type', $edit_dichvus->type) == 'maylanh' ? 'selected' : '' }}>
          Máy Lạnh
        </option>
        <option value="maygiat" {{ old('type', $edit_dichvus->type) == 'maygiat' ? 'selected' : '' }}>
          Máy Giặt
        </option>
        <option value="tulanh" {{ old('type', $edit_dichvus->type) == 'tulanh' ? 'selected' : '' }}>
          Tủ Lạnh
        </option>
        <option value="ongdongamtuong" {{ old('type', $edit_dichvus->type) == 'ongdongamtuong' ? 'selected' : '' }}>
          Ống Đồng Âm Tường
        </option>
      </select>
    </div>

    <div class="form-group">
      <label>Mô tả</label>
      <textarea name="description" class="form-control">{{$edit_dichvus->description}}</textarea>
    </div>

    <div class="form-group">
      <label>Mô tả chi tiết</label>
      <textarea id="detail_descriptions" name="detail_descriptions"
        class="form-control">{{$edit_dichvus->detail_descriptions}}</textarea>
    </div>

    <div class="form-group">
      <label for="val">Hình ảnh</label>
      <input type="file" name="image" class="form-control">
      @if($edit_dichvus->image)
      <img src="{{ asset($edit_dichvus->image) }}" width="100" alt="Current Image">
      @endif
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
  CKEDITOR.replace('detail_descriptions');
</script>
@endsection
@extends('admin.main')

@section('head')
<script src="/ckeditor/ckeditor.js"></script>
@endsection

@section('content')
<form action="" method="POST" enctype="multipart/form-data">
  <div class="card-body">
    <div class="form-group">
      <label for="val">Tên tin</label>
      <input type="text" name="name" class="form-control" value="{{$edit_tintuc->name}}" placeholder="Enter name">
    </div>

    <div class="form-group">
      <label>Loại danh muc</label>
      <select class="form-control" name="danh_muc_tin_tuc_id">
        @foreach ($dm as $val)
        <option value="{{$val->id}}" {{$val->id==$val->id ? 'selected' : ''}}>
          {{$val->name}}
        </option>
        @endforeach
      </select>
    </div>

    <div class="form-group">
      <label>Mô tả</label>
      <textarea name="description" class="form-control">{{$edit_tintuc->description}}</textarea>
    </div>

    <div class="form-group">
      <label>Mô tả chi tiết</label>
      <textarea id="detail_descriptions" name="detail_descriptions"
        class="form-control">{{$edit_tintuc->detail_descriptions}}</textarea>
    </div>

    <div class="form-group">
      <label for="val">Hình ảnh</label>
      <input type="file" name="image" class="form-control">
      @if($edit_tintuc->image)
      <img src="{{ asset($edit_tintuc->image) }}" width="100" alt="Current Image">
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
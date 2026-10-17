@extends('admin.main')

@section('head')
<script src="/ckeditor/ckeditor.js"></script>
@endsection

@section('content')
<form action="" method="POST" enctype="multipart/form-data">
  <div class="card-body">
    <div class="form-group">
      <label for="menu">Tên Danh muc</label>
      <input type="text" name="name" value="{{$edit_danhmuc->name}}" class="form-control" placeholder="Enter name">
    </div>
    <!-- /.card-body -->
    <div class="card-footer">
      <button type="submit" class="btn btn-primary">Lưu</button>
    </div>
    @csrf
</form>
@endsection

@section('footer')
@endsection
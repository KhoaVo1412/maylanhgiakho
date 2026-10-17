@extends('admin.main')
@section('content')
<form action="" method="POST">
  <div class="card-body">
    <div class="form-group">
      <label for="menu">Tên danh mục</label>
      <input type="text" name="name" class="form-control" placeholder="Enter name">
    </div>
    <div class="card-footer">
      <button type="submit" class="btn btn-primary">Thêm</button>
    </div>
    @csrf
</form>
@endsection

@section('footer')
@endsection
@extends('admin.main')

@section('content')
<form action="" method="POST">
    <div class="card-body">
      <div class="form-group">
        <label for="menu">Tiêu đề</label>
        <input type="text" name="name" class="form-control" value="{{old('name')}}" placeholder="Enter title">
      </div>

      <div class="form-group">
        <label for="menu">Url</label>
        <input type="text" name="url" class="form-control" value="{{old('url')}}" placeholder="Url">
      </div>
      
      <div class="form-group">
        <label for="menu">Hình ảnh</label>
        <input type="file" class="form-control" id="upload">
        <div id="image_show">
          
        </div>
        <input type="hidden" name="thumb" id="thumb">
      </div>

      <div class="form-group">
        <label>Arrange</label>
        <input type="number" name="sort_by" value="1" class="form-control">
      </div>

      <div class="form-group">
        <label>Trạng thái</label>
        <div class="custom-control custom-radio">
          <input class="custom-control-input" type="radio" value="1" id="active" name="active" checked="">
          <label for="active" class="custom-control-label">Hoạt động</label>
        </div>
        <div class="custom-control custom-radio">
          <input class="custom-control-input" type="radio" value="0" id="no_active" name="active">
          <label for="no_active" class="custom-control-label">Không hoạt động</label>
        </div>
      </div>
    <!-- /.card-body -->
    <div class="card-footer">
      <button type="submit" class="btn btn-primary">Thêm</button>
    </div>
    @csrf
  </form>
@endsection

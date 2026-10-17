@extends('admin.main')

@section('content')
<form action="" method="POST">
    <div class="card-body">
      <div class="form-group">
        <label for="menu">Tiêu đề</label>
        <input type="text" name="name" class="form-control" value="{{$slider->name}}" placeholder="Enter title">
      </div>

      <div class="form-group">
        <label for="menu">Url</label>
        <input type="text" name="url" class="form-control" value="{{$slider->url}}" placeholder="Url">
      </div>
      
      <div class="form-group">
        <label for="menu">Hình ảnh</label>
        <input type="file" class="form-control" id="upload">
        <div id="image_show">
            <a href="{{$slider->thumb}}">
              <img src="{{$slider->thumb}}" alt="err" width="100px">
            </a>
        </div>
        <input type="hidden" value="{{$slider->thumb}}" name="thumb" id="thumb">
      </div>

      <div class="form-group">
        <label>Arrange</label>
        <input type="number" name="sort_by" value="{{$slider->sort_by}}" class="form-control">
      </div>

      <div class="form-group">
        <label>Trạng thái</label>
        <div class="custom-control custom-radio">
          <input class="custom-control-input" type="radio" value="1" id="active" name="active" 
            {{$slider->active == 1 ? ' checked=""' : ''}}>
          <label for="active" class="custom-control-label">Hoạt động</label>
        </div>
        <div class="custom-control custom-radio">
          <input class="custom-control-input" type="radio" value="0" id="no_active" name="active"
            {{$slider->active == 0 ? ' checked=""' : ''}}>
          <label for="no_active" class="custom-control-label">Không hoạt động</label>
        </div>
      </div>
    <!-- /.card-body -->
    <div class="card-footer">
      <button type="submit" class="btn btn-primary">Lưu</button>
    </div>
    @csrf
  </form>
@endsection

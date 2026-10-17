@extends('admin.main')

@section('head')
    <script src="/ckeditor/ckeditor.js"></script>
@endsection

@section('content')
<form action="" method="POST">
    <div class="card-body">
      <div class="form-group">
        <label for="menu">Tên Loại</label>
        <input type="text" name="name" class="form-control" placeholder="Enter name">
      </div>

      <div class="form-group">
        <label >Category</label>
        <select class="form-control" name="parent_id">
            <option value="0">Main Category</option>
            @foreach ($menus as $menu)
              <option value="{{$menu->id}}">{{$menu->name}}</option>
            @endforeach
        </select>
      </div>
      
      <div class="form-group">
        <label>Tiêu đề</label>
        <input type="text"name="title" class="form-control">
      </div>
      <div class="form-group">
        <label>Mô tả</label>
        <textarea name="description" class="form-control"></textarea>
      </div>

      <div class="form-group">
        <label>Mô tả chi tiết</label>
        <textarea id="content" name="content" class="form-control"></textarea>
      </div>
      
      <div class="form-group">
        <label for="menu">Hình ảnh</label>
        <input type="file" class="form-control" id="upload">
        <div id="image_show">
          
        </div>
        <input type="hidden" name="thumb" id="thumb">
      </div>
      
      <div class="form-group">
        <label>Trạng Thái</label>
        <div class="custom-control custom-radio">
          <input class="custom-control-input" type="radio" value="1" id="active" name="active" checked="">
          <label for="active" class="custom-control-label">Hoạt động</label>
        </div>
        <div class="custom-control custom-radio">
          <input class="custom-control-input" type="radio" value="0" id="no_active" name="active">
          <label for="no_active" class="custom-control-label">Không Hoạt Động</label>
        </div>
      </div>
    <!-- /.card-body -->
    <div class="card-footer">
      <button type="submit" class="btn btn-primary">Thêm</button>
    </div>
    @csrf
  </form>
@endsection

@section('footer')
    <script>
        CKEDITOR.replace('content');
    </script>
@endsection
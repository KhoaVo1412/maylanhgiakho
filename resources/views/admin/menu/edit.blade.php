@extends('admin.main')

@section('head')
    <script src="/ckeditor/ckeditor.js"></script>
@endsection

@section('content')
<form action="" method="POST">
    <div class="card-body">
      <div class="form-group">
        <label for="menu">Tên Loại</label>
        <input type="text" name="name" value="{{$menu->name}}" class="form-control" placeholder="Enter name">
      </div>
      <div class="form-group">
        <label for="menu">Tieu de</label>
        <input type="text" name="title" value="{{$menu->title}}" class="form-control" placeholder="Enter name">
      </div>

      <div class="form-group">
        <label >Category</label>
        <select class="form-control" name="parent_id">
            <option value="0" {{$menu->parent_id == 0 ? 'selected':''}}>Danh muc cha</option>
            @foreach ($menus as $menuParent)
                <option value="{{$menuParent->id}}" 
                    {{$menu->parent_id == $menuParent->id ? 'selected' : ''}}>
                    {{$menuParent->name}}
                </option>
            @endforeach
        </select>
      </div>
      <div class="form-group">
        <label>Mô tả</label>
        <textarea id="description" name="description" class="form-control">{{$menu->description}}</textarea>
      </div>
      <div class="form-group">
        <label>Mô tả chi tiết</label>
        <textarea id="content" name="content" class="form-control">{{$menu->content}}</textarea>
      </div>

      <div class="form-group">
        <label for="menu">Hình ảnh</label>
        <input type="file" class="form-control" id="upload">
        <div id="image_show">
          
        </div>
        <input type="hidden" name="thumb" value="{{$menu->thumb}}" id="thumb">
      </div>

      <div class="form-group">
        <label>Trạng thái</label>
        <div class="custom-control custom-radio">
          <input class="custom-control-input" type="radio" value="1" id="active" name="active" 
          {{-- nếu menu active ==1 thì sẽ check --}}
            {{$menu->active == 1 ? 'checked = "" ':''}}>
          <label for="active" class="custom-control-label">Hoạt động</label>
        </div>
        <div class="custom-control custom-radio">
          <input class="custom-control-input" type="radio" value="0" id="no_active" name="active"
          {{$menu->active == 0  ? 'checked = "" ':''}}>
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

@section('footer')
    <script>
        CKEDITOR.replace('content');
    </script>
@endsection
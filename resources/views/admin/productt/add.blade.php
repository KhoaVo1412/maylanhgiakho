@extends('admin.main')

@section('head')
    <script src="/ckeditor/ckeditor.js"></script>
@endsection

@section('content')
<form action="" method="POST">
    <div class="card-body">
      <div class="form-group">
        <label for="menu">Tên sản phẩm</label>
        <input type="text" name="name" class="form-control" value="{{old('name')}}" placeholder="Enter name">
      </div>

      <div class="form-group">
        <label >Loại sản phẩm</label>
        <select class="form-control" name="menu_id">
            @foreach ($menus as $menu)
              <option value="{{$menu->id}}">{{$menu->name}}</option>
            @endforeach
        </select>
      </div>
      {{-- <div class="form-group">
        <label>Quantity</label>
        <input type="number" name="SL" value="{{old('SL')}}" class="form-control">
      </div> --}}

      <div class="form-group">
        <label>Giá</label>
        <input type="number" name="price" value="{{old('price')}}" class="form-control">
      </div>
      
      <div class="form-group">
        <label>Giá Giảm(nếu có)</label>
        <input type="number" name="price_sale" value="{{old('price_sale')}}" class="form-control">
      </div>

      
      <div class="form-group">
        <label>Mô tả</label>
        <textarea name="description" class="form-control">{{old('description')}}</textarea>
      </div>

      <div class="form-group">
        <label>Mô tả chi tiết</label>
        <textarea id="content" name="content" class="form-control">{{old('content')}}</textarea>
      </div>
      
      {{-- first --}}
      <h2 style="text-align: center;">Thông Số Kỹ Thuật</h2>
      <div class="form-group">
        <label>Model</label>
        <input type="text" name="model" class="form-control" value="{{old('model')}}">
      </div>
      <div class="form-group">
        <label>Màu Sắc</label>
        <input type="text" name="mausac" class="form-control"value="{{old('mausac')}}">
      </div>
      <div class="form-group">
        <label>Nhà Sản Xuất</label>
        <input type="text" name="nsx" class="form-control" value="{{old('nsx')}}">
      </div>
      <div class="form-group">
        <label>Xuất Xứ</label>
        <input type="text" name="xuatxu" class="form-control"value="{{old('xuatxu')}}">
      </div>
      <div class="form-group">
        <label>Năm Ra mắt</label>
        <input type="text" name="namramat" class="form-control"value="{{old('namramat')}}">
      </div>
      <div class="form-group">
        <label>Thời Gian Bảo Hành</label>
        <input type="text" name="tgbh" class="form-control"value="{{old('tgbh')}}">
      </div>
      <div class="form-group">
        <label>Điểm Bảo Hành</label>
        <input type="text" name="ddiembh" class="form-control"value="{{old('ddiembh')}}">
      </div>
      <div class="form-group">
        <label>Loại Gas</label>
        <input type="text" name="loaigas" class="form-control"value="{{old('loaigas')}}">
      </div>
      <div class="form-group">
        <label>Khử Mùi</label>
        <input type="text" name="khumui" class="form-control" value="{{old('khumui')}}">
      </div>
      {{-- end --}}
      
      <div class="form-group">
        <label for="menu">Hình ảnh</label>
        <input type="file" class="form-control" id="upload">
        <div id="image_show">
          
        </div>
        <input type="hidden" name="thumb" id="thumb">
      </div>
      
      <div class="form-group">
        <label for="menu">Hình ảnh chi tiết 1</label>
        <input type="file" class="form-control" id="upload_dt1">
        <div id="image_show_dt1">
          
        </div>
        <input type="hidden" name="thumb_dt1" id="thumb_dt1">
      </div>
      
      <div class="form-group">
        <label for="menu">Hình ảnh chi tiết 2</label>
        <input type="file" class="form-control" id="upload_dt2">
        <div id="image_show_dt2">
          
        </div>
        <input type="hidden" name="thumb_dt2" id="thumb_dt2">
      </div>
      
      <div class="form-group">
        <label>Trạng Thái</label>
        <div class="custom-control custom-radio">
          <input class="custom-control-input" type="radio" value="1" id="active" name="active" checked="">
          <label for="active" class="custom-control-label">Hoạt động</label>
        </div>
        <div class="custom-control custom-radio">
          <input class="custom-control-input" type="radio" value="0" id="no_active" name="active">
          <label for="no_active" class="custom-control-label">Không hoạt động</label>
        </div>
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
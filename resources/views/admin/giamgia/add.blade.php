@extends('admin.main')

@section('head')
    <script src="/ckeditor/ckeditor.js"></script>
@endsection

@section('content')
<form action="" method="POST">
    <div class="card-body">
      <div class="form-group">
        <label for="">Tên giảm giá</label>
        <input type="text" name="tengg" class="form-control" placeholder="Name Discount">
      </div>

      <div class="form-group">
        <label for="">Mã giảm giá</label>
        <input type="text" name="magg" class="form-control" placeholder="Discount Code">
      </div>

      <div class="form-group">
        <label for="">Số lượng</label>
        <input type="text" name="slgg" class="form-control" placeholder="Quantity">
      </div>

      <div class="form-group">
        <label for="">Tính năng</label>
        <select class="form-control" name="tngg">
            <option value="0">--- Choose ---</option>
              <option value="1">Giảm theo %</option>
              <option value="2">Giảm theo số tiền</option>
        </select>
      </div>

      <div class="form-group">
        <label for="">Số tiền hoặc số %</label>
        <input type="text" name="sotiengg" class="form-control" placeholder="% or moneys">
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

@section('footer')
    <script>
        CKEDITOR.replace('content');
    </script>
@endsection
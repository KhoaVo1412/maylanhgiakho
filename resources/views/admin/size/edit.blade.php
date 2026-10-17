@extends('admin.main')

@section('head')
    <script src="/ckeditor/ckeditor.js"></script>
@endsection

@section('content')
<form action="" method="POST">
    <div class="card-body">
      <div class="form-group">
        <label for="menu">Mã Lực(HP)</label>
        <input type="text" name="tensize" value="{{$size->tensize}}" class="form-control" placeholder="Nhập Mã LựcLực">
      </div>

      <div class="form-group">
        <label>Trạn thái</label>
        <div class="custom-control custom-radio">
          <input class="custom-control-input" type="radio" value="1" id="active" name="active" 
          {{-- nếu menu active ==1 thì sẽ check --}}
            {{$size->active == 1 ? 'checked = "" ':''}}>
          <label for="active" class="custom-control-label">Hoạt động</label>
        </div>
        <div class="custom-control custom-radio">
          <input class="custom-control-input" type="radio" value="0" id="no_active" name="active"
          {{$size->active == 0  ? 'checked = "" ':''}}>
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
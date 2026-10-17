<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4" style="background: #1d1f20;">
  <!-- Brand Logo -->
  <a href="/admin" class="brand-link">
    <img src="/template/admin/dist/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3"
      style="opacity: .8">
    <span class="brand-text font-weight-light">Trang Admin</span>
  </a>

  <!-- Sidebar -->
  <div class="sidebar">
    <!-- Sidebar user (optional) -->
    <div class="user-panel mt-3 pb-3 mb-3 d-flex">
      <div class="image">
        <img src="/template/admin/dist/img/avatar3.png" class="img-circle elevation-2" alt="User Image">
      </div>
      <div class="info">
        <a href="#" class="d-block" style="font-size: 20px; font-weight: bold;">{{Auth::user()->name}}</a>
      </div>
    </div>

    <!-- SidebarSearch Form -->
    <div class="form-inline">
      <div class="input-group" data-widget="sidebar-search">
        <input class="form-control form-control-sidebar" type="Search" placeholder="Tìm kiếm" aria-label="Search">
        <div class="input-group-append">
          <button class="btn btn-sidebar">
            <i class="fas fa-search fa-fw"></i>
          </button>
        </div>
      </div>
    </div>

    <!-- Sidebar Menu -->
    <nav class="mt-2">
      <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
        {{-- Category --}}
        <li class="nav-item">
          <a href="#" class="nav-link">
            <i class="nav-icon fas fa-tachometer-alt"></i>
            <p>
              Loại Sản Phẩm
              <i class="right fas fa-angle-left"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="/admin/menus/add" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Thêm</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="/admin/menus/list" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Danh Sách</p>
              </a>
            </li>
          </ul>
        </li>

        {{-- Product --}}
        <li class="nav-item">
          <a href="#" class="nav-link">
            <i class="fab fa-product-hunt" aria-hidden="true"></i>
            <p> Sản Phẩm
              <i class="right fas fa-angle-left"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="/admin/productts/add" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Thêm</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="/admin/productts/list" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Danh Sách </p>
              </a>
            </li>
          </ul>
        </li>

        {{-- Manager Bai viết--}}
        <li class="nav-item">
          <a href="#" class="nav-link">
            <i class="fa fa-link" aria-hidden="true"></i>
            <p> Danh Mục Bài Viết
              <i class="right fas fa-angle-left"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="/admin/danhmucbaiviets/add" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Thêm </p>
              </a>
            </li>
            <li class="nav-item">
              <a href="/admin/danhmucbaiviets/list" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Danh Sách </p>
              </a>
            </li>

          </ul>
        </li>
        <li class="nav-item">
          <a href="#" class="nav-link">
            <i class="fa fa-link" aria-hidden="true"></i>
            <p> Danh Sach Bài Viết
              <i class="right fas fa-angle-left"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="/admin/tintucs/add" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Thêm </p>
              </a>
            </li>
            <li class="nav-item">
              <a href="/admin/tintucs/list" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Danh Sách </p>
              </a>
            </li>

          </ul>
        </li>
        <li class="nav-item">
          <a href="#" class="nav-link">
            <i class="fa fa-link" aria-hidden="true"></i>
            <p>Bài Viết Dịch Vụ
              <i class="right fas fa-angle-left"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="/admin/dichvus/add" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Thêm </p>
              </a>
            </li>
            <li class="nav-item">
              <a href="/admin/dichvus/list" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Danh Sách </p>
              </a>
            </li>

          </ul>
        </li>
        {{-- Manager Size--}}
        <li class="nav-item">
          <a href="#" class="nav-link">
            <i class="fa fa-link" aria-hidden="true"></i>
            <p> Mã Lực(HP)
              <i class="right fas fa-angle-left"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="/admin/size/add" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Thêm </p>
              </a>
            </li>
            <li class="nav-item">
              <a href="/admin/size/list" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Danh Sách </p>
              </a>
            </li>

          </ul>
        </li>

        {{-- Manager Mau--}}
        <li class="nav-item">
          <a href="#" class="nav-link">
            <i class="fas fa-palette" aria-hidden="true"></i>
            <p> Màu
              <i class="right fas fa-angle-left"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="/admin/mau/add" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Thêm </p>
              </a>
            </li>
            <li class="nav-item">
              <a href="/admin/mau/list" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Danh Sách </p>
              </a>
            </li>

          </ul>
        </li>

        {{-- Manager CTSP--}}
        <li class="nav-item">
          <a href="#" class="nav-link">
            <i class="fas fa-info-circle" aria-hidden="true"></i>
            <p> Chi Tiết Sản Phẩm
              <i class="right fas fa-angle-left"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="/admin/ctsp/add" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Thêm</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="/admin/ctsp/list" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Danh Sách</p>
              </a>
            </li>

          </ul>
        </li>

        {{-- Slider --}}
        <li class="nav-item">
          <a href="#" class="nav-link">
            <i class="fas fa-sliders-h" aria-hidden="true"></i>
            <p> Sliders
              <i class="right fas fa-angle-left"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="/admin/sliders/add" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Thêm</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="/admin/sliders/list" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Danh Sách</p>
              </a>
            </li>

          </ul>
        </li>

        {{--Bill Login--}}
        <li class="nav-item">
          <a href="#" class="nav-link">
            <i class="fas fa-file-invoice-dollar" aria-hidden="true"></i>
            <p> Hóa Đơn Đăng Nhập
              <i class="right fas fa-angle-left"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">

            <li class="nav-item">
              <a href="/admin/customerslog" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Danh Sách</p>
              </a>
            </li>

          </ul>
        </li>

        {{-- ShoppingCart --}}
        <li class="nav-item">
          <a href="#" class="nav-link">
            <i class="fas fa-file-invoice-dollar" aria-hidden="true"></i>
            <p> Hóa Đơn Vãng Lai
              <i class="right fas fa-angle-left"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="/admin/customers" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Danh Sách</p>
              </a>
            </li>
          </ul>
        </li>

        {{-- Manager User--}}
        {{-- <li class="nav-item">
          <a href="#" class="nav-link">
            <i class="fa fa-cart-plus" aria-hidden="true"></i>
            <p> Khách Hàng Vãng Lai
              <i class="right fas fa-angle-left"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="/admin/customermanagers" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Danh Sách</p>
              </a>
            </li>
          </ul>
        </li> --}}

        {{-- Manager User Login--}}
        <li class="nav-item">
          <a href="#" class="nav-link">
            <i class="fas fa-user-circle" aria-hidden="true"></i>
            <p>Tài Khoản Khách Hàng
              <i class="right fas fa-angle-left"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="/admin/customermanagers" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Danh Sách</p>
              </a>
            </li>
          </ul>
        </li>

        {{-- Disount --}}
        <li class="nav-item">
          <a href="#" class="nav-link">
            <i class="fas fa-tags" aria-hidden="true"></i>
            <p> Giảm Giá
              <i class="right fas fa-angle-left"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="/admin/giamgia/add" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Thêm</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="/admin/giamgia/list" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Danh Sách</p>
              </a>
            </li>

          </ul>
        </li>
      </ul>
    </nav>
    <!-- /.sidebar-menu -->
  </div>
  <!-- /.sidebar -->
</aside>
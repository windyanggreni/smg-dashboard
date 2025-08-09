 <!-- Sidebar -->
 <div class="sidebar" data-background-color="dark">
    <div class="sidebar-logo">
      <!-- Logo Header -->
      <div class="logo-header" data-background-color="dark">
        <a href="index.html" class="logo mt-3" style="margin-left: 40px;">
          <img
            src="{{ asset('assets/img/smg/logosmg.png') }}"
            alt="Logo navbar brand"
            class="navbar-brand"
            height="70"
          />
        </a>
        <div class="nav-toggle">
          <button class="btn btn-toggle toggle-sidebar">
            <i class="gg-menu-right"></i>
          </button>
          <button class="btn btn-toggle sidenav-toggler">
            <i class="gg-menu-left"></i>
          </button>
        </div>
        <button class="topbar-toggler more">
          <i class="gg-more-vertical-alt"></i>
        </button>
      </div>
      <!-- End Logo Header -->
    </div>
    <div class="sidebar-wrapper scrollbar scrollbar-inner">
      <div class="sidebar-content">
        <ul class="nav nav-secondary">
            <li class="nav-item active">
                <a href="/dashboard">
                    <i class="fa fa-home"></i>
                    <p>Dashboard</p>
                </a>
            </li>
          <li class="nav-section">
            <span class="sidebar-mini-icon">
              <i class="fa fa-ellipsis-h"></i>
            </span>
            <h4 class="text-section">Operations</h4>
          </li>

          <li class="nav-item">
            <a href="{{ route('categories.index') }}">
                <i class="fas fa-tags"></i>
                <p>Categories</p>
            </a>
          </li>

          <li class="nav-item">
            <a href="{{ route('products.index') }}">
                <i class="fas fa-box"></i>
                <p>Products</p>
            </a>
          </li>

          <li class="nav-item">
            <a href="{{ route('orders.index') }}">
                <i class="fas fa-receipt"></i>
                <p>Order Management</p>
                @if($countPendingOrders > 0)
                    <span class="badge badge-success">{{ $countPendingOrders }}</span>
                @endif
            </a>
        </li>


          <li class="nav-section">
            <span class="sidebar-mini-icon">
              <i class="fa fa-ellipsis-h"></i>
            </span>
            <h4 class="text-section">User Management</h4>
          </li>

        <li class="nav-item">
            <a href="{{ route('users.index') }}">
                <i class="fas fa-users-cog"></i>
                <p>Users Management</p>
            </a>
        </li>

        <li class="nav-section">
            <span class="sidebar-mini-icon">
              <i class="fa fa-ellipsis-h"></i>
            </span>
            <h4 class="text-section">Documents</h4>
          </li>

          <li class="nav-item">
            <a href="{{ route('laporan.index') }}">
                <i class="fas fa-file-alt"></i>
                <p>Laporan</p>
            </a>
          </li>

      </div>
    </div>
  </div>
  <!-- End Sidebar -->
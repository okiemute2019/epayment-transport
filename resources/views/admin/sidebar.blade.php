<nav class="sidebar sidebar-offcanvas" id="sidebar">
  <ul class="nav">
    <li class="nav-item nav-profile">
      <a href="#" class="nav-link">
        <div class="nav-profile-image">
          <img src="assets/images/faces/face1.jpg" alt="profile">
          <span class="login-status online"></span>
          <!--change to offline or busy as needed-->
        </div>
        <div class="nav-profile-text d-flex flex-column">
          <span class="font-weight-bold mb-2">{{ Auth::user()->name }}</span>
          <span class="text-secondary text-small">{{ Auth::user()->role }}</span>
        </div>
        <i class="mdi mdi-bookmark-check text-success nav-profile-badge"></i>
      </a>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="{{route('admin.dashboard')}}">
        <span class="menu-title">Dashboard</span>
        <i class="mdi mdi-home menu-icon"></i>
      </a>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="{{route('admin.showMerchants')}}">
        <span class="menu-title">Merchant Management</span>
        <i class="mdi mdi-worker menu-icon"></i>
      </a>
    </li>
    <li class="nav-item">
      <a class="nav-link" data-bs-toggle="collapse" href="#bus-app" aria-expanded="false" aria-controls="bus-app">
        <span class="menu-title">Bus Application</span>
        <i class="menu-arrow"></i>
        <i class="mdi mdi-bus menu-icon"></i>
      </a>
      <div class="collapse" id="bus-app">
        <ul class="nav flex-column sub-menu">
          <li class="nav-item"> <a class="nav-link" href="{{route('admin.showBusRoutes')}}">Route Management</a></li>
          <li class="nav-item"> <a class="nav-link" href="{{route('admin.showBuses')}}">Bus Management</a></li>
          <li class="nav-item"> <a class="nav-link" href="#">Transaction Details</a></li>
          <li class="nav-item"> <a class="nav-link" href="#">Transaction Summary</a></li>
        </ul>
      </div>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="#">
        <span class="menu-title">Settlement Management</span>
        <i class="mdi mdi-cash-multiple menu-icon"></i>
      </a>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="#">
        <span class="menu-title">Payment Management</span>
        <i class="mdi mdi-cash menu-icon"></i>
      </a>
    </li>
  </ul>
</nav>
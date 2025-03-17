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
        <a class="nav-link" href="{{route('merchant.dashboard')}}">
          <span class="menu-title">Dashboard</span>
          <i class="mdi mdi-home menu-icon"></i>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="{{route('merchant.showBuses',['phone'=>Auth::user()->phone])}}">
          <span class="menu-title">Bus Information</span>
          <i class="mdi mdi-bus menu-icon"></i>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="{{route('merchant.showBusRoutes',['phone'=>Auth::user()->phone])}}">
          <span class="menu-title">Bus Routes</span>
          <i class="mdi mdi-highway menu-icon"></i>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="{{route('merchant.transDetails',['id'=>Auth::user()->id])}}">
          <span class="menu-title">Transaction Details</span>
          <i class="mdi mdi-cash menu-icon"></i>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="#">
          <span class="menu-title">Transaction Summary</span>
          <i class="mdi mdi-cash-multiple menu-icon"></i>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="#">
          <span class="menu-title">Balance History</span>
          <i class="mdi mdi-history menu-icon"></i>
        </a>
      </li>
    </ul>
  </nav>
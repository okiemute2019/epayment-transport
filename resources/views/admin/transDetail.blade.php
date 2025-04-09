<!DOCTYPE html>
<html lang="en">
  <head>
    @include('admin.header')
  </head>
  <body>
    <div class="container-scroller">
      <!-- partial:partials/_navbar.html -->
      @include('admin.navbar')
      <!-- partial -->
      <div class="container-fluid page-body-wrapper">
        <!-- partial:partials/_sidebar.html -->
        @include('admin.sidebar')
        <!-- partial -->
        <div class="main-panel">
          <div class="content-wrapper">
            <div class="page-header">
              <h3 class="page-title">
                <span class="page-title-icon bg-gradient-primary text-white me-2">
                  <i class="mdi mdi-home"></i>
                </span>Admin
              </h3>
              <nav aria-label="breadcrumb">
                <ul class="breadcrumb">
                  <li class="breadcrumb-item active" aria-current="page">
                    <span></span>Overview <i class="mdi mdi-alert-circle-outline icon-sm text-primary align-middle"></i>
                  </li>
                </ul>
              </nav>
            </div>
            <div class="row">
                <div class="col-lg-12 grid-margin stretch-card">
                    <div class="card">
                      <div class="card-body">
                        <h4 class="card-title">All Transactions</h4>
                        <!-- <button type="button" class="btn btn-primary btn-rounded btn-fw btn-sm" data-bs-toggle="modal" data-bs-target="#addBusRouteModal">Add Bus Route</button> -->
                        <div class="d-flex flex-row-reverse">{{ $alltrans_details->links('pagination::bootstrap-4') }}</div>
                        <table class="table">
                          <thead>
                            <tr>
                              <th>ID</th>
                              <th>Account ID</th>
                              <th>Desc</th>
                              <th>Amount</th>
                              <th>Date</th>
                            </tr>
                          </thead>
                          <tbody>
                            @foreach ($alltrans_details as $detail)                            
                            <tr>
                              <td>{{$detail->id}}</td>
                              <td>{{$detail->account_id}}</td>
                              <td>{{$detail->desc}}</td>
                              <td>{{$detail->amount}}</td>
                              <td>{{$detail->created_at}}</td>
                            </tr>
                          @endforeach
                          </tbody>
                        </table>
                      </div>
                      <div class="row">{{ $alltrans_details->links('pagination::bootstrap-4') }}</div>
                    </div>
                  </div>
            </div>
          </div>

          
          <!-- content-wrapper ends -->
          <!-- partial:partials/_footer.html -->
          @include('admin.footer')
          <!-- partial -->
        </div>
        <!-- main-panel ends -->
      </div>
      <!-- page-body-wrapper ends -->
    </div>
    <!-- container-scroller -->
    @include('admin.scripts')
  </body>
</html>
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
                </span>Admin Dashboard
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
                        <h4 class="card-title">Merchant Bus Routes</h4>
                        <button type="button" class="btn btn-primary btn-rounded btn-fw btn-sm" data-bs-toggle="modal" data-bs-target="#addBusRouteModal">Add Bus Route</button>
                        <table class="table">
                          <thead>
                            <tr>
                              <th>Route ID</th>
                              <th>Route</th>
                              <th>Merchant</th>
                              <th>Fare</th>
                              <th>Actions</th>
                            </tr>
                          </thead>
                          <tbody>
                            @foreach ($regBusRoutes as $busroute)
                            <tr>
                              <td>{{$busroute->id}}</td>
                              <td>{{$busroute->routename}}</td>
                              <td>{{$busroute->merchantname}}</td>
                              <td>{{$busroute->fare}}</td>
                              <td><i class="mdi mdi-settings-box"></i><a href="{{url('admin/deleteBusRoute/'.$busroute->id)}}" onclick="return confirm(&quot;Confirm delete?&quot;)"><i class="mdi mdi-delete"></i></a></td>
                            </tr>
                            @endforeach
                          </tbody>
                        </table>
                      </div>
                    </div>
                  </div>
            </div>
          </div>

          <!-- Modal -->
          <div class="modal fade" id="addBusRouteModal" tabindex="-1" aria-labelledby="addBusRouteModalLabel" aria-hidden="true">
            <div class="modal-dialog">
              <form method="post" action="{{url('admin/addBusRoute')}}">
                {!! csrf_field() !!}
              <div class="modal-content">
                <div class="modal-header">
                  <h1 class="modal-title fs-5" id="exampleModalLabel">New Bus Route</h1>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                  <div class="modal-body">
                    <div class="mb-3">
                      <select class="form-select" name="merchantID" aria-label="Default select Merchant" required>
                        <option selected>Select Merchant</option>
                        @foreach ($regMerchants as $item)
                          <option value={{$item->id}}>{{$item->merchantname}}</option>
                        @endforeach
                      </select>
                    </div>
                    <div class="mb-3">
                      <label for="formGroup" class="form-label">Route Name</label>
                      <input type="text" name="routename" class="form-control" id="formGroupBusRoute" placeholder="Enter Route Name" required>
                      @error('routename')
                          <span class="text-danger">{{ $message }}</span>
                      @enderror
                    </div>
                    <div class="mb-3">
                      <label for="formGroup" class="form-label">From</label>
                      <input type="text" name="from" class="form-control" id="formGroupBusRoute" placeholder="Enter Origin" required>
                    </div>
                    <div class="mb-3">
                      <label for="formGroup" class="form-label">To</label>
                      <input type="text" name="to" class="form-control" id="formGroupBusRoute" placeholder="Enter Destination" required>
                    </div>
                    <div class="mb-3">
                      <label for="formGroup" class="form-label">Fare</label>
                      <input type="number" name="fare" class="form-control" id="formGroupBusRoute" placeholder="Enter Route Fare" required>
                    </div>
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <input type="submit" value="Save" class="btn btn-primary">
                  </div>
              </div>
              </form>
            </div>
          </div>
          <!-- End Modal -->
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
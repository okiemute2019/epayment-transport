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
                        <h4 class="card-title">Merchant Buses</h4>
                        <button type="button" class="btn btn-primary btn-rounded btn-fw btn-sm" data-bs-toggle="modal" data-bs-target="#addBusRouteModal">Add Bus</button>
                        <table class="table">
                          <thead>
                            <tr>
                              <th>Bus ID</th>
                              <th>Bus Code</th>
                              <th>Model</th>
                              <th>Merchant</th>
                              <th>Actions</th>
                            </tr>
                          </thead>
                          <tbody>
                            @foreach ($regBuses as $bus)
                            <tr>
                              <td>{{$bus->id}}</td>
                              <td>{{$bus->bus_code}}</td>
                              <td>{{$bus->bus_model}}</td>
                              <td>{{$bus->merchantname}}</td>
                              <td><i class="mdi mdi-settings-box"></i><a href="{{url('admin/deleteBusInfo/'.$bus->id)}}" onclick="return confirm(&quot;Confirm delete?&quot;)"><i class="mdi mdi-delete"></i></a></td>
                            </tr>
                            @endforeach
                          </tbody>
                        </table>
                      </div>
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
              <!-- Modal -->
              <div class="modal fade" id="addBusRouteModal" tabindex="-1" aria-labelledby="addBusRouteModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                  <form method="post" action="{{url('admin/addBusInfo')}}">
                    {!! csrf_field() !!}
                  <div class="modal-content">
                    <div class="modal-header">
                      <h1 class="modal-title fs-5" id="exampleModalLabel">New Bus</h1>
                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                      <div class="modal-body">
                        <div class="mb-3">
                          <label for="formGroup" class="form-label">Select Merchant</label>
                          <select class="form-select" name="merchantID" aria-label="Default select Merchant" required>
                            <option value="">Select Merchant</option>
                            @foreach ($regMerchants as $item)
                              <option value={{$item->id}}>{{$item->merchantname}}</option>
                            @endforeach
                          </select>
                        </div>
                        <div class="mb-3">
                          <label for="formGroup" class="form-label">Bus Code</label>
                          <input type="text" name="buscode" class="form-control" id="formGroupBusInfo" placeholder="Enter Bus Code" required>
                        </div>
                        <div class="mb-3">
                            <label for="formGroup" class="form-label">Select Bus Model</label>
                            <select class="form-select" name="busmodel" aria-label="Default select Bus Model" required>
                                <option value="">Select Bus Model</option>
                                <option value="Ashok">Ashok</option>
                                <option value="Yutong">Yutong</option>
                                <option value="Daewoo">Daewoo</option>
                            </select>
                        </div>
                        <div class="mb-3">
                          <label for="formGroup" class="form-label">Plate Number</label>
                          <input type="text" name="plate_no" class="form-control" id="formGroupBusInfo" placeholder="Enter Plate Number" required>
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
    @include('admin.scripts')
  </body>
</html>
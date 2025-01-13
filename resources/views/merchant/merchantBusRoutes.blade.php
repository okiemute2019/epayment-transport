<!DOCTYPE html>
<html lang="en">
  <head>
    @include('merchant.header')
  </head>
  <body>
    <div class="container-scroller">
      <!-- partial:partials/_navbar.html -->
      @include('merchant.navbar')
      <!-- partial -->
      <div class="container-fluid page-body-wrapper">
        <!-- partial:partials/_sidebar.html -->
        @include('merchant.sidebar')
        <!-- partial -->
        <div class="main-panel">
          <div class="content-wrapper">
            <div class="page-header">
              <h3 class="page-title">
                <span class="page-title-icon bg-gradient-primary text-white me-2">
                  <i class="mdi mdi-home"></i>
                </span>Merchant Dashboard
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
                        <h4 class="card-title">Bus Routes</h4>
                        <table class="table">
                          <thead>
                            <tr>
                              <th>Route ID</th>
                              <th>Route</th>
                              <th>Merchant</th>
                              <th>Fare</th>
                              <th>QR Code</th>
                            </tr>
                          </thead>
                          <tbody>
                            @foreach ($regBusRoutes as $busroute)
                              @php
                                  $newroute = ["id"=>$busroute->id,"routename"=>$busroute->routename,"merchantid"=>$busroute->merchant_id,"merchantname"=>$busroute->merchantname,"fare"=>$busroute->fare];
                                  $newer = json_encode($newroute);
                              @endphp
                            <tr>
                              <td>{{$busroute->id}}</td>
                              <td>{{$busroute->routename}}</td>
                              <td>{{$busroute->merchantname}}</td>
                              <td>{{$busroute->fare}}</td>
                              <td><button type="button" class="btn btn-sm btn-success" data-bs-toggle="modal" data-bs-target="#generateRouteQRModal{{$busroute->id}}">Generate</button></td>
                            </tr>
                            <!-- Modal -->
                            <div class="modal fade" id="generateRouteQRModal{{$busroute->id}}" tabindex="-1" aria-labelledby="generateRouteQRModalLabel" aria-hidden="true">
                              <div class="modal-dialog modal-sm">
                                <div class="modal-content">
                                  <div class="modal-header">
                                    <h1 class="modal-title fs-5" id="exampleModalLabel">Scan Ticket QR</h1>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                  </div>
                                    <div class="modal-body">
                                      <div class="col-md-4">
                                        {!! QrCode::size(250)->generate($newer); !!}
                                      </div>
                                    </div>
                                    <div class="modal-footer justify-content-start">
                                      <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                    </div>
                                </div>
                              </div>
                            </div>
                            <!-- End Modal -->
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
          @include('merchant.footer')
          <!-- partial -->
        </div>
        <!-- main-panel ends -->
      </div>
      <!-- page-body-wrapper ends -->
    </div>
    <!-- container-scroller -->
    @include('merchant.scripts')
  </body>
</html>
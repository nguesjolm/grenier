<?php
//Volume de SMS disponible

?>
@include('layouts.header')
<!-- Wrapper -->
    <div id="db-wrapper">
        <!-- Sidebar -->
        @include('pages.admin_nav')
        <!-- sidebar -->

        <!-- Page Content -->
        <div id="page-content">

            <!-- Page Header -->
            @include('pages.admin_header')
            <!-- Page Header -->

            <!-- Container fluid::Nouvelle client -->
           <!-- Container fluid -->
           <div class="container-fluid p-4">
            <div class="row">
                <!-- Page Header -->
                <div class="col-lg-12 col-md-12 col-12">
                    <div class="border-bottom pb-4 mb-4 d-flex justify-content-between align-items-center">

                        <div class="mb-2 mb-lg-0">
                            <h1 class="mb-1 h2 font-weight-bold">
                              Unité sms
                                <span class="font-size-sm text-muted"></span>
                            </h1>
                            <!-- Breadcrumb  -->
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item">
                                        <a href="dashboard">Dashboard</a>
                                    </li>
                                    <li class="breadcrumb-item"><a href="#!">SMS</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">
                                       solde
                                    </li>
                                </ol>
                            </nav>
                        </div>

                        <div class="nav btn-group" role="tablist">
                            <button class="btn btn-outline-warning  active"
                                    data-toggle="tab" data-target="#tabPaneGrid"
                                    role="tab" aria-controls="tabPaneGrid" aria-selected="true">
                                   <span class="fe fe-grid"></span>
                            </button>

                        </div>
                    </div>
                </div>
            </div>
            <!-- Row -->
                  <div class="row">
                      <div class="offset-xl-3 col-xl-6 offset-lg-2 col-lg-8 col-md-12 col-12">
                          <!-- Card -->
                          <div class="card mb-4">
                              <!-- Card header -->
                              <div class="card-header">
                                  <h4 class="mb-0">Volume SMS</h4>
                              </div>
                              <!-- Card body -->
                              <div class="card-body">
                                  <!-- Form -->
                                  {{SMSVolume()}}
                              </div>
                          </div>


                      </div>
                  </div>
          <!-- Container fluid -->

        </div>
            <!-- Container fluid -->

        </div>
        <!-- Page Content -->
    </div>
@include('layouts.footer')

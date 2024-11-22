<?php
//Total nouvelles commandes
$comd = ReadComd(0);
$nvCmd = count($comd);
//Total  courses en publiées
$course = ReadCours(0);
$nbcrs = count($course);
//Total clients
$clients = userAll();
$nbcl = count($clients);
//Total transporteur
$transp = ReadTransp(1);
$nbtp = count($transp);
?>
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

            <!-- Container fluid::Tableau de bord -->
            <div class="container-fluid p-4">
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-12">
                        <div class="border-bottom pb-4 mb-4 d-lg-flex justify-content-between align-items-center">
                            <div>
                                <h1 class="mb-0 h2 font-weight-bold">Tableau de bord</h1>
                            </div>
                            <div class="d-flex">

                                <a href="/" class="btn btn-warning">Commencer</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xl-3 col-lg-6 col-md-12 col-12">
                        <!-- Card -->
                        <div class="card mb-4">
                            <!-- Card body -->
                            <div class="card-body">
                                <div class="d-flex align-items-center justify-content-between mb-3 lh-1">
                                  <a href="new_commande">
                                    <div>
                                        <span class="font-size-xs text-uppercase font-weight-semi-bold">En cours</span>
                                    </div>
                                  </a>
                                    <div>
                                        <span class="fe fe-shopping-bag font-size-lg text-primary"></span>
                                    </div>
                                </div>
                                <h2 class="font-weight-bold mb-1">
                                    {{$nvCmd}}
                                </h2>
                                <span class="text-success font-weight-semi-bold">
                                    <i class="fe fe-trending-up mr-1"></i>{{$nvCmd}}</span>
                                <span class="ml-1 font-weight-medium">Commandes</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-lg-6 col-md-12 col-12">
                        <!-- Card -->
                        <div class="card mb-4">
                            <!-- Card body -->
                            <div class="card-body">
                                <div class="d-flex align-items-center justify-content-between mb-3 lh-1">
                                    <div>
                                      <a href="course_pub">
                                        <span class="font-size-xs text-uppercase font-weight-semi-bold">Courses</span>
                                      </a>
                                    </div>
                                    <div>
                                        <span class=" fe fe-book-open font-size-lg text-primary"></span>
                                    </div>
                                </div>
                                <h2 class="font-weight-bold mb-1">
                                    {{$nbcrs}}
                                </h2>
                                <span class="text-danger font-weight-semi-bold">{{$nbcrs}}</span>
                                <span class="ml-1 font-weight-medium">courses publiées</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-lg-6 col-md-12 col-12">
                        <!-- Card -->
                        <div class="card mb-4">
                            <!-- Card body -->
                            <div class="card-body">
                                <div class="d-flex align-items-center justify-content-between mb-3 lh-1">
                                    <div>
                                      <a href="clients_liste">
                                        <span class="font-size-xs text-uppercase font-weight-semi-bold">Clients</span>
                                      </a>
                                    </div>
                                    <div>
                                        <span class=" fe fe-users font-size-lg text-primary"></span>
                                    </div>
                                </div>
                                <h2 class="font-weight-bold mb-1">
                                    {{$nbcl}}
                                </h2>
                                <span class="text-success font-weight-semi-bold"><i class="fe fe-trending-up mr-1"></i>{{$nbcl}}</span>
                                <span class="ml-1 font-weight-medium">clients</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-lg-6 col-md-12 col-12">
                        <!-- Card -->
                        <div class="card mb-4">
                            <!-- Card body -->
                            <div class="card-body">
                                <div class="d-flex align-items-center justify-content-between mb-3 lh-1">
                                    <div>
                                      <a href="transp_valide">
                                        <span class="font-size-xs text-uppercase font-weight-semi-bold">Transporteurs</span>
                                      </a>
                                    </div>
                                    <div>
                                        <span class=" fe fe-truck  font-size-lg text-primary"></span>
                                    </div>
                                </div>
                                <h2 class="font-weight-bold mb-1">
                                    {{$nbtp}}
                                </h2>
                                <span class="text-success font-weight-semi-bold"><i class="fe fe-trending-up mr-1"></i>{{$nbtp}}</span>
                                <span class="ml-1 font-weight-medium">transporteurs</span>
                            </div>
                        </div>
                    </div>
                </div>


            </div>
            <!-- Container fluid -->

        </div>
        <!-- Page Content -->
    </div>

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
                                Clients bloqués
                                <span class="font-size-sm text-muted">(1202)</span>
                            </h1>
                            <!-- Breadcrumb  -->
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item">
                                        <a href="dashboard">Dashboard</a>
                                    </li>
                                    <li class="breadcrumb-item"><a href="#!">Clients</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">
                                        bloqués
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
            <div class="row">
                <div class="col-lg-12 col-md-12 col-12">
                    <!-- Tab -->
                    <div class="tab-content">
                        <!-- Tab pane -->
                        <div class="tab-pane fade show active" id="tabPaneGrid" role="tabpanel" aria-labelledby="tabPaneGrid">
                            <div class="mb-4">
                                <!-- Form -->
                                <form class="d-flex align-items-center col-12 col-md-12 col-lg-12">
                                    <div class="col-lg-6">
                                            <select id="selectOne" class="form-control">
                                             <option>Filtre de recherche</option>
                                             <option>Code client</option>
                                             <option>Nom client</option>
                                             <option>Prénom client</option>
                                             <option>Date inscription</option>
                                             <option>Client tel</option>
                                            </select>
                                    </div>

                                    <div class="col-lg-6">
                                     <input type="search" class="form-control pl-6" placeholder="Valeur"/>
                                    </div>

                                </form>
                            </div>
                            <div class="row">
                                <div class="col-xl-3 col-lg-6 col-md-6 col-12">
                                    <!-- Card -->
                                    <div class="card mb-4">
                                        <!-- Card body -->
                                        <div class="card-body">
                                            <div class="text-center">
                                                <img src="../../assets/images/avatar/avatar-11.jpg" class="rounded-circle avatar-xl mb-3" alt="" />
                                                <h4 class="mb-0">Kouame NGUES</h4>
                                                <p class="mb-0"><b>Nom: Kouame</b></p>
                                                <p class="mb-0"><b>Prénom: Ngues</b></p>
                                                <p class="mb-0"><b>Inscrit le 11/01/2021</b></p>
                                                <p><span class="text-dark">
                                                    <span class="badge badge-success" type="button" data-toggle="modal" data-target="#exampleModalLong">
                                                        Activer
                                                      </span>
                                                </span></p>
                                            </div>


                                            <div class="d-flex justify-content-between border-bottom py-2 mt-4">
                                                <span>Code Client</span>
                                                <span class="text-dark">cl0012</span>
                                            </div>
                                            <div class="d-flex justify-content-between border-bottom py-2">
                                                <span>Tel</span>
                                                <span class="text-dark">
                                                 0102205211
                                                </span>
                                            </div>
                                            <div class="d-flex justify-content-between pt-2">
                                                <span>Mot de passe</span>
                                                <span class="text-dark"> ki002158 </span>
                                            </div>
                                            <div class="d-flex justify-content-between pt-2">
                                                <span>Statut</span>
                                                <span class="text-dark">
                                                    <span class="badge badge-danger" type="button" data-toggle="modal" data-target="#exampleModalLong">
                                                        bloqué
                                                      </span>
                                                </span>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
            <!-- Container fluid -->

        </div>
        <!-- Page Content -->
    </div>
@include('layouts.footer')

<?php
$clients = userAll();
$nbcl = count($clients);
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
                                Clients actifs
                                <span class="font-size-sm text-muted">({{$nbcl}})</span>
                            </h1>
                            <!-- Breadcrumb  -->
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item">
                                        <a href="dashboard">Dashboard</a>
                                    </li>
                                    <li class="breadcrumb-item"><a href="#!">Clients</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">
                                        Actifs
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
            <div class="row ">
                <div class="col-lg-12 col-md-12 col-12">
                    <!-- Tab -->
                    <div class="tab-content">
                        <!-- Tab pane -->
                        <div class="tab-pane fade show active" id="tabPaneGrid" role="tabpanel" aria-labelledby="tabPaneGrid">
                            <div class="mb-4">
                                <!-- Form -->
                                <form class="d-flex align-items-center col-12 col-md-12 col-lg-12">
                                    <div class="col-lg-6">
                                            <select id="selectOne" class="form-control clients">
                                             <option>Filtre de recherche</option>
                                             <option value="tel">Tel client</option>
                                             <option value="nom">Nom client</option>
                                             <option value="prenom">Prénom client</option>
                                             <option value="created_at">Date inscription</option>
                                            </select>
                                    </div>

                                    <div class="col-lg-6">
                                     <input type="search" class="form-control pl-6 valSeaUs" placeholder="Valeur"/>
                                    </div>

                                </form>
                            </div>

                            <div class="row clientL">
                              @foreach ($clients as $key => $value)
                                <div class="col-xl-3 col-lg-6 col-md-6 col-12">
                                    <!-- Card -->
                                    <div class="card mb-4">
                                        <!-- Card body -->
                                        <div class="card-body">
                                            <div class="text-center">
                                                <img src="{{$value->profile}}" class="rounded-circle avatar-xl mb-3" alt="" />
                                                <h4 class="mb-0">{{$value->nom}} {{$value->prenom}}</h4>
                                                <p class="mb-0"><b>Nom: {{$value->nom}}</b></p>
                                                <p class="mb-0"><b>Prénom: {{$value->prenom}}</b></p>
                                                <p class="mb-0"><b>Inscrit le {{$value->created_at}}</b></p>
                                            </div>

                                            <div class="d-flex justify-content-between border-bottom py-2">
                                                <span>Tel</span>
                                                <span class="text-dark">
                                                 {{$value->tel}}
                                                </span>
                                            </div>
                                            <div class="d-flex justify-content-between pt-2">
                                                <span>Mot de passe</span>
                                                <span class="text-dark"> {{$value->password}} </span>
                                            </div>
                                            <div class="d-flex justify-content-between pt-2">
                                                <span>Statut</span>
                                                <span class="text-dark">
                                                    <span class="badge badge-success" type="button" data-toggle="modal" data-target="#exampleModalLong">
                                                        Actif
                                                      </span>
                                                </span>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                              @endforeach

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
<script type="text/javascript">
//Filtre de Recherche client
$('.valSeaUs').keyup(function(){
  var valeur = $(this).val();
  var attribut = $('.clients').children("option:selected").val();
  var data = {attribut:attribut,valeur:valeur};
  if (valeur=='') {
    window.location="clients_liste";
  }else{
    $.ajax({
       url:'searchCl',
       method:'GET',
       data:data,
       dataType:'html',
       success:function(data){
         $('.clientL').html(data);
       },
       error:function(data){
         console.log("error");
       }
    });
  }
});
</script>

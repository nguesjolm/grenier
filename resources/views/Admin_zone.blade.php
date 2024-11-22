<?php
$zone = ReadZone();
$nb = count($zone);
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
                                Gestion des zones
                                <span class="font-size-sm text-muted">({{$nb}})</span>
                            </h1>
                            <!-- Breadcrumb  -->
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item">
                                        <a href="dashboard">Dashboard</a>
                                    </li>
                                    <li class="breadcrumb-item"><a href="#!">Zones</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">

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
                                <form class="d-flex align-items-center col-12 col-md-12 col-lg-12" action="addZ" method="get">
                                    <div class="col-lg-6">
                                       <div class="form-group">
                                        <input type="text" class="form-control form-control-sm" name="zone" placeholder="Nom de la zone" required>
                                       </div>
                                    </div>

                                    <div class="col-lg-6">
                                     <button type="submit" class="btn btn-warning btn-sm">Ajouter</button>
                                    </div>

                                </form>
                            </div>
                            <div class="row">


                                      @foreach ($zone as $key => $value)
                                      <div class="col-xl-3 col-lg-6 col-md-6 col-12">
                                        <!-- Card -->
                                        <div class="card mb-4">
                                        <!-- Card body -->
                                        <div class="card-body">
                                            <div class="d-flex justify-content-between border-bottom py-2 mt-4">
                                                <span>Zone</span>
                                                <span class="text-primary">{{$value->nom}}</span>
                                            </div>
                                            <div class="d-flex justify-content-between border-bottom py-2">
                                                <span>Action</span>
                                                <span class="text-dark">
                                                   <span class="badge badge-info edit" id="{{$value->id}}" nom="{{$value->nom}}"><i class="fe fe-edit font-size-lg text-white"></i></span>
                                                   <span class="badge badge-danger sup" id="{{$value->id}}" nom="{{$value->nom}}"><i class="fe fe-trash font-size-lg text-white"></i></span>
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

    <!-- Modal de Réservation -->
    <div class="modal fade" id="exampleModalLong" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLongTitle">Modification</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
                <div class="row align-items-center no-gutters">
                  <b>Mise à jour des villes</b>
                </div><hr>
                <div class="form-group">
                  <label class="input-label" for="textInput">Point d'arrêt</label>
                  <input type="text" id="textInput" class="form-control arret"placeholder="">
                </div>
                <input type="hidden" class="idZn">
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary annulBtn" data-dismiss="modal">Annuler</button>
            <button type="button" class="btn btn-warning up">Modifier</button>
          </div>
        </div>
      </div>
    </div>


@include('layouts.footer')
<script type="text/javascript">
//Suppression de l'exportation
   $('.sup').click(function(){
      var code = $(this).attr('nom');
      var id   = $(this).attr('id');
      var data = {id:id,code:code};
      Swal.fire({
           title: 'SUPPRESSION DES ZONES',
           text: "Voulez-vous Supprimer la zone "+code+" ?",
           icon: 'error',
           showCancelButton: true,
           confirmButtonColor: '#3085d6',
           cancelButtonColor: '#d33',
           cancelButtonText: 'non',
           confirmButtonText: 'oui , supprimé!',
           backdrop: `rgba(240,15,83,0.4)`
         }).then((result)=>{
             if (result.value) {
                $.ajax({
                  url:'DelZn',
                  method:'GET',
                  data:data,
                  dataType:'json',
                   success:function(data){
                    if (data.code==2) {
                     Swal.fire({
                       position: 'top-end',
                       icon: 'success',
                       title: "La zone "+code+' a été supprimée avec succès',
                       showConfirmButton: false,
                       timer: 1500
                     });
                     window.location="zone";
                    }
                   },
                   error:function(data){
                      console.log(data);
                   }
                });
             }
         });
   });

// Modal de modification
$('.edit').click(function(){
  var code = $(this).attr('nom');
  var id   = $(this).attr('id');
  var data = {id:id,code:code};
  $('.arret').val(code);
  $('.idZn').val(id);
  $("#exampleModalLong").modal('show');
});

$('.up').click(function(){
  var zone = $('.arret').val();
  var id   = $('.idZn').val();
  var data = {code:zone,id:id};
  console.log(data);
  $.ajax({
    url:'UpZn',
    method:'GET',
    data:data,
    dataType:'json',
     success:function(data){
      if (data.code==2) {
       Swal.fire({
         position: 'top-end',
         icon: 'success',
         title: "La zone "+zone+' a été modifiée avec succès',
         showConfirmButton: false,
         timer: 1500
       });
       window.location="zone";
      }
     },
     error:function(data){
        console.log(data);
     }
  });
});


</script>

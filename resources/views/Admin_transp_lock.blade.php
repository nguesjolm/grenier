<?php
$transp = ReadTransp(2);
$nbtp = count($transp);
//dd($transp);
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
                                Compte Transporteurs rejetés
                                <span class="font-size-sm text-muted">({{$nbtp}})</span>
                            </h1>
                            <!-- Breadcrumb  -->
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item">
                                        <a href="dashboard">Dashboard</a>
                                    </li>
                                    <li class="breadcrumb-item"><a href="#!">Compte transporteurs</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">
                                        Demande
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
                                            <select id="selectOne" class="form-control transp">
                                             <option>Filtre de recherche</option>
                                             <option value="nomT">Nom Transp.</option>
                                             <option value="prenomT">Prénom Transp.</option>
                                             <option value="telT">Tél Transp.</option>
                                             <option value="matrT">Matricule Veh.</option>
                                            </select>
                                    </div>

                                    <div class="col-lg-6">
                                     <input type="search" class="form-control pl-6 valsearch" placeholder="Valeur"/>
                                    </div>

                                </form>
                            </div>
                            <div class="row transport">
                              @foreach ($transp as $key => $value)
                                @if ($value->statut==2)
                                <div class="col-xl-3 col-lg-6 col-md-6 col-12">
                                    <!-- Card -->
                                    <div class="card mb-4">
                                        <!-- Card body -->
                                        <div class="card-body">

                                            <div class="text-center">
                                                <h4 class="mb-0">{{$value->nom.' '.$value->prenom}}</h4>
                                                <p class="mb-0">Nom: <b>{{$value->nom}}</b></p>
                                                <p class="mb-0">Prénom: <b>{{$value->prenom}}</b></p>
                                                <p class="mb-0">Matricule: <b>{{$value->matricule}}</b></p>
                                                <p class="mb-0">Tel: <b>{{$value->tel}}</b></p>
                                                <p class="mb-0">Pass: <b>{{$value->password}}</b></p>
                                                <p class="mb-0">crée le {{$value->created_at}}</p>
                                            </div>

                                            <div class="d-flex justify-content-between pt-2">
                                                <span class="text-dark">
                                                    <span class="badge badge-success valid"
                                                          id="{{$value->transpID}}"
                                                          nom="{{$value->tel}}"
                                                          nm="{{$value->nom}}"
                                                          pass="{{$value->password}}"
                                                          type="button" data-toggle="modal"
                                                          data-target="#exampleModalLong">
                                                        valider
                                                    </span>
                                                </span>

                                                <span class="badge badge-danger rejete"
                                                      id="{{$value->transpID}}"
                                                      nom="{{$value->tel}}"
                                                      pass="{{$value->password}}"
                                                      type="button" data-toggle="modal"
                                                      data-target="#exampleModalLong">
                                                refuser
                                               </span>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                                @endif
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
 //Valider la demande
 $('.valid').click(function(){
   var code = $(this).attr('nom');
   var id   = $(this).attr('id');
   var nm   = $(this).attr('nm');
   var pass = $(this).attr('pass');
   var data = {id:id,code:code,nm:nm,pass:pass};
   console.log(data);
   Swal.fire({
        title: 'Transporteur',
        text: 'Voulez-vous valider la demande du '+code+' ?',
        icon: 'error',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        cancelButtonText: 'non',
        confirmButtonText: 'oui , validée!',
        backdrop: `rgba(240,15,83,0.4)`
      }).then((result)=>{
          if (result.value) {
             $.ajax({
               url:'ValDemd',
               method:'GET',
               data:data,
               dataType:'json',
                success:function(data){
                 if (data.code==2) {
                  Swal.fire({
                    position: 'top-end',
                    icon: 'success',
                    title: 'La demande '+code+' a été validée avec succès',
                    showConfirmButton: false,
                    timer: 1500
                  });
                  window.location='transp_lock';
                 }
                 if (data.code==2) {
                  Swal.fire({
                    position: 'top-end',
                    icon: 'success',
                    title: 'La demande '+code+' a été validée avec succès',
                    showConfirmButton: false,
                    timer: 1500
                  });
                  window.location='transp_lock';
                 }
                 if (data.code==1) {
                   Swal.fire({
                     position: 'top-end',
                     icon: 'error',
                     title: 'Votre volume SMS est insuffisant',
                     showConfirmButton: false,
                     timer: 5000
                   });
                   window.location='transp_lock';
                 }
                },
                error:function(data){
                   console.log(data);
                }
             });
          }
      });
 });


 //Rejete la demande
 $('.rejete').click(function(){
   var code = $(this).attr('nom');
   var id   = $(this).attr('id');
   var data = {id:id,code:code};
   console.log(data);
   Swal.fire({
        title: 'Transporteur',
        text: "Voulez-vous rejeter la demande du "+code+" ?",
        icon: 'error',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        cancelButtonText: 'non',
        confirmButtonText: 'oui , rejetée!',
        backdrop: `rgba(240,15,83,0.4)`
      }).then((result)=>{
          if (result.value) {
             $.ajax({
               url:'RejtDemd',
               method:'GET',
               data:data,
               dataType:'json',
                success:function(data){
                 if (data.code==2) {
                  Swal.fire({
                    position: 'top-end',
                    icon: 'success',
                    title: "La demande "+code+' a été rejetée avec succès',
                    showConfirmButton: false,
                    timer: 1500
                  });
                  window.location="transp_lock";
                 }
                },
                error:function(data){
                   console.log(data);
                }
             });
          }
      });
 });

 //Filtre de recherche
 $('.valsearch').keyup(function(){
   var valeur = $(this).val();
   var attribut = $('.transp').children("option:selected").val();
   var data = {attribut:attribut,valeur:valeur};
   console.log(data);
   if (valeur=="") {
     window.location="transp_lock";
   }else{
     $.ajax({
       url:'SearchDemdno',
       method:'GET',
       data:data,
       dataType:'html',
        success:function(data){
          console.log(data);
          $('.transport').html(data);
        },
        error:function(data){
           console.log(data);
        }
     });
   }

 });


</script>

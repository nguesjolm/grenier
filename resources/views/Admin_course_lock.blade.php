<?php
$course = ReadCours(1);
$nbcrs = count($course);
//dd($course);
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
                                Courses bloquées
                                <span class="font-size-sm text-muted">({{$nbcrs}})</span>
                            </h1>
                            <!-- Breadcrumb  -->
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item">
                                        <a href="dashboard">Dashboard</a>
                                    </li>
                                    <li class="breadcrumb-item"><a href="#!">Courses</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">
                                        bloquées
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
                                            <select id="selectOne" class="form-control courses">
                                             <option>Filtre de recherche</option>
                                             <option value="code">Code Course.</option>
                                             <option value="created_at">Date publication</option>
                                             <option value="placedispo">Place dispo.</option>
                                             <option value="montant">Coût/place</option>
                                             <option value="tel">Tél. Transp</option>
                                            </select>
                                    </div>

                                    <div class="col-lg-6">
                                     <input type="search" class="form-control pl-6 valsearch" placeholder="Valeur"/>
                                    </div>

                                </form>
                            </div>
                            <div class="row coursesT">
                              <?php
                              $today = date('Y-m-d');
                              foreach ($course as $key => $value){
                                     if ($value->etat==1){

                                       // if ($value->fin>=$today) {
                              ?>

                                <div class="col-xl-3 col-lg-6 col-md-6 col-12">
                                    <!-- Card -->
                                    <div class="card mb-4">
                                        <!-- Card body -->
                                        <div class="card-body">
                                            <div class="text-center">
                                                <img src="{{$value->vehicule}}" class="rounded-circle avatar-xl mb-3" alt="" />
                                                <h4 class="mb-0">{{$value->nomT}} {{$value->prenomT}}</h4>
                                                <p class="mb-0">Nom: <b>{{$value->nomT}}</b></p>
                                                <p class="mb-0">Prénom: <b>{{$value->prenomT}}</b></p>
                                                {{-- <p class="mb-0">Code: <b>{{$value->prenomT}}</b></p> --}}
                                                <p class="mb-0">Tel: <b>{{$value->telT}}</b></p>
                                                <p class="mb-0">Fin: <b>{{$value->fin}}</b></p>
                                                <p class="mb-0"><b>Publié le {{$value->created_at}}</b></p>
                                                <p class="mb-0">
                                                    <span class="badge badge-success lock"
                                                          code = {{$value->code}}
                                                          id="{{$value->offID}}"
                                                          tel="{{$value->telT}}"
                                                          type="button" data-toggle="modal"
                                                          data-target="#exampleModalLong">
                                                    débloquer
                                                   </span>
                                                </p>
                                            </div>

                                            <div class="d-flex justify-content-between border-bottom py-2 mt-4">
                                                <span>Code</span>
                                                <span class="text-primary">{{$value->code}}</span>
                                            </div>

                                            <div class="d-flex justify-content-between border-bottom py-2 mt-4">
                                                <span>Trajet</span>
                                                <span class="text-primary">{{ReadVille($value->depart)}}-{{ReadVille($value->arrive)}}</span>
                                            </div>

                                            <div class="d-flex justify-content-between border-bottom py-2">
                                                <span>Place dispo</span>
                                                <span class="text-primary">
                                                 <b>{{$value->placedispo}}</b>
                                                </span>
                                            </div>
                                            <div class="d-flex justify-content-between border-bottom py-2">
                                                <span>Coût</span>
                                                <span class="text-primary">
                                                 <b>{{$value->montant}} fcfa / place</b>
                                                </span>
                                            </div>
                                            <div class="d-flex justify-content-between  pt-2">
                                                <span>Unité</span>
                                                <span class="text-dark"> {{ReadUnites($value->unite)}} </span>
                                            </div>




                                        </div>
                                    </div>
                                </div>

                            <?php //}
                               }
                             }?>
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
<script type='text/javascript'>
//Bloquer la course publiée
$('.lock').click(function(){
  var id = $(this).attr('id');
  var tel = $(this).attr('tel');
  var code = $(this).attr('code');
  var data = {id:id,tel:tel,code:code};
  console.log(data);
  Swal.fire({
       title: 'Transporteur',
       text: 'Voulez-vous débloquer l\'offre '+code+' ?',
       icon: 'error',
       showCancelButton: true,
       confirmButtonColor: '#3085d6',
       cancelButtonColor: '#d33',
       cancelButtonText: 'non',
       confirmButtonText: 'oui , débloquer!',
       backdrop: `rgba(240,15,83,0.4)`
     }).then((result)=>{
         if (result.value) {
            $.ajax({
              url:'lockOn',
              method:'GET',
              data:data,
              dataType:'json',
               success:function(data){
                if (data.code==2) {
                 Swal.fire({
                   position: 'top-end',
                   icon: 'success',
                   title: 'La course '+code+' a été bloquée avec succès',
                   showConfirmButton: false,
                   timer: 1500
                 });
                 window.location='course_lock';
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
  var attribut = $('.courses').children("option:selected").val();
  var data = {attribut:attribut,valeur:valeur};
  console.log(data);
  $.ajax({
     url:'searchCourseLck',
     data:data,
     dataType:'html',
     success:function(data){
       $('.coursesT').html(data);
     },
     error:function(data){
       console.log('error');
     }
  });
});

</script>

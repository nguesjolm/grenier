<?php
$comd = ReadComd(1);
//dd($comd);
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

            <!-- Container fluid::Nouvelle commande -->
            <div class="container-fluid p-4">
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-12">
                        <!-- Page Header -->
                        <div class="border-bottom pb-4 mb-4 d-lg-flex align-items-center justify-content-between">
                            <div class="mb-2 mb-lg-0">
                                <h1 class="mb-1 h2 font-weight-bold">Commandes remboursées</h1>
                                <!-- Breadcrumb -->
                                <nav aria-label="breadcrumb">
                                    <ol class="breadcrumb">
                                        <li class="breadcrumb-item">
                                            <a href="dashboard">Tableau de bord</a>
                                        </li>
                                        <li class="breadcrumb-item">
                                            <a href="#!">Commandes</a>
                                        </li>
                                        <li class="breadcrumb-item active" aria-current="page">
                                            remboursées
                                        </li>
                                    </ol>
                                </nav>
                            </div>

                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-12">
                        <!-- Card -->
                        <div class="card rounded-lg">
                            <!-- Card header -->
                            <div class="card-header border-bottom-0 p-0 bg-white">
                                <div>
                                    <!-- Nav -->
                                    <ul class="nav nav-lb-tab" id="tab" role="tablist">
                                        <li class="nav-item">
                                            <a class="nav-link active" id="courses-tab" data-toggle="pill" href="#courses" role="tab" aria-controls="courses" aria-selected="true">Remboursées</a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div class="p-4 row">
                                <!-- Form -->
                                <form class="d-flex align-items-center col-12 col-md-12 col-lg-12">
                                    <div class="col-lg-6">
                                            <select id="selectOne" class="form-control command">
                                             <option>Filtre de recherche</option>
                                             <option value="code">Code commande</option>
                                            </select>
                                    </div>

                                    <div class="col-lg-6">
                                     <input type="search" class="form-control pl-6 valsearch" placeholder="valeur"/>
                                    </div>

                                </form>
                            </div>
                            <div>
                                <!-- Table -->
                                <div class="tab-content" id="tabContent">
                                    <!--Tab pane -->
                                    <div class="tab-pane fade show active" id="courses" role="tabpanel" aria-labelledby="courses-tab">
                                        <div class="table-responsive border-0 overflow-y-hidden">
                                            <table class="table mb-0 text-nowrap cmdNew">
                                                <thead>
                                                    <tr>
                                                        <th scope="col" class="border-0 text-uppercase">
                                                           Code
                                                        </th>
                                                        <th scope="col" class="border-0 text-uppercase">
                                                            Courses
                                                        </th>
                                                        <th scope="col" class="border-0 text-uppercase">
                                                            CLIENT
                                                        </th>
                                                        <th scope="col" class="border-0 text-uppercase">
                                                            DATE
                                                        </th>
                                                        <th scope="col" class="border-0 text-uppercase">
                                                            STATUS
                                                        </th>
                                                        <th scope="col" class="border-0 text-uppercase">
                                                            ACTION
                                                        </th>
                                                        <th scope="col" class="border-0 text-uppercase"></th>
                                                    </tr>
                                                </thead>
                                                <tbody class="">
                                                  @foreach ($comd as $key => $value)
                                                    @if ($value->statut==2)
                                                      <tr>
                                                          <td class="align-middle border-top-0">
                                                              <h4><b class="text-danger">{{$value->cmdCode}}</b></h4>
                                                          </td>

                                                          <td class="border-top-0">
                                                              <a href="#!" class="text-inherit">
                                                                  <div class="d-lg-flex align-items-center">
                                                                      <div>
                                                                          <img src="{{$value->vehicule}}" alt="" class="img-4by3-lg rounded" />
                                                                      </div>
                                                                      <div class="ml-lg-3 mt-2 mt-lg-0">
                                                                          <h4 class="mb-1">
                                                                              <span class="text-primary">{{ReadVille($value->depart)}} - {{ReadVille($value->arrive)}}</span><br>
                                                                              <span>Arrêt: </span> {{$value->arret}} <br>
                                                                              <span>Coût:</span> {{$value->montant}} fcfa / place
                                                                          </h4>
                                                                          <span class="text-success">Commandes:</span> {{$value->qte}} places<br>
                                                                          <span class="text-success">Montant payé:</span> {{$value->qte*$value->montant}} fcfa<br>
                                                                          <a href="#" class="badge badge-warning infoTransp"
                                                                          id="{{$value->offre_transporteur_id}}">
                                                                              infos transporteur
                                                                          </a>
                                                                      </div>
                                                                  </div>
                                                              </a>
                                                          </td>

                                                          <td class="align-middle border-top-0">
                                                              <div class="d-flex align-items-center">
                                                                  {{userNom($value->user_id)}} -
                                                                  {{userTel($value->user_id)}}
                                                              </div>
                                                          </td>
                                                          <td class="align-middle border-top-0">
                                                              <span class="bg-warning mr-1 d-inline-block align-middle"></span>{{$value->cdd}}
                                                          </td>
                                                          <td class="align-middle border-top-0">
                                                              <span class="badge-dot bg-success mr-1 d-inline-block align-middle"></span>
                                                              <span class="text-success">livrée</span>
                                                          </td>
                                                          <td class="align-middle border-top-0">
                                                            @if ($value->statut=='2')
                                                              <span class="text-danger">remboursée</span>
                                                            @else
                                                              <a href="#!" class="btn btn-outline-warning btn-sm solder" id="{{$value->cmdCode}}">
                                                              solder
                                                              </a>
                                                            @endif

                                                          </td>

                                                      </tr>
                                                    @endif

                                                  @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- Card Footer -->
                            <div class="card-footer">
                            </div>
                        </div>
                        <!-- Modal infos transporteur -->
                        <div class="modal fade" id="exampleModalLong" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
                          <div class="modal-dialog modal-dialog-centered" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                  <h5 class="modal-title" id="exampleModalLongTitle">Réserver</h5>
                                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                  </button>
                                </div>
                                <div class="modal-body">
                                      <div class="row align-items-center no-gutters">
                                          <div class="col-auto">
                                           <img class="rounded-circle avatar-xl profile" alt="">
                                          </div>
                                          <div class="col ml-2">
                                           <span class="text-warning">Transporteur : </span>
                                           <span class="nomTp"></span><br>
                                           <span class="text-warning">Tel : </span>
                                           <span><b class="telTp"></b></span><br>
                                           <span class="text-warning">Matricule : </span>
                                           <span class="matricule"></span><br>
                                           {{-- <span><b>1000 fcfa / place</b></span><br>
                                           <span>Unité : Carton</span> --}}
                                          </div>
                                      </div>
                                </div>
                                <div class="modal-footer">
                                  <button type="button" class="btn btn-warning" data-dismiss="modal">ok</button>
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
<script type="text/javascript">

//Valeur de Recherhce
$('.valsearch').keyup(function(){
  var valeur = $(this).val();
  var attribut = $('.command').children("option:selected").val();
  var data = {attribut:attribut,valeur:valeur};
  console.log(data);
  if (valeur=='') {
    window.location="rembourse_commande";
  } else {
    $.ajax({
      url:'searchCmdRemb',
      method:'GET',
      data:data,
      dataType:'html',
      success:function(data){
        $('.cmdNew').html(data);
      },
      error:function(data){
        console.log(data);
      }
    });
  }

});

//Infos du transporteur
$(".infoTransp").click(function(){
  var idTrasp = $(this).attr("id");
  var data = {tranp:idTrasp}
  console.log("tranp:"+idTrasp);
  $.ajax({
     url:"readTranspID",
     data:data,
     method:"GET",
     dataType:"json",
     success:function(data){
        var nom = data.nomT+" "+data.prenomT;
        $(".profile").attr("src",data.profile);
        $(".nomTp").text(nom);
        $(".telTp").text(data.telT);
        $(".matricule").text(data.matricule);
        $("#exampleModalLong").modal("show");
     },
     error:function(data){console.log(data);}
  });

});

//Boutton solder
$(".solder").click(function(){
  var id = $(this).attr("id");
  var data = {id:id};
  Swal.fire({
       title: "Transporteur",
       text: "Voulez-vous solder la commande du "+id+" ?",
       icon: "error",
       showCancelButton: true,
       confirmButtonColor: "#3085d6",
       cancelButtonColor: "#d33",
       cancelButtonText: "non",
       confirmButtonText: "oui , soldée!",
       backdrop: `rgba(240,15,83,0.4)`
     }).then((result)=>{
        if (result.value) {
          $.ajax({
            url:"UpdComdSolde",
            method:"GET",
            data:data,
            dataType:"json",
            success:function(data){
              if (data.code==2){
                Swal.fire({
                  position: "top-end",
                  icon: "success",
                  title: "La commande "+id+" a été soldée avec succès",
                  showConfirmButton: false,
                  timer: 1500
                });
                window.location="livre_commande";
              }
            },
            error:function(data){
              console.log(data);
            }
          });
        }
     });
});

//Boutton Rembourser rembourser
$(".rembourser").click(function(){
  var id = $(this).attr("id");
  var data = {id:id};
  Swal.fire({
       title: "Transporteur",
       text: "Voulez-vous rembourser la commande du "+id+" ?",
       icon: "error",
       showCancelButton: true,
       confirmButtonColor: "#3085d6",
       cancelButtonColor: "#d33",
       cancelButtonText: "non",
       confirmButtonText: "oui , remboursée!",
       backdrop: `rgba(240,15,83,0.4)`
     }).then((result)=>{
        if (result.value) {
          $.ajax({
            url:"UpdComdRemb",
            method:"GET",
            data:data,
            dataType:"json",
            success:function(data){
              if (data.code==2){
                Swal.fire({
                  position: "top-end",
                  icon: "success",
                  title: "La commande "+id+" a été remboursée avec succès",
                  showConfirmButton: false,
                  timer: 1500
                });
                window.location="livre_commande";
              }
            },
            error:function(data){
              console.log(data);
            }
          });
        }
     });
});


</script>

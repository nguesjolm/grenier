<?php
#Les offres publiées
  $off = ReadOf(0);
  $nbof = count($off);
#Simulation de reservation

?>
  <!-- Page Content -->
    <div class="bg-warning">
        <div class="container">
            <!-- Hero Section -->
            <div class="row align-items-center no-gutters">
                <div class="col-xl-5 col-lg-6 col-md-12">
                    <div class="py-5 py-lg-0">
                        <h1 class="text-white display-4 font-weight-bold">
                          Akwaba sur LE GRENIER
                        </h1>
                        <p class="text-secondary-50 mb-4 lead">
                            Transporte facilement tes produits vivriers<br>
                            <span>Appelez au : 225 01 02 20 52 11</span><br>
                            <span>infos@grenier.ci</span><br>
                        </p>

                        <a href="transporteur" class="btn btn-success">Devenir Transporteur</a>
                        @if (isset($_SESSION['tel']) AND !empty($_SESSION['tel']))
                          <a href="mon_comptes" class="btn btn-white">{{$_SESSION['nom'].' '.$_SESSION['prenom']}}</a>
                        @else
                          <a href="sign" class="btn btn-white">Se connecter</a>
                        @endif

                    </div>
                </div>
                <div class=" col-xl-7 col-lg-6 col-md-12 text-lg-right text-center">
                    <img src="assets/images/hero/hero-img.png" alt="" class="img-fluid" />
                </div>
            </div>
        </div>
    </div>

    <!-- Sous-titre -->
    <div class="bg-white py-4 shadow-sm">
        <div class="container">
            <div class="row align-items-center no-gutters">
                <!-- Features -->
                <div class="col-xl-4 col-lg-4 col-md-6 mb-lg-0 mb-4">
                    <div class="d-flex align-items-center">
                        <span class="icon-sahpe icon-lg bg-light-warning rounded-circle text-center text-dark-warning font-size-md ">
                          <i class="fe fe-truck"></i>
                        </span>
                        <div class="ml-3">
                            <h4 class="mb-0 font-weight-semi-bold">plus de 100 transporteurs</h4>
                            <p class="mb-0">Des vehicules convenables</p>
                        </div>
                    </div>
                </div>
                <!-- Features -->
                <div class="col-xl-4 col-lg-4 col-md-6 mb-lg-0 mb-4">
                    <div class="d-flex align-items-center">
                        <span class="icon-sahpe icon-lg bg-light-warning rounded-circle text-center text-dark-warning font-size-md ">
                          <i class="fe fe-headphones"> </i></span>
                        <div class="ml-3">
                            <h4 class="mb-0 font-weight-semi-bold">Disponibilité</h4>
                            <p class="mb-0">24h/24 - 7j/7</p>
                        </div>
                    </div>
                </div>
                <!-- Features -->
                <div class="col-xl-4 col-lg-4 col-md-12">
                    <div class="d-flex align-items-center">
                        <span class="icon-sahpe icon-lg bg-light-warning rounded-circle text-center text-dark-warning font-size-md "> <i
                class="fe fe-clock"> </i></span>
                        <div class="ml-3">
                            <h4 class="mb-0 font-weight-semi-bold">Rapidité</h4>
                            <p class="mb-0">Nous vous livrons vos produits à temps</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Filtrer  -->
    <div class="pt-lg-12 pb-lg-3 pt-8 pb-6">
        <div class="container">

            <div class="row mb-4">
                <div class="col">
                    <h2 class="mb-0">Recherche ton transporteur</h2>
                </div>
            </div>

            <div class="position-relative">
                <!-- Card -->
                <div class="card mb-4 ">
                    <!-- Card Body -->
                    <div class="card-body">
                     <form action="grenier_check#transpo" method="post">
                       @csrf
                        <div class="row">

                         <div class="col-lg-4">
                          <select class="selectpicker departSelect" name="departSelect" data-width="100%" required>
                            <option value="">Départ</option>
                            @foreach (ReadZone() as $value)
                            <option value="{{$value->id}}">{{$value->nom}}</option>
                            @endforeach
                          </select>
                         </div>

                         <div class="col-lg-4">
                          <select class="selectpicker arriveSelect" name="arriveSelect" data-width="100%" required>
                            <option value="">Arrivé</option>
                            @foreach (ReadZone() as $value)
                            <option value="{{$value->id}}">{{$value->nom}}</option>
                            @endforeach
                          </select>
                         </div>

                         <div class="col-lg-4">
                          <select class="selectpicker uniteSelect" name="uniteSelect" data-width="100%" required>
                            <option value="">Unité</option>
                            @foreach (ReadUnite() as $value)
                              <option value="{{$value->id}}">{{$value->unite}}</option>
                            @endforeach
                          </select>
                         </div>

                        </div>
                        <button type="submit" class="btn btn-success mt-3 grenierCheck">Rechercher</button>
                     </form>

                    </div>
                </div>
                    <!-- Card -->
            </div>


        </div>
    </div>

    <div class="pt-lg-12 pb-lg-3 pt-8 pb-6">
        <div class="container">

            <div class="row mb-4">
                <div class="col">
                    <h2 class="mb-0">Nos Tranporteurs</h2>
                </div>
            </div>

            <div class="position-relative">
                <ul class="controls " id="sliderFirstControls">
                    <li class="prev">
                        <i class="fe fe-chevron-left"></i>
                    </li>
                    <li class="next">
                        <i class="fe fe-chevron-right"></i>
                    </li>
                </ul>
                <div class="sliderFirst offresZone">

                   <?php
                      if ($nbof!=0) {
                        $today = date('Y-m-d');
                      foreach ($off as $key => $value){
                        if ($value->fin>=$today) {
                  ?>

                    <div class="item">
                        <!-- Card -->
                        <div class="card  mb-4 card-hover">
                            <a href="#" class="card-img-top">
                            <img src="{{$value->vehicule}}" alt="" class="rounded-top card-img-top">
                            </a>
                            <!-- Card Body -->
                            <div class="card-body">
                                <h4 class="mb-2 text-truncate-line-2 ">
                                  <a href="#" class="text-inherit text-warning">
                                    {{ReadVille($value->depart)}} - {{ReadVille($value->arrive)}}
                                  </a>
                                </h4>
                                <!-- List -->
                                <ul class="mb-3 list-inline">
                                    <li class="list-inline-item"><i class="far fa-clock mr-1"></i>{{$value->placedispo}} places</li>
                                </ul>
                                <div class="lh-1">
                                    <span class="text-warning">unité : </span>
                                    <span class="font-size-xs text-muted">{{ReadUnites($value->unite)}}</span>
                                </div>
                                <!-- Price -->
                                <div class="lh-1 mt-3">
                                    <span class="text-dark font-weight-bold">{{$value->montant}} fcfa / place</span>
                                    <!--<del class="font-size-xs text-muted">$750</del>-->
                                </div>
                            </div>
                            <!-- Card Footer -->
                            <div class="card-footer">
                                <div class="row align-items-center no-gutters">
                                    <div class="col-auto">
                                        <img src="{{$value->profile}}" class="rounded-circle avatar-xs" alt="">
                                    </div>
                                    <div class="col ml-2">
                                        <span>{{$value->nom." ".$value->prenom}}</span>
                                    </div>
                                    <div class="col-auto">
                                        <a href="#!" class="text-white  reserv" title="Réserver une place" id="{{$value->Ofid}}">
                                        <span class="badge badge-warning" type="button" class="btn btn-primary"
                                              data-toggle="modal" data-target="#exampleModalLong">
                                          Réserver
                                        </span>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <?php } }
                      }else{echo '<div class="alert alert-warning offresZone" role="alert">Aucun transporteur disponible !</div>';} ?>



                </div>
            </div>


        </div>
    </div>

<!-- Modal de Réservation -->
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
                 <img src="assets/images/avatar/avatar-1.jpg" class="rounded-circle avatar-xl profile" alt="">
                </div>
                <div class="col ml-2">
                 <span class="text-warning">Transporteur : </span>
                 <span class="transp">Touré Abou</span><br>
                 <span><b class="destin">Toumodi - Abidjan</b></span><br>
                 <span><span class="place">10</span> places disponible</span><br>
                 <span><b><span class="prix">1000</span> fcfa / place</b></span><br>
                 <span>Unité : <span class="unite"></span></span>
                </div>
            </div><hr>
            <div class="form-group">
              <label class="input-label" for="textInput">Point d'arrêt(où se trouve vos produits ?)</label>
              <input type="text" id="textInput" class="form-control arret"placeholder="Ex:Sikensi sur le tronçon Toumodi-Abidjan">
            </div>

            <div class="form-group">
              <label class="input-label" for="textInput">Quantité(Combien de places voulez-vous ?)</label>
              <input type="number" id="textInput" class="form-control qtecmd" placeholder="">
              <input type="hidden" class="idoff">
              <input type="hidden" class="idtransp">
              <input type="hidden" class="teltransp">
              <input type="hidden" class="uniteOf">
            </div>


            <div class="alert alert-warning" role="alert">
                Montant à payer : <span class="payer">00</span> fcfa
            </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary annulBtn" data-dismiss="modal">Annuler</button>
        <button type="button" class="btn btn-warning reservBtn">Réserver</button>
        <button id="bt_get_signature"style="display: none;"></button>

      </div>
    </div>
  </div>
</div>

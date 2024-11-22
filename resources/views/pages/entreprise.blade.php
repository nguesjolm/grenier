<?php
  #Liste des offres
  $offre = offre($_SESSION['id_user']);
  #Reservation en cours
  $res_new = reserv($_SESSION['id_user'],0);
  $resNew = count($res_new);
  #Reservation livrée
  $res_liv = reserv($_SESSION['id_user'],1);
  $resLiv = count($res_liv);
  #Id transporteur en fonction de l'user
  $transp = transpID($_SESSION['id_user']);
  #Livraisons en cours
  $liv_new = livr($transp,0);
  $nbLiv = count($liv_new);
  #Livraisons livrées
  $liv_sold = livr($transp,1);
  $nbLivS = count($liv_sold);
  #User
  // $tel = userTel(21);
  // dd($tel);
  //dd($liv_new);

 #today
 $today = date('Y-m-d');



?>
  <div class="pt-5">
    <div class="container">
      <div class="row align-items-center">
        <div class="col-xl-12 col-lg-12 col-md-12 col-12">
          <!-- Bg -->
          <div class=" pt-16 rounded-top " style="background: url(../assets/images/background/profile-bg.jpg) no-repeat; background-size: cover;">
          </div>
          <div
            class="d-flex align-items-end justify-content-between bg-white px-4  pt-2 pb-4 rounded-bottom shadow-sm ">
            <div class="d-flex align-items-center">
              <div class="mr-2 position-relative d-flex justify-content-end align-items-end mt-n5">
                <img src=@if ($_SESSION['profile']=='')
                          {{asset('assets/images/avatar/icon.png')}}
                         @else
                           "{{$_SESSION['profile']}}"
                         @endif
                     class="avatar-xl rounded-circle border-width-4 border-white"
                    alt="">
              </div>
              <div class="lh-1">
                <h2 class="mb-0">{{$_SESSION['nom'].' '.$_SESSION['prenom']}}
                </h2>
              </div>

            </div>


            <div>
              <a href="/" class="btn btn-warning btn-sm d-none d-md-block">Commencer ici</a>
            </div>

            <div>
              <a href="mon_comptes" class="btn btn-success btn-sm d-none d-md-block">Actuliser</a>
            </div>

          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- Content -->
  <div class="pb-5 py-md-5">
    <div class="container">
      <div>
        @if (isset($_SESSION['error_transp']) AND $_SESSION['error_transp']!='' AND isset($_SESSION['nom'])AND $_SESSION['nom']!='')
          <div class="alert alert-warning alert-dismissible fade show" role="alert">
           {{$_SESSION['error_transp']}}
           <button type="button" class="close" data-dismiss="alert" aria-label="Close">
             <span aria-hidden="true">&times;</span>
           </button>
           </div>
        @endif
      </div>
      <div class="row">
        <div class="col-md-12">
          <!-- Side Navbar -->
          <ul class="nav nav-lb-tab mb-6" id="tab" role="tablist">
            <li class="nav-item ml-0" role="presentation">
              <a class="nav-link active" id="bookmarked-tab" data-toggle="pill" href="#bookmarked" role="tab"
                aria-controls="bookmarked" aria-selected="true">Réservations en cours</a>
            </li>
            <li class="nav-item" role="presentation">
              <a class="nav-link" id="currentlyLearning-tab" data-toggle="pill" href="#currentlyLearning" role="tab"
                aria-controls="currentlyLearning" aria-selected="false">Réservations livrées</a>
            </li>

            <li class="nav-item" role="presentation">
              <a class="nav-link" id="path-tab" data-toggle="pill" href="#commande" role="tab" aria-controls="path"
                aria-selected="false">
                Livraisons</a>
            </li>
            <li class="nav-item" role="presentation">
              <a class="nav-link" id="path-tab" data-toggle="pill" href="#commande_solde" role="tab" aria-controls="path"
                aria-selected="false">
                Livraisons soldées</a>
            </li>
            <li class="nav-item" role="presentation">
              <a class="nav-link" id="path-tab" data-toggle="pill" href="#path" role="tab" aria-controls="path"
                aria-selected="false">
                Poster une offre</a>
            </li>

            <li class="nav-item" role="presentation">
              <a class="nav-link" id="path-tab" data-toggle="pill" href="#compte" role="tab" aria-controls="path"
                aria-selected="false">
                Mon compte</a>
            </li>
          </ul>
          <!-- Tab content -->
          <div class="tab-content" id="tabContent">

            <!-- Réservation en cours -->
            <div class="tab-pane fade show active" id="bookmarked" role="tabpanel" aria-labelledby="bookmarked-tab">
              @php
                if ($resNew!=0) {
                  echo "<h2>Vos colis sont en cours de route</h2>";
                }else{
                  echo '<div class="alert alert-warning" role="alert">Aucune réservations</div>';
                }
              @endphp


              <br>
              <div class="row">
                {{-- {{dd($res_new)}} --}}
               @foreach ($res_new as $value)
                <div class="col-lg-3 col-md-6 col-12">
                  <!-- Card -->
                  <div class="card  mb-4 card-hover">
                    <a href="#!" class="card-img-top"><img src="{{$value->vehicule}}" alt=""
                        class="card-img-top rounded-top"></a>
                    <!-- Card body -->
                    <div class="card-body">
                      <h4 class="h4 mb-2 text-truncate-line-2 ">
                        <a href="#" class="text-warning">
                          {{ReadVille($value->depart)}} - {{ReadVille($value->arrive)}}
                        </a>
                      </h4>
                      <div class="lh-1 mt-3">
                        <span class="text-dark font-weight-bold">{{$value->montant}} fcfa / place</span>
                      </div><br>
                      <!-- Code -->
                      <div class="lh-1">
                        <span class="text-success">Code : </span>
                        <span class="font-size-xs text-muted">{{$value->code}}</span>
                      </div><br>

                      <!-- Unité -->
                      <div class="lh-1">
                        <span class="text-success">unité : </span>
                        <span class="font-size-xs text-muted">{{ReadUnites($value->unite)}}</span>
                      </div><br>

                      <div class="lh-1">
                        <span class="text-success">Transporteur  : </span>
                        <span class="font-size-xs text-muted">{{transpTel($value->transporteur_id)}}</span>
                      </div><br>

                      <div class="lh-1">
                        <span class="text-success">Arrêt  : </span>
                        <span class="font-size-xs text-muted">{{$value->arret}}</span>
                      </div><br>

                      <ul class="mb-3 list-inline">
                        <li class="list-inline-item">
                        <span class="text-success">Commande : </span> {{$value->qte}} places
                        </li>
                      </ul>

                      <!-- Price -->
                      <div class="lh-1 mt-3">
                        <span class="text-success">Montant payé : </span>{{$value->qte*$value->montant}} fcfa
                      </div><br>
                      <b>Le {{$value->cdd}}</b>
                    </div>
                    <!-- Card footer -->
                    <div class="card-footer">
                      <div class="row align-items-center no-gutters">
                        <div class="col-auto">
                          <img src="{{transpProf($value->transporteur_id)}}" class="rounded-circle avatar-xs" alt="">
                        </div>
                        <div class="col ml-2">
                          <span>{{transpNom($value->transporteur_id)}}</span>
                        </div>
                        <div class="col-auto">
                          <a href="#!" class="text-white" title="Réserver une place">
                           <span class="badge badge-danger" type="button" class="btn btn-primary"data-toggle="modal" data-target="#exampleModalLong">
                              En cours
                           </span>
                         </a>
                        </div>

                      </div>
                    </div>
                  </div>
                </div>
               @endforeach
              </div>

              <div class="row">
                <div class="offset-lg-3 col-lg-6 col-md-12 col-12 text-center mt-5">
                  <p>Réduisons ensemble les pertes post-recoltes</p>
                </div>
              </div>
            </div>

            <!-- Colis livré -->
            <div class="tab-pane fade" id="currentlyLearning" role="tabpanel" aria-labelledby="currentlyLearning-tab">
              @php
                if ($resLiv!=0) {
                  echo "<h2>Vos colis ont été livrés</h2>";
                }else{
                  echo '<div class="alert alert-warning" role="alert">Aucune réservations livrées</div>';
                }
              @endphp

              <div class="row">
                {{-- {{dd($res_new)}} --}}
               @foreach ($res_liv as $value)
                <div class="col-lg-3 col-md-6 col-12">
                  <!-- Card -->
                  <div class="card  mb-4 card-hover">
                    <a href="#!" class="card-img-top"><img src="{{$value->vehicule}}" alt=""
                        class="card-img-top rounded-top"></a>
                    <!-- Card body -->
                    <div class="card-body">
                      <h4 class="h4 mb-2 text-truncate-line-2 ">
                        <a href="#" class="text-warning">
                          {{ReadVille($value->depart)}} - {{ReadVille($value->arrive)}}
                        </a>
                      </h4>
                      <div class="lh-1 mt-3">
                        <span class="text-dark font-weight-bold">{{$value->montant}} fcfa / place</span>
                      </div><br>

                      <div class="lh-1">
                        <span class="text-success">Code : </span>
                        <span class="font-size-xs text-muted">{{$value->code}}</span>
                      </div><br>

                      <!-- Unité -->
                      <div class="lh-1">
                        <span class="text-success">unité : </span>
                        <span class="font-size-xs text-muted">{{ReadUnites($value->unite)}}</span>
                      </div><br>

                      <div class="lh-1">
                        <span class="text-success">Tel  : </span>
                        <span class="font-size-xs text-muted">{{transpTel($value->transporteur_id)}}</span>
                      </div><br>

                      <div class="lh-1">
                        <span class="text-success">Arrêt  : </span>
                        <span class="font-size-xs text-muted">{{$value->arret}}</span>
                      </div><br>

                      <div class="lh-1">
                        <span class="text-success">Livré le  : </span>
                        <span class="font-size-xs text-muted">{{$value->livdate}}</span>
                      </div><br>

                      <ul class="mb-3 list-inline">
                        <li class="list-inline-item">
                        <span class="text-success">Commande : </span> {{$value->qte}} places
                        </li>
                      </ul>

                      <!-- Price -->
                      <div class="lh-1 mt-3">
                        <span class="text-success">Montant payé : </span>{{$value->qte*$value->montant}} fcfa
                      </div><br>
                      <b>Réservé le {{$value->date}}</b><br>
                    </div>
                    <!-- Card footer -->
                    <div class="card-footer">
                      <div class="row align-items-center no-gutters">
                        <div class="col-auto">
                          <img src="{{transpProf($value->transporteur_id)}}" class="rounded-circle avatar-xs" alt="">
                        </div>
                        <div class="col ml-2">
                          <span>{{transpNom($value->transporteur_id)}}</span>
                        </div>
                        <div class="col-auto">
                          <a href="#!" class="text-white" title="Réserver une place">
                           <span class="badge badge-success" type="button" class="btn btn-primary"data-toggle="modal" data-target="#exampleModalLong">
                              livré
                           </span>
                         </a>
                        </div>

                      </div>
                    </div>
                  </div>
                </div>
               @endforeach
              </div>

              <div class="row">
                <div class="offset-lg-3 col-lg-6 col-md-12 col-12 text-center mt-5">
                  <p>Réduisons ensemble les pertes post-recoltes</p>
                </div>
              </div>
            </div>

            <!-- Publier une offre -->

            <div class="tab-pane fade" id="path" role="tabpanel" aria-labelledby="path-tab">
                            <!-- Card -->
                            <div class="card border-0 mb-4">
                              <!-- Card header -->
                              <div class="card-header">
                                <h4 class="mb-0">Nouvelle Offre</h4>
                              </div>
                              <!-- Card Body -->
                              <div class="card-body">

                                <div class="mt-4">
                                  <form action="addOffre" method="post" enctype="multipart/form-data">
                                    @csrf
                                    <!-- Form -->
                                    <div class="row">

                                      <!-- Coût de la place -->
                                      <div class="form-group col-md-4">
                                        <label for="prix" class="form-label">Coût/place(fcfa)</label>
                                        <input type="number" id="prix" class="form-control text-dark"
                                          placeholder="" name="prix" required>
                                      </div>

                                      <!-- Départ -->
                                      <div class="form-group col-md-4">
                                        <label for="selectDate" class="form-label">Départ</label>
                                        <select class="selectpicker" data-width="100%" name="depart" required>
                                          <option></option>
                                          @foreach (ReadZone() as $value)
                                          <option value="{{$value->id}}">{{$value->nom}}</option>
                                          @endforeach
                                        </select>
                                      </div>

                                      <!-- Arrive -->
                                      <div class="form-group col-md-4">
                                        <label for="selectDate" class="form-label">Arrivé</label>
                                        <select class="selectpicker" data-width="100%" name="arrive" required>
                                          <option></option>
                                          @foreach (ReadZone() as $value)
                                          <option value="{{$value->id}}">{{$value->nom}}</option>
                                          @endforeach
                                        </select>
                                      </div>

                                    </div>
                                    <div class="row">
                                      <!-- places -->
                                      <div class="form-group col-md-4">
                                        <label for="place" class="form-label">Nombre de place disponible</label>
                                        <input type="number" id="place" class="form-control text-dark" placeholder="" name="places" required>
                                      </div>

                                      <!-- Unité -->
                                      <div class="form-group col-md-4">
                                        <label for="selectDate" class="form-label">Unité</label>
                                        <select class="selectpicker" data-width="100%" name="unite" required>
                                          <option placeholder=""></option>
                                          @foreach (ReadUnite() as $value)
                                            <option value="{{$value->id}}">{{$value->unite}}</option>
                                          @endforeach
                                        </select>
                                      </div>

                                      <!-- Date de pub -->
                                      <div class="form-group col-md-4">
                                       <label for="selectDate" class="form-label">Fin</label>
                                       <input type="text" id="selectDate" class="form-control text-dark flatpickr flatpickr-input" placeholder="Selectionner une Date"
                                              readonly="readonly" name="fin_date" required>
                                      </div>

                                      <!-- vehicule -->
                                      <div class="form-group col-md-4">
                                        <label for="selectDate" class="form-label">Véhicule</label>
                                        <input type="file" name="vehicule" required>
                                      </div>

                                    </div>
                                    <!-- button -->
                                    <button class="send btn btn-warning" type="submit">
                                      Publié
                                    </button>
                                    <a href="mon_comptes" class="btn btn-outline-danger ">
                                     Annuler
                                    </a>
                                  </form><br>
                                </div>
                                <hr>
                                <div class="row">

                                @foreach($offre as $key => $value)
                                 @if ($value->fin>=$today)
                                  <div class="col-lg-3 col-md-6 col-12">
                                    <!-- Card -->
                                    <div class="card  mb-4 card-hover">
                                      <a href="#!" class="card-img-top"><img src="{{$value->vehicule}}" alt=""
                                          class="card-img-top rounded-top"></a>
                                      <!-- Card body -->
                                      <div class="card-body">
                                        <h4 class="h4 mb-2 text-truncate-line-2 ">
                                          <a href="#" class="text-warning">
                                            {{ReadVille($value->depart)}} - {{ReadVille($value->arrive)}}
                                          </a>
                                        </h4>

                                        <!-- Unité -->
                                        <div class="lh-1">
                                          <span class="text-success">Code : </span>
                                          <span class="font-size-xs text-muted">{{$value->code}}</span>
                                        </div><br>

                                        <!-- Unité -->
                                        <div class="lh-1">
                                          <span class="text-success">unité : </span>
                                          <span class="font-size-xs text-muted">{{ReadUnites($value->unite)}}</span>
                                        </div>
                                        <!-- Prix -->
                                        <div class="lh-1 mt-3">
                                          <span class="text-success">Prix : </span>
                                          <span class="font-size-xs text-muted">{{$value->montant}} F /place</span>
                                        </div>
                                        <!-- Places -->
                                        <div class="lh-1 mt-3">
                                          <span class="text-success">Places : </span>{{$value->placedispo}}
                                        </div><br>
                                        <b>Le {{$value->date}}</b>
                                      </div>
                                      <!-- Card footer -->
                                      <div class="card-footer">
                                        <div class="row align-items-center no-gutters">
                                          <div class="col-auto">
                                            <img src="{{$_SESSION['profile']}}" class="rounded-circle avatar-xs" alt="">
                                          </div>
                                          <div class="col ml-2">
                                             <span>{{$value->nom}} {{$value->prenom}} </span><br>
                                            <a href="#!" class="text-white" title="Réserver une place">
                                             <span class="badge badge-success" type="button" class="btn btn-primary"data-toggle="modal" data-target="#exampleModalLong">
                                                actif
                                             </span>
                                           </a>
                                          </div>
                                          <div class="col-auto">
                                            <a href="#!" class="text-white delOff" title="Réserver une place" id="{{$value->offID}}">
                                             <span class="badge badge-danger" type="button" class="btn btn-primary">
                                                Supprimé
                                             </span>
                                           </a>
                                          </div>

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


            <!-- Mes Livraisons à effectuer  -->
            <div class="tab-pane fade" id="commande" role="tabpanel" aria-labelledby="currentlyLearning-tab">

              @php
                if ($nbLiv!=0) {
                  echo "<h2>Mes livraisons à effectuer </h2><br>";
                }else{
                  echo '<div class="alert alert-warning" role="alert">Aucune Livraisons à effectuer</div>';
                }
              @endphp
              <div class="row">
                {{-- {{dd($res_new)}} --}}
               @foreach ($liv_new as $value)
                <div class="col-lg-3 col-md-6 col-12">
                  <!-- Card -->
                  <div class="card  mb-4 card-hover">
                    <a href="#!" class="card-img-top"><img src="{{$value->vehicule}}" alt=""
                        class="card-img-top rounded-top"></a>
                    <!-- Card body -->
                    <div class="card-body">
                      <h4 class="h4 mb-2 text-truncate-line-2 ">
                        <a href="#" class="text-warning">
                          {{ReadVille($value->depart)}} - {{ReadVille($value->arrive)}}
                        </a>
                      </h4>
                      <div class="lh-1 mt-3">
                        <span class="text-dark font-weight-bold">{{$value->montant}} fcfa / place</span>
                      </div><br>
                      <!-- Code -->
                      <div class="lh-1">
                        <span class="text-success">Code : </span>
                        <span class="font-size-xs text-muted">{{$value->code}}</span>
                      </div><br>

                      <!-- Unité -->
                      <div class="lh-1">
                        <span class="text-success">unité : </span>
                        <span class="font-size-xs text-muted">{{ReadUnites($value->unite)}}</span>
                      </div><br>

                      <!-- Tel user -->
                      <div class="lh-1">
                        <span class="text-success">Client  : </span>
                        <span class="font-size-xs text-muted">{{userTel($value->offClient)}}</span>
                      </div><br>

                      <div class="lh-1">
                        <span class="text-success">Arrêt  : </span>
                        <span class="font-size-xs text-muted">{{$value->arret}}</span>
                      </div><br>

                      <ul class="mb-3 list-inline">
                        <li class="list-inline-item">
                        <span class="text-success">Commande : </span> {{$value->qte}} places
                        </li>
                      </ul>

                      <!-- Price -->
                      <div class="lh-1 mt-3">
                        <span class="text-success">Montant payé : </span>{{$value->qte*$value->montant}} fcfa
                      </div><br>
                      <b>Le {{$value->licd}}</b>
                    </div>
                    <!-- Card footer -->
                    <div class="card-footer">
                      <div class="row align-items-center no-gutters">
                        <div class="col-auto">
                          <img src="{{userProfil($value->offClient)}}" class="rounded-circle avatar-xs" alt="">
                        </div>
                        <div class="col ml-2">
                          <span>{{userNom($value->offClient)}}</span>
                        </div>
                        <div class="col-auto">
                          <a href="#!" class="text-white" title="Réserver une place">
                           <span class="badge badge-danger" type="button" class="btn btn-primary"data-toggle="modal" data-target="#exampleModalLong">
                              En cours
                           </span>
                         </a>
                        </div>

                      </div>
                    </div>
                  </div>
                </div>
               @endforeach
              </div>
              <div class="row">
                <div class="offset-lg-3 col-lg-6 col-md-12 col-12 text-center mt-5">
                  <p>Réduisons ensemble les pertes post-recoltes</p>
                </div>
              </div>
            </div>

            <!-- Mes livraisons soldées -->
            <div class="tab-pane fade" id="commande_solde" role="tabpanel" aria-labelledby="currentlyLearning-tab">
              @php
                if ($nbLivS!=0) {
                  echo "<h2>Mes Livraisons soldées </h2><br>";
                }else{
                  echo '<div class="alert alert-warning" role="alert">Aucune Livraisons soldées</div>';
                }
              @endphp

              <div class="row">
                {{-- {{dd($res_new)}} --}}
               @foreach ($liv_sold as $value)
                <div class="col-lg-3 col-md-6 col-12">
                  <!-- Card -->
                  <div class="card  mb-4 card-hover">
                    <a href="#!" class="card-img-top"><img src="{{$value->vehicule}}" alt=""
                        class="card-img-top rounded-top"></a>
                    <!-- Card body -->
                    <div class="card-body">
                      <h4 class="h4 mb-2 text-truncate-line-2 ">
                        <a href="#" class="text-warning">
                          {{ReadVille($value->depart)}} - {{ReadVille($value->arrive)}}
                        </a>
                      </h4>
                      <div class="lh-1 mt-3">
                        <span class="text-dark font-weight-bold">{{$value->montant}} fcfa / place</span>
                      </div><br>
                      <!-- Code -->
                      <div class="lh-1">
                        <span class="text-success">Code : </span>
                        <span class="font-size-xs text-muted">{{$value->code}}</span>
                      </div><br>

                      <!-- Unité -->
                      <div class="lh-1">
                        <span class="text-success">unité : </span>
                        <span class="font-size-xs text-muted">{{ReadUnites($value->unite)}}</span>
                      </div><br>

                      <!-- Tel user -->
                      <div class="lh-1">
                        <span class="text-success">Client  : </span>
                        <span class="font-size-xs text-muted">{{userTel($value->offClient)}}</span>
                      </div><br>

                      <div class="lh-1">
                        <span class="text-success">Arrêt  : </span>
                        <span class="font-size-xs text-muted">{{$value->arret}}</span>
                      </div><br>

                      <ul class="mb-3 list-inline">
                        <li class="list-inline-item">
                        <span class="text-success">Commande : </span> {{$value->qte}} places
                        </li>
                      </ul>

                      <!-- Price -->
                      <div class="lh-1 mt-3">
                        <span class="text-success">Montant payé : </span>{{$value->qte*$value->montant}} fcfa
                      </div><br>
                      <b>Le {{$value->licd}}</b>
                    </div>
                    <!-- Card footer -->
                    <div class="card-footer">
                      <div class="row align-items-center no-gutters">
                        <div class="col-auto">
                          <img src="{{userProfil($value->offClient)}}" class="rounded-circle avatar-xs" alt="">
                        </div>
                        <div class="col ml-2">
                          <span>{{userNom($value->offClient)}}</span>
                        </div>
                        <div class="col-auto">
                          <a href="#!" class="text-white" title="Réserver une place">
                           <span class="badge badge-danger" type="button" class="btn btn-primary"data-toggle="modal" data-target="#exampleModalLong">
                              En cours
                           </span>
                         </a>
                        </div>

                      </div>
                    </div>
                  </div>
                </div>
               @endforeach
              </div>
              <div class="row">
                <div class="offset-lg-3 col-lg-6 col-md-12 col-12 text-center mt-5">
                  <p>Réduisons ensemble les pertes post-recoltes</p>
                </div>
              </div>
            </div>

            <!-- Mon compte -->
            <div class="tab-pane fade" id="compte" role="tabpanel" aria-labelledby="currentlyLearning-tab">
            <div class="col-lg-12 col-md-8 col-12">
					<!-- Card -->
					<div class="card" id="grenier">
						<!-- Card header -->
						<div class="card-header">
							<h3 class="mb-0 text-warning">MON COMPTE <b>GRENIER</b></h3>
						</div>
						<!-- Card body -->
						<div class="card-body">
							<div class="d-lg-flex align-items-center justify-content-between">
								<div class="d-flex align-items-center mb-4 mb-lg-0">
									<img src="{{$_SESSION['profile']}}" id="img-uploaded" class="avatar-xl rounded-circle" alt="" />
									<div class="ml-3">
										<h4 class="mb-0">{{$_SESSION['nom'].' '.$_SESSION['prenom']}}</h4>
									</div>
								</div>
								<div>
									<a href="logout" class="btn btn-outline-warning btn-sm">
                    Se déconnecter
                  </a>
								</div>
							</div>
							<hr class="my-5" />
							<div>

								<!-- Form -->
								<form class="form-row" action="upcompte"  method="POST" enctype="multipart/form-data">
                  @csrf
									<!-- First name -->
									<div class="form-group col-12 col-md-6">
										<label class="form-label" for="fname">Nom</label>
										<input type="text" id="fname" name="nom" class="form-control" value="{{$_SESSION['nom']}}"/>
									</div>
									<!-- Last name -->
									<div class="form-group col-12 col-md-6">
										<label class="form-label" for="lname">Prénom</label>
										<input type="text" id="lname" name="prenom" class="form-control" value="{{$_SESSION['prenom']}}"/>
									</div>
									<!-- Phone -->
									<div class="form-group col-12 col-md-6">
										<label class="form-label" for="phone">Téléphone</label>
										<input type="number" name="phone" id="phone" class="form-control" value="{{$_SESSION['tel']}}"/>
									</div>

									<!-- pass -->
									<div class="form-group col-12 col-md-6">
                    <label for="password" class="form-label">Password</label>
                    <input type="text" id="password" class="form-control" name="password"
                           placeholder="" value="{{$_SESSION['password']}}">
                  </div>

                  <!-- Photo de profile -->
                  <div class="form-group">
                     <label for="photo">Photo de profile</label>
                     <div class="custom-file">
                        <input type="file" id="photo" name="profile" value="">
                     </div>
                  </div>


									<div class="col-12">
										<!-- Button -->
										<button class="btn btn-warning" type="submit">
											Mettre à jour
										</button>
									</div>
								</form>
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

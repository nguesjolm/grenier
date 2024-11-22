 <!-- Page content -->
 <div class="container d-flex flex-column">
    <div class="row align-items-center justify-content-center no-gutters min-vh-100">
      <div class="col-lg-5 col-md-8 py-8 py-xl-0">
        <!-- Card -->
        <div class="card shadow ">
          <!-- Card body -->
          <div class="card-body p-6">
            @if (isset($_SESSION['error_transp']) AND $_SESSION['error_transp']!='' AND isset($_SESSION['nom'])AND $_SESSION['nom']!='')
            <div class="mb-4">
              <a href="/"><img src="../assets/images/favicon/logo.png" class="mb-4" alt=""></a>
              <h1 class="mb-1 font-weight-bold">Grenier - Transporteur</h1>

               
                  <div class="alert alert-warning alert-dismissible fade show" role="alert">
                   <strong>{{$_SESSION['nom']}}</strong> {{$_SESSION['error_transp']}}
                   <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                     <span aria-hidden="true">&times;</span>
                   </button>
                   </div>
            </div>
            @else
            <div class="mb-4">
              <a href="/"><img src="../assets/images/favicon/logo.png" class="mb-4" alt=""></a>
              <h1 class="mb-1 font-weight-bold">Grenier - Transporteur</h1>
            </div>
            <!-- Form -->
            <form action="addtransporteur" method="POST" enctype="multipart/form-data">
              @csrf

              <!-- Nom -->
              <div class="form-group">
                <label for="nom" class="form-label">Nom</label>
                <input type="text" id="nom" class="form-control" name="nom"
                placeholder="" required>
              </div>
              <!-- Prénom -->
              <div class="form-group">
                <label for="prenom" class="form-label">Prénom</label>
                <input type="text" id="prenom" class="form-control" name="prenom"
                placeholder="" required>
              </div>
              <!-- Prénom -->
              <div class="form-group">
                <label for="tel" class="form-label">Téléphone</label>
                <input type="number" id="tel" class="form-control" name="tel"
                placeholder="ex: 0102205211" required>
              </div>
              <!-- Matricule -->
              <div class="form-group">
                <label for="matricule" class="form-label">Matricule de votre vehicule</label>
                <input type="text" id="matricule" class="form-control" name="matricule"
                placeholder="" required>
              </div>
              <!-- Photo de profile -->
              {{-- <div class="form-group">
                <label for="photo">Photo du vehicule</label>
                <div class="custom-file">
                 <input type="file" id="photo" name="photo" required>
                </div>
              </div> --}}

              <div>
                	<!-- Button -->
                <button type="submit" class="btn btn-warning btn-block">S'abonner</button>
              </div>
              <hr class="my-4">
              <div class="mt-4 text-center">
                Trouver des clients !!
              </div>
            </form>
            @endif
            
          </div>
        </div>
      </div>
    </div>
  </div>

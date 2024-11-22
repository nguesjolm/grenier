 <!-- Sidebar -->
 <nav class="navbar-vertical navbar">
            <div class="nav-scroller">
                <!-- Brand logo -->
                <a class="navbar-brand" href="dashboard">
                 <!--<img src="../../assets/images/favicon/logo.png" alt="" /></a>-->
                 <h1 class="">LE GRENIER</h1>
                </a>
                <!-- Navbar nav -->
                <ul class="navbar-nav flex-column" id="sideNavbar">
                    <!-- Gestion de  Commandes -->
                    <li class="nav-item">
                        <a class="nav-link " href="#!" data-toggle="collapse" data-target="#navDashboard" aria-expanded="false" aria-controls="navDashboard">
                            <i class="nav-icon fe fe-clock mr-2"></i>Commandes
                        </a>
                        <div id="navDashboard" class="collapse" data-parent="#sideNavbar">
                            <ul class="nav flex-column">
                                <!-- Commande Nouvelle -->
                                <li class="nav-item">
                                    <a class="nav-link" href="new_commande">Nouvelle</a>
                                </li>

                                <!-- Commande livrées -->
                                <li class="nav-item ">
                                    <a class="nav-link " href="livre_commande">Livrées</a>
                                </li>

                                <!-- Commande soldées -->
                                <li class="nav-item ">
                                    <a class="nav-link " href="solde_commande">soldées</a>
                                </li>

                                <!-- Commande rejete -->
                                <li class="nav-item ">
                                    <a class="nav-link " href="rembourse_commande">remboursées</a>
                                </li>


                            </ul>
                        </div>
                    </li>
                    <!-- Gestion des clients -->
                    <li class="nav-item">
                        <a class="nav-link " href="clients_liste">
                            <i class="nav-icon fe fe-users mr-2"></i>Clients
                        </a>
                        {{-- <div id="navCourses" class="collapse" data-parent="#sideNavbar">
                            <ul class="nav flex-column">
                                <li class="nav-item">
                                    <a class="nav-link" href="clients_liste">Liste</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="clients_bloque">Bloqué</a>
                                </li>
                            </ul>
                        </div> --}}
                    </li>
                    <!-- Gestion des courses -->
                    <li class="nav-item">
                        <a class="nav-link " href="#!" data-toggle="collapse" data-target="#navProfile" aria-expanded="false" aria-controls="navProfile">
                            <i class="nav-icon fe fe-bookmark  mr-2"></i>Gestion des courses
                        </a>
                        <div id="navProfile" class="collapse " data-parent="#sideNavbar">
                            <ul class="nav flex-column">
                                <li class="nav-item">
                                    <a class="nav-link " href="course_pub">Publiées</a>
                                </li>
                                <li class="nav-item ">
                                    <a class="nav-link" href="course_lock">Bloquées</a>
                                </li>
                            </ul>
                        </div>
                    </li>
                    <!-- Gestion des transporteurs -->
                    <li class="nav-item">
                        <a class="nav-link " href="#!" data-toggle="collapse" data-target="#navtransport" aria-expanded="false" aria-controls="navProfile">
                            <i class="nav-icon fe fe-truck mr-2"></i>Transporteurs
                        </a>
                        <div id="navtransport" class="collapse " data-parent="#sideNavbar">
                            <ul class="nav flex-column">
                                <li class="nav-item">
                                    <a class="nav-link " href="transp_demande">Demandes</a>
                                </li>
                                <li class="nav-item ">
                                    <a class="nav-link" href="transp_valide">Comptes valides</a>
                                </li>
                                <li class="nav-item ">
                                    <a class="nav-link" href="transp_lock">Comptes rejetés</a>
                                </li>
                            </ul>
                        </div>
                    </li>

                    <!-- Gestion des zones -->
                    <li class="nav-item">
                        <a class="nav-link " href="zone">
                            <i class="nav-icon fe fe-map mr-2"></i>Gestion des zones
                        </a>
                    </li>

                    <!-- Nav item -->
                    <li class="nav-item ">
                        <div class="nav-divider">
                        </div>
                    </li>
                    <!-- Nav item -->
                    <li class="nav-item ">
                        <div class="navbar-heading">Paramètres</div>
                    </li>
                    <!-- Nav item -->
                    <li class="nav-item ">
                        <a class="nav-link " href="coordonnes">
                            <i class="nav-icon fe fe-clipboard mr-2"></i>Coordonnées
                        </a>
                    </li>
                    <!-- Nav item -->
                    <li class="nav-item ">
                        <a class="nav-link " href="unite_sms">
                            <i class="nav-icon fe fe-git-pull-request mr-2"></i>Unité SMS
                        </a>
                    </li>

                </ul>

            </div>
        </nav>

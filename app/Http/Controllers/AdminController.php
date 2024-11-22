<?php
namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

/**
 * Gestion de l'administrateur
 */
class AdminController extends Controller
{

  #GESTION des commandes
  function searchCmdRemb(Request $request)
  {
   $attribut = $request->attribut;
   $valeur = $request->valeur;
   $data = ['attribut'=>$attribut,'valeur'=>$valeur];
   $res = filtreComd($attribut,$valeur,1);
   $nbCmd = count($res);
   $output='';
   if ($nbCmd==0) {
    $output.='

     <div class="col-lg-12 alert alert-danger" role="alert">
         Aucune commandes disponibles
      </div>
     ';
   }else{
    $output.='<thead>
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
    <tbody class="">';
    foreach ($res as $key => $value) {
      if ($value->statut==2) {
        $output.='<tr>
         <td class="align-middle border-top-0">
           <h4><b class="text-danger">'.$value->code.'</b></h4>
         </td>

         <td class="border-top-0">
             <a href="#!" class="text-inherit">
                 <div class="d-lg-flex align-items-center">
                     <div>
                         <img src="'.readVehID($value->offre_id).'" alt="" class="img-4by3-lg rounded" />
                     </div>
                     <div class="ml-lg-3 mt-2 mt-lg-0">
                         <h4 class="mb-1">
                             <span class="text-primary">'.ReadVille(readDeptID($value->offre_id)).' - '.ReadVille(readArrivID($value->offre_id)).'</span><br>
                             <span>Arrêt: </span> '.$value->arret.' <br>
                             <span>Coût:</span>'.readMontantID($value->offre_id).'fcfa / place
                         </h4>
                         <span class="text-success">Commandes:</span> '.$value->qte.' places<br>
                         <span class="text-success">Montant payé:</span>'.readMontantID($value->offre_id)*$value->qte.' fcfa<br>
                         <a href="#" class="badge badge-warning infoTransp"
                         id="'.$value->offre_transporteur_id.'">
                             infos transporteur
                         </a>
                     </div>
                 </div>
             </a>
         </td>

         <td class="align-middle border-top-0">
             <div class="d-flex align-items-center">
                 '.userNom($value->user_id).' -
                 '.userTel($value->user_id).'
             </div>
         </td>

         <td class="align-middle border-top-0">
             <span class="bg-warning mr-1 d-inline-block align-middle"></span>'.$value->created_at.'
         </td>

         <td class="align-middle border-top-0">
             <span class="badge-dot bg-success mr-1 d-inline-block align-middle"></span>
             <span class="text-success">livrée</span>
         </td>

         <td class="align-middle border-top-0">';
          if ($value->statut=='2') {
            $output.='<span class="text-danger">remboursée</span>';
          } else {
            $output.='
             <a href="#!" class="btn btn-outline-warning btn-sm solder" id="'.$value->code.'">
              solder
             </a>';
          }



        $output.='</td>
         </tr>';
      }

    }
    $output.='</tbody>';
   }
   $output.='<!-- Modal infos transporteur -->
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
  </div>';

  $output.='
    <script type="text/javascript">
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

    //Infos livreur
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


    </script>
  ';
  return $output;

}

  function searchCmdSold(Request $request)
  {
   $attribut = $request->attribut;
   $valeur = $request->valeur;
   $data = ['attribut'=>$attribut,'valeur'=>$valeur];
   $res = filtreComd($attribut,$valeur,1);
   $nbCmd = count($res);
   $output='';
   if ($nbCmd==0) {
    $output.='

     <div class="col-lg-12 alert alert-danger" role="alert">
         Aucune commandes disponibles
      </div>
     ';
   }else{
    $output.='<thead>
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
    <tbody class="">';
    foreach ($res as $key => $value) {
      if ($value->statut==1) {
        $output.='<tr>
         <td class="align-middle border-top-0">
           <h4><b class="text-danger">'.$value->code.'</b></h4>
         </td>

         <td class="border-top-0">
             <a href="#!" class="text-inherit">
                 <div class="d-lg-flex align-items-center">
                     <div>
                         <img src="'.readVehID($value->offre_id).'" alt="" class="img-4by3-lg rounded" />
                     </div>
                     <div class="ml-lg-3 mt-2 mt-lg-0">
                         <h4 class="mb-1">
                             <span class="text-primary">'.ReadVille(readDeptID($value->offre_id)).' - '.ReadVille(readArrivID($value->offre_id)).'</span><br>
                             <span>Arrêt: </span> '.$value->arret.' <br>
                             <span>Coût:</span>'.readMontantID($value->offre_id).'fcfa / place
                         </h4>
                         <span class="text-success">Commandes:</span> '.$value->qte.' places<br>
                         <span class="text-success">Montant payé:</span>'.readMontantID($value->offre_id)*$value->qte.' fcfa<br>
                         <a href="#" class="badge badge-warning infoTransp"
                         id="'.$value->offre_transporteur_id.'">
                             infos transporteur
                         </a>
                     </div>
                 </div>
             </a>
         </td>

         <td class="align-middle border-top-0">
             <div class="d-flex align-items-center">
                 '.userNom($value->user_id).' -
                 '.userTel($value->user_id).'
             </div>
         </td>

         <td class="align-middle border-top-0">
             <span class="bg-warning mr-1 d-inline-block align-middle"></span>'.$value->created_at.'
         </td>

         <td class="align-middle border-top-0">
             <span class="badge-dot bg-success mr-1 d-inline-block align-middle"></span>
             <span class="text-success">livrée</span>
         </td>

         <td class="align-middle border-top-0">';
          if ($value->statut=='1') {
            $output.='<span class="text-success">soldée</span>';
          } else {
            $output.='
             <a href="#!" class="btn btn-outline-warning btn-sm solder" id="'.$value->code.'">
              solder
             </a>';
          }



        $output.='</td>
         </tr>';
      }

    }
    $output.='</tbody>';
   }
   $output.='<!-- Modal infos transporteur -->
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
  </div>';

  $output.='
    <script type="text/javascript">
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

    //Infos livreur
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


    </script>
  ';
  return $output;

}

  function UpdComdRemb(Request $request)
  {
    $id = $request->id;
    $res = UpdComdSolde(2,$id);
    return response()->json(['code' => '2'],200);
  }
  function UpdComdSolde(Request $request)
  {
    $id = $request->id;
    $res = UpdComdSolde(1,$id);
    return response()->json(['code' => '2'],200);
  }
  function searchCmdLV(Request $request)
  {
    $attribut = $request->attribut;
    $valeur = $request->valeur;
    $data = ['attribut'=>$attribut,'valeur'=>$valeur];
    $res = filtreComd($attribut,$valeur,1);
    $nbCmd = count($res);
    $output='';
    if ($nbCmd==0) {
      $output.='

       <div class="col-lg-12 alert alert-danger" role="alert">
           Aucune commandes disponibles
        </div>
       ';
    }else{
      $output.='<thead>
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
      <tbody class="">';
      foreach ($res as $key => $value) {
        $output.='<tr>
         <td class="align-middle border-top-0">
           <h4><b class="text-danger">'.$value->code.'</b></h4>
         </td>

         <td class="border-top-0">
             <a href="#!" class="text-inherit">
                 <div class="d-lg-flex align-items-center">
                     <div>
                         <img src="'.readVehID($value->offre_id).'" alt="" class="img-4by3-lg rounded" />
                     </div>
                     <div class="ml-lg-3 mt-2 mt-lg-0">
                         <h4 class="mb-1">
                             <span class="text-primary">'.ReadVille(readDeptID($value->offre_id)).' - '.ReadVille(readArrivID($value->offre_id)).'</span><br>
                             <span>Arrêt: </span> '.$value->arret.' <br>
                             <span>Coût:</span>'.readMontantID($value->offre_id).'fcfa / place
                         </h4>
                         <span class="text-success">Commandes:</span> '.$value->qte.' places<br>
                         <span class="text-success">Montant payé:</span>'.readMontantID($value->offre_id)*$value->qte.' fcfa<br>
                         <a href="#" class="badge badge-warning infoTransp"
                         id="'.$value->offre_transporteur_id.'">
                             infos transporteur
                         </a>
                     </div>
                 </div>
             </a>
         </td>

         <td class="align-middle border-top-0">
             <div class="d-flex align-items-center">
                 '.userNom($value->user_id).' -
                 '.userTel($value->user_id).'
             </div>
         </td>

         <td class="align-middle border-top-0">
             <span class="bg-warning mr-1 d-inline-block align-middle"></span>'.$value->created_at.'
         </td>

         <td class="align-middle border-top-0">
             <span class="badge-dot bg-success mr-1 d-inline-block align-middle"></span>
             <span class="text-success">livrée</span>
         </td>

         <td class="align-middle border-top-0">';
          if ($value->statut=='1') {
            $output.='<span class="text-success">soldée</span>';
          } else {
            $output.='
             <a href="#!" class="btn btn-outline-warning btn-sm solder" id="'.$value->code.'">
              solder
             </a>';
          }

          if ($value->statut=='2') {
            $output.='<span class="text-success">remboursée</span>';
          } else {
            $output.='
             <a href="#!" class="btn btn-outline-danger btn-sm rembourser" id="'.$value->code.'">
              rembourser
             </a>';
          }


        $output.='</td>
         </tr>';
      }
      $output.='</tbody>';
    }
    $output.='<!-- Modal infos transporteur -->
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
    </div>';

    $output.='
      <script type="text/javascript">
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

      //Infos livreur
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


      </script>
    ';
    return $output;

  }

  function searchCmd(Request $request)
  {
    $attribut = $request->attribut;
    $valeur = $request->valeur;
    $data = ['attribut'=>$attribut,'valeur'=>$valeur];
    $res = filtreComd($attribut,$valeur,0);
    $nbCmd = count($res);
    $output='';
    if ($nbCmd==0) {
      $output.='

       <div class="col-lg-12 alert alert-danger" role="alert">
           Aucune commandes disponibles
        </div>
       ';
    }else{
      $output.='<thead>
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
      <tbody class="">';
      foreach ($res as $key => $value) {
        $output.='<tr>
         <td class="align-middle border-top-0">
           <h4><b class="text-danger">'.$value->code.'</b></h4>
         </td>

         <td class="border-top-0">
             <a href="#!" class="text-inherit">
                 <div class="d-lg-flex align-items-center">
                     <div>
                         <img src="'.readVehID($value->offre_id).'" alt="" class="img-4by3-lg rounded" />
                     </div>
                     <div class="ml-lg-3 mt-2 mt-lg-0">
                         <h4 class="mb-1">
                             <span class="text-primary">'.ReadVille(readDeptID($value->offre_id)).' - '.ReadVille(readArrivID($value->offre_id)).'</span><br>
                             <span>Arrêt: </span> '.$value->arret.' <br>
                             <span>Coût:</span>'.readMontantID($value->offre_id).'fcfa / place
                         </h4>
                         <span class="text-success">Commandes:</span> '.$value->qte.' places<br>
                         <span class="text-success">Montant payé:</span>'.readMontantID($value->offre_id)*$value->qte.' fcfa<br>
                         <a href="#" class="badge badge-warning infoTransp"
                         id="'.$value->offre_transporteur_id.'">
                             infos transporteur
                         </a>
                     </div>
                 </div>
             </a>
         </td>

         <td class="align-middle border-top-0">
             <div class="d-flex align-items-center">
                 '.userNom($value->user_id).' -
                 '.userTel($value->user_id).'
             </div>
         </td>

         <td class="align-middle border-top-0">
             <span class="bg-warning mr-1 d-inline-block align-middle"></span>'.$value->created_at.'
         </td>

         <td class="align-middle border-top-0">
             <span class="badge-dot bg-warning mr-1 d-inline-block align-middle"></span>
             <span class="text-primary">En cours</span>
         </td>

         <td class="align-middle border-top-0">
             <a href="#!" class="btn btn-outline-success btn-sm livrer" id="'.$value->code.'">
               Livrer
             </a>
         </td>

        </tr>';
      }
      $output.='</tbody>';
    }
    $output.='<!-- Modal infos transporteur -->
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
    </div>';

    $output.='
      <script type="text/javascript">
      //Boutton livrer
      $(".livrer").click(function(){
        var id = $(this).attr("id");
        var data = {id:id};
        Swal.fire({
             title: "Transporteur",
             text: "Voulez-vous livrer la commande du "+id+" ?",
             icon: "error",
             showCancelButton: true,
             confirmButtonColor: "#3085d6",
             cancelButtonColor: "#d33",
             cancelButtonText: "non",
             confirmButtonText: "oui , livrée!",
             backdrop: `rgba(240,15,83,0.4)`
           }).then((result)=>{
              if (result.value) {
                $.ajax({
                  url:"UpdComd",
                  method:"GET",
                  data:data,
                  dataType:"json",
                  success:function(data){
                    if (data.code==2){
                      Swal.fire({
                        position: "top-end",
                        icon: "success",
                        title: "La commande "+id+" a été livrée avec succès",
                        showConfirmButton: false,
                        timer: 1500
                      });
                      window.location="new_commande";
                    }
                  },
                  error:function(data){
                    console.log(data);
                  }
                });
              }
           });
      });

      //Infos livreur
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


      </script>
    ';


    return $output;

  }

  function UpdComd(Request $request)
  {
    $id = $request->id;
    $res = UpdComd(1,$id);
    return response()->json(['code' => '2'],200);
  }

  function readTranspID(Request $request)
  {
    $id = $request->tranp;
    $transp = ReadTranspID($id);
    $data = ['matricule' => $transp->matricule,
             'profile'=>$transp->photo,
             'nomT'=>$transp->nomT,
             'prenomT'=>$transp->prenomT,
             'telT'=>$transp->telT,
             'passT'=>$transp->passT,
             'profile'=>$transp->profile
            ];
    return response()->json($data,200);
  }

  #GESTION des clients
  function searchCl(Request $request)
  {
    $attribut = $request->attribut;
    $valeur = $request->valeur;
    $res = filtreUser($attribut,$valeur);
    $nbcl = count($res);
    $output='';
    if ($nbcl==0) {
      $output.='  <div class="col-lg-12 alert alert-danger" role="alert">
           Aucun clients disponible
        </div>';
    }else{
      foreach ($res as $key => $value) {
      $output.='
      <div class="col-xl-3 col-lg-6 col-md-6 col-12">
          <!-- Card -->
          <div class="card mb-4">
              <!-- Card body -->
              <div class="card-body">
                  <div class="text-center">
                      <img src='.$value->profile.' class="rounded-circle avatar-xl mb-3" alt="" />
                      <h4 class="mb-0">'.$value->nom.' '.$value->prenom.'</h4>
                      <p class="mb-0"><b>Nom: '.$value->nom.'</b></p>
                      <p class="mb-0"><b>Prénom: '.$value->prenom.'</b></p>
                      <p class="mb-0"><b>Inscrit le '.$value->created_at.'</b></p>
                  </div>

                  <div class="d-flex justify-content-between border-bottom py-2">
                      <span>Tel</span>
                      <span class="text-dark">
                       '.$value->tel.'
                      </span>
                  </div>
                  <div class="d-flex justify-content-between pt-2">
                      <span>Mot de passe</span>
                      <span class="text-dark"> '.$value->password.' </span>
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
      ';
      }
    }
    return $output;
  }

  #Gestion des courses
  //Débloquer une course
  function lockOn(Request $request)
  {
    $id = $request->id;
    upoffre($id,0);
    return response()->json(['code' => '2'],200);
  }

  //Filtre recherche des courses bloquées
  function searchCourseLck(Request $request)
  {
    $attribut = $request->attribut;
    $valeur   = $request->valeur;
    $data = ['attribut'=>$attribut,'valeur'=>$valeur];
    if ($attribut=='tel') {
      $user = userID($valeur);
      $res = filtreCourses($user);
    }else{
      $res = filtreCourse($attribut,$valeur);
    }

    $output = '';
    $nbC = count($res);
    if ($nbC==0) {
      $output.='
      <div class="col-lg-12 alert alert-danger" role="alert">
         Aucune course disponible
      </div>';
    }else {
      $today = date('Y-m-d');
      foreach ($res as $key => $value) {
        if ($value->fin>=$today) {
          if ($value->etat==1) {
            $output.='
            <div class="col-xl-3 col-lg-6 col-md-6 col-12">
                <!-- Card -->
                <div class="card mb-4">
                    <!-- Card body -->
                    <div class="card-body">
                        <div class="text-center">
                            <img src='.$value->vehicule.' class="rounded-circle avatar-xl mb-3" alt="" />
                            <h4 class="mb-0">'.userNom($value->user_id).'</h4>
                            <p class="mb-0">Nom: <b>'.usernNom($value->user_id).'</b></p>
                            <p class="mb-0">Prénom: <b>'.userPNom($value->user_id).'</b></p>
                            <p class="mb-0">Tel: <b>'.userTel($value->user_id).'</b></p>
                            <p class="mb-0"><b>Publié le '.$value->created_at.'</b></p>
                            <p class="mb-0">
                                <span class="badge badge-success lock"
                                      code = '.$value->code.'
                                      id="'.$value->offID.'"
                                      tel='.userTel($value->user_id).'
                                      type="button" data-toggle="modal"
                                      data-target="#exampleModalLong">
                                débloquer
                               </span>
                            </p>
                        </div>

                        <div class="d-flex justify-content-between border-bottom py-2 mt-4">
                            <span>Code</span>
                            <span class="text-primary">'.$value->code.'</span>
                        </div>

                        <div class="d-flex justify-content-between border-bottom py-2 mt-4">
                            <span>Trajet</span>
                            <span class="text-primary">'.ReadVille($value->depart).'-'.ReadVille($value->arrive).'</span>
                        </div>

                        <div class="d-flex justify-content-between border-bottom py-2">
                            <span>Place dispo</span>
                            <span class="text-primary">
                             <b>'.$value->placedispo.'</b>
                            </span>
                        </div>
                        <div class="d-flex justify-content-between border-bottom py-2">
                            <span>Coût</span>
                            <span class="text-primary">
                             <b>'.$value->montant.' fcfa / place</b>
                            </span>
                        </div>
                        <div class="d-flex justify-content-between  pt-2">
                            <span>Unité</span>
                            <span class="text-dark"> '.ReadUnites($value->unite).' </span>
                        </div>




                    </div>
                </div>
            </div>
            ';
          }
        }

      }
    }

    //Bloquer la course publiée
    $output.="<script type='text/javascript'>
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
    </script>";


    return $output;
  }
  //Filtre de recherche des courses
  function searchCourse(Request $request)
  {
    $attribut = $request->attribut;
    $valeur   = $request->valeur;
    $data = ['attribut'=>$attribut,'valeur'=>$valeur];
    if ($attribut=='tel') {
      $user = userID($valeur);
      $res = filtreCourses($user);
    }else{
      $res = filtreCourse($attribut,$valeur);
    }

    $output = '';
    $nbC = count($res);
    if ($nbC==0) {
      $output.='
      <div class="col-lg-12 alert alert-danger" role="alert">
         Aucune course disponible
      </div>';
    }else {
      $today = date('Y-m-d');
      foreach ($res as $key => $value) {
        if ($value->fin>=$today) {
          if ($value->etat==0) {
            $output.='
            <div class="col-xl-3 col-lg-6 col-md-6 col-12">
                <!-- Card -->
                <div class="card mb-4">
                    <!-- Card body -->
                    <div class="card-body">
                        <div class="text-center">
                            <img src='.$value->vehicule.' class="rounded-circle avatar-xl mb-3" alt="" />
                            <h4 class="mb-0">'.userNom($value->user_id).'</h4>
                            <p class="mb-0">Nom: <b>'.usernNom($value->user_id).'</b></p>
                            <p class="mb-0">Prénom: <b>'.userPNom($value->user_id).'</b></p>
                            <p class="mb-0">Tel: <b>'.userTel($value->user_id).'</b></p>
                            <p class="mb-0"><b>Publié le '.$value->created_at.'</b></p>
                            <p class="mb-0">
                                <span class="badge badge-danger lock"
                                      code = '.$value->code.'
                                      id="'.$value->offID.'"
                                      tel='.userTel($value->user_id).'
                                      type="button" data-toggle="modal"
                                      data-target="#exampleModalLong">
                                bloquer
                               </span>
                            </p>
                        </div>

                        <div class="d-flex justify-content-between border-bottom py-2 mt-4">
                            <span>Code</span>
                            <span class="text-primary">'.$value->code.'</span>
                        </div>

                        <div class="d-flex justify-content-between border-bottom py-2 mt-4">
                            <span>Trajet</span>
                            <span class="text-primary">'.ReadVille($value->depart).'-'.ReadVille($value->arrive).'</span>
                        </div>

                        <div class="d-flex justify-content-between border-bottom py-2">
                            <span>Place dispo</span>
                            <span class="text-primary">
                             <b>'.$value->placedispo.'</b>
                            </span>
                        </div>
                        <div class="d-flex justify-content-between border-bottom py-2">
                            <span>Coût</span>
                            <span class="text-primary">
                             <b>'.$value->montant.' fcfa / place</b>
                            </span>
                        </div>
                        <div class="d-flex justify-content-between  pt-2">
                            <span>Unité</span>
                            <span class="text-dark"> '.ReadUnites($value->unite).' </span>
                        </div>




                    </div>
                </div>
            </div>
            ';
          }
        }

      }
    }

    //Bloquer la course publiée
    $output.="<script type='text/javascript'>
    $('.lock').click(function(){
      var id = $(this).attr('id');
      var tel = $(this).attr('tel');
      var code = $(this).attr('code');
      var data = {id:id,tel:tel,code:code};
      console.log(data);
      Swal.fire({
           title: 'Transporteur',
           text: 'Voulez-vous bloquer l\'offre '+code+' ?',
           icon: 'error',
           showCancelButton: true,
           confirmButtonColor: '#3085d6',
           cancelButtonColor: '#d33',
           cancelButtonText: 'non',
           confirmButtonText: 'oui , bloquer!',
           backdrop: `rgba(240,15,83,0.4)`
         }).then((result)=>{
             if (result.value) {
                $.ajax({
                  url:'lockOf',
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
                     window.location='course_pub';
                    }


                   },
                   error:function(data){
                      console.log(data);
                   }
                });
             }
         });
    });
    </script>";


    return $output;

  }
  //Bloquer une course
  function lockOf(Request $request)
  {
    $id = $request->id;
    upoffre($id,1);
    return response()->json(['code' => '2'],200);
  }

  #GESTION des transporteurs
  //Filtre de recherche des demandes rejetés
  function SearchDemdno(Request $request)
  {
    $output = '';
    $transp = filtreTransp($request->attribut,$request->valeur);
    $nbT = count($transp);
    if ($nbT==0) {
      $output.='
      <div class="col-lg-12 alert alert-danger" role="alert">
         Aucun transporteur disponible
      </div>';
    }else{
      foreach ($transp as $key => $value) {
       if ($value->statut==2) {
        $output.='
          <div class="col-xl-3 col-lg-6 col-md-6 col-12">
            <!-- Card -->
            <div class="card mb-4">
              <!-- Card body -->
              <div class="card-body">
                 <div class="text-center">
                     <h4 class="mb-0">'.$value->nomT.' '.$value->prenomT.'</h4>
                     <p class="mb-0">Nom: <b>'.$value->nomT.'</b></p>
                     <p class="mb-0">Prénom: <b>'.$value->prenomT.'</b></p>
                     <p class="mb-0">Matricule: <b>'.$value->matricule.'</b></p>
                     <p class="mb-0">Tel: <b>'.$value->telT.'</b></p>
                     <p class="mb-0">Pass: <b>'.$value->passT.'</b></p>
                     <p class="mb-0">crée le '.$value->created_at.'</p>
                 </div>

                 <div class="d-flex justify-content-between pt-2">
                     <span class="text-dark">
                         <span class="badge badge-success valid"
                               id='.$value->id.'
                               nom='.$value->telT.'
                               nm='.$value->nomT.'
                               pass='.$value->passT.'
                               type="button" data-toggle="modal"
                               data-target="#exampleModalLong">
                             valider
                         </span>
                     </span>

                     <span class="badge badge-danger rejete"
                           id='.$value->id.'
                           nom='.$value->telT.'
                           pass='.$value->passT.'
                           type="button" data-toggle="modal"
                           data-target="#exampleModalLong">
                     refuser
                    </span>
                 </div>
                 </div>
             </div>
         </div>
        ';
       }
      }

    }
    //Validation de la demande
    $output.="<script type='text/javascript'>
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
    </script>";

    //Rejet de la demande
    $output.="<script type='text/javascript'>
    $('.rejete').click(function(){
      var code = $(this).attr('nom');
      var id   = $(this).attr('id');
      var data = {id:id,code:code};
      console.log(data);
      Swal.fire({
           title: 'Transporteur',
           text: 'Voulez-vous rejeter la demande du '+code+' ?',
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
                  url:'RejtDemd',
                  method:'GET',
                  data:data,
                  dataType:'json',
                   success:function(data){
                    if (data.code==2) {
                     Swal.fire({
                       position: 'top-end',
                       icon: 'success',
                       title: 'La demande '+code+' a été rejetée avec succès',
                       showConfirmButton: false,
                       timer: 1500
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
    </script>";

    return $output;
  }
  //Filtre de recherche des demandes validées
  function SearchDemdok(Request $request)
  {
    $output = '';
    $transp = filtreTransp($request->attribut,$request->valeur);
    $nbT = count($transp);
    if ($nbT==0) {
      $output.='
      <div class="col-lg-12 alert alert-danger" role="alert">
         Aucun transporteur disponible
      </div>';
    }else{
      foreach ($transp as $key => $value) {
       if ($value->statut==1) {
        $output.='
          <div class="col-xl-3 col-lg-6 col-md-6 col-12">
            <!-- Card -->
            <div class="card mb-4">
              <!-- Card body -->
              <div class="card-body">
                 <div class="text-center">
                     <h4 class="mb-0">'.$value->nomT.' '.$value->prenomT.'</h4>
                     <p class="mb-0">Nom: <b>'.$value->nomT.'</b></p>
                     <p class="mb-0">Prénom: <b>'.$value->prenomT.'</b></p>
                     <p class="mb-0">Matricule: <b>'.$value->matricule.'</b></p>
                     <p class="mb-0">Tel: <b>'.$value->telT.'</b></p>
                     <p class="mb-0">Pass: <b>'.$value->passT.'</b></p>
                     <p class="mb-0">crée le '.$value->created_at.'</p>
                 </div>

                 <div class="d-flex justify-content-between pt-2">
                     <span class="text-dark">
                         <span class="badge badge-success valid"
                               id='.$value->id.'
                               nom='.$value->telT.'
                               nm='.$value->nomT.'
                               pass='.$value->passT.'
                               type="button" data-toggle="modal"
                               data-target="#exampleModalLong">
                             valider
                         </span>
                     </span>

                     <span class="badge badge-danger rejete"
                           id='.$value->id.'
                           nom='.$value->telT.'
                           pass='.$value->passT.'
                           type="button" data-toggle="modal"
                           data-target="#exampleModalLong">
                     refuser
                    </span>
                 </div>
                 </div>
             </div>
         </div>
        ';
       }
      }

    }
    //Validation de la demande
    $output.="<script type='text/javascript'>
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
                     window.location='transp_valide';
                    }

                    if (data.code==1) {
                      Swal.fire({
                        position: 'top-end',
                        icon: 'error',
                        title: 'Votre volume SMS est insuffisant',
                        showConfirmButton: false,
                        timer: 5000
                      });
                      window.location='transp_demande';
                    }
                   },
                   error:function(data){
                      console.log(data);
                   }
                });
             }
         });
    });
    </script>";

    //Rejet de la demande
    $output.="<script type='text/javascript'>
    $('.rejete').click(function(){
      var code = $(this).attr('nom');
      var id   = $(this).attr('id');
      var data = {id:id,code:code};
      console.log(data);
      Swal.fire({
           title: 'Transporteur',
           text: 'Voulez-vous rejeter la demande du '+code+' ?',
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
                  url:'RejtDemd',
                  method:'GET',
                  data:data,
                  dataType:'json',
                   success:function(data){
                    if (data.code==2) {
                     Swal.fire({
                       position: 'top-end',
                       icon: 'success',
                       title: 'La demande '+code+' a été rejetée avec succès',
                       showConfirmButton: false,
                       timer: 1500
                     });
                     window.location='transp_valide';
                    }
                   },
                   error:function(data){
                      console.log(data);
                   }
                });
             }
         });
    });
    </script>";

    return $output;
  }

  //Filtre de recherche des nouvelles demandes
  function SearchDemd(Request $request)
  {
    $output = '';
    $transp = filtreTransp($request->attribut,$request->valeur);
    $nbT = count($transp);
    if ($nbT==0) {
      $output.='
      <div class="col-lg-12 alert alert-danger" role="alert">
         Aucun transporteur disponible
      </div>';
    }else{
      foreach ($transp as $key => $value) {
       if ($value->statut==0) {
        $output.='
          <div class="col-xl-3 col-lg-6 col-md-6 col-12">
            <!-- Card -->
            <div class="card mb-4">
              <!-- Card body -->
              <div class="card-body">
                 <div class="text-center">
                     <h4 class="mb-0">'.$value->nomT.' '.$value->prenomT.'</h4>
                     <p class="mb-0">Nom: <b>'.$value->nomT.'</b></p>
                     <p class="mb-0">Prénom: <b>'.$value->prenomT.'</b></p>
                     <p class="mb-0">Matricule: <b>'.$value->matricule.'</b></p>
                     <p class="mb-0">Tel: <b>'.$value->telT.'</b></p>
                     <p class="mb-0">Pass: <b>'.$value->passT.'</b></p>
                     <p class="mb-0">crée le '.$value->created_at.'</p>
                 </div>

                 <div class="d-flex justify-content-between pt-2">
                     <span class="text-dark">
                         <span class="badge badge-success valid"
                               id='.$value->id.'
                               nom='.$value->telT.'
                               nm='.$value->nomT.'
                               pass='.$value->passT.'
                               type="button" data-toggle="modal"
                               data-target="#exampleModalLong">
                             valider
                         </span>
                     </span>

                     <span class="badge badge-danger rejete"
                           id='.$value->id.'
                           nom='.$value->telT.'
                           pass='.$value->passT.'
                           type="button" data-toggle="modal"
                           data-target="#exampleModalLong">
                     refuser
                    </span>
                 </div>
                 </div>
             </div>
         </div>
        ';
       }
      }

    }
    //Validation de la demande
    $output.="<script type='text/javascript'>
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
                     window.location='transp_demande';
                    }

                    if (data.code==1) {
                      Swal.fire({
                        position: 'top-end',
                        icon: 'error',
                        title: 'Votre volume SMS est insuffisant',
                        showConfirmButton: false,
                        timer: 5000
                      });
                      window.location='transp_demande';
                    }
                   },
                   error:function(data){
                      console.log(data);
                   }
                });
             }
         });
    });
    </script>";

    //Rejet de la demande
    $output.="<script type='text/javascript'>
    $('.rejete').click(function(){
      var code = $(this).attr('nom');
      var id   = $(this).attr('id');
      var data = {id:id,code:code};
      console.log(data);
      Swal.fire({
           title: 'Transporteur',
           text: 'Voulez-vous rejeter la demande du '+code+' ?',
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
                  url:'RejtDemd',
                  method:'GET',
                  data:data,
                  dataType:'json',
                   success:function(data){
                    if (data.code==2) {
                     Swal.fire({
                       position: 'top-end',
                       icon: 'success',
                       title: 'La demande '+code+' a été rejetée avec succès',
                       showConfirmButton: false,
                       timer: 1500
                     });
                     window.location='transp_demande';
                    }
                   },
                   error:function(data){
                      console.log(data);
                   }
                });
             }
         });
    });
    </script>";


    return $output;
  }

  //Rejeter la demande
  function RejtDemd(Request $request)
  {
    $res = UpTransp(2,$request->id);
    return response()->json(['code' => '2'],200);
  }
  //Validation des demandes
   function ValDemd(Request $request)
   {
     $res = UpTransp(1,$request->id);
     $tel = $request->code;
     $sender = 'GRENIER';
     $msg = 'Bjr '.$request->nm.' votre compte GRENIER est actif, connectez-vous avec tel:'.$request->code.' password:'.$request->pass.' .cliquez ici grenier.ci/sign';
     try {
       SMS($msg,$tel,$sender);
       return response()->json(['code' => '2'],200);
     } catch (\Exception $e) {
        return response()->json(['code' => '1'],200);
     }

   }

  # Gestion des Zones
  //Modifcation de la zone
  function UpZn(Request $request)
  {
    $stat = 0;
    $zone = $request->code;
    $id = $request->id;
    $data = ['zone'=>$zone,'id'=>$id];
    $res = UpZone($zone,$stat,$id);
    return response()->json(['code' => '2'],200);
  }
  //Supprimer une zone
  function DelZn(Request $request)
  {
    $stat = 1;
    $zone = $request->code;
    $id = $request->id;
    $res = UpZone($zone,$stat,$id);
    return response()->json(['code' => '2'],200);
  }

   // Ajout d'une nouvelle zone
   function addZ(Request $request)
   {
     $zn = $request->zone;
     $zone = AddZone($zn);
     return redirect('zone');
   }

   #GEstion des coordonnes admin
   function upAd(Request $request)
   {
     $usern = $request->usern;
     $pass  = $request->pass;
     $dataUp = ['mail'=>$usern,'pass'=>$pass];
     $res = DB::table('admins')
                 ->where('admins.id', '=',1)
                 ->update($dataUp);
     return redirect('coordonnes');
   }

}

<?php
use Illuminate\Support\Facades\DB;
use App\Models\Ville;
use App\Models\Unite;
use App\Models\Transporteur;
use App\Models\Offres;
use App\Models\User;
use App\Models\OffreHasClient;

#demarrage de session
session_start();
#Gesion Admin
function readAd()
{
  $admin = DB::table('admins')->orderBy('id', 'desc')->first();
  return $admin;
}

#Gestion des commandes
//Statut du solde
function UpdComdSolde($stat,$code)
{
  $dataUp = ['statut'=>$stat];
  $res = DB::table('offre_has_clients')
                 ->where('offre_has_clients.code','=',$code)
                 ->update($dataUp);
  return $res;
}
//Courses vehicule
function readVehID($id)
{
  $courses = DB::table('offres')->orderBy('id','desc')->where('offres.id','=',$id)->first();
  return $courses->vehicule;
}
//Courses depart
function readDeptID($id)
{
  $courses = DB::table('offres')->orderBy('id','desc')->where('offres.id','=',$id)->first();
  return $courses->depart;
}
//Courses Arrive
function readArrivID($id)
{
  $courses = DB::table('offres')->orderBy('id','desc')->where('offres.id','=',$id)->first();
  return $courses->arrive;
}
//Courses montant
function readMontantID($id)
{
  $courses = DB::table('offres')->orderBy('id','desc')->where('offres.id','=',$id)->first();
  return $courses->montant;
}


//Filtre automatique des commandes
function filtreComd($attribut,$valeur,$stat)
{
  $res = OffreHasClient::query()->where($attribut, 'LIKE', "%{$valeur}%")
                                ->where('offre_has_clients.livraison', '=',$stat)
                                ->get();
  return $res;
}

//Lecture de toutes les commandes
function ReadComd($stat)
{
  $course = DB::table('offre_has_clients')
            ->join('offres', 'offre_has_clients.offre_id', '=', 'offres.id')
            ->select('offre_has_clients.*', 'offres.*','offres.id as offID','offres.code as offcode','offre_has_clients.code as cmdCode','offre_has_clients.created_at as cdd')
            ->where('offre_has_clients.livraison','=',$stat)
            ->get();
  return $course;
}

//Mise en etat du statut des commandes
function UpdComd($livre,$code)
{
  $dataUp = ['livraison'=>$livre];
  $res = DB::table('offre_has_clients')
                 ->where('offre_has_clients.code','=',$code)
                 ->update($dataUp);
  return $res;
}

#Gestion des courses
//Filtre de recherche en fonction de l'id_user
function filtreCourses($iduser)
{
  $course = DB::table('offres')
            ->join('transporteurs', 'offres.transporteur_id', '=', 'transporteurs.id')
            ->select('transporteurs.*', 'offres.*', 'transporteurs.id as transpID','offres.id as offID')
            ->where('offres.user_id','=',$iduser)
            ->get();
  return $course;
}
//Filtre de Recherhce des courses
function filtreCourse($attribut,$valeur)
{
  $res = Offres::query()->where($attribut, 'LIKE', "%{$valeur}%")
                  ->orderBy('id', 'desc')
                  ->select('offres.*','offres.id as offID')
                  ->get();
  return $res;
}
//Lecture des courses
function ReadCours($stat)
{
  $course = DB::table('offres')
            ->join('transporteurs', 'offres.transporteur_id', '=', 'transporteurs.id')
            ->select('transporteurs.*', 'offres.*', 'transporteurs.id as transpID','offres.id as offID')
            ->where('offres.etat','=',$stat)
            ->get();
  return $course;
}

#Gestion des transporteurs

//Filtre de recherche
function filtreTransp($attribut,$valeur)
{
  //$res = DB::table('clients')->where($attribut,'=',$valeur)->orderBy('id', 'desc')->get();
  $res = Transporteur::query()->where($attribut, 'LIKE', "%{$valeur}%")
                  ->orderBy('id', 'desc')->get();
  return $res;
}

//Modification des transporteurs
function UpTransp($stat,$id)
{
  $dataUp = ['statut'=>$stat];
  $res = DB::table('transporteurs')
                 ->where('transporteurs.id', '=', $id)
                 ->update($dataUp);
  return $res;

}

//Lecture des demandes
function ReadTransp($stat)
{
  $transp = DB::table('transporteurs')
            ->join('users', 'transporteurs.user_id', '=', 'users.id')
            ->select('transporteurs.*', 'users.*', 'transporteurs.id as transpID','users.id as usID')
            ->where('transporteurs.statut','=',$stat)
            ->get();
  return $transp;
}
//Lecture des transporteurs en fonction de l'id
function ReadTranspID($id)
{
  $transp = DB::table('transporteurs')
                ->join('users', 'transporteurs.user_id','=','users.id')
                ->select('transporteurs.*','users.*')
                ->where('transporteurs.id','=',$id)
                ->first();
  return $transp;
}

# Gestion des zones
function UpZone($zone,$stat,$id)
{
  $dataUp = ['nom'=>$zone,'statut'=>$stat];
  $res = DB::table('villes')
                 ->where('villes.id', '=', $id)
                 ->update($dataUp);
  return $res;

}

function AddZone($zone)
{
  // Verification
  $zones = DB::table('villes')
            ->where('nom', '=', $zone)
            ->get();
  $nb = count($zones);
  if ($nb==0)
  {
    $dataZone = ['nom'=>$zone,'statut'=>0];
    Ville::create($dataZone);
  }
}

function ReadZone()
{
  $zone = DB::table('villes')->orderBy('id', 'desc')->where('statut','=','0')->get();
  return $zone;
}

# Gestion des unités
function AddUnite($unite)
{
  // Verification
  $unites = DB::table('unites')
            ->where('unite', '=', $unite)
            ->get();
  $nb = count($unites);
  if ($nb==0)
  {
    $dataUnite = ['unite'=>$unite];
    Unite::create($dataUnite);
  }
}
function ReadUnite()
{
  $unite = DB::table('unites')->orderBy('id', 'desc')->get();
  return $unite;
}

# Lecture des offres en fonction du client
function offre($user)
{
  $offres = DB::table('offres')
            ->join('users', 'offres.user_id','=','users.id')
            ->join('villes', 'offres.depart','=','villes.id')
            ->select('offres.*','users.*','offres.id as offID','users.id as Usid')
            ->where('users.id', '=', $user)
            ->where('offres.etat', '=',0)
            ->get();
  return $offres;
}

#Lecture des villes depart et arrive
function ReadVille($id)
{
  $villes = DB::table('villes')->where('villes.id','=',$id)->first();
  $nom = $villes->nom;
  return $nom;
}

#Lecture des unités
function ReadUnites($id)
{
  $unites = DB::table('unites')->where('unites.id','=',$id)->first();
  $unit = $unites->unite;
  return $unit;
}

#Gestion des Offres
    //Filtre de Recherche
    // function filtreOff($attribut,$v)


   //Mise à jour des offres
   function upoffre($id,$stat)
   {
     $res = DB::table('offres')->where('offres.id', '=', $id)->update(['etat' => $stat]);
     return $res;
   }

  // Suppression d'une offre
   function delOffre($id)
   {
     $res = DB::table('offres')->where('offres.id', '=', $id)->update(['etat' => 1]);
     return $res;
   }

   function ReadOf($etat)
   {
     $offres = DB::table('offres')
               ->join('users', 'offres.user_id','=','users.id')
               ->select('offres.*','users.*','offres.id as Ofid')
               ->where('offres.etat', '=', $etat)
               ->where('offres.placedispo', '>',0)
               ->orderBy('offres.id', 'desc')
               ->get();
     return $offres;
   }

   function checkOf($etat,$depart,$arrive,$unite)
   {
     $offres = DB::table('offres')
               ->join('users', 'offres.user_id','=','users.id')
               ->select('offres.*','users.*','offres.id as Ofid')
               ->where('offres.etat', '=', $etat)
               ->where('offres.depart', '=', $depart)
               ->where('offres.arrive', '=', $arrive)
               ->where('offres.unite', '=', $unite)
               ->where('offres.placedispo', '>',0)
               ->orderBy('offres.id', 'desc')
               ->get();
     return $offres;
   }

   function ReadOff($idof)
   {
     $offres = DB::table('offres')
               ->join('users', 'offres.user_id','=','users.id')
               ->select('offres.*','users.*','offres.id as Ofid')
               ->where('offres.id', '=', $idof)
               ->orderBy('offres.id', 'desc')
               ->first();
     return $offres;
   }

   function upPlace($place,$idof)
   {
     $res = DB::table('offres')
                 ->where('offres.id', '=', $idof)
                 ->update(['placedispo'=>$place]);
   }


#Gestion des transporteur
 //Selection de l'id transporteur en fonction de l'id user
 function transpID($user)
 {
   $transp =  DB::table('transporteurs')->where('transporteurs.user_id','=',$user)->first();
   $idtransp = $transp->id;
   return $idtransp;
 }

# Gestion des réservations
function reserv($user,$statut)
{
  $offres = DB::table('offre_has_clients')
            ->join('users', 'offre_has_clients.user_id','=','users.id')
            ->join('offres', 'offre_has_clients.offre_id','=','offres.id')
            ->select('offre_has_clients.*','offres.*','offres.id as Usid','offre_has_clients.updated_at as livdate','offre_has_clients.created_at as cdd','offre_has_clients.code as code','offres.code as cde')
            ->where('offre_has_clients.user_id', '=', $user)
            ->where('offre_has_clients.statut', '=', $statut)
            ->get();
  return $offres;
}

function addreserv($offre_id,$transporteur_id,$qte,$arret,$date,$numPaiement,$statut,$livraison,$code,$user_id)
{
  $dataReserv = ['offre_id'=>$offre_id,
                 'offre_transporteur_id'=>$transporteur_id,
                 'qte'=>$qte,
                 'arret'=>$arret,
                 'date'=>$date,
                 'numpaiement'=>$numPaiement,
                 'statut'=>$statut,
                 'livraison'=>$livraison,
                 'code'=>$code,
                 'user_id'=>$user_id];
   $res = DB::table('offre_has_clients')->insert($dataReserv);
   return $res;
}

function paiement($numpaiement,$statut)
{
  $datapay = ['numpaiement'=>$numpaiement,'statut'=>$statut];
  $res = DB::table('paiements')->insert($datapay);
  return $res;
}

#Gestion des transporteurs
function transp($id)
{
  $transp = DB::table('transporteurs')
            ->join('users', 'transporteurs.user_id','=','users.id')
            ->select('transporteurs.*','users.*','users.id as Usid','transporteurs.id as Tpsid')
            ->where('transporteurs.id', '=', $id)
            ->get();
  return $transp;
}

function transpTel($id)
{
  $transp = DB::table('transporteurs')
            ->join('users', 'transporteurs.user_id','=','users.id')
            ->select('transporteurs.*','users.*','users.id as Usid','transporteurs.id as Tpsid')
            ->where('transporteurs.id', '=', $id)
            ->first();
  return $transp->tel;
}

function transpNom($id)
{
  $transp = DB::table('transporteurs')
            ->join('users', 'transporteurs.user_id','=','users.id')
            ->select('transporteurs.*','users.*','users.id as Usid','transporteurs.id as Tpsid')
            ->where('transporteurs.id', '=', $id)
            ->first();
  $nomT = $transp->nom.' '.$transp->prenom;
  return $nomT;
}

function transpProf($id)
{
  $transp = DB::table('transporteurs')
            ->join('users', 'transporteurs.user_id','=','users.id')
            ->select('transporteurs.*','users.*','users.id as Usid','transporteurs.id as Tpsid')
            ->where('transporteurs.id', '=', $id)
            ->first();
  return $transp->profile;
}

#Gestion des users
function filtreUser($attribut,$valeur)
{
  $res = User::query()->where($attribut, 'LIKE', "%{$valeur}%")
                  ->orderBy('id', 'desc')
                  ->get();
  return $res;
}

function userAll()
{
  $user = DB::table('users')
              ->select('users.*')
              ->get();
  return $user;
}

function userTel($id)
{
  $user = DB::table('users')->where('users.id','=',$id)->first();
  return $user->tel;
}

function userID($tel)
{
  $user = DB::table('users')->where('users.tel','=',$tel)->first();
  return $user->id;
}

function userPNom($id)
{
  $user = DB::table('users')->where('users.id','=',$id)->first();
  return $user->prenom;
}

function usernNom($id)
{
  $user = DB::table('users')->where('users.id','=',$id)->first();
  return $user->nom;
}



function userNom($id)
{
  $user = DB::table('users')->where('users.id','=',$id)->first();
  return $user->nom." ".$user->prenom;
}

function userProfil($id)
{
  $user = DB::table('users')->where('users.id','=',$id)->first();
  return $user->profile;
}

#Gestion des livraison
function livr($transp,$statut)
{
  $offres = DB::table('offre_has_clients')
            ->join('users', 'offre_has_clients.user_id','=','users.id')
            ->join('offres', 'offre_has_clients.offre_id','=','offres.id')
            ->select('offre_has_clients.*','offres.*','offres.id as Offid','offres.user_id as OffUser','offre_has_clients.user_id as offClient','offre_has_clients.created_at as licd','offre_has_clients.code as code','offres.code as cde')
            ->where('offre_has_clients.offre_transporteur_id', '=', $transp)
            ->where('offre_has_clients.livraison', '=', $statut)
            ->get();
  return $offres;
}

#Gestion des notifications
 //SMS
 function SMS($msg,$tel,$sender)
 {
    // Filtrer le messages
         $nvMsg = str_replace('à','a', $msg);
         $nvMsg = str_replace('á','a', $nvMsg);
         $nvMsg = str_replace('â','a', $nvMsg);
         $nvMsg = str_replace('ç','c', $nvMsg);
         $nvMsg = str_replace('è','e', $nvMsg);
         $nvMsg = str_replace('é','e', $nvMsg);
         $nvMsg = str_replace('ê','e', $nvMsg);
         $nvMsg = str_replace('ë','e', $nvMsg);
         $nvMsg = str_replace('ù','u', $nvMsg);
         $nvMsg = str_replace('ù','u', $nvMsg);
         $nvMsg = str_replace('ü','u', $nvMsg);
         $nvMsg = str_replace('û','u', $nvMsg);
         $nvMsg = str_replace('ô','o', $nvMsg);
         $nvMsg = str_replace('î','i', $nvMsg);
         $key = "46635f08c5ee833a42aa16e3273fd1";
         $api = 'Authorization: Bearer '.$key."";
         // Step 1: Créer la campagne
         $curl = curl_init();
         $datas= [
           'step' => NULL,
           'sender' => $sender,
           'name' => 'SMS GRENIER',
           'campaignType' => 'SIMPLE',
           'recipientSource' => 'CUSTOM',
           'groupId' => NULL,
           'filename' => NULL,
           'saveAsModel' => false,
           'destination' => 'NAT_INTER',
           'message' => $msg,
           'emailText' => NULL,
           'recipients' =>
           [
             [
               'phone' => $tel,
             ],
           ],
           'sendAt' => [],
           'dlrUrl' => NULL,
           'responseUrl' => NULL,
         ];
         curl_setopt_array($curl, array(
           CURLOPT_URL => 'https://api.letexto.com/v1/campaigns',
           CURLOPT_RETURNTRANSFER => true,
           CURLOPT_ENCODING => '',
           CURLOPT_MAXREDIRS => 10,
           CURLOPT_TIMEOUT => 0,
           CURLOPT_FOLLOWLOCATION => true,
           CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
           CURLOPT_CUSTOMREQUEST => 'POST',
           CURLOPT_POSTFIELDS =>json_encode($datas),
           CURLOPT_HTTPHEADER => array(
             $api,
             'Content-Type: application/json'
           ),
         ));
         $response = curl_exec($curl);
         curl_close($curl);
         $res = json_decode($response);
         $camp_id = $res->id;

         // Step2: Programmer la campagne
         $curl_send = curl_init();
         curl_setopt_array($curl_send, array(
           CURLOPT_URL => 'https://api.letexto.com/v1/campaigns/'.$camp_id.'/schedules',
           CURLOPT_RETURNTRANSFER => true,
           CURLOPT_ENCODING => '',
           CURLOPT_MAXREDIRS => 10,
           CURLOPT_TIMEOUT => 0,
           CURLOPT_FOLLOWLOCATION => true,
           CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
           CURLOPT_CUSTOMREQUEST => 'POST',
           CURLOPT_HTTPHEADER => array(
             $api
           ),
         ));
         $response_send = curl_exec($curl_send);
         curl_close($curl_send);
         return $response_send;
   }

 function SMSVolume()
 {
   $key = "46635f08c5ee833a42aa16e3273fd1";
   $api = 'Authorization: Bearer '.$key."";
   //Créer de la requête
   $curl = curl_init();
   curl_setopt_array($curl, array(
     CURLOPT_URL => 'https://api.letexto.com/v1/user-volume',
     CURLOPT_RETURNTRANSFER => true,
     CURLOPT_ENCODING => '',
     CURLOPT_MAXREDIRS => 10,
     CURLOPT_TIMEOUT => 0,
     CURLOPT_FOLLOWLOCATION => true,
     CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
     CURLOPT_CUSTOMREQUEST => 'GET',
     //CURLOPT_POSTFIELDS =>json_encode($datas),
     CURLOPT_HTTPHEADER => array(
       $api,
       'Content-Type: application/json'
     ),
   ));
   $response = curl_exec($curl);
   curl_close($curl);
   $res = json_decode($response);
   $text = "
   Volume National: ".$res->national." SMS / Volume International: ".$res->international." SMS";
   return $text;
 }

 function emailNotif($from,$to,$titre,$msg)
 {
    $from = $from;
    $to =$to;
    $subject = $titre;
    $message = $msg;
    $headers = "From:" . $from;
    mail($to,$subject,$message, $headers);
 }

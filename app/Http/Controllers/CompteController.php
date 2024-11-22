<?php
namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Users;
use App\Models\Transporteur;
use App\Models\Admin;
use App\Models\Offres;
use App\Cinetpay\Cinetpay;


class CompteController extends Controller
{
  // Création de compte client
   public function creatcount(Request $request)
   {
       $nom = $request->nom;
       $prenom = $request->prenom;
       $tel = '225'.$request->tel;
       $password = $request->password;
       // Data user
       $user = ['prenom'=>$prenom,
                'nom' =>$nom,
                'tel'=>$tel,
                'password'=>$password];
      // Verification du compte
      $res = Users::where('tel','=',$tel)->first();
      if ($res=='') {
        // Creation de compte user
        $idus = Users::create($user);
        //$transpdata = ['matricule'=>'default','photo'=>'null','user_id'=>$idus->id,'statut'=>3];
        $transpdata =  ['matricule'=>'NNNN','photo'=>'null',
                        'user_id'=>$idus->id,'code'=>'NNN','nomT'=>$nom,'prenomT'=>$prenom,
                        'telT'=>$tel,'passT'=>$password,'statut'=>1];
        //dd($transpdata);
        $trans = Transporteur::create($transpdata);

        // Retour json

        $_SESSION['nom'] = $nom;
        $_SESSION['prenom'] = $prenom;
        $_SESSION['tel'] = $tel;
        $_SESSION['password'] = $password;
        $_SESSION['id_user'] = $idus->id;
        $_SESSION['profile'] = $idus->profile;
        return response()->json(['code' => '1'],200);

      }
      else {
          return response()->json(['code' => '2'],200);
      }

   }

   // Connection au compte client
   public function login(Request $request)
   {
      $tel = $request->tel;
      $password = $request->password;
      // Verification
      $restel  = Users::where('tel','=',$tel)->first();
      $respass = Users::where('password','=',$password)->first();
      if ($restel!='' AND $respass!='') {
        $_SESSION['nom'] = $restel->nom;
        $_SESSION['id_user'] = $restel->id;
        $_SESSION['profile'] = $restel->profile;
        $_SESSION['prenom'] = $restel->prenom;
        $_SESSION['tel'] = $restel->tel;
        $_SESSION['password'] = $restel->password;
        //dd($_SESSION['tel']);
        return response()->json(['code' => '1'],200);
      }elseif ($restel=='') {
        return response()->json(['code' => '3'],200);
      }elseif ($respass=='') {
        return response()->json(['code' => '2'],200);
      }else {
        return response()->json(['code' => '0'],200);
      }
   }

   // Récupération de mot de pass
   public function passRecp(Request $request)
   {
     $nom       = $request->nom;
     $prenom    = $request->prenom;
     $tel       = '225'.$request->tel;
     $restel    = Users::Where('tel','=',$tel)->first();
     $resnom    = Users::Where('nom','=',$nom)->first();
     $resprenom = Users::Where('prenom','=',$prenom)->first();
     if ($restel!=''&&$resprenom!='') {
       $pass = $restel->password;
       return response()->json(['code' => '1','pass'=>$pass],200);
     }else {
       return response()->json(['code' => '2'],200);
     }

   }

   // Connection au compte administrateurs
   public function logAd(Request $request)
   {
      
      $mail = $request->mail;
      $pass = $request->pass;
      $resmail    = Admin::Where('mail','=',$mail)->first();
      $respass    = Admin::Where('pass','=',$pass)->first();
      //dd($resmail,$respass);
      if ($resmail!=''&& $respass!='') {
         $_SESSION['mail'] = $respass->mail;
         return response()->json(['code' => '1'],200);
      }else {
         return response()->json(['code' => '2'],200);
      }
   }

   // Déconnection au compte
   public function logout()
   {
     session_destroy();
     return redirect('/');
   }

   // Mise à jour des comptes
   public function upcompte(Request $request)
   {
      $lien  = env('LIEN_FILE');
      $file  = $request->profile;
      if ($file!='') {
        $path  = $file->store('profile','public');
        $photo = $lien.$path;
        $nom = $request->nom;
        $prenom = $request->prenom;
        $phone = $request->phone;
        $password = $request->password;
        $dataupd = ['prenom'=>$prenom,'nom'=>$nom,'tel'=>$phone,'password'=>$password,'profile'=>$photo];
        $res = Users::where('id',$_SESSION['id_user'])->update($dataupd);
        $_SESSION['nom'] = $nom;
        $_SESSION['profile'] = $photo;
        $_SESSION['prenom'] = $prenom;
        $_SESSION['tel'] = $phone;
        $_SESSION['password'] = $password;
        return redirect("mon_comptes");
      }else{
        $nom = $request->nom;
        $prenom = $request->prenom;
        $phone = $request->phone;
        $password = $request->password;
        $dataupd = ['prenom'=>$prenom,'nom'=>$nom,'tel'=>$phone,'password'=>$password];
        $res = Users::where('id',$_SESSION['id_user'])->update($dataupd);
        $_SESSION['nom'] = $nom;
        $_SESSION['prenom'] = $prenom;
        $_SESSION['tel'] = $phone;
        $_SESSION['password'] = $password;
        return redirect("mon_comptes");
      }
      // dd($res);
   }

   // Becom transporteur
   public function begintransp(Request $request)
   {
     $lien  = env('LIEN_FILE');
     $file  = $request->photo;
     $path  = $file->store('vehicule','public');
     $vehicule = $lien.$path;
     $matricule = $request->matricule;
     $transpdata = ['matricule'=>$matricule,'photo'=>$vehicule,'user_id'=>$_SESSION['id_user']];
     Transporteur::create($transpdata);
     $_SESSION['error_transp'] = "Votre demande a été pris en compte nous vous contactons dans 24h!";
     return redirect('/mon_comptes');
     //dd($transpdata);
   }

   // Poster une offre
   public function addOffre(Request $request)
   {
     $lien  = env('LIEN_FILE');
     $prix  = $request->prix;
     $file  = $request->vehicule;
     $path  = $file->store('vehicule','public');
     $vehicule = $lien.$path;
     $depart = $request->depart;
     $arrive = $request->arrive;
     $places = $request->places;
     $unite  = $request->unite;
     $code   = date("YmdHis").'off';
     $debut  = date('Y-m-d');
     $fin    = $request->fin_date;
     $data   = ['debut'=>$debut,'fin'=>$fin];
     $idtransp = transpID($_SESSION['id_user']);
     $dataOffre = ['depart'=>$depart,'arrive'=>$arrive,'placedispo'=>$places,'montant'=>$prix,
                   'transporteur_id'=>$idtransp,'user_id'=>$_SESSION['id_user'],'vehicule'=>$vehicule,
                   'unite'=>$unite,'date'=>$debut,'code'=>$code,'fin'=>$fin];
     // dd($dataOffre);
     $offre = Offres::create($dataOffre);
     $_SESSION['error_transp'] = "Nouvelle Offre: Votre offre a été publiée avec succès";
     return redirect('/mon_comptes');

   }

   // Creation de compte transporteur
   public function addtransporteur(Request $request)
   {
     $lien  = env('LIEN_FILE');
     //$file  = $request->photo;
     //$path  = $file->store('vehicule','public');
     //$photo = $lien.$path;
     $nom = $request->nom;
     $prenom = $request->prenom;
     $tel = '225'.$request->tel;
     $matricule = $request->matricule;
     $password = rand(100,100000000);

     $restel    = Users::Where('tel','=',$tel)->first();
     $resnom    = Users::Where('nom','=',$nom)->first();
     $resprenom = Users::Where('prenom','=',$prenom)->first();


       if ($restel!='' AND $resprenom!='' AND $resnom!='') {
           $_SESSION['nom'] = $nom.' '.$prenom;
           $_SESSION['error_transp'] = "Ce compte existe déjà, veuillez changer votre numéro de téléphone";
           return redirect('/transporteur');
       }else{
         $userdata = ['nom'=>$nom,'prenom'=>$prenom,'tel'=>$tel,'password'=>$password];
         $user = Users::create($userdata);
         $user_id = $user->id;
         $code = rand(5,1000).$nom;
         $transpdata = ['matricule'=>$matricule,'photo'=>'photo','user_id'=>$user_id,'code'=>$code,'nomT'=>$nom,'prenomT'=>$prenom,'telT'=>$tel,'passT'=>$password,'statut'=>'0'];
         Transporteur::create($transpdata);
         $_SESSION['nom'] = $nom.' '.$prenom;
         $_SESSION['error_transp'] = "Devenir transporteur: Votre demande a été pris en compte nous vous contactons dans 24h!";
         return redirect('/transporteur');
       }

   }

   // Gestion de compte user
   public function mon_comptes()
   {
     //$users = Users::where('id',$_SESSION['id_user'])->first();
     return view('entreprise');
   }

   // Suppression d'une offre
   public function delOf(Request $request)
   {
     $res = delOffre($request->idOf);
     $_SESSION['error_transp'] = "Offre Supprimée avec succès";
     return response()->json(['code' => '2'],200);
   }

   //Lecture des infos offres
   public function readoff(Request $request)
   {
      $infos  = ReadOff($request->offre);
      $nom    = $infos->nom.' '.$infos->prenom;
      $destin = ReadVille($infos->depart).' - '.ReadVille($infos->arrive);
      $places = $infos->placedispo;
      $prix   = $infos->montant;
      $telTrp = $infos->tel;
      $unite  = ReadUnites($infos->unite);
      $profile = $infos->profile;
      $idoff = $infos->Ofid;
      $idtransp = $infos->transporteur_id;
      $data   = response()->json(['transp'=>$nom,
                                  'price'=>$prix,
                                  'destin'=>$destin,
                                  'place'=>$places,
                                  'profile'=>$profile,
                                  'idoff'=>$idoff,
                                  'idtransp'=>$idtransp,
                                  'teltransp'=>$telTrp,
                                  'unite'=>$unite]);

      return $data;

   }

   //Validation de reservation
   public function cinetpay_notify_ouverture(Request $request)
   {
     // Réception des données
    	 $id_transaction = $request->get("cpm_trans_id");
       if ($id_transaction!=null) {
          //coordonnées de CINETPAY
          $apiKey  = config('cinetpay.compteApikey');
          $site_id = config('cinetpay.compteSiteid');
          $plateform = config('cinetpay.plateform');

           // Création de l'objet cinetpay
           $CinetPay = new CinetPay($site_id, $apiKey, $plateform);

            // Reprise exacte des bonnes données chez CinetPay
            $CinetPay->setTransId($id_transaction)->getPayStatus();
            $cpm_site_id = $CinetPay->_cpm_site_id;
            $signature = $CinetPay->_signature;
            $cpm_amount = $CinetPay->_cpm_amount;
            $cpm_trans_id = $CinetPay->_cpm_trans_id;
            $cpm_custom = $CinetPay->_cpm_custom;
            $cpm_currency = $CinetPay->_cpm_currency;
            $cpm_payid = $CinetPay->_cpm_payid;
            $cpm_payment_date = $CinetPay->_cpm_payment_date;
            $cpm_payment_time = $CinetPay->_cpm_payment_time;
            $cpm_error_message = $CinetPay->_cpm_error_message;
            $payment_method = $CinetPay->_payment_method;
            $cpm_phone_prefixe = $CinetPay->_cpm_phone_prefixe;
            $cel_phone_num = $CinetPay->_cel_phone_num;
            $cpm_ipn_ack = $CinetPay->_cpm_ipn_ack;
            $created_at = $CinetPay->_created_at;
            $updated_at = $CinetPay->_updated_at;
            $cpm_result = $CinetPay->_cpm_result;
            $cpm_trans_status = $CinetPay->_cpm_trans_status;
            $cpm_designation = $CinetPay->_cpm_designation;
            $buyer_name = $CinetPay->_buyer_name;

            // Vérification du paiement
             $paiement = DB::table('paiements')
                         ->where('numpaiement','=',$id_transaction)
                         ->first();
           //Traitment
           if ($paiement) {
             if ($_SESSION['amount']==$cpm_amount) {

               // paiement validé
               if ($cpm_result=='00') {
                 //Insertion de la reservation
                $res =  addreserv($_SESSION['idoff'],$_SESSION['idtransp'],$_SESSION['qte'],
                                   $_SESSION['arret'],$_SESSION['date'],$_SESSION['paiement'],
                                   $_SESSION['statut'],$_SESSION['livraison'],$_SESSION['code'],
                                   $_SESSION['id_user']);
                //Mise à jour des places disponible
                upPlace($_SESSION['placeDisp'],$_SESSION['idoff']);
                //Notification SMS ET EMAIL
                $msg = 'Reservation de '.$_SESSION['qte'].' places à'.' '.$_SESSION['arret'].',Contact:'.$_SESSION['tel'];
                $sender = 'GRENIER';
                try {
                  SMS($msg,$_SESSION['telT'] ,$sender);
                } catch (\Exception $e) {
                  echo "error";
                }



               } else {
                 echo "paiement echoué";
               }

             } else {
               echo "paiement echoué";
             }

           } else {
             echo "novalidate";
           }


       }
   }

   //Lancement de la reservation
   public function saveReserv(Request $request)
   {
     $idoff    = $request->idoff;
     $idtransp = $request->idtransp;
     $arret    = $request->arret;
     $qte      = $request->qte;
     $place    = $request->place;
     $telT     = $request->telT;
     $unite    = $request->unite;
     $date     = date('d/m/Y');
     $paiement = date("YmdHis");
     $statut   = 0;
     $livraison = 0;
     $code = date("YmdHis").'cmd';
     if (isset($_SESSION['tel']) AND !empty($_SESSION['tel'])) {
       //Vérification nombre de place
       if($qte>$place){
         $data = response()->json(['code' => '3'],200);
       }elseif ($qte==0) {
         $data = response()->json(['code' => '3'],200);
       }else{
         //Génération du paiement
         paiement($paiement,0);
         //Insertion de la reservation
         $montant = readMontantID($idoff)*$qte;
         $placeDisp = $place-$qte;
         $_SESSION['amount'] = $montant;
         $_SESSION['idoff'] = $idoff;
         $_SESSION['idtransp'] = $idtransp;
         $_SESSION['qte'] = $qte;
         $_SESSION['arret'] = $arret;
         $_SESSION['date'] = $date;
         $_SESSION['paiement'] = $paiement;
         $_SESSION['statut'] = $statut;
         $_SESSION['livraison'] = $livraison;
         $_SESSION['code'] = $code;
         $_SESSION['placeDisp'] = $placeDisp;
         $_SESSION['telT'] = $telT;
         try {
          //Notification au support technique
          $from = 'info@grenier.ci';
          $to = 'teknolojang@gmail.com';
          $titre = "GRENIER, Réservation";
          $msg = "Commande en cours:: client:".$_SESSION['tel']."/ Transporteur:".$_SESSION['telT']." /Code:".$code;
          //emailNotif($from,$to,$titre,$msg);

           //Retour du traitement
           $data = response()->json(
          	 	        ['code' => 1,
          	 		       'message' => 'success',
          	 			     'command' => [
                             'code' => $paiement,
                             'amount' => $montant,
                             'designation' =>'Réservation de place sur GRENIER'
                            ]
          				    ],200);
         } catch (\Exception $e) {
           //Retour du traitement
           $data = response()->json(['code' => '1'],200);
         }

       }

     }else{
       //Vérification nombre de place
       if($qte>$place){
         $data = response()->json(['code' => '3'],200);
       }elseif ($qte==0) {
         $data = response()->json(['code' => '3'],200);
       }else{
         //Demande de connection
         $data = response()->json(['code' => '2'],200);
       }

     }
     return $data;
   }

   //Filtre de Recherche
   public function grenier_check(Request $request)
   {
     $depart = $request->departSelect;
     $arrive = $request->arriveSelect;
     $unite = $request->uniteSelect;
     $data = ['depart'=>$depart,'arrive'=>$arrive,'unite'=>$unite];
     return view('grenier_check')->with('depart',$depart)
                                 ->with('arrive',$arrive)
                                 ->with('unite',$unite);
   }

}

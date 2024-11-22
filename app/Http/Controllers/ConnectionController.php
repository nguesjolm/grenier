<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
/*use Validator;
use DB;
use Mail;*/
/*use App\Model\setting;
use App\Cinetpay\Cinetpay;
use App\Model\abonnement;
use App\Model\offres;
use App\Model\clients;
use App\Mail\AbonnementMail;*/
session_start();

class ConnectionController extends Controller
{
	 /**
     * Create a new controller instance.
     *
     * @return void
     */

    public function logAd(Request $request)
    {
    	return response()->json(['code' => 0],200);
    }
}

?>
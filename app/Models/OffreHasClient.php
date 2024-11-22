<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OffreHasClient extends Model
{
    use HasFactory;
    protected $fillable = ['offre_id','offre_transporteur_id','qte','arret','date','numpaiement','statut','livraison','code','user_id','updated_at','created_at'];

}

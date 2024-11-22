<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Offres extends Model
{
    use HasFactory;
    protected $fillable = ['depart','arrive','montant','placedispo','transporteur_id','user_id','vehicule','unite','date','code','fin'];
}

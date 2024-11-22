<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transporteur extends Model
{
    use HasFactory;
    protected $fillable = ['matricule','photo','user_id','code','nomT','prenomT','telT','passT','statut'];

}

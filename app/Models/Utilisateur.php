<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class Utilisateur extends Authenticatable
{
    protected $table = 'utilisateur';
    
    
    protected $fillable = [
        'nom', 'prenom', 'email', 'branche','role'
    ];
}
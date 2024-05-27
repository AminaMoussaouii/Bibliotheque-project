<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RegleEmprunt extends Model
{
    use HasFactory;

    protected $fillable = 
    ['type_tier', 'nbr_emprunt'];
    protected $table = 'regle_emprunt';
}

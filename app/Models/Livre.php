<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Livre extends Model
{
    use HasFactory;
    protected $fillable = [
        'titre', 'auteur','isbn', 'editeur', 'langue', 'date_edition', 'exp_disp', 'etage', 'rayon', 'nombre_pages', 'discipline', 'statut', 'type_ouvrage', 'image'];
}

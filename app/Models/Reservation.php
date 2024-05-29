<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    use HasFactory;
    protected $fillable = [
        'nom', 'prenom','email', 'titre', 'auteur', 'rayon', 'etage', 'branche','isbn','type_ouvrage', 'livre_id'
    ];


    public function emprunt()
{
    return $this->hasOne(Emprunt::class);
}

public function livre()
    {
        return $this->belongsTo(Livre::class);
    }


}

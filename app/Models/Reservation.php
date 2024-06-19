<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    use HasFactory;
    protected $fillable = [
        'nom', 'prénom','email', 'titre', 'auteur', 'rayon', 'etage', 'Filière','isbn','type_ouvrage', 'livre_id','user_id','Role'

    ];


    public function emprunt()
{
    return $this->hasOne(Emprunt::class);
}

public function livre()
    {
        return $this->belongsTo(Livre::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Emprunt extends Model
{
    use HasFactory;
    protected $fillable = [
        'nom',
        'prenom',
        'email',
        'role',
        'titre',
        'type_ouvrage',
        'isbn',
        'date_limite',
        'date_retour',
        'nbr_jrs_retard',
        'statut',
    ];

    protected $dates = ['date_limite', 'date_retour'];


    public function reservation()
{
    return $this->belongsTo(Reservation::class);
}

public function livre()
{
    return $this->belongsTo(Livre::class, 'id');
}


public function user()
{
    return $this->belongsTo(User::class);
}

}

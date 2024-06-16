<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Emprunt extends Model
{
    use HasFactory;
    protected $fillable = [
        'nom',
        'prénom',
        'email',
        'Role',
        'titre',
        'type_ouvrage',
        'isbn',
        'date_limite',
        'date_retour',
        'nbr_jrs_retard',
        'statut',
        'livre_id',
        'user_id'
    ];

    protected $dates = ['date_limite', 'date_retour'];


    public function reservation()
{
    return $this->belongsTo(Reservation::class);
}

public function livre()
{
    return $this->belongsTo(Livre::class, 'livre_id');
}


public function user()
{
    return $this->belongsTo(User::class);
}

}

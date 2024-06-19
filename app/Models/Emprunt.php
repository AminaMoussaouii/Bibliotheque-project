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

    // protected $dates = ['date_limite', 'date_retour'];
    protected $dates = ['date_emprunt', 'date_limite', 'date_retour'];

    public function getJoursDeRetardAttribute()
    {
        if (is_null($this->date_retour) && now()->gt($this->date_limite)) {
            return now()->diffInDays($this->date_limite);
        }

        if (!is_null($this->date_retour) && $this->date_retour->gt($this->date_limite)) {
            return $this->date_retour->diffInDays($this->date_limite);
        }

        return 0;
    }


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

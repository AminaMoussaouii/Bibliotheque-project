<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Builder;

class Etudiant extends User
{
    use HasFactory;

    protected static function booted()
    {
        static::addGlobalScope('etudiant', function (Builder $builder) {
            $builder->where('Role', 'etudiant');
        });
    }

    protected $fillable = [
        'nom','prénom' ,'email', 'password', 'Role','Code_Apogée','CNE','Filière','Tél'
    ];
}

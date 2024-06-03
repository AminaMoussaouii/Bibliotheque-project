<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Builder;

class Bibliothecaire extends User
{
    use HasFactory;

    protected static function booted()
    {
        static::addGlobalScope('bibliothecaire', function (Builder $builder) {
            $builder->where('Role', 'bibliothècaire');
        });
    }

    protected $fillable = [
        'nom','prénom', 'email', 'password', 'PPR', 'Role','Tél'
    ];
}


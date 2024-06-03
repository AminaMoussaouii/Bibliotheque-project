<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Builder;

class Admin extends User
{
    use HasFactory;

    protected static function booted()
    {
        static::addGlobalScope('admin', function (Builder $builder) {
            $builder->where('Role', 'admin');
        });
    }

    protected $fillable = [
        'nom','prénom', 'email', 'password', 'PPR', 'Role','Tél'
    ];
}


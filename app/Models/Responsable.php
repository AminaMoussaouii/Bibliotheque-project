<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Builder;

class Responsable extends User
{
    use HasFactory;

    protected static function booted()
    {
        static::addGlobalScope('responsable', function (Builder $builder) {
            $builder->where('Role', 'responsable');
        });
    }

    protected $fillable = [
        'nom','prénom', 'email', 'password', 'PPR', 'Role','Tél'
    ];
}

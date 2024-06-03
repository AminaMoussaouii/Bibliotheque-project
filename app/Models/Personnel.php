<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Builder;

class Personnel extends User
{
    use HasFactory;

    protected static function booted()
    {
        static::addGlobalScope('personnel', function (Builder $builder) {
            $builder->where('Role', 'personnel');
        });
    }

    protected $fillable = [
        'nom', 'prénom','email','PPR', 'password', 'department', 'Role','Tél'
    ];
}
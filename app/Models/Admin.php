<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Admin extends Authenticatable
{
    use HasFactory, HasApiTokens;

    protected $guards = 'admin';

    protected $fillable = [
        'first_name','last_name','email', 'no_hp','username', 'password'
    ];
}

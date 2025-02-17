<?php

namespace App\Models;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;

class Admin extends Authenticatable  
{
    protected $fillable = [
        'name',
        'email',
        'mobile',
        'password',
        'socials',
        'youtube',
        'whatsapp',
        'facebook',
        'instagram',

    ];
}

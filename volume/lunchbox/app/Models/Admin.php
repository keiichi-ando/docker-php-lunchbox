<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Admin extends Authenticatable
{
    use HasFactory;
    use Notifiable;

    /**
     * The attributres that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
            'name',
            'email',
            'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     *
     */
    protected $hidden = [
            'password', 'remember_token'
    ];


    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $cats = [
        'email_veritied_at' => 'datetime'
    ];
}

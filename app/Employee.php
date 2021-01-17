<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Employee extends Authenticatable {

    use Notifiable;

    protected $guard = 'employee';
    protected $fillable = [
        'name', 'email', 'mobile', 'designation', 'salary', '', 'password',
    ];
    protected $hidden = [
        'password', 'remember_token',
    ];

}

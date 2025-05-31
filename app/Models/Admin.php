<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;
use Laravel\Sanctum\HasApiTokens;

class Admin extends Authenticatable
{
    use HasFactory, Notifiable,HasApiTokens ;

    protected $fillable = ['email','password','role'];

    protected $hidden = [
        'password',
        'remember_token',
    ];
    public function notes()
    {
        return $this->hasMany(Notes::class, 'admin_id');
    }
    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = Hash::make($value);
    }   
}

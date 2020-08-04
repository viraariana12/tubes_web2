<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'nama', 
        'email', 
        'password', 
        'tempat_lahir', 
        'tanggal_lahir', 
        'alamat', 
        'no_hp', 
        'foto',
        'super_user',
        'api_token'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token', 'api_token'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function postingan()  {
        return $this->hasMany('App\Postingan');
    }

    public function komentar() {
        return $this->hasMany('App\Komentar');
    }

    public function like() {
        return $this->hasMany('App\Like');
    }

    public function media() {
        return $this->hasManyThrough('App\Media','App\Postingan');
    }

    public function teman() {
        return $this->belongsToMany('App\User','pertemanan','user_id','teman_user_id');
    }

    public function permintaanTeman() {

    }

}

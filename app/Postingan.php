<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Postingan extends Model
{
    protected $fillable = ['isi'];

    public function user() {
        return $this->belongsTo('App\User');
    }
    
    public function media() {
        return $this->hasMany('App\Media');
    }

    public function komentar() {
        return $this->hasMany('App\Komentar');
    }

    public function like() {
        return $this->hasMany('App\Like');
    }
}

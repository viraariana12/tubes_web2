<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Komentar extends Model
{
    protected $fillable = ['isi'];

    public function user() {
        return $this->belongsTo('App\User');
    }

    public function postingan() {
        return $this->belongsTo('App\Postingan');
    }
}

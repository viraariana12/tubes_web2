<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Media extends Model
{
    protected $fillable = ['nama','jenis','url'];

    public function postingan() {
        return $this->belongsTo('App\Postingan');
    }
}

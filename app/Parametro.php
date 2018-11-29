<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Parametro extends Model
{
    protected $table = 'parametros';

    protected $fillable = [
    	'grupo',
        'codigo',
        'valor'
    ];
}

<?php

use \Illuminate\Database\Eloquent\Model as Eloquent;

class Cliente_model extends Eloquent {

    protected $table = 'cliente';
    protected $primaryKey = 'idcliente';
    public $timestamps = false;

    public function persona() {
        return $this->belongsTo('Persona_model', 'idpersona');
    }

}

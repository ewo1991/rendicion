<?php

use \Illuminate\Database\Eloquent\Model as Eloquent;

class Persona_model extends Eloquent {

    protected $table = 'persona';
    protected $primaryKey = 'idpersona';
    public $timestamps = false;

    public function empleado() {
        return $this->hasOne('Empleado_model', 'idpersona');
    }

}

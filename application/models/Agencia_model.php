<?php

	use \Illuminate\Database\Eloquent\Model as Eloquent;

	class Agencia_model extends Eloquent { 
		protected $table = 'agencia';
		protected $primaryKey = 'idagencia';

		public function empleados(){
			return $this->hasMany('Empleado_model', 'idagencia');
		}

		public function empresa(){
			return $this->belongsTo('Empresa_model', 'idempresa');
		}
	}
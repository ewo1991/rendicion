<?php

	use \Illuminate\Database\Eloquent\Model as Eloquent;

	class Empleado_model extends Eloquent { 
		protected $table = 'empleado';
		protected $primaryKey = 'idempleado';
		public $timestamps = false;

		public function empresa(){
			return $this->belongsTo('Empresa_model', 'idempresa');
		}

		public function persona(){
			return $this->belongsTo('Persona_model', 'idpersona');
		}

		public function agencia(){
			return $this->belongsTo('Agencia_model', 'idagencia');
		}

		public function perfil(){
			return $this->belongsTo('Perfil_model', 'idperfil');
		}
	}
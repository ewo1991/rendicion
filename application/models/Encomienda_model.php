<?php

	use \Illuminate\Database\Eloquent\Model as Eloquent;

	class Encomienda_model extends Eloquent { 
		protected $table = 'encomienda';
		protected $primaryKey = 'idencomiendas';
		public $timestamps = false;
		
		public function detalles(){
			return $this->hasMany('Detalle_model', 'idencomiendas');
		}	
	}
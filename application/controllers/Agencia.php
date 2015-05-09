<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Agencia extends CI_Controller {
	public function __construct(){
		parent::__construct();
		$this->load->model(array('Agencia_model'));
	}

	public function returnAgencias(){
		$agencias = Agencia_model::all();

		echo json_encode($agencias);
	}
}
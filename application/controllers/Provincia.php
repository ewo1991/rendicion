<?php

defined('BASEPATH') OR exit('No direct script access allowed');

use \Illuminate\Database\Capsule\Manager as DB;

class Provincia extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model(array('Provincia_model'));
    }

    public function returnProvincias() {
        $data = DB::table('provincia')
                ->where('provincia.iddepartamento', '=', $this->input->get('iddepartamento'))
                ->get();
        echo json_encode(array("provincias" => $data));
    }

}

<?php

defined('BASEPATH') OR exit('No direct script access allowed');

use \Illuminate\Database\Capsule\Manager as DB;

class Departamento extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model(array('Departamento_model'));
    }

    public function returnDepartamentos() {
        $data = DB::table('departamento')
                ->get();
        echo json_encode(array("departamentos"=>$data));
    }


}

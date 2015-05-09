<?php

defined('BASEPATH') OR exit('No direct script access allowed');

use \Illuminate\Database\Capsule\Manager as DB;

class Tipopago extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model(array('Tipo_pago_model'));
    }

    public function returnTipoDePagos() {
        $data = DB::table('tipopago')
                ->get();
        echo json_encode(array("tipopagos"=>$data));
    }


}

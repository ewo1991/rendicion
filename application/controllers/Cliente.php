<?php

defined('BASEPATH') OR exit('No direct script access allowed');

use \Illuminate\Database\Capsule\Manager as DB;

class Cliente extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model(array('Cliente_model', 'Persona_model'));
    }

    public function returnCliente() {
        $data = DB::table('cliente')
                ->join('persona', 'persona.idpersona', '=', 'cliente.idpersona')
                ->where('persona.dni', '=', $this->input->get('dni'))
                ->get();

        $cliente = array();

        foreach ($data as $value) {
            array_push($cliente, array('idcliente' => $value['idcliente'], 'cliente' => $value['nombre'] . ' ' . $value['ap_paterno'] . ' ' . $value['ap_materno']));
        }

        echo json_encode($cliente);
    }

    public function returnCliente_all_data() {
        $data = DB::table('cliente')
                ->join('persona', 'persona.idpersona', '=', 'cliente.idpersona')
                ->where('persona.dni', '=', $this->input->get('dni'))
                ->get();

        $direcciones = DB::select("SELECT
direccion.iddireccion,
direccion.direccion,
distrito.distrito,
provincia.provincia,
departamento.departamento,
direccion.distrito_iddistrito,
direccion.distrito_provincia_idprovincia,
direccion.distrito_provincia_departamento_iddepartamento
FROM
direccion
INNER JOIN distrito ON direccion.distrito_iddistrito = distrito.iddistrito AND direccion.distrito_provincia_idprovincia = distrito.idprovincia AND direccion.distrito_provincia_departamento_iddepartamento = distrito.iddepartamento
INNER JOIN provincia ON direccion.distrito_provincia_idprovincia = provincia.idprovincia AND direccion.distrito_provincia_departamento_iddepartamento = provincia.iddepartamento
INNER JOIN departamento ON direccion.distrito_provincia_departamento_iddepartamento = departamento.iddepartamento
WHERE direccion.idcliente=".$data[0]['idcliente']);


        echo json_encode(array("cliente"=>$data,"direccion"=>$direcciones));
    }

    public function saveClienteExtend() {

        $request_body = file_get_contents('php://input');
        $data = json_decode($request_body);
        $max_idpersona = (int) Persona_model::max('idpersona') + 1;
        $persona = new Persona_model;
        $persona->idpersona = $max_idpersona;
        $persona->tipodocumento_idtipodocumento = 1;
        $persona->tipopersona = 1;
        $persona->clase_persona = 1;
        $persona->dni = $data->dni;
        $persona->nombre = $data->nombre;
        $persona->ap_paterno = $data->ap_paterno;
        $persona->ap_materno = $data->ap_materno;
        $persona->alias1 = $data->alias1;
        $persona->alias2 = $data->alias2;
        $persona->telefono = $data->telefono;
        $persona->celular = $data->celular;
        $persona->rpm = $data->rpm;
        $persona->pagina_web = $data->pagina_web;
        $persona->correo_electronico = $data->correo_electronico;

        if ($persona->save()) {
//            insertar cliente
            $max_idcliente = (int) Cliente_model::max('idcliente') + 1;
            $persona = new Cliente_model;
            $persona->idcliente = $max_idcliente;
            $persona->idpersona = $max_idpersona;
            $persona->limite_credito = $data->limite_credito;
            if ($persona->save()) {
                echo json_encode(array("code" => 1, "msg" => "Se inserto correctamente el cliente", "idcliente" => $max_idcliente));
            }
        }
    }

}

<?php

defined('BASEPATH') OR exit('No direct script access allowed');

use \Illuminate\Database\Capsule\Manager as DB;

class Encomienda extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model(array('Encomienda_model', 'Detalle_model'));
    }

    public function saveEncomienda() {
        $request_body = file_get_contents('php://input');
        $data = json_decode($request_body);

        $max = Encomienda_model::max('nro_encomienda');
        $resp = array();

        $encomienda = new Encomienda_model;
        $encomienda->nro_encomienda = str_pad(((int) $max + 1), 7, "0", STR_PAD_LEFT);
        $encomienda->fechaemision = date('Y-m-d', strtotime($data->fecha));
        $encomienda->fechareg = date('y-m-d H:i:s');
        $encomienda->idruta = $data->ruta->idruta;
        $encomienda->iditinerario = $data->itinerario->iditinerario;
        $encomienda->remitente = $data->remitente[0]->idcliente;
        $encomienda->destinatario = $data->consignatario[0]->idcliente;
        $encomienda->cantidadtotal = count($data->detalle);
        $encomienda->idempleado = $this->session->userdata['user_id'];
        $encomienda->idagencia = $data->agencia->idagencia;

        if ($encomienda->save()) {
            foreach ($data->detalle as $value) {
                $detalle = new Detalle_model;
                $detalle->idencomiendas = $encomienda->idencomiendas;
                $detalle->glosa = $value->descripcion;
                $detalle->cantidad = $value->cantidad;
                $detalle->preciopaquete = $value->flete;
                $detalle->subtotal = $value->total;
                $detalle->save();
            }

            if ($detalle->ID) {
                $resp = array('code' => 1, 'msg' => str_pad($encomienda->idencomiendas, 7, "0", STR_PAD_LEFT));
            } else {
                $resp = array('code' => 0, 'msg' => 'No se pudo generar la encomienda');
            }
        } else {
            $resp = array('code' => 0, 'msg' => 'Ocurrió un error al momento de registrar la encomienda');
        }

        echo json_encode($resp);
    }

   

    public function gridDetalleEncomienda() {
        $text = $this->input->get('text');
        $limit = $this->input->get('limit');
        $page = $this->input->get('page');

        $total = DB::select("select count(*) as total from encomienda where encomienda.nro_encomienda like '%" . $text . "%' and encomienda.estado = 0");

        $query = DB::select("SELECT
        encomienda.idencomiendas,
        encomienda.nro_encomienda,
        encomienda_detalle.glosa,
        encomienda_detalle.preciopaquete,
        encomienda_detalle.cantidad,
        encomienda_detalle.subtotal
        FROM
        encomienda
        INNER JOIN encomienda_detalle ON encomienda.idencomiendas = encomienda_detalle.idencomiendas 
        where  encomienda.nro_encomienda = '" . $text . "' and encomienda.estado = 0  and encomienda.estado_facturacion=0 limit " . $limit . " offset " . ($page == 1 ? 0 : (($page - 1) * $limit)) . ";");

        $resp = array('total' => $total[0]['total'] / $limit, 'data' => $query);


        echo json_encode($resp);
    }

    public function deleteEncomienda() {
        $request_body = file_get_contents('php://input');
        $data = json_decode($request_body);

        $resp = array();

        $encomienda = DB::table('encomienda')
                ->where('nro_encomienda', $data->id)
                ->update(['estado' => 4]);

        if ($encomienda) {
            $resp = array('cod' => 1, "msg" => "Se anuló correctamente la encomienda");
        } else {
            $resp = array('cod' => 0, "msg" => "No se anuló correctamente la encomienda");
        }

        echo json_encode($resp);
    }

}

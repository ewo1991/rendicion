<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class User extends CI_Controller {
	public function __construct() {
        parent::__construct();
        $this->load->model(array('Empleado_model', 'Empresa_model', 'Persona_model', 'Agencia_model'));
    }

	public function index(){
		$this->load->view('login');
	}

	public function login() {
        $empleado = Empleado_model::with('persona')
                                    ->where('usuario', '=', $this->input->post('username'))->get();
        $resp = array();
        if (count($empleado) > 0) {
            if($this->compare_crypt($this->input->post('password'), $empleado[0]->clave)){
            	$this->session->set_userdata(array(
                    'user_id'       =>  $empleado[0]->idempleado,
                    'user_agencia'  =>  $empleado[0]->idagencia,
                    'user_perfil'   =>  $empleado[0]->idperfil,
                    'user_name'     =>  $empleado[0]->persona->nombre,
                    'user_ape_pat'  =>  $empleado[0]->persona->ap_paterno,
                    'user_ape_mat'  =>  $empleado[0]->persona->ap_materno
                ));
	            $resp = array("rep" => 1, "msg" => "Datos correctos, redireccionando...");
            }else{
            	$resp = array("rep" => 0, "msg" => "Usuario o Contraseña incorrectos...");
            }
        } else {
            $resp = array("rep" => 2, "msg" => "Usuario o Contraseña incorrectos...");
        }
        
        echo json_encode($resp);
    }

    public function logout() {
        $this->session->unset_userdata('user_name');
        $this->session->sess_destroy();
        redirect('usuario');
    }

    public function compare_crypt($pwd, $salt){
    	if(crypt($pwd, $salt) == $salt) {  
			return true; 
		}else{
			return false;
		}
    }
}
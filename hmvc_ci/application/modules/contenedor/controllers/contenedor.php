<?php if (! defined('BASEPATH')) exit('No direct script access allowed');

class Contenedor extends MX_Controller {
    
    public function __construct() {
        parent::__construct();
        //$this->caducidadSesion(); 
        $this->urlBase = base_url();
        //$this->load->model('contenedor_model'); // incluyendo modelo de este modulo
        //Modules::run("app/metodosComunes/__autoload", "inicio", "modules/contenedor/views");
        /* $this->carabiner->empty_cache('js');
        $this->carabiner->js('application/modules/login/libraries/js/login.js');        
	$this->carabiner->css('application/modules/login/libraries/css/login.css');*/
    }
    
    function index($flagalert = null) {	
        /* $this->carabiner->display('css');
        $this->carabiner->display('js'); */
        $body['body'] = modules::run('login/controller/contenido');
	$this->load->view('header',$body);
        $this->load->view('footer');
    }
}
<?php if (! defined('BASEPATH')) exit('No direct script access allowed');
 
class Login extends MX_Controller {
    
    function __construct(){
        parent::__construct();
        $this->urlBase = base_url();
    }
 
    function index(){
        $login = $_POST['username'];
        $pass =$_POST['password'];
        if(isset($login) || isset($pass)){
            if(trim($login) == "" || trim($pass) == ""){
                echo("false");

            }
            else{
                $this->load->model('user');
                $user = $this->user->login($login,$pass);
                if($user){
                    echo("true");
                }
                else{
                    echo("false");
                }
            }
        }
        else{
            echo("false");
        }
    }
	
    function contenido(){
        $html="<div class='container'>
       
        <div class='row'>
            <div class='col-md-4 col-md-offset-4 text-center logo-margin '>
              <img src='$this->urlBase"."assets/img/logo.png'\" alt=''/>
                </div>
            <div class='col-md-4 col-md-offset-4'>
                <div class='login-panel panel panel-default'>
                    <div class='panel-heading'>
                        <h3 class='panel-title'>Inicio de sesión</h3>
                    </div>
                    <div class='panel-body'>
                        <form role='form'>
                            <fieldset>
                                <div class='form-group'>
                                    <input id='login-username' type='text' class='form-control' name='username' value='' placeholder='Usuario' required='required' aria-required='true'>
                                </div>
                                <div class='form-group'>
                                    <input id='login-password' type='password' value='' class='form-control' name='password' placeholder='Contraseña'>
                                </div>
                                <a id='btn-login' href='#' onclick=\"validaUsuario('$this->urlBase')\" class='btn btn-lg btn-primary btn-block'>Login</a>
                            </fieldset>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>";
		return $html;
	}
}
?>
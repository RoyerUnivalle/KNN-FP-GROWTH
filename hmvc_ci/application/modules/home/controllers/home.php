<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Home extends MX_Controller{
    public function __construct(){
        parent::__construct();
        $this->carabiner->js('application/modules/home/js/home.js');
        $this->urlBase = base_url();
    }
	
    public function index(){
        $this->carabiner->display('js');
        if($this->session->userdata('logged_in')){
            $body['body'] = modules::run('home/controller/contenido');
            $this->load->view('header',($body));
            $this->load->view('footer');
        }
        else{
            echo('No se ha logueado');
            redirect('contenedor');
        }
    }
	
    public function logOut(){
        if($this->session->userdata('logged_in')){
            //$this->session->unset_userdata('logged_in');
            //session_destroy();
            //redirect('login', 'refresh');
            $this->session->sess_destroy();
            echo("true");
        }
        else{
            echo("false");
        }
    }
    
    public function contenido(){
        $perfil = $this->session->userdata('perfil');
        $this->load->model('menu');
        $opciones = $this->menu->contenidoMenu($perfil);
        $datosCompra = $this->menu->datosCompra();
        $costoCompras = $datosCompra[0]['costo_compras'];
        $costoCompras = number_format($costoCompras,0,'.',',');
        $datosVenta = $this->menu->datosVenta();
        $costoVentas = $datosVenta[0]['costo_ventas'];
        $costoVentas = number_format($costoVentas,0,'.',',');
        $cantidadProveedores = $this->menu->cantidadProveedoresMes();
        $cantidadClientes = $this->menu->cantidadClientesMes();
        $maxProductoMes = $this->menu->maxProductoMes();
        $productoDesc = $this->menu->selProducto($maxProductoMes[0]['movivent_producto_id']);
        $html ="<!--  wrapper -->
    <div id='wrapper'>
        <!-- navbar top -->
        <nav class='navbar navbar-default navbar-fixed-top' role='navigation' id='navbar'>
            <!-- navbar-header -->
            <div class='navbar-header'>
                <button type='button' class='navbar-toggle' data-toggle='collapse' data-target='.sidebar-collapse'>
                    <span class='sr-only'>Toggle navigation</span>
                    <span class='icon-bar'></span>
                    <span class='icon-bar'></span>
                    <span class='icon-bar'></span>
                </button>
                <a class='navbar-brand' href='index.html'>
                    <img src='$this->urlBase"."assets/img/logo.png' alt='' />
                </a>
            </div>
            <!-- end navbar-header -->
            <!-- navbar-top-links -->
            <ul class='nav navbar-top-links navbar-right'>
                <!-- main dropdown -->

                <li class='dropdown'>
                    <a class='dropdown-toggle' data-toggle='dropdown' href='#'>
                        <i class='fa fa-user fa-3x'></i>
                    </a>
                    <!-- dropdown user-->
                    <ul class='dropdown-menu dropdown-user'>
                        <li><a id='btn-logout' href='#' onclick=\"logOut('$this->urlBase','home/logOut')\"><i class='fa fa-sign-out fa-fw'></i>Salir</a>
                        </li>
                    </ul>
                    <!-- end dropdown-user -->
                </li>
                <!-- end main dropdown -->
            </ul>
            <!-- end navbar-top-links -->

        </nav>
        <!-- end navbar top -->

        <!-- navbar side -->
        <nav class='navbar-default navbar-static-side' role='navigation'>
            <!-- sidebar-collapse -->
            <div class='sidebar-collapse'>
                <!-- side-menu -->
                <ul class='nav' id='side-menu'>
                    <li>
                        <!-- user image section-->
                        <div class='user-section'>
                            <div class='user-section-inner'>
                                <img src='$this->urlBase"."assets/img/user.jpg' alt=''>
                            </div>
                            <div class='user-info'>
                                <div><strong>".$this->session->userdata('nombPers')." ".$this->session->userdata('apelPers')."</strong></div>
                                <div class='user-text-online'>
                                    <span class='user-circle-online btn btn-success btn-circle '></span>&nbsp;Online
                                </div>
                            </div>
                        </div>
                        <!--end user image section-->
                    </li>
                    <li class='selected'>
                        <a href='home'><i class='fa fa-dashboard fa-fw'></i>Inicio</a>
                    </li>
";
        
        
        $posiinic = 0;
        //Se recorren los módulos a mostrar en el menú
        foreach ($opciones as $keyM=>$modulo){
            //Se recorren los submódulos a mostrar en el menú
            foreach ($modulo as $keySm=>$submodulo){
                //Se recorren las opciones a mostrar en el menú
                foreach ($submodulo as $keyOp=>$opcion){
                    
                    //Se almacena el identificador y nombre del módulo
                    $idModulo = substr($opciones[$keyM][$keySm][$keyOp],$posiinic,strpos($opciones[$keyM][$keySm][$keyOp],'|',$posiinic) - $posiinic);
                    $posiinic = strpos($opciones[$keyM][$keySm][$keyOp],'|',$posiinic) + 1;
                    $nombreModu = substr($opciones[$keyM][$keySm][$keyOp],$posiinic,strpos($opciones[$keyM][$keySm][$keyOp],'|',$posiinic)-$posiinic);
                    $posiinic = strpos($opciones[$keyM][$keySm][$keyOp],'|',$posiinic) + 1;
                    
                    //Se almacena el identificador y nombre del submódulo
                    $idSubmo = substr($opciones[$keyM][$keySm][$keyOp],$posiinic,strpos($opciones[$keyM][$keySm][$keyOp],'|',$posiinic) - $posiinic);
                    $posiinic = strpos($opciones[$keyM][$keySm][$keyOp],'|',$posiinic) + 1;
                    $nombreSubmo = substr($opciones[$keyM][$keySm][$keyOp],$posiinic,strpos($opciones[$keyM][$keySm][$keyOp],'|',$posiinic)-$posiinic);
                    $posiinic = strpos($opciones[$keyM][$keySm][$keyOp],'|',$posiinic) + 1;
                    
                    //Se almacena el identificador y nombre de la opción
                    $idOpcion   = substr($opciones[$keyM][$keySm][$keyOp],$posiinic,strpos($opciones[$keyM][$keySm][$keyOp],'|',$posiinic) - $posiinic);
                    $posiinic   = strpos($opciones[$keyM][$keySm][$keyOp],'|',$posiinic) + 1;
                    $nombreOpci = substr($opciones[$keyM][$keySm][$keyOp],$posiinic,strpos($opciones[$keyM][$keySm][$keyOp],'|',$posiinic) - $posiinic);
                    $posiinic   = strpos($opciones[$keyM][$keySm][$keyOp],'|',$posiinic) + 1;
                    $metodoOpci = substr($opciones[$keyM][$keySm][$keyOp],$posiinic,strpos($opciones[$keyM][$keySm][$keyOp],'|',$posiinic) - $posiinic);
                    $posiinic   = strpos($opciones[$keyM][$keySm][$keyOp],'|',$posiinic) + 1;
                    //Se acumula el html para las opciones
                    $imprOpci.="<li><a id='btn-opcion-".$idOpcion."' href='#' onclick=\"llamarMetodo('$this->urlBase','$metodoOpci')\">$nombreOpci</a></li>";
                    $posiinic = 0;
                }
                //Se acumula el html para los submódulos
                $imprSubmo.= "<li><a href='#'>$nombreSubmo<span class='fa arrow'></span></a><ul class='nav nav-third-level'>";
                //Se concatena el html de las opciones al de los submódulos
                $imprSubmo.=$imprOpci."</ul>";
                //Se vacía el html de las opciones para cuando se iteren las opciones del siguiente submódulo
                $imprOpci = '';
            }
            //Se acumula el html para los módulos
            $imprModu.= "<li><a href='#'><i class='fa fa-sitemap fa-fw'></i>$nombreModu<span class='fa arrow'></span></a>";
            //Se concatena el html de los submódulos al de los módulos
            $imprModu.="<ul class='nav nav-second-level'>".$imprSubmo."</li></ul></li>";
            //Se vacía el html de los submódulos para cuando se iteren los submódulos del siguiente módulo
            $imprSubmo = '';

        }
        $html.= $imprModu;
        
        $html.= "</ul>
                <!-- end side-menu -->
            </div>
            <!-- end sidebar-collapse -->
        </nav>
        <!-- end navbar side -->
        <!--  page-wrapper -->
        <div id='page-wrapper'>

            <div class='row'>
                <!-- Page Header -->
                <div class='col-lg-12'>
                    <h1 class='page-header'>Inicio</h1>
                </div>
                <!--End Page Header -->
            </div>

            <div class='row'>
                <!-- Welcome -->
                <div class='col-lg-12'>
                    <div class='alert alert-info'>
                        <i class='fa fa-folder-open'></i><b>&nbsp;Hola! </b>Bienvenido <b>".$this->session->userdata('nombPers')."</b>
                    </div>
                </div>
                <!--end  Welcome -->
            </div>


            <div class='row'>
                <!--quick info section -->
                <div class='col-lg-3'>
                    <div class='alert alert-danger text-center'>
                        <i class='fa fa-calendar fa-3x'></i>&nbsp;Compras del mes: <b>".$datosCompra[0]['cantidad_compras']." </b>

                    </div>
                </div>
                <div class='col-lg-5'>
                    <div class='alert alert-success text-center'>
                        <i class='fa  fa-beer fa-3x'></i>&nbsp;Lo más comprado del mes: <b>27 % </b>
                    </div>
                </div>
                <div class='col-lg-3'>
                    <div class='alert alert-info text-center'>
                        <i class='fa fa-rss fa-3x'></i>&nbsp;Proveedores registrados este mes: <b>".$cantidadProveedores[0]['cantidad_proveedores']."</b>

                    </div>
                </div>
                <div class='col-lg-4'>
                    <div class='alert alert-warning text-center'>
                        <i class='fa  fa-pencil fa-3x'></i>&nbsp;Inversión Total Compras del mes: <b>$ ".$costoCompras."</b>
                    </div>
                </div>
                <div class='col-lg-3'>
                    <div class='alert alert-danger text-center'>
                        <i class='fa fa-calendar fa-3x'></i>&nbsp;Ventas del mes: <b>".$datosVenta[0]['cantidad_ventas']." </b>

                    </div>
                </div>
                <div class='col-lg-5'>
                    <div class='alert alert-success text-center'>
                        <i class='fa  fa-beer fa-3x'></i>&nbsp;Lo más vendido del mes: <b>".$productoDesc[0]['producto_nombre']."</b>
                    </div>
                </div>
                <div class='col-lg-3'>
                    <div class='alert alert-info text-center'>
                        <i class='fa fa-rss fa-3x'></i>&nbsp;Clientes registrados este mes: <b>".$cantidadClientes[0]['cantidad_clientes']."</b>

                    </div>
                </div>
                <div class='col-lg-4'>
                    <div class='alert alert-warning text-center'>
                        <i class='fa  fa-pencil fa-3x'></i>&nbsp;Recaudo Total Ventas del mes: <b>$ ".$costoVentas."</b>
                    </div>
                </div>
                <!--end quick info section -->
            </div>
            
        </div>
        <!-- end page-wrapper -->

    </div>
    <!-- end wrapper -->";
        
        return $html;
    }
}
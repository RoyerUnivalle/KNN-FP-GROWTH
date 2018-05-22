<?php if (! defined('BASEPATH')) exit('No direct script access allowed');
 
class Usuarios extends MX_Controller {
    
    function __construct(){
        parent::__construct();
        $this->urlBase = base_url();
    }
 
    function index(){
        echo("usuarios.index");
    }
	
    function crearUsuario(){
        $this->load->model('usuario');
        $estados = $this->usuario->listaEstados();
        $perfiles = $this->usuario->listaPerfiles();
        $imprOpci ="";
        $cargaForma = "<div class='row'>
                 <!-- page header -->
                <div class='col-lg-12'>
                    <h1 class='page-header'>Crear Usuario</h1>
                </div>
                <!--end page header -->
            </div>
            <div class='row'>
                <div class='col-lg-12'>
                    <!-- Form Elements -->
                    <div class='panel panel-default'>
                        <div class='panel-heading'>
                            Registro de Usuarios
                        </div>
                        <div class='panel-body'>
                            <div class='row'>
                                <div class='col-lg-6'>
                                    <form role='form'>
                                        <div class='form-group'>
                                            <label>Usuario</label>
                                            <input id='usuario-nombre' class='form-control' placeholder='Usuario de Logueo.'>
                                        </div>
                                        
                                        <div class='form-group'>
                                            <label>Estado</label>
                                            <select id='usuario-estado-id' class='form-control'>";
        
        foreach ($estados as $keyEstado=>$estado){
            //Se acumula el html para las opciones
            $imprOpci.="<option>".$estados[$keyEstado]."</option>"
                       . "";
        }
        $cargaForma.=$imprOpci;
        $cargaForma.="</select>
                                        </div>
                                        <button id='btn-guardar' href='#' onclick=\"insertaUsuario('$this->urlBase')\" type='submit' class='btn btn-primary'>Guardar</button>
                                        <button id='btn-cancelar' type='reset' class='btn btn-success'>Cancelar</button>
                                    </form>
                                </div>
                                <div class='col-lg-6'>
                                    <form role='form'>
                                        <div class='form-group'>
                                            <label>Clave</label>
                                            <input id='usuario-clave' type='password' class='form-control' placeholder='Clave del Usuario'>
                                        </div>
                                        
                                        
                                         <div class='form-group'>
                                            <label>Perfil</label>
                                            <select id='usuario-perfil-id' class='form-control'>";
        $imprOpci="";
        foreach ($perfiles as $keyPerfil=>$perfil){
            //Se acumula el html para las opciones
            $imprOpci.="<option>".$perfiles[$keyPerfil]."</option>"
                       . "";
        }
        $cargaForma.=$imprOpci;
        $cargaForma.="</select>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                     <!-- End Form Elements -->
                </div>
            </div>
";
        echo $cargaForma;
    }
    
    function modificarUsuario(){
        if($this->session->userdata('logged_in')){
            $this->load->model('usuario');
            $codigoUsua               = $_POST['idUsuario'];
            
            $estados                  = $this->usuario->listaEstados();
            $perfiles                 = $this->usuario->listaPerfiles();
            $usuario                  = $this->usuario->selModiUsuario($codigoUsua);
            
            $id_usuario               = $usuario[0]['id_usuario'];
            $usuario_nombre           = $usuario[0]['usuario_nombre'];
            $usuario_clave            = $usuario[0]['usuario_clave'];
            $usuario_perfil_id        = $usuario[0]['usuario_perfil_id'];
            $perfil                   = $this->usuario->selPerfil($usuario_perfil_id);
            $usuario_perfil           = $perfil[0]['perfil'];
            $usuario_estado_id        = $usuario[0]['usuario_estado_id'];
            $estado                   = $this->usuario->selEstado($usuario_estado_id);
            $usuario_estado           = $estado[0]['estado'];
            $imprOpci                 = "";
            $imprCiudad               = "";
            $cargaForma = "<div class='row'>
                    <!-- page header -->
                   <div class='col-lg-12'>
                       <h1 class='page-header'>Modificar Usuario</h1>
                   </div>
                   <!--end page header -->
               </div>
               <div class='row'>
                   <div class='col-lg-12'>
                       <!-- Form Elements -->
                       <div class='panel panel-default'>
                           <div class='panel-heading'>
                               Modificación de Usuarios
                           </div>
                           <div class='panel-body'>
                               <div class='row'>
                                   <div class='col-lg-6'>
                                       <form role='form'>
                                            <div class='form-group'>
                                               <label>Código</label>
                                               <input id='id-usuario' class='form-control' placeholder='Código del Usuario.' value='$id_usuario' disabled>
                                            </div>
                                            <div class='form-group'>
                                               <label>Clave</label>
                                               <input id='usuario-clave' type='password' class='form-control' placeholder='Clave del Usuario' value='$usuario_clave'>
                                            </div>
                                            <div class='form-group'>
                                               <label>Estado</label>
                                               <select id='usuario-estado' class='form-control'>";

            foreach ($estados as $keyEstado=>$estado){
                //Se acumula el html para las opciones
                if($usuario_estado == $estados[$keyEstado]){
                    $imprOpci.="<option selected>".$estados[$keyEstado]."</option>";
                }
                else{
                    $imprOpci.="<option>".$estados[$keyEstado]."</option>";
                }
            }
            $cargaForma.=$imprOpci;
            $cargaForma.="</select>
                                           </div>
                                           <button id='btn-guardar' href='#' onclick=\"actualizaUsuario('$this->urlBase')\" type='submit' class='btn btn-primary'>Guardar</button>
                                           <button id='btn-cancelar' type='reset' class='btn btn-success'>Cancelar</button>
                                       </form>
                                   </div>
                                   <div class='col-lg-6'>
                                       <form role='form'>
                                            <div class='form-group'>
                                               <label>Usuario</label>
                                               <input id='usuario-nombre' class='form-control' placeholder='Usuario de Logueo.' value='$usuario_nombre'>
                                           </div>

                                            <div class='form-group'>
                                               <label>Perfil</label>
                                               <select id='usuario-perfil' class='form-control'>";
            $imprOpci="";
            foreach ($perfiles as $keyPerfil=>$perfil){
                //Se acumula el html para las opciones
                if($usuario_perfil == $perfiles[$keyPerfil]){
                    $imprOpci.="<option selected>".$perfiles[$keyPerfil]."</option>";
                }
                else{
                    $imprOpci.="<option>".$perfiles[$keyPerfil]."</option>";
                }
            }
            $cargaForma.=$imprOpci;
            $cargaForma.="</select>
                                           </div>
                                       </form>
                                   </div>
                               </div>
                           </div>
                       </div>
                        <!-- End Form Elements -->
                   </div>
               </div>
   ";
            echo $cargaForma;
        }
        else{
            echo('No se ha logueado');
            redirect('contenedor');
        }
    }
    
    function consultarUsuario(){
        if($this->session->userdata('logged_in')){
            $valorUsua = "";
            $this->load->model('usuario');
            $usuarios    = $this->usuario->consUsuario($valorUsua);
            $imprUsuario = "";
                $cargaForma  = "<div class='row' onload='consultaUsuario('$this->urlBase')'>
                        <!-- Page Header -->
                        <div class='col-lg-12'>
                            <h1 class='page-header'>Consultar Usuario</h1>
                        </div>
                        <!--End Page Header -->
                    </div>
                    <div class='row'>
                        <div class='col-lg-12'>
                            <!-- Advanced Tables -->
                            <div class='panel panel-default'>
                                <div class='panel-heading'>
                                     Consulta de Usuario
                                </div>
                                <div class='panel-body'>
                                    <div class='table-responsive'>
                                        <div id='dataTables-example_wrapper' class='dataTables_wrapper form-inline' role='grid'>
                                            <div class='row'>
                                                <div class='col-sm-6'>
                                                    <!-- search section-->
                                                    <div id='dataTables-example_filter' class='dataTables_filter'>
                                                        <span class='input-group-btn'>
                                                            <input type='search' id='usuario-valor' class='form-control input-sm' aria-controls='dataTables-example' placeholder='Buscar'>
                                                            <button id='busca-usuario' class='btn btn-default' onclick=\"consultaUsuario('$this->urlBase')\" type='submit'><i class='fa fa-search'></i></button>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div id='usuarios' class='row'>
                                                <div class='form-group'>
                                                    <div id='lista'>
                                                        <table class='table table-bordered'width='100%'  border='0' cellspacing='0' cellpadding='0' style='font-size:10px'>
                                                            <thead>
                                                                <tr>
                                                                    <th>Código</th>
                                                                    <th>Nombre de Usuario</th>
                                                                    <th>Perfil</th>
                                                                    <th>Estado</th>
                                                                </tr>
                                                            </thead>";
            if($usuarios != false){
                $imprUsuario = "";
                $cargaForma.= "<tbody>";
                $posiinic = 0;                                                
                foreach ($usuarios as $keyUsuario=>$usuario){
                    //Se acumula el html para los usuarios
                    $idUsuario = substr($usuarios[$keyUsuario],$posiinic,strpos($usuarios[$keyUsuario],'|',$posiinic) - $posiinic);
                    $posiinic = strpos($usuarios[$keyUsuario],'|',$posiinic) + 1;

                    $usuarioNombre = substr($usuarios[$keyUsuario],$posiinic,strpos($usuarios[$keyUsuario],'|',$posiinic) - $posiinic);
                    $posiinic = strpos($usuarios[$keyUsuario],'|',$posiinic) + 1;

                    $usuarioPerfil = substr($usuarios[$keyUsuario],$posiinic,strpos($usuarios[$keyUsuario],'|',$posiinic) - $posiinic);
                    $descPerfil = $this->usuario->descPerfil($usuarioPerfil);
                    $descPerfil = $descPerfil[0]['perfil_nombre'];
                    $posiinic = strpos($usuarios[$keyUsuario],'|',$posiinic) + 1;

                    $usuarioEstado = substr($usuarios[$keyUsuario],$posiinic,strpos($usuarios[$keyUsuario],'|',$posiinic) - $posiinic);
                    $descEstado = $this->usuario->descEstado($usuarioEstado);
                    $descEstado = $descEstado[0]['estado_descripcion'];
                    $posiinic = strpos($usuarios[$keyUsuario],'|',$posiinic) + 1;

                    $imprUsuario.="<tr>";
                    $imprUsuario.="<td>".$idUsuario."</td>";
                    $imprUsuario.="<td>".$usuarioNombre."</td>";
                    $imprUsuario.="<td>".$descPerfil."</td>";
                    $imprUsuario.="<td>".$descEstado."</td>";
                    $imprUsuario.="<td><button id='btn-modificar' href='#' onclick=\"modificaUsuario('$this->urlBase','$idUsuario')\" type='submit' class='btn btn-default btn-circle'><i class='fa fa-pencil'></i></button></td>";
                    $imprUsuario.="<td><button id='btn-eliminar' href='#' onclick=\"borraUsuario('$this->urlBase','$idUsuario')\" type='submit' class='btn btn-danger btn-circle'><i class='fa fa-times'></i></button></td>";
                    $imprUsuario.="</tr>";
                    $posiinic = 0;
                    }
                    $cargaForma.=$imprUsuario;
                    $imprUsuario   = '';
                    $cargaForma.="</tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!--End Advanced Tables -->
                        </div>
                    </div>";
                echo $cargaForma;
            }
            else{
                echo $cargaForma.="</table>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!--End Advanced Tables -->
                        </div>
                    </div>";
            }
        }
        else{
            echo('No se ha logueado');
            redirect('contenedor');
        }
    }
    
    //Recarga el formulario de consulta de los usuarios una vez eliminado algún usuario.
    function eliminarUsuario(){
        if($this->session->userdata('logged_in')){
            $this->load->model('usuario');
            $idUsuario = $_POST['idUsuario'];
            $persUsua  = $this->usuario->selPersUsua($idUsuario);
            if($persUsua == 0){
                $usuarios  = $this->usuario->borUsuario($idUsuario);
                $cargaForma = "<div class='form-group'>
                                                        <div id='lista'>
                                                            <table class='table table-bordered'width='100%'  border='0' cellspacing='0' cellpadding='0' style='font-size:10px'>
                                                                <thead>
                                                                    <tr>
                                                                        <th>Código</th>
                                                                        <th>Nombre de Usuario</th>
                                                                        <th>Perfil</th>
                                                                        <th>Estado</th>
                                                                    </tr>
                                                                </thead>";
                if($usuarios != false){
                    $imprUsuario = "";
                    $cargaForma.= "<tbody>";
                    $posiinic = 0;                                                
                    foreach ($usuarios as $keyUsuario=>$usuario){
                        //Se acumula el html para los usuarios
                        $idUsuario = substr($usuarios[$keyUsuario],$posiinic,strpos($usuarios[$keyUsuario],'|',$posiinic) - $posiinic);
                        $posiinic = strpos($usuarios[$keyUsuario],'|',$posiinic) + 1;

                        $usuarioNombre = substr($usuarios[$keyUsuario],$posiinic,strpos($usuarios[$keyUsuario],'|',$posiinic) - $posiinic);
                        $posiinic = strpos($usuarios[$keyUsuario],'|',$posiinic) + 1;

                        $usuarioPerfil = substr($usuarios[$keyUsuario],$posiinic,strpos($usuarios[$keyUsuario],'|',$posiinic) - $posiinic);
                        $descPerfil = $this->usuario->descPerfil($usuarioPerfil);
                        $descPerfil = $descPerfil[0]['perfil_nombre'];
                        $posiinic = strpos($usuarios[$keyUsuario],'|',$posiinic) + 1;

                        $usuarioEstado = substr($usuarios[$keyUsuario],$posiinic,strpos($usuarios[$keyUsuario],'|',$posiinic) - $posiinic);
                        $descEstado = $this->usuario->descEstado($usuarioEstado);
                        $descEstado = $descEstado[0]['estado_descripcion'];
                        $posiinic = strpos($usuarios[$keyUsuario],'|',$posiinic) + 1;

                        $imprUsuario.="<tr>";
                        $imprUsuario.="<td>".$idUsuario."</td>";
                        $imprUsuario.="<td>".$usuarioNombre."</td>";
                        $imprUsuario.="<td>".$descPerfil."</td>";
                        $imprUsuario.="<td>".$descEstado."</td>";
                        $imprUsuario.="<td><button id='btn-modificar' href='#' onclick=\"modificaUsuario('$this->urlBase','$idUsuario')\" type='submit' class='btn btn-default btn-circle'><i class='fa fa-pencil'></i></button></td>";
                        $imprUsuario.="<td><button id='btn-eliminar' href='#' onclick=\"borraUsuario('$this->urlBase','$idUsuario')\" type='submit' class='btn btn-danger btn-circle'><i class='fa fa-times'></i></button></td>";
                        $imprUsuario.="</tr>";
                        $posiinic = 0;
                        }
                        $cargaForma.=$imprUsuario;
                        $imprUsuario   = '';
                        $cargaForma.="</tbody>
                                                            </table>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!--End Advanced Tables -->
                            </div>
                        </div>";
                    echo $cargaForma;
                }
                else{
                    echo $cargaForma.="</table>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!--End Advanced Tables -->
                            </div>
                        </div>";
                }
            }
            else{
                echo("persusua");
            }
        }
        else{
            echo('No se ha logueado');
            redirect('contenedor');
        }
    }
    
    function guardarUsuario(){
        $this->load->model('usuario');
        $nombreUsua = $_POST['nombreUsua'];
        $claveUsua  = $_POST['claveUsua'];
        $perfilUsua = $_POST['perfilUsua'];
        $usuariCodi = substr($perfilUsua,0,strpos($perfilUsua,'-',0) - 1);
        $estadoUsua = $_POST['estadoUsua'];
        $estadoCodi = substr($estadoUsua,0,strpos($estadoUsua,'-',0) - 1);
        $usuario    = $this->usuario->insUsuario($nombreUsua,$claveUsua,$usuariCodi,$estadoCodi);
        if(isset($usuario)){
            echo("true");
        }
        else{
            echo("false");
        }
    }
    
    function obtenerUsuario(){
        $this->load->model('usuario');
        $idUsuario  = $_POST['idUsuario'];
        $nombreUsua = $_POST['nombreUsua'];
        $usuario    = $this->usuario->selUsuario($idUsuario,$nombreUsua);
        if($usuario == 0){
            echo("true");
        }
        else{
            echo("false");
        }
    }
    
    //Invoca el modelo de actualización de usuarios.
    function actualizarUsuario(){
        if($this->session->userdata('logged_in')){
            $this->load->model('usuario');
            $codigoUsua = $_POST['idUsuario'];
            $nombreUsua = $_POST['nombreUsua'];
            $claveUsua  = $_POST['claveUsua'];
            $perfilUsua = $_POST['perfilUsua'];
            $perfilCodi = substr($perfilUsua,0,strpos($perfilUsua,'-',0) - 1);
            $estadoUsua = $_POST['estadoUsua'];
            $estadoCodi = substr($estadoUsua,0,strpos($estadoUsua,'-',0) - 1);
            $usuario         = $this->usuario->updUsuario($codigoUsua,$nombreUsua,$claveUsua,$perfilCodi,$estadoCodi);
            if($usuario){
                echo("true");
            }
            else{
                echo("false");
            }
        }
        else{
            echo('No se ha logueado');
            redirect('contenedor');
        }
    }
    
    //Recarga el formulario de consulta de los usuarios a partir del criterio de búsqueda dado.
    function seleccionarUsuario(){
        if($this->session->userdata('logged_in')){
            $this->load->model('usuario');
            $valorUsua = $_POST['usuario_valor'];
            $usuarios  = $this->usuario->consUsuario($valorUsua);
            $imprUsuario = "";
            $cargaForma = "<div class='form-group'>
                                                    <div id='lista'>
                                                        <table class='table table-bordered'width='100%'  border='0' cellspacing='0' cellpadding='0' style='font-size:10px'>
                                                            <thead>
                                                                <tr>
                                                                    <th>Código</th>
                                                                    <th>Nombre de Usuario</th>
                                                                    <th>Perfil</th>
                                                                    <th>Estado</th>
                                                                </tr>
                                                            </thead>";
            if($usuarios != false){
                $imprUsuario = "";
                $cargaForma.= "<tbody>";
                $posiinic = 0;                                                
                foreach ($usuarios as $keyUsuario=>$usuario){
                    //Se acumula el html para los usuarios
                    $idUsuario = substr($usuarios[$keyUsuario],$posiinic,strpos($usuarios[$keyUsuario],'|',$posiinic) - $posiinic);
                    $posiinic = strpos($usuarios[$keyUsuario],'|',$posiinic) + 1;

                    $usuarioNombre = substr($usuarios[$keyUsuario],$posiinic,strpos($usuarios[$keyUsuario],'|',$posiinic) - $posiinic);
                    $posiinic = strpos($usuarios[$keyUsuario],'|',$posiinic) + 1;

                    $usuarioPerfil = substr($usuarios[$keyUsuario],$posiinic,strpos($usuarios[$keyUsuario],'|',$posiinic) - $posiinic);
                    $descPerfil = $this->usuario->descPerfil($usuarioPerfil);
                    $descPerfil = $descPerfil[0]['perfil_nombre'];
                    $posiinic = strpos($usuarios[$keyUsuario],'|',$posiinic) + 1;

                    $usuarioEstado = substr($usuarios[$keyUsuario],$posiinic,strpos($usuarios[$keyUsuario],'|',$posiinic) - $posiinic);
                    $descEstado = $this->usuario->descEstado($usuarioEstado);
                    $descEstado = $descEstado[0]['estado_descripcion'];
                    $posiinic = strpos($usuarios[$keyUsuario],'|',$posiinic) + 1;

                    $imprUsuario.="<tr>";
                    $imprUsuario.="<td>".$idUsuario."</td>";
                    $imprUsuario.="<td>".$usuarioNombre."</td>";
                    $imprUsuario.="<td>".$descPerfil."</td>";
                    $imprUsuario.="<td>".$descEstado."</td>";
                    $imprUsuario.="<td><button id='btn-modificar' href='#' onclick=\"modificaUsuario('$this->urlBase','$idUsuario')\" type='submit' class='btn btn-default btn-circle'><i class='fa fa-pencil'></i></button></td>";
                    $imprUsuario.="<td><button id='btn-eliminar' href='#' onclick=\"borraUsuario('$this->urlBase','$idUsuario')\" type='submit' class='btn btn-danger btn-circle'><i class='fa fa-times'></i></button></td>";
                    $imprUsuario.="</tr>";
                    $posiinic = 0;
                    }
                    $cargaForma.=$imprUsuario;
                    $imprUsuario   = '';
                    $cargaForma.="</tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!--End Advanced Tables -->
                        </div>
                    </div>";
                echo $cargaForma;
            }
            else{
                echo $cargaForma.="</table>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!--End Advanced Tables -->
                        </div>
                    </div>";
            }
        }
        else{
            echo('No se ha logueado');
            redirect('contenedor');
        }
    }
}
?>
<?php if (! defined('BASEPATH')) exit('No direct script access allowed');
 
class Personas extends MX_Controller {
    
    function __construct(){
        parent::__construct();
        $this->urlBase = base_url();
    }
 
    function index(){
        echo("personas.index");
    }
	
    function crearPersona(){
        //Se cargan los Estados desde el modelo Persona
        $this->load->model('persona');
        $estados     = $this->persona->listaEstados();
        $ciudades    = $this->persona->listaCiudades();
        $usuarios    = $this->persona->listaUsuarios();
        $imprOpci    ="";
        $imprCiudad  ="";
        $imprUsuario ="";
        $cargaForma  = "<div class='row'>
                 <!-- page header -->
                <div class='col-lg-12'>
                    <h1 class='page-header'>Crear Persona</h1>
                </div>
                <!--end page header -->
            </div>
            <div class='row'>
                <div class='col-lg-12'>
                    <!-- Form Elements -->
                    <div class='panel panel-default'>
                        <div class='panel-heading'>
                            Registro de Personas
                        </div>
                        <div class='panel-body'>
                            <div class='row'>
                                <div class='col-lg-6'>
                                    <form role='form'>
                                        <div class='form-group'>
                                            <label>Código Persona</label>
                                            <input id='id-persona' class='form-control' placeholder='Identificador único de la Persona.'>
                                        </div>
                                        
                                        <div class='form-group'>
                                            <label>Apellidos</label>
                                            <input id='persona-apellido' class='form-control'>
                                        </div>
                                        
                                        <div class='form-group'>
                                            <label>Ciudad</label>
                                            <select id='persona-ciudad' class='form-control'>";
        foreach ($ciudades as $keyCiudad=>$ciudad){
            //Se acumula el html para las opciones
            $imprCiudad.="<option>".$ciudades[$keyCiudad]."</option>"
                       . "";
        }
        $cargaForma.=$imprCiudad;
        $cargaForma.="</select>
                                        </div>
                                        
                                        <div class='form-group'>
                                            <label>Teléfono</label>
                                            <input id='persona-telefono' class='form-control'>
                                        </div>
                                        
                                        <div class='form-group'>
                                            <label>Estado</label>
                                            <select id='persona-estado' class='form-control'>";
        
        foreach ($estados as $keyEstado=>$estado){
            //Se acumula el html para las opciones
            $imprOpci.="<option>".$estados[$keyEstado]."</option>"
                       . "";
        }
        $cargaForma.=$imprOpci;
        $cargaForma.="</select>
                                        </div>
                                        <button id='btn-guardar' href='#' onclick=\"insertaPersona('$this->urlBase')\" type='submit' class='btn btn-primary'>Guardar</button>
                                        <button type='reset' class='btn btn-success'>Cancelar</button>
                                    </form>
                                </div>
                                <div class='col-lg-6'>
                                    <form role='form'>
                                        <div class='form-group'>
                                            <label>Nombres</label>
                                            <input id='persona-nombre' class='form-control' placeholder='Descripción de la Persona.'>
                                        </div>
                                        
                                        <div class='form-group'>
                                            <label>Email</label>
                                            <input id='persona-email' class='form-control' placeholder='correo@mail.com'>
                                        </div>
                                        
                                        <div class='form-group'>
                                            <label>Dirección</label>
                                            <input id='persona-direccion' class='form-control'>
                                        </div>
                                        
                                        <div class='form-group'>
                                            <label>Usuario</label>
                                            <select id='persona-usuario' class='form-control'>";
        foreach ($usuarios as $keyUsuario=>$usuario){
            //Se acumula el html para las opciones
            $imprUsuario.="<option>".$usuarios[$keyUsuario]."</option>"
                       . "";
        }
        $cargaForma.=$imprUsuario;
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
    
    function modificarPersona(){
        if($this->session->userdata('logged_in')){
            $this->load->model('persona');
            $codigoPers         = $_POST['idPersona'];
            $estados            = $this->persona->listaEstados();
            $ciudades           = $this->persona->listaCiudades();
            $usuarios           = $this->persona->listaUsuarios();
            $persona            = $this->persona->selModiPersona($codigoPers);
            $id_persona         = $persona[0]['id_persona'];
            $persona_nombre     = $persona[0]['persona_nombre'];
            $persona_apellido   = $persona[0]['persona_apellido'];
            $persona_email      = $persona[0]['persona_email'];
            $persona_ciudad_id  = $persona[0]['persona_ciudad_id'];
            $ciudad             = $this->persona->selCiudad($persona_ciudad_id);
            $persona_ciudad     = $ciudad[0]['ciudad'];
            $persona_direccion  = $persona[0]['persona_direccion'];
            $persona_telefono   = $persona[0]['persona_telefono'];
            $persona_usuario_id = $persona[0]['persona_usuario_id'];
            $usuario            = $this->persona->selUsuario($persona_usuario_id);
            $persona_usuario     = $usuario[0]['usuario'];
            $persona_estado_id  = $persona[0]['persona_estado_id'];
            $estado             = $this->persona->selEstado($persona_estado_id);
            $persona_estado     = $estado[0]['estado'];
            $imprOpci           = "";
            $imprCiudad         = "";
            $imprUsuario        = "";
            $cargaForma  = "<div class='row'>
                 <!-- page header -->
                <div class='col-lg-12'>
                    <h1 class='page-header'>Modificar Persona</h1>
                </div>
                <!--end page header -->
            </div>
            <div class='row'>
                <div class='col-lg-12'>
                    <!-- Form Elements -->
                    <div class='panel panel-default'>
                        <div class='panel-heading'>
                            Registro de Personas
                        </div>
                        <div class='panel-body'>
                            <div class='row'>
                                <div class='col-lg-6'>
                                    <form role='form'>
                                        <div class='form-group'>
                                            <label>Código Persona</label>
                                            <input id='id-persona' class='form-control' placeholder='Identificador único de la Persona.' value = '$id_persona' disabled>
                                        </div>
                                        
                                        <div class='form-group'>
                                            <label>Apellidos</label>
                                            <input id='persona-apellido' class='form-control' value = '$persona_apellido'>
                                        </div>
                                        
                                        <div class='form-group'>
                                            <label>Ciudad</label>
                                            <select id='persona-ciudad' class='form-control'>";
        foreach ($ciudades as $keyCiudad=>$ciudad){
            //Se acumula el html para las opciones
            if($persona_ciudad == $ciudades[$keyCiudad]){
                $imprCiudad.="<option selected>".$persona_ciudad."</option>";
            }
            else{
                $imprCiudad.="<option>".$ciudades[$keyCiudad]."</option>";
            }
        }
        $cargaForma.=$imprCiudad;
        $cargaForma.="</select>
                                        </div>
                                        
                                        <div class='form-group'>
                                            <label>Teléfono</label>
                                            <input id='persona-telefono' class='form-control' value = '$persona_telefono'>
                                        </div>
                                        
                                        <div class='form-group'>
                                            <label>Estado</label>
                                            <select id='persona-estado' class='form-control'>";
        
        foreach ($estados as $keyEstado=>$estado){
            //Se acumula el html para los estados
            if($persona_estado == $estados[$keyEstado]){
                $imprOpci.="<option selected>".$persona_estado."</option>";
            }
            else{
                $imprOpci.="<option>".$estados[$keyEstado]."</option>";
            }
        }
        $cargaForma.=$imprOpci;
        $cargaForma.="</select>
                                        </div>
                                        <button id='btn-guardar' href='#' onclick=\"actualizaPersona('$this->urlBase')\" type='submit' class='btn btn-primary'>Guardar</button>
                                        <button type='reset' class='btn btn-success'>Cancelar</button>
                                    </form>
                                </div>
                                <div class='col-lg-6'>
                                    <form role='form'>
                                        <div class='form-group'>
                                            <label>Nombres</label>
                                            <input id='persona-nombre' class='form-control' placeholder='Descripción de la Persona.' value = '$persona_nombre'>
                                        </div>
                                        
                                        <div class='form-group'>
                                            <label>Email</label>
                                            <input id='persona-email' class='form-control' placeholder='correo@mail.com' value = '$persona_email'>
                                        </div>
                                        
                                        <div class='form-group'>
                                            <label>Dirección</label>
                                            <input id='persona-direccion' class='form-control' value = '$persona_direccion'>
                                        </div>
                                        
                                        <div class='form-group'>
                                            <label>Usuario</label>
                                            <select id='persona-usuario' class='form-control'>";
        foreach ($usuarios as $keyUsuario=>$usuario){
            //Se acumula el html para las opciones
            if($persona_usuario == $usuarios[$keyUsuario]){
                $imprUsuario.="<option selected>".$persona_usuario."</option>";
            }
            else{
                $imprUsuario.="<option>".$usuarios[$keyUsuario]."</option>";
            }
        }
        $cargaForma.=$imprUsuario;
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
    
    
    //Carga el formulario de consulta de los personas.
    function consultarPersona(){
        if($this->session->userdata('logged_in')){
            $valorPers = "";
            $this->load->model('persona');
            $personas    = $this->persona->consPersona($valorPers);
            $imprPersona = "";
            $cargaForma  = "<div class='row' onload='consultaPersona('$this->urlBase')'>
                        <!-- Page Header -->
                        <div class='col-lg-12'>
                            <h1 class='page-header'>Consultar Persona</h1>
                        </div>
                        <!--End Page Header -->
                    </div>
                    <div class='row'>
                        <div class='col-lg-12'>
                            <!-- Advanced Tables -->
                            <div class='panel panel-default'>
                                <div class='panel-heading'>
                                     Consulta de Personas
                                </div>
                                <div class='panel-body'>
                                    <div class='table-responsive'>
                                        <div id='dataTables-example_wrapper' class='dataTables_wrapper form-inline' role='grid'>
                                            <div class='row'>
                                                <div class='col-sm-6'>
                                                    <!-- search section-->
                                                    <div id='dataTables-example_filter' class='dataTables_filter'>
                                                        <span class='input-group-btn'>
                                                            <input type='search' id='persona-valor' class='form-control input-sm' aria-controls='dataTables-example' placeholder='Buscar'>
                                                            <button id='busca-persona' class='btn btn-default' onclick=\"consultaPersona('$this->urlBase')\" type='submit'><i class='fa fa-search'></i></button>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div id='personas' class='row'>
                                                <div class='form-group'>
                                                    <div id='lista'>
                                                        <table class='table table-bordered'width='100%'  border='0' cellspacing='0' cellpadding='0' style='font-size:10px'>
                                                            <thead>
                                                                <tr>
                                                                    <th>Código</th>
                                                                    <th>Nombre</th>
                                                                    <th>Apellido</th>
                                                                    <th>Email</th>
                                                                    <th>Ciudad</th>
                                                                    <th>Dirección</th>
                                                                    <th>Teléfono</th>
                                                                    <th>Usuario</th>
                                                                    <th>Persona Registra</th>
                                                                    <th>Fecha Registro</th>
                                                                    <th>Estado</th>
                                                                </tr>
                                                            </thead>";
            if($personas != false){
                $imprPersona = "";
                $cargaForma.= "<tbody>";
                                                            $posiinic = 0;                                                
                                                            foreach ($personas as $keyPersona=>$persona){
                                                                    //Se acumula el html para los personas
                                                                    $idPersona = substr($personas[$keyPersona],$posiinic,strpos($personas[$keyPersona],'|',$posiinic) - $posiinic);
                                                                    $posiinic = strpos($personas[$keyPersona],'|',$posiinic) + 1;

                                                                    $personaNombre = substr($personas[$keyPersona],$posiinic,strpos($personas[$keyPersona],'|',$posiinic) - $posiinic);
                                                                    $posiinic = strpos($personas[$keyPersona],'|',$posiinic) + 1;

                                                                    $personaApellido = substr($personas[$keyPersona],$posiinic,strpos($personas[$keyPersona],'|',$posiinic) - $posiinic);
                                                                    $posiinic = strpos($personas[$keyPersona],'|',$posiinic) + 1;

                                                                    $personaEmail = substr($personas[$keyPersona],$posiinic,strpos($personas[$keyPersona],'|',$posiinic) - $posiinic);
                                                                    $posiinic = strpos($personas[$keyPersona],'|',$posiinic) + 1;

                                                                    $personaCiudad = substr($personas[$keyPersona],$posiinic,strpos($personas[$keyPersona],'|',$posiinic) - $posiinic);
                                                                    $descCiudad = $this->persona->descCiudad($personaCiudad);
                                                                    $descCiudad = $descCiudad[0]['ciudad_nombre'];
                                                                    $posiinic = strpos($personas[$keyPersona],'|',$posiinic) + 1;

                                                                    $personaDireccion = substr($personas[$keyPersona],$posiinic,strpos($personas[$keyPersona],'|',$posiinic) - $posiinic);
                                                                    $posiinic = strpos($personas[$keyPersona],'|',$posiinic) + 1;

                                                                    $personaTelefono = substr($personas[$keyPersona],$posiinic,strpos($personas[$keyPersona],'|',$posiinic) - $posiinic);
                                                                    $posiinic = strpos($personas[$keyPersona],'|',$posiinic) + 1;

                                                                    $personaUsuario = substr($personas[$keyPersona],$posiinic,strpos($personas[$keyPersona],'|',$posiinic) - $posiinic);
                                                                    $descUsuario = $this->persona->descUsuario($personaUsuario);
                                                                    $descUsuario = $descUsuario[0]['usuario_nombre'];
                                                                    $posiinic = strpos($personas[$keyPersona],'|',$posiinic) + 1;

                                                                    $personaEstado = substr($personas[$keyPersona],$posiinic,strpos($personas[$keyPersona],'|',$posiinic) - $posiinic);
                                                                    $descEstado = $this->persona->descEstado($personaEstado);
                                                                    $descEstado = $descEstado[0]['estado_descripcion'];
                                                                    $posiinic = strpos($personas[$keyPersona],'|',$posiinic) + 1;

                                                                    $personaFechaRegistro = substr($personas[$keyPersona],$posiinic,strpos($personas[$keyPersona],'|',$posiinic) - $posiinic);
                                                                    $posiinic = strpos($personas[$keyPersona],'|',$posiinic) + 1;

                                                                    $personaPersonaRegistra = substr($personas[$keyPersona],$posiinic,strpos($personas[$keyPersona],'|',$posiinic) - $posiinic);
                                                                    $posiinic = strpos($personas[$keyPersona],'|',$posiinic) + 1;

                                                                    $imprPersona.="<tr>";
                                                                    $imprPersona.="<td>".$idPersona."</td>";
                                                                    $imprPersona.="<td>".$personaNombre."</td>";
                                                                    $imprPersona.="<td>".$personaApellido."</td>";
                                                                    $imprPersona.="<td>".$personaEmail."</td>";
                                                                    $imprPersona.="<td>".$descCiudad."</td>";
                                                                    $imprPersona.="<td>".$personaDireccion."</td>";
                                                                    $imprPersona.="<td>".$personaTelefono."</td>";
                                                                    $imprPersona.="<td>".$descUsuario."</td>";
                                                                    $imprPersona.="<td>".$personaPersonaRegistra."</td>";
                                                                    $imprPersona.="<td>".$personaFechaRegistro."</td>";
                                                                    $imprPersona.="<td>".$descEstado."</td>";
                                                                    $imprPersona.="<td><button id='btn-modificar' href='#' onclick=\"modificaPersona('$this->urlBase','$idPersona')\" type='submit' class='btn btn-default btn-circle'><i class='fa fa-pencil'></i></button></td>";
                                                                    $imprPersona.="<td><button id='btn-eliminar' href='#' onclick=\"borraPersona('$this->urlBase','$idPersona')\" type='submit' class='btn btn-danger btn-circle'><i class='fa fa-times'></i></button></td>";
                                                                    $imprPersona.="</tr>";
                                                                    $posiinic = 0;
                                                                }
                                                                $cargaForma.=$imprPersona;
                                                                $imprPersona   = '';
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
    
    //Recarga el formulario de consulta de los clientes una vez eliminado algún cliente.
    function eliminarPersona(){
        if($this->session->userdata('logged_in')){
            $this->load->model('persona');
            $codigoPers = $_POST['idPersona'];
            $personas  = $this->persona->borPersona($codigoPers);
            $cargaForma  = "<div class='form-group'>
                                                    <div id='lista'>
                                                        <table class='table table-bordered'width='100%'  border='0' cellspacing='0' cellpadding='0' style='font-size:10px'>
                                                            <thead>
                                                                <tr>
                                                                    <th>Código</th>
                                                                    <th>Nombre</th>
                                                                    <th>Apellido</th>
                                                                    <th>Email</th>
                                                                    <th>Ciudad</th>
                                                                    <th>Dirección</th>
                                                                    <th>Teléfono</th>
                                                                    <th>Usuario</th>
                                                                    <th>Persona Registra</th>
                                                                    <th>Fecha Registro</th>
                                                                    <th>Estado</th>
                                                                </tr>
                                                            </thead>";
            if($personas != false){
                $imprPersona = "";
                $cargaForma.= "<tbody>";
                                                            $posiinic = 0;                                                
                                                            foreach ($personas as $keyPersona=>$persona){
                                                                    //Se acumula el html para los personas
                                                                    $idPersona = substr($personas[$keyPersona],$posiinic,strpos($personas[$keyPersona],'|',$posiinic) - $posiinic);
                                                                    $posiinic = strpos($personas[$keyPersona],'|',$posiinic) + 1;

                                                                    $personaNombre = substr($personas[$keyPersona],$posiinic,strpos($personas[$keyPersona],'|',$posiinic) - $posiinic);
                                                                    $posiinic = strpos($personas[$keyPersona],'|',$posiinic) + 1;

                                                                    $personaApellido = substr($personas[$keyPersona],$posiinic,strpos($personas[$keyPersona],'|',$posiinic) - $posiinic);
                                                                    $posiinic = strpos($personas[$keyPersona],'|',$posiinic) + 1;

                                                                    $personaEmail = substr($personas[$keyPersona],$posiinic,strpos($personas[$keyPersona],'|',$posiinic) - $posiinic);
                                                                    $posiinic = strpos($personas[$keyPersona],'|',$posiinic) + 1;

                                                                    $personaCiudad = substr($personas[$keyPersona],$posiinic,strpos($personas[$keyPersona],'|',$posiinic) - $posiinic);
                                                                    $descCiudad = $this->persona->descCiudad($personaCiudad);
                                                                    $descCiudad = $descCiudad[0]['ciudad_nombre'];
                                                                    $posiinic = strpos($personas[$keyPersona],'|',$posiinic) + 1;

                                                                    $personaDireccion = substr($personas[$keyPersona],$posiinic,strpos($personas[$keyPersona],'|',$posiinic) - $posiinic);
                                                                    $posiinic = strpos($personas[$keyPersona],'|',$posiinic) + 1;

                                                                    $personaTelefono = substr($personas[$keyPersona],$posiinic,strpos($personas[$keyPersona],'|',$posiinic) - $posiinic);
                                                                    $posiinic = strpos($personas[$keyPersona],'|',$posiinic) + 1;

                                                                    $personaUsuario = substr($personas[$keyPersona],$posiinic,strpos($personas[$keyPersona],'|',$posiinic) - $posiinic);
                                                                    $descUsuario = $this->persona->descUsuario($personaUsuario);
                                                                    $descUsuario = $descUsuario[0]['usuario_nombre'];
                                                                    $posiinic = strpos($personas[$keyPersona],'|',$posiinic) + 1;

                                                                    $personaEstado = substr($personas[$keyPersona],$posiinic,strpos($personas[$keyPersona],'|',$posiinic) - $posiinic);
                                                                    $descEstado = $this->persona->descEstado($personaEstado);
                                                                    $descEstado = $descEstado[0]['estado_descripcion'];
                                                                    $posiinic = strpos($personas[$keyPersona],'|',$posiinic) + 1;

                                                                    $personaFechaRegistro = substr($personas[$keyPersona],$posiinic,strpos($personas[$keyPersona],'|',$posiinic) - $posiinic);
                                                                    $posiinic = strpos($personas[$keyPersona],'|',$posiinic) + 1;

                                                                    $personaPersonaRegistra = substr($personas[$keyPersona],$posiinic,strpos($personas[$keyPersona],'|',$posiinic) - $posiinic);
                                                                    $posiinic = strpos($personas[$keyPersona],'|',$posiinic) + 1;

                                                                    $imprPersona.="<tr>";
                                                                    $imprPersona.="<td>".$idPersona."</td>";
                                                                    $imprPersona.="<td>".$personaNombre."</td>";
                                                                    $imprPersona.="<td>".$personaApellido."</td>";
                                                                    $imprPersona.="<td>".$personaEmail."</td>";
                                                                    $imprPersona.="<td>".$descCiudad."</td>";
                                                                    $imprPersona.="<td>".$personaDireccion."</td>";
                                                                    $imprPersona.="<td>".$personaTelefono."</td>";
                                                                    $imprPersona.="<td>".$descUsuario."</td>";
                                                                    $imprPersona.="<td>".$personaPersonaRegistra."</td>";
                                                                    $imprPersona.="<td>".$personaFechaRegistro."</td>";
                                                                    $imprPersona.="<td>".$descEstado."</td>";
                                                                    $imprPersona.="<td><button id='btn-modificar' href='#' onclick=\"modificaPersona('$this->urlBase','$idPersona')\" type='submit' class='btn btn-default btn-circle'><i class='fa fa-pencil'></i></button></td>";
                                                                    $imprPersona.="<td><button id='btn-eliminar' href='#' onclick=\"borraPersona('$this->urlBase','$idPersona')\" type='submit' class='btn btn-danger btn-circle'><i class='fa fa-times'></i></button></td>";
                                                                    $imprPersona.="</tr>";
                                                                    $posiinic = 0;
                                                                }
                                                                $cargaForma.=$imprPersona;
                                                                $imprPersona   = '';
                                                                $cargaForma.="</tbody>
                                                        </table>
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
    
    function guardarPersona(){
        $this->load->model('persona');
        $idPers          = $_POST['idPers'];
        $nombrePers      = $_POST['nombrePers'];
        $apellidoPers    = $_POST['apellidoPers'];
        $emailPers       = $_POST['emailPers'];
        $ciudadPers      = $_POST['ciudadPers'];
        $ciudadCodi      = substr($ciudadPers,0,strpos($ciudadPers,'-',0) - 1);
        $direccionPers   = $_POST['direccionPers'];
        $telefonoPers    = $_POST['telefonoPers'];
        $usuarioPers     = $_POST['usuarioPers'];
        $usuarioCodi     = substr($usuarioPers,0,strpos($usuarioPers,'-',0) - 1);
        $estadoPers      = $_POST['estadoPers'];
        $estadoCodi      = substr($estadoPers,0,strpos($estadoPers,'-',0) - 1);
        $personaPers     = $this->session->userdata('idPers');
        $persona         = $this->persona->insPersona($idPers,$nombrePers,$apellidoPers,$emailPers,
                                                      $ciudadCodi,$direccionPers,$telefonoPers,$usuarioCodi,
                                                      $estadoCodi,$personaPers);
        if(isset($persona)){
            echo("true");
        }
        else{
            echo("false");}
        }
    
    function obtenerPersona(){
        $this->load->model('persona');
        $codigoPers = $_POST['idPers'];
        $persona    = $this->persona->selPersona($codigoPers);
        echo($persona);
    }
    
    function validarUsuaPers(){
        $this->load->model('persona');
        $idPers      = $_POST['idPers'];
        $usuaPers    = $_POST['usuarioPers'];
        $usuarioCodi = substr($usuaPers,0,strpos($usuaPers,'-',0) - 1);
        $persona     = $this->persona->selUsuaPers($idPers,$usuarioCodi);
        echo($persona);
    }
    
    
    //Recarga el formulario de consulta de las personas a partir del criterio de búsqueda dado.
    function seleccionarPersona(){
        if($this->session->userdata('logged_in')){
            $this->load->model('persona');
            $valorPers = $_POST['persona_valor'];
            $personas  = $this->persona->consPersona($valorPers);
            $imprPersona = "";
            $cargaForma  = "<div class='form-group'>
                                                    <div id='lista'>
                                                        <table class='table table-bordered'width='100%'  border='0' cellspacing='0' cellpadding='0' style='font-size:10px'>
                                                            <thead>
                                                                <tr>
                                                                    <th>Código</th>
                                                                    <th>Nombre</th>
                                                                    <th>Apellido</th>
                                                                    <th>Email</th>
                                                                    <th>Ciudad</th>
                                                                    <th>Dirección</th>
                                                                    <th>Teléfono</th>
                                                                    <th>Usuario</th>
                                                                    <th>Persona Registra</th>
                                                                    <th>Fecha Registro</th>
                                                                    <th>Estado</th>
                                                                </tr>
                                                            </thead>";
            if($personas != false){
                $imprPersona = "";
                $cargaForma.= "<tbody>";
                                                            $posiinic = 0;                                                
                                                            foreach ($personas as $keyPersona=>$persona){
                                                                    //Se acumula el html para los personas
                                                                    $idPersona = substr($personas[$keyPersona],$posiinic,strpos($personas[$keyPersona],'|',$posiinic) - $posiinic);
                                                                    $posiinic = strpos($personas[$keyPersona],'|',$posiinic) + 1;

                                                                    $personaNombre = substr($personas[$keyPersona],$posiinic,strpos($personas[$keyPersona],'|',$posiinic) - $posiinic);
                                                                    $posiinic = strpos($personas[$keyPersona],'|',$posiinic) + 1;

                                                                    $personaApellido = substr($personas[$keyPersona],$posiinic,strpos($personas[$keyPersona],'|',$posiinic) - $posiinic);
                                                                    $posiinic = strpos($personas[$keyPersona],'|',$posiinic) + 1;

                                                                    $personaEmail = substr($personas[$keyPersona],$posiinic,strpos($personas[$keyPersona],'|',$posiinic) - $posiinic);
                                                                    $posiinic = strpos($personas[$keyPersona],'|',$posiinic) + 1;

                                                                    $personaCiudad = substr($personas[$keyPersona],$posiinic,strpos($personas[$keyPersona],'|',$posiinic) - $posiinic);
                                                                    $descCiudad = $this->persona->descCiudad($personaCiudad);
                                                                    $descCiudad = $descCiudad[0]['ciudad_nombre'];
                                                                    $posiinic = strpos($personas[$keyPersona],'|',$posiinic) + 1;

                                                                    $personaDireccion = substr($personas[$keyPersona],$posiinic,strpos($personas[$keyPersona],'|',$posiinic) - $posiinic);
                                                                    $posiinic = strpos($personas[$keyPersona],'|',$posiinic) + 1;

                                                                    $personaTelefono = substr($personas[$keyPersona],$posiinic,strpos($personas[$keyPersona],'|',$posiinic) - $posiinic);
                                                                    $posiinic = strpos($personas[$keyPersona],'|',$posiinic) + 1;

                                                                    $personaUsuario = substr($personas[$keyPersona],$posiinic,strpos($personas[$keyPersona],'|',$posiinic) - $posiinic);
                                                                    $descUsuario = $this->persona->descUsuario($personaUsuario);
                                                                    $descUsuario = $descUsuario[0]['usuario_nombre'];
                                                                    $posiinic = strpos($personas[$keyPersona],'|',$posiinic) + 1;

                                                                    $personaEstado = substr($personas[$keyPersona],$posiinic,strpos($personas[$keyPersona],'|',$posiinic) - $posiinic);
                                                                    $descEstado = $this->persona->descEstado($personaEstado);
                                                                    $descEstado = $descEstado[0]['estado_descripcion'];
                                                                    $posiinic = strpos($personas[$keyPersona],'|',$posiinic) + 1;

                                                                    $personaFechaRegistro = substr($personas[$keyPersona],$posiinic,strpos($personas[$keyPersona],'|',$posiinic) - $posiinic);
                                                                    $posiinic = strpos($personas[$keyPersona],'|',$posiinic) + 1;

                                                                    $personaPersonaRegistra = substr($personas[$keyPersona],$posiinic,strpos($personas[$keyPersona],'|',$posiinic) - $posiinic);
                                                                    $posiinic = strpos($personas[$keyPersona],'|',$posiinic) + 1;

                                                                    $imprPersona.="<tr>";
                                                                    $imprPersona.="<td>".$idPersona."</td>";
                                                                    $imprPersona.="<td>".$personaNombre."</td>";
                                                                    $imprPersona.="<td>".$personaApellido."</td>";
                                                                    $imprPersona.="<td>".$personaEmail."</td>";
                                                                    $imprPersona.="<td>".$descCiudad."</td>";
                                                                    $imprPersona.="<td>".$personaDireccion."</td>";
                                                                    $imprPersona.="<td>".$personaTelefono."</td>";
                                                                    $imprPersona.="<td>".$descUsuario."</td>";
                                                                    $imprPersona.="<td>".$personaPersonaRegistra."</td>";
                                                                    $imprPersona.="<td>".$personaFechaRegistro."</td>";
                                                                    $imprPersona.="<td>".$descEstado."</td>";
                                                                    $imprPersona.="<td><button id='btn-modificar' href='#' onclick=\"modificaPersona('$this->urlBase','$idPersona')\" type='submit' class='btn btn-default btn-circle'><i class='fa fa-pencil'></i></button></td>";
                                                                    $imprPersona.="<td><button id='btn-eliminar' href='#' onclick=\"borraPersona('$this->urlBase','$idPersona')\" type='submit' class='btn btn-danger btn-circle'><i class='fa fa-times'></i></button></td>";
                                                                    $imprPersona.="</tr>";
                                                                    $posiinic = 0;
                                                                }
                                                                $cargaForma.=$imprPersona;
                                                                $imprPersona   = '';
                                                                $cargaForma.="</tbody>
                                                        </table>
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
    
    
    
    //Invoca el modelo de actualización de clientes.
    function actualizarPersona(){
        if($this->session->userdata('logged_in')){
            $this->load->model('persona');
            $idPers          = $_POST['idPers'];
            $nombrePers      = $_POST['nombrePers'];
            $apellidoPers    = $_POST['apellidoPers'];
            $emailPers       = $_POST['emailPers'];
            $ciudadPers      = $_POST['ciudadPers'];
            $ciudadCodi      = substr($ciudadPers,0,strpos($ciudadPers,'-',0) - 1);
            $direccionPers   = $_POST['direccionPers'];
            $telefonoPers    = $_POST['telefonoPers'];
            $usuarioPers     = $_POST['usuarioPers'];
            $usuarioCodi     = substr($usuarioPers,0,strpos($usuarioPers,'-',0) - 1);
            $estadoPers      = $_POST['estadoPers'];
            $estadoCodi      = substr($estadoPers,0,strpos($estadoPers,'-',0) - 1);
            $personaPers     = $this->session->userdata('idPers');
            $persona         = $this->persona->updPersona($idPers,$nombrePers,$apellidoPers,$emailPers,
                                                          $ciudadCodi,$direccionPers,$telefonoPers,$usuarioCodi,
                                                          $estadoCodi,$personaPers);
            if(isset($persona)){
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
}
?>
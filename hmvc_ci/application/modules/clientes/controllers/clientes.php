<?php if (! defined('BASEPATH')) exit('No direct script access allowed');
 
class Clientes extends MX_Controller {
    
    function __construct(){
        parent::__construct();
        $this->urlBase = base_url();
    }
 
    function index(){
        echo("clientes.index");
    }
	
    function crearCliente(){
        if($this->session->userdata('logged_in')){
            //Se cargan los Estados desde el modelo Cliente
            $this->load->model('cliente');
            $estados    = $this->cliente->listaEstados();
            $generos    = $this->cliente->listaGeneros();
            $ciudades   = $this->cliente->listaCiudades();
            $imprOpci   = "";
            $imprCiudad = "";
            $cargaForma = "<div class='row'>
                     <!-- page header -->
                    <div class='col-lg-12'>
                        <h1 class='page-header'>Crear Cliente</h1>
                    </div>
                    <!--end page header -->
                </div>
                <div class='row'>
                    <div class='col-lg-12'>
                        <!-- Form Elements -->
                        <div class='panel panel-default'>
                            <div class='panel-heading'>
                                Registro de Clientes
                            </div>
                            <div class='panel-body'>
                                <div class='row'>
                                    <div class='col-lg-6'>
                                        <form role='form'>
                                            <div class='form-group'>
                                                <label>Código Cliente</label>
                                                <input id='id-cliente' class='form-control' placeholder='Identificador único del Cliente.'>
                                            </div>

                                            <div class='form-group'>
                                                <label>Género</label>
                                                <select id='cliente-genero' class='form-control'>";

            foreach ($generos as $keyGenero=>$genero){
                //Se acumula el html para las opciones
                $imprOpci.="<option>".$generos[$keyGenero]."</option>"
                           . "";
            }
            $cargaForma.=$imprOpci;
            $imprOpci   = '';
            $cargaForma.="</select>
                                            </div>
                                            <div class='form-group'>
                                                <label>Ciudad</label>
                                                <select id='cliente-ciudad' class='form-control'>";
            foreach ($ciudades as $keyCiudad=>$ciudad){
                //Se acumula el html para las opciones
                $imprCiudad.="<option>".$ciudades[$keyCiudad]."</option>"
                           . "";
            }
            $cargaForma.=$imprCiudad;
            $cargaForma.="</select>
                                            </div>
                                            <div class='form-group'>
                                                <label>Email</label>
                                                <input id='cliente-email' class='form-control' placeholder='correo@mail.com'>
                                            </div>

                                            <div class='form-group'>
                                                <label>Estados</label>
                                                <select id='cliente-estado' class='form-control'>";

            foreach ($estados as $keyEstado=>$estado){
                //Se acumula el html para las opciones
                $imprOpci.="<option>".$estados[$keyEstado]."</option>"
                           . "";
            }
            $cargaForma.=$imprOpci;
            $imprOpci   = '';
            $cargaForma.="</select>
                                            </div>

                                            <button id='btn-guardar' href='#' onclick=\"insertaCliente('$this->urlBase')\" type='submit' class='btn btn-primary'>Guardar</button>
                                            <button type='reset' class='btn btn-success'>Cancelar</button>
                                        </form>
                                    </div>
                                    <div class='col-lg-6'>
                                        <form role='form'>
                                            <div class='form-group'>
                                                <label>Nombres y Apellidos</label>
                                                <input id='cliente-nombre' class='form-control' placeholder='Descripción del Cliente.'>
                                            </div>

                                            <div class='form-group'>
                                                <label>Teléfono</label>
                                                <input id='cliente-telefono' class='form-control'>
                                            </div>

                                            <div class='form-group'>
                                                <label>Dirección</label>
                                                <input id='cliente-direccion' class='form-control'>
                                            </div>

                                            <div class='form-group'>
                                                <label>Fecha de Nacimiento</label>
                                                <input id='cliente-fechanacimiento' type='date' data-format='dd-MM-yyyy' class='form-control' placeholder='dd-mm-yyyy'>
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
    
    function modificarCliente(){
        if($this->session->userdata('logged_in')){
            $this->load->model('cliente');
            $codigoClie               = $_POST['idCliente'];
            $estados                  = $this->cliente->listaEstados();
            $generos                  = $this->cliente->listaGeneros();
            $ciudades                 = $this->cliente->listaCiudades();
            $cliente                  = $this->cliente->selModiCliente($codigoClie);
            $id_cliente               = $cliente[0]['id_cliente'];
            $cliente_nombre           = $cliente[0]['cliente_nombre'];
            $cliente_genero_id        = $cliente[0]['cliente_genero_id'];
            $genero                   = $this->cliente->selGenero($cliente_genero_id);
            $cliente_genero           = $genero[0]['genero'];
            $cliente_telefono         = $cliente[0]['cliente_telefono'];
            $cliente_ciudad_id        = $cliente[0]['cliente_ciudad_id'];
            $ciudad                   = $this->cliente->selCiudad($cliente_ciudad_id);
            $cliente_ciudad           = $ciudad[0]['ciudad'];
            $cliente_direccion        = $cliente[0]['cliente_direccion'];
            $cliente_email            = $cliente[0]['cliente_email'];
            $cliente_fecha_nacimiento = $cliente[0]['cliente_fecha_nacimiento'];
            $cliente_estado_id        = $cliente[0]['cliente_estado_id'];
            $estado                   = $this->cliente->selEstado($cliente_estado_id);
            $cliente_estado           = $estado[0]['estado'];
            $imprOpci                 = "";
            $imprCiudad               = "";
            $cargaForma = "<div class='row'>
                     <!-- page header -->
                    <div class='col-lg-12'>
                        <h1 class='page-header'>Modificar Cliente</h1>
                    </div>
                    <!--end page header -->
                </div>
                <div class='row'>
                    <div class='col-lg-12'>
                        <!-- Form Elements -->
                        <div class='panel panel-default'>
                            <div class='panel-heading'>
                                Modificación de Clientes
                            </div>
                            <div class='panel-body'>
                                <div class='row'>
                                    <div class='col-lg-6'>
                                        <form role='form'>
                                            <div class='form-group'>
                                                <label>Código Cliente</label>
                                                <input id='id-cliente' class='form-control' placeholder='Identificador único del Cliente.' value='$id_cliente' disabled>
                                            </div>

                                            <div class='form-group'>
                                                <label>Género</label>
                                                <select id='cliente-genero' class='form-control'>";

            foreach ($generos as $keyGenero=>$genero){
                //Se acumula el html para las opciones
                if($cliente_genero == $generos[$keyGenero]){
                    $imprOpci.="<option selected>".$cliente_genero."</option>";
                }
                else{
                    $imprOpci.="<option>".$generos[$keyGenero]."</option>";
                }
            }
            $cargaForma.=$imprOpci;
            $imprOpci   = '';
            $cargaForma.="</select>
                                            </div>
                                            <div class='form-group'>
                                                <label>Ciudad</label>
                                                <select id='cliente-ciudad' class='form-control'>";
            foreach ($ciudades as $keyCiudad=>$ciudad){
                //Se acumula el html para las opciones
                if($cliente_ciudad == $ciudades[$keyCiudad]){
                    $imprCiudad.="<option selected>".$cliente_ciudad."</option>";
                }
                else{
                    $imprCiudad.="<option>".$ciudades[$keyCiudad]."</option>";
                }
            }
            $cargaForma.=$imprCiudad;
            $cargaForma.="</select>
                                            </div>
                                            <div class='form-group'>
                                                <label>Email</label>
                                                <input id='cliente-email' class='form-control' placeholder='correo@mail.com' value='$cliente_email'>
                                            </div>

                                            <div class='form-group'>
                                                <label>Estados</label>
                                                <select id='cliente-estado' class='form-control'>";

            foreach ($estados as $keyEstado=>$estado){
                //Se acumula el html para las opciones
                if($cliente_estado == $estados[$keyEstado]){
                    $imprOpci.="<option selected>".$estados[$keyEstado]."</option>";
                }
                else{
                    $imprOpci.="<option>".$estados[$keyEstado]."</option>";
                }
            }
            $cargaForma.=$imprOpci;
            $imprOpci   = '';
            $cargaForma.="</select>
                                            </div>

                                            <button id='btn-guardar' href='#' onclick=\"actualizaCliente('$this->urlBase')\" type='submit' class='btn btn-primary'>Guardar</button>
                                            <button type='reset' class='btn btn-success'>Cancelar</button>
                                        </form>
                                    </div>
                                    <div class='col-lg-6'>
                                        <form role='form'>
                                            <div class='form-group'>
                                                <label>Nombres y Apellidos</label>
                                                <input id='cliente-nombre' class='form-control' placeholder='Descripción del Cliente.' value='$cliente_nombre'>
                                            </div>

                                            <div class='form-group'>
                                                <label>Teléfono</label>
                                                <input id='cliente-telefono' class='form-control' value='$cliente_telefono'>
                                            </div>

                                            <div class='form-group'>
                                                <label>Dirección</label>
                                                <input id='cliente-direccion' class='form-control' value='$cliente_direccion'>
                                            </div>

                                            <div class='form-group'>
                                                <label>Fecha de Nacimiento</label>
                                                <input id='cliente-fechanacimiento' type='date' data-format='dd-MM-yyyy' class='form-control' placeholder='dd-mm-yyyy' value='$cliente_fecha_nacimiento'>
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
    
    
    //Carga el formulario de consulta de los clientes.
    function consultarCliente(){
        if($this->session->userdata('logged_in')){
            $valorClie = "";
            $this->load->model('cliente');
            $clientes    = $this->cliente->consCliente($valorClie);
            $imprCliente = "";
                $cargaForma  = "<div class='row' onload='consultaCliente('$this->urlBase')'>
                        <!-- Page Header -->
                        <div class='col-lg-12'>
                            <h1 class='page-header'>Consultar Cliente</h1>
                        </div>
                        <!--End Page Header -->
                    </div>
                    <div class='row'>
                        <div class='col-lg-12'>
                            <!-- Advanced Tables -->
                            <div class='panel panel-default'>
                                <div class='panel-heading'>
                                     Consulta de Clientes
                                </div>
                                <div class='panel-body'>
                                    <div class='table-responsive'>
                                        <div id='dataTables-example_wrapper' class='dataTables_wrapper form-inline' role='grid'>
                                            <div class='row'>
                                                <div class='col-sm-6'>
                                                    <!-- search section-->
                                                    <div id='dataTables-example_filter' class='dataTables_filter'>
                                                        <span class='input-group-btn'>
                                                            <input type='search' id='cliente-valor' class='form-control input-sm' aria-controls='dataTables-example' placeholder='Buscar'>
                                                            <button id='busca-cliente' class='btn btn-default' onclick=\"consultaCliente('$this->urlBase')\" type='submit'><i class='fa fa-search'></i></button>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div id='clientes' class='row'>
                                                <div class='form-group'>
                                                    <div id='lista'>
                                                        <table class='table table-bordered'width='100%'  border='0' cellspacing='0' cellpadding='0' style='font-size:10px'>
                                                            <thead>
                                                                <tr>
                                                                    <th>Código</th>
                                                                    <th>Nombres y Apellidos</th>
                                                                    <th>Género</th>
                                                                    <th>Teléfono</th>
                                                                    <th>Ciudad</th>
                                                                    <th>Dirección</th>
                                                                    <th>Email</th>
                                                                    <th>Fecha Nacimiento</th>
                                                                    <th>Total Ventas</th>
                                                                    <th>Valor Acumulado Ventas</th>
                                                                    <th>Fecha Registro</th>
                                                                    <th>Persona Registra</th>
                                                                    <th>Estado</th>
                                                                </tr>
                                                            </thead>";
            if($clientes != false){
                $imprCliente = "";
                $cargaForma.= "<tbody>";
                                                            $posiinic = 0;                                                
                                                            foreach ($clientes as $keyCliente=>$cliente){
                                                                    //Se acumula el html para los clientes
                                                                    $idCliente = substr($clientes[$keyCliente],$posiinic,strpos($clientes[$keyCliente],'|',$posiinic) - $posiinic);
                                                                    $posiinic = strpos($clientes[$keyCliente],'|',$posiinic) + 1;

                                                                    $clienteNombre = substr($clientes[$keyCliente],$posiinic,strpos($clientes[$keyCliente],'|',$posiinic) - $posiinic);
                                                                    $posiinic = strpos($clientes[$keyCliente],'|',$posiinic) + 1;

                                                                    $clienteGenero = substr($clientes[$keyCliente],$posiinic,strpos($clientes[$keyCliente],'|',$posiinic) - $posiinic);
                                                                    $descGenero = $this->cliente->descGenero($clienteGenero);
                                                                    $descGenero = $descGenero[0]['genero_descripcion'];
                                                                    $posiinic = strpos($clientes[$keyCliente],'|',$posiinic) + 1;

                                                                    $clienteTelefono = substr($clientes[$keyCliente],$posiinic,strpos($clientes[$keyCliente],'|',$posiinic) - $posiinic);
                                                                    $posiinic = strpos($clientes[$keyCliente],'|',$posiinic) + 1;

                                                                    $clienteCiudad = substr($clientes[$keyCliente],$posiinic,strpos($clientes[$keyCliente],'|',$posiinic) - $posiinic);
                                                                    $descCiudad = $this->cliente->descCiudad($clienteCiudad);
                                                                    $descCiudad = $descCiudad[0]['ciudad_nombre'];
                                                                    $posiinic = strpos($clientes[$keyCliente],'|',$posiinic) + 1;

                                                                    $clienteDireccion = substr($clientes[$keyCliente],$posiinic,strpos($clientes[$keyCliente],'|',$posiinic) - $posiinic);
                                                                    $posiinic = strpos($clientes[$keyCliente],'|',$posiinic) + 1;

                                                                    $clienteEmail = substr($clientes[$keyCliente],$posiinic,strpos($clientes[$keyCliente],'|',$posiinic) - $posiinic);
                                                                    $posiinic = strpos($clientes[$keyCliente],'|',$posiinic) + 1;

                                                                    $clienteFechaNaci = substr($clientes[$keyCliente],$posiinic,strpos($clientes[$keyCliente],'|',$posiinic) - $posiinic);
                                                                    $posiinic = strpos($clientes[$keyCliente],'|',$posiinic) + 1;

                                                                    $clienteVentas = substr($clientes[$keyCliente],$posiinic,strpos($clientes[$keyCliente],'|',$posiinic) - $posiinic);
                                                                    $posiinic = strpos($clientes[$keyCliente],'|',$posiinic) + 1;

                                                                    $clienteCostAcum = substr($clientes[$keyCliente],$posiinic,strpos($clientes[$keyCliente],'|',$posiinic) - $posiinic);
                                                                    $posiinic = strpos($clientes[$keyCliente],'|',$posiinic) + 1;
                                                                    
                                                                    $clienteFechaRegi = substr($clientes[$keyCliente],$posiinic,strpos($clientes[$keyCliente],'|',$posiinic) - $posiinic);
                                                                    $posiinic = strpos($clientes[$keyCliente],'|',$posiinic) + 1;

                                                                    $clientePersona = substr($clientes[$keyCliente],$posiinic,strpos($clientes[$keyCliente],'|',$posiinic) - $posiinic);
                                                                    $descPersona= $this->cliente->descPersona($clientePersona);
                                                                    $descPersona = $descPersona[0]['persona_nombre'];
                                                                    $posiinic = strpos($clientes[$keyCliente],'|',$posiinic) + 1;

                                                                    $clienteEstado = substr($clientes[$keyCliente],$posiinic,strpos($clientes[$keyCliente],'|',$posiinic) - $posiinic);
                                                                    $descEstado = $this->cliente->descEstado($clienteEstado);
                                                                    $descEstado = $descEstado[0]['estado_descripcion'];
                                                                    $posiinic = strpos($clientes[$keyCliente],'|',$posiinic) + 1;

                                                                    $imprCliente.="<tr>";
                                                                    $imprCliente.="<td>".$idCliente."</td>";
                                                                    $imprCliente.="<td>".$clienteNombre."</td>";
                                                                    $imprCliente.="<td>".$descGenero."</td>";
                                                                    $imprCliente.="<td>".$clienteTelefono."</td>";
                                                                    $imprCliente.="<td>".$descCiudad."</td>";
                                                                    $imprCliente.="<td>".$clienteDireccion."</td>";
                                                                    $imprCliente.="<td>".$clienteEmail."</td>";
                                                                    $imprCliente.="<td>".$clienteFechaNaci."</td>";
                                                                    $imprCliente.="<td>".$clienteVentas."</td>";
                                                                    $imprCliente.="<td>".$clienteCostAcum."</td>";
                                                                    $imprCliente.="<td>".$clienteFechaRegi."</td>";
                                                                    $imprCliente.="<td>".$descPersona."</td>";
                                                                    $imprCliente.="<td>".$descEstado."</td>";
                                                                    $imprCliente.="<td><button id='btn-modificar' href='#' onclick=\"modificaCliente('$this->urlBase','$idCliente')\" type='submit' class='btn btn-default btn-circle'><i class='fa fa-pencil'></i></button></td>";
                                                                    $imprCliente.="<td><button id='btn-eliminar' href='#' onclick=\"borraCliente('$this->urlBase','$idCliente')\" type='submit' class='btn btn-danger btn-circle'><i class='fa fa-times'></i></button></td>";
                                                                    $imprCliente.="</tr>";
                                                                    $posiinic = 0;
                                                                }
                                                                $cargaForma.=$imprCliente;
                                                                $imprCliente   = '';
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
    function eliminarCliente(){
        if($this->session->userdata('logged_in')){
            $this->load->model('cliente');
            $codigoClie = $_POST['idCliente'];
            $clientes  = $this->cliente->borCliente($codigoClie);
            $cargaForma  = "<div class='form-group'>
                                                    <div id='lista'>
                                                        <table class='table table-bordered'width='100%'  border='0' cellspacing='0' cellpadding='0' style='font-size:10px'>
                                                            <thead>
                                                                <tr>
                                                                    <th>Código</th>
                                                                    <th>Nombres y Apellidos</th>
                                                                    <th>Género</th>
                                                                    <th>Teléfono</th>
                                                                    <th>Ciudad</th>
                                                                    <th>Dirección</th>
                                                                    <th>Email</th>
                                                                    <th>Fecha Nacimiento</th>
                                                                    <th>Total Ventas</th>
                                                                    <th>Valor Acumulado Ventas</th>
                                                                    <th>Fecha Registro</th>
                                                                    <th>Persona Registra</th>
                                                                    <th>Estado</th>
                                                                </tr>
                                                            </thead>";
            if($clientes != false){
                $imprCliente = "";
                $cargaForma.= "<tbody>";
                                                            $posiinic = 0;                                                
                                                            foreach ($clientes as $keyCliente=>$cliente){
                                                                    //Se acumula el html para los clientes
                                                                    $idCliente = substr($clientes[$keyCliente],$posiinic,strpos($clientes[$keyCliente],'|',$posiinic) - $posiinic);
                                                                    $posiinic = strpos($clientes[$keyCliente],'|',$posiinic) + 1;

                                                                    $clienteNombre = substr($clientes[$keyCliente],$posiinic,strpos($clientes[$keyCliente],'|',$posiinic) - $posiinic);
                                                                    $posiinic = strpos($clientes[$keyCliente],'|',$posiinic) + 1;

                                                                    $clienteGenero = substr($clientes[$keyCliente],$posiinic,strpos($clientes[$keyCliente],'|',$posiinic) - $posiinic);
                                                                    $descGenero = $this->cliente->descGenero($clienteGenero);
                                                                    $descGenero = $descGenero[0]['genero_descripcion'];
                                                                    $posiinic = strpos($clientes[$keyCliente],'|',$posiinic) + 1;

                                                                    $clienteTelefono = substr($clientes[$keyCliente],$posiinic,strpos($clientes[$keyCliente],'|',$posiinic) - $posiinic);
                                                                    $posiinic = strpos($clientes[$keyCliente],'|',$posiinic) + 1;

                                                                    $clienteCiudad = substr($clientes[$keyCliente],$posiinic,strpos($clientes[$keyCliente],'|',$posiinic) - $posiinic);
                                                                    $descCiudad = $this->cliente->descCiudad($clienteCiudad);
                                                                    $descCiudad = $descCiudad[0]['ciudad_nombre'];
                                                                    $posiinic = strpos($clientes[$keyCliente],'|',$posiinic) + 1;

                                                                    $clienteDireccion = substr($clientes[$keyCliente],$posiinic,strpos($clientes[$keyCliente],'|',$posiinic) - $posiinic);
                                                                    $posiinic = strpos($clientes[$keyCliente],'|',$posiinic) + 1;

                                                                    $clienteEmail = substr($clientes[$keyCliente],$posiinic,strpos($clientes[$keyCliente],'|',$posiinic) - $posiinic);
                                                                    $posiinic = strpos($clientes[$keyCliente],'|',$posiinic) + 1;

                                                                    $clienteFechaNaci = substr($clientes[$keyCliente],$posiinic,strpos($clientes[$keyCliente],'|',$posiinic) - $posiinic);
                                                                    $posiinic = strpos($clientes[$keyCliente],'|',$posiinic) + 1;

                                                                    $clienteVentas = substr($clientes[$keyCliente],$posiinic,strpos($clientes[$keyCliente],'|',$posiinic) - $posiinic);
                                                                    $posiinic = strpos($clientes[$keyCliente],'|',$posiinic) + 1;

                                                                    $clienteCostAcum = substr($clientes[$keyCliente],$posiinic,strpos($clientes[$keyCliente],'|',$posiinic) - $posiinic);
                                                                    $posiinic = strpos($clientes[$keyCliente],'|',$posiinic) + 1;
                                                                    
                                                                    $clienteFechaRegi = substr($clientes[$keyCliente],$posiinic,strpos($clientes[$keyCliente],'|',$posiinic) - $posiinic);
                                                                    $posiinic = strpos($clientes[$keyCliente],'|',$posiinic) + 1;

                                                                    $clientePersona = substr($clientes[$keyCliente],$posiinic,strpos($clientes[$keyCliente],'|',$posiinic) - $posiinic);
                                                                    $descPersona= $this->cliente->descPersona($clientePersona);
                                                                    $descPersona = $descPersona[0]['persona_nombre'];
                                                                    $posiinic = strpos($clientes[$keyCliente],'|',$posiinic) + 1;

                                                                    $clienteEstado = substr($clientes[$keyCliente],$posiinic,strpos($clientes[$keyCliente],'|',$posiinic) - $posiinic);
                                                                    $descEstado = $this->cliente->descEstado($clienteEstado);
                                                                    $descEstado = $descEstado[0]['estado_descripcion'];
                                                                    $posiinic = strpos($clientes[$keyCliente],'|',$posiinic) + 1;

                                                                    $imprCliente.="<tr>";
                                                                    $imprCliente.="<td>".$idCliente."</td>";
                                                                    $imprCliente.="<td>".$clienteNombre."</td>";
                                                                    $imprCliente.="<td>".$descGenero."</td>";
                                                                    $imprCliente.="<td>".$clienteTelefono."</td>";
                                                                    $imprCliente.="<td>".$descCiudad."</td>";
                                                                    $imprCliente.="<td>".$clienteDireccion."</td>";
                                                                    $imprCliente.="<td>".$clienteEmail."</td>";
                                                                    $imprCliente.="<td>".$clienteFechaNaci."</td>";
                                                                    $imprCliente.="<td>".$clienteVentas."</td>";
                                                                    $imprCliente.="<td>".$clienteCostAcum."</td>";
                                                                    $imprCliente.="<td>".$clienteFechaRegi."</td>";
                                                                    $imprCliente.="<td>".$descPersona."</td>";
                                                                    $imprCliente.="<td>".$descEstado."</td>";
                                                                    $imprCliente.="<td><button id='btn-modificar' href='#' onclick=\"modificaCliente('$this->urlBase','$idCliente')\" type='submit' class='btn btn-default btn-circle'><i class='fa fa-pencil'></i></button></td>";
                                                                    $imprCliente.="<td><button id='btn-eliminar' href='#' onclick=\"borraCliente('$this->urlBase','$idCliente')\" type='submit' class='btn btn-danger btn-circle'><i class='fa fa-times'></i></button></td>";
                                                                    $imprCliente.="</tr>";
                                                                    $posiinic = 0;
                                                                }
                                                                $cargaForma.=$imprCliente;
                                                                $imprCliente   = '';
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
    
    
    //Invoca el modelo de almacenamiento del cliente en la base de datos.
    function guardarCliente(){
        if($this->session->userdata('logged_in')){
            $this->load->model('cliente');
            $codigoClie      = $_POST['idClie'];
            $nombreClie      = $_POST['nombreClie'];
            $generoClie      = $_POST['genero'];
            $generoCodi      = substr($generoClie,0,strpos($generoClie,'-',0) - 1);
            $telefonoClie    = $_POST['telefonoClie'];
            $ciudadClie      = $_POST['ciudadClie'];
            $ciudadCodi      = substr($ciudadClie,0,strpos($ciudadClie,'-',0) - 1);
            $direccionClie   = $_POST['direccionClie'];
            $emailClie       = $_POST['emailClie'];
            $estadoClie      = $_POST['estadoClie'];
            $estadoCodi      = substr($estadoClie,0,strpos($estadoClie,'-',0) - 1);
            $fechaNaci       = $_POST['fechaNaci'];
            $personaClie     = $this->session->userdata('idPers');
            $cliente         = $this->cliente->insCliente($codigoClie,$nombreClie,$generoCodi,$telefonoClie,$ciudadCodi,
                                                          $direccionClie,$emailClie,$estadoCodi,$fechaNaci,$personaClie);
            if(isset($cliente)){
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
    
    
    //Valida si un cliente ya existe.
    function obtenerCliente(){
        if($this->session->userdata('logged_in')){
            $this->load->model('cliente');
            $codigoClie = $_POST['idClie'];
            $cliente    = $this->cliente->selCliente($codigoClie);
            echo($cliente);
        }
        else{
            echo('No se ha logueado');
            redirect('contenedor');
        }
    }
    
    
    //Recarga el formulario de consulta de los clientes a partir del criterio de búsqueda dado.
    function seleccionarCliente(){
        if($this->session->userdata('logged_in')){
            $this->load->model('cliente');
            $valorClie = $_POST['cliente_valor'];
            $clientes  = $this->cliente->consCliente($valorClie);
            $imprCliente = "";
            $cargaForma  = "<div class='form-group'>
                                                    <div id='lista'>
                                                        <table class='table table-bordered'width='100%'  border='0' cellspacing='0' cellpadding='0' style='font-size:10px'>
                                                            <thead>
                                                                <tr>
                                                                    <th>Código</th>
                                                                    <th>Nombres y Apellidos</th>
                                                                    <th>Género</th>
                                                                    <th>Teléfono</th>
                                                                    <th>Ciudad</th>
                                                                    <th>Dirección</th>
                                                                    <th>Email</th>
                                                                    <th>Fecha Nacimiento</th>
                                                                    <th>Total Ventas</th>
                                                                    <th>Valor Acumulado Ventas</th>
                                                                    <th>Fecha Registro</th>
                                                                    <th>Persona Registra</th>
                                                                    <th>Estado</th>
                                                                </tr>
                                                            </thead>";
            if($clientes != false){
                $imprCliente = "";
                $cargaForma.= "<tbody>";
                $posiinic = 0;                                                
                foreach ($clientes as $keyCliente=>$cliente){
                        //Se acumula el html para los clientes
                        $idCliente = substr($clientes[$keyCliente],$posiinic,strpos($clientes[$keyCliente],'|',$posiinic) - $posiinic);
                        $posiinic = strpos($clientes[$keyCliente],'|',$posiinic) + 1;

                        $clienteNombre = substr($clientes[$keyCliente],$posiinic,strpos($clientes[$keyCliente],'|',$posiinic) - $posiinic);
                        $posiinic = strpos($clientes[$keyCliente],'|',$posiinic) + 1;

                        $clienteGenero = substr($clientes[$keyCliente],$posiinic,strpos($clientes[$keyCliente],'|',$posiinic) - $posiinic);
                        $descGenero = $this->cliente->descGenero($clienteGenero);
                        $descGenero = $descGenero[0]['genero_descripcion'];
                        $posiinic = strpos($clientes[$keyCliente],'|',$posiinic) + 1;

                        $clienteTelefono = substr($clientes[$keyCliente],$posiinic,strpos($clientes[$keyCliente],'|',$posiinic) - $posiinic);
                        $posiinic = strpos($clientes[$keyCliente],'|',$posiinic) + 1;

                        $clienteCiudad = substr($clientes[$keyCliente],$posiinic,strpos($clientes[$keyCliente],'|',$posiinic) - $posiinic);
                        $descCiudad = $this->cliente->descCiudad($clienteCiudad);
                        $descCiudad = $descCiudad[0]['ciudad_nombre'];
                        $posiinic = strpos($clientes[$keyCliente],'|',$posiinic) + 1;

                        $clienteDireccion = substr($clientes[$keyCliente],$posiinic,strpos($clientes[$keyCliente],'|',$posiinic) - $posiinic);
                        $posiinic = strpos($clientes[$keyCliente],'|',$posiinic) + 1;

                        $clienteEmail = substr($clientes[$keyCliente],$posiinic,strpos($clientes[$keyCliente],'|',$posiinic) - $posiinic);
                        $posiinic = strpos($clientes[$keyCliente],'|',$posiinic) + 1;

                        $clienteFechaNaci = substr($clientes[$keyCliente],$posiinic,strpos($clientes[$keyCliente],'|',$posiinic) - $posiinic);
                        $posiinic = strpos($clientes[$keyCliente],'|',$posiinic) + 1;
                        
                        $clienteVentas = substr($clientes[$keyCliente],$posiinic,strpos($clientes[$keyCliente],'|',$posiinic) - $posiinic);
                        $posiinic = strpos($clientes[$keyCliente],'|',$posiinic) + 1;

                        $clienteCostAcum = substr($clientes[$keyCliente],$posiinic,strpos($clientes[$keyCliente],'|',$posiinic) - $posiinic);
                        $posiinic = strpos($clientes[$keyCliente],'|',$posiinic) + 1;

                        $clienteFechaRegi = substr($clientes[$keyCliente],$posiinic,strpos($clientes[$keyCliente],'|',$posiinic) - $posiinic);
                        $posiinic = strpos($clientes[$keyCliente],'|',$posiinic) + 1;

                        $clientePersona = substr($clientes[$keyCliente],$posiinic,strpos($clientes[$keyCliente],'|',$posiinic) - $posiinic);
                        $descPersona= $this->cliente->descPersona($clientePersona);
                        $descPersona = $descPersona[0]['persona_nombre'];
                        $posiinic = strpos($clientes[$keyCliente],'|',$posiinic) + 1;

                        $clienteEstado = substr($clientes[$keyCliente],$posiinic,strpos($clientes[$keyCliente],'|',$posiinic) - $posiinic);
                        $descEstado = $this->cliente->descEstado($clienteEstado);
                        $descEstado = $descEstado[0]['estado_descripcion'];
                        $posiinic = strpos($clientes[$keyCliente],'|',$posiinic) + 1;

                        $imprCliente.="<tr>";
                        $imprCliente.="<td>".$idCliente."</td>";
                        $imprCliente.="<td>".$clienteNombre."</td>";
                        $imprCliente.="<td>".$descGenero."</td>";
                        $imprCliente.="<td>".$clienteTelefono."</td>";
                        $imprCliente.="<td>".$descCiudad."</td>";
                        $imprCliente.="<td>".$clienteDireccion."</td>";
                        $imprCliente.="<td>".$clienteEmail."</td>";
                        $imprCliente.="<td>".$clienteFechaNaci."</td>";
                        $imprCliente.="<td>".$clienteVentas."</td>";
                        $imprCliente.="<td>".$clienteCostAcum."</td>";
                        $imprCliente.="<td>".$clienteFechaRegi."</td>";
                        $imprCliente.="<td>".$descPersona."</td>";
                        $imprCliente.="<td>".$descEstado."</td>";
                        $imprCliente.="<td><button id='btn-modificar' href='#' onclick=\"modificaCliente('$this->urlBase','$idCliente')\" type='submit' class='btn btn-default btn-circle'><i class='fa fa-pencil'></i></button></td>";
                        $imprCliente.="<td><button id='btn-eliminar' href='#' onclick=\"borraCliente('$this->urlBase','$idCliente')\" type='submit' class='btn btn-danger btn-circle'><i class='fa fa-times'></i></button></td>";
                        $imprCliente.="</tr>";
                        $posiinic = 0;
                    }
                    $cargaForma.=$imprCliente;
                    $imprCliente   = '';
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
    function actualizarCliente(){
        if($this->session->userdata('logged_in')){
            $this->load->model('cliente');
            $codigoClie      = $_POST['idClie'];
            $nombreClie      = $_POST['nombreClie'];
            $generoClie      = $_POST['genero'];
            $generoCodi      = substr($generoClie,0,strpos($generoClie,'-',0) - 1);
            $telefonoClie    = $_POST['telefonoClie'];
            $ciudadClie      = $_POST['ciudadClie'];
            $ciudadCodi      = substr($ciudadClie,0,strpos($ciudadClie,'-',0) - 1);
            $direccionClie   = $_POST['direccionClie'];
            $emailClie       = $_POST['emailClie'];
            $estadoClie      = $_POST['estadoClie'];
            $estadoCodi      = substr($estadoClie,0,strpos($estadoClie,'-',0) - 1);
            $fechaNaci       = $_POST['fechaNaci'];
            $personaClie     = $this->session->userdata('idPers');
            $cliente         = $this->cliente->updCliente($codigoClie,$nombreClie,$generoCodi,$telefonoClie,$ciudadCodi,
                                                          $direccionClie,$emailClie,$estadoCodi,$fechaNaci,$personaClie);
            if(isset($cliente)){
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
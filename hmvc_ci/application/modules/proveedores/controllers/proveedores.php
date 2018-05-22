<?php if (! defined('BASEPATH')) exit('No direct script access allowed');
 
class Proveedores extends MX_Controller {
    
    function __construct(){
        parent::__construct();
        $this->urlBase = base_url();
    }
 
    function index(){
        echo("proveedores.index");
    }
	
    function crearProveedor(){
        //Se cargan los Estados desde el modelo Proveedor
        $this->load->model('proveedor');
        $estados = $this->proveedor->listaEstados();
        $imprOpci ="";
        $cargaForma = "<div class='row'>
                 <!-- page header -->
                <div class='col-lg-12'>
                    <h1 class='page-header'>Crear Proveedor</h1>
                </div>
                <!--end page header -->
            </div>
            <div class='row'>
                <div class='col-lg-12'>
                    <!-- Form Elements -->
                    <div class='panel panel-default'>
                        <div class='panel-heading'>
                            Registro de Proveedores
                        </div>
                        <div class='panel-body'>
                            <div class='row'>
                                <div class='col-lg-6'>
                                    <form role='form'>
                                        <div class='form-group'>
                                            <label>Código Proveedor</label>
                                            <input id='id-proveedor' class='form-control' placeholder='Identificador único del Proveedor.'>
                                        </div>
                                        
                                        <div class='form-group'>
                                            <label>Dirección</label>
                                            <input id='proveedor-direccion' class='form-control'>
                                        </div>
                                        
                                        <div class='form-group'>
                                            <label>Estado</label>
                                            <select id='proveedor-estado-id' class='form-control'>";
        
        foreach ($estados as $keyEstado=>$estado){
            //Se acumula el html para las opciones
            $imprOpci.="<option>".$estados[$keyEstado]."</option>"
                       . "";
        }
        $cargaForma.=$imprOpci;
        $cargaForma.="</select>
                                        </div>
                                        <button id='btn-guardar' href='#' onclick=\"insertaProveedor('$this->urlBase')\" type='submit' class='btn btn-primary'>Guardar</button>
                                        <button id='btn-cancelar' type='reset' class='btn btn-success'>Cancelar</button>
                                    </form>
                                </div>
                                <div class='col-lg-6'>
                                    <form role='form'>
                                        <div class='form-group'>
                                            <label>Nombre Proveedor</label>
                                            <input id='proveedor-nombre' class='form-control' placeholder='Descripción del Proveedor.'>
                                        </div>
                                        
                                        <div class='form-group'>
                                            <label>Teléfono</label>
                                            <input id='proveedor-telefono' class='form-control'>
                                        </div>
                                        
                                        <div class='form-group'>
                                            <label>Email</label>
                                            <input id='proveedor-email' class='form-control' placeholder='correo@mail.com'>
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
    
    function modificarProveedor(){
        if($this->session->userdata('logged_in')){
            $this->load->model('proveedor');
            $codigoProv                 = $_POST['idProveedor'];
            $estados                    = $this->proveedor->listaEstados();
            $proveedor                  = $this->proveedor->selModiProveedor($codigoProv);
            $id_proveedor               = $proveedor[0]['id_proveedor'];
            $proveedor_nombre           = $proveedor[0]['proveedor_nombre'];
            $proveedor_direccion        = $proveedor[0]['proveedor_direccion'];
            $proveedor_telefono         = $proveedor[0]['proveedor_telefono'];
            $proveedor_email            = $proveedor[0]['proveedor_email'];
            $proveedor_estado_id        = $proveedor[0]['proveedor_estado_id'];
            $proveedor_frecuencia       = $proveedor[0]['proveedor_frecuencia'];
            $proveedor_costacum_compras = $proveedor[0]['proveedor_costacum_compras'];
            $estado                   = $this->proveedor->selEstado($proveedor_estado_id);
            $proveedor_estado           = $estado[0]['estado'];
            $imprOpci                 = "";
            $imprCiudad               = "";
            $cargaForma = "<div class='row'>
                 <!-- page header -->
                <div class='col-lg-12'>
                    <h1 class='page-header'>Modificar Proveedor</h1>
                </div>
                <!--end page header -->
            </div>
            <div class='row'>
                <div class='col-lg-12'>
                    <!-- Form Elements -->
                    <div class='panel panel-default'>
                        <div class='panel-heading'>
                            Modificación de Proveedores
                        </div>
                        <div class='panel-body'>
                            <div class='row'>
                                <div class='col-lg-6'>
                                    <form role='form'>
                                        <div class='form-group'>
                                            <label>Código Proveedor</label>
                                            <input id='id-proveedor' class='form-control' placeholder='Identificador único del Proveedor.' value='$id_proveedor' disabled>
                                        </div>
                                        
                                        <div class='form-group'>
                                            <label>Dirección</label>
                                            <input id='proveedor-direccion' class='form-control' value ='$proveedor_direccion'>
                                        </div>
                                        
                                        <div class='form-group'>
                                            <label>Email</label>
                                            <input id='proveedor-email' class='form-control' placeholder='correo@mail.com' value = '$proveedor_email'>
                                        </div>
                                        
                                        <div class='form-group'>
                                            <label>Valor Acumulado Compras</label>
                                            <input id='proveedor-costacum-compras' class='form-control' value ='$proveedor_costacum_compras' disabled>
                                        </div>
                                        
                                        <button id='btn-guardar' href='#' onclick=\"actualizaProveedor('$this->urlBase')\" type='submit' class='btn btn-primary'>Guardar</button>
                                        <button id='btn-cancelar' type='reset' class='btn btn-success'>Cancelar</button>
                                    </form>
                                </div>
                                <div class='col-lg-6'>
                                    <form role='form'>
                                        <div class='form-group'>
                                            <label>Nombre Proveedor</label>
                                            <input id='proveedor-nombre' class='form-control' placeholder='Descripción del Proveedor.' value='$proveedor_nombre'>
                                        </div>
                                        
                                        <div class='form-group'>
                                            <label>Teléfono</label>
                                            <input id='proveedor-telefono' class='form-control' value ='$proveedor_telefono'>
                                        </div>
                                        
                                        <div class='form-group'>
                                            <label>Frecuencia</label>
                                            <input id='proveedor-frecuencia' class='form-control' value ='$proveedor_frecuencia' disabled>
                                        </div>
                                        
                                        <div class='form-group'>
                                            <label>Estado</label>
                                            <select id='proveedor-estado-id' class='form-control' value = '$proveedor_estado'>";
        
        foreach ($estados as $keyEstado=>$estado){
            //Se acumula el html para las opciones
            if($proveedor_estado == $estados[$keyEstado]){
                $imprOpci.="<option selected>".$estados[$keyEstado]."</option>";
            }
            else{
                $imprOpci.="<option>".$estados[$keyEstado]."</option>";
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
    
    
    //Carga el formulario de consulta de los proveedores.
    function consultarProveedor(){
        if($this->session->userdata('logged_in')){
            $valorProv = "";
            $this->load->model('proveedor');
            $proveedores = $this->proveedor->consProveedor($valorProv);
            $imprProveedor = "";
            $cargaForma  = "<div class='row' onload='consultaProveedor('$this->urlBase')'>
                        <!-- Page Header -->
                        <div class='col-lg-12'>
                            <h1 class='page-header'>Consultar Proveedor</h1>
                        </div>
                        <!--End Page Header -->
                    </div>
                    <div class='row'>
                        <div class='col-lg-12'>
                            <!-- Advanced Tables -->
                            <div class='panel panel-default'>
                                <div class='panel-heading'>
                                     Consulta de Proveedores
                                </div>
                                <div class='panel-body'>
                                    <div class='table-responsive'>
                                        <div id='dataTables-example_wrapper' class='dataTables_wrapper form-inline' role='grid'>
                                            <div class='row'>
                                                <div class='col-sm-6'>
                                                    <!-- search section-->
                                                    <div id='dataTables-example_filter' class='dataTables_filter'>
                                                        <span class='input-group-btn'>
                                                            <input type='search' id='proveedor-valor' class='form-control input-sm' aria-controls='dataTables-example' placeholder='Buscar'>
                                                            <button id='busca-proveedor' class='btn btn-default' onclick=\"consultaProveedor('$this->urlBase')\" type='submit'><i class='fa fa-search'></i></button>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div id='proveedores' class='row'>
                                                <div class='form-group'>
                                                    <div id='lista'>
                                                        <table class='table table-bordered'width='100%'  border='0' cellspacing='0' cellpadding='0' style='font-size:10px'>
                                                            <thead>
                                                                <tr>
                                                                    <th>Código</th>
                                                                    <th>Nombre</th>
                                                                    <th>Teléfono</th>
                                                                    <th>Dirección</th>
                                                                    <th>Email</th>
                                                                    <th>Total Compras</th>
                                                                    <th>Valor Acumulado Compras</th>
                                                                    <th>Fecha Registro</th>
                                                                    <th>Persona Registra</th>
                                                                    <th>Estado</th>
                                                                </tr>
                                                            </thead>";
            if($proveedores != false){
                $imprProveedor = "";
                $cargaForma.= "<tbody>";
                                                            $posiinic = 0;                                                
                                                            foreach ($proveedores as $keyProveedor=>$proveedor){
                                                                    //Se acumula el html para los proveedores
                                                                    $idProveedor = substr($proveedores[$keyProveedor],$posiinic,strpos($proveedores[$keyProveedor],'|',$posiinic) - $posiinic);
                                                                    $posiinic = strpos($proveedores[$keyProveedor],'|',$posiinic) + 1;

                                                                    $proveedorNombre = substr($proveedores[$keyProveedor],$posiinic,strpos($proveedores[$keyProveedor],'|',$posiinic) - $posiinic);
                                                                    $posiinic = strpos($proveedores[$keyProveedor],'|',$posiinic) + 1;

                                                                    $proveedorTelefono = substr($proveedores[$keyProveedor],$posiinic,strpos($proveedores[$keyProveedor],'|',$posiinic) - $posiinic);
                                                                    $posiinic = strpos($proveedores[$keyProveedor],'|',$posiinic) + 1;

                                                                    $proveedorDireccion = substr($proveedores[$keyProveedor],$posiinic,strpos($proveedores[$keyProveedor],'|',$posiinic) - $posiinic);
                                                                    $posiinic = strpos($proveedores[$keyProveedor],'|',$posiinic) + 1;

                                                                    $proveedorEmail = substr($proveedores[$keyProveedor],$posiinic,strpos($proveedores[$keyProveedor],'|',$posiinic) - $posiinic);
                                                                    $posiinic = strpos($proveedores[$keyProveedor],'|',$posiinic) + 1;

                                                                    $proveedorFrecuencia = substr($proveedores[$keyProveedor],$posiinic,strpos($proveedores[$keyProveedor],'|',$posiinic) - $posiinic);
                                                                    $posiinic = strpos($proveedores[$keyProveedor],'|',$posiinic) + 1;

                                                                    $proveedorValoCompras = substr($proveedores[$keyProveedor],$posiinic,strpos($proveedores[$keyProveedor],'|',$posiinic) - $posiinic);
                                                                    $posiinic = strpos($proveedores[$keyProveedor],'|',$posiinic) + 1;

                                                                    $proveedorFechaRegi = substr($proveedores[$keyProveedor],$posiinic,strpos($proveedores[$keyProveedor],'|',$posiinic) - $posiinic);
                                                                    $posiinic = strpos($proveedores[$keyProveedor],'|',$posiinic) + 1;

                                                                    $proveedorPersona = substr($proveedores[$keyProveedor],$posiinic,strpos($proveedores[$keyProveedor],'|',$posiinic) - $posiinic);
                                                                    $descPersona= $this->proveedor->descPersona($proveedorPersona);
                                                                    $descPersona = $descPersona[0]['persona_nombre'];
                                                                    $posiinic = strpos($proveedores[$keyProveedor],'|',$posiinic) + 1;

                                                                    $proveedorEstado = substr($proveedores[$keyProveedor],$posiinic,strpos($proveedores[$keyProveedor],'|',$posiinic) - $posiinic);
                                                                    $descEstado = $this->proveedor->descEstado($proveedorEstado);
                                                                    $descEstado = $descEstado[0]['estado_descripcion'];
                                                                    $posiinic = strpos($proveedores[$keyProveedor],'|',$posiinic) + 1;

                                                                    $imprProveedor.="<tr>";
                                                                    $imprProveedor.="<td>".$idProveedor."</td>";
                                                                    $imprProveedor.="<td>".$proveedorNombre."</td>";
                                                                    $imprProveedor.="<td>".$proveedorTelefono."</td>";
                                                                    $imprProveedor.="<td>".$proveedorDireccion."</td>";
                                                                    $imprProveedor.="<td>".$proveedorEmail."</td>";
                                                                    $imprProveedor.="<td>".$proveedorFrecuencia."</td>";
                                                                    $imprProveedor.="<td>".$proveedorValoCompras."</td>";
                                                                    $imprProveedor.="<td>".$proveedorFechaRegi."</td>";
                                                                    $imprProveedor.="<td>".$descPersona."</td>";
                                                                    $imprProveedor.="<td>".$descEstado."</td>";
                                                                    $imprProveedor.="<td><button id='btn-modificar' href='#' onclick=\"modificaProveedor('$this->urlBase','$idProveedor')\" type='submit' class='btn btn-default btn-circle'><i class='fa fa-pencil'></i></button></td>";
                                                                    $imprProveedor.="<td><button id='btn-eliminar' href='#' onclick=\"borraProveedor('$this->urlBase','$idProveedor')\" type='submit' class='btn btn-danger btn-circle'><i class='fa fa-times'></i></button></td>";
                                                                    $imprProveedor.="</tr>";
                                                                    $posiinic = 0;
                                                                }
                                                                $cargaForma.=$imprProveedor;
                                                                $imprProveedor   = '';
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
    
    
    //Recarga el formulario de consulta de los proveedores una vez eliminado algún proveedor.
    //Recarga el formulario de consulta de los clientes una vez eliminado algún cliente.
    function eliminarProveedor(){
        if($this->session->userdata('logged_in')){
            $this->load->model('proveedor');
            $codigoProv = $_POST['idProveedor'];
            $proveedores  = $this->proveedor->borProveedor($codigoProv);
            $cargaForma  = "<div class='form-group'>
                                                    <div id='lista'>
                                                        <table class='table table-bordered'width='100%'  border='0' cellspacing='0' cellpadding='0' style='font-size:10px'>
                                                            <thead>
                                                                <tr>
                                                                    <th>Código</th>
                                                                    <th>Nombre</th>
                                                                    <th>Teléfono</th>
                                                                    <th>Dirección</th>
                                                                    <th>Email</th>
                                                                    <th>Total Compras</th>
                                                                    <th>Valor Total Compras</th>
                                                                    <th>Fecha Registro</th>
                                                                    <th>Persona Registra</th>
                                                                    <th>Estado</th>
                                                                </tr>
                                                            </thead>";
            if($proveedores != false){
                $imprProveedor = "";
                $cargaForma.= "<tbody>";
                                                            $posiinic = 0;                                                
                                                            foreach ($proveedores as $keyProveedor=>$proveedor){
                                                                    //Se acumula el html para los proveedores
                                                                    $idProveedor = substr($proveedores[$keyProveedor],$posiinic,strpos($proveedores[$keyProveedor],'|',$posiinic) - $posiinic);
                                                                    $posiinic = strpos($proveedores[$keyProveedor],'|',$posiinic) + 1;

                                                                    $proveedorNombre = substr($proveedores[$keyProveedor],$posiinic,strpos($proveedores[$keyProveedor],'|',$posiinic) - $posiinic);
                                                                    $posiinic = strpos($proveedores[$keyProveedor],'|',$posiinic) + 1;

                                                                    $proveedorTelefono = substr($proveedores[$keyProveedor],$posiinic,strpos($proveedores[$keyProveedor],'|',$posiinic) - $posiinic);
                                                                    $posiinic = strpos($proveedores[$keyProveedor],'|',$posiinic) + 1;

                                                                    $proveedorDireccion = substr($proveedores[$keyProveedor],$posiinic,strpos($proveedores[$keyProveedor],'|',$posiinic) - $posiinic);
                                                                    $posiinic = strpos($proveedores[$keyProveedor],'|',$posiinic) + 1;

                                                                    $proveedorEmail = substr($proveedores[$keyProveedor],$posiinic,strpos($proveedores[$keyProveedor],'|',$posiinic) - $posiinic);
                                                                    $posiinic = strpos($proveedores[$keyProveedor],'|',$posiinic) + 1;

                                                                    $proveedorFrecuencia = substr($proveedores[$keyProveedor],$posiinic,strpos($proveedores[$keyProveedor],'|',$posiinic) - $posiinic);
                                                                    $posiinic = strpos($proveedores[$keyProveedor],'|',$posiinic) + 1;

                                                                    $proveedorValoCompras = substr($proveedores[$keyProveedor],$posiinic,strpos($proveedores[$keyProveedor],'|',$posiinic) - $posiinic);
                                                                    $posiinic = strpos($proveedores[$keyProveedor],'|',$posiinic) + 1;

                                                                    $proveedorFechaRegi = substr($proveedores[$keyProveedor],$posiinic,strpos($proveedores[$keyProveedor],'|',$posiinic) - $posiinic);
                                                                    $posiinic = strpos($proveedores[$keyProveedor],'|',$posiinic) + 1;

                                                                    $proveedorPersona = substr($proveedores[$keyProveedor],$posiinic,strpos($proveedores[$keyProveedor],'|',$posiinic) - $posiinic);
                                                                    $descPersona= $this->proveedor->descPersona($proveedorPersona);
                                                                    $descPersona = $descPersona[0]['persona_nombre'];
                                                                    $posiinic = strpos($proveedores[$keyProveedor],'|',$posiinic) + 1;

                                                                    $proveedorEstado = substr($proveedores[$keyProveedor],$posiinic,strpos($proveedores[$keyProveedor],'|',$posiinic) - $posiinic);
                                                                    $descEstado = $this->proveedor->descEstado($proveedorEstado);
                                                                    $descEstado = $descEstado[0]['estado_descripcion'];
                                                                    $posiinic = strpos($proveedores[$keyProveedor],'|',$posiinic) + 1;

                                                                    $imprProveedor.="<tr>";
                                                                    $imprProveedor.="<td>".$idProveedor."</td>";
                                                                    $imprProveedor.="<td>".$proveedorNombre."</td>";
                                                                    $imprProveedor.="<td>".$proveedorTelefono."</td>";
                                                                    $imprProveedor.="<td>".$proveedorDireccion."</td>";
                                                                    $imprProveedor.="<td>".$proveedorEmail."</td>";
                                                                    $imprProveedor.="<td>".$proveedorFrecuencia."</td>";
                                                                    $imprProveedor.="<td>".$proveedorValoCompras."</td>";
                                                                    $imprProveedor.="<td>".$proveedorFechaRegi."</td>";
                                                                    $imprProveedor.="<td>".$descPersona."</td>";
                                                                    $imprProveedor.="<td>".$descEstado."</td>";
                                                                    $imprProveedor.="<td><button id='btn-modificar' href='#' onclick=\"modificaProveedor('$this->urlBase','$idProveedor')\" type='submit' class='btn btn-default btn-circle'><i class='fa fa-pencil'></i></button></td>";
                                                                    $imprProveedor.="<td><button id='btn-eliminar' href='#' onclick=\"borraProveedor('$this->urlBase','$idProveedor')\" type='submit' class='btn btn-danger btn-circle'><i class='fa fa-times'></i></button></td>";
                                                                    $imprProveedor.="</tr>";
                                                                    $posiinic = 0;
                                                                }
                                                                $cargaForma.=$imprProveedor;
                                                                $imprProveedor   = '';
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
    
    //Invoca el modelo de almacenamiento del proveedor en la base de datos.
    function guardarProveedor(){
        $this->load->model('proveedor');
        $codigoProv      = $_POST['idProv'];
        $nombreProv      = $_POST['nombreProv'];
        $telefonoProv    = $_POST['telefonoProv'];
        $direccionProv   = $_POST['direccionProv'];
        $emailProv       = $_POST['emailProv'];
        $estadoProv      = $_POST['estadoProv'];
        $estadoCodi      = substr($estadoProv,0,strpos($estadoProv,'-',0) - 1);
        $personaProv     = $this->session->userdata('idPers');
        $proveedor       = $this->proveedor->insProveedor($codigoProv,$nombreProv,$telefonoProv,$direccionProv,
                                                          $emailProv,$personaProv,$estadoCodi);
        if(isset($proveedor)){
            echo("true");
        }
        else{
            echo("false");
        }
    }
    
    
    //Valida si un proveedor ya existe.
    function obtenerProveedor(){
        $this->load->model('proveedor');
        $codigoProv = $_POST['idProv'];
        $proveedor   = $this->proveedor->selProveedor($codigoProv);
        echo($proveedor);
    }
    
    
    //Recarga el formulario de consulta de los proveedores a partir del criterio de búsqueda dado.
    function seleccionarProveedor(){
        if($this->session->userdata('logged_in')){
            $this->load->model('proveedor');
            $valorClie = $_POST['proveedor_valor'];
            $proveedores  = $this->proveedor->consProveedor($valorClie);
            $imprProveedor = "";
            $cargaForma  = "<div class='form-group'>
                                                    <div id='lista'>
                                                        <table class='table table-bordered'width='100%'  border='0' cellspacing='0' cellpadding='0' style='font-size:10px'>
                                                            <thead>
                                                                <tr>
                                                                    <th>Código</th>
                                                                    <th>Nombre</th>
                                                                    <th>Teléfono</th>
                                                                    <th>Dirección</th>
                                                                    <th>Email</th>
                                                                    <th>Total Compras</th>
                                                                    <th>Valor Acumulado Compras</th>
                                                                    <th>Fecha Registro</th>
                                                                    <th>Persona Registra</th>
                                                                    <th>Estado</th>
                                                                </tr>
                                                            </thead>";
            if($proveedores != false){
                $imprProveedor = "";
                $cargaForma.= "<tbody>";
                                                            $posiinic = 0;                                                
                                                            foreach ($proveedores as $keyProveedor=>$proveedor){
                                                                    //Se acumula el html para los proveedores
                                                                    $idProveedor = substr($proveedores[$keyProveedor],$posiinic,strpos($proveedores[$keyProveedor],'|',$posiinic) - $posiinic);
                                                                    $posiinic = strpos($proveedores[$keyProveedor],'|',$posiinic) + 1;

                                                                    $proveedorNombre = substr($proveedores[$keyProveedor],$posiinic,strpos($proveedores[$keyProveedor],'|',$posiinic) - $posiinic);
                                                                    $posiinic = strpos($proveedores[$keyProveedor],'|',$posiinic) + 1;

                                                                    $proveedorTelefono = substr($proveedores[$keyProveedor],$posiinic,strpos($proveedores[$keyProveedor],'|',$posiinic) - $posiinic);
                                                                    $posiinic = strpos($proveedores[$keyProveedor],'|',$posiinic) + 1;

                                                                    $proveedorDireccion = substr($proveedores[$keyProveedor],$posiinic,strpos($proveedores[$keyProveedor],'|',$posiinic) - $posiinic);
                                                                    $posiinic = strpos($proveedores[$keyProveedor],'|',$posiinic) + 1;

                                                                    $proveedorEmail = substr($proveedores[$keyProveedor],$posiinic,strpos($proveedores[$keyProveedor],'|',$posiinic) - $posiinic);
                                                                    $posiinic = strpos($proveedores[$keyProveedor],'|',$posiinic) + 1;

                                                                    $proveedorFrecuencia = substr($proveedores[$keyProveedor],$posiinic,strpos($proveedores[$keyProveedor],'|',$posiinic) - $posiinic);
                                                                    $posiinic = strpos($proveedores[$keyProveedor],'|',$posiinic) + 1;

                                                                    $proveedorValoCompras = substr($proveedores[$keyProveedor],$posiinic,strpos($proveedores[$keyProveedor],'|',$posiinic) - $posiinic);
                                                                    $posiinic = strpos($proveedores[$keyProveedor],'|',$posiinic) + 1;

                                                                    $proveedorFechaRegi = substr($proveedores[$keyProveedor],$posiinic,strpos($proveedores[$keyProveedor],'|',$posiinic) - $posiinic);
                                                                    $posiinic = strpos($proveedores[$keyProveedor],'|',$posiinic) + 1;

                                                                    $proveedorPersona = substr($proveedores[$keyProveedor],$posiinic,strpos($proveedores[$keyProveedor],'|',$posiinic) - $posiinic);
                                                                    $descPersona= $this->proveedor->descPersona($proveedorPersona);
                                                                    $descPersona = $descPersona[0]['persona_nombre'];
                                                                    $posiinic = strpos($proveedores[$keyProveedor],'|',$posiinic) + 1;

                                                                    $proveedorEstado = substr($proveedores[$keyProveedor],$posiinic,strpos($proveedores[$keyProveedor],'|',$posiinic) - $posiinic);
                                                                    $descEstado = $this->proveedor->descEstado($proveedorEstado);
                                                                    $descEstado = $descEstado[0]['estado_descripcion'];
                                                                    $posiinic = strpos($proveedores[$keyProveedor],'|',$posiinic) + 1;

                                                                    $imprProveedor.="<tr>";
                                                                    $imprProveedor.="<td>".$idProveedor."</td>";
                                                                    $imprProveedor.="<td>".$proveedorNombre."</td>";
                                                                    $imprProveedor.="<td>".$proveedorTelefono."</td>";
                                                                    $imprProveedor.="<td>".$proveedorDireccion."</td>";
                                                                    $imprProveedor.="<td>".$proveedorEmail."</td>";
                                                                    $imprProveedor.="<td>".$proveedorFrecuencia."</td>";
                                                                    $imprProveedor.="<td>".$proveedorValoCompras."</td>";
                                                                    $imprProveedor.="<td>".$proveedorFechaRegi."</td>";
                                                                    $imprProveedor.="<td>".$descPersona."</td>";
                                                                    $imprProveedor.="<td>".$descEstado."</td>";
                                                                    $imprProveedor.="<td><button id='btn-modificar' href='#' onclick=\"modificaProveedor('$this->urlBase','$idProveedor')\" type='submit' class='btn btn-default btn-circle'><i class='fa fa-pencil'></i></button></td>";
                                                                    $imprProveedor.="<td><button id='btn-eliminar' href='#' onclick=\"borraProveedor('$this->urlBase','$idProveedor')\" type='submit' class='btn btn-danger btn-circle'><i class='fa fa-times'></i></button></td>";
                                                                    $imprProveedor.="</tr>";
                                                                    $posiinic = 0;
                                                                }
                                                                $cargaForma.=$imprProveedor;
                                                                $imprProveedor   = '';
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
    
    //Invoca el modelo de actualización de proveedores.
    function actualizarProveedor(){
        $this->load->model('proveedor');
        $codigoProv      = $_POST['idProv'];
        $nombreProv      = $_POST['nombreProv'];
        $telefonoProv    = $_POST['telefonoProv'];
        $direccionProv   = $_POST['direccionProv'];
        $emailProv       = $_POST['emailProv'];
        $estadoProv      = $_POST['estadoProv'];
        $estadoCodi      = substr($estadoProv,0,strpos($estadoProv,'-',0) - 1);
        $personaProv     = $this->session->userdata('idPers');
        $proveedor       = $this->proveedor->updProveedor($codigoProv,$nombreProv,$telefonoProv,$direccionProv,
                                                          $emailProv,$personaProv,$estadoCodi);
        if(isset($proveedor)){
            echo("true");
        }
        else{
            echo("false");
        }
    }
}
?>
<?php if (! defined('BASEPATH')) exit('No direct script access allowed');
 
class Ingredientes extends MX_Controller {
    
    function __construct(){
        parent::__construct();
        $this->urlBase = base_url();
    }
 
    function index(){
        echo("ingredientes.index");
    }
	
    function crearIngrediente(){
        //Se cargan los Estados desde el modelo Ingrediente
        $this->load->model('ingrediente');
        $estados     = $this->ingrediente->listaEstados();
        $unidades    = $this->ingrediente->listaUnidades();
        $imprOpci    ="";
        $imprUnidad  ="";
        $cargaForma  = "<div class='row'>
                 <!-- page header -->
                <div class='col-lg-12'>
                    <h1 class='page-header'>Crear Ingrediente</h1>
                </div>
                <!--end page header -->
            </div>
            <div class='row'>
                <div class='col-lg-12'>
                    <!-- Form Elements -->
                    <div class='panel panel-default'>
                        <div class='panel-heading'>
                            Registro de Ingredientes
                        </div>
                        <div class='panel-body'>
                            <div class='row'>
                                <div class='col-lg-6'>
                                    <form role='form'>
                                        <div class='form-group'>
                                            <label>Nombre</label>
                                            <input id='ingrediente-nombre' class='form-control' placeholder='Descripción del Ingrediente.'>
                                        </div>
                                        <div class='form-group'>
                                            <label>Cantidad Máxima</label>
                                            <input id='ingrediente-cantidad-maxima' class='form-control'>
                                        </div>
                                        <div class='form-group'>
                                            <label>Unidad</label>
                                            <select id='ingrediente-unidad' class='form-control'>";
        
        foreach ($unidades as $keyUnidad=>$unidad){
            //Se acumula el html para las opciones
            $imprOpci.="<option>".$unidades[$keyUnidad]."</option>"
                       . "";
        }
        $cargaForma.=$imprOpci;
        $imprOpci = "";
        $cargaForma.="</select>
                                        </div>
                                        
                                        <button id='btn-guardar' href='#' onclick=\"insertaIngrediente('$this->urlBase')\" type='submit' class='btn btn-primary'>Guardar</button>
                                        <button type='reset' class='btn btn-success'>Cancelar</button>
                                    </form>
                                </div>
                                <div class='col-lg-6'>
                                    <form role='form'>
                                        <div class='form-group'>
                                            <label>Cantidad Mínima</label>
                                            <input id='ingrediente-cantidad-minima' class='form-control'>
                                        </div>
                                        
                                        <div class='form-group'>
                                            <label>Cantidad Actual</label>
                                            <input id='ingrediente-cantidad-actual' class='form-control' value = 0 disabled>
                                        </div>
                                        <div class='form-group'>
                                            <label>Estado</label>
                                            <select id='ingrediente-estado' class='form-control'>";
        
        foreach ($estados as $keyEstado=>$estado){
            //Se acumula el html para las opciones
            $imprOpci.="<option>".$estados[$keyEstado]."</option>"
                       . "";
        }
        $cargaForma.=$imprOpci;
        $imprOpci = "";
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
    
    function modificarIngrediente(){
        if($this->session->userdata('logged_in')){
            $this->load->model('ingrediente');
            $idIngrediente  = $_POST['idIngrediente'];
            $estados        = $this->ingrediente->listaEstados();
            $unidades       = $this->ingrediente->listaUnidades();
            $ingrediente    = $this->ingrediente->selModiIngrediente($idIngrediente);
            $id_ingrediente = $ingrediente[0]['id_ingrediente'];
            $ingrNombre     = $ingrediente[0]['ingrediente_nombre'];
            $ingrCantMini   = $ingrediente[0]['ingrediente_cantidad_minima'];
            $ingrCantMaxi   = $ingrediente[0]['ingrediente_cantidad_maxima'];
            $ingrCantActu   = $ingrediente[0]['ingrediente_cantidad_actual'];
            
            $ingrUnidad_id  = $ingrediente[0]['ingrediente_unidad_id'];
            $unidad         = $this->ingrediente->selUnidad($ingrUnidad_id);
            $ingrediente_unidad = $unidad[0]['unidad'];
            
            $ingrEstado_id  = $ingrediente[0]['ingrediente_estado_id'];
            $estado         = $this->ingrediente->selEstado($ingrEstado_id);
            $ingrediente_estado = $estado[0]['estado'];
            
            $imprOpci           = "";
            $cargaForma  = "<div class='row'>
                 <!-- page header -->
                <div class='col-lg-12'>
                    <h1 class='page-header'>Modificar Ingrediente</h1>
                </div>
                <!--end page header -->
            </div>
            <div class='row'>
                <div class='col-lg-12'>
                    <!-- Form Elements -->
                    <div class='panel panel-default'>
                        <div class='panel-heading'>
                            Modificación de Ingredientes
                        </div>
                        <div class='panel-body'>
                            <div class='row'>
                                <div class='col-lg-6'>
                                    <form role='form'>
                                        <div class='form-group'>
                                            <label>Código</label>
                                            <input id='id-ingrediente' class='form-control' placeholder='Código del Ingrediente.' value = '$id_ingrediente' disabled>
                                        </div>
                                        <div class='form-group'>
                                                <label>Cantidad Mínima</label>
                                                <input id='ingrediente-cantidad-minima' class='form-control' value = '$ingrCantMini'>
                                        </div>
                                        <div class='form-group'>
                                            <label>Cantidad Actual</label>
                                            <input id='ingrediente-cantidad-actual' class='form-control' value = '$ingrCantActu' disabled>
                                        </div>
                                        <div class='form-group'>
                                            <label>Estado</label>
                                            <select id='ingrediente-estado' class='form-control'>";

            foreach ($estados as $keyEstado=>$estado){
                //Se acumula el html para las opciones
                if($ingrediente_estado == $estados[$keyEstado]){
                    $imprOpci.="<option selected>".$estados[$keyEstado]."</option>";
                }
                else{
                    $imprOpci.="<option>".$estados[$keyEstado]."</option>";
                }
            }
            $cargaForma.=$imprOpci;
            $imprOpci = "";
            $cargaForma.="</select>
                                        </div>
                                            <button id='btn-guardar' href='#' onclick=\"actualizaIngrediente('$this->urlBase')\" type='submit' class='btn btn-primary'>Guardar</button>
                                            <button type='reset' class='btn btn-success'>Cancelar</button>
                                        </form>
                                    </div>
                                    <div class='col-lg-6'>
                                        <form role='form'>
                                            <div class='form-group'>
                                               <label>Nombre</label>
                                               <input id='ingrediente-nombre' class='form-control' placeholder='Descripción del Ingrediente.' value = '$ingrNombre'>
                                            </div>
                                            <div class='form-group'>
                                                <label>Cantidad Máxima</label>
                                                <input id='ingrediente-cantidad-maxima' class='form-control' value = '$ingrCantMaxi'>
                                            </div>
                                            <div class='form-group'>
                                                <label>Unidad</label>
                                                <select id='ingrediente-unidad' class='form-control'>";
        
            foreach ($unidades as $keyUnidad=>$unidad){
                //Se acumula el html para las opciones
                if($ingrediente_unidad == $unidades[$keyUnidad]){
                    $imprOpci.="<option selected>".$unidades[$keyUnidad]."</option>";
                }
                else{
                    $imprOpci.="<option>".$unidades[$keyUnidad]."</option>";
                }
            }
            $cargaForma.=$imprOpci;
            $imprOpci = "";
            $cargaForma.="</select>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                         <!-- End Form Elements -->
                    </div>
                </div>";
            echo $cargaForma;
        }
        else{
            echo('No se ha logueado');
            redirect('contenedor');
        }
    }
    
    //Carga el formulario de consulta de los ingredientes.
    function consultarIngrediente(){
        if($this->session->userdata('logged_in')){
            $valorIngr = "";
            $this->load->model('ingrediente');
            $ingredientes    = $this->ingrediente->consIngrediente($valorIngr);
            $imprIngrediente = "";
                $cargaForma  = "<div class='row' onload='consultaIngrediente('$this->urlBase')'>
                        <!-- Page Header -->
                        <div class='col-lg-12'>
                            <h1 class='page-header'>Consultar Ingrediente</h1>
                        </div>
                        <!--End Page Header -->
                    </div>
                    <div class='row'>
                        <div class='col-lg-12'>
                            <!-- Advanced Tables -->
                            <div class='panel panel-default'>
                                <div class='panel-heading'>
                                     Consulta de Ingredientes
                                </div>
                                <div class='panel-body'>
                                    <div class='table-responsive'>
                                        <div id='dataTables-example_wrapper' class='dataTables_wrapper form-inline' role='grid'>
                                            <div class='row'>
                                                <div class='col-sm-6'>
                                                    <!-- search section-->
                                                    <div id='dataTables-example_filter' class='dataTables_filter'>
                                                        <span class='input-group-btn'>
                                                            <input type='search' id='ingrediente-valor' class='form-control input-sm' aria-controls='dataTables-example' placeholder='Buscar'>
                                                            <button id='busca-ingrediente' class='btn btn-default' onclick=\"consultaIngrediente('$this->urlBase')\" type='submit'><i class='fa fa-search'></i></button>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div id='ingredientes' class='row'>
                                                <div class='form-group'>
                                                    <div id='lista'>
                                                        <table class='table table-bordered'width='100%'  border='0' cellspacing='0' cellpadding='0' style='font-size:10px'>
                                                            <thead>
                                                                <tr>
                                                                    <th>Código</th>
                                                                    <th>Nombre</th>
                                                                    <th>Cantidad Mínima</th>
                                                                    <th>Cantidad Máxima</th>
                                                                    <th>Cantidad Actual</th>
                                                                    <th>Unidad</th>
                                                                    <th>Fecha Registro</th>
                                                                    <th>Persona Registra</th>
                                                                    <th>Estado</th>
                                                                </tr>
                                                            </thead>";
            if($ingredientes != false){
                $imprIngrediente = "";
                $cargaForma.= "<tbody>";
                $posiinic = 0;                                                
                foreach ($ingredientes as $keyIngrediente=>$ingrediente){
                    //Se acumula el html para los ingredientes
                    $idIngrediente = substr($ingredientes[$keyIngrediente],$posiinic,strpos($ingredientes[$keyIngrediente],'|',$posiinic) - $posiinic);
                    $posiinic = strpos($ingredientes[$keyIngrediente],'|',$posiinic) + 1;

                    $ingredienteNombre = substr($ingredientes[$keyIngrediente],$posiinic,strpos($ingredientes[$keyIngrediente],'|',$posiinic) - $posiinic);
                    $posiinic = strpos($ingredientes[$keyIngrediente],'|',$posiinic) + 1;

                    $ingredienteCantMini = substr($ingredientes[$keyIngrediente],$posiinic,strpos($ingredientes[$keyIngrediente],'|',$posiinic) - $posiinic);
                    $posiinic = strpos($ingredientes[$keyIngrediente],'|',$posiinic) + 1;
                    
                    $ingredienteCantMaxi = substr($ingredientes[$keyIngrediente],$posiinic,strpos($ingredientes[$keyIngrediente],'|',$posiinic) - $posiinic);
                    $posiinic = strpos($ingredientes[$keyIngrediente],'|',$posiinic) + 1;
                    
                    $ingredienteCantActu = substr($ingredientes[$keyIngrediente],$posiinic,strpos($ingredientes[$keyIngrediente],'|',$posiinic) - $posiinic);
                    $posiinic = strpos($ingredientes[$keyIngrediente],'|',$posiinic) + 1;
                    
                    $ingredienteUnidad = substr($ingredientes[$keyIngrediente],$posiinic,strpos($ingredientes[$keyIngrediente],'|',$posiinic) - $posiinic);
                    $posiinic = strpos($ingredientes[$keyIngrediente],'|',$posiinic) + 1;
                    
                    $ingredienteFechaRegi = substr($ingredientes[$keyIngrediente],$posiinic,strpos($ingredientes[$keyIngrediente],'|',$posiinic) - $posiinic);
                    $posiinic = strpos($ingredientes[$keyIngrediente],'|',$posiinic) + 1;

                    $ingredientePersona = substr($ingredientes[$keyIngrediente],$posiinic,strpos($ingredientes[$keyIngrediente],'|',$posiinic) - $posiinic);
                    $posiinic = strpos($ingredientes[$keyIngrediente],'|',$posiinic) + 1;

                    $ingredienteEstado = substr($ingredientes[$keyIngrediente],$posiinic,strpos($ingredientes[$keyIngrediente],'|',$posiinic) - $posiinic);
                    $posiinic = strpos($ingredientes[$keyIngrediente],'|',$posiinic) + 1;

                    $imprIngrediente.="<tr>";
                    $imprIngrediente.="<td>".$idIngrediente."</td>";
                    $imprIngrediente.="<td>".$ingredienteNombre."</td>";
                    $imprIngrediente.="<td>".$ingredienteCantMini."</td>";
                    $imprIngrediente.="<td>".$ingredienteCantMaxi."</td>";
                    $imprIngrediente.="<td>".$ingredienteCantActu."</td>";
                    $imprIngrediente.="<td>".$ingredienteUnidad."</td>";
                    $imprIngrediente.="<td>".$ingredienteFechaRegi."</td>";
                    $imprIngrediente.="<td>".$ingredientePersona."</td>";
                    $imprIngrediente.="<td>".$ingredienteEstado."</td>";
                    $imprIngrediente.="<td><button id='btn-modificar' href='#' onclick=\"modificaIngrediente('$this->urlBase','$idIngrediente')\" type='submit' class='btn btn-default btn-circle'><i class='fa fa-pencil'></i></button></td>";
                    $imprIngrediente.="<td><button id='btn-eliminar' href='#' onclick=\"borraIngrediente('$this->urlBase','$idIngrediente')\" type='submit' class='btn btn-danger btn-circle'><i class='fa fa-times'></i></button></td>";
                    $imprIngrediente.="</tr>";
                    $posiinic = 0;
                }
                $cargaForma.=$imprIngrediente;
                $imprIngrediente   = '';
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
    
    //Recarga el formulario de consulta de los ingredientes una vez eliminado algún ingrediente.
    function eliminarIngrediente(){
        if($this->session->userdata('logged_in')){
            $this->load->model('ingrediente');
            $idIngrediente = $_POST['idIngrediente'];
            $moviIngr   = $this->ingrediente->selMoviIngr($idIngrediente);
            if($moviIngr == 0){
                $ingreprodu = $this->ingrediente->selProdIngr($idIngrediente);
                if($ingreprodu == 0){
                    $ingredientes  = $this->ingrediente->borIngrediente($idIngrediente);
                    $cargaForma = "<div class='form-group'>
                                                    <div id='lista'>
                                                        <table class='table table-bordered'width='100%'  border='0' cellspacing='0' cellpadding='0' style='font-size:10px'>
                                                            <thead>
                                                                <tr>
                                                                    <th>Código</th>
                                                                    <th>Nombre</th>
                                                                    <th>Cantidad Mínima</th>
                                                                    <th>Cantidad Máxima</th>
                                                                    <th>Cantidad Actual</th>
                                                                    <th>Unidad</th>
                                                                    <th>Fecha Registro</th>
                                                                    <th>Persona Registra</th>
                                                                    <th>Estado</th>
                                                                </tr>
                                                            </thead>";
                    if($ingredientes != false){
                        $imprIngrediente = "";
                        $cargaForma.= "<tbody>";
                        $posiinic = 0;                                                
                        foreach ($ingredientes as $keyIngrediente=>$ingrediente){
                            //Se acumula el html para los ingredientes
                            $idIngrediente = substr($ingredientes[$keyIngrediente],$posiinic,strpos($ingredientes[$keyIngrediente],'|',$posiinic) - $posiinic);
                            $posiinic = strpos($ingredientes[$keyIngrediente],'|',$posiinic) + 1;

                            $ingredienteNombre = substr($ingredientes[$keyIngrediente],$posiinic,strpos($ingredientes[$keyIngrediente],'|',$posiinic) - $posiinic);
                            $posiinic = strpos($ingredientes[$keyIngrediente],'|',$posiinic) + 1;

                            $ingredienteCantMini = substr($ingredientes[$keyIngrediente],$posiinic,strpos($ingredientes[$keyIngrediente],'|',$posiinic) - $posiinic);
                            $posiinic = strpos($ingredientes[$keyIngrediente],'|',$posiinic) + 1;

                            $ingredienteCantMaxi = substr($ingredientes[$keyIngrediente],$posiinic,strpos($ingredientes[$keyIngrediente],'|',$posiinic) - $posiinic);
                            $posiinic = strpos($ingredientes[$keyIngrediente],'|',$posiinic) + 1;

                            $ingredienteCantActu = substr($ingredientes[$keyIngrediente],$posiinic,strpos($ingredientes[$keyIngrediente],'|',$posiinic) - $posiinic);
                            $posiinic = strpos($ingredientes[$keyIngrediente],'|',$posiinic) + 1;

                            $ingredienteUnidad = substr($ingredientes[$keyIngrediente],$posiinic,strpos($ingredientes[$keyIngrediente],'|',$posiinic) - $posiinic);
                            $posiinic = strpos($ingredientes[$keyIngrediente],'|',$posiinic) + 1;

                            $ingredienteFechaRegi = substr($ingredientes[$keyIngrediente],$posiinic,strpos($ingredientes[$keyIngrediente],'|',$posiinic) - $posiinic);
                            $posiinic = strpos($ingredientes[$keyIngrediente],'|',$posiinic) + 1;

                            $ingredientePersona = substr($ingredientes[$keyIngrediente],$posiinic,strpos($ingredientes[$keyIngrediente],'|',$posiinic) - $posiinic);
                            $posiinic = strpos($ingredientes[$keyIngrediente],'|',$posiinic) + 1;

                            $ingredienteEstado = substr($ingredientes[$keyIngrediente],$posiinic,strpos($ingredientes[$keyIngrediente],'|',$posiinic) - $posiinic);
                            $posiinic = strpos($ingredientes[$keyIngrediente],'|',$posiinic) + 1;

                            $imprIngrediente.="<tr>";
                            $imprIngrediente.="<td>".$idIngrediente."</td>";
                            $imprIngrediente.="<td>".$ingredienteNombre."</td>";
                            $imprIngrediente.="<td>".$ingredienteCantMini."</td>";
                            $imprIngrediente.="<td>".$ingredienteCantMaxi."</td>";
                            $imprIngrediente.="<td>".$ingredienteCantActu."</td>";
                            $imprIngrediente.="<td>".$ingredienteUnidad."</td>";
                            $imprIngrediente.="<td>".$ingredienteFechaRegi."</td>";
                            $imprIngrediente.="<td>".$ingredientePersona."</td>";
                            $imprIngrediente.="<td>".$ingredienteEstado."</td>";
                            $imprIngrediente.="<td><button id='btn-modificar' href='#' onclick=\"modificaIngrediente('$this->urlBase','$idIngrediente')\" type='submit' class='btn btn-default btn-circle'><i class='fa fa-pencil'></i></button></td>";
                            $imprIngrediente.="<td><button id='btn-eliminar' href='#' onclick=\"borraIngrediente('$this->urlBase','$idIngrediente')\" type='submit' class='btn btn-danger btn-circle'><i class='fa fa-times'></i></button></td>";
                            $imprIngrediente.="</tr>";
                            $posiinic = 0;
                        }
                        $cargaForma.=$imprIngrediente;
                        $imprIngrediente   = '';
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
                    echo("ingreprodu");
                }
            }
            else{
                echo("movicomp");
            }
        }
        else{
            echo('No se ha logueado');
            redirect('contenedor');
        }
    }
    
    
    function guardarIngrediente(){
        $this->load->model('ingrediente');
        $nombreIngr    = $_POST['nombreIngr'];
        $cantMinIngr   = $_POST['cantMinIngr'];
        $cantMaxIngr   = $_POST['cantMaxIngr'];
        $cantActIngr   = $_POST['cantActIngr'];
        $unidadIngr    = $_POST['unidadIngr'];
        $unidadCodi    = substr($unidadIngr,0,strpos($unidadIngr,'-',0) - 1);
        $estadoIngr    = $_POST['estadoIngr'];
        $estadoCodi    = substr($estadoIngr,0,strpos($estadoIngr,'-',0) - 1);
        $personaIngr   = $this->session->userdata('idPers');
        $ingrediente      = $this->ingrediente->insIngrediente($nombreIngr,$cantMinIngr,$cantMaxIngr,$cantActIngr,
                                                               $unidadCodi,$estadoCodi,$personaIngr);
        if(isset($ingrediente)){
            echo("true");
        }
        else{
            echo("false");}
        }
    
    function obtenerIngrediente(){
        $this->load->model('ingrediente');
        $idIngrediente = $_POST['idIngrediente'];
        $nombreIngr    = $_POST['nombreIngrediente'];
        $ingrediente   = $this->ingrediente->selIngrediente($idIngrediente,$nombreIngr);
        if($ingrediente == 0){
            echo("true");
        }
        else{
            echo("false");
        }
    }
    
    function validarUsuaPers(){
        $this->load->model('ingrediente');
        $usuaPers    = $_POST['usuarioPers'];
        $usuarioCodi = substr($usuaPers,0,strpos($usuaPers,'-',0) - 1);
        $ingrediente     = $this->ingrediente->selUsuaPers($usuarioCodi);
        echo($ingrediente);
    }
    
    //Invoca el modelo de actualización de ingredientes.
    function actualizarIngrediente(){
        if($this->session->userdata('logged_in')){
            $this->load->model('ingrediente');
            $idIngrediente      = $_POST['idIngrediente'];
            $nombreIngrediente  = $_POST['nombreIngrediente'];
            $cantMinIngrediente = $_POST['cantMinIngrediente'];
            $cantMaxIngrediente = $_POST['cantMaxIngrediente'];
            $cantActIngrediente = $_POST['cantActIngrediente'];
            $unidadIngrediente  = $_POST['unidadIngrediente'];
            $unidadCodi         = substr($unidadIngrediente,0,strpos($unidadIngrediente,'-',0) - 1);
            $estadoIngrediente  = $_POST['estadoIngrediente'];
            $estadoCodi         = substr($estadoIngrediente,0,strpos($estadoIngrediente,'-',0) - 1);
            $ingrediente        = $this->ingrediente->updIngrediente($idIngrediente,$nombreIngrediente,$cantMinIngrediente,
                                                                     $cantMaxIngrediente,$cantActIngrediente,$unidadCodi,
                                                                     $estadoCodi);
            if($ingrediente){
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
    
    //Recarga el formulario de consulta de los ingredientes a partir del criterio de búsqueda dado.
    function seleccionarIngrediente(){
        if($this->session->userdata('logged_in')){
            $this->load->model('ingrediente');
            $valorIngr = $_POST['ingrediente_valor'];
            $ingredientes  = $this->ingrediente->consIngrediente($valorIngr);
            $imprIngrediente = "";
            $cargaForma = "<div class='form-group'>
                                            <div id='lista'>
                                                <table class='table table-bordered'width='100%'  border='0' cellspacing='0' cellpadding='0' style='font-size:10px'>
                                                    <thead>
                                                        <tr>
                                                            <th>Código</th>
                                                            <th>Nombre</th>
                                                            <th>Cantidad Mínima</th>
                                                            <th>Cantidad Máxima</th>
                                                            <th>Cantidad Actual</th>
                                                            <th>Unidad</th>
                                                            <th>Fecha Registro</th>
                                                            <th>Persona Registra</th>
                                                            <th>Estado</th>
                                                        </tr>
                                                    </thead>";
            if($ingredientes != false){
                $imprIngrediente = "";
                $cargaForma.= "<tbody>";
                $posiinic = 0;                                                
                foreach ($ingredientes as $keyIngrediente=>$ingrediente){
                    //Se acumula el html para los ingredientes
                    $idIngrediente = substr($ingredientes[$keyIngrediente],$posiinic,strpos($ingredientes[$keyIngrediente],'|',$posiinic) - $posiinic);
                    $posiinic = strpos($ingredientes[$keyIngrediente],'|',$posiinic) + 1;

                    $ingredienteNombre = substr($ingredientes[$keyIngrediente],$posiinic,strpos($ingredientes[$keyIngrediente],'|',$posiinic) - $posiinic);
                    $posiinic = strpos($ingredientes[$keyIngrediente],'|',$posiinic) + 1;

                    $ingredienteCantMini = substr($ingredientes[$keyIngrediente],$posiinic,strpos($ingredientes[$keyIngrediente],'|',$posiinic) - $posiinic);
                    $posiinic = strpos($ingredientes[$keyIngrediente],'|',$posiinic) + 1;

                    $ingredienteCantMaxi = substr($ingredientes[$keyIngrediente],$posiinic,strpos($ingredientes[$keyIngrediente],'|',$posiinic) - $posiinic);
                    $posiinic = strpos($ingredientes[$keyIngrediente],'|',$posiinic) + 1;

                    $ingredienteCantActu = substr($ingredientes[$keyIngrediente],$posiinic,strpos($ingredientes[$keyIngrediente],'|',$posiinic) - $posiinic);
                    $posiinic = strpos($ingredientes[$keyIngrediente],'|',$posiinic) + 1;

                    $ingredienteUnidad = substr($ingredientes[$keyIngrediente],$posiinic,strpos($ingredientes[$keyIngrediente],'|',$posiinic) - $posiinic);
                    $posiinic = strpos($ingredientes[$keyIngrediente],'|',$posiinic) + 1;

                    $ingredienteFechaRegi = substr($ingredientes[$keyIngrediente],$posiinic,strpos($ingredientes[$keyIngrediente],'|',$posiinic) - $posiinic);
                    $posiinic = strpos($ingredientes[$keyIngrediente],'|',$posiinic) + 1;

                    $ingredientePersona = substr($ingredientes[$keyIngrediente],$posiinic,strpos($ingredientes[$keyIngrediente],'|',$posiinic) - $posiinic);
                    $posiinic = strpos($ingredientes[$keyIngrediente],'|',$posiinic) + 1;

                    $ingredienteEstado = substr($ingredientes[$keyIngrediente],$posiinic,strpos($ingredientes[$keyIngrediente],'|',$posiinic) - $posiinic);
                    $posiinic = strpos($ingredientes[$keyIngrediente],'|',$posiinic) + 1;

                    $imprIngrediente.="<tr>";
                    $imprIngrediente.="<td>".$idIngrediente."</td>";
                    $imprIngrediente.="<td>".$ingredienteNombre."</td>";
                    $imprIngrediente.="<td>".$ingredienteCantMini."</td>";
                    $imprIngrediente.="<td>".$ingredienteCantMaxi."</td>";
                    $imprIngrediente.="<td>".$ingredienteCantActu."</td>";
                    $imprIngrediente.="<td>".$ingredienteUnidad."</td>";
                    $imprIngrediente.="<td>".$ingredienteFechaRegi."</td>";
                    $imprIngrediente.="<td>".$ingredientePersona."</td>";
                    $imprIngrediente.="<td>".$ingredienteEstado."</td>";
                    $imprIngrediente.="<td><button id='btn-modificar' href='#' onclick=\"modificaIngrediente('$this->urlBase','$idIngrediente')\" type='submit' class='btn btn-default btn-circle'><i class='fa fa-pencil'></i></button></td>";
                    $imprIngrediente.="<td><button id='btn-eliminar' href='#' onclick=\"borraIngrediente('$this->urlBase','$idIngrediente')\" type='submit' class='btn btn-danger btn-circle'><i class='fa fa-times'></i></button></td>";
                    $imprIngrediente.="</tr>";
                    $posiinic = 0;
                }
                $cargaForma.=$imprIngrediente;
                $imprIngrediente   = '';
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
<?php if (! defined('BASEPATH')) exit('No direct script access allowed');
 
class Movitras extends MX_Controller {
    
    function __construct(){
        parent::__construct();
        $this->urlBase = base_url();
    }
 
    function index(){
        echo("movitras.index");
    }
	
    function crearMovitras(){
        //Se cargan los Estados desde el modelo Movitrasl
        $this->load->model('movitrasl');
        $ingredientes = $this->movitrasl->listaIngredientes();
        $bodegas = $this->movitrasl->listaBodegas();
        $imprOpci ="";
        $cargaForma = "<div class='row'>
                 <!-- page header -->
                <div class='col-lg-12'>
                    <h1 class='page-header'>Registrar Traslado de Bodega</h1>
                </div>
                <!--end page header -->
            </div>
            <div class='row'>
                <div class='col-lg-12'>
                    <!-- Form Elements -->
                    <div class='panel panel-default'>
                        <div class='panel-heading'>
                            Registro de Traslados de Bodega
                        </div>
                        <div class='panel-body'>
                            <div class='row'>
                                <div class='col-lg-6'>
                                    <form role='form'>
                                        <div class='form-group'>
                                            <label>Bodega Fuente</label>
                                            <select id='movitras-bodefuen-id' class='form-control'>";
        
        foreach ($bodegas as $keyBodega=>$bodega){
            //Se acumula el html para las opciones
            $imprOpci.="<option>".$bodegas[$keyBodega]."</option>"
                       . "";
        }
        $cargaForma.=$imprOpci;
        $imprOpci = '';
        $cargaForma.="</select>
                                        </div>
                                        <div class='form-group'>
                                            <label>Cantidad</label>
                                            <input id='movitras-cantidad' class='form-control' placeholder='Cantidad del Ingrediente.'>
                                        </div>
                                        <div class='form-group'>
                                            <label>Observación</label>
                                            <textarea id='movitras-observacion' class='form-control' placeholder='Observación'></textarea>
                                        </div>
                                        <button id='btn-guardar' href='#' onclick=\"insertaMovitras('$this->urlBase')\" type='submit' class='btn btn-primary'>Añadir Traslado</button>
                                        <button id='btn-cancelar' type='reset' class='btn btn-success'>Cancelar</button>
                                    </form>
                                </div>
                                <div class='col-lg-6'>
                                    <form role='form'>
                                        
                                        <div class='form-group'>
                                            <label>Ingrediente</label>
                                            <select id='movitras-ingrediente-id' class='form-control'>";
        
        foreach ($ingredientes as $keyIngrediente=>$ingrediente){
            //Se acumula el html para las opciones
            $imprOpci.="<option>".$ingredientes[$keyIngrediente]."</option>"
                       . "";
        }
        $cargaForma.=$imprOpci;
        $imprOpci = '';
        $cargaForma.="</select>
                                        </div>
                                        <div class='form-group'>
                                            <label>Bodega Destino</label>
                                            <select id='movitras-bodedest-id' class='form-control'>";
        
        foreach ($bodegas as $keyBodega=>$bodega){
            //Se acumula el html para las opciones
            $imprOpci.="<option>".$bodegas[$keyBodega]."</option>"
                       . "";
        }
        $cargaForma.=$imprOpci;
        $imprOpci = '';
        $cargaForma.="</select>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>";
        echo $cargaForma;
    }
    
    function guardarMovitras(){
        $this->load->model('movitrasl');
        $bodefuenMovi    = $_POST['bodefuen'];
        $bodefuenCodi    = substr($bodefuenMovi,0,strpos($bodefuenMovi,'-',0) - 1);
        $bodedestMovi    = $_POST['bodedest'];
        $bodedestCodi    = substr($bodedestMovi,0,strpos($bodedestMovi,'-',0) - 1);
        $ingredienteMovi = $_POST['ingrediente'];
        $ingredienteCodi = substr($ingredienteMovi,0,strpos($ingredienteMovi,'-',0) - 1);
        $cantidadMovi    = $_POST['cantidad'];
        $observacion     = $_POST['observacion'];
        $personaMovi     = $this->session->userdata('idPers');
        $ingrebofu = $this->movitrasl->selIngreBode($bodefuenCodi,$ingredienteCodi);
        //Valida que exista el ingrediente en la bodega fuente.
        if($ingrebofu == -1){
            echo("bofu_no_disponible");
        }
        else{
            //Valida que la cantidad disponible del ingrediente de la bodega fuente sea mayor o igual
            //a la cantidad a trasladar.
            if($ingrebofu >= $cantidadMovi){
                $afectaIngreBofu = $this->movitrasl->actIngreBofu($bodefuenCodi,$ingredienteCodi,$cantidadMovi,
                                                                  $personaMovi);
                $movitras = $this->movitrasl->selIngreBode($bodedestCodi,$ingredienteCodi);
                //Valida que exista el ingrediente en la bodega destino.
                if($movitras == -1){
                    //Registra el ingrediente en la bodega destino con la cantidad trasladada.
                    $afectaMoviTras = $this->movitrasl->insMoviTras($bodedestCodi,$ingredienteCodi,$cantidadMovi,
                                                                      $personaMovi);
                    //Valida que se hayan afectado las cantidades en las bodegas fuente y destino.
                    if((isset($afectaMoviTras))&&(isset($afectaIngreBofu))){
                        //Registra el movimiento de traslado
                        $movitras = $this->movitrasl->insMovitras($bodefuenCodi,$bodedestCodi,$ingredienteCodi,
                                                                  $cantidadMovi,$observacion,$personaMovi);
                        if(isset($movitras)){
                            echo("true");
                        }
                        else{
                            echo("false");
                        }
                    }
                    else{
                        echo("false");
                    }
                }
                else{
                    //Actualiza el ingrediente en la bodega destino con la cantidad trasladada.
                    $actuMoviTras = $this->movitrasl->actIngreBode($bodedestCodi,$ingredienteCodi,$cantidadMovi,
                                                                      $personaMovi);
                    //Valida que se hayan afectado las cantidades en las bodegas fuente y destino.
                    if((isset($actuMoviTras))&&(isset($afectaIngreBofu))){
                        //Registra el movimiento de traslado
                        $movitras = $this->movitrasl->insMovitras($bodefuenCodi,$bodedestCodi,$ingredienteCodi,
                                                                  $cantidadMovi,$observacion,$personaMovi);
                        if(isset($movitras)){
                            echo("true");
                        }
                        else{
                            echo("false");
                        }
                    }
                    else{
                        echo("false");
                    }
                }
            }
            else{
                echo("bofu_no_disponible");
            }
        }
    }
    
    function afectaMoviTras(){
        $this->load->model('movitrasl');
        $bodefuenMovi    = $_POST['bodefuen'];
        $bodefuenCodi    = substr($bodefuenMovi,0,strpos($bodefuenMovi,'-',0) - 1);
        $bodedestMovi    = $_POST['bodedest'];
        $bodedestCodi    = substr($bodedestMovi,0,strpos($bodedestMovi,'-',0) - 1);
        $ingredienteMovi = $_POST['ingrediente'];
        $ingredienteCodi = substr($ingredienteMovi,0,strpos($ingredienteMovi,'-',0) - 1);
        $cantidadMovi    = $_POST['cantidad'];
        $personaMovi     = $this->session->userdata('idPers');
        $ingrebofu = $this->movitrasl->selMoviTras($bodefuenCodi,$ingredienteCodi);
        if($ingrebofu == 0){
           echo("bofu_no_disponible");
        }
        else{
            if($ingrebofu >= $cantidadMovi){
                $afectaIngreBofu = $this->movitrasl->actIngreBofu($bodefuenCodi,$ingredienteCodi,$cantidadMovi,
                                                                  $personaMovi);
                $movitras       = $this->movitrasl->selMoviTras($bodedestCodi,$ingredienteCodi);
                if($movitras == 0){
                    $afectaMoviTras = $this->movitrasl->insMoviTras($bodedestCodi,$ingredienteCodi,$cantidadMovi,
                                                                      $personaMovi);
                    if((isset($afectaMoviTras))&&(isset($afectaIngreBofu))){
                        echo("true");
                    }
                    else{
                        echo("false");
                    }
                }
                else{
                    if($movitras == 1){
                        $afectaMoviTras = $this->movitrasl->actMoviTras($bodedestCodi,$ingredienteCodi,$cantidadMovi,
                                                                          $personaMovi);
                        if(isset($afectaMoviTras)&&isset($afectaIngreBofu)){
                            echo("true");
                        }
                        else{
                            echo("false");
                        }
                    }
                }
            }
            else{
                echo("bofu_no_disponible");
            }
        }
    }
    
    //Carga el formulario de consulta de los movimientos de traslado de bodega de ingredientes.
    function consultarMoviTras(){
        if($this->session->userdata('logged_in')){
            $valorMoviTras = "";
            $this->load->model('movitrasl');
            $movitras      = $this->movitrasl->consMoviTras($valorMoviTras);
            $imprMoviTras  = "";
                $cargaForma  = "<div class='row' onload='consultaMoviTras('$this->urlBase')'>
                        <!-- Page Header -->
                        <div class='col-lg-12'>
                            <h1 class='page-header'>Movimientos de Traslado de Bodega</h1>
                        </div>
                        <!--End Page Header -->
                    </div>
                    <div class='row'>
                        <div class='col-lg-12'>
                            <!-- Advanced Tables -->
                            <div class='panel panel-default'>
                                <div class='panel-heading'>
                                     Consulta de Movimientos de Traslado de Bodega de Ingredientes
                                </div>
                                <div class='panel-body'>
                                    <div class='table-responsive'>
                                        <div id='dataTables-example_wrapper' class='dataTables_wrapper form-inline' role='grid'>
                                            <div class='row'>
                                                <div class='col-sm-6'>
                                                    <!-- search section-->
                                                    <div id='dataTables-example_filter' class='dataTables_filter'>
                                                        <span class='input-group-btn'>
                                                            <input type='search' id='movitras-valor' class='form-control input-sm' aria-controls='dataTables-example' placeholder='Buscar'>
                                                            <button id='busca-movitras' class='btn btn-default' onclick=\"consultaMoviTras('$this->urlBase')\" type='submit'><i class='fa fa-search'></i></button>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div id='movitras' class='row'>
                                                <div class='form-group'>
                                                    <div id='lista'>
                                                        <table class='table table-bordered'width='100%'  border='0' cellspacing='0' cellpadding='0' style='font-size:10px'>
                                                            <thead>
                                                                <tr>
                                                                    <th>Secuencia</th>
                                                                    <th>Código Bodega Fuente</th>
                                                                    <th>Nombre Bodega Fuente</th>
                                                                    <th>Código Bodega Destino</th>
                                                                    <th>Nombre Bodega Destino</th>
                                                                    <th>Código Ingrediente</th>
                                                                    <th>Nombre Ingrediente</th>
                                                                    <th>Cantidad</th>
                                                                    <th>Observación</th>
                                                                    <th>Fecha Registro</th>
                                                                    <th>Persona Registra</th>
                                                                </tr>
                                                            </thead>";
            if($movitras != false){
                $imprMoviTras = "";
                $cargaForma.= "<tbody>";
                $posiinic = 0;                                                
                foreach ($movitras as $keyMoviTras=>$movitrasl){
                    //Se acumula el html para los movitrass
                    $idMoviTras = substr($movitras[$keyMoviTras],$posiinic,strpos($movitras[$keyMoviTras],'|',$posiinic) - $posiinic);
                    $posiinic = strpos($movitras[$keyMoviTras],'|',$posiinic) + 1;

                    $idBodeFuen = substr($movitras[$keyMoviTras],$posiinic,strpos($movitras[$keyMoviTras],'|',$posiinic) - $posiinic);
                    $descBodeFuen = $this->movitrasl->descBodega($idBodeFuen);
                    $descBodeFuen = $descBodeFuen[0]['bodega_nombre'];
                    $posiinic = strpos($movitras[$keyMoviTras],'|',$posiinic) + 1;

                    $idBodeDest = substr($movitras[$keyMoviTras],$posiinic,strpos($movitras[$keyMoviTras],'|',$posiinic) - $posiinic);
                    $descBodeDest = $this->movitrasl->descBodega($idBodeDest);
                    $descBodeDest = $descBodeDest[0]['bodega_nombre'];
                    $posiinic = strpos($movitras[$keyMoviTras],'|',$posiinic) + 1;
                    
                    $idIngrediente = substr($movitras[$keyMoviTras],$posiinic,strpos($movitras[$keyMoviTras],'|',$posiinic) - $posiinic);
                    $descIngrediente = $this->movitrasl->descIngrediente($idIngrediente);
                    $descIngrediente = $descIngrediente[0]['ingrediente_nombre'];
                    $posiinic = strpos($movitras[$keyMoviTras],'|',$posiinic) + 1;

                    $movitrasCantidad = substr($movitras[$keyMoviTras],$posiinic,strpos($movitras[$keyMoviTras],'|',$posiinic) - $posiinic);
                    $posiinic = strpos($movitras[$keyMoviTras],'|',$posiinic) + 1;
                    
                    $movitrasObservacion = substr($movitras[$keyMoviTras],$posiinic,strpos($movitras[$keyMoviTras],'|',$posiinic) - $posiinic);
                    $posiinic = strpos($movitras[$keyMoviTras],'|',$posiinic) + 1;
                    
                    $movitrasFechaRegi = substr($movitras[$keyMoviTras],$posiinic,strpos($movitras[$keyMoviTras],'|',$posiinic) - $posiinic);
                    $posiinic = strpos($movitras[$keyMoviTras],'|',$posiinic) + 1;

                    $idPersona = substr($movitras[$keyMoviTras],$posiinic,strpos($movitras[$keyMoviTras],'|',$posiinic) - $posiinic);
                    $descPersona= $this->movitrasl->descPersona($idPersona);
                    $descPersona = $descPersona[0]['persona_nombre'];
                    $posiinic = strpos($movitras[$keyMoviTras],'|',$posiinic) + 1;

                    $imprMoviTras.="<tr>";
                    $imprMoviTras.="<td>".$idMoviTras."</td>";
                    $imprMoviTras.="<td>".$idBodeFuen."</td>";
                    $imprMoviTras.="<td>".$descBodeFuen."</td>";
                    $imprMoviTras.="<td>".$idBodeDest."</td>";
                    $imprMoviTras.="<td>".$descBodeDest."</td>";
                    $imprMoviTras.="<td>".$idIngrediente."</td>";
                    $imprMoviTras.="<td>".$descIngrediente."</td>";
                    $imprMoviTras.="<td>".$movitrasCantidad."</td>";
                    $imprMoviTras.="<td>".$movitrasObservacion."</td>";
                    $imprMoviTras.="<td>".$movitrasFechaRegi."</td>";
                    $imprMoviTras.="<td>".$descPersona."</td>";
                    $imprMoviTras.="</tr>";
                    $posiinic = 0;
                }
                $cargaForma.=$imprMoviTras;
                $imprMoviTras   = '';
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
    
    function seleccionarMoviTras(){
        if($this->session->userdata('logged_in')){
            $this->load->model('movitrasl');
            $valorMoviTras = $_POST['movitras_valor'];
            $movitras      = $this->movitrasl->consMoviTras($valorMoviTras);
            $imprMoviTras  = "";
            $imprMoviTras  = "";
            $cargaForma  = "<div class='form-group'>
                                                <div id='lista'>
                                                    <table class='table table-bordered'width='100%'  border='0' cellspacing='0' cellpadding='0' style='font-size:10px'>
                                                        <thead>
                                                            <tr>
                                                                <th>Secuencia</th>
                                                                <th>Código Bodega Fuente</th>
                                                                <th>Nombre Bodega Fuente</th>
                                                                <th>Código Bodega Destino</th>
                                                                <th>Nombre Bodega Destino</th>
                                                                <th>Código Ingrediente</th>
                                                                <th>Nombre Ingrediente</th>
                                                                <th>Cantidad</th>
                                                                <th>Observación</th>
                                                                <th>Fecha Registro</th>
                                                                <th>Persona Registra</th>
                                                            </tr>
                                                        </thead>";
            if($movitras != false){
                $imprMoviTras = "";
                $cargaForma.= "<tbody>";
                $posiinic = 0;                                                
                foreach ($movitras as $keyMoviTras=>$movitrasl){
                    //Se acumula el html para los movitrass
                    $idMoviTras = substr($movitras[$keyMoviTras],$posiinic,strpos($movitras[$keyMoviTras],'|',$posiinic) - $posiinic);
                    $posiinic = strpos($movitras[$keyMoviTras],'|',$posiinic) + 1;

                    $idBodeFuen = substr($movitras[$keyMoviTras],$posiinic,strpos($movitras[$keyMoviTras],'|',$posiinic) - $posiinic);
                    $descBodeFuen = $this->movitrasl->descBodega($idBodeFuen);
                    $descBodeFuen = $descBodeFuen[0]['bodega_nombre'];
                    $posiinic = strpos($movitras[$keyMoviTras],'|',$posiinic) + 1;

                    $idBodeDest = substr($movitras[$keyMoviTras],$posiinic,strpos($movitras[$keyMoviTras],'|',$posiinic) - $posiinic);
                    $descBodeDest = $this->movitrasl->descBodega($idBodeDest);
                    $descBodeDest = $descBodeDest[0]['bodega_nombre'];
                    $posiinic = strpos($movitras[$keyMoviTras],'|',$posiinic) + 1;
                    
                    $idIngrediente = substr($movitras[$keyMoviTras],$posiinic,strpos($movitras[$keyMoviTras],'|',$posiinic) - $posiinic);
                    $descIngrediente = $this->movitrasl->descIngrediente($idIngrediente);
                    $descIngrediente = $descIngrediente[0]['ingrediente_nombre'];
                    $posiinic = strpos($movitras[$keyMoviTras],'|',$posiinic) + 1;

                    $movitrasCantidad = substr($movitras[$keyMoviTras],$posiinic,strpos($movitras[$keyMoviTras],'|',$posiinic) - $posiinic);
                    $posiinic = strpos($movitras[$keyMoviTras],'|',$posiinic) + 1;
                    
                    $movitrasObservacion = substr($movitras[$keyMoviTras],$posiinic,strpos($movitras[$keyMoviTras],'|',$posiinic) - $posiinic);
                    $posiinic = strpos($movitras[$keyMoviTras],'|',$posiinic) + 1;
                    
                    $movitrasFechaRegi = substr($movitras[$keyMoviTras],$posiinic,strpos($movitras[$keyMoviTras],'|',$posiinic) - $posiinic);
                    $posiinic = strpos($movitras[$keyMoviTras],'|',$posiinic) + 1;

                    $idPersona = substr($movitras[$keyMoviTras],$posiinic,strpos($movitras[$keyMoviTras],'|',$posiinic) - $posiinic);
                    $descPersona= $this->movitrasl->descPersona($idPersona);
                    $descPersona = $descPersona[0]['persona_nombre'];
                    $posiinic = strpos($movitras[$keyMoviTras],'|',$posiinic) + 1;

                    $imprMoviTras.="<tr>";
                    $imprMoviTras.="<td>".$idMoviTras."</td>";
                    $imprMoviTras.="<td>".$idBodeFuen."</td>";
                    $imprMoviTras.="<td>".$descBodeFuen."</td>";
                    $imprMoviTras.="<td>".$idBodeDest."</td>";
                    $imprMoviTras.="<td>".$descBodeDest."</td>";
                    $imprMoviTras.="<td>".$idIngrediente."</td>";
                    $imprMoviTras.="<td>".$descIngrediente."</td>";
                    $imprMoviTras.="<td>".$movitrasCantidad."</td>";
                    $imprMoviTras.="<td>".$movitrasObservacion."</td>";
                    $imprMoviTras.="<td>".$movitrasFechaRegi."</td>";
                    $imprMoviTras.="<td>".$descPersona."</td>";
                    $imprMoviTras.="</tr>";
                    $posiinic = 0;
                }
                $cargaForma.=$imprMoviTras;
                $imprMoviTras   = '';
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
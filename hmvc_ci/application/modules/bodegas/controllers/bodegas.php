<?php if (! defined('BASEPATH')) exit('No direct script access allowed');
 
class Bodegas extends MX_Controller {
    
    function __construct(){
        parent::__construct();
        $this->urlBase = base_url();
    }
 
    function index(){
        echo("bodegas.index");
    }
	
    function crearBodega(){
        if($this->session->userdata('logged_in')){
            //Se cargan los Estados desde el modelo Bodega
            $this->load->model('bodega');
            $estados    = $this->bodega->listaEstados();
            $generos    = $this->bodega->listaGeneros();
            $ciudades   = $this->bodega->listaCiudades();
            $imprOpci   = "";
            $imprCiudad = "";
            $cargaForma = "<div class='row'>
                     <!-- page header -->
                    <div class='col-lg-12'>
                        <h1 class='page-header'>Crear Bodega</h1>
                    </div>
                    <!--end page header -->
                </div>
                <div class='row'>
                    <div class='col-lg-12'>
                        <!-- Form Elements -->
                        <div class='panel panel-default'>
                            <div class='panel-heading'>
                                Registro de Bodegas
                            </div>
                            <div class='panel-body'>
                                <div class='row'>
                                    <div class='col-lg-6'>
                                        <form role='form'>
                                            <div class='form-group'>
                                                <label>Código Bodega</label>
                                                <input id='id-bodega' class='form-control' placeholder='Identificador único de la Bodega.'>
                                            </div>
                                            <div class='form-group'>
                                                <label>Estados</label>
                                                <select id='bodega-estado' class='form-control'>";

            foreach ($estados as $keyEstado=>$estado){
                //Se acumula el html para las opciones
                $imprOpci.="<option>".$estados[$keyEstado]."</option>"
                           . "";
            }
            $cargaForma.=$imprOpci;
            $imprOpci   = '';
            $cargaForma.="</select>
                                            </div>

                                            <button id='btn-guardar' href='#' onclick=\"insertaBodega('$this->urlBase')\" type='submit' class='btn btn-primary'>Guardar</button>
                                            <button type='reset' class='btn btn-success'>Cancelar</button>
                                        </form>
                                    </div>
                                    <div class='col-lg-6'>
                                        <form role='form'>
                                            <div class='form-group'>
                                                <label>Nombre Bodega</label>
                                                <input id='bodega-nombre' class='form-control' placeholder='Descripción de la Bodega.'>
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
    
    function modificarBodega(){
        if($this->session->userdata('logged_in')){
            $this->load->model('bodega');
            $idBodega      = $_POST['idBodega'];
            $estados       = $this->bodega->listaEstados();
            $bodega        = $this->bodega->selModiBodega($idBodega);
            $id_bodega     = $bodega[0]['id_bodega'];
            $bodeNombre    = $bodega[0]['bodega_nombre'];
            $bodeEstado_id = $bodega[0]['bodega_estado_id'];
            $estado        = $this->bodega->selEstado($bodeEstado_id);
            $bodega_estado = $estado[0]['estado'];
            
            $imprOpci           = "";
            $cargaForma = "<div class='row'>
                     <!-- page header -->
                    <div class='col-lg-12'>
                        <h1 class='page-header'>Crear Bodega</h1>
                    </div>
                    <!--end page header -->
                </div>
                <div class='row'>
                    <div class='col-lg-12'>
                        <!-- Form Elements -->
                        <div class='panel panel-default'>
                            <div class='panel-heading'>
                                Registro de Bodegas
                            </div>
                            <div class='panel-body'>
                                <div class='row'>
                                    <div class='col-lg-6'>
                                        <form role='form'>
                                            <div class='form-group'>
                                                <label>Código Bodega</label>
                                                <input id='id-bodega' class='form-control' placeholder='Identificador único de la Bodega.' value='$id_bodega' disabled>
                                            </div>
                                            <div class='form-group'>
                                                <label>Estados</label>
                                                <select id='bodega-estado' class='form-control'>";

            foreach ($estados as $keyEstado=>$estado){
                //Se acumula el html para las opciones
                if($bodega_estado == $estados[$keyEstado]){
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

                                            <button id='btn-guardar' href='#' onclick=\"actualizaBodega('$this->urlBase')\" type='submit' class='btn btn-primary'>Guardar</button>
                                            <button type='reset' class='btn btn-success'>Cancelar</button>
                                        </form>
                                    </div>
                                    <div class='col-lg-6'>
                                        <form role='form'>
                                            <div class='form-group'>
                                                <label>Nombre Bodega</label>
                                                <input id='bodega-nombre' class='form-control' placeholder='Descripción de la Bodega.' value='$bodeNombre'>
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
    
    //Carga el formulario de consulta de los bodegas.
    function consultarBodega(){
        if($this->session->userdata('logged_in')){
            $valorBode = "";
            $this->load->model('bodega');
            $bodegas    = $this->bodega->consBodega($valorBode);
            $imprBodega = "";
                $cargaForma  = "<div class='row' onload='consultaBodega('$this->urlBase')'>
                        <!-- Page Header -->
                        <div class='col-lg-12'>
                            <h1 class='page-header'>Consultar Bodega</h1>
                        </div>
                        <!--End Page Header -->
                    </div>
                    <div class='row'>
                        <div class='col-lg-12'>
                            <!-- Advanced Tables -->
                            <div class='panel panel-default'>
                                <div class='panel-heading'>
                                     Consulta de Bodegas
                                </div>
                                <div class='panel-body'>
                                    <div class='table-responsive'>
                                        <div id='dataTables-example_wrapper' class='dataTables_wrapper form-inline' role='grid'>
                                            <div class='row'>
                                                <div class='col-sm-6'>
                                                    <!-- search section-->
                                                    <div id='dataTables-example_filter' class='dataTables_filter'>
                                                        <span class='input-group-btn'>
                                                            <input type='search' id='bodega-valor' class='form-control input-sm' aria-controls='dataTables-example' placeholder='Buscar'>
                                                            <button id='busca-bodega' class='btn btn-default' onclick=\"consultaBodega('$this->urlBase')\" type='submit'><i class='fa fa-search'></i></button>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div id='bodegas' class='row'>
                                                <div class='form-group'>
                                                    <div id='lista'>
                                                        <table class='table table-bordered'width='100%'  border='0' cellspacing='0' cellpadding='0' style='font-size:10px'>
                                                            <thead>
                                                                <tr>
                                                                    <th>Código</th>
                                                                    <th>Nombre</th>
                                                                    <th>Estado</th>
                                                                </tr>
                                                            </thead>";
            if($bodegas != false){
                $imprBodega = "";
                $cargaForma.= "<tbody>";
                $posiinic = 0;                                                
                foreach ($bodegas as $keyBodega=>$bodega){
                    //Se acumula el html para los bodegas
                    $idBodega = substr($bodegas[$keyBodega],$posiinic,strpos($bodegas[$keyBodega],'|',$posiinic) - $posiinic);
                    $posiinic = strpos($bodegas[$keyBodega],'|',$posiinic) + 1;

                    $bodegaNombre = substr($bodegas[$keyBodega],$posiinic,strpos($bodegas[$keyBodega],'|',$posiinic) - $posiinic);
                    $posiinic = strpos($bodegas[$keyBodega],'|',$posiinic) + 1;

                    $bodegaEstado = substr($bodegas[$keyBodega],$posiinic,strpos($bodegas[$keyBodega],'|',$posiinic) - $posiinic);
                    $descEstado = $this->bodega->descEstado($bodegaEstado);
                    $descEstado = $descEstado[0]['estado_descripcion'];
                    $posiinic = strpos($bodegas[$keyBodega],'|',$posiinic) + 1;

                    $imprBodega.="<tr>";
                    $imprBodega.="<td>".$idBodega."</td>";
                    $imprBodega.="<td>".$bodegaNombre."</td>";
                    $imprBodega.="<td>".$descEstado."</td>";
                    $imprBodega.="<td><button id='btn-modificar' href='#' onclick=\"modificaBodega('$this->urlBase','$idBodega')\" type='submit' class='btn btn-default btn-circle'><i class='fa fa-pencil'></i></button></td>";
                    $imprBodega.="<td><button id='btn-eliminar' href='#' onclick=\"borraBodega('$this->urlBase','$idBodega')\" type='submit' class='btn btn-danger btn-circle'><i class='fa fa-times'></i></button></td>";
                    $imprBodega.="</tr>";
                    $posiinic = 0;
                }
                $cargaForma.=$imprBodega;
                $imprBodega   = '';
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
    
    //Recarga el formulario de consulta de los bodegas una vez eliminado algún bodega.
    function eliminarBodega(){
        if($this->session->userdata('logged_in')){
            $this->load->model('bodega');
            $idBodega = $_POST['idBodega'];
            $moviBode = $this->bodega->selMoviBode($idBodega);
            if($moviBode == 0){
                $ingreBode = $this->bodega->selIngrBode($idBodega);
                if($ingreBode == 0){
                    $moveBode = $this->bodega->selMoveBode($idBodega);
                    if($moveBode == 0){
                        $bodegas  = $this->bodega->borBodega($idBodega);
                        $cargaForma = "<div class='form-group'>
                                                        <div id='lista'>
                                                            <table class='table table-bordered'width='100%'  border='0' cellspacing='0' cellpadding='0' style='font-size:10px'>
                                                                <thead>
                                                                    <tr>
                                                                        <th>Código</th>
                                                                        <th>Nombre</th>
                                                                        <th>Estado</th>
                                                                    </tr>
                                                                </thead>";
                        if($bodegas != false){
                            $imprBodega = "";
                            $cargaForma.= "<tbody>";
                            $posiinic = 0;                                                
                            foreach ($bodegas as $keyBodega=>$bodega){
                                //Se acumula el html para los bodegas
                                $idBodega = substr($bodegas[$keyBodega],$posiinic,strpos($bodegas[$keyBodega],'|',$posiinic) - $posiinic);
                                $posiinic = strpos($bodegas[$keyBodega],'|',$posiinic) + 1;

                                $bodegaNombre = substr($bodegas[$keyBodega],$posiinic,strpos($bodegas[$keyBodega],'|',$posiinic) - $posiinic);
                                $posiinic = strpos($bodegas[$keyBodega],'|',$posiinic) + 1;

                                $bodegaEstado = substr($bodegas[$keyBodega],$posiinic,strpos($bodegas[$keyBodega],'|',$posiinic) - $posiinic);
                                $descEstado = $this->bodega->descEstado($bodegaEstado);
                                $descEstado = $descEstado[0]['estado_descripcion'];
                                $posiinic = strpos($bodegas[$keyBodega],'|',$posiinic) + 1;

                                $imprBodega.="<tr>";
                                $imprBodega.="<td>".$idBodega."</td>";
                                $imprBodega.="<td>".$bodegaNombre."</td>";
                                $imprBodega.="<td>".$descEstado."</td>";
                                $imprBodega.="<td><button id='btn-modificar' href='#' onclick=\"modificaBodega('$this->urlBase','$idBodega')\" type='submit' class='btn btn-default btn-circle'><i class='fa fa-pencil'></i></button></td>";
                                $imprBodega.="<td><button id='btn-eliminar' href='#' onclick=\"borraBodega('$this->urlBase','$idBodega')\" type='submit' class='btn btn-danger btn-circle'><i class='fa fa-times'></i></button></td>";
                                $imprBodega.="</tr>";
                                $posiinic = 0;
                            }
                            $cargaForma.=$imprBodega;
                            $imprBodega   = '';
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
                        echo("movebode");
                    }
                }
                else{
                    echo("ingrebode");
                }
            }
            else{
                echo("movibode");
            }
        }
        else{
            echo('No se ha logueado');
            redirect('contenedor');
        }
    }
    
    function guardarBodega(){
        $this->load->model('bodega');
        $codigoBode = $_POST['idBode'];
        $nombreBode = $_POST['nombreBode'];
        $estadoBode = $_POST['estadoBode'];
        $estadoCodi = substr($estadoBode,0,strpos($estadoBode,'-',0) - 1);
        $bodega     = $this->bodega->insBodega($codigoBode,$nombreBode,$estadoCodi);
        if(isset($bodega)){
            echo("true");
        }
        else{
            echo("false");
        }
    }
    
    function obtenerBodega(){
        $this->load->model('bodega');
        $idBodega     = $_POST['idBodega'];
        $nombreBodega = $_POST['nombreBodega'];
        $operacion    = $_POST['operacion'];
        $bodega       = $this->bodega->selBodega($idBodega,$nombreBodega,$operacion);
        if($bodega == 0){
            echo("true");
        }
        else{
            echo("false");
        }
    }
    
    //Invoca el modelo de actualización de bodegas.
    function actualizarBodega(){
        if($this->session->userdata('logged_in')){
            $this->load->model('bodega');
            $idBodega      = $_POST['idBodega'];
            $nombreBodega  = $_POST['nombreBodega'];
            $estadoBodega  = $_POST['estadoBodega'];
            $estadoCodi    = substr($estadoBodega,0,strpos($estadoBodega,'-',0) - 1);
            $bodega        = $this->bodega->updBodega($idBodega,$nombreBodega,$estadoCodi);
            if($bodega){
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
    
    //Recarga el formulario de consulta de las bodegas a partir del criterio de búsqueda dado.
    function seleccionarBodega(){
        if($this->session->userdata('logged_in')){
            $this->load->model('bodega');
            $valorBode = $_POST['bodega_valor'];
            $bodegas  = $this->bodega->consBodega($valorBode);
            $imprBodega = "";
            $cargaForma = "<div class='form-group'>
                                            <div id='lista'>
                                                <table class='table table-bordered'width='100%'  border='0' cellspacing='0' cellpadding='0' style='font-size:10px'>
                                                    <thead>
                                                        <tr>
                                                            <th>Código</th>
                                                            <th>Nombre</th>
                                                            <th>Estado</th>
                                                        </tr>
                                                    </thead>";
            if($bodegas != false){
                $imprBodega = "";
                $cargaForma.= "<tbody>";
                $posiinic = 0;                                                
                foreach ($bodegas as $keyBodega=>$bodega){
                    //Se acumula el html para los bodegas
                    $idBodega = substr($bodegas[$keyBodega],$posiinic,strpos($bodegas[$keyBodega],'|',$posiinic) - $posiinic);
                    $posiinic = strpos($bodegas[$keyBodega],'|',$posiinic) + 1;

                    $bodegaNombre = substr($bodegas[$keyBodega],$posiinic,strpos($bodegas[$keyBodega],'|',$posiinic) - $posiinic);
                    $posiinic = strpos($bodegas[$keyBodega],'|',$posiinic) + 1;

                    $bodegaEstado = substr($bodegas[$keyBodega],$posiinic,strpos($bodegas[$keyBodega],'|',$posiinic) - $posiinic);
                    $descEstado = $this->bodega->descEstado($bodegaEstado);
                    $descEstado = $descEstado[0]['estado_descripcion'];
                    $posiinic = strpos($bodegas[$keyBodega],'|',$posiinic) + 1;

                    $imprBodega.="<tr>";
                    $imprBodega.="<td>".$idBodega."</td>";
                    $imprBodega.="<td>".$bodegaNombre."</td>";
                    $imprBodega.="<td>".$descEstado."</td>";
                    $imprBodega.="<td><button id='btn-modificar' href='#' onclick=\"modificaBodega('$this->urlBase','$idBodega')\" type='submit' class='btn btn-default btn-circle'><i class='fa fa-pencil'></i></button></td>";
                    $imprBodega.="<td><button id='btn-eliminar' href='#' onclick=\"borraBodega('$this->urlBase','$idBodega')\" type='submit' class='btn btn-danger btn-circle'><i class='fa fa-times'></i></button></td>";
                    $imprBodega.="</tr>";
                    $posiinic = 0;
                }
                $cargaForma.=$imprBodega;
                $imprBodega   = '';
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
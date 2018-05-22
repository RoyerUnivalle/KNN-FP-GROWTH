<?php if (! defined('BASEPATH')) exit('No direct script access allowed');
 
class Categorias extends MX_Controller {
    
    function __construct(){
        parent::__construct();
        $this->urlBase = base_url();
    }
 
    function index(){
        echo("categorias.index");
    }
	
    function crearCategoria(){
        if($this->session->userdata('logged_in')){    
            //Se cargan los Estados desde el modelo Categoria
            $this->load->model('categoria');
            $estados = $this->categoria->listaEstados();
            $imprOpci ="";
            $cargaForma = "<div class='row'>
                     <!-- page header -->
                    <div class='col-lg-12'>
                        <h1 class='page-header'>Crear Categoría</h1>
                    </div>
                    <!--end page header -->
                </div>
                <div class='row'>
                    <div class='col-lg-12'>
                        <!-- Form Elements -->
                        <div class='panel panel-default'>
                            <div class='panel-heading'>
                                Registro de Categorías
                            </div>
                            <div class='panel-body'>
                                <div class='row'>
                                    <div class='col-lg-6'>
                                        <form role='form'>
                                            <div class='form-group'>
                                                <label>Nombre</label>
                                                <input id='categoria-nombre' class='form-control' placeholder='Descripción de la Categoría.'>
                                            </div>
                                            <button id='btn-guardar' href='#' onclick=\"insertaCategoria('$this->urlBase')\" type='submit' class='btn btn-primary'>Guardar</button>
                                            <button type='reset' class='btn btn-success'>Cancelar</button>
                                        </form>
                                    </div>
                                    <div class='col-lg-6'>
                                        <form role='form'>
                                            <div class='form-group'>
                                                <label>Estado</label>
                                                <select id='categoria-estado' class='form-control'>";

            foreach ($estados as $keyEstado=>$estado){
                //Se acumula el html para las opciones
                $imprOpci.="<option>".$estados[$keyEstado]."</option>"
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
            echo $cargaForma;}
        else{
            echo('No se ha logueado');
            redirect('contenedor');
        }
    }
    
    function modificarCategoria(){
        if($this->session->userdata('logged_in')){
            $this->load->model('categoria');
            $idCategoria         = $_POST['idCategoria'];
            $estados             = $this->categoria->listaEstados();
            $categoria           = $this->categoria->selModiCategoria($idCategoria);
            $id_categoria        = $categoria[0]['id_categoria'];
            $categoria_nombre    = $categoria[0]['categoria_nombre'];
            $categoria_estado_id = $categoria[0]['categoria_estado_id'];
            $estado              = $this->categoria->selEstado($categoria_estado_id);
            $categoria_estado    = $estado[0]['estado'];
            $imprOpci            = "";
            $cargaForma = "<div class='row'>
                     <!-- page header -->
                    <div class='col-lg-12'>
                        <h1 class='page-header'>Modificar Categoría</h1>
                    </div>
                    <!--end page header -->
                </div>
                <div class='row'>
                    <div class='col-lg-12'>
                        <!-- Form Elements -->
                        <div class='panel panel-default'>
                            <div class='panel-heading'>
                                Modificación de Categorías
                            </div>
                            <div class='panel-body'>
                                <div class='row'>
                                    <div class='col-lg-6'>
                                        <form role='form'>
                                            <div class='form-group'>
                                                <label>Código</label>
                                                <input id='id-categoria' class='form-control' placeholder='Descripción de la Categoría.' value='$idCategoria' disabled>
                                            </div>
                                            <div class='form-group'>
                                                <label>Estado</label>
                                                <select id='categoria-estado' class='form-control'>";

            foreach ($estados as $keyEstado=>$estado){
                //Se acumula el html para las opciones
                if($categoria_estado == $estados[$keyEstado]){
                    $imprOpci.="<option selected>".$estados[$keyEstado]."</option>";
                }
                else{
                    $imprOpci.="<option>".$estados[$keyEstado]."</option>";
                }
            }
            $cargaForma.=$imprOpci;
            $cargaForma.="</select>
                                            </div>
                                            <button id='btn-guardar' href='#' onclick=\"actualizaCategoria('$this->urlBase')\" type='submit' class='btn btn-primary'>Guardar</button>
                                            <button type='reset' class='btn btn-success'>Cancelar</button>
                                        </form>
                                    </div>
                                    <div class='col-lg-6'>
                                        <form role='form'>
                                            <div class='form-group'>
                                                <label>Nombre</label>
                                                <input id='categoria-nombre' class='form-control' placeholder='Descripción de la Categoría.' value='$categoria_nombre'>
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
    
    //Carga el formulario de consulta de los categorias.
    function consultarCategoria(){
        if($this->session->userdata('logged_in')){
            $valorCate = "";
            $this->load->model('categoria');
            $categorias    = $this->categoria->consCategoria($valorCate);
            $imprCategoria = "";
                $cargaForma  = "<div class='row' onload='consultaCategoria('$this->urlBase')'>
                        <!-- Page Header -->
                        <div class='col-lg-12'>
                            <h1 class='page-header'>Consultar Categoría</h1>
                        </div>
                        <!--End Page Header -->
                    </div>
                    <div class='row'>
                        <div class='col-lg-12'>
                            <!-- Advanced Tables -->
                            <div class='panel panel-default'>
                                <div class='panel-heading'>
                                     Consulta de Categorías
                                </div>
                                <div class='panel-body'>
                                    <div class='table-responsive'>
                                        <div id='dataTables-example_wrapper' class='dataTables_wrapper form-inline' role='grid'>
                                            <div class='row'>
                                                <div class='col-sm-6'>
                                                    <!-- search section-->
                                                    <div id='dataTables-example_filter' class='dataTables_filter'>
                                                        <span class='input-group-btn'>
                                                            <input type='search' id='categoria-valor' class='form-control input-sm' aria-controls='dataTables-example' placeholder='Buscar'>
                                                            <button id='busca-categoria' class='btn btn-default' onclick=\"consultaCategoria('$this->urlBase')\" type='submit'><i class='fa fa-search'></i></button>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div id='categorias' class='row'>
                                                <div class='form-group'>
                                                    <div id='lista'>
                                                        <table class='table table-bordered'width='100%'  border='0' cellspacing='0' cellpadding='0' style='font-size:10px'>
                                                            <thead>
                                                                <tr>
                                                                    <th>Código</th>
                                                                    <th>Nombre</th>
                                                                    <th>Fecha Registro</th>
                                                                    <th>Persona Registra</th>
                                                                    <th>Estado</th>
                                                                </tr>
                                                            </thead>";
            if($categorias != false){
                $imprCategoria = "";
                $cargaForma.= "<tbody>";
                $posiinic = 0;                                                
                foreach ($categorias as $keyCategoria=>$categoria){
                    //Se acumula el html para los categorias
                    $idCategoria = substr($categorias[$keyCategoria],$posiinic,strpos($categorias[$keyCategoria],'|',$posiinic) - $posiinic);
                    $posiinic = strpos($categorias[$keyCategoria],'|',$posiinic) + 1;

                    $categoriaNombre = substr($categorias[$keyCategoria],$posiinic,strpos($categorias[$keyCategoria],'|',$posiinic) - $posiinic);
                    $posiinic = strpos($categorias[$keyCategoria],'|',$posiinic) + 1;

                    $categoriaFechaRegi = substr($categorias[$keyCategoria],$posiinic,strpos($categorias[$keyCategoria],'|',$posiinic) - $posiinic);
                    $posiinic = strpos($categorias[$keyCategoria],'|',$posiinic) + 1;

                    $categoriaPersona = substr($categorias[$keyCategoria],$posiinic,strpos($categorias[$keyCategoria],'|',$posiinic) - $posiinic);
                    $posiinic = strpos($categorias[$keyCategoria],'|',$posiinic) + 1;

                    $categoriaEstado = substr($categorias[$keyCategoria],$posiinic,strpos($categorias[$keyCategoria],'|',$posiinic) - $posiinic);
                    $descEstado = $this->categoria->descEstado($categoriaEstado);
                    $descEstado = $descEstado[0]['estado_descripcion'];
                    $posiinic = strpos($categorias[$keyCategoria],'|',$posiinic) + 1;

                    $imprCategoria.="<tr>";
                    $imprCategoria.="<td>".$idCategoria."</td>";
                    $imprCategoria.="<td>".$categoriaNombre."</td>";
                    $imprCategoria.="<td>".$categoriaFechaRegi."</td>";
                    $imprCategoria.="<td>".$categoriaPersona."</td>";
                    $imprCategoria.="<td>".$descEstado."</td>";
                    $imprCategoria.="<td><button id='btn-modificar' href='#' onclick=\"modificaCategoria('$this->urlBase','$idCategoria')\" type='submit' class='btn btn-default btn-circle'><i class='fa fa-pencil'></i></button></td>";
                    $imprCategoria.="<td><button id='btn-eliminar' href='#' onclick=\"borraCategoria('$this->urlBase','$idCategoria')\" type='submit' class='btn btn-danger btn-circle'><i class='fa fa-times'></i></button></td>";
                    $imprCategoria.="</tr>";
                    $posiinic = 0;
                }
                $cargaForma.=$imprCategoria;
                $imprCategoria   = '';
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
    
    //Recarga el formulario de consulta de los categorias una vez eliminado algún categoria.
    function eliminarCategoria(){
        if($this->session->userdata('logged_in')){
            $this->load->model('categoria');
            $idCategoria = $_POST['idCategoria'];
            $cateProd    = $this->categoria->selCateProd($idCategoria);
            if($cateProd == 0){
                $categorias  = $this->categoria->borCategoria($idCategoria);
                $cargaForma  = "<div class='form-group'>
                                                        <div id='lista'>
                                                            <table class='table table-bordered'width='100%'  border='0' cellspacing='0' cellpadding='0' style='font-size:10px'>
                                                                <thead>
                                                                    <tr>
                                                                        <th>Código</th>
                                                                        <th>Nombre</th>
                                                                        <th>Fecha Registro</th>
                                                                        <th>Persona Registra</th>
                                                                        <th>Estado</th>
                                                                    </tr>
                                                                </thead>";
                if($categorias != false){
                    $imprCategoria = "";
                    $cargaForma.= "<tbody>";
                    $posiinic = 0;                                                
                    foreach ($categorias as $keyCategoria=>$categoria){
                        //Se acumula el html para los categorias
                        $idCategoria = substr($categorias[$keyCategoria],$posiinic,strpos($categorias[$keyCategoria],'|',$posiinic) - $posiinic);
                        $posiinic = strpos($categorias[$keyCategoria],'|',$posiinic) + 1;

                        $categoriaNombre = substr($categorias[$keyCategoria],$posiinic,strpos($categorias[$keyCategoria],'|',$posiinic) - $posiinic);
                        $posiinic = strpos($categorias[$keyCategoria],'|',$posiinic) + 1;

                        $categoriaFechaRegi = substr($categorias[$keyCategoria],$posiinic,strpos($categorias[$keyCategoria],'|',$posiinic) - $posiinic);
                        $posiinic = strpos($categorias[$keyCategoria],'|',$posiinic) + 1;

                        $categoriaPersona = substr($categorias[$keyCategoria],$posiinic,strpos($categorias[$keyCategoria],'|',$posiinic) - $posiinic);
                        $posiinic = strpos($categorias[$keyCategoria],'|',$posiinic) + 1;

                        $categoriaEstado = substr($categorias[$keyCategoria],$posiinic,strpos($categorias[$keyCategoria],'|',$posiinic) - $posiinic);
                        $descEstado = $this->categoria->descEstado($categoriaEstado);
                        $descEstado = $descEstado[0]['estado_descripcion'];
                        $posiinic = strpos($categorias[$keyCategoria],'|',$posiinic) + 1;

                        $imprCategoria.="<tr>";
                        $imprCategoria.="<td>".$idCategoria."</td>";
                        $imprCategoria.="<td>".$categoriaNombre."</td>";
                        $imprCategoria.="<td>".$categoriaFechaRegi."</td>";
                        $imprCategoria.="<td>".$categoriaPersona."</td>";
                        $imprCategoria.="<td>".$descEstado."</td>";
                        $imprCategoria.="<td><button id='btn-modificar' href='#' onclick=\"modificaCategoria('$this->urlBase','$idCategoria')\" type='submit' class='btn btn-default btn-circle'><i class='fa fa-pencil'></i></button></td>";
                        $imprCategoria.="<td><button id='btn-eliminar' href='#' onclick=\"borraCategoria('$this->urlBase','$idCategoria')\" type='submit' class='btn btn-danger btn-circle'><i class='fa fa-times'></i></button></td>";
                        $imprCategoria.="</tr>";
                        $posiinic = 0;
                    }
                    $cargaForma.=$imprCategoria;
                    $imprCategoria   = '';
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
                echo("cateprod");
            }
        }
        else{
            echo('No se ha logueado');
            redirect('contenedor');
        }
    }
    
    function guardarCategoria(){
        $this->load->model('categoria');
        $nombreCate      = $_POST['nombreCate'];
        $estadoCate      = $_POST['estadoCate'];
        $estadoCodi      = substr($estadoCate,0,strpos($estadoCate,'-',0) - 1);
        $personaCate     = $this->session->userdata('idPers');
        $categoria       = $this->categoria->insCategoria($nombreCate,$personaCate,$estadoCodi);
        if(isset($categoria)){
            echo("true");
        }
        else{
            echo("false");
        }
    }
    
    function obtenerCategoria(){
        $this->load->model('categoria');
        $idCategoria = $_POST['idCategoria'];
        $nombreCate  = $_POST['nombreCategoria'];
        $categoria   = $this->categoria->selCategoria($idCategoria,$nombreCate);
        if($categoria == 0){
            echo("true");
        }
        else{
            echo("false");
        }
    }
    
    //Invoca el modelo de actualización de categorias.
    function actualizarCategoria(){
        if($this->session->userdata('logged_in')){
            $this->load->model('categoria');
            $idCategoria     = $_POST['idCategoria'];
            $nombreCategoria = $_POST['nombreCategoria'];
            $estadoCategoria = $_POST['estadoCategoria'];
            $estadoCodi      = substr($estadoCategoria,0,strpos($estadoCategoria,'-',0) - 1);
            $categoria       = $this->categoria->updCategoria($idCategoria,$nombreCategoria,$estadoCodi);
            if($categoria){
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
    
    //Recarga el formulario de consulta de los categorias a partir del criterio de búsqueda dado.
    function seleccionarCategoria(){
        if($this->session->userdata('logged_in')){
            $this->load->model('categoria');
            $valorCate = $_POST['categoria_valor'];
            $categorias  = $this->categoria->consCategoria($valorCate);
            $imprCategoria = "";
            $cargaForma  = "<div class='form-group'>
                                                        <div id='lista'>
                                                            <table class='table table-bordered'width='100%'  border='0' cellspacing='0' cellpadding='0' style='font-size:10px'>
                                                                <thead>
                                                                    <tr>
                                                                        <th>Código</th>
                                                                        <th>Nombre</th>
                                                                        <th>Fecha Registro</th>
                                                                        <th>Persona Registra</th>
                                                                        <th>Estado</th>
                                                                    </tr>
                                                                </thead>";
            if($categorias != false){
                $imprCategoria = "";
                $cargaForma.= "<tbody>";
                $posiinic = 0;                                                
                foreach ($categorias as $keyCategoria=>$categoria){
                    //Se acumula el html para los categorias
                    $idCategoria = substr($categorias[$keyCategoria],$posiinic,strpos($categorias[$keyCategoria],'|',$posiinic) - $posiinic);
                    $posiinic = strpos($categorias[$keyCategoria],'|',$posiinic) + 1;

                    $categoriaNombre = substr($categorias[$keyCategoria],$posiinic,strpos($categorias[$keyCategoria],'|',$posiinic) - $posiinic);
                    $posiinic = strpos($categorias[$keyCategoria],'|',$posiinic) + 1;

                    $categoriaFechaRegi = substr($categorias[$keyCategoria],$posiinic,strpos($categorias[$keyCategoria],'|',$posiinic) - $posiinic);
                    $posiinic = strpos($categorias[$keyCategoria],'|',$posiinic) + 1;

                    $categoriaPersona = substr($categorias[$keyCategoria],$posiinic,strpos($categorias[$keyCategoria],'|',$posiinic) - $posiinic);
                    $posiinic = strpos($categorias[$keyCategoria],'|',$posiinic) + 1;

                    $categoriaEstado = substr($categorias[$keyCategoria],$posiinic,strpos($categorias[$keyCategoria],'|',$posiinic) - $posiinic);
                    $descEstado = $this->categoria->descEstado($categoriaEstado);
                    $descEstado = $descEstado[0]['estado_descripcion'];
                    $posiinic = strpos($categorias[$keyCategoria],'|',$posiinic) + 1;

                    $imprCategoria.="<tr>";
                    $imprCategoria.="<td>".$idCategoria."</td>";
                    $imprCategoria.="<td>".$categoriaNombre."</td>";
                    $imprCategoria.="<td>".$categoriaFechaRegi."</td>";
                    $imprCategoria.="<td>".$categoriaPersona."</td>";
                    $imprCategoria.="<td>".$descEstado."</td>";
                    $imprCategoria.="<td><button id='btn-modificar' href='#' onclick=\"modificaCategoria('$this->urlBase','$idCategoria')\" type='submit' class='btn btn-default btn-circle'><i class='fa fa-pencil'></i></button></td>";
                    $imprCategoria.="<td><button id='btn-eliminar' href='#' onclick=\"borraCategoria('$this->urlBase','$idCategoria')\" type='submit' class='btn btn-danger btn-circle'><i class='fa fa-times'></i></button></td>";
                    $imprCategoria.="</tr>";
                    $posiinic = 0;
                }
                $cargaForma.=$imprCategoria;
                $imprCategoria   = '';
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
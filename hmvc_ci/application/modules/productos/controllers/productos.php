<?php if (! defined('BASEPATH')) exit('No direct script access allowed');
 
class Productos extends MX_Controller {
    
    function __construct(){
        parent::__construct();
        $this->urlBase = base_url();
    }
 
    function index(){
        echo("productos.index");
    }
	
    function crearProducto(){
        //Se cargan los Estados desde el modelo Producto
        $this->load->model('producto');
        $estados     = $this->producto->listaEstados();
        $categorias  = $this->producto->listaCategorias();
        $imprOpci    ="";
        $cargaForma  = "<div class='row'>
                 <!-- page header -->
                <div class='col-lg-12'>
                    <h1 class='page-header'>Crear Producto</h1>
                </div>
                <!--end page header -->
            </div>
            <div class='row'>
                <div class='col-lg-12'>
                    <!-- Form Elements -->
                    <div class='panel panel-default'>
                        <div class='panel-heading'>
                            Registro de Productos
                        </div>
                        <div class='panel-body'>
                            <div class='row'>
                                <div class='col-lg-6'>
                                    <form role='form'>
                                        <div class='form-group'>
                                            <label>Nombre</label>
                                            <input id='producto-nombre' class='form-control' placeholder='Descripción del Producto.'>
                                        </div>
                                        
                                        <div class='form-group'>
                                            <label>Estado</label>
                                            <select id='producto-estado' class='form-control'>";
        
        foreach ($estados as $keyEstado=>$estado){
            //Se acumula el html para las opciones
            $imprOpci.="<option>".$estados[$keyEstado]."</option>"
                       . "";
        }
        $cargaForma.=$imprOpci;
        $imprOpci = "";
        $cargaForma.="</select>
                                        </div>
                                        <button id='btn-guardar' href='#' onclick=\"insertaProducto('$this->urlBase')\" type='submit' class='btn btn-primary'>Guardar</button>
                                        <button type='reset' class='btn btn-success'>Cancelar</button>
                                    </form>
                                </div>
                                <div class='col-lg-6'>
                                    <form role='form'>
                                        <div class='form-group'>
                                            <label>Categoría</label>
                                            <select id='producto-categoria' class='form-control'>";
        
        foreach ($categorias as $keyCategoria=>$categoria){
            //Se acumula el html para las opciones
            $imprOpci.="<option>".$categorias[$keyCategoria]."</option>"
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
    
    
    function modificarProducto(){
        if($this->session->userdata('logged_in')){
            $this->load->model('producto');
            $idProducto               = $_POST['idProducto'];
            $unidades                 = $this->producto->listaUnidades();
            $categorias               = $this->producto->listaCategorias();
            $estados                  = $this->producto->listaEstados();
            
            $producto                 = $this->producto->selModiProducto($idProducto);
            $id_producto              = $producto[0]['id_producto'];
            $producto_nombre          = $producto[0]['producto_nombre'];
            $producto_categoria_id    = $producto[0]['producto_categoria_id'];
            $categoria                = $this->producto->selCategoria($producto_categoria_id);
            $producto_categoria       = $categoria[0]['categoria'];
            $producto_persona_id      = $producto[0]['producto_persona_id'];
            $persona                  = $this->producto->selPersona($producto_persona_id);
            $producto_estado_id       = $producto[0]['producto_estado_id'];
            $estado                   = $this->producto->selEstado($producto_estado_id);
            $producto_estado          = $estado[0]['estado'];
            $imprOpci                 = "";
            $ingreprodu               = $this->producto->consIngreProdu($idProducto,"");
            $cargaForma  = "<div class='row'>
                 <!-- page header -->
                <div class='col-lg-12'>
                    <h1 class='page-header'>Modificar Producto</h1>
                </div>
                <!--end page header -->
            </div>
            <div class='row'>
                <div class='col-lg-12'>
                    <!-- Form Elements -->
                    <div class='panel panel-default'>
                        <div class='panel-heading'>
                            Modificación de Productos
                        </div>
                        <div class='panel-body'>
                            <div class='row'>
                                <div class='col-lg-6'>
                                    <form role='form'>
                                        <div class='form-group'>
                                            <label>Código</label>
                                            <input id='id-producto' class='form-control' placeholder='Descripción del Producto.' value='$id_producto' disabled>
                                        </div>
                                        <div class='form-group'>
                                            <label>Categoría</label>
                                            <select id='producto-categoria' class='form-control'>";
        
            foreach ($categorias as $keyCategoria=>$categoria){
                //Se acumula el html para las opciones
                if($producto_categoria == $categorias[$keyCategoria]){
                    $imprOpci.="<option selected>".$producto_categoria."</option>";
                }
                else{
                    $imprOpci.="<option>".$categorias[$keyCategoria]."</option>";
                }
            }
            $cargaForma.=$imprOpci;
            $imprOpci = "";
            $cargaForma.="</select>
                                        </div>
                                        
                                        
                                        <button id='btn-guardar' href='#' onclick=\"actualizaProducto('$this->urlBase')\" type='submit' class='btn btn-primary'>Guardar</button>
                                        <button type='reset' class='btn btn-success'>Cancelar</button>
                                    </form>
                                </div>
                                <div class='col-lg-6'>
                                    <form role='form'>
                                        <div class='form-group'>
                                            <label>Nombre</label>
                                            <input id='producto-nombre' class='form-control' placeholder='Descripción del Producto.' value='$producto_nombre'>
                                        </div>
                                        <div class='form-group'>
                                            <label>Estado</label>
                                            <select id='producto-estado' class='form-control'>";
        
            foreach ($estados as $keyEstado=>$estado){
                //Se acumula el html para las opciones
                if($producto_estado == $estados[$keyEstado]){
                    $imprOpci.="<option selected>".$producto_estado."</option>";
                }
                else{
                    $imprOpci.="<option>".$estados[$keyEstado]."</option>";
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
                        
                        <div class='panel-heading'>
                            Modificación de Composición del Producto
                        </div>
                        <div class='panel-body'>
                                    <div class='table-responsive'>
                                        <div id='dataTables-example_wrapper' class='dataTables_wrapper form-inline' role='grid'>
                                            <div class='row'>
                                                <div class='col-sm-6'>
                                                    <!-- search section-->
                                                    <div id='dataTables-example_filter' class='dataTables_filter'>
                                                        <span class='input-group-btn'>
                                                            <input type='search' id='ingreprodu-valor' class='form-control input-sm' aria-controls='dataTables-example' placeholder='Buscar'>
                                                            <button id='busca-producto' class='btn btn-default' onclick=\"consultaIngreProdu('$this->urlBase')\" type='submit'><i class='fa fa-search'></i></button>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div id='ingreprodu' class='row'>
                                                <div class='form-group'>
                                                    <div id='lista'>
                                                        <table class='table table-bordered'width='100%'  border='0' cellspacing='0' cellpadding='0' style='font-size:10px'>
                                                            <thead>
                                                                <tr>
                                                                    <th>Código Ingrediente</th>
                                                                    <th>Nombre Ingrediente</th>
                                                                    <th>Unidad</th>
                                                                    <th>Cantidad</th>
                                                                    <th>Fecha Registro</th>
                                                                    <th>Persona Registra</th>
                                                                    <th>Estado</th>
                                                                </tr>
                                                            </thead>";
            if($ingreprodu != false){
                $imprProducto = "";
                $cargaForma.= "<tbody>";
                $posiinic = 0;                                                
                foreach ($ingreprodu as $keyIngreProdu=>$produingre){
                    //Se acumula el html para los productos
                    $idProducto = substr($ingreprodu[$keyIngreProdu],$posiinic,strpos($ingreprodu[$keyIngreProdu],'|',$posiinic) - $posiinic);
                    $posiinic = strpos($ingreprodu[$keyIngreProdu],'|',$posiinic) + 1;

                    $idIngrediente = substr($ingreprodu[$keyIngreProdu],$posiinic,strpos($ingreprodu[$keyIngreProdu],'|',$posiinic) - $posiinic);
                    $descIngrediente = $this->producto->descIngrediente($idIngrediente);
                    $descIngrediente = $descIngrediente[0]['ingrediente_nombre'];
                    $posiinic = strpos($ingreprodu[$keyIngreProdu],'|',$posiinic) + 1;

                    $idUnidad = substr($ingreprodu[$keyIngreProdu],$posiinic,strpos($ingreprodu[$keyIngreProdu],'|',$posiinic) - $posiinic);
                    $descUnidad = $this->producto->descUnidad($idUnidad);
                    $descUnidad = $descUnidad[0]['unidad_nombre'];
                    $posiinic = strpos($ingreprodu[$keyIngreProdu],'|',$posiinic) + 1;

                    $ingreproduCantidad = substr($ingreprodu[$keyIngreProdu],$posiinic,strpos($ingreprodu[$keyIngreProdu],'|',$posiinic) - $posiinic);
                    $posiinic = strpos($ingreprodu[$keyIngreProdu],'|',$posiinic) + 1;

                    $ingreproduFechaRegi = substr($ingreprodu[$keyIngreProdu],$posiinic,strpos($ingreprodu[$keyIngreProdu],'|',$posiinic) - $posiinic);
                    $posiinic = strpos($ingreprodu[$keyIngreProdu],'|',$posiinic) + 1;
                    
                    $ingreproduPersona = substr($ingreprodu[$keyIngreProdu],$posiinic,strpos($ingreprodu[$keyIngreProdu],'|',$posiinic) - $posiinic);
                    $posiinic = strpos($ingreprodu[$keyIngreProdu],'|',$posiinic) + 1;

                    $ingreproduEstado = substr($ingreprodu[$keyIngreProdu],$posiinic,strpos($ingreprodu[$keyIngreProdu],'|',$posiinic) - $posiinic);
                    $descEstado = $this->producto->descEstado($ingreproduEstado);
                    $descEstado = $descEstado[0]['estado_descripcion'];
                    $posiinic = strpos($ingreprodu[$keyIngreProdu],'|',$posiinic) + 1;

                    $imprProducto.="<tr>";
                    $imprProducto.="<td>".$idIngrediente."</td>";
                    $imprProducto.="<td>".$descIngrediente."</td>";
                    $imprProducto.="<td>".$descUnidad."</td>";
                    $imprProducto.="<td>".$ingreproduCantidad."</td>";
                    $imprProducto.="<td>".$ingreproduFechaRegi."</td>";
                    $imprProducto.="<td>".$ingreproduPersona."</td>";
                    $imprProducto.="<td>".$descEstado."</td>";
                    $imprProducto.="<td><button id='btn-modificar' href='#' onclick=\"modificaIngreProdu('$this->urlBase','$idProducto','$idIngrediente')\" type='submit' class='btn btn-default btn-circle'><i class='fa fa-pencil'></i></button></td>";
                    $imprProducto.="<td><button id='btn-eliminar' href='#' onclick=\"borraIngreProdu('$this->urlBase','$idProducto','$idIngrediente')\" type='submit' class='btn btn-danger btn-circle'><i class='fa fa-times'></i></button></td>";
                    $imprProducto.="</tr>";
                    $posiinic = 0;
                }
                $cargaForma.=$imprProducto;
                $imprProducto   = '';
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
    
    //Carga el formulario de consulta de los productos.
    function consultarProducto(){
        if($this->session->userdata('logged_in')){
            $valorProd = "";
            $this->load->model('producto');
            $productos    = $this->producto->consProducto($valorProd);
            $imprProducto = "";
            $cargaForma  = "<div class='row' onload='consultaProducto('$this->urlBase')'>
                        <!-- Page Header -->
                        <div class='col-lg-12'>
                            <h1 class='page-header'>Consultar Producto</h1>
                        </div>
                        <!--End Page Header -->
                    </div>
                    <div class='row'>
                        <div class='col-lg-12'>
                            <!-- Advanced Tables -->
                            <div class='panel panel-default'>
                                <div class='panel-heading'>
                                     Consulta de Productos
                                </div>
                                <div class='panel-body'>
                                    <div class='table-responsive'>
                                        <div id='dataTables-example_wrapper' class='dataTables_wrapper form-inline' role='grid'>
                                            <div class='row'>
                                                <div class='col-sm-6'>
                                                    <!-- search section-->
                                                    <div id='dataTables-example_filter' class='dataTables_filter'>
                                                        <span class='input-group-btn'>
                                                            <input type='search' id='producto-valor' class='form-control input-sm' aria-controls='dataTables-example' placeholder='Buscar'>
                                                            <button id='busca-producto' class='btn btn-default' onclick=\"consultaProducto('$this->urlBase')\" type='submit'><i class='fa fa-search'></i></button>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div id='productos' class='row'>
                                                <div class='form-group'>
                                                    <div id='lista'>
                                                        <table class='table table-bordered'width='100%'  border='0' cellspacing='0' cellpadding='0' style='font-size:10px'>
                                                            <thead>
                                                                <tr>
                                                                    <th>Código</th>
                                                                    <th>Nombre</th>
                                                                    <th>Categoría</th>
                                                                    <th>Fecha Registro</th>
                                                                    <th>Persona Registra</th>
                                                                    <th>Estado</th>
                                                                </tr>
                                                            </thead>";
            if($productos != false){
                $imprProducto = "";
                $cargaForma.= "<tbody>";
                $posiinic = 0;                                                
                foreach ($productos as $keyProducto=>$producto){
                    //Se acumula el html para los productos
                    $idProducto = substr($productos[$keyProducto],$posiinic,strpos($productos[$keyProducto],'|',$posiinic) - $posiinic);
                    $posiinic = strpos($productos[$keyProducto],'|',$posiinic) + 1;

                    $productoNombre = substr($productos[$keyProducto],$posiinic,strpos($productos[$keyProducto],'|',$posiinic) - $posiinic);
                    $posiinic = strpos($productos[$keyProducto],'|',$posiinic) + 1;

                    $productoCategoria = substr($productos[$keyProducto],$posiinic,strpos($productos[$keyProducto],'|',$posiinic) - $posiinic);
                    $descCategoria = $this->producto->descCategoria($productoCategoria);
                    $descCategoria = $descCategoria[0]['categoria_nombre'];
                    $posiinic = strpos($productos[$keyProducto],'|',$posiinic) + 1;

                    $productoFechaRegi = substr($productos[$keyProducto],$posiinic,strpos($productos[$keyProducto],'|',$posiinic) - $posiinic);
                    $posiinic = strpos($productos[$keyProducto],'|',$posiinic) + 1;

                    $productoPersona = substr($productos[$keyProducto],$posiinic,strpos($productos[$keyProducto],'|',$posiinic) - $posiinic);
                    $posiinic = strpos($productos[$keyProducto],'|',$posiinic) + 1;

                    $productoEstado = substr($productos[$keyProducto],$posiinic,strpos($productos[$keyProducto],'|',$posiinic) - $posiinic);
                    $descEstado = $this->producto->descEstado($productoEstado);
                    $descEstado = $descEstado[0]['estado_descripcion'];
                    $posiinic = strpos($productos[$keyProducto],'|',$posiinic) + 1;

                    $imprProducto.="<tr>";
                    $imprProducto.="<td>".$idProducto."</td>";
                    $imprProducto.="<td>".$productoNombre."</td>";
                    $imprProducto.="<td>".$descCategoria."</td>";
                    $imprProducto.="<td>".$productoFechaRegi."</td>";
                    $imprProducto.="<td>".$productoPersona."</td>";
                    $imprProducto.="<td>".$descEstado."</td>";
                    $imprProducto.="<td><button id='btn-modificar' href='#' onclick=\"modificaProducto('$this->urlBase','$idProducto')\" type='submit' class='btn btn-default btn-circle'><i class='fa fa-pencil'></i></button></td>";
                    $imprProducto.="<td><button id='btn-eliminar' href='#' onclick=\"borraProducto('$this->urlBase','$idProducto')\" type='submit' class='btn btn-danger btn-circle'><i class='fa fa-times'></i></button></td>";
                    $imprProducto.="</tr>";
                    $posiinic = 0;
                }
                $cargaForma.=$imprProducto;
                $imprProducto   = '';
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
    
    //Recarga el formulario de consulta de los productos una vez eliminado algún producto.
    function eliminarProducto(){
        if($this->session->userdata('logged_in')){
            $this->load->model('producto');
            $idProducto = $_POST['idProducto'];
            $moveProd   = $this->producto->selMoveProd($idProducto);
            if($moveProd == 0){
                $ingreProdu = $this->producto->selIngrProd($idProducto);
                if($ingreProdu == 0){
                    $productos  = $this->producto->borProducto($idProducto);
                    $cargaForma = "<div class='form-group'>
                                                            <div id='lista'>
                                                                <table class='table table-bordered'width='100%'  border='0' cellspacing='0' cellpadding='0' style='font-size:10px'>
                                                                    <thead>
                                                                        <tr>
                                                                            <th>Código</th>
                                                                            <th>Nombre</th>
                                                                            <th>Categoría</th>
                                                                            <th>Fecha Registro</th>
                                                                            <th>Persona Registra</th>
                                                                            <th>Estado</th>
                                                                        </tr>
                                                                    </thead>";
                    if($productos != false){
                        $imprProducto = "";
                        $cargaForma.= "<tbody>";
                        $posiinic = 0;                                                
                        foreach ($productos as $keyProducto=>$producto){
                            //Se acumula el html para los productos
                            $idProducto = substr($productos[$keyProducto],$posiinic,strpos($productos[$keyProducto],'|',$posiinic) - $posiinic);
                            $posiinic = strpos($productos[$keyProducto],'|',$posiinic) + 1;

                            $productoNombre = substr($productos[$keyProducto],$posiinic,strpos($productos[$keyProducto],'|',$posiinic) - $posiinic);
                            $posiinic = strpos($productos[$keyProducto],'|',$posiinic) + 1;

                            $productoCategoria = substr($productos[$keyProducto],$posiinic,strpos($productos[$keyProducto],'|',$posiinic) - $posiinic);
                            $descCategoria = $this->producto->descCategoria($productoCategoria);
                            $descCategoria = $descCategoria[0]['categoria_nombre'];
                            $posiinic = strpos($productos[$keyProducto],'|',$posiinic) + 1;

                            $productoFechaRegi = substr($productos[$keyProducto],$posiinic,strpos($productos[$keyProducto],'|',$posiinic) - $posiinic);
                            $posiinic = strpos($productos[$keyProducto],'|',$posiinic) + 1;

                            $productoPersona = substr($productos[$keyProducto],$posiinic,strpos($productos[$keyProducto],'|',$posiinic) - $posiinic);
                            $posiinic = strpos($productos[$keyProducto],'|',$posiinic) + 1;

                            $productoEstado = substr($productos[$keyProducto],$posiinic,strpos($productos[$keyProducto],'|',$posiinic) - $posiinic);
                            $descEstado = $this->producto->descEstado($productoEstado);
                            $descEstado = $descEstado[0]['estado_descripcion'];
                            $posiinic = strpos($productos[$keyProducto],'|',$posiinic) + 1;

                            $imprProducto.="<tr>";
                            $imprProducto.="<td>".$idProducto."</td>";
                            $imprProducto.="<td>".$productoNombre."</td>";
                            $imprProducto.="<td>".$descCategoria."</td>";
                            $imprProducto.="<td>".$productoFechaRegi."</td>";
                            $imprProducto.="<td>".$productoPersona."</td>";
                            $imprProducto.="<td>".$descEstado."</td>";
                            $imprProducto.="<td><button id='btn-modificar' href='#' onclick=\"modificaProducto('$this->urlBase','$idProducto')\" type='submit' class='btn btn-default btn-circle'><i class='fa fa-pencil'></i></button></td>";
                            $imprProducto.="<td><button id='btn-eliminar' href='#' onclick=\"borraProducto('$this->urlBase','$idProducto')\" type='submit' class='btn btn-danger btn-circle'><i class='fa fa-times'></i></button></td>";
                            $imprProducto.="</tr>";
                            $posiinic = 0;
                        }
                        $cargaForma.=$imprProducto;
                        $imprProducto   = '';
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
                echo("movivent");
            }
        }
        else{
            echo('No se ha logueado');
            redirect('contenedor');
        }
    }
    
    function guardarProducto(){
        $this->load->model('producto');
        $nombreProd    = $_POST['nombreProd'];
        $categoriaProd = $_POST['categoriaProd'];
        $categoriaCodi = substr($categoriaProd,0,strpos($categoriaProd,'-',0) - 1);
        $estadoProd    = $_POST['estadoProd'];
        $estadoCodi    = substr($estadoProd,0,strpos($estadoProd,'-',0) - 1);
        $personaProd   = $this->session->userdata('idPers');
        $producto      = $this->producto->insProducto($nombreProd,$categoriaCodi,$estadoCodi,$personaProd);
        if(isset($producto)){
            echo("true");
        }
        else{
            echo("false");}
        }
    
    function obtenerProducto(){
        $this->load->model('producto');
        $idProducto = $_POST['idProducto'];
        $nombreProd = $_POST['nombreProd'];
        $producto  = $this->producto->selProducto($idProducto,$nombreProd);
        if($producto == 0){
            echo("true");
        }
        else{
            echo("false");
        }
    }
    
    function validarUsuaPers(){
        $this->load->model('producto');
        $usuaPers    = $_POST['usuarioPers'];
        $usuarioCodi = substr($usuaPers,0,strpos($usuaPers,'-',0) - 1);
        $producto     = $this->producto->selUsuaPers($usuarioCodi);
        echo($producto);
    }
    
    //Invoca el modelo de actualización de productos.
    function actualizarProducto(){
        if($this->session->userdata('logged_in')){
            $this->load->model('producto');
            $idProducto      = $_POST['idProd'];
            $nombreProd      = $_POST['nombreProd'];
            $categoriaProd   = $_POST['categoriaProd'];
            $categoriaCodi   = substr($categoriaProd,0,strpos($categoriaProd,'-',0) - 1);
            $estadoProd      = $_POST['estadoProd'];
            $estadoCodi      = substr($estadoProd,0,strpos($estadoProd,'-',0) - 1);
            $producto         = $this->producto->updProducto($idProducto,$nombreProd,$categoriaCodi,$estadoCodi);
            if(isset($producto)){
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
    
    //Recarga el formulario de consulta de los productos a partir del criterio de búsqueda dado.
    function seleccionarProducto(){
        if($this->session->userdata('logged_in')){
            $this->load->model('producto');
            $valorProd = $_POST['producto_valor'];
            $productos  = $this->producto->consProducto($valorProd);
            $imprProducto = "";
            $cargaForma = "<div class='form-group'>
                                                    <div id='lista'>
                                                        <table class='table table-bordered'width='100%'  border='0' cellspacing='0' cellpadding='0' style='font-size:10px'>
                                                            <thead>
                                                                <tr>
                                                                    <th>Código</th>
                                                                    <th>Nombre</th>
                                                                    <th>Categoría</th>
                                                                    <th>Fecha Registro</th>
                                                                    <th>Persona Registra</th>
                                                                    <th>Estado</th>
                                                                </tr>
                                                            </thead>";
            if($productos != false){
                $imprProducto = "";
                $cargaForma.= "<tbody>";
                $posiinic = 0;                                                
                foreach ($productos as $keyProducto=>$producto){
                    //Se acumula el html para los productos
                    $idProducto = substr($productos[$keyProducto],$posiinic,strpos($productos[$keyProducto],'|',$posiinic) - $posiinic);
                    $posiinic = strpos($productos[$keyProducto],'|',$posiinic) + 1;

                    $productoNombre = substr($productos[$keyProducto],$posiinic,strpos($productos[$keyProducto],'|',$posiinic) - $posiinic);
                    $posiinic = strpos($productos[$keyProducto],'|',$posiinic) + 1;

                    $productoCategoria = substr($productos[$keyProducto],$posiinic,strpos($productos[$keyProducto],'|',$posiinic) - $posiinic);
                    $descCategoria = $this->producto->descCategoria($productoCategoria);
                    $descCategoria = $descCategoria[0]['categoria_nombre'];
                    $posiinic = strpos($productos[$keyProducto],'|',$posiinic) + 1;

                    $productoFechaRegi = substr($productos[$keyProducto],$posiinic,strpos($productos[$keyProducto],'|',$posiinic) - $posiinic);
                    $posiinic = strpos($productos[$keyProducto],'|',$posiinic) + 1;

                    $productoPersona = substr($productos[$keyProducto],$posiinic,strpos($productos[$keyProducto],'|',$posiinic) - $posiinic);
                    $posiinic = strpos($productos[$keyProducto],'|',$posiinic) + 1;

                    $productoEstado = substr($productos[$keyProducto],$posiinic,strpos($productos[$keyProducto],'|',$posiinic) - $posiinic);
                    $descEstado = $this->producto->descEstado($productoEstado);
                    $descEstado = $descEstado[0]['estado_descripcion'];
                    $posiinic = strpos($productos[$keyProducto],'|',$posiinic) + 1;

                    $imprProducto.="<tr>";
                    $imprProducto.="<td>".$idProducto."</td>";
                    $imprProducto.="<td>".$productoNombre."</td>";
                    $imprProducto.="<td>".$descCategoria."</td>";
                    $imprProducto.="<td>".$productoFechaRegi."</td>";
                    $imprProducto.="<td>".$productoPersona."</td>";
                    $imprProducto.="<td>".$descEstado."</td>";
                    $imprProducto.="<td><button id='btn-modificar' href='#' onclick=\"modificaProducto('$this->urlBase','$idProducto')\" type='submit' class='btn btn-default btn-circle'><i class='fa fa-pencil'></i></button></td>";
                    $imprProducto.="<td><button id='btn-eliminar' href='#' onclick=\"borraProducto('$this->urlBase','$idProducto')\" type='submit' class='btn btn-danger btn-circle'><i class='fa fa-times'></i></button></td>";
                    $imprProducto.="</tr>";
                    $posiinic = 0;
                }
                $cargaForma.=$imprProducto;
                $imprProducto   = '';
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
    
    function modificarIngreProdu(){
        if($this->session->userdata('logged_in')){
            $this->load->model('producto');
            $idProducto          = $_POST['idProducto'];
            $idIngrediente       = $_POST['idIngrediente'];
            $ingreprodu          = $this->producto->selModiIngreProdu($idProducto,$idIngrediente);
            $unidades            = $this->producto->listaUnidades();
            $estados             = $this->producto->listaEstados();
            $idProducto          = $ingreprodu[0]['ingreprodu_producto_id'];
            $idIngrediente       = $ingreprodu[0]['ingreprodu_ingrediente_id'];
            $idUnidad            = $ingreprodu[0]['ingreprodu_unidad_id'];
            $unidad              = $this->producto->selUnidad($idUnidad);
            $ingreprodu_unidad   = $unidad[0]['unidad'];
            $ingreproduCantidad  = $ingreprodu[0]['ingreprodu_cantidad'];
            $ingreproduFechaRegi = $ingreprodu[0]['ingreprodu_fecha_registro'];
            $idPersona           = $ingreprodu[0]['ingreprodu_persona_id'];
            $idEstado            = $ingreprodu[0]['ingreprodu_estado_id'];
            $estado              = $this->producto->selEstado($idEstado);
            $ingreprodu_estado   = $estado[0]['estado'];
            $imprOpci            = "";
            $cargaForma  = "<div class='row'>
                 <!-- page header -->
                <div class='col-lg-12'>
                    <h1 class='page-header'>Composición de Ingredientes por Producto</h1>
                </div>
                <!--end page header -->
            </div>
            <div class='row'>
                <div class='col-lg-12'>
                    <!-- Form Elements -->
                    <div class='panel panel-default'>
                        <div class='panel-heading'>
                            Modificar Composición de Ingredientes por Producto
                        </div>
                        <div class='panel-body'>
                            <div class='row'>
                                <div class='col-lg-6'>
                                    <form role='form'>
                                        <div class='form-group'>
                                            <label>Código del Producto</label>
                                            <input id='ingreprodu-producto' class='form-control' placeholder='Código del Producto.' value='$idProducto' disabled>
                                        </div>
                                        
                                        <div class='form-group'>
                                            <label>Unidad</label>
                                            <select id='ingreprodu-unidad' class='form-control'>";
        
            foreach ($unidades as $keyUnidad=>$unidad){
                //Se acumula el html para las opciones
                if($ingreprodu_unidad == $unidades[$keyUnidad]){
                    $imprOpci.="<option selected>".$ingreprodu_unidad."</option>";
                }
                else{
                    $imprOpci.="<option>".$unidades[$keyUnidad]."</option>";
                }
            }
            $cargaForma.=$imprOpci;
            $imprOpci = "";
            $cargaForma.="</select>
                                        </div>
                                        
                                        <div class='form-group'>
                                            <label>Estado</label>
                                            <select id='ingreprodu-estado' class='form-control'>";
        
            foreach ($estados as $keyEstado=>$estado){
                //Se acumula el html para las opciones
                if($ingreprodu_estado == $estados[$keyEstado]){
                    $imprOpci.="<option selected>".$ingreprodu_estado."</option>";
                }
                else{
                    $imprOpci.="<option>".$estados[$keyEstado]."</option>";
                }
            }
            $cargaForma.=$imprOpci;
            $imprOpci = "";
            $cargaForma.="</select>
                                        </div>
                                        
                                        
                                        <button id='btn-guardar' href='#' onclick=\"actualizaIngreProdu('$this->urlBase')\" type='submit' class='btn btn-primary'>Guardar</button>
                                        <button type='reset' class='btn btn-success'>Cancelar</button>
                                    </form>
                                </div>
                                <div class='col-lg-6'>
                                    <form role='form'>
                                        <div class='form-group'>
                                            <label>Código del Ingrediente</label>
                                            <input id='ingreprodu-ingrediente' class='form-control' placeholder='Código del Ingrediente.' value='$idIngrediente' disabled>
                                        </div>
                                        <div class='form-group'>
                                            <label>Cantidad</label>
                                            <input id='ingreprodu-cantidad' class='form-control' value='$ingreproduCantidad'>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                     <!-- End Form Elements -->
                </div>
            </div>";
            echo($cargaForma);
        }
        else{
            echo('No se ha logueado');
            redirect('contenedor');
        }
    }
    
    //Invoca el modelo de actualización de productos.
    function actualizarIngreProdu(){
        if($this->session->userdata('logged_in')){
            $this->load->model('producto');
            $idProducto        = $_POST['idProducto'];
            $idIngrediente     = $_POST['idIngrediente'];
            $unidadIngreProd   = $_POST['idUnidad'];
            $unidadCodi        = substr($unidadIngreProd,0,strpos($unidadIngreProd,'-',0) - 1);
            $cantidadIngreProd = $_POST['cantidad'];
            $estadoIngreProdu  = $_POST['estado'];
            $estadoCodi        = substr($estadoIngreProdu,0,strpos($estadoIngreProdu,'-',0) - 1);
            $ingreprodu        = $this->producto->updIngreProdu($idProducto,$idIngrediente,$unidadCodi,
                                                                $cantidadIngreProd,$estadoCodi);
            if($ingreprodu){
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
    
    //Recarga el formulario de consulta de los productos una vez eliminado algún producto.
    function eliminarIngreProdu(){
        if($this->session->userdata('logged_in')){
            $this->load->model('producto');
            $idProducto    = $_POST['idProducto'];
            $idIngrediente = $_POST['idIngrediente'];
            $ingreprodu    = $this->producto->borIngreProdu($idProducto,$idIngrediente);
            $cargaForma = "<div class='form-group'>
                                                    <div id='lista'>
                                                        <table class='table table-bordered'width='100%'  border='0' cellspacing='0' cellpadding='0' style='font-size:10px'>
                                                            <thead>
                                                                <tr>
                                                                    <th>Código Ingrediente</th>
                                                                    <th>Nombre Ingrediente</th>
                                                                    <th>Unidad</th>
                                                                    <th>Cantidad</th>
                                                                    <th>Fecha Registro</th>
                                                                    <th>Persona Registra</th>
                                                                    <th>Estado</th>
                                                                </tr>
                                                            </thead>";
            if($ingreprodu != false){
                $imprProducto = "";
                $cargaForma.= "<tbody>";
                $posiinic = 0;                                                
                foreach ($ingreprodu as $keyIngreProdu=>$produingre){
                    //Se acumula el html para los productos
                    $idProducto = substr($ingreprodu[$keyIngreProdu],$posiinic,strpos($ingreprodu[$keyIngreProdu],'|',$posiinic) - $posiinic);
                    $posiinic = strpos($ingreprodu[$keyIngreProdu],'|',$posiinic) + 1;

                    $idIngrediente = substr($ingreprodu[$keyIngreProdu],$posiinic,strpos($ingreprodu[$keyIngreProdu],'|',$posiinic) - $posiinic);
                    $descIngrediente = $this->producto->descIngrediente($idIngrediente);
                    $descIngrediente = $descIngrediente[0]['ingrediente_nombre'];
                    $posiinic = strpos($ingreprodu[$keyIngreProdu],'|',$posiinic) + 1;

                    $idUnidad = substr($ingreprodu[$keyIngreProdu],$posiinic,strpos($ingreprodu[$keyIngreProdu],'|',$posiinic) - $posiinic);
                    $descUnidad = $this->producto->descUnidad($idUnidad);
                    $descUnidad = $descUnidad[0]['unidad_nombre'];
                    $posiinic = strpos($ingreprodu[$keyIngreProdu],'|',$posiinic) + 1;

                    $ingreproduCantidad = substr($ingreprodu[$keyIngreProdu],$posiinic,strpos($ingreprodu[$keyIngreProdu],'|',$posiinic) - $posiinic);
                    $posiinic = strpos($ingreprodu[$keyIngreProdu],'|',$posiinic) + 1;

                    $ingreproduFechaRegi = substr($ingreprodu[$keyIngreProdu],$posiinic,strpos($ingreprodu[$keyIngreProdu],'|',$posiinic) - $posiinic);
                    $posiinic = strpos($ingreprodu[$keyIngreProdu],'|',$posiinic) + 1;
                    
                    $ingreproduPersona = substr($ingreprodu[$keyIngreProdu],$posiinic,strpos($ingreprodu[$keyIngreProdu],'|',$posiinic) - $posiinic);
                    $posiinic = strpos($ingreprodu[$keyIngreProdu],'|',$posiinic) + 1;

                    $ingreproduEstado = substr($ingreprodu[$keyIngreProdu],$posiinic,strpos($ingreprodu[$keyIngreProdu],'|',$posiinic) - $posiinic);
                    $descEstado = $this->producto->descEstado($ingreproduEstado);
                    $descEstado = $descEstado[0]['estado_descripcion'];
                    $posiinic = strpos($ingreprodu[$keyIngreProdu],'|',$posiinic) + 1;

                    $imprProducto.="<tr>";
                    $imprProducto.="<td>".$idIngrediente."</td>";
                    $imprProducto.="<td>".$descIngrediente."</td>";
                    $imprProducto.="<td>".$descUnidad."</td>";
                    $imprProducto.="<td>".$ingreproduCantidad."</td>";
                    $imprProducto.="<td>".$ingreproduFechaRegi."</td>";
                    $imprProducto.="<td>".$ingreproduPersona."</td>";
                    $imprProducto.="<td>".$descEstado."</td>";
                    $imprProducto.="<td><button id='btn-modificar' href='#' onclick=\"modificaIngreProdu('$this->urlBase','$idProducto','$idIngrediente')\" type='submit' class='btn btn-default btn-circle'><i class='fa fa-pencil'></i></button></td>";
                    $imprProducto.="<td><button id='btn-eliminar' href='#' onclick=\"borraIngreProdu('$this->urlBase','$idProducto','$idIngrediente')\" type='submit' class='btn btn-danger btn-circle'><i class='fa fa-times'></i></button></td>";
                    $imprProducto.="</tr>";
                    $posiinic = 0;
                }
                $cargaForma.=$imprProducto;
                $imprProducto   = '';
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
    
    //Recarga el formulario de consulta de los productos a partir del criterio de búsqueda dado.
    function seleccionarIngreProdu(){
        if($this->session->userdata('logged_in')){
            $this->load->model('producto');
            $idProducto     = $_POST['idProducto'];
            $valorIngreProd = $_POST['ingreprodu_valor'];
            $ingreprodu     = $this->producto->consIngreProdu($idProducto,$valorIngreProd);
            $imprIngreProdu = "";
            $cargaForma = "<div class='form-group'>
                                                    <div id='lista'>
                                                        <table class='table table-bordered'width='100%'  border='0' cellspacing='0' cellpadding='0' style='font-size:10px'>
                                                            <thead>
                                                                <tr>
                                                                    <th>Código Ingrediente</th>
                                                                    <th>Nombre Ingrediente</th>
                                                                    <th>Unidad</th>
                                                                    <th>Cantidad</th>
                                                                    <th>Fecha Registro</th>
                                                                    <th>Persona Registra</th>
                                                                    <th>Estado</th>
                                                                </tr>
                                                            </thead>";
            if($ingreprodu != false){
                $imprIngreProdu = "";
                $cargaForma.= "<tbody>";
                $posiinic = 0;                                                
                foreach ($ingreprodu as $keyIngreProdu=>$produingre){
                    //Se acumula el html para los productos
                    $idProducto = substr($ingreprodu[$keyIngreProdu],$posiinic,strpos($ingreprodu[$keyIngreProdu],'|',$posiinic) - $posiinic);
                    $posiinic = strpos($ingreprodu[$keyIngreProdu],'|',$posiinic) + 1;

                    $idIngrediente = substr($ingreprodu[$keyIngreProdu],$posiinic,strpos($ingreprodu[$keyIngreProdu],'|',$posiinic) - $posiinic);
                    $descIngrediente = $this->producto->descIngrediente($idIngrediente);
                    $descIngrediente = $descIngrediente[0]['ingrediente_nombre'];
                    $posiinic = strpos($ingreprodu[$keyIngreProdu],'|',$posiinic) + 1;

                    $idUnidad = substr($ingreprodu[$keyIngreProdu],$posiinic,strpos($ingreprodu[$keyIngreProdu],'|',$posiinic) - $posiinic);
                    $descUnidad = $this->producto->descUnidad($idUnidad);
                    $descUnidad = $descUnidad[0]['unidad_nombre'];
                    $posiinic = strpos($ingreprodu[$keyIngreProdu],'|',$posiinic) + 1;

                    $ingreproduCantidad = substr($ingreprodu[$keyIngreProdu],$posiinic,strpos($ingreprodu[$keyIngreProdu],'|',$posiinic) - $posiinic);
                    $posiinic = strpos($ingreprodu[$keyIngreProdu],'|',$posiinic) + 1;

                    $ingreproduFechaRegi = substr($ingreprodu[$keyIngreProdu],$posiinic,strpos($ingreprodu[$keyIngreProdu],'|',$posiinic) - $posiinic);
                    $posiinic = strpos($ingreprodu[$keyIngreProdu],'|',$posiinic) + 1;
                    
                    $ingreproduPersona = substr($ingreprodu[$keyIngreProdu],$posiinic,strpos($ingreprodu[$keyIngreProdu],'|',$posiinic) - $posiinic);
                    $posiinic = strpos($ingreprodu[$keyIngreProdu],'|',$posiinic) + 1;

                    $ingreproduEstado = substr($ingreprodu[$keyIngreProdu],$posiinic,strpos($ingreprodu[$keyIngreProdu],'|',$posiinic) - $posiinic);
                    $descEstado = $this->producto->descEstado($ingreproduEstado);
                    $descEstado = $descEstado[0]['estado_descripcion'];
                    $posiinic = strpos($ingreprodu[$keyIngreProdu],'|',$posiinic) + 1;

                    $imprIngreProdu.="<tr>";
                    $imprIngreProdu.="<td>".$idIngrediente."</td>";
                    $imprIngreProdu.="<td>".$descIngrediente."</td>";
                    $imprIngreProdu.="<td>".$descUnidad."</td>";
                    $imprIngreProdu.="<td>".$ingreproduCantidad."</td>";
                    $imprIngreProdu.="<td>".$ingreproduFechaRegi."</td>";
                    $imprIngreProdu.="<td>".$ingreproduPersona."</td>";
                    $imprIngreProdu.="<td>".$descEstado."</td>";
                    $imprIngreProdu.="<td><button id='btn-modificar' href='#' onclick=\"modificaIngreProdu('$this->urlBase','$idProducto','$idIngrediente')\" type='submit' class='btn btn-default btn-circle'><i class='fa fa-pencil'></i></button></td>";
                    $imprIngreProdu.="<td><button id='btn-eliminar' href='#' onclick=\"borraIngreProdu('$this->urlBase','$idProducto','$idIngrediente')\" type='submit' class='btn btn-danger btn-circle'><i class='fa fa-times'></i></button></td>";
                    $imprIngreProdu.="</tr>";
                    $posiinic = 0;
                }
                $cargaForma.=$imprIngreProdu;
                $imprIngreProdu   = '';
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
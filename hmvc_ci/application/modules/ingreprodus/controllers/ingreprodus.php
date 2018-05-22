<?php if (! defined('BASEPATH')) exit('No direct script access allowed');
 
class IngreProdus extends MX_Controller {
    
    function __construct(){
        parent::__construct();
        $this->urlBase = base_url();
    }
 
    function index(){
        echo("ingreprodus.index");
    }
	
    function componerProducto(){
        //Se cargan los Estados desde el modelo IngreProdu
        $this->load->model('ingreprodu');
        $productos    = $this->ingreprodu->listaProductos();
        $ingredientes = $this->ingreprodu->listaIngredientes();
        $unidades     = $this->ingreprodu->listaUnidades();
        $estados      = $this->ingreprodu->listaEstados();
        $unidades     = $this->ingreprodu->listaUnidades();
        $imprOpci     ="";
        $imprUnidad   ="";
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
                            Registro de Ingredientes por Producto
                        </div>
                        <div class='panel-body'>
                            <div class='row'>
                                <div class='col-lg-6'>
                                    <form role='form'>
                                        <div class='form-group'>
                                            <label>Código del Producto</label>
                                            <select id='ingreprodu-producto' class='form-control'>";
        
        foreach ($productos as $keyProducto=>$producto){
            //Se acumula el html para las opciones
            $imprOpci.="<option>".$productos[$keyProducto]."</option>"
                       . "";
        }
        $cargaForma.=$imprOpci;
        $imprOpci = "";
        $cargaForma.="</select>
                                        </div>
                                        
                                        <div class='form-group'>
                                            <label>Unidad</label>
                                            <select id='ingreprodu-unidad' class='form-control'>";
        
        foreach ($unidades as $keyUnidad=>$unidad){
            //Se acumula el html para las opciones
            $imprOpci.="<option>".$unidades[$keyUnidad]."</option>"
                       . "";
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
            $imprOpci.="<option>".$estados[$keyEstado]."</option>"
                       . "";
        }
        $cargaForma.=$imprOpci;
        $imprOpci = "";
        $cargaForma.="</select>
                                        </div>
                                        
                                        
                                        <button id='btn-guardar' href='#' onclick=\"insertaIngreProdu('$this->urlBase')\" type='submit' class='btn btn-primary'>Guardar</button>
                                        <button type='reset' class='btn btn-success'>Cancelar</button>
                                    </form>
                                </div>
                                <div class='col-lg-6'>
                                    <form role='form'>
                                        <div class='form-group'>
                                            <label>Código del Ingrediente</label>
                                            <select id='ingreprodu-ingrediente' class='form-control'>";
        
        foreach ($ingredientes as $keyIngrediente=>$ingrediente){
            //Se acumula el html para las opciones
            $imprOpci.="<option>".$ingredientes[$keyIngrediente]."</option>"
                       . "";
        }
        $cargaForma.=$imprOpci;
        $imprOpci = "";
        $cargaForma.="</select>
                                        </div>
                                        <div class='form-group'>
                                            <label>Cantidad</label>
                                            <input id='ingreprodu-cantidad' class='form-control'>
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
    
    
    function guardarIngreProdu(){
        $this->load->model('ingreprodu');
        $productoIngreProd    = $_POST['productoIngreProd'];
        $productoCodi         = substr($productoIngreProd,0,strpos($productoIngreProd,'-',0) - 1);
        $ingredienteIngreProd = $_POST['ingredienteIngreProd'];
        $ingredienteCodi      = substr($ingredienteIngreProd,0,strpos($ingredienteIngreProd,'-',0) - 1);
        $unidadIngreProd      = $_POST['unidadIngreProd'];
        $unidadCodi           = substr($unidadIngreProd,0,strpos($unidadIngreProd,'-',0) - 1);
        $cantidadIngreProd    = $_POST['cantidadIngreProd'];
        $estadoIngreProd      = $_POST['estadoIngreProd'];
        $estadoCodi           = substr($estadoIngreProd,0,strpos($estadoIngreProd,'-',0) - 1);
        $personaIngreProd     = $this->session->userdata('idPers');
        $ingreprodu           = $this->ingreprodu->insIngreProdu($productoCodi,$ingredienteCodi,$unidadCodi,
                                                                 $cantidadIngreProd,$estadoCodi,$personaIngreProd);
        if(isset($ingreprodu)){
            echo("true");
        }
        else{
            echo("false");}
        }
    
    function obtenerIngreProdu(){
        $this->load->model('ingreprodu');
        $productoIngreProd    = $_POST['productoIngreProd'];
        $productoCodi         = substr($productoIngreProd,0,strpos($productoIngreProd,'-',0) - 1);
        $ingredienteIngreProd = $_POST['ingredienteIngreProd'];
        $ingredienteCodi      = substr($ingredienteIngreProd,0,strpos($ingredienteIngreProd,'-',0) - 1);
        $ingreprodu           = $this->ingreprodu->selIngreProdu($productoCodi,$ingredienteCodi);
        echo($ingreprodu);
    }
}
?>
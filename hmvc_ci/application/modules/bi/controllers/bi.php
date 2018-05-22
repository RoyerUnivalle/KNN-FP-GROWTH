<?php if (! defined('BASEPATH')) exit('No direct script access allowed');
 
class BI extends MX_Controller {
    
    public $frequentItem;
    public $minimumSupportCount;
    public $minConfidence;
    public $supportCount;
    public $orderedFrequentItem;
    public $FPTree;
    public $recomendados;
    public $totaIngrProv;
    
    function __construct(){
        parent::__construct();
        $this->urlBase = base_url();
        $this->frequentItem = array();
        //$this->minimumSupportCount = $_POST['frecuMini'];
	$this->minConfidence = 60 * 0.01;
	$this->supportCount = array();
	$this->orderedFrequentItem = array();
        $this->recomendados = array();
        $this->totaIngrProv = 0;
    }
 
    function index(){
        echo("bi.index");
    }
	
    /************************INICIA SINCRONIZACIÓN DATAMART********************/
    function sincronizaDW_vista(){
        //Se cargan los Estados desde el modelo Persona
        $imprOpci    ="";
        $imprCiudad  ="";
        $imprUsuario ="";
        $this->load->model('bi_model');
        $ultiSincro = $this->bi_model->ultiSincroniza();
        $sincroniza = $ultiSincro[0]['ULTISINC'];
        $cargaForma  = "<div class='row'>
                 <!--page header-->
                <div class='col-lg-12'>
                    <h1 class='page-header'>Sincronización de Datos</h1>
                </div>
                 <!--end page header-->
            </div>
            
            <div class='row'>
                <div class='col-lg-12'>
                     <!--jumbotron-->
                    <div class='jumbotron'>
                        <p>La Sincronización de datos le permite generar los procesos de Inteligencia de Negocio 
                        con los datos almacenados hasta la fecha actual; de lo contrario, la información empleada por estos procesos puede ser inconsistente. </p>
                        <p>Última sincronización ejecutada: ".$sincroniza.".</p>
                        <p>
                        <button id='btn-sincronizar_dw' href='#' onclick=\"sincronizaDW('$this->urlBase')\" type='submit' class='btn btn-primary btn-lg'>Sincronizar Datos</button>
                        </p>
                    </div>
                      <!--End jumbotron-->
                </div>
            </div>";
        echo $cargaForma;
    }
    
    function sincronizaDW(){
        //Se invoca al modelo para obtener las tablas y campos a sincronizar.
        $this->load->model('bi_model');
        $tablas_campos = $this->bi_model->tablas_campos();
        $tablas = array();
        $datosCopia = array();
        $deleteArray = array();
        $insertArray = array();
        $posiinic = 0;
        //Se ejecuta cada consulta correspondiente a cada tabla y sus campos a sincronizar.
        foreach($tablas_campos as $tabla_campo){
            $posiinic = strpos($tabla_campo['campos'],'FROM') + 5;
            $nombTabla = substr($tabla_campo['campos'],$posiinic);
            //Por cada consulta se obtiene un arreglo con los registros encontrados.
            $registro = $this->bi_model->selDatosSincron($tabla_campo['campos']);
            //Cada arreglo contenedor del registro de datos se almacena en un arreglo global.
            $tablas[$nombTabla] = $registro;
        }
        //Se recorre el arreglo global.
        if(is_array($tablas)){
            $delete = '';
            $insert = '';
            foreach ($tablas as $keyTablas=>$registros){
                $delete .= 'DELETE FROM ';
                if($keyTablas != "compras" && $keyTablas != "ventas"){
                    $delete .= 'dim'.$keyTablas.';';
                }
                else{
                    $delete .= 'fact'.$keyTablas.';';
                }
                if(is_array($registros)){
                    foreach ($registros as $keyDatRegi=>$datosRegistro){
                        if(is_array($datosRegistro)){
                            $insert .= 'INSERT INTO ';
                            if($keyTablas != "compras" && $keyTablas != "ventas"){
                                $insert .= 'dim'.$keyTablas.'(';
                            }
                            else{
                                $insert .= 'fact'.$keyTablas.'(';
                            }
                            $campos = '';
                            $valores = '';
                            foreach ($datosRegistro as $keyDatos=>$datos){
                                $datosCopia = $datosRegistro;
                                end($datosCopia);
                                if($keyDatos == key($datosCopia)){
                                    $campos .= $keyDatos;
                                    $valores .= "'$datos'";
                                }
                                else{
                                    $campos .= $keyDatos.',';
                                    $valores .= "'$datos',";
                                }
                            }
                            $insert .= $campos.") VALUES(".$valores.");";
                            $campos = '';
                            $valores = '';
                        }
                    }
                }
            }
            $deleteArray = explode(';',$delete);
            $insertArray = explode(';',$insert);
            $resultDel = $this->bi_model->insDatosSincron($deleteArray);
            $result = $this->bi_model->insDatosSincron($insertArray);
            if($result){
                $sincronCompleta = 1;
                $insSincron = $this->bi_model->insSincron_Dw($sincronCompleta);
                echo('true');
            }
            else{
                $sincronCompleta = 0;
                $insSincron = $this->bi_model->insSincron_Dw($sincronCompleta);
                echo('false');
            }
        }
    }
    /***********************FINALIZA SINCRONIZACIÓN DATAMART*******************/
    
    
    
    /**************************INICIA ALGORITMO FPGROWTH***********************/
    /*
    *input array of frequent pattern
    */
    public function set($t){
            if(is_array($t)){
                $this->frequentItem[] 	= $t;
            }
    }

    public function get(){
            echo "<pre>";
            print_r($this->frequentItem);
            echo "</pre>";
    }

    public function getFrequentItem(){
        echo "<pre>";
        print_r($this->frequentItem);
        echo "</pre>";
    }

    public function orderFrequentItem($frequentItem, $supportCount){
        foreach ($frequentItem as $k => $v) {
            $ordered 	= array();
            foreach ($supportCount as $key => $value) {
                if(isset($v[$key])){
                    $ordered[$key] = $v[$key];
                }
            }
            $this->orderedFrequentItem[$k] = $ordered;
        }
    }

    public function getOrderedFrequentItem(){
            echo "<pre>";
            print_r($this->orderedFrequentItem);
            echo "</pre>";
    }

    public function countSupportCount(){
        if(is_array($this->frequentItem)){
            foreach ($this->frequentItem as $key => $value) {
                if(is_array($value)){
                    foreach ($value as $k => $v) {
                        if (empty($this->supportCount[$v])) {
                            $this->supportCount[$v] = 1;
                        }
                        else{
                            $this->supportCount[$v] = $this->supportCount[$v] + 1;
                        }
                    }
                }
            }
        }
    }

    public function getSupportCount(){
            echo "<pre>";
            print_r($this->supportCount);
            echo "</pre>";
    }

    public function orderBySupportCount(){
            ksort($this->supportCount);
            arsort($this->supportCount);
    }

    public function removeByMinimumSupport($supportCount,$minimumSupportCount){
            if(is_array($supportCount))
            {
                    $this->supportCount = array();
                    foreach ($supportCount as $key => $value) {
                            if ($value >= $minimumSupportCount)
                            {
                                    $this->supportCount[$key] = $value;
                            }
                    }
            }
    }

    /* struktur array
    * item  : (I1, I2, dst)
    * count : (2, 3, 4)
    * child : (next array)
    */
    public function buildFPTree($orderedFrequentItem){
            $FPTree[] 	= array(
                    'item'	=> 'null',
                    'count'	=> 0,
                    'child'	=> null,
            );
            $FPTree2[] 	= array();
            if(is_array($orderedFrequentItem))
            {
                    $i 	= 0;
                    foreach ($orderedFrequentItem as $orderedFrequentItemKey => $orderedFrequentItemValue) {
                            // inisiasi ke FPTree 0 // save key FPTree sementara
                            $FPTreeTemp 	= $FPTree[0];
                            $FPTreeTempKey 	= array(0);

                            foreach ($orderedFrequentItemValue as $itemKey => $itemValue) {
                                    // add key FPTree sementara
                                    array_push($FPTreeTempKey, $itemValue);

                                    // insert tree ke FPTree
                                    switch ((count($FPTreeTempKey))) {
                                            case 2:
                                                    if(empty($FPTree[0]['child'][$itemValue]))
                                                    {
                                                            $FPTree[0]['child'][$itemValue] 	= array(
                                                                    'item'	=> $itemValue,
                                                                    'count'	=> 1,
                                                                    'child'	=> null,
                                                            );
                                                    }else{
                                                            $FPTree[0]['child'][$itemValue]['count'] = $FPTree[0]['child'][$itemValue]['count'] + 1;
                                                    }
                                                    break;

                                            case 3:
                                                    if(empty($FPTree[0]['child'][$FPTreeTempKey[1]]['child'][$itemValue]))
                                                    {
                                                            $FPTree[0]['child'][$FPTreeTempKey[1]]['child'][$itemValue] 	= array(
                                                                    'item'	=> $itemValue,
                                                                    'count'	=> 1,
                                                                    'child'	=> null,
                                                            );
                                                    }else{
                                                            $FPTree[0]['child'][$FPTreeTempKey[1]]['child'][$itemValue]['count'] = $FPTree[0]['child'][$FPTreeTempKey[1]]['child'][$itemValue]['count'] + 1;
                                                    }
                                                    break;

                                            case 4:
                                                    if(empty($FPTree[0]['child'][$FPTreeTempKey[1]]['child'][$FPTreeTempKey[2]]['child'][$itemValue]))
                                                    {
                                                            $FPTree[0]['child'][$FPTreeTempKey[1]]['child'][$FPTreeTempKey[2]]['child'][$itemValue] 	= array(
                                                                    'item'	=> $itemValue,
                                                                    'count'	=> 1,
                                                                    'child'	=> null,
                                                            );
                                                    }else{
                                                            $FPTree[0]['child'][$FPTreeTempKey[1]]['child'][$FPTreeTempKey[2]]['child'][$itemValue]['count'] = $FPTree[0]['child'][$FPTreeTempKey[1]]['child'][$FPTreeTempKey[2]]['child'][$itemValue]['count'] + 1;
                                                    }
                                                    break;

                                            case 5:
                                                    if(empty($FPTree[0]['child'][$FPTreeTempKey[1]]['child'][$FPTreeTempKey[2]]['child'][$FPTreeTempKey[3]]['child'][$itemValue]))
                                                    {
                                                            $FPTree[0]['child'][$FPTreeTempKey[1]]['child'][$FPTreeTempKey[2]]['child'][$FPTreeTempKey[3]]['child'][$itemValue] 	= array(
                                                                    'item'	=> $itemValue,
                                                                    'count'	=> 1,
                                                                    'child'	=> null,
                                                            );
                                                    }else{
                                                            $FPTree[0]['child'][$FPTreeTempKey[1]]['child'][$FPTreeTempKey[2]]['child'][$FPTreeTempKey[3]]['child'][$itemValue]['count'] = $FPTree[0]['child'][$FPTreeTempKey[1]]['child'][$FPTreeTempKey[2]]['child'][$FPTreeTempKey[3]]['child'][$itemValue]['count'] + 1;
                                                    }
                                                    break;

                                            default:

                                                    break;
                                    }
                            }
                    }
            }
            return $FPTree;
    }

    public function getFPTree()
    {
            echo "<pre>";
            print_r($this->FPTree);
            echo "</pre>";
    }
    /**************************FINALIZA ALGORITMO FPGROWTH*********************/
    
    
    
    /*****************************INICIA ALGORITMO KNN*************************/
    function distanciaEuclidiana($cantidadIngre,$cantidadDife){   
        $distanciaEuclidiana = sqrt($cantidadDife * pow((100/$cantidadIngre),2));
        return($distanciaEuclidiana);
    }

    /****************************FINALIZA ALGORITMO KNN************************/
    
    /************************INICIA RECOMENDADOR DE VENTAS*********************/
    //Carga el formulario de consulta de clientes por ventas.
    function biVentas(){
        if($this->session->userdata('logged_in')){
            $this->load->model('bi_model');
            $clientes = $this->bi_model->listaClientes();
            $imprOpci ="";
            $cargaForma = "<div class='row'>
                    <!-- page header -->
                    <div class='col-lg-12'>
                        <h1 class='page-header'>Analizar Ventas</h1>
                    </div>
                    <!--end page header -->
                </div>
                <div class='row'>
                    <div class='col-lg-12'>
                        <!-- Form Elements -->
                        <div class='panel panel-default'>
                            <div class='panel-heading'>
                                Criterios de Análisis
                            </div>
                            <div class='panel-body'>
                                <div class='row'>
                                    <div class='col-lg-6'>
                                        <form role='form'>
                                                                                
                                            <div class='form-group'>
                                                <label>Fecha Inicio</label>
                                                <input id='fecha-inicio' type='date' data-format='dd-MM-yyyy' class='form-control' placeholder='dd-mm-yyyy'>
                                            </div>
                                            
                                            <div class='form-group'>
                                                <label>Frecuencia Mínima de Ventas</label>
                                                <input id='frecuencia-minima' type='number' min='1' class='form-control' placeholder='Frecuencia Mínima.' value ='1'>
                                            </div>
                                            
                                            <div class='form-group'>
                                                <label>Cliente</label>
                                                <select id='cliente' class='form-control' placeholder='Cliente'>";
            $imprOpci.="<option>".''."</option>";
            foreach ($clientes as $keyCliente=>$cliente){
                //Se acumula el html para las opciones
                $imprOpci.="<option>".$clientes[$keyCliente]."</option>"
                       . "";
            }
            $cargaForma.=$imprOpci;
            $imprOpci = '';
            $cargaForma.="</select>
                                            </div>
                                            
                                            <button id='btn-guardar' href='#' onclick=\"consultaClientesFrecuentes('$this->urlBase')\" type='submit' class='btn btn-primary'>Aceptar</button>
                                            <button id='btn-cancelar' type='reset' class='btn btn-success'>Cancelar</button>
                                        </form>
                                    </div>
                                    <div class='col-lg-6'>
                                        <form role='form'>
                                            <div class='form-group'>
                                                <label>Fecha Final</label>
                                                <input id='fecha-final' type='date' data-format='dd-MM-yyyy' class='form-control' placeholder='dd-mm-yyyy'>
                                            </div>
                                            
                                            <div class='form-group'>
                                                <label>Porcentaje de Recomendación Mínimo</label>
                                                <input id='porcentaje-recomendacion' type='number' min='1' max='100' class='form-control' placeholder='Porcentaje de Recomendación.' value ='1'>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            
                            <div class='panel-heading'>
                                     Resultado Análisis
                            </div>
                            <div class='panel-body'>
                                <div class='table-responsive'>
                                    <div id='dataTables-example_wrapper' class='dataTables_wrapper form-inline' role='grid'>
                                        <div id='clientes' class='row'>
                                            <div class='form-group'>
                                                <div id='lista'>
                                                    <table class='table table-bordered'width='100%'  border='0' cellspacing='0' cellpadding='0' style='font-size:10px'>
                                                        <caption>Clientes Frecuentes</caption>
                                                        <thead>
                                                            <tr>
                                                                <th>Código</th>
                                                                <th>Nombres y Apellidos</th>
                                                                <th>Género</th>
                                                                <th>Ciudad</th>
                                                                <th>Fecha Nacimiento</th>
                                                                <th>Valor Acumulado Ventas</th>
                                                                <th>Total Ventas</th>
                                                            </tr>
                                                        </thead>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>";
            echo($cargaForma);
        }
    }
    

    public function consultaClientesFrecuentes(){
        if($this->session->userdata('logged_in')){
            $fechaInic = $_POST['fechaInic'];
            $fechaFina = $_POST['fechaFina'];
            $frecuMini = $_POST['frecuMini'];
            $porceMini = $_POST['porceMini'];
            $cliente = $_POST['cliente'];
            $clienteCodi = substr($cliente,0,strpos($cliente,'-',0) - 1);
            $this->load->model('bi_model');
            $ventas    = $this->bi_model->consClieVent($fechaInic,$fechaFina,$clienteCodi);
            if($ventas != false){
                $posiinic = 0;
                $fpgrowth = new BI();
                foreach ($ventas as $keyVenta=>$venta){
                    $fpgrowth->set($venta);
                }
                //$fpgrowth->get();
                $fpgrowth->countSupportCount();
                //$fpgrowth->getSupportCount();
                $fpgrowth->orderBySupportCount();
                //$fpgrowth->getSupportCount();
                $fpgrowth->removeByMinimumSupport($fpgrowth->supportCount,$frecuMini);
                //$fpgrowth->getSupportCount();
                $fpgrowth->orderFrequentItem($fpgrowth->frequentItem, $fpgrowth->supportCount);
                //$fpgrowth->getOrderedFrequentItem();
                $fpgrowth->FPTree = $fpgrowth->buildFPTree($fpgrowth->orderedFrequentItem);
                //$fpgrowth->getFPTree();  
                
                $cargaForma = "<div class='form-group'>
                                <div id='lista'>
                                    <table class='table table-bordered'width='100%'  border='0' cellspacing='0' cellpadding='0' style='font-size:10px'>
                                        <caption>Clientes Frecuentes</caption>
                                        <thead>
                                            <tr>
                                                <th>Código</th>
                                                <th>Nombres y Apellidos</th>
                                                <th>Género</th>
                                                <th>Ciudad</th>
                                                <th>Fecha Nacimiento</th>
                                                <th>Valor Acumulado Ventas</th>
                                                <th>Total Ventas</th>
                                            </tr>
                                        </thead>";
                $imprCliente = "";
                $cargaForma.= "<tbody>";
                $frecuencia = 0;
                if(is_array($fpgrowth->FPTree)){
                    foreach ($fpgrowth->FPTree as $keyNivel1=>$nivel1){
                        foreach ($nivel1 as $keyNivel2=>$nivel2){
                            if($keyNivel2 == "child" && is_array($nivel2)){
                                foreach ($nivel2 as $keyNivel3=>$nivel3){
                                    foreach ($nivel3 as $keyCliente=>$cliente){
                                        if($keyCliente == "item"){
                                            $idCliente = $cliente;
                                            $datosCliente = $this->bi_model->datosCliente($cliente);
                                            $clienteNombre = $datosCliente[0]['cliente_nombre'];
                                            
                                            $descGenero = $datosCliente[0]['cliente_genero_id'];
                                            $descGenero = $this->bi_model->descGenero($descGenero);
                                            $descGenero = $descGenero[0]['genero_descripcion'];
                                            
                                            $descCiudad = $datosCliente[0]['cliente_ciudad_id'];
                                            $descCiudad = $this->bi_model->descCiudad($descCiudad);
                                            $descCiudad = $descCiudad[0]['ciudad_nombre'];
                                            
                                            $clienteFechaNaci = $datosCliente[0]['cliente_fecha_nacimiento'];
                                            $clienteCostoVentas = $datosCliente[0]['cliente_costacum_ventas'];
                                            
                                            //Se acumula el html para los clientes
                                            $imprCliente.="<tr>";
                                            $imprCliente.="<td>".$idCliente."</td>";
                                            $imprCliente.="<td>".$clienteNombre."</td>";
                                            $imprCliente.="<td>".$descGenero."</td>";
                                            $imprCliente.="<td>".$descCiudad."</td>";
                                            $imprCliente.="<td>".$clienteFechaNaci."</td>";
                                            $imprCliente.="<td>".$clienteCostoVentas."</td>";
                                        }
                                        else{
                                            if($keyCliente == "count"){
                                                $frecuencia = $cliente;
                                                $imprCliente.="<td>".$frecuencia."</td>";
                                                $imprCliente.="<td><button id='btn-recomendar' href='#' onclick=\"recomiendaProducto('$this->urlBase','$idCliente','$frecuMini','$porceMini')\" type='submit' class='btn btn-default btn-circle'><i class='fa fa-pencil'></i></button></td>";
                                                $imprCliente.="</tr>";
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    }
                    $cargaForma.=$imprCliente;
                    $imprCliente   = '';
                    $cargaForma.="</tbody>
                            </table>
                        </div>
                    </div>";
                    $cargaForma.="<div class='form-group'>
                                <div id='productos'>
                                </div>
                            </div>";
                    echo($cargaForma);
                }
                else{
                    echo("no_array");
                }
            }
        }
    }
    
    public function consultaProduClien(){
        if($this->session->userdata('logged_in')){
            $idCliente = $_POST['idCliente'];
            $frecuMini = $_POST['frecuMini'];
            $porceMini = $_POST['porceMini'];
            $this->load->model('bi_model');
            $productos = $this->bi_model->consProdClie($idCliente);
            if($productos != false){
                $produFpgrowth = new BI();
                foreach ($productos as $keyProducto=>$productoRefe){
                    $produFpgrowth->set($productoRefe);
                }
                //$produFpgrowth->get();
                $produFpgrowth->countSupportCount();
                //$produFpgrowth->getSupportCount();
                $produFpgrowth->orderBySupportCount();
                //$produFpgrowth->getSupportCount();
                $produFpgrowth->removeByMinimumSupport($produFpgrowth->supportCount,$frecuMini);
                //$produFpgrowth->getSupportCount();
                $produFpgrowth->orderFrequentItem($produFpgrowth->frequentItem, $produFpgrowth->supportCount);
                //$produFpgrowth->getOrderedFrequentItem();
                $produFpgrowth->FPTree = $produFpgrowth->buildFPTree($produFpgrowth->orderedFrequentItem);
                //$produFpgrowth->getFPTree();
                if(is_array($produFpgrowth->FPTree)){
                    foreach ($produFpgrowth->FPTree as $keyNivel1=>$nivel1){
                        foreach ($nivel1 as $keyNivel2=>$nivel2){
                            if($keyNivel2 == "child" && is_array($nivel2)){
                                foreach ($nivel2 as $keyNivel3=>$nivel3){
                                    foreach ($nivel3 as $keyProducto=>$producto){
                                        if($keyProducto == "item"){
                                            $idProdRefe = $producto;
                                            
                                            //Se seleccionan los ingredientes que componen al producto de referencia.
                                            $ingrProdRefes = $this->bi_model->selIngrProd($idProdRefe);
                                            $refesIngrProd = array();
                                            if(is_array($ingrProdRefes)){
                                                foreach($ingrProdRefes as $keyIngrProdRefe=>$ingrProdRefe){
                                                    //Se arma un array solamente con los ingredientes del producto de referencia
                                                    $refesIngrProd[] = $ingrProdRefe['ingreprodu_ingrediente_id'];
                                                }
                                            }
                                            
                                            //Se selecciona la categoría del producto de referencia
                                            $categoria = $this->bi_model->selCateProd($idProdRefe);
                                            $idCategoria = $categoria[0]['producto_categoria_id'];
                                            
                                            //Se seleccionan todos los productos pertenecientes a la misma categoría
                                            //del producto de referencia, omitiendo el producto de referencia
                                            $ProdCate = $this->bi_model->selProdCate($idCategoria,$idProdRefe);
                                            if(is_array($ProdCate)){
                                                foreach($ProdCate as $keyProdCate=>$prod){
                                                    $this->prodRecomendado($refesIngrProd,$prod,$porceMini);
                                                }
                                            }
                                        }
                                        else{
                                            if($keyProducto == "count"){
                                                $frecuencia = $producto;
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    }
                    if(empty($this->recomendados)){
                        echo("No hay recomendaciones.");
                    }
                    else{
                        $this->imprimeProductos();
                    }
                }
                else{
                    echo("no_array");
                }
            }
        }
    }
    
    
    public function prodRecomendado($ingrProdRefe,$prod,$porceMini){
        if($this->session->userdata('logged_in')){
            //Cantidad de ingredientes del producto de referencia.
            $cantIngrProdRefe = count($ingrProdRefe);
            
            //Se seleccionan los ingredientes que componen al producto a comparar.
            $ingrProds = $this->bi_model->selIngrProd($prod['id_producto']);
            $ingrProd = array();
            if(is_array($ingrProds)){
                foreach($ingrProds as $keyIngrProd=>$ingrProdu){
                    //Se arma un array solamente con los ingredientes del producto de referencia
                    $ingrProd[] = $ingrProdu['ingreprodu_ingrediente_id'];
                }
            }
            
            $cantIngrProd = count($ingrProd);
            $ingrDife = array();
            if($cantIngrProdRefe >= $cantIngrProd){
                $cantidadIngre = $cantIngrProdRefe;
                if(is_array($ingrProdRefe) && is_array($ingrProd)){
                    $ingrDife = array_diff($ingrProdRefe,$ingrProd);
                }
            }
            else{
                $cantidadIngre = $cantIngrProd;
                if(is_array($ingrProdRefe) && is_array($ingrProd)){
                    $ingrDife = array_diff($ingrProd,$ingrProdRefe);
                }
            }
            $cantidadDife = count($ingrDife);
            $distanciaEuclidiana = 0;
            $distanciaEuclidiana = $this->distanciaEuclidiana($cantidadIngre,$cantidadDife);
            $valoSimi = 100 - $distanciaEuclidiana;
            if($valoSimi >= $porceMini){
                $this->recomendados[$prod['id_producto']] = $valoSimi;
            }
        }
    }
    
    
    public function imprimeProductos(){
        if($this->session->userdata('logged_in')){
            $this->load->model('bi_model');
            $cargaForma =  "<table class='table table-bordered'width='100%'  border='0' cellspacing='0' cellpadding='0' style='font-size:10px'>
                                <caption>Productos Recomendados</caption>
                                <thead>
                                    <tr>
                                        <th>Código Producto</th>
                                        <th>Nombres Producto</th>
                                        <th>Categoría</th>
                                        <th>% Recomendación</th>
                                    </tr>
                                </thead>";
            $cargaForma.= "<tbody>";
            $imprProducto = "";
            if(is_array($this->recomendados)){
                foreach ($this->recomendados as $keyProducto=>$recomendacion){
                    //echo("PRODUCTO: ".$keyProducto." - % RECOMENDACIÓN: ".$producto);
                    $producto = $this->bi_model->descProducto($keyProducto);
                    $productoNombre = ($producto[0]['producto_nombre']);
                    $productoCategoria = ($producto[0]['producto_categoria_id']);
                    $categoria = $this->bi_model->descCategoria($productoCategoria);
                    $categoriaNombre = ($categoria[0]['categoria_nombre']);
                    //Se acumula el html para los clientes
                    $imprProducto.="<tr>";
                    $imprProducto.="<td>".$keyProducto."</td>";
                    $imprProducto.="<td>".$productoNombre."</td>";
                    $imprProducto.="<td>".$categoriaNombre."</td>";
                    $imprProducto.="<td>".$recomendacion."</td>";
                    $imprProducto.="</tr>";
                }
                //$cargaForma.=$imprCliente;
                $imprCliente   = '';
                $cargaForma.=$imprProducto;
                $cargaForma.="</tbody>
                        </table>
                    </div>
                </div>";
                echo($cargaForma);
            }
            else{
                echo("no_array");
            }
        }
    }
    /***********************FINALIZA RECOMENDADOR DE VENTAS********************/
    
    
    /***********************INICIA RECOMENDADOR DE COMPRAS*********************/
    //Carga el formulario de consulta de clientes por ventas.
    function biCompras(){
        if($this->session->userdata('logged_in')){
            $this->load->model('bi_model');
            $proveedores = $this->bi_model->listaProveedores();
            $imprOpci ="";
            $cargaForma = "<div class='row'>
                    <!-- page header -->
                    <div class='col-lg-12'>
                        <h1 class='page-header'>Analizar Compras</h1>
                    </div>
                    <!--end page header -->
                </div>
                <div class='row'>
                    <div class='col-lg-12'>
                        <!-- Form Elements -->
                        <div class='panel panel-default'>
                            <div class='panel-heading'>
                                Criterios de Análisis
                            </div>
                            <div class='panel-body'>
                                <div class='row'>
                                    <div class='col-lg-6'>
                                        <form role='form'>
                                                                                
                                            <div class='form-group'>
                                                <label>Fecha Inicio</label>
                                                <input id='fecha-inicio' type='date' data-format='dd-MM-yyyy' class='form-control' placeholder='dd-mm-yyyy'>
                                            </div>
                                            
                                            <div class='form-group'>
                                                <label>Frecuencia Mínima de Compras</label>
                                                <input id='frecuencia-minima' type='number' min='1' class='form-control' placeholder='Frecuencia Mínima.' value ='1'>
                                            </div>
                                            
                                            <div class='form-group'>
                                                <label>Proveedor</label>
                                                <select id='proveedor' class='form-control' placeholder='Proveedor'>";
            $imprOpci.="<option>".''."</option>";
            foreach ($proveedores as $keyProveedor=>$proveedor){
                //Se acumula el html para las opciones
                $imprOpci.="<option>".$proveedores[$keyProveedor]."</option>"
                       . "";
            }
            $cargaForma.=$imprOpci;
            $imprOpci = '';
            $cargaForma.="</select>
                                            </div>
                                            
                                            <button id='btn-guardar' href='#' onclick=\"consultaProveedoresFrecuentes('$this->urlBase')\" type='submit' class='btn btn-primary'>Aceptar</button>
                                            <button id='btn-cancelar' type='reset' class='btn btn-success'>Cancelar</button>
                                        </form>
                                    </div>
                                    <div class='col-lg-6'>
                                        <form role='form'>
                                            <div class='form-group'>
                                                <label>Fecha Final</label>
                                                <input id='fecha-final' type='date' data-format='dd-MM-yyyy' class='form-control' placeholder='dd-mm-yyyy'>
                                            </div>
                                            
                                            <div class='form-group'>
                                                <label>Porcentaje de Recomendación Mínimo</label>
                                                <input id='porcentaje-recomendacion' type='number' min='1' max='100' class='form-control' placeholder='Porcentaje de Recomendación.' value ='1'>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            
                            <div class='panel-heading'>
                                     Resultado Análisis
                            </div>
                            <div class='panel-body'>
                                <div class='table-responsive'>
                                    <div id='dataTables-example_wrapper' class='dataTables_wrapper form-inline' role='grid'>
                                        <div id='proveedores' class='row'>
                                            <div class='form-group'>
                                                <div id='lista'>
                                                    <table class='table table-bordered'width='100%'  border='0' cellspacing='0' cellpadding='0' style='font-size:10px'>
                                                        <caption>Proveedores Frecuentes</caption>
                                                        <thead>
                                                            <tr>
                                                                <th>Código</th>
                                                                <th>Nombre</th>
                                                                <th>Valor Acumulado Compras</th>
                                                                <th>Total Compras</th>
                                                            </tr>
                                                        </thead>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>";
            echo($cargaForma);
        }
    }
    
    public function consultaProveedoresFrecuentes(){
        if($this->session->userdata('logged_in')){
            $fechaInic = $_POST['fechaInic'];
            $fechaFina = $_POST['fechaFina'];
            $frecuMini = $_POST['frecuMini'];
            $porceMini = $_POST['porceMini'];
            $proveedor = $_POST['proveedor'];
            $proveedorCodi = substr($proveedor,0,strpos($proveedor,'-',0) - 1);
            $this->load->model('bi_model');
            $compras    = $this->bi_model->consProvComp($fechaInic,$fechaFina,$proveedorCodi);
            if($compras != false){
                $posiinic = 0;
                $fpgrowth = new BI();
                foreach ($compras as $keyCompra=>$compra){
                    $fpgrowth->set($compra);
                }
                //$fpgrowth->get();
                $fpgrowth->countSupportCount();
                //$fpgrowth->getSupportCount();
                $fpgrowth->orderBySupportCount();
                //$fpgrowth->getSupportCount();
                $fpgrowth->removeByMinimumSupport($fpgrowth->supportCount,$frecuMini);
                //$fpgrowth->getSupportCount();
                $fpgrowth->orderFrequentItem($fpgrowth->frequentItem, $fpgrowth->supportCount);
                //$fpgrowth->getOrderedFrequentItem();
                $fpgrowth->FPTree = $fpgrowth->buildFPTree($fpgrowth->orderedFrequentItem);
                //$fpgrowth->getFPTree();  
                
                $cargaForma = "<div class='form-group'>
                                <div id='lista'>
                                    <table class='table table-bordered'width='100%'  border='0' cellspacing='0' cellpadding='0' style='font-size:10px'>
                                        <caption>Proveedores Frecuentes</caption>
                                        <thead>
                                            <tr>
                                                <th>Código</th>
                                                <th>Nombre</th>
                                                <th>Valor Acumulado Compras</th>
                                                <th>Total Compras</th>
                                            </tr>
                                        </thead>";
                $imprProveedor = "";
                $cargaForma.= "<tbody>";
                $frecuencia = 0;
                if(is_array($fpgrowth->FPTree)){
                    foreach ($fpgrowth->FPTree as $keyNivel1=>$nivel1){
                        foreach ($nivel1 as $keyNivel2=>$nivel2){
                            if($keyNivel2 == "child" && is_array($nivel2)){
                                foreach ($nivel2 as $keyNivel3=>$nivel3){
                                    foreach ($nivel3 as $keyProveedor=>$proveedor){
                                        if($keyProveedor == "item"){
                                            $idProveedor = $proveedor;
                                            $datosProveedor = $this->bi_model->datosProveedor($proveedor);
                                            $proveedorNombre = $datosProveedor[0]['proveedor_nombre'];
                                            
                                            $proveedorCostoVentas = $datosProveedor[0]['proveedor_costacum_compras'];
                                            
                                            //Se acumula el html para los clientes
                                            $imprProveedor.="<tr>";
                                            $imprProveedor.="<td>".$idProveedor."</td>";
                                            $imprProveedor.="<td>".$proveedorNombre."</td>";
                                            $imprProveedor.="<td>".$proveedorCostoVentas."</td>";
                                        }
                                        else{
                                            if($keyProveedor == "count"){
                                                $frecuencia = $proveedor;
                                                $imprProveedor.="<td>".$frecuencia."</td>";
                                                $imprProveedor.="<td><button id='btn-recomendar' href='#' onclick=\"recomiendaIngrediente('$this->urlBase','$idProveedor','$frecuMini','$porceMini')\" type='submit' class='btn btn-default btn-circle'><i class='fa fa-pencil'></i></button></td>";
                                                $imprProveedor.="</tr>";
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    }
                    $cargaForma.=$imprProveedor;
                    $imprProveedor   = '';
                    $cargaForma.="</tbody>
                            </table>
                        </div>
                    </div>";
                    $cargaForma.="<div class='form-group'>
                                <div id='ingredientes'>
                                </div>
                            </div>";
                    echo($cargaForma);
                }
                else{
                    echo("no_array");
                }
            }
        }
    }
    
    public function consultaIngreProve(){
        if($this->session->userdata('logged_in')){
            $idProveedor = $_POST['idProveedor'];
            $frecuMini = $_POST['frecuMini'];
            $porceMini = $_POST['porceMini'];
            $this->load->model('bi_model');
            $frecuencia = 0;
            $ingredientes = $this->bi_model->consIngrProv($idProveedor);
            if($ingredientes != false){
                $ingreFpgrowth = new BI();
                foreach ($ingredientes as $keyIngrediente=>$ingredienteRefe){
                    $ingreFpgrowth->set($ingredienteRefe);
                }
                //$produFpgrowth->get();
                $ingreFpgrowth->countSupportCount();
                //$produFpgrowth->getSupportCount();
                $ingreFpgrowth->orderBySupportCount();
                //$produFpgrowth->getSupportCount();
                $ingreFpgrowth->removeByMinimumSupport($ingreFpgrowth->supportCount,$frecuMini);
                //$produFpgrowth->getSupportCount();
                $ingreFpgrowth->orderFrequentItem($ingreFpgrowth->frequentItem, $ingreFpgrowth->supportCount);
                //$produFpgrowth->getOrderedFrequentItem();
                $ingreFpgrowth->FPTree = $ingreFpgrowth->buildFPTree($ingreFpgrowth->orderedFrequentItem);
                //$ingreFpgrowth->getFPTree();
                $this->totaIngrProv = 0;
                if(is_array($ingreFpgrowth->FPTree)){
                    foreach ($ingreFpgrowth->FPTree as $keyNivel1=>$nivel1){
                        foreach ($nivel1 as $keyNivel2=>$nivel2){
                            if($keyNivel2 == "child" && is_array($nivel2)){
                                foreach ($nivel2 as $keyNivel3=>$nivel3){
                                    foreach ($nivel3 as $keyIngrediente=>$ingrediente){
                                        if($keyIngrediente == "item"){
                                            $idIngrRefe = $ingrediente;
                                        }
                                        else{
                                            if($keyIngrediente == "count"){
                                                $frecuencia = $ingrediente;
                                                $this->totaIngrProv = $this->totaIngrProv + $frecuencia;
                                            }
                                        }
                                        if($frecuencia >= $frecuMini){
                                            $this->recomendados[$idIngrRefe] = $frecuencia;
                                        }
                                    }
                                }
                            }
                        }
                    }
                    if(empty($this->recomendados)){
                        echo("No hay recomendaciones.");
                    }
                    else{
                        $this->imprimeIngredientes();
                    }
                }
                else{
                    echo("no_array");
                }
            }
        }
    }
    
    public function imprimeIngredientes(){
        if($this->session->userdata('logged_in')){
            $this->load->model('bi_model');
            $cargaForma =  "<table class='table table-bordered'width='100%'  border='0' cellspacing='0' cellpadding='0' style='font-size:10px'>
                                <caption>Ingredientes Recomendados</caption>
                                <thead>
                                    <tr>
                                        <th>Código Ingrediente</th>
                                        <th>Nombre Ingrediente</th>
                                        <th>% Recomendación</th>
                                    </tr>
                                </thead>";
            $cargaForma.= "<tbody>";
            $imprIngrediente = "";
            if(is_array($this->recomendados)){
                foreach ($this->recomendados as $keyIngrediente=>$recomendacion){
                    $recomendacion = ($recomendacion / $this->totaIngrProv) * 100;
                    $ingrediente = $this->bi_model->descIngrediente($keyIngrediente);
                    $ingredienteNombre = ($ingrediente[0]['ingrediente_nombre']);
                    $imprIngrediente.="<tr>";
                    $imprIngrediente.="<td>".$keyIngrediente."</td>";
                    $imprIngrediente.="<td>".$ingredienteNombre."</td>";
                    $imprIngrediente.="<td>".$recomendacion."</td>";
                    $imprIngrediente.="</tr>";
                }
                $cargaForma.=$imprIngrediente;
                $cargaForma.="</tbody>
                        </table>
                    </div>
                </div>";
                echo($cargaForma);
            }
            else{
                echo("no_array");
            }
        }
    }
    /************************FINALIZA RECOMENDADOR DE COMPRAS*******************/
}
?>
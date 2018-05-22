<?php if (! defined('BASEPATH')) exit('No direct script access allowed');
 
class Ventas extends MX_Controller {
    
    function __construct(){
        parent::__construct();
        $this->urlBase = base_url();
    }
 
    function index(){
        echo("ventas.index");
    }
	
    //Formulario de registro de ventas
    function crearVenta(){
        //Se cargan los Estados desde el modelo Venta
        $this->load->model('venta');
        $estados = $this->venta->listaEstados();
        $clientes = $this->venta->listaClientes();
        $productos = $this->venta->listaProductos();
        $bodegas = $this->venta->listaBodegas();
        $id_venta = $this->venta->MaxId_Venta();
        $id_secuencia = $this->venta->MaxId_Secuencia($id_venta);
        $MoviVent = $this->venta->selMoviOrdeVent($id_venta);
        $imprOpci ="";
        $cargaForma = "<div class='row'>
                 <!-- page header -->
                <div class='col-lg-12'>
                    <h1 class='page-header'>Registrar Venta</h1>
                </div>
                <!--end page header -->
            </div>
            <div class='row'>
                <div class='col-lg-12'>
                    <!-- Form Elements -->
                    <div class='panel panel-default'>
                        <div class='panel-heading'>
                            Registro de Ventas
                        </div>
                        <div class='panel-body'>
                            <div class='row'>
                                <div class='col-lg-6'>
                                    <form role='form'>
                                        <div class='form-group'>
                                            <label>Código Venta</label>
                                            <input id='id-venta' class='form-control' placeholder='Código de la Venta.' value='$id_venta'>
                                        </div>
                                        
                                        <div class='form-group'>
                                            <label>Fecha</label>
                                            <input id='venta-fecha' type='date' data-format='dd-MM-yyyy' class='form-control' placeholder='dd-mm-yyyy'>
                                        </div>
                                        
                                        <div class='form-group'>
                                            <label>Estado</label>
                                            <select id='venta-estado-id' class='form-control'>";
        
        foreach ($estados as $keyEstado=>$estado){
            //Se acumula el html para las opciones
            $imprOpci.="<option>".$estados[$keyEstado]."</option>"
                       . "";
        }
        $cargaForma.=$imprOpci;
        $imprOpci = '';
        $cargaForma.="</select>
                                        </div>
                                        <button id='btn-guardar' href='#' onclick=\"insertaVenta('$this->urlBase')\" type='submit' class='btn btn-primary'>Añadir Venta</button>
                                        <button id='btn-cancelar' type='reset' class='btn btn-success'>Cancelar</button>
                                    </form>
                                </div>
                                <div class='col-lg-6'>
                                    <form role='form'>
                                        <div class='form-group'>
                                            <label>Cliente</label>
                                            <select id='venta-cliente-id' class='form-control'>";
        
        foreach ($clientes as $keyCliente=>$cliente){
            //Se acumula el html para las opciones
            $imprOpci.="<option>".$clientes[$keyCliente]."</option>"
                       . "";
        }
        $cargaForma.=$imprOpci;
        $imprOpci = '';
        $cargaForma.="</select>
                                        </div>
                                        
                                        <div class='form-group'>
                                            <label>Costo</label>
                                            <input id='venta-costo' class='form-control' placeholder='Costo Total de la Venta.' value ='0' disabled>
                                        </div>
                                        
                                        <div class='form-group'>
                                            <label>Descripción</label>
                                            <input id='venta-descripcion' class='form-control' placeholder='Descripción de la Venta.'>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                            
                        <div class='panel-heading'>
                            Movimientos de Venta
                        </div>
                        <div class='panel-body'>    
                            <div id='movivent' class='row'>
                                <div class='form-group'>
                                    <div id='lista'>
                                        <table class='table table-bordered'width='100%'  border='0' cellspacing='0' cellpadding='0' style='font-size:10px'>
                                            <thead>
                                                <tr>
                                                    <th>Secuencia</th>
                                                    <th>Producto</th>
                                                    <th>Cantidad</th>
                                                    <th>Costo Unitario</th>
                                                    <th>Costo Total</th>
                                                    <th>Bodega</th>
                                                    <th>Estado</th>
                                                    <th>Persona que Registra</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td><input id='id-movivent-secuencia' class='form-control' placeholder='Secuencia' value='$id_secuencia' disabled></td>
                                                    <td><select id='movivent-producto-id' class='form-control' disabled>";
        
        foreach ($productos as $keyProducto=>$producto){
            //Se acumula el html para las opciones
            $imprOpci.="<option>".$productos[$keyProducto]."</option>"
                       . "";
        }
        $cargaForma.=$imprOpci;
        $imprOpci = '';
        $cargaForma.="</select></td>
                                                    <td><input id='movivent-cantidad' class='form-control' placeholder='Cantidad' disabled></td>
                                                    <td><input id='movivent-costo-unit' class='form-control' placeholder='Costo Unitario' disabled></td>
                                                    <td><input id='movivent-costo-total' class='form-control' placeholder='Costo Total' value=0 disabled></td>
                                                    <td><select id='movivent-bodega-id' class='form-control' disabled>";
        
        foreach ($bodegas as $keyBodega=>$bodega){
            //Se acumula el html para las opciones
            $imprOpci.="<option>".$bodegas[$keyBodega]."</option>"
                       . "";
        }
        $cargaForma.=$imprOpci;
        $imprOpci = '';
        $cargaForma.="</select></td>
                                                    <td><select id='movivent-estado-id' class='form-control' disabled>";
        
        foreach ($estados as $keyEstado=>$estado){
            //Se acumula el html para las opciones
            $imprOpci.="<option>".$estados[$keyEstado]."</option>"
                       . "";
        }
        $cargaForma.=$imprOpci;
        $imprOpci = '';
        $cargaForma.="</select></td>
                                                    <td><button id='btn-guardar-movivent' href='#' onclick=\"insertaMovivent('$this->urlBase')\" type='submit' class='btn btn-default btn-circle' disabled><i class='fa fa-check'></i></button></td>
                                                </tr>";
        
        if($MoviVent != false){
            $imprMoviVent = "";
            //$cargaForma.= "<tbody>";
            $posiinic = 0;                                                
            foreach ($MoviVent as $keyMoviVent=>$cliente){
                //Se acumula el html para los clientes
                $id_movivent_secuencia = substr($MoviVent[$keyMoviVent],$posiinic,strpos($MoviVent[$keyMoviVent],'|',$posiinic) - $posiinic);
                $posiinic = strpos($MoviVent[$keyMoviVent],'|',$posiinic) + 1;

                $movivent_producto_id = substr($MoviVent[$keyMoviVent],$posiinic,strpos($MoviVent[$keyMoviVent],'|',$posiinic) - $posiinic);
                $posiinic = strpos($MoviVent[$keyMoviVent],'|',$posiinic) + 1;

                $movivent_cantidad = substr($MoviVent[$keyMoviVent],$posiinic,strpos($MoviVent[$keyMoviVent],'|',$posiinic) - $posiinic);
                $posiinic = strpos($MoviVent[$keyMoviVent],'|',$posiinic) + 1;

                $movivent_costo_unit = substr($MoviVent[$keyMoviVent],$posiinic,strpos($MoviVent[$keyMoviVent],'|',$posiinic) - $posiinic);
                $posiinic = strpos($MoviVent[$keyMoviVent],'|',$posiinic) + 1;

                $movivent_costo_total = substr($MoviVent[$keyMoviVent],$posiinic,strpos($MoviVent[$keyMoviVent],'|',$posiinic) - $posiinic);
                $posiinic = strpos($MoviVent[$keyMoviVent],'|',$posiinic) + 1;

                $movivent_bodega_id = substr($MoviVent[$keyMoviVent],$posiinic,strpos($MoviVent[$keyMoviVent],'|',$posiinic) - $posiinic);
                $posiinic = strpos($MoviVent[$keyMoviVent],'|',$posiinic) + 1;

                $movivent_estado_id = substr($MoviVent[$keyMoviVent],$posiinic,strpos($MoviVent[$keyMoviVent],'|',$posiinic) - $posiinic);
                $posiinic = strpos($MoviVent[$keyMoviVent],'|',$posiinic) + 1;

                $imprMoviVent.="<tr>";
                $imprMoviVent.="<td>".$id_movivent_secuencia."</td>";
                $imprMoviVent.="<td>".$movivent_producto_id."</td>";
                $imprMoviVent.="<td>".$movivent_cantidad."</td>";
                $imprMoviVent.="<td>".$movivent_costo_unit."</td>";
                $imprMoviVent.="<td>".$movivent_costo_total."</td>";
                $imprMoviVent.="<td>".$movivent_bodega_id."</td>";
                $imprMoviVent.="<td>".$movivent_estado_id."</td>";
                $imprMoviVent.="</tr>";
                $posiinic = 0;
            }
            $cargaForma.=$imprMoviVent;
            $imprMoviVent   = '';
            $cargaForma.="</tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>";
        }
        else{
            $cargaForma.="</tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>";
        }
        $cargaForma.= "</div>
                    </div>
                </div>
            </div>";
        echo($cargaForma);
    }
    
    //Formulario de modificación de ventas
    function modificarVenta(){
        if($this->session->userdata('logged_in')){
            $this->load->model('venta');
            $codigoVent          = $_POST['idVenta'];
            $venta              = $this->venta->selIdVenta($codigoVent);
            $id_venta           = $venta[0]['id_venta'];
            $venta_cliente_id = $venta[0]['venta_cliente_id'];
            $cliente           = $this->venta->selCliente($venta_cliente_id);
            $venta_cliente    = $cliente[0]['cliente'];
            $venta_fecha        = $venta[0]['venta_fecha'];
            $venta_costo        = $venta[0]['venta_costo'];
            $venta_descripcion  = $venta[0]['venta_descripcion'];
            $venta_estado_id    = $venta[0]['venta_estado_id'];
            $estado              = $this->venta->selEstado($venta_estado_id);
            $venta_estado       = $estado[0]['estado'];
            $MoviOrdeVent        = $this->venta->selMoviOrdeVent($id_venta);
            $id_secuencia        = $this->venta->MaxId_Secuencia($id_venta);
            
            $estados = $this->venta->listaEstados();
            $clientes = $this->venta->listaClientes();
            $productos = $this->venta->listaProductos();
            $bodegas = $this->venta->listaBodegas();
            $imprOpci                 = "";
            
            $cargaForma = "<div class='row'>
                 <!-- page header -->
                <div class='col-lg-12'>
                    <h1 class='page-header'>Modificar Venta</h1>
                </div>
                <!--end page header -->
            </div>
            <div class='row'>
                <div class='col-lg-12'>
                    <!-- Form Elements -->
                    <div class='panel panel-default'>
                        <div class='panel-heading'>
                            Modificación de Ventas
                        </div>
                        <div class='panel-body'>
                            <div class='row'>
                                <div class='col-lg-6'>
                                    <form role='form'>
                                        <div class='form-group'>
                                            <label>Código Venta</label>
                                            <input id='id-venta' class='form-control' placeholder='Código de la Venta.' value='$id_venta' disabled>
                                        </div>
                                        
                                        <div class='form-group'>
                                            <label>Fecha</label>
                                            <input id='venta-fecha' type='date' data-format='dd-MM-yyyy' class='form-control' placeholder='dd-mm-yyyy' value='$venta_fecha'>
                                        </div>
                                        
                                        <div class='form-group'>
                                            <label>Estado</label>
                                            <select id='venta-estado-id' class='form-control'>";
        
            foreach ($estados as $keyEstado=>$estado){
                //Se acumula el html para las opciones
                if($venta_estado == $estados[$keyEstado]){
                    $imprOpci.="<option selected>".$estados[$keyEstado]."</option>";
                }
                else{
                    $imprOpci.="<option>".$estados[$keyEstado]."</option>";
                }
            }
            $cargaForma.=$imprOpci;
            $imprOpci = '';
            $cargaForma.="</select>
                                            </div>
                                            <button id='btn-guardar' href='#' onclick=\"actualizaVenta('$this->urlBase')\" type='submit' class='btn btn-primary'>Actualizar Venta</button>
                                            <button id='btn-cancelar' type='reset' class='btn btn-success'>Cancelar</button>
                                        </form>
                                    </div>
                                    <div class='col-lg-6'>
                                        <form role='form'>
                                            <div class='form-group'>
                                                <label>Cliente</label>
                                                <select id='venta-cliente-id' class='form-control'>";

            foreach ($clientes as $keyCliente=>$cliente){
                //Se acumula el html para las opciones
                if($venta_cliente == $clientes[$keyCliente]){
                    $imprOpci.="<option selected>".$clientes[$keyCliente]."</option>";
                }
                else{
                    $imprOpci.="<option>".$clientes[$keyCliente]."</option>";
                }
            }
            $cargaForma.=$imprOpci;
            $imprOpci = '';
            $cargaForma.="</select>
                                            </div>

                                            <div class='form-group'>
                                                <label>Costo</label>
                                                <input id='venta-costo' class='form-control' placeholder='Costo Total de la Venta.' value='$venta_costo' disabled>
                                            </div>

                                            <div class='form-group'>
                                                <label>Descripción</label>
                                                <input id='venta-descripcion' class='form-control' placeholder='Descripción de la Venta.' value='$venta_descripcion'>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>

                            <div class='panel-heading'>
                                Movimientos de Venta
                            </div>
                            <div class='panel-body'>    
                                <div id='movivent' class='row'>
                                    <div class='form-group'>
                                        <div id='lista'>
                                            <table class='table table-bordered'width='100%'  border='0' cellspacing='0' cellpadding='0' style='font-size:10px'>
                                                <thead>
                                                    <tr>
                                                        <th>Secuencia</th>
                                                        <th>Producto</th>
                                                        <th>Cantidad</th>
                                                        <th>Costo Unitario</th>
                                                        <th>Costo Total</th>
                                                        <th>Bodega</th>
                                                        <th>Estado</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td><input id='id-movivent-secuencia' class='form-control' placeholder='Secuencia' value='$id_secuencia' disabled></td>
                                                        <td><select id='movivent-producto-id' class='form-control'>";

            foreach ($productos as $keyProducto=>$producto){
                //Se acumula el html para las opciones
                $imprOpci.="<option>".$productos[$keyProducto]."</option>"
                           . "";
            }
            $cargaForma.=$imprOpci;
            $imprOpci = '';
            $cargaForma.="</select></td>
                                                        <td><input id='movivent-cantidad' class='form-control' placeholder='Cantidad'></td>
                                                        <td><input id='movivent-costo-unit' class='form-control' placeholder='Costo Unitario'></td>
                                                        <td><input id='movivent-costo-total' class='form-control' placeholder='Costo Total' value=0 disabled></td>
                                                        <td><select id='movivent-bodega-id' class='form-control'>";

            foreach ($bodegas as $keyBodega=>$bodega){
                //Se acumula el html para las opciones
                $imprOpci.="<option>".$bodegas[$keyBodega]."</option>"
                           . "";
            }
            $cargaForma.=$imprOpci;
            $imprOpci = '';
            $cargaForma.="</select></td>
                                                        <td><select id='venta-estado-id' class='form-control'>";

            foreach ($estados as $keyEstado=>$estado){
                //Se acumula el html para las opciones
                $imprOpci.="<option>".$estados[$keyEstado]."</option>"
                           . "";
            }
            $cargaForma.=$imprOpci;
            $imprOpci = '';
            $cargaForma.="</select></td>
                                                        <td><button id='btn-guardar-movivent' href='#' onclick=\"insertaMovivent('$this->urlBase')\" type='submit' class='btn btn-default btn-circle'><i class='fa fa-check'></i></button></td>
                                                    </tr>";

            if($MoviOrdeVent != false){
                $imprMoviVent = "";
                //$cargaForma.= "<tbody>";
                $posiinic = 0;                                                
                foreach ($MoviOrdeVent as $keyMoviOrdeVent=>$cliente){
                    //Se acumula el html para los clientes
                    $id_movivent_secuencia = substr($MoviOrdeVent[$keyMoviOrdeVent],$posiinic,strpos($MoviOrdeVent[$keyMoviOrdeVent],'|',$posiinic) - $posiinic);
                    $posiinic = strpos($MoviOrdeVent[$keyMoviOrdeVent],'|',$posiinic) + 1;

                    $movivent_producto_id = substr($MoviOrdeVent[$keyMoviOrdeVent],$posiinic,strpos($MoviOrdeVent[$keyMoviOrdeVent],'|',$posiinic) - $posiinic);
                    $descProducto = $this->venta->descProducto($movivent_producto_id);
                    $descProducto = $descProducto[0]['producto_nombre'];
                    $posiinic = strpos($MoviOrdeVent[$keyMoviOrdeVent],'|',$posiinic) + 1;

                    $movivent_cantidad = substr($MoviOrdeVent[$keyMoviOrdeVent],$posiinic,strpos($MoviOrdeVent[$keyMoviOrdeVent],'|',$posiinic) - $posiinic);
                    $posiinic = strpos($MoviOrdeVent[$keyMoviOrdeVent],'|',$posiinic) + 1;

                    $movivent_costo_unit = substr($MoviOrdeVent[$keyMoviOrdeVent],$posiinic,strpos($MoviOrdeVent[$keyMoviOrdeVent],'|',$posiinic) - $posiinic);
                    $posiinic = strpos($MoviOrdeVent[$keyMoviOrdeVent],'|',$posiinic) + 1;

                    $movivent_costo_total = substr($MoviOrdeVent[$keyMoviOrdeVent],$posiinic,strpos($MoviOrdeVent[$keyMoviOrdeVent],'|',$posiinic) - $posiinic);
                    $posiinic = strpos($MoviOrdeVent[$keyMoviOrdeVent],'|',$posiinic) + 1;

                    $movivent_bodega_id = substr($MoviOrdeVent[$keyMoviOrdeVent],$posiinic,strpos($MoviOrdeVent[$keyMoviOrdeVent],'|',$posiinic) - $posiinic);
                    $descBodega = $this->venta->descBodega($movivent_bodega_id);
                    $descBodega = $descBodega[0]['bodega_nombre'];
                    $posiinic = strpos($MoviOrdeVent[$keyMoviOrdeVent],'|',$posiinic) + 1;

                    $movivent_estado_id = substr($MoviOrdeVent[$keyMoviOrdeVent],$posiinic,strpos($MoviOrdeVent[$keyMoviOrdeVent],'|',$posiinic) - $posiinic);
                    $descEstado = $this->venta->descEstado($movivent_estado_id);
                    $descEstado = $descEstado[0]['estado_descripcion'];
                    $posiinic = strpos($MoviOrdeVent[$keyMoviOrdeVent],'|',$posiinic) + 1;

                    $imprMoviVent.="<tr>";
                    $imprMoviVent.="<td>".$id_movivent_secuencia."</td>";
                    $imprMoviVent.="<td>".$descProducto."</td>";
                    $imprMoviVent.="<td>".$movivent_cantidad."</td>";
                    $imprMoviVent.="<td>".$movivent_costo_unit."</td>";
                    $imprMoviVent.="<td>".$movivent_costo_total."</td>";
                    $imprMoviVent.="<td>".$descBodega."</td>";
                    $imprMoviVent.="<td>".$descEstado."</td>";
                    $imprMoviVent.="<td><button id='btn-eliminar' href='#' onclick=\"borraMovivent('$this->urlBase','$codigoVent','$id_movivent_secuencia','$movivent_bodega_id','$movivent_producto_id','$movivent_cantidad')\" type='submit' class='btn btn-danger btn-circle'><i class='fa fa-times'></i></button></td>";
                    $imprMoviVent.="</tr>";
                    $posiinic = 0;
                }
                $cargaForma.=$imprMoviVent;
                $imprMoviVent = '';
                $cargaForma.="</tbody>
                                        </table>
                                    </div>
                                </div>";
            }
            else{
                $cargaForma.="</tbody>
                                        </table>
                                    </div>
                                </div>";
            }
            $cargaForma.= "</div>
                        </div>
                    </div>
                </div>";
            echo($cargaForma);
            }
        else{
            echo('No se ha logueado');
            redirect('contenedor');
        }
    }
    
    //Formulario de consulta de ventas
    function consultarVenta(){
        if($this->session->userdata('logged_in')){
            $this->load->model('venta');
            $ventas = $this->venta->selVentas("");
            $imprVenta = "";
            $cargaForma  = "<div class='row' onload='consultaVenta('$this->urlBase')'>
                        <!-- Page Header -->
                        <div class='col-lg-12'>
                            <h1 class='page-header'>Consultar Venta</h1>
                        </div>
                        <!--End Page Header -->
                    </div>
                    <div class='row'>
                        <div class='col-lg-12'>
                            <!-- Advanced Tables -->
                            <div class='panel panel-default'>
                                <div class='panel-heading'>
                                     Consulta de Ventas
                                </div>
                                <div class='panel-body'>
                                    <div class='table-responsive'>
                                        <div id='dataTables-example_wrapper' class='dataTables_wrapper form-inline' role='grid'>
                                            <div class='row'>
                                                <div class='col-sm-6'>
                                                    <!-- search section-->
                                                    <div id='dataTables-example_filter' class='dataTables_filter'>
                                                        <span class='input-group-btn'>
                                                            <input type='search' id='venta-valor' class='form-control input-sm' aria-controls='dataTables-example' placeholder='Buscar'>
                                                            <button id='busca-venta' class='btn btn-default' onclick=\"consultaVenta('$this->urlBase')\" type='submit'><i class='fa fa-search'></i></button>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div id='ventas' class='row'>
                                                <div class='form-group'>
                                                    <div id='lista'>
                                                        <table class='table table-bordered'width='100%'  border='0' cellspacing='0' cellpadding='0' style='font-size:10px'>
                                                            <thead>
                                                                <tr>
                                                                    <th>Código Venta</th>
                                                                    <th>Código Cliente</th>
                                                                    <th>Nombre Cliente</th>
                                                                    <th>Fecha</th>
                                                                    <th>Costo</th>
                                                                    <th>Descripción</th>
                                                                    <th>Estado</th>
                                                                </tr>
                                                            </thead>";
            if($ventas != false){
                $imprVenta = "";
                $cargaForma.= "<tbody>";
                $posiinic = 0;
                foreach ($ventas as $keyVenta=>$venta){
                    //Se acumula el html para los clientes
                    $idVenta = substr($ventas[$keyVenta],$posiinic,strpos($ventas[$keyVenta],'|',$posiinic) - $posiinic);
                    $posiinic = strpos($ventas[$keyVenta],'|',$posiinic) + 1;

                    $ventaCliente = substr($ventas[$keyVenta],$posiinic,strpos($ventas[$keyVenta],'|',$posiinic) - $posiinic);
                    $descCliente = $this->venta->descCliente($ventaCliente);
                    $descCliente = $descCliente[0]['cliente_nombre'];
                    $posiinic = strpos($ventas[$keyVenta],'|',$posiinic) + 1;

                    $ventaFecha = substr($ventas[$keyVenta],$posiinic,strpos($ventas[$keyVenta],'|',$posiinic) - $posiinic);
                    $posiinic = strpos($ventas[$keyVenta],'|',$posiinic) + 1;

                    $ventaCosto = substr($ventas[$keyVenta],$posiinic,strpos($ventas[$keyVenta],'|',$posiinic) - $posiinic);
                    $posiinic = strpos($ventas[$keyVenta],'|',$posiinic) + 1;

                    $ventaDescr = substr($ventas[$keyVenta],$posiinic,strpos($ventas[$keyVenta],'|',$posiinic) - $posiinic);
                    $posiinic = strpos($ventas[$keyVenta],'|',$posiinic) + 1;
                    
                    $ventaEstado = substr($ventas[$keyVenta],$posiinic,strpos($ventas[$keyVenta],'|',$posiinic) - $posiinic);
                    $descEstado = $this->venta->descEstado($ventaEstado);
                    $descEstado = $descEstado[0]['estado_descripcion'];
                    $posiinic = strpos($ventas[$keyVenta],'|',$posiinic) + 1;

                    $imprVenta.="<tr>";
                    $imprVenta.="<td>".$idVenta."</td>";
                    $imprVenta.="<td>".$ventaCliente."</td>";
                    $imprVenta.="<td>".$descCliente."</td>";
                    $imprVenta.="<td>".$ventaFecha."</td>";
                    $imprVenta.="<td>".$ventaCosto."</td>";
                    $imprVenta.="<td>".$ventaDescr."</td>";
                    $imprVenta.="<td>".$descEstado."</td>";
                    $imprVenta.="<td><button id='btn-modificar' href='#' onclick=\"modificaVenta('$this->urlBase','$idVenta')\" type='submit' class='btn btn-default btn-circle'><i class='fa fa-pencil'></i></button></td>";
                    $imprVenta.="<td><button id='btn-eliminar' href='#' onclick=\"borraVenta('$this->urlBase','$idVenta')\" type='submit' class='btn btn-danger btn-circle'><i class='fa fa-times'></i></button></td>";
                    $imprVenta.="</tr>";
                    $posiinic = 0;
                }
                $cargaForma.=$imprVenta;
                $imprVenta   = '';
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
            }
            else{
                $cargaForma.="</table>
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
            echo $cargaForma;
        }
        else{
            echo('No se ha logueado');
            redirect('contenedor');
        }
    }
    
    //Proceso de registro de ventas.
    function guardarVenta(){
        $this->load->model('venta');
        $codigoVent    = $_POST['idVent'];
        $clienteVent = $_POST['clienteVent'];
        $clienteCodi = substr($clienteVent,0,strpos($clienteVent,'-',0) - 1);
        $fechaVent     = $_POST['fechaVent'];
        $costoVent     = $_POST['costoVent'];
        $estadoVent    = $_POST['estadoVent'];
        $estadoCodi    = substr($estadoVent,0,strpos($estadoVent,'-',0) - 1);
        $descriVent    = $_POST['descriVent'];
        $venta        = $this->venta->insVenta($codigoVent,$clienteCodi,$fechaVent,$estadoCodi,$descriVent);
        if(isset($venta)){
            $estados = $this->venta->listaEstados();
            $productos = $this->venta->listaProductos();
            $bodegas = $this->venta->listaBodegas();
            $id_venta = $codigoVent;
            $id_secuencia = $this->venta->MaxId_Secuencia($id_venta);
            $imprOpci ="";
            $cargaForma = "<div class='form-group'>
                                    <div id='lista'>
                                        <table class='table table-bordered'width='100%'  border='0' cellspacing='0' cellpadding='0' style='font-size:10px'>
                                            <thead>
                                                <tr>
                                                    <th>Secuencia</th>
                                                    <th>Producto</th>
                                                    <th>Cantidad</th>
                                                    <th>Costo Unitario</th>
                                                    <th>Costo Total</th>
                                                    <th>Bodega</th>
                                                    <th>Estado</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td><input id='id-movivent-secuencia' class='form-control' placeholder='Secuencia' value='$id_secuencia' disabled></td>
                                                    <td><select id='movivent-producto-id' class='form-control'>";
        
            foreach ($productos as $keyProducto=>$producto){
                //Se acumula el html para las opciones
                $imprOpci.="<option>".$productos[$keyProducto]."</option>"
                           . "";
            }
            $cargaForma.=$imprOpci;
            $imprOpci = '';
            $cargaForma.="</select></td>
                                                    <td><input id='movivent-cantidad' class='form-control' placeholder='Cantidad'></td>
                                                    <td><input id='movivent-costo-unit' class='form-control' placeholder='Costo Unitario'></td>
                                                    <td><input id='movivent-costo-total' class='form-control' placeholder='Costo Total' value=0 disabled></td>
                                                    <td><select id='movivent-bodega-id' class='form-control'>";
        
            foreach ($bodegas as $keyBodega=>$bodega){
                //Se acumula el html para las opciones
                $imprOpci.="<option>".$bodegas[$keyBodega]."</option>"
                           . "";
            }
            $cargaForma.=$imprOpci;
            $imprOpci = '';
            $cargaForma.="</select></td>
                                                    <td><select id='movivent-estado-id' class='form-control'>";
        
            foreach ($estados as $keyEstado=>$estado){
                //Se acumula el html para las opciones
                $imprOpci.="<option>".$estados[$keyEstado]."</option>"
                           . "";
            }
            $cargaForma.=$imprOpci;
            $imprOpci = '';
            $cargaForma.="</select></td>
                                                    <td><button id='btn-guardar-movivent' href='#' onclick=\"insertaMovivent('$this->urlBase')\" type='submit' class='btn btn-default btn-circle'><i class='fa fa-check'></i></button></td>
                                                </tr>";
            echo($cargaForma);
        }
        else{
            $cargaForma = "";
            echo($cargaForma);
        }
    }
    
    //Consulta una venta por el identificador de venta.
    function obtenerVenta(){
        $this->load->model('venta');
        $idVenta = $_POST['idVent'];
        $venta     = $this->venta->selVenta($idVenta);
        echo($venta);
    }
    
    //Registra un movimiento de venta
    function guardarMovivent(){
        $this->load->model('venta');
        $idVentaMovi    = $_POST['id_venta'];
        $secuenciaMovi  = $_POST['secuencia'];
        $productoMovi   = $_POST['producto'];
        $productoCodi   = substr($productoMovi,0,strpos($productoMovi,'-',0) - 1);
        $cantidadMovi   = $_POST['cantidad'];
        $costoUnitMovi  = $_POST['costo_unit'];
        $costoTotalMovi = $_POST['costo_total'];
        $bodegaMovi     = $_POST['bodega'];
        $bodegaCodi     = substr($bodegaMovi,0,strpos($bodegaMovi,'-',0) - 1);
        $estadoMovi     = $_POST['estado'];
        $estadoCodi     = substr($estadoMovi,0,strpos($estadoMovi,'-',0) - 1);
        $personaMovi    = $this->session->userdata('idPers');
        $movivent       = $this->venta->insMovivent($idVentaMovi,$secuenciaMovi,$productoCodi,$cantidadMovi,
                                                     $costoUnitMovi,$costoTotalMovi,$bodegaCodi,$estadoCodi,
                                                     $personaMovi);
        if(isset($movivent)){
            $estados = $this->venta->listaEstados();
            $productos = $this->venta->listaProductos();
            $bodegas = $this->venta->listaBodegas();
            $id_venta = $idVentaMovi;
            $id_secuencia = $this->venta->MaxId_Secuencia($id_venta);
            $MoviOrdeVent = $this->venta->selMoviOrdeVent($id_venta);
            $imprOpci ="";
            $cargaForma = "<div class='form-group'>
                                    <div id='lista'>
                                        <table class='table table-bordered'width='100%'  border='0' cellspacing='0' cellpadding='0' style='font-size:10px'>
                                            <thead>
                                                <tr>
                                                    <th>Secuencia</th>
                                                    <th>Producto</th>
                                                    <th>Cantidad</th>
                                                    <th>Costo Unitario</th>
                                                    <th>Costo Total</th>
                                                    <th>Bodega</th>
                                                    <th>Estado</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td><input id='id-movivent-secuencia' class='form-control' placeholder='Secuencia' value='$id_secuencia' disabled></td>
                                                    <td><select id='movivent-producto-id' class='form-control'>";
        
            foreach ($productos as $keyProducto=>$producto){
                //Se acumula el html para las opciones
                $imprOpci.="<option>".$productos[$keyProducto]."</option>"
                           . "";
            }
            $cargaForma.=$imprOpci;
            $imprOpci = '';
            $cargaForma.="</select></td>
                                                    <td><input id='movivent-cantidad' class='form-control' placeholder='Cantidad'></td>
                                                    <td><input id='movivent-costo-unit' class='form-control' placeholder='Costo Unitario'></td>
                                                    <td><input id='movivent-costo-total' class='form-control' placeholder='Costo Total' value=0 disabled></td>
                                                    <td><select id='movivent-bodega-id' class='form-control'>";
        
            foreach ($bodegas as $keyBodega=>$bodega){
                //Se acumula el html para las opciones
                $imprOpci.="<option>".$bodegas[$keyBodega]."</option>"
                           . "";
            }
            $cargaForma.=$imprOpci;
            $imprOpci = '';
            $cargaForma.="</select></td>
                                                    <td><select id='movivent-estado-id' class='form-control'>";
        
            foreach ($estados as $keyEstado=>$estado){
                //Se acumula el html para las opciones
                $imprOpci.="<option>".$estados[$keyEstado]."</option>"
                           . "";
            }
            $cargaForma.=$imprOpci;
            $imprOpci = '';
            $cargaForma.="</select></td>
                                                    <td><button id='btn-guardar-movivent' href='#' onclick=\"insertaMovivent('$this->urlBase')\" type='submit' class='btn btn-default btn-circle'><i class='fa fa-check'></i></button></td>
                                                </tr>";
        
            if($MoviOrdeVent != false){
                $imprMoviVent = "";
                $posiinic = 0;                                                
                foreach ($MoviOrdeVent as $keyMoviOrdeVent=>$cliente){
                    //Se acumula el html para los movimientos de venta
                    $id_movivent_secuencia = substr($MoviOrdeVent[$keyMoviOrdeVent],$posiinic,strpos($MoviOrdeVent[$keyMoviOrdeVent],'|',$posiinic) - $posiinic);
                    $posiinic = strpos($MoviOrdeVent[$keyMoviOrdeVent],'|',$posiinic) + 1;

                    $movivent_producto_id = substr($MoviOrdeVent[$keyMoviOrdeVent],$posiinic,strpos($MoviOrdeVent[$keyMoviOrdeVent],'|',$posiinic) - $posiinic);
                    $descProducto = $this->venta->descProducto($movivent_producto_id);
                    $descProducto = $descProducto[0]['producto_nombre'];
                    $posiinic = strpos($MoviOrdeVent[$keyMoviOrdeVent],'|',$posiinic) + 1;

                    $movivent_cantidad = substr($MoviOrdeVent[$keyMoviOrdeVent],$posiinic,strpos($MoviOrdeVent[$keyMoviOrdeVent],'|',$posiinic) - $posiinic);
                    $posiinic = strpos($MoviOrdeVent[$keyMoviOrdeVent],'|',$posiinic) + 1;

                    $movivent_costo_unit = substr($MoviOrdeVent[$keyMoviOrdeVent],$posiinic,strpos($MoviOrdeVent[$keyMoviOrdeVent],'|',$posiinic) - $posiinic);
                    $posiinic = strpos($MoviOrdeVent[$keyMoviOrdeVent],'|',$posiinic) + 1;

                    $movivent_costo_total = substr($MoviOrdeVent[$keyMoviOrdeVent],$posiinic,strpos($MoviOrdeVent[$keyMoviOrdeVent],'|',$posiinic) - $posiinic);
                    $posiinic = strpos($MoviOrdeVent[$keyMoviOrdeVent],'|',$posiinic) + 1;

                    $movivent_bodega_id = substr($MoviOrdeVent[$keyMoviOrdeVent],$posiinic,strpos($MoviOrdeVent[$keyMoviOrdeVent],'|',$posiinic) - $posiinic);
                    $descBodega = $this->venta->descBodega($movivent_bodega_id);
                    $descBodega = $descBodega[0]['bodega_nombre'];
                    $posiinic = strpos($MoviOrdeVent[$keyMoviOrdeVent],'|',$posiinic) + 1;

                    $movivent_estado_id = substr($MoviOrdeVent[$keyMoviOrdeVent],$posiinic,strpos($MoviOrdeVent[$keyMoviOrdeVent],'|',$posiinic) - $posiinic);
                    $descEstado = $this->venta->descEstado($movivent_estado_id);
                    $descEstado = $descEstado[0]['estado_descripcion'];
                    $posiinic = strpos($MoviOrdeVent[$keyMoviOrdeVent],'|',$posiinic) + 1;

                    $imprMoviVent.="<tr>";
                    $imprMoviVent.="<td>".$id_movivent_secuencia."</td>";
                    $imprMoviVent.="<td>".$descProducto."</td>";
                    $imprMoviVent.="<td>".$movivent_cantidad."</td>";
                    $imprMoviVent.="<td>".$movivent_costo_unit."</td>";
                    $imprMoviVent.="<td>".$movivent_costo_total."</td>";
                    $imprMoviVent.="<td>".$descBodega."</td>";
                    $imprMoviVent.="<td>".$descEstado."</td>";
                    $imprMoviVent.="<td><button id='btn-eliminar' href='#' onclick=\"borraMovivent('$this->urlBase','$idVentaMovi','$id_movivent_secuencia','$movivent_bodega_id','$movivent_producto_id','$movivent_cantidad')\" type='submit' class='btn btn-danger btn-circle'><i class='fa fa-times'></i></button></td>";
                    $imprMoviVent.="</tr>";
                    $posiinic = 0;
                }
            $cargaForma.=$imprMoviVent;
            $imprMoviVent = '';
            $cargaForma.="</tbody>
                                        </table>
                                    </div>
                                </div>";
            }
            else{
                $cargaForma.="</tbody>
                                        </table>
                                    </div>
                                </div>";
            }
            echo($cargaForma);
        }
        else{
            $cargaForma = "";
            echo($cargaForma);
        }
    }
    
    //Consulta un movimiento de venta por Identificador de venta y secuencia.
    function obtenerMovivent(){
        $this->load->model('venta');
        $idVenta  = $_POST['idVent'];
        $secuencia = $_POST['secuencia'];
        $venta    = $this->venta->selMovivent($idVenta,$secuencia);
        echo($venta);
    }
    
    //Borra un movimiento de venta.
    function eliminarMovivent(){
        $this->load->model('venta');
        $idVentaMovi   = $_POST['idVenta'];
        $secuenciaMovi  = $_POST['idSecuencia'];
        $movivent       = $this->venta->borMovivent($idVentaMovi,$secuenciaMovi);
        if(isset($movivent)){
            $estados = $this->venta->listaEstados();
            $productos = $this->venta->listaProductos();
            $bodegas = $this->venta->listaBodegas();
            $id_venta = $idVentaMovi;
            $id_secuencia = $this->venta->MaxId_Secuencia($id_venta);
            $MoviOrdeVent = $this->venta->selMoviOrdeVent($id_venta);
            $imprOpci ="";
            $cargaForma = "<div class='form-group'>
                                    <div id='lista'>
                                        <table class='table table-bordered'width='100%'  border='0' cellspacing='0' cellpadding='0' style='font-size:10px'>
                                            <thead>
                                                <tr>
                                                    <th>Secuencia</th>
                                                    <th>Producto</th>
                                                    <th>Cantidad</th>
                                                    <th>Costo Unitario</th>
                                                    <th>Costo Total</th>
                                                    <th>Bodega</th>
                                                    <th>Estado</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td><input id='id-movivent-secuencia' class='form-control' placeholder='Secuencia' value='$id_secuencia' disabled></td>
                                                    <td><select id='movivent-producto-id' class='form-control'>";
        
            foreach ($productos as $keyProducto=>$producto){
                //Se acumula el html para las opciones
                $imprOpci.="<option>".$productos[$keyProducto]."</option>"
                           . "";
            }
            $cargaForma.=$imprOpci;
            $imprOpci = '';
            $cargaForma.="</select></td>
                                                    <td><input id='movivent-cantidad' class='form-control' placeholder='Cantidad'></td>
                                                    <td><input id='movivent-costo-unit' class='form-control' placeholder='Costo Unitario'></td>
                                                    <td><input id='movivent-costo-total' class='form-control' placeholder='Costo Total' value=0 disabled></td>
                                                    <td><select id='movivent-bodega-id' class='form-control'>";
        
            foreach ($bodegas as $keyBodega=>$bodega){
                //Se acumula el html para las opciones
                $imprOpci.="<option>".$bodegas[$keyBodega]."</option>"
                           . "";
            }
            $cargaForma.=$imprOpci;
            $imprOpci = '';
            $cargaForma.="</select></td>
                                                    <td><select id='venta-estado-id' class='form-control'>";
        
            foreach ($estados as $keyEstado=>$estado){
                //Se acumula el html para las opciones
                $imprOpci.="<option>".$estados[$keyEstado]."</option>"
                           . "";
            }
            $cargaForma.=$imprOpci;
            $imprOpci = '';
            $cargaForma.="</select></td>
                                                    <td><button id='btn-guardar-movivent' href='#' onclick=\"insertaMovivent('$this->urlBase')\" type='submit' class='btn btn-default btn-circle'><i class='fa fa-check'></i></button></td>
                                                </tr>";
        
            if($MoviOrdeVent != false){
                $imprMoviVent = "";
                //$cargaForma.= "<tbody>";
                $posiinic = 0;                                                
                foreach ($MoviOrdeVent as $keyMoviOrdeVent=>$cliente){
                    //Se acumula el html para los clientes
                    $id_movivent_secuencia = substr($MoviOrdeVent[$keyMoviOrdeVent],$posiinic,strpos($MoviOrdeVent[$keyMoviOrdeVent],'|',$posiinic) - $posiinic);
                    $posiinic = strpos($MoviOrdeVent[$keyMoviOrdeVent],'|',$posiinic) + 1;

                    $movivent_producto_id = substr($MoviOrdeVent[$keyMoviOrdeVent],$posiinic,strpos($MoviOrdeVent[$keyMoviOrdeVent],'|',$posiinic) - $posiinic);
                    $descProducto = $this->venta->descProducto($movivent_producto_id);
                    $descProducto = $descProducto[0]['producto_nombre'];
                    $posiinic = strpos($MoviOrdeVent[$keyMoviOrdeVent],'|',$posiinic) + 1;

                    $movivent_cantidad = substr($MoviOrdeVent[$keyMoviOrdeVent],$posiinic,strpos($MoviOrdeVent[$keyMoviOrdeVent],'|',$posiinic) - $posiinic);
                    $posiinic = strpos($MoviOrdeVent[$keyMoviOrdeVent],'|',$posiinic) + 1;

                    $movivent_costo_unit = substr($MoviOrdeVent[$keyMoviOrdeVent],$posiinic,strpos($MoviOrdeVent[$keyMoviOrdeVent],'|',$posiinic) - $posiinic);
                    $posiinic = strpos($MoviOrdeVent[$keyMoviOrdeVent],'|',$posiinic) + 1;

                    $movivent_costo_total = substr($MoviOrdeVent[$keyMoviOrdeVent],$posiinic,strpos($MoviOrdeVent[$keyMoviOrdeVent],'|',$posiinic) - $posiinic);
                    $posiinic = strpos($MoviOrdeVent[$keyMoviOrdeVent],'|',$posiinic) + 1;

                    $movivent_bodega_id = substr($MoviOrdeVent[$keyMoviOrdeVent],$posiinic,strpos($MoviOrdeVent[$keyMoviOrdeVent],'|',$posiinic) - $posiinic);
                    $descBodega = $this->venta->descBodega($movivent_bodega_id);
                    $descBodega = $descBodega[0]['bodega_nombre'];
                    $posiinic = strpos($MoviOrdeVent[$keyMoviOrdeVent],'|',$posiinic) + 1;

                    $movivent_estado_id = substr($MoviOrdeVent[$keyMoviOrdeVent],$posiinic,strpos($MoviOrdeVent[$keyMoviOrdeVent],'|',$posiinic) - $posiinic);
                    $descEstado = $this->venta->descEstado($movivent_estado_id);
                    $descEstado = $descEstado[0]['estado_descripcion'];
                    $posiinic = strpos($MoviOrdeVent[$keyMoviOrdeVent],'|',$posiinic) + 1;

                    $imprMoviVent.="<tr>";
                    $imprMoviVent.="<td>".$id_movivent_secuencia."</td>";
                    $imprMoviVent.="<td>".$descProducto."</td>";
                    $imprMoviVent.="<td>".$movivent_cantidad."</td>";
                    $imprMoviVent.="<td>".$movivent_costo_unit."</td>";
                    $imprMoviVent.="<td>".$movivent_costo_total."</td>";
                    $imprMoviVent.="<td>".$descBodega."</td>";
                    $imprMoviVent.="<td>".$descEstado."</td>";
                    $imprMoviVent.="<td><button id='btn-eliminar' href='#' onclick=\"borraMovivent('$this->urlBase','$idVentaMovi','$id_movivent_secuencia','$movivent_bodega_id','$movivent_producto_id','$movivent_cantidad')\" type='submit' class='btn btn-danger btn-circle'><i class='fa fa-times'></i></button></td>";
                    $imprMoviVent.="</tr>";
                    $posiinic = 0;
                }
            $cargaForma.=$imprMoviVent;
            $imprMoviVent = '';
            $cargaForma.="</tbody>
                                        </table>
                                    </div>
                                </div>";
            }
            else{
                $cargaForma.="</tbody>
                                        </table>
                                    </div>
                                </div>";
            }
            echo($cargaForma);
        }
        else{
            $cargaForma = "";
            echo($cargaForma);
        }
    }
    
    //Recarga el formulario de consulta de las ventas a partir del criterio de búsqueda dado.
    function seleccionarVenta(){
        if($this->session->userdata('logged_in')){
            $this->load->model('venta');
            $valorVent = $_POST['venta_valor'];
            $ventas  = $this->venta->selVentas($valorVent);
            $cargaForma = "<div class='form-group'>
                                                    <div id='lista'>
                                                        <table class='table table-bordered'width='100%'  border='0' cellspacing='0' cellpadding='0' style='font-size:10px'>
                                                            <thead>
                                                                <tr>
                                                                    <th>Código Venta</th>
                                                                    <th>Código Cliente</th>
                                                                    <th>Nombre Cliente</th>
                                                                    <th>Fecha</th>
                                                                    <th>Costo</th>
                                                                    <th>Descripción</th>
                                                                    <th>Estado</th>
                                                                </tr>
                                                            </thead>";
            if($ventas != false){
                $imprVenta = "";
                $cargaForma.= "<tbody>";
                $posiinic = 0;
                foreach ($ventas as $keyVenta=>$venta){
                    //Se acumula el html para los clientes
                    $idVenta = substr($ventas[$keyVenta],$posiinic,strpos($ventas[$keyVenta],'|',$posiinic) - $posiinic);
                    $posiinic = strpos($ventas[$keyVenta],'|',$posiinic) + 1;

                    $ventaCliente = substr($ventas[$keyVenta],$posiinic,strpos($ventas[$keyVenta],'|',$posiinic) - $posiinic);
                    $descCliente = $this->venta->descCliente($ventaCliente);
                    $descCliente = $descCliente[0]['cliente_nombre'];
                    $posiinic = strpos($ventas[$keyVenta],'|',$posiinic) + 1;

                    $ventaFecha = substr($ventas[$keyVenta],$posiinic,strpos($ventas[$keyVenta],'|',$posiinic) - $posiinic);
                    $posiinic = strpos($ventas[$keyVenta],'|',$posiinic) + 1;

                    $ventaCosto = substr($ventas[$keyVenta],$posiinic,strpos($ventas[$keyVenta],'|',$posiinic) - $posiinic);
                    $posiinic = strpos($ventas[$keyVenta],'|',$posiinic) + 1;

                    $ventaDescr = substr($ventas[$keyVenta],$posiinic,strpos($ventas[$keyVenta],'|',$posiinic) - $posiinic);
                    $posiinic = strpos($ventas[$keyVenta],'|',$posiinic) + 1;
                    
                    $ventaEstado = substr($ventas[$keyVenta],$posiinic,strpos($ventas[$keyVenta],'|',$posiinic) - $posiinic);
                    $descEstado = $this->venta->descEstado($ventaEstado);
                    $descEstado = $descEstado[0]['estado_descripcion'];
                    $posiinic = strpos($ventas[$keyVenta],'|',$posiinic) + 1;

                    $imprVenta.="<tr>";
                    $imprVenta.="<td>".$idVenta."</td>";
                    $imprVenta.="<td>".$ventaCliente."</td>";
                    $imprVenta.="<td>".$descCliente."</td>";
                    $imprVenta.="<td>".$ventaFecha."</td>";
                    $imprVenta.="<td>".$ventaCosto."</td>";
                    $imprVenta.="<td>".$ventaDescr."</td>";
                    $imprVenta.="<td>".$descEstado."</td>";
                    $imprVenta.="<td><button id='btn-modificar' href='#' onclick=\"modificaVenta('$this->urlBase','$idVenta')\" type='submit' class='btn btn-default btn-circle'><i class='fa fa-pencil'></i></button></td>";
                    $imprVenta.="<td><button id='btn-eliminar' href='#' onclick=\"borraVenta('$this->urlBase','$idVenta')\" type='submit' class='btn btn-danger btn-circle'><i class='fa fa-times'></i></button></td>";
                    $imprVenta.="</tr>";
                    $posiinic = 0;
                }
                $cargaForma.=$imprVenta;
                $imprVenta   = '';
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
            }
            else{
                $cargaForma.="</table>
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
            echo $cargaForma;
        }
        else{
            echo('No se ha logueado');
            redirect('contenedor');
        }
    }
    
    //Invoca el modelo de actualización de ventas.
    function actualizarVenta(){
        if($this->session->userdata('logged_in')){
            $this->load->model('venta');
            $codigoVent      = $_POST['idVent'];
            $clienteVent   = $_POST['clienteVent'];
            $clienteCodi   = substr($clienteVent,0,strpos($clienteVent,'-',0) - 1);
            $fechaVent       = $_POST['fechaVent'];
            $costoVent       = $_POST['costoVent'];
            $estadoVent      = $_POST['estadoVent'];
            $estadoCodi      = substr($estadoVent,0,strpos($estadoVent,'-',0) - 1);
            $descripcionVent = $_POST['descriVent'];
            $personaClie     = $this->session->userdata('idPers');
            $venta          = $this->venta->updVenta($codigoVent,$clienteCodi,$fechaVent,$costoVent,$estadoCodi,
                                                          $descripcionVent,$personaClie);
            if(isset($venta)){
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
    
    //Invoca el modelo de eliminación de ventas.
    function eliminarVenta(){
        if($this->session->userdata('logged_in')){
            $this->load->model('venta');
            $idVenta     = $_POST['idVenta'];
            $MoviOrdeVent = $this->venta->selMoviOrdeVent($idVenta);
            if(isset($MoviOrdeVent)){
                if($MoviOrdeVent == 0){
                    $venta = $this->venta->delVenta($idVenta);
                    if($venta){
                        /****************************************/
                        $ventas = $this->venta->selVentas("");
                        $imprVenta = "";
                        $cargaForma  = "<div class='row' onload='consultaVenta('$this->urlBase')'>
                                    <!-- Page Header -->
                                    <div class='col-lg-12'>
                                        <h1 class='page-header'>Consultar Venta</h1>
                                    </div>
                                    <!--End Page Header -->
                                </div>
                                <div class='row'>
                                    <div class='col-lg-12'>
                                        <!-- Advanced Tables -->
                                        <div class='panel panel-default'>
                                            <div class='panel-heading'>
                                                 Consulta de Ventas
                                            </div>
                                            <div class='panel-body'>
                                                <div class='table-responsive'>
                                                    <div id='dataTables-example_wrapper' class='dataTables_wrapper form-inline' role='grid'>
                                                        <div class='row'>
                                                            <div class='col-sm-6'>
                                                                <!-- search section-->
                                                                <div id='dataTables-example_filter' class='dataTables_filter'>
                                                                    <span class='input-group-btn'>
                                                                        <input type='search' id='venta-valor' class='form-control input-sm' aria-controls='dataTables-example' placeholder='Buscar'>
                                                                        <button id='busca-venta' class='btn btn-default' onclick=\"consultaVenta('$this->urlBase')\" type='submit'><i class='fa fa-search'></i></button>
                                                                    </span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div id='ventas' class='row'>
                                                            <div class='form-group'>
                                                                <div id='lista'>
                                                                    <table class='table table-bordered'width='100%'  border='0' cellspacing='0' cellpadding='0' style='font-size:10px'>
                                                                        <thead>
                                                                            <tr>
                                                                                <th>Código Venta</th>
                                                                                <th>Código Cliente</th>
                                                                                <th>Nombre Cliente</th>
                                                                                <th>Fecha</th>
                                                                                <th>Costo</th>
                                                                                <th>Descripción</th>
                                                                                <th>Estado</th>
                                                                            </tr>
                                                                        </thead>";
                        if($ventas != false){
                            $imprVenta = "";
                            $cargaForma.= "<tbody>";
                            $posiinic = 0;
                            foreach ($ventas as $keyVenta=>$venta){
                                //Se acumula el html para los clientes
                                $idVenta = substr($ventas[$keyVenta],$posiinic,strpos($ventas[$keyVenta],'|',$posiinic) - $posiinic);
                                $posiinic = strpos($ventas[$keyVenta],'|',$posiinic) + 1;

                                $ventaCliente = substr($ventas[$keyVenta],$posiinic,strpos($ventas[$keyVenta],'|',$posiinic) - $posiinic);
                                $descCliente = $this->venta->descCliente($ventaCliente);
                                $descCliente = $descCliente[0]['cliente_nombre'];
                                $posiinic = strpos($ventas[$keyVenta],'|',$posiinic) + 1;

                                $ventaFecha = substr($ventas[$keyVenta],$posiinic,strpos($ventas[$keyVenta],'|',$posiinic) - $posiinic);
                                $posiinic = strpos($ventas[$keyVenta],'|',$posiinic) + 1;

                                $ventaCosto = substr($ventas[$keyVenta],$posiinic,strpos($ventas[$keyVenta],'|',$posiinic) - $posiinic);
                                $posiinic = strpos($ventas[$keyVenta],'|',$posiinic) + 1;

                                $ventaDescr = substr($ventas[$keyVenta],$posiinic,strpos($ventas[$keyVenta],'|',$posiinic) - $posiinic);
                                $posiinic = strpos($ventas[$keyVenta],'|',$posiinic) + 1;

                                $ventaEstado = substr($ventas[$keyVenta],$posiinic,strpos($ventas[$keyVenta],'|',$posiinic) - $posiinic);
                                $descEstado = $this->venta->descEstado($ventaEstado);
                                $descEstado = $descEstado[0]['estado_descripcion'];
                                $posiinic = strpos($ventas[$keyVenta],'|',$posiinic) + 1;

                                $imprVenta.="<tr>";
                                $imprVenta.="<td>".$idVenta."</td>";
                                $imprVenta.="<td>".$ventaCliente."</td>";
                                $imprVenta.="<td>".$descCliente."</td>";
                                $imprVenta.="<td>".$ventaFecha."</td>";
                                $imprVenta.="<td>".$ventaCosto."</td>";
                                $imprVenta.="<td>".$ventaDescr."</td>";
                                $imprVenta.="<td>".$descEstado."</td>";
                                $imprVenta.="<td><button id='btn-modificar' href='#' onclick=\"modificaVenta('$this->urlBase','$idVenta')\" type='submit' class='btn btn-default btn-circle'><i class='fa fa-pencil'></i></button></td>";
                                $imprVenta.="<td><button id='btn-eliminar' href='#' onclick=\"borraVenta('$this->urlBase','$idVenta')\" type='submit' class='btn btn-danger btn-circle'><i class='fa fa-times'></i></button></td>";
                                $imprVenta.="</tr>";
                                $posiinic = 0;
                            }
                            $cargaForma.=$imprVenta;
                            $imprVenta   = '';
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
                        }
                        else{
                            $cargaForma.="</table>
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
                        echo $cargaForma;
                        /****************************************/
                    }
                    else{
                        echo("false");
                    }
                }
                else{
                    echo("movivent");
                }
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
    
    //Invoca el modelo de actualización de cantidades de ingrediente por bodega.
    function afectaIngreBode(){
        if($this->session->userdata('logged_in')){
            $this->load->model('venta');
            $idBodega   = $_POST['bodega'];
            $posiSepara = strpos($idBodega,'-',0);
            if($posiSepara !== false){
                $idBodega = substr($idBodega,0,strpos($idBodega,'-',0) - 1);
            }
            $idProducto = $_POST['producto'];
            $posiSepara = strpos($idProducto,'-',0);
            if($posiSepara !== false){
                $idProducto = substr($idProducto,0,strpos($idProducto,'-',0) - 1);
            }
            $cantProdu  = $_POST['cantProdu'];
            $signo      = $_POST['signo'];
            $ingreProdu = $this->venta->selIngreProdu($idProducto);
            if($ingreProdu != false){
                foreach ($ingreProdu as $keyIngreProdu=>$produIngre){
                    $afecCant = false;
                    $posiinic = 0;
                    $idProducto = substr($ingreProdu[$keyIngreProdu],$posiinic,strpos($ingreProdu[$keyIngreProdu],'|',$posiinic) - $posiinic);
                    $posiinic = strpos($ingreProdu[$keyIngreProdu],'|',$posiinic) + 1;
                    
                    $idIngred = substr($ingreProdu[$keyIngreProdu],$posiinic,strpos($ingreProdu[$keyIngreProdu],'|',$posiinic) - $posiinic);
                    $posiinic = strpos($ingreProdu[$keyIngreProdu],'|',$posiinic) + 1;
                    
                    $idUnidad = substr($ingreProdu[$keyIngreProdu],$posiinic,strpos($ingreProdu[$keyIngreProdu],'|',$posiinic) - $posiinic);
                    $posiinic = strpos($ingreProdu[$keyIngreProdu],'|',$posiinic) + 1;
                    
                    $cantIngr = substr($ingreProdu[$keyIngreProdu],$posiinic,strpos($ingreProdu[$keyIngreProdu],'|',$posiinic) - $posiinic);
                    $posiinic = strpos($ingreProdu[$keyIngreProdu],'|',$posiinic) + 1;
                    
                    $fechaRegistro = substr($ingreProdu[$keyIngreProdu],$posiinic,strpos($ingreProdu[$keyIngreProdu],'|',$posiinic) - $posiinic);
                    $posiinic = strpos($ingreProdu[$keyIngreProdu],'|',$posiinic) + 1;
                    
                    $idPersona = substr($ingreProdu[$keyIngreProdu],$posiinic,strpos($ingreProdu[$keyIngreProdu],'|',$posiinic) - $posiinic);
                    $posiinic = strpos($ingreProdu[$keyIngreProdu],'|',$posiinic) + 1;
                    
                    $idEstado = substr($ingreProdu[$keyIngreProdu],$posiinic,strpos($ingreProdu[$keyIngreProdu],'|',$posiinic) - $posiinic);
                    $posiinic = strpos($ingreProdu[$keyIngreProdu],'|',$posiinic) + 1;
                    
                    $cantidad = $cantProdu * $cantIngr;
                    if($signo === "-"){
                        $cantIngrBod = $this->venta->selIngreBode($idBodega,$idIngred,$cantidad);
                        if($cantIngrBod == 1){
                            $ingreBode = $this->venta->actIngreBode($idBodega,$idIngred,$cantidad,$signo);
                            if($ingreBode){
                                $afecCant = true;
                            }
                            else{
                                echo("false");
                            }
                        }
                        else{
                            echo("|".$idIngred."|".$idBodega."|".$cantidad."|");
                            break;
                        }
                    }
                    else{
                        $ingreBode = $this->venta->actIngreBode($idBodega,$idIngred,$cantidad,$signo);
                        if($ingreBode){
                            $afecCant = true;
                        }
                        else{
                            echo("false");
                        }
                    }
                }
                if($afecCant){
                    echo("true");
                }
            }
        }
        else{
            echo('No se ha logueado');
            redirect('contenedor');
        }
    }
}
?>
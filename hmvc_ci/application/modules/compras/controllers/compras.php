<?php if (! defined('BASEPATH')) exit('No direct script access allowed');
 
class Compras extends MX_Controller {
    
    function __construct(){
        parent::__construct();
        $this->urlBase = base_url();
    }
 
    function index(){
        echo("compras.index");
    }
	
    //Formulario de registro de compras
    function crearCompra(){
        //Se cargan los Estados desde el modelo Compra
        $this->load->model('compra');
        $estados = $this->compra->listaEstados();
        $proveedores = $this->compra->listaProveedores();
        $ingredientes = $this->compra->listaIngredientes();
        $bodegas = $this->compra->listaBodegas();
        $id_compra = $this->compra->MaxId_Compra();
        $id_secuencia = $this->compra->MaxId_Secuencia($id_compra);
        $MoviOrdeComp = $this->compra->selMoviOrdeComp($id_compra);
        $imprOpci ="";
        $cargaForma = "<div class='row'>
                 <!-- page header -->
                <div class='col-lg-12'>
                    <h1 class='page-header'>Registrar Compra</h1>
                </div>
                <!--end page header -->
            </div>
            <div class='row'>
                <div class='col-lg-12'>
                    <!-- Form Elements -->
                    <div class='panel panel-default'>
                        <div class='panel-heading'>
                            Registro de Compras
                        </div>
                        <div class='panel-body'>
                            <div class='row'>
                                <div class='col-lg-6'>
                                    <form role='form'>
                                        <div class='form-group'>
                                            <label>Código Compra</label>
                                            <input id='id-compra' class='form-control' placeholder='Código de la Compra.' value='$id_compra'>
                                        </div>
                                        
                                        <div class='form-group'>
                                            <label>Fecha</label>
                                            <input id='compra-fecha' type='date' data-format='dd-MM-yyyy' class='form-control' placeholder='dd-mm-yyyy'>
                                        </div>
                                        
                                        <div class='form-group'>
                                            <label>Estado</label>
                                            <select id='compra-estado-id' class='form-control'>";
        
        foreach ($estados as $keyEstado=>$estado){
            //Se acumula el html para las opciones
            $imprOpci.="<option>".$estados[$keyEstado]."</option>"
                       . "";
        }
        $cargaForma.=$imprOpci;
        $imprOpci = '';
        $cargaForma.="</select>
                                        </div>
                                        <button id='btn-guardar' href='#' onclick=\"insertaCompra('$this->urlBase')\" type='submit' class='btn btn-primary'>Añadir Compra</button>
                                        <button id='btn-cancelar' type='reset' class='btn btn-success'>Cancelar</button>
                                    </form>
                                </div>
                                <div class='col-lg-6'>
                                    <form role='form'>
                                        <div class='form-group'>
                                            <label>Proveedor</label>
                                            <select id='compra-proveedor-id' class='form-control'>";
        
        foreach ($proveedores as $keyProveedor=>$proveedor){
            //Se acumula el html para las opciones
            $imprOpci.="<option>".$proveedores[$keyProveedor]."</option>"
                       . "";
        }
        $cargaForma.=$imprOpci;
        $imprOpci = '';
        $cargaForma.="</select>
                                        </div>
                                        
                                        <div class='form-group'>
                                            <label>Costo</label>
                                            <input id='compra-costo' class='form-control' placeholder='Costo Total de la Compra.' value ='0' disabled>
                                        </div>
                                        
                                        <div class='form-group'>
                                            <label>Descripción</label>
                                            <input id='compra-descripcion' class='form-control' placeholder='Descripción de la Compra.'>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                            
                        <div class='panel-heading'>
                            Movimientos de Compra
                        </div>
                        <div class='panel-body'>    
                            <div id='movicomp' class='row'>
                                <div class='form-group'>
                                    <div id='lista'>
                                        <table class='table table-bordered'width='100%'  border='0' cellspacing='0' cellpadding='0' style='font-size:10px'>
                                            <thead>
                                                <tr>
                                                    <th>Secuencia</th>
                                                    <th>Ingrediente</th>
                                                    <th>Cantidad</th>
                                                    <th>Costo Unitario</th>
                                                    <th>Costo Total</th>
                                                    <th>Bodega</th>
                                                    <th>Estado</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td><input id='id-movicomp-secuencia' class='form-control' placeholder='Secuencia' value='$id_secuencia' disabled></td>
                                                    <td><select id='movicomp-ingrediente-id' class='form-control' disabled>";
        
        foreach ($ingredientes as $keyIngrediente=>$ingrediente){
            //Se acumula el html para las opciones
            $imprOpci.="<option>".$ingredientes[$keyIngrediente]."</option>"
                       . "";
        }
        $cargaForma.=$imprOpci;
        $imprOpci = '';
        $cargaForma.="</select></td>
                                                    <td><input id='movicomp-cantidad' class='form-control' placeholder='Cantidad' disabled></td>
                                                    <td><input id='movicomp-costo-unit' class='form-control' placeholder='Costo Unitario' disabled></td>
                                                    <td><input id='movicomp-costo-total' class='form-control' placeholder='Costo Total' value=0 disabled></td>
                                                    <td><select id='movicomp-bodega-id' class='form-control' disabled>";
        
        foreach ($bodegas as $keyBodega=>$bodega){
            //Se acumula el html para las opciones
            $imprOpci.="<option>".$bodegas[$keyBodega]."</option>"
                       . "";
        }
        $cargaForma.=$imprOpci;
        $imprOpci = '';
        $cargaForma.="</select></td>
                                                    <td><select id='compra-estado-id' class='form-control' disabled>";
        
        foreach ($estados as $keyEstado=>$estado){
            //Se acumula el html para las opciones
            $imprOpci.="<option>".$estados[$keyEstado]."</option>"
                       . "";
        }
        $cargaForma.=$imprOpci;
        $imprOpci = '';
        $cargaForma.="</select></td>
                                                    <td><button id='btn-guardar-movicomp' href='#' onclick=\"insertaMovicomp('$this->urlBase')\" type='submit' class='btn btn-default btn-circle' disabled><i class='fa fa-check'></i></button></td>
                                                </tr>";
        
        if($MoviOrdeComp != false){
            $imprMoviComp = "";
            //$cargaForma.= "<tbody>";
            $posiinic = 0;                                                
            foreach ($MoviOrdeComp as $keyMoviOrdeComp=>$cliente){
                //Se acumula el html para los clientes
                $id_movicomp_secuencia = substr($MoviOrdeComp[$keyMoviOrdeComp],$posiinic,strpos($MoviOrdeComp[$keyMoviOrdeComp],'|',$posiinic) - $posiinic);
                $posiinic = strpos($MoviOrdeComp[$keyMoviOrdeComp],'|',$posiinic) + 1;

                $movicomp_ingrediente_id = substr($MoviOrdeComp[$keyMoviOrdeComp],$posiinic,strpos($MoviOrdeComp[$keyMoviOrdeComp],'|',$posiinic) - $posiinic);
                $posiinic = strpos($MoviOrdeComp[$keyMoviOrdeComp],'|',$posiinic) + 1;

                $movicomp_cantidad = substr($MoviOrdeComp[$keyMoviOrdeComp],$posiinic,strpos($MoviOrdeComp[$keyMoviOrdeComp],'|',$posiinic) - $posiinic);
                $posiinic = strpos($MoviOrdeComp[$keyMoviOrdeComp],'|',$posiinic) + 1;

                $movicomp_costo_unit = substr($MoviOrdeComp[$keyMoviOrdeComp],$posiinic,strpos($MoviOrdeComp[$keyMoviOrdeComp],'|',$posiinic) - $posiinic);
                $posiinic = strpos($MoviOrdeComp[$keyMoviOrdeComp],'|',$posiinic) + 1;

                $movicomp_costo_total = substr($MoviOrdeComp[$keyMoviOrdeComp],$posiinic,strpos($MoviOrdeComp[$keyMoviOrdeComp],'|',$posiinic) - $posiinic);
                $posiinic = strpos($MoviOrdeComp[$keyMoviOrdeComp],'|',$posiinic) + 1;

                $movicomp_bodega_id = substr($MoviOrdeComp[$keyMoviOrdeComp],$posiinic,strpos($MoviOrdeComp[$keyMoviOrdeComp],'|',$posiinic) - $posiinic);
                $posiinic = strpos($MoviOrdeComp[$keyMoviOrdeComp],'|',$posiinic) + 1;

                $movicomp_estado_id = substr($MoviOrdeComp[$keyMoviOrdeComp],$posiinic,strpos($MoviOrdeComp[$keyMoviOrdeComp],'|',$posiinic) - $posiinic);
                $posiinic = strpos($MoviOrdeComp[$keyMoviOrdeComp],'|',$posiinic) + 1;

                $imprMoviComp.="<tr>";
                $imprMoviComp.="<td>".$id_movicomp_secuencia."</td>";
                $imprMoviComp.="<td>".$movicomp_ingrediente_id."</td>";
                $imprMoviComp.="<td>".$movicomp_cantidad."</td>";
                $imprMoviComp.="<td>".$movicomp_costo_unit."</td>";
                $imprMoviComp.="<td>".$movicomp_costo_total."</td>";
                $imprMoviComp.="<td>".$movicomp_bodega_id."</td>";
                $imprMoviComp.="<td>".$movicomp_estado_id."</td>";
                $imprMoviComp.="<td><button id='btn-modificar' href='#' onclick=\"modificaCliente('$this->urlBase','$idCliente')\" type='submit' class='btn btn-default btn-circle'><i class='fa fa-pencil'></i></button></td>";
                $imprMoviComp.="<td><button id='btn-eliminar' href='#' onclick=\"borraCliente('$this->urlBase','$idCliente')\" type='submit' class='btn btn-danger btn-circle'><i class='fa fa-times'></i></button></td>";
                $imprMoviComp.="</tr>";
                $posiinic = 0;
            }
            $cargaForma.=$imprMoviComp;
            $imprMoviComp   = '';
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
    
    //Formulario de modificación de compras
    function modificarCompra(){
        if($this->session->userdata('logged_in')){
            $this->load->model('compra');
            $codigoComp          = $_POST['idCompra'];
            $compra              = $this->compra->selIdCompra($codigoComp);
            $id_compra           = $compra[0]['id_compra'];
            $compra_proveedor_id = $compra[0]['compra_proveedor_id'];
            $proveedor           = $this->compra->selProveedor($compra_proveedor_id);
            $compra_proveedor    = $proveedor[0]['proveedor'];
            $compra_fecha        = $compra[0]['compra_fecha'];
            $compra_costo        = $compra[0]['compra_costo'];
            $compra_descripcion  = $compra[0]['compra_descripcion'];
            $compra_estado_id    = $compra[0]['compra_estado_id'];
            $estado              = $this->compra->selEstado($compra_estado_id);
            $compra_estado       = $estado[0]['estado'];
            $MoviOrdeComp        = $this->compra->selMoviOrdeComp($id_compra);
            $id_secuencia        = $this->compra->MaxId_Secuencia($id_compra);
            
            $estados = $this->compra->listaEstados();
            $proveedores = $this->compra->listaProveedores();
            $ingredientes = $this->compra->listaIngredientes();
            $bodegas = $this->compra->listaBodegas();
            $imprOpci                 = "";
            
            $cargaForma = "<div class='row'>
                 <!-- page header -->
                <div class='col-lg-12'>
                    <h1 class='page-header'>Modificar Compra</h1>
                </div>
                <!--end page header -->
            </div>
            <div class='row'>
                <div class='col-lg-12'>
                    <!-- Form Elements -->
                    <div class='panel panel-default'>
                        <div class='panel-heading'>
                            Modificación de Compras
                        </div>
                        <div class='panel-body'>
                            <div class='row'>
                                <div class='col-lg-6'>
                                    <form role='form'>
                                        <div class='form-group'>
                                            <label>Código Compra</label>
                                            <input id='id-compra' class='form-control' placeholder='Código de la Compra.' value='$id_compra' disabled>
                                        </div>
                                        
                                        <div class='form-group'>
                                            <label>Fecha</label>
                                            <input id='compra-fecha' type='date' data-format='dd-MM-yyyy' class='form-control' placeholder='dd-mm-yyyy' value='$compra_fecha'>
                                        </div>
                                        
                                        <div class='form-group'>
                                            <label>Estado</label>
                                            <select id='compra-estado-id' class='form-control'>";
        
            foreach ($estados as $keyEstado=>$estado){
                //Se acumula el html para las opciones
                if($compra_estado == $estados[$keyEstado]){
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
                                            <button id='btn-guardar' href='#' onclick=\"actualizaCompra('$this->urlBase')\" type='submit' class='btn btn-primary'>Actualizar Compra</button>
                                            <button id='btn-cancelar' type='reset' class='btn btn-success'>Cancelar</button>
                                        </form>
                                    </div>
                                    <div class='col-lg-6'>
                                        <form role='form'>
                                            <div class='form-group'>
                                                <label>Proveedor</label>
                                                <select id='compra-proveedor-id' class='form-control'>";

            foreach ($proveedores as $keyProveedor=>$proveedor){
                //Se acumula el html para las opciones
                if($compra_proveedor == $proveedores[$keyProveedor]){
                    $imprOpci.="<option selected>".$proveedores[$keyProveedor]."</option>";
                }
                else{
                    $imprOpci.="<option>".$proveedores[$keyProveedor]."</option>";
                }
            }
            $cargaForma.=$imprOpci;
            $imprOpci = '';
            $cargaForma.="</select>
                                            </div>

                                            <div class='form-group'>
                                                <label>Costo</label>
                                                <input id='compra-costo' class='form-control' placeholder='Costo Total de la Compra.' value='$compra_costo' disabled>
                                            </div>

                                            <div class='form-group'>
                                                <label>Descripción</label>
                                                <input id='compra-descripcion' class='form-control' placeholder='Descripción de la Compra.' value='$compra_descripcion'>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>

                            <div class='panel-heading'>
                                Movimientos de Compra
                            </div>
                            <div class='panel-body'>    
                                <div id='movicomp' class='row'>
                                    <div class='form-group'>
                                        <div id='lista'>
                                            <table class='table table-bordered'width='100%'  border='0' cellspacing='0' cellpadding='0' style='font-size:10px'>
                                                <thead>
                                                    <tr>
                                                        <th>Secuencia</th>
                                                        <th>Ingrediente</th>
                                                        <th>Cantidad</th>
                                                        <th>Costo Unitario</th>
                                                        <th>Costo Total</th>
                                                        <th>Bodega</th>
                                                        <th>Estado</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td><input id='id-movicomp-secuencia' class='form-control' placeholder='Secuencia' value='$id_secuencia' disabled></td>
                                                        <td><select id='movicomp-ingrediente-id' class='form-control'>";

            foreach ($ingredientes as $keyIngrediente=>$ingrediente){
                //Se acumula el html para las opciones
                $imprOpci.="<option>".$ingredientes[$keyIngrediente]."</option>"
                           . "";
            }
            $cargaForma.=$imprOpci;
            $imprOpci = '';
            $cargaForma.="</select></td>
                                                        <td><input id='movicomp-cantidad' class='form-control' placeholder='Cantidad'></td>
                                                        <td><input id='movicomp-costo-unit' class='form-control' placeholder='Costo Unitario'></td>
                                                        <td><input id='movicomp-costo-total' class='form-control' placeholder='Costo Total' value=0 disabled></td>
                                                        <td><select id='movicomp-bodega-id' class='form-control'>";

            foreach ($bodegas as $keyBodega=>$bodega){
                //Se acumula el html para las opciones
                $imprOpci.="<option>".$bodegas[$keyBodega]."</option>"
                           . "";
            }
            $cargaForma.=$imprOpci;
            $imprOpci = '';
            $cargaForma.="</select></td>
                                                        <td><select id='compra-estado-id' class='form-control'>";

            foreach ($estados as $keyEstado=>$estado){
                //Se acumula el html para las opciones
                $imprOpci.="<option>".$estados[$keyEstado]."</option>"
                           . "";
            }
            $cargaForma.=$imprOpci;
            $imprOpci = '';
            $cargaForma.="</select></td>
                                                        <td><button id='btn-guardar-movicomp' href='#' onclick=\"insertaMovicomp('$this->urlBase')\" type='submit' class='btn btn-default btn-circle'><i class='fa fa-check'></i></button></td>
                                                    </tr>";

            if($MoviOrdeComp != false){
                $imprMoviComp = "";
                //$cargaForma.= "<tbody>";
                $posiinic = 0;                                                
                foreach ($MoviOrdeComp as $keyMoviOrdeComp=>$cliente){
                    //Se acumula el html para los clientes
                    $id_movicomp_secuencia = substr($MoviOrdeComp[$keyMoviOrdeComp],$posiinic,strpos($MoviOrdeComp[$keyMoviOrdeComp],'|',$posiinic) - $posiinic);
                    $posiinic = strpos($MoviOrdeComp[$keyMoviOrdeComp],'|',$posiinic) + 1;

                    $movicomp_ingrediente_id = substr($MoviOrdeComp[$keyMoviOrdeComp],$posiinic,strpos($MoviOrdeComp[$keyMoviOrdeComp],'|',$posiinic) - $posiinic);
                    $descIngrediente = $this->compra->descIngrediente($movicomp_ingrediente_id);
                    $descIngrediente = $descIngrediente[0]['ingrediente_nombre'];
                    $posiinic = strpos($MoviOrdeComp[$keyMoviOrdeComp],'|',$posiinic) + 1;

                    $movicomp_cantidad = substr($MoviOrdeComp[$keyMoviOrdeComp],$posiinic,strpos($MoviOrdeComp[$keyMoviOrdeComp],'|',$posiinic) - $posiinic);
                    $posiinic = strpos($MoviOrdeComp[$keyMoviOrdeComp],'|',$posiinic) + 1;

                    $movicomp_costo_unit = substr($MoviOrdeComp[$keyMoviOrdeComp],$posiinic,strpos($MoviOrdeComp[$keyMoviOrdeComp],'|',$posiinic) - $posiinic);
                    $posiinic = strpos($MoviOrdeComp[$keyMoviOrdeComp],'|',$posiinic) + 1;

                    $movicomp_costo_total = substr($MoviOrdeComp[$keyMoviOrdeComp],$posiinic,strpos($MoviOrdeComp[$keyMoviOrdeComp],'|',$posiinic) - $posiinic);
                    $posiinic = strpos($MoviOrdeComp[$keyMoviOrdeComp],'|',$posiinic) + 1;

                    $movicomp_bodega_id = substr($MoviOrdeComp[$keyMoviOrdeComp],$posiinic,strpos($MoviOrdeComp[$keyMoviOrdeComp],'|',$posiinic) - $posiinic);
                    $descBodega = $this->compra->descBodega($movicomp_bodega_id);
                    $descBodega = $descBodega[0]['bodega_nombre'];
                    $posiinic = strpos($MoviOrdeComp[$keyMoviOrdeComp],'|',$posiinic) + 1;

                    $movicomp_estado_id = substr($MoviOrdeComp[$keyMoviOrdeComp],$posiinic,strpos($MoviOrdeComp[$keyMoviOrdeComp],'|',$posiinic) - $posiinic);
                    $descEstado = $this->compra->descEstado($movicomp_estado_id);
                    $descEstado = $descEstado[0]['estado_descripcion'];
                    $posiinic = strpos($MoviOrdeComp[$keyMoviOrdeComp],'|',$posiinic) + 1;

                    $imprMoviComp.="<tr>";
                    $imprMoviComp.="<td>".$id_movicomp_secuencia."</td>";
                    $imprMoviComp.="<td>".$descIngrediente."</td>";
                    $imprMoviComp.="<td>".$movicomp_cantidad."</td>";
                    $imprMoviComp.="<td>".$movicomp_costo_unit."</td>";
                    $imprMoviComp.="<td>".$movicomp_costo_total."</td>";
                    $imprMoviComp.="<td>".$descBodega."</td>";
                    $imprMoviComp.="<td>".$descEstado."</td>";
                    $imprMoviComp.="<td><button id='btn-eliminar' href='#' onclick=\"borraMovicomp('$this->urlBase','$codigoComp','$id_movicomp_secuencia')\" type='submit' class='btn btn-danger btn-circle'><i class='fa fa-times'></i></button></td>";
                    $imprMoviComp.="</tr>";
                    $posiinic = 0;
                }
                $cargaForma.=$imprMoviComp;
                $imprMoviComp = '';
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
    
    //Formulario de consulta de compras
    function consultarCompra(){
        if($this->session->userdata('logged_in')){
            $this->load->model('compra');
            $compras = $this->compra->selCompras("");
            $imprCompra = "";
            $cargaForma  = "<div class='row' onload='consultaCompra('$this->urlBase')'>
                        <!-- Page Header -->
                        <div class='col-lg-12'>
                            <h1 class='page-header'>Consultar Compra</h1>
                        </div>
                        <!--End Page Header -->
                    </div>
                    <div class='row'>
                        <div class='col-lg-12'>
                            <!-- Advanced Tables -->
                            <div class='panel panel-default'>
                                <div class='panel-heading'>
                                     Consulta de Compras
                                </div>
                                <div class='panel-body'>
                                    <div class='table-responsive'>
                                        <div id='dataTables-example_wrapper' class='dataTables_wrapper form-inline' role='grid'>
                                            <div class='row'>
                                                <div class='col-sm-6'>
                                                    <!-- search section-->
                                                    <div id='dataTables-example_filter' class='dataTables_filter'>
                                                        <span class='input-group-btn'>
                                                            <input type='search' id='compra-valor' class='form-control input-sm' aria-controls='dataTables-example' placeholder='Buscar'>
                                                            <button id='busca-compra' class='btn btn-default' onclick=\"consultaCompra('$this->urlBase')\" type='submit'><i class='fa fa-search'></i></button>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div id='compras' class='row'>
                                                <div class='form-group'>
                                                    <div id='lista'>
                                                        <table class='table table-bordered'width='100%'  border='0' cellspacing='0' cellpadding='0' style='font-size:10px'>
                                                            <thead>
                                                                <tr>
                                                                    <th>Código Compra</th>
                                                                    <th>Código Proveedor</th>
                                                                    <th>Nombre Proveedor</th>
                                                                    <th>Fecha</th>
                                                                    <th>Costo</th>
                                                                    <th>Descripción</th>
                                                                    <th>Estado</th>
                                                                </tr>
                                                            </thead>";
            if($compras != false){
                $imprCompra = "";
                $cargaForma.= "<tbody>";
                $posiinic = 0;
                foreach ($compras as $keyCompra=>$compra){
                    //Se acumula el html para los clientes
                    $idCompra = substr($compras[$keyCompra],$posiinic,strpos($compras[$keyCompra],'|',$posiinic) - $posiinic);
                    $posiinic = strpos($compras[$keyCompra],'|',$posiinic) + 1;

                    $compraProveedor = substr($compras[$keyCompra],$posiinic,strpos($compras[$keyCompra],'|',$posiinic) - $posiinic);
                    $descProveedor = $this->compra->descProveedor($compraProveedor);
                    $descProveedor = $descProveedor[0]['proveedor_nombre'];
                    $posiinic = strpos($compras[$keyCompra],'|',$posiinic) + 1;

                    $compraFecha = substr($compras[$keyCompra],$posiinic,strpos($compras[$keyCompra],'|',$posiinic) - $posiinic);
                    $posiinic = strpos($compras[$keyCompra],'|',$posiinic) + 1;

                    $compraCosto = substr($compras[$keyCompra],$posiinic,strpos($compras[$keyCompra],'|',$posiinic) - $posiinic);
                    $posiinic = strpos($compras[$keyCompra],'|',$posiinic) + 1;

                    $compraDescr = substr($compras[$keyCompra],$posiinic,strpos($compras[$keyCompra],'|',$posiinic) - $posiinic);
                    $posiinic = strpos($compras[$keyCompra],'|',$posiinic) + 1;
                    
                    $compraEstado = substr($compras[$keyCompra],$posiinic,strpos($compras[$keyCompra],'|',$posiinic) - $posiinic);
                    $descEstado = $this->compra->descEstado($compraEstado);
                    $descEstado = $descEstado[0]['estado_descripcion'];
                    $posiinic = strpos($compras[$keyCompra],'|',$posiinic) + 1;

                    $imprCompra.="<tr>";
                    $imprCompra.="<td>".$idCompra."</td>";
                    $imprCompra.="<td>".$compraProveedor."</td>";
                    $imprCompra.="<td>".$descProveedor."</td>";
                    $imprCompra.="<td>".$compraFecha."</td>";
                    $imprCompra.="<td>".$compraCosto."</td>";
                    $imprCompra.="<td>".$compraDescr."</td>";
                    $imprCompra.="<td>".$descEstado."</td>";
                    $imprCompra.="<td><button id='btn-modificar' href='#' onclick=\"modificaCompra('$this->urlBase','$idCompra')\" type='submit' class='btn btn-default btn-circle'><i class='fa fa-pencil'></i></button></td>";
                    $imprCompra.="<td><button id='btn-eliminar' href='#' onclick=\"borraCompra('$this->urlBase','$idCompra')\" type='submit' class='btn btn-danger btn-circle'><i class='fa fa-times'></i></button></td>";
                    $imprCompra.="</tr>";
                    $posiinic = 0;
                }
                $cargaForma.=$imprCompra;
                $imprCompra   = '';
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
    
    //Proceso de registro de compras.
    function guardarCompra(){
        $this->load->model('compra');
        $codigoComp    = $_POST['idComp'];
        $proveedorComp = $_POST['proveedorComp'];
        $proveedorCodi = substr($proveedorComp,0,strpos($proveedorComp,' - ',0));
        $fechaComp     = $_POST['fechaComp'];
        $costoComp     = $_POST['costoComp'];
        $estadoComp    = $_POST['estadoComp'];
        $estadoCodi    = substr($estadoComp,0,strpos($estadoComp,'-',0) - 1);
        $descriComp    = $_POST['descriComp'];
        $compra        = $this->compra->insCompra($codigoComp,$proveedorCodi,$fechaComp,$estadoCodi,$descriComp);
        if(isset($compra)){
            $estados = $this->compra->listaEstados();
            $ingredientes = $this->compra->listaIngredientes();
            $bodegas = $this->compra->listaBodegas();
            $id_compra = $codigoComp;
            $id_secuencia = $this->compra->MaxId_Secuencia($id_compra);
            $imprOpci ="";
            $cargaForma = "<div class='form-group'>
                                    <div id='lista'>
                                        <table class='table table-bordered'width='100%'  border='0' cellspacing='0' cellpadding='0' style='font-size:10px'>
                                            <thead>
                                                <tr>
                                                    <th>Secuencia</th>
                                                    <th>Ingrediente</th>
                                                    <th>Cantidad</th>
                                                    <th>Costo Unitario</th>
                                                    <th>Costo Total</th>
                                                    <th>Bodega</th>
                                                    <th>Estado</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td><input id='id-movicomp-secuencia' class='form-control' placeholder='Secuencia' value='$id_secuencia' disabled></td>
                                                    <td><select id='movicomp-ingrediente-id' class='form-control'>";
        
            foreach ($ingredientes as $keyIngrediente=>$ingrediente){
                //Se acumula el html para las opciones
                $imprOpci.="<option>".$ingredientes[$keyIngrediente]."</option>"
                           . "";
            }
            $cargaForma.=$imprOpci;
            $imprOpci = '';
            $cargaForma.="</select></td>
                                                    <td><input id='movicomp-cantidad' class='form-control' placeholder='Cantidad'></td>
                                                    <td><input id='movicomp-costo-unit' class='form-control' placeholder='Costo Unitario'></td>
                                                    <td><input id='movicomp-costo-total' class='form-control' placeholder='Costo Total' value=0 disabled></td>
                                                    <td><select id='movicomp-bodega-id' class='form-control'>";
        
            foreach ($bodegas as $keyBodega=>$bodega){
                //Se acumula el html para las opciones
                $imprOpci.="<option>".$bodegas[$keyBodega]."</option>"
                           . "";
            }
            $cargaForma.=$imprOpci;
            $imprOpci = '';
            $cargaForma.="</select></td>
                                                    <td><select id='compra-estado-id' class='form-control'>";
        
            foreach ($estados as $keyEstado=>$estado){
                //Se acumula el html para las opciones
                $imprOpci.="<option>".$estados[$keyEstado]."</option>"
                           . "";
            }
            $cargaForma.=$imprOpci;
            $imprOpci = '';
            $cargaForma.="</select></td>
                                                    <td><button id='btn-guardar-movicomp' href='#' onclick=\"insertaMovicomp('$this->urlBase')\" type='submit' class='btn btn-default btn-circle'><i class='fa fa-check'></i></button></td>
                                                </tr>";
            echo($cargaForma);
        }
        else{
            $cargaForma = "";
            echo($cargaForma);
        }
    }
    
    //Consulta una compra por el identificador de compra.
    function obtenerCompra(){
        $this->load->model('compra');
        $idCompra = $_POST['idComp'];
        $compra     = $this->compra->selCompra($idCompra);
        echo($compra);
    }
    
    //Registra un movimiento de compra
    function guardarMovicomp(){
        $this->load->model('compra');
        $idCompraMovi   = $_POST['id_compra'];
        $secuenciaMovi  = $_POST['secuencia'];
        $ingredienteMovi  = $_POST['ingrediente'];
        $ingredienteCodi  = substr($ingredienteMovi,0,strpos($ingredienteMovi,'-',0) - 1);
        $cantidadMovi   = $_POST['cantidad'];
        $costoUnitMovi  = $_POST['costo_unit'];
        $costoTotalMovi = $_POST['costo_total'];
        $bodegaMovi     = $_POST['bodega'];
        $bodegaCodi     = substr($bodegaMovi,0,strpos($bodegaMovi,'-',0) - 1);
        $estadoMovi     = $_POST['estado'];
        $estadoCodi     = substr($estadoMovi,0,strpos($estadoMovi,'-',0) - 1);
        $personaMovi    = $this->session->userdata('idPers');
        $movicomp       = $this->compra->insMovicomp($idCompraMovi,$secuenciaMovi,$ingredienteCodi,$cantidadMovi,
                                                     $costoUnitMovi,$costoTotalMovi,$bodegaCodi,$estadoCodi,
                                                     $personaMovi);
        if(isset($movicomp)){
            $estados = $this->compra->listaEstados();
            $ingredientes = $this->compra->listaIngredientes();
            $bodegas = $this->compra->listaBodegas();
            $id_compra = $idCompraMovi;
            $id_secuencia = $this->compra->MaxId_Secuencia($id_compra);
            $MoviOrdeComp = $this->compra->selMoviOrdeComp($id_compra);
            $imprOpci ="";
            $cargaForma = "<div class='form-group'>
                                    <div id='lista'>
                                        <table class='table table-bordered'width='100%'  border='0' cellspacing='0' cellpadding='0' style='font-size:10px'>
                                            <thead>
                                                <tr>
                                                    <th>Secuencia</th>
                                                    <th>Ingrediente</th>
                                                    <th>Cantidad</th>
                                                    <th>Costo Unitario</th>
                                                    <th>Costo Total</th>
                                                    <th>Bodega</th>
                                                    <th>Estado</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td><input id='id-movicomp-secuencia' class='form-control' placeholder='Secuencia' value='$id_secuencia' disabled></td>
                                                    <td><select id='movicomp-ingrediente-id' class='form-control'>";
        
            foreach ($ingredientes as $keyIngrediente=>$ingrediente){
                //Se acumula el html para las opciones
                $imprOpci.="<option>".$ingredientes[$keyIngrediente]."</option>"
                           . "";
            }
            $cargaForma.=$imprOpci;
            $imprOpci = '';
            $cargaForma.="</select></td>
                                                    <td><input id='movicomp-cantidad' class='form-control' placeholder='Cantidad'></td>
                                                    <td><input id='movicomp-costo-unit' class='form-control' placeholder='Costo Unitario'></td>
                                                    <td><input id='movicomp-costo-total' class='form-control' placeholder='Costo Total' value=0 disabled></td>
                                                    <td><select id='movicomp-bodega-id' class='form-control'>";
        
            foreach ($bodegas as $keyBodega=>$bodega){
                //Se acumula el html para las opciones
                $imprOpci.="<option>".$bodegas[$keyBodega]."</option>"
                           . "";
            }
            $cargaForma.=$imprOpci;
            $imprOpci = '';
            $cargaForma.="</select></td>
                                                    <td><select id='compra-estado-id' class='form-control'>";
        
            foreach ($estados as $keyEstado=>$estado){
                //Se acumula el html para las opciones
                $imprOpci.="<option>".$estados[$keyEstado]."</option>"
                           . "";
            }
            $cargaForma.=$imprOpci;
            $imprOpci = '';
            $cargaForma.="</select></td>
                                                    <td><button id='btn-guardar-movicomp' href='#' onclick=\"insertaMovicomp('$this->urlBase')\" type='submit' class='btn btn-default btn-circle'><i class='fa fa-check'></i></button></td>
                                                </tr>";
        
            if($MoviOrdeComp != false){
                $imprMoviComp = "";
                //$cargaForma.= "<tbody>";
                $posiinic = 0;                                                
                foreach ($MoviOrdeComp as $keyMoviOrdeComp=>$cliente){
                    //Se acumula el html para los clientes
                    $id_movicomp_secuencia = substr($MoviOrdeComp[$keyMoviOrdeComp],$posiinic,strpos($MoviOrdeComp[$keyMoviOrdeComp],'|',$posiinic) - $posiinic);
                    $posiinic = strpos($MoviOrdeComp[$keyMoviOrdeComp],'|',$posiinic) + 1;

                    $movicomp_ingrediente_id = substr($MoviOrdeComp[$keyMoviOrdeComp],$posiinic,strpos($MoviOrdeComp[$keyMoviOrdeComp],'|',$posiinic) - $posiinic);
                    $descIngrediente = $this->compra->descIngrediente($movicomp_ingrediente_id);
                    $descIngrediente = $descIngrediente[0]['ingrediente_nombre'];
                    $posiinic = strpos($MoviOrdeComp[$keyMoviOrdeComp],'|',$posiinic) + 1;

                    $movicomp_cantidad = substr($MoviOrdeComp[$keyMoviOrdeComp],$posiinic,strpos($MoviOrdeComp[$keyMoviOrdeComp],'|',$posiinic) - $posiinic);
                    $posiinic = strpos($MoviOrdeComp[$keyMoviOrdeComp],'|',$posiinic) + 1;

                    $movicomp_costo_unit = substr($MoviOrdeComp[$keyMoviOrdeComp],$posiinic,strpos($MoviOrdeComp[$keyMoviOrdeComp],'|',$posiinic) - $posiinic);
                    $posiinic = strpos($MoviOrdeComp[$keyMoviOrdeComp],'|',$posiinic) + 1;

                    $movicomp_costo_total = substr($MoviOrdeComp[$keyMoviOrdeComp],$posiinic,strpos($MoviOrdeComp[$keyMoviOrdeComp],'|',$posiinic) - $posiinic);
                    $posiinic = strpos($MoviOrdeComp[$keyMoviOrdeComp],'|',$posiinic) + 1;

                    $movicomp_bodega_id = substr($MoviOrdeComp[$keyMoviOrdeComp],$posiinic,strpos($MoviOrdeComp[$keyMoviOrdeComp],'|',$posiinic) - $posiinic);
                    $descBodega = $this->compra->descBodega($movicomp_bodega_id);
                    $descBodega = $descBodega[0]['bodega_nombre'];
                    $posiinic = strpos($MoviOrdeComp[$keyMoviOrdeComp],'|',$posiinic) + 1;

                    $movicomp_estado_id = substr($MoviOrdeComp[$keyMoviOrdeComp],$posiinic,strpos($MoviOrdeComp[$keyMoviOrdeComp],'|',$posiinic) - $posiinic);
                    $descEstado = $this->compra->descEstado($movicomp_estado_id);
                    $descEstado = $descEstado[0]['estado_descripcion'];
                    $posiinic = strpos($MoviOrdeComp[$keyMoviOrdeComp],'|',$posiinic) + 1;

                    $imprMoviComp.="<tr>";
                    $imprMoviComp.="<td>".$id_movicomp_secuencia."</td>";
                    $imprMoviComp.="<td>".$descIngrediente."</td>";
                    $imprMoviComp.="<td>".$movicomp_cantidad."</td>";
                    $imprMoviComp.="<td>".$movicomp_costo_unit."</td>";
                    $imprMoviComp.="<td>".$movicomp_costo_total."</td>";
                    $imprMoviComp.="<td>".$descBodega."</td>";
                    $imprMoviComp.="<td>".$descEstado."</td>";
                    $imprMoviComp.="<td><button id='btn-eliminar' href='#' onclick=\"borraMovicomp('$this->urlBase','$idCompraMovi','$id_movicomp_secuencia')\" type='submit' class='btn btn-danger btn-circle'><i class='fa fa-times'></i></button></td>";
                    $imprMoviComp.="</tr>";
                    $posiinic = 0;
                }
            $cargaForma.=$imprMoviComp;
            $imprMoviComp = '';
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
    
    //Consulta un movimiento de compra por Identificador de compra y secuencia.
    function obtenerMovicomp(){
        $this->load->model('compra');
        $idCompra  = $_POST['idComp'];
        $secuencia = $_POST['secuencia'];
        $compra    = $this->compra->selMovicomp($idCompra,$secuencia);
        echo($compra);
    }
    
    //Afecta las cantidades del ingrediente por bodega.
    function afectaIngrebode(){
        $this->load->model('compra');
        $bodegaIngreBode      = $_POST['bodega'];
        $bodegaCodi           = substr($bodegaIngreBode,0,strpos($bodegaIngreBode,'-',0) - 1);
        $ingredienteIngreBode = $_POST['ingrediente'];
        $ingredienteCodi      = substr($ingredienteIngreBode,0,strpos($ingredienteIngreBode,'-',0) - 1);
        $cantidadIngreBode    = $_POST['cantidad'];
        $personaIngreBode     = $this->session->userdata('idPers');
        $ingrebode            = $this->compra->selIngreBode($bodegaCodi,$ingredienteCodi);
        if($ingrebode == 0){
            $afectaIngreBode = $this->compra->insIngreBode($bodegaCodi,$ingredienteCodi,$cantidadIngreBode,
                                                           $personaIngreBode);
        }
        else{
            if($ingrebode == 1){
                $afectaIngreBode = $this->compra->actIngreBode($bodegaCodi,$ingredienteCodi,$cantidadIngreBode,
                                                               $personaIngreBode);
            }
        }
        if(isset($afectaIngreBode)){
            echo("true");
        }
        else{
            echo("false");
        }
    }
    
    //Borra un movimiento de compra.
    function eliminarMovicomp(){
        $this->load->model('compra');
        $idCompraMovi   = $_POST['idCompra'];
        $secuenciaMovi  = $_POST['idSecuencia'];
        $movicomp       = $this->compra->borMovicomp($idCompraMovi,$secuenciaMovi);
        if(isset($movicomp)){
            $estados = $this->compra->listaEstados();
            $ingredientes = $this->compra->listaIngredientes();
            $bodegas = $this->compra->listaBodegas();
            $id_compra = $idCompraMovi;
            $id_secuencia = $this->compra->MaxId_Secuencia($id_compra);
            $MoviOrdeComp = $this->compra->selMoviOrdeComp($id_compra);
            $imprOpci ="";
            $cargaForma = "<div class='form-group'>
                                    <div id='lista'>
                                        <table class='table table-bordered'width='100%'  border='0' cellspacing='0' cellpadding='0' style='font-size:10px'>
                                            <thead>
                                                <tr>
                                                    <th>Secuencia</th>
                                                    <th>Ingrediente</th>
                                                    <th>Cantidad</th>
                                                    <th>Costo Unitario</th>
                                                    <th>Costo Total</th>
                                                    <th>Bodega</th>
                                                    <th>Estado</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td><input id='id-movicomp-secuencia' class='form-control' placeholder='Secuencia' value='$id_secuencia' disabled></td>
                                                    <td><select id='movicomp-ingrediente-id' class='form-control'>";
        
            foreach ($ingredientes as $keyIngrediente=>$ingrediente){
                //Se acumula el html para las opciones
                $imprOpci.="<option>".$ingredientes[$keyIngrediente]."</option>"
                           . "";
            }
            $cargaForma.=$imprOpci;
            $imprOpci = '';
            $cargaForma.="</select></td>
                                                    <td><input id='movicomp-cantidad' class='form-control' placeholder='Cantidad'></td>
                                                    <td><input id='movicomp-costo-unit' class='form-control' placeholder='Costo Unitario'></td>
                                                    <td><input id='movicomp-costo-total' class='form-control' placeholder='Costo Total' value=0 disabled></td>
                                                    <td><select id='movicomp-bodega-id' class='form-control'>";
        
            foreach ($bodegas as $keyBodega=>$bodega){
                //Se acumula el html para las opciones
                $imprOpci.="<option>".$bodegas[$keyBodega]."</option>"
                           . "";
            }
            $cargaForma.=$imprOpci;
            $imprOpci = '';
            $cargaForma.="</select></td>
                                                    <td><select id='compra-estado-id' class='form-control'>";
        
            foreach ($estados as $keyEstado=>$estado){
                //Se acumula el html para las opciones
                $imprOpci.="<option>".$estados[$keyEstado]."</option>"
                           . "";
            }
            $cargaForma.=$imprOpci;
            $imprOpci = '';
            $cargaForma.="</select></td>
                                                    <td><button id='btn-guardar-movicomp' href='#' onclick=\"insertaMovicomp('$this->urlBase')\" type='submit' class='btn btn-default btn-circle'><i class='fa fa-check'></i></button></td>
                                                </tr>";
        
            if($MoviOrdeComp != false){
                $imprMoviComp = "";
                //$cargaForma.= "<tbody>";
                $posiinic = 0;                                                
                foreach ($MoviOrdeComp as $keyMoviOrdeComp=>$cliente){
                    //Se acumula el html para los clientes
                    $id_movicomp_secuencia = substr($MoviOrdeComp[$keyMoviOrdeComp],$posiinic,strpos($MoviOrdeComp[$keyMoviOrdeComp],'|',$posiinic) - $posiinic);
                    $posiinic = strpos($MoviOrdeComp[$keyMoviOrdeComp],'|',$posiinic) + 1;

                    $movicomp_ingrediente_id = substr($MoviOrdeComp[$keyMoviOrdeComp],$posiinic,strpos($MoviOrdeComp[$keyMoviOrdeComp],'|',$posiinic) - $posiinic);
                    $descIngrediente = $this->compra->descIngrediente($movicomp_ingrediente_id);
                    $descIngrediente = $descIngrediente[0]['ingrediente_nombre'];
                    $posiinic = strpos($MoviOrdeComp[$keyMoviOrdeComp],'|',$posiinic) + 1;

                    $movicomp_cantidad = substr($MoviOrdeComp[$keyMoviOrdeComp],$posiinic,strpos($MoviOrdeComp[$keyMoviOrdeComp],'|',$posiinic) - $posiinic);
                    $posiinic = strpos($MoviOrdeComp[$keyMoviOrdeComp],'|',$posiinic) + 1;

                    $movicomp_costo_unit = substr($MoviOrdeComp[$keyMoviOrdeComp],$posiinic,strpos($MoviOrdeComp[$keyMoviOrdeComp],'|',$posiinic) - $posiinic);
                    $posiinic = strpos($MoviOrdeComp[$keyMoviOrdeComp],'|',$posiinic) + 1;

                    $movicomp_costo_total = substr($MoviOrdeComp[$keyMoviOrdeComp],$posiinic,strpos($MoviOrdeComp[$keyMoviOrdeComp],'|',$posiinic) - $posiinic);
                    $posiinic = strpos($MoviOrdeComp[$keyMoviOrdeComp],'|',$posiinic) + 1;

                    $movicomp_bodega_id = substr($MoviOrdeComp[$keyMoviOrdeComp],$posiinic,strpos($MoviOrdeComp[$keyMoviOrdeComp],'|',$posiinic) - $posiinic);
                    $descBodega = $this->compra->descBodega($movicomp_bodega_id);
                    $descBodega = $descBodega[0]['bodega_nombre'];
                    $posiinic = strpos($MoviOrdeComp[$keyMoviOrdeComp],'|',$posiinic) + 1;

                    $movicomp_estado_id = substr($MoviOrdeComp[$keyMoviOrdeComp],$posiinic,strpos($MoviOrdeComp[$keyMoviOrdeComp],'|',$posiinic) - $posiinic);
                    $descEstado = $this->compra->descEstado($movicomp_estado_id);
                    $descEstado = $descEstado[0]['estado_descripcion'];
                    $posiinic = strpos($MoviOrdeComp[$keyMoviOrdeComp],'|',$posiinic) + 1;

                    $imprMoviComp.="<tr>";
                    $imprMoviComp.="<td>".$id_movicomp_secuencia."</td>";
                    $imprMoviComp.="<td>".$descIngrediente."</td>";
                    $imprMoviComp.="<td>".$movicomp_cantidad."</td>";
                    $imprMoviComp.="<td>".$movicomp_costo_unit."</td>";
                    $imprMoviComp.="<td>".$movicomp_costo_total."</td>";
                    $imprMoviComp.="<td>".$descBodega."</td>";
                    $imprMoviComp.="<td>".$descEstado."</td>";
                    $imprMoviComp.="<td><button id='btn-eliminar' href='#' onclick=\"borraMovicomp('$this->urlBase','$idCompraMovi','$id_movicomp_secuencia')\" type='submit' class='btn btn-danger btn-circle'><i class='fa fa-times'></i></button></td>";
                    $imprMoviComp.="</tr>";
                    $posiinic = 0;
                }
            $cargaForma.=$imprMoviComp;
            $imprMoviComp = '';
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
    
    //Recarga el formulario de consulta de las compras a partir del criterio de búsqueda dado.
    function seleccionarCompra(){
        if($this->session->userdata('logged_in')){
            $this->load->model('compra');
            $valorComp = $_POST['compra_valor'];
            $compras  = $this->compra->selCompras($valorComp);
            $cargaForma = "<div class='form-group'>
                                                    <div id='lista'>
                                                        <table class='table table-bordered'width='100%'  border='0' cellspacing='0' cellpadding='0' style='font-size:10px'>
                                                            <thead>
                                                                <tr>
                                                                    <th>Código Compra</th>
                                                                    <th>Código Proveedor</th>
                                                                    <th>Nombre Proveedor</th>
                                                                    <th>Fecha</th>
                                                                    <th>Costo</th>
                                                                    <th>Descripción</th>
                                                                    <th>Estado</th>
                                                                </tr>
                                                            </thead>";
            if($compras != false){
                $imprCompra = "";
                $cargaForma.= "<tbody>";
                $posiinic = 0;
                foreach ($compras as $keyCompra=>$compra){
                    //Se acumula el html para los clientes
                    $idCompra = substr($compras[$keyCompra],$posiinic,strpos($compras[$keyCompra],'|',$posiinic) - $posiinic);
                    $posiinic = strpos($compras[$keyCompra],'|',$posiinic) + 1;

                    $compraProveedor = substr($compras[$keyCompra],$posiinic,strpos($compras[$keyCompra],'|',$posiinic) - $posiinic);
                    $descProveedor = $this->compra->descProveedor($compraProveedor);
                    $descProveedor = $descProveedor[0]['proveedor_nombre'];
                    $posiinic = strpos($compras[$keyCompra],'|',$posiinic) + 1;

                    $compraFecha = substr($compras[$keyCompra],$posiinic,strpos($compras[$keyCompra],'|',$posiinic) - $posiinic);
                    $posiinic = strpos($compras[$keyCompra],'|',$posiinic) + 1;

                    $compraCosto = substr($compras[$keyCompra],$posiinic,strpos($compras[$keyCompra],'|',$posiinic) - $posiinic);
                    $posiinic = strpos($compras[$keyCompra],'|',$posiinic) + 1;

                    $compraDescr = substr($compras[$keyCompra],$posiinic,strpos($compras[$keyCompra],'|',$posiinic) - $posiinic);
                    $posiinic = strpos($compras[$keyCompra],'|',$posiinic) + 1;
                    
                    $compraEstado = substr($compras[$keyCompra],$posiinic,strpos($compras[$keyCompra],'|',$posiinic) - $posiinic);
                    $descEstado = $this->compra->descEstado($compraEstado);
                    $descEstado = $descEstado[0]['estado_descripcion'];
                    $posiinic = strpos($compras[$keyCompra],'|',$posiinic) + 1;

                    $imprCompra.="<tr>";
                    $imprCompra.="<td>".$idCompra."</td>";
                    $imprCompra.="<td>".$compraProveedor."</td>";
                    $imprCompra.="<td>".$descProveedor."</td>";
                    $imprCompra.="<td>".$compraFecha."</td>";
                    $imprCompra.="<td>".$compraCosto."</td>";
                    $imprCompra.="<td>".$compraDescr."</td>";
                    $imprCompra.="<td>".$descEstado."</td>";
                    $imprCompra.="<td><button id='btn-modificar' href='#' onclick=\"modificaCompra('$this->urlBase','$idCompra')\" type='submit' class='btn btn-default btn-circle'><i class='fa fa-pencil'></i></button></td>";
                    $imprCompra.="<td><button id='btn-eliminar' href='#' onclick=\"borraCompra('$this->urlBase','$idCompra')\" type='submit' class='btn btn-danger btn-circle'><i class='fa fa-times'></i></button></td>";
                    $imprCompra.="</tr>";
                    $posiinic = 0;
                }
                $cargaForma.=$imprCompra;
                $imprCompra   = '';
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
    
    //Invoca el modelo de actualización de compras.
    function actualizarCompra(){
        if($this->session->userdata('logged_in')){
            $this->load->model('compra');
            $codigoComp      = $_POST['idComp'];
            $proveedorComp   = $_POST['proveedorComp'];
            $proveedorCodi   = substr($proveedorComp,0,strpos($proveedorComp,'-',0) - 1);
            $fechaComp       = $_POST['fechaComp'];
            $costoComp       = $_POST['costoComp'];
            $estadoComp      = $_POST['estadoComp'];
            $estadoCodi      = substr($estadoComp,0,strpos($estadoComp,'-',0) - 1);
            $descripcionComp = $_POST['descriComp'];
            $personaClie     = $this->session->userdata('idPers');
            $compra          = $this->compra->updCompra($codigoComp,$proveedorCodi,$fechaComp,$costoComp,$estadoCodi,
                                                          $descripcionComp,$personaClie);
            if(isset($compra)){
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
    
    //Invoca el modelo de eliminación de compras.
    function eliminarCompra(){
        if($this->session->userdata('logged_in')){
            $this->load->model('compra');
            $idCompra     = $_POST['idCompra'];
            $MoviOrdeComp = $this->compra->selMoviOrdeComp($idCompra);
            if(isset($MoviOrdeComp)){
                if($MoviOrdeComp == 0){
                    $compra = $this->compra->delCompra($idCompra);
                    if($compra){
                        /****************************************/
                        $compras = $this->compra->selCompras("");
                        $imprCompra = "";
                        $cargaForma  = "<div class='row' onload='consultaCompra('$this->urlBase')'>
                                    <!-- Page Header -->
                                    <div class='col-lg-12'>
                                        <h1 class='page-header'>Consultar Compra</h1>
                                    </div>
                                    <!--End Page Header -->
                                </div>
                                <div class='row'>
                                    <div class='col-lg-12'>
                                        <!-- Advanced Tables -->
                                        <div class='panel panel-default'>
                                            <div class='panel-heading'>
                                                 Consulta de Compras
                                            </div>
                                            <div class='panel-body'>
                                                <div class='table-responsive'>
                                                    <div id='dataTables-example_wrapper' class='dataTables_wrapper form-inline' role='grid'>
                                                        <div class='row'>
                                                            <div class='col-sm-6'>
                                                                <!-- search section-->
                                                                <div id='dataTables-example_filter' class='dataTables_filter'>
                                                                    <span class='input-group-btn'>
                                                                        <input type='search' id='compra-valor' class='form-control input-sm' aria-controls='dataTables-example' placeholder='Buscar'>
                                                                        <button id='busca-compra' class='btn btn-default' onclick=\"consultaCompra('$this->urlBase')\" type='submit'><i class='fa fa-search'></i></button>
                                                                    </span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div id='compras' class='row'>
                                                            <div class='form-group'>
                                                                <div id='lista'>
                                                                    <table class='table table-bordered'width='100%'  border='0' cellspacing='0' cellpadding='0' style='font-size:10px'>
                                                                        <thead>
                                                                            <tr>
                                                                                <th>Código Compra</th>
                                                                                <th>Código Proveedor</th>
                                                                                <th>Nombre Proveedor</th>
                                                                                <th>Fecha</th>
                                                                                <th>Costo</th>
                                                                                <th>Descripción</th>
                                                                                <th>Estado</th>
                                                                            </tr>
                                                                        </thead>";
                        if($compras != false){
                            $imprCompra = "";
                            $cargaForma.= "<tbody>";
                            $posiinic = 0;
                            foreach ($compras as $keyCompra=>$compra){
                                //Se acumula el html para los clientes
                                $idCompra = substr($compras[$keyCompra],$posiinic,strpos($compras[$keyCompra],'|',$posiinic) - $posiinic);
                                $posiinic = strpos($compras[$keyCompra],'|',$posiinic) + 1;

                                $compraProveedor = substr($compras[$keyCompra],$posiinic,strpos($compras[$keyCompra],'|',$posiinic) - $posiinic);
                                $descProveedor = $this->compra->descProveedor($compraProveedor);
                                $descProveedor = $descProveedor[0]['proveedor_nombre'];
                                $posiinic = strpos($compras[$keyCompra],'|',$posiinic) + 1;

                                $compraFecha = substr($compras[$keyCompra],$posiinic,strpos($compras[$keyCompra],'|',$posiinic) - $posiinic);
                                $posiinic = strpos($compras[$keyCompra],'|',$posiinic) + 1;

                                $compraCosto = substr($compras[$keyCompra],$posiinic,strpos($compras[$keyCompra],'|',$posiinic) - $posiinic);
                                $posiinic = strpos($compras[$keyCompra],'|',$posiinic) + 1;

                                $compraDescr = substr($compras[$keyCompra],$posiinic,strpos($compras[$keyCompra],'|',$posiinic) - $posiinic);
                                $posiinic = strpos($compras[$keyCompra],'|',$posiinic) + 1;

                                $compraEstado = substr($compras[$keyCompra],$posiinic,strpos($compras[$keyCompra],'|',$posiinic) - $posiinic);
                                $descEstado = $this->compra->descEstado($compraEstado);
                                $descEstado = $descEstado[0]['estado_descripcion'];
                                $posiinic = strpos($compras[$keyCompra],'|',$posiinic) + 1;

                                $imprCompra.="<tr>";
                                $imprCompra.="<td>".$idCompra."</td>";
                                $imprCompra.="<td>".$compraProveedor."</td>";
                                $imprCompra.="<td>".$descProveedor."</td>";
                                $imprCompra.="<td>".$compraFecha."</td>";
                                $imprCompra.="<td>".$compraCosto."</td>";
                                $imprCompra.="<td>".$compraDescr."</td>";
                                $imprCompra.="<td>".$descEstado."</td>";
                                $imprCompra.="<td><button id='btn-modificar' href='#' onclick=\"modificaCompra('$this->urlBase','$idCompra')\" type='submit' class='btn btn-default btn-circle'><i class='fa fa-pencil'></i></button></td>";
                                $imprCompra.="<td><button id='btn-eliminar' href='#' onclick=\"borraCompra('$this->urlBase','$idCompra')\" type='submit' class='btn btn-danger btn-circle'><i class='fa fa-times'></i></button></td>";
                                $imprCompra.="</tr>";
                                $posiinic = 0;
                            }
                            $cargaForma.=$imprCompra;
                            $imprCompra   = '';
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
                    echo("movicomp");
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
}
?>
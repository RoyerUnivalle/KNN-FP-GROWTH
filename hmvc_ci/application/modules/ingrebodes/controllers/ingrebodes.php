<?php if (! defined('BASEPATH')) exit('No direct script access allowed');
 
class IngreBodes extends MX_Controller {
    
    function __construct(){
        parent::__construct();
        $this->urlBase = base_url();
    }
 
    function index(){
        echo("ingrebodes.index");
    }
    
    
    //Carga el formulario de consulta de los ingrebodes por bodega.
    function consultarIngreBode(){
        if($this->session->userdata('logged_in')){
            $valorIngreBode = "";
            $this->load->model('ingrebode');
            $ingrebodes    = $this->ingrebode->consIngreBode($valorIngreBode);
            $imprIngreBode = "";
                $cargaForma  = "<div class='row' onload='consultaIngreBode('$this->urlBase')'>
                        <!-- Page Header -->
                        <div class='col-lg-12'>
                            <h1 class='page-header'>Consultar Ingredientes por Bodega</h1>
                        </div>
                        <!--End Page Header -->
                    </div>
                    <div class='row'>
                        <div class='col-lg-12'>
                            <!-- Advanced Tables -->
                            <div class='panel panel-default'>
                                <div class='panel-heading'>
                                     Consulta de Ingredientes por Bodega
                                </div>
                                <div class='panel-body'>
                                    <div class='table-responsive'>
                                        <div id='dataTables-example_wrapper' class='dataTables_wrapper form-inline' role='grid'>
                                            <div class='row'>
                                                <div class='col-sm-6'>
                                                    <!-- search section-->
                                                    <div id='dataTables-example_filter' class='dataTables_filter'>
                                                        <span class='input-group-btn'>
                                                            <input type='search' id='ingrebode-valor' class='form-control input-sm' aria-controls='dataTables-example' placeholder='Buscar'>
                                                            <button id='busca-ingrebode' class='btn btn-default' onclick=\"consultaIngreBode('$this->urlBase')\" type='submit'><i class='fa fa-search'></i></button>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div id='ingrebodes' class='row'>
                                                <div class='form-group'>
                                                    <div id='lista'>
                                                        <table class='table table-bordered'width='100%'  border='0' cellspacing='0' cellpadding='0' style='font-size:10px'>
                                                            <thead>
                                                                <tr>
                                                                    <th>Código Bodega</th>
                                                                    <th>Nombre Bodega</th>
                                                                    <th>Código Ingrediente</th>
                                                                    <th>Nombre Ingrediente</th>
                                                                    <th>Cantidad</th>
                                                                    <th>Fecha Registro</th>
                                                                    <th>Persona Registra</th>
                                                                </tr>
                                                            </thead>";
            if($ingrebodes != false){
                $imprIngreBode = "";
                $cargaForma.= "<tbody>";
                $posiinic = 0;                                                
                foreach ($ingrebodes as $keyIngreBode=>$ingrebode){
                    //Se acumula el html para los ingrebodes
                    $idBodega = substr($ingrebodes[$keyIngreBode],$posiinic,strpos($ingrebodes[$keyIngreBode],'|',$posiinic) - $posiinic);
                    $bodega      = $this->ingrebode->selBodega($idBodega);
                    $descBodega = $bodega[0]['bodega_nombre'];
                    $posiinic = strpos($ingrebodes[$keyIngreBode],'|',$posiinic) + 1;

                    $idIngrebode = substr($ingrebodes[$keyIngreBode],$posiinic,strpos($ingrebodes[$keyIngreBode],'|',$posiinic) - $posiinic);
                    $ingrediente = $this->ingrebode->selIngrediente($idIngrebode);
                    $descIngrediente = $ingrediente[0]['ingrediente_nombre'];
                    $posiinic = strpos($ingrebodes[$keyIngreBode],'|',$posiinic) + 1;

                    $ingrebodeCantidad = substr($ingrebodes[$keyIngreBode],$posiinic,strpos($ingrebodes[$keyIngreBode],'|',$posiinic) - $posiinic);
                    $posiinic = strpos($ingrebodes[$keyIngreBode],'|',$posiinic) + 1;
                    
                    $ingrebodeFechaRegi = substr($ingrebodes[$keyIngreBode],$posiinic,strpos($ingrebodes[$keyIngreBode],'|',$posiinic) - $posiinic);
                    $posiinic = strpos($ingrebodes[$keyIngreBode],'|',$posiinic) + 1;

                    $ingrebodePersona = substr($ingrebodes[$keyIngreBode],$posiinic,strpos($ingrebodes[$keyIngreBode],'|',$posiinic) - $posiinic);
                    $posiinic = strpos($ingrebodes[$keyIngreBode],'|',$posiinic) + 1;

                    $imprIngreBode.="<tr>";
                    $imprIngreBode.="<td>".$idBodega."</td>";
                    $imprIngreBode.="<td>".$descBodega."</td>";
                    $imprIngreBode.="<td>".$idIngrebode."</td>";
                    $imprIngreBode.="<td>".$descIngrediente."</td>";
                    $imprIngreBode.="<td>".$ingrebodeCantidad."</td>";
                    $imprIngreBode.="<td>".$ingrebodeFechaRegi."</td>";
                    $imprIngreBode.="<td>".$ingrebodePersona."</td>";
                    $imprIngreBode.="</tr>";
                    $posiinic = 0;
                }
                $cargaForma.=$imprIngreBode;
                $imprIngreBode   = '';
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
    
    function seleccionarIngrebode(){
        if($this->session->userdata('logged_in')){
            $this->load->model('ingrebode');
            $valorIngrebode = $_POST['ingrebode_valor'];
            $ingrebodes  = $this->ingrebode->consIngrebode($valorIngrebode);
            $imprIngrebode = "";
            $cargaForma = "<div class='form-group'>
                                                    <div id='lista'>
                                                        <table class='table table-bordered'width='100%'  border='0' cellspacing='0' cellpadding='0' style='font-size:10px'>
                                                            <thead>
                                                                <tr>
                                                                    <th>Código Bodega</th>
                                                                    <th>Nombre Bodega</th>
                                                                    <th>Código Ingrediente</th>
                                                                    <th>Nombre Ingrediente</th>
                                                                    <th>Cantidad</th>
                                                                    <th>Fecha Registro</th>
                                                                    <th>Persona Registra</th>
                                                                </tr>
                                                            </thead>";
            if($ingrebodes != false){
                $imprIngreBode = "";
                $cargaForma.= "<tbody>";
                $posiinic = 0;                                                
                foreach ($ingrebodes as $keyIngreBode=>$ingrebode){
                    //Se acumula el html para los ingrebodes
                    $idBodega = substr($ingrebodes[$keyIngreBode],$posiinic,strpos($ingrebodes[$keyIngreBode],'|',$posiinic) - $posiinic);
                    $bodega      = $this->ingrebode->selBodega($idBodega);
                    $descBodega = $bodega[0]['bodega_nombre'];
                    $posiinic = strpos($ingrebodes[$keyIngreBode],'|',$posiinic) + 1;

                    $idIngrebode = substr($ingrebodes[$keyIngreBode],$posiinic,strpos($ingrebodes[$keyIngreBode],'|',$posiinic) - $posiinic);
                    $ingrediente = $this->ingrebode->selIngrediente($idIngrebode);
                    $descIngrediente = $ingrediente[0]['ingrediente_nombre'];
                    $posiinic = strpos($ingrebodes[$keyIngreBode],'|',$posiinic) + 1;

                    $ingrebodeCantidad = substr($ingrebodes[$keyIngreBode],$posiinic,strpos($ingrebodes[$keyIngreBode],'|',$posiinic) - $posiinic);
                    $posiinic = strpos($ingrebodes[$keyIngreBode],'|',$posiinic) + 1;
                    
                    $ingrebodeFechaRegi = substr($ingrebodes[$keyIngreBode],$posiinic,strpos($ingrebodes[$keyIngreBode],'|',$posiinic) - $posiinic);
                    $posiinic = strpos($ingrebodes[$keyIngreBode],'|',$posiinic) + 1;

                    $ingrebodePersona = substr($ingrebodes[$keyIngreBode],$posiinic,strpos($ingrebodes[$keyIngreBode],'|',$posiinic) - $posiinic);
                    $posiinic = strpos($ingrebodes[$keyIngreBode],'|',$posiinic) + 1;

                    $imprIngreBode.="<tr>";
                    $imprIngreBode.="<td>".$idBodega."</td>";
                    $imprIngreBode.="<td>".$descBodega."</td>";
                    $imprIngreBode.="<td>".$idIngrebode."</td>";
                    $imprIngreBode.="<td>".$descIngrediente."</td>";
                    $imprIngreBode.="<td>".$ingrebodeCantidad."</td>";
                    $imprIngreBode.="<td>".$ingrebodeFechaRegi."</td>";
                    $imprIngreBode.="<td>".$ingrebodePersona."</td>";
                    $imprIngreBode.="</tr>";
                    $posiinic = 0;
                }
                $cargaForma.=$imprIngreBode;
                $imprIngreBode   = '';
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
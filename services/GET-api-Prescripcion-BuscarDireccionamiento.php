<?php
header("Content-Type: text/html; charset=iso-8859-1");
set_time_limit(1000);
require_once('../modelo/conexion-sql.php');
if ((!empty($_POST['var_Reg'])) and (!empty($_POST['var_Prs']))) {

    $sql = "SELECT * FROM PRS_URL_SERVICES WHERE COD_URL = '4'";
    $params = array();
    $options = array("Scrollable" => SQLSRV_CURSOR_KEYSET);
    $stmt = sqlsrv_query($conn, $sql, $params, $options);
    $row_count = sqlsrv_num_rows($stmt);
    if ($row_count === false) {
        echo "<div class='alert alert-danger alert-dismissible'>";
        echo "<button type='button' class='close' data-dismiss='alert'>&times;</button>";
        echo "<strong>Error!</strong> No se encuentra el recurso solicitado, error: ERROR0006</div>";
    } else {
        while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
            $url = $row['DES_URL'] . $_POST['var_Nit'] . '/' . $_POST['var_Tok'] . '/' . $_POST['var_Prs'];
            $ch = curl_init($url);
            curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json; charset=utf-8'));
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
            $result = curl_exec($ch);
            $array = json_decode($result, true);
            if (count($array) <> 0) {
                $i = 0;
                ?>

                <div class="list-group">
                    <a   onclick="javascript:tabla_prescripcion();" class="list-group-item list-group-item-action list-group-item-info"><span class="badge badge-info badge-pill"><?php echo count($array); ?></span> Detalle</a>
                </div>

                <div class="table-responsive" id="tabla_prescripcion">
                    <table class="table table-hover table-sm">
                        <tbody>
                            <tr>
                                <td colspan="1"><small><strong>Estado:</strong></small><br>
                                    <?php echo ValorRefMipres($conn, 'PRESCRIPCION', 'ESTPRES', $array[$i]['prescripcion']['EstPres']); ?></td>
                                <td colspan="2"><small><strong>Tipo de Transcripcion:</strong></small><br>
                                    <?php echo ValorRefMipres($conn, 'PRESCRIPCION', 'TIPOTRANSC', $array[$i]['prescripcion']['TipoTransc']); ?></td>
                                <td colspan="2"><small><strong>Codigo de la EPS:</strong></small><br>
                                    <?php echo ValorRefMipres($conn, 'PRESCRIPCION', 'CODEPS', $array[$i]['prescripcion']['CodEPS']); ?></td>
                            </tr>	

                            <tr>
                                <td colspan="3"><small><strong>Fecha y Hora:</strong></small><br>
                                    <?php echo FormatoFechaMipres($array[$i]['prescripcion']['FPrescripcion']) . ' ' . $array[$i]['prescripcion']['HPrescripcion']; ?></td>
                                <td colspan="2"><small><strong>Numero de Prescripcion:</strong></small><br>
                                    <?php echo $array[$i]['prescripcion']['NoPrescripcion']; ?></td>
                            </tr>					   	
                            <tr>
                                <th colspan="5" class="table-active"><center>DATOS DEL PRESTADOR</center></th>
                        </tr>
                        <tr>
                            <td colspan="2"><small><strong>Departamento:</strong></small><br>
                                <?php echo NombreDepartamento($conn, $array[$i]['prescripcion']['CodDANEMunIPS']); ?></td>
                            <td colspan="2"><small><strong>Municipio:</strong></small><br>
                                <?php echo NombreMunicipio($conn, $array[$i]['prescripcion']['CodDANEMunIPS']); ?></td>
                            <td><small><strong>Codigo Habilitacion:</strong></small><br>
                                <?php echo $array[$i]['prescripcion']['CodHabIPS']; ?></td>
                        </tr>
                        <tr>
                            <td colspan="3"><small><strong>Nombre del prestador de Servicios de Salud:</strong></small><br>
                                <?php echo NombrePrestador($conn, $array[$i]['prescripcion']['NroIDIPS']); ?></td>
                            <td colspan="2"><small><strong>Documento de Identificacion:</strong></small><br>
                                <?php echo $array[$i]['prescripcion']['TipoIDIPS'] . ' ' . $array[$i]['prescripcion']['NroIDIPS']; ?></td>
                        </tr>
                        <tr>
                            <td colspan="3"><small><strong>Direccion:</strong></small><br>
                                <?php echo $array[$i]['prescripcion']['DirSedeIPS']; ?></td>
                            <td colspan="2"><small><strong>Telefono:</strong></small><br>
                                <?php echo $array[$i]['prescripcion']['TelSedeIPS']; ?></td>
                        </tr>
                        <tr>
                            <th colspan="5" class="table-active"><center>DATOS DEL PACIENTE</center></th>
                        </tr>
                        <tr>
                            <td colspan="1"><small><strong>Identificacion:</strong></small><br>
                                <?php echo $array[$i]['prescripcion']['TipoIDPaciente'] . ' ' . $array[$i]['prescripcion']['NroIDPaciente']; ?></td>
                            <td colspan="3"><small><strong>Nombre:</strong></small><br>
                                <?php echo $array[$i]['prescripcion']['PNPaciente'] . ' ' . $array[$i]['prescripcion']['SNPaciente'] . ' ' . $array[$i]['prescripcion']['PAPaciente'] . ' ' . $array[$i]['prescripcion']['SAPaciente']; ?></td>
                            <td colspan="1"><small><strong>Regimen:</strong></small><br>
                                <?php echo $_POST['var_Reg']; ?></td>
                        </tr>
                        <tr>
                            <td><small><strong>Ambito de Atencion:</strong></small><br>
                                <?php echo ValorRefMipres($conn, 'PRESCRIPCION', 'CODAMBATE', $array[$i]['prescripcion']['CodAmbAte']); ?></td>
                            <td><small><strong>Referencia o contrareferencia:</strong></small><br>
                                <?php echo SiNoRefMipres($array[$i]['prescripcion']['RefAmbAte']); ?></td>
                            <td><small><strong>Enfermedad Huerfana:</strong></small><br>
                                <?php echo SiNoRefMipres($array[$i]['prescripcion']['EnfHuerfana']); ?></td>
                            <td><small><strong>Codigo Enfermedad Huerfana:</strong></small><br>
                                <?php echo ValorRefMipres($conn, 'PRESCRIPCION', 'CODENFHUERFANA', $array[$i]['prescripcion']['CodEnfHuerfana']); ?></td>
                            <td><small><strong>Enfermedad huerfana es el diagnostico principal:</strong></small><br>
                                <?php echo SiNoRefMipres($array[$i]['prescripcion']['EnfHuerfanaDX']); ?></td>
                        </tr>
                        <tr>
                            <td colspan="5"><small><strong>Diagnostico Principal:</strong></small><br>
                                <?php echo $array[$i]['prescripcion']['CodDxPpal'] . ' ' . NombreDiagnostico($conn, $array[$i]['prescripcion']['CodDxPpal']); ?></td>
                        </tr>
                        <tr>
                            <td colspan="5"><small><strong>Diagnostico Relacionado 1:</strong></small><br>
                                <?php echo $array[$i]['prescripcion']['CodDxRel1'] . ' ' . NombreDiagnostico($conn, $array[$i]['prescripcion']['CodDxRel1']); ?></td>
                        </tr>
                        <tr>
                            <td colspan="4"><small><strong>Diagnostico Relacionado 2:</strong></small><br>
                                <?php echo $array[$i]['prescripcion']['CodDxRel2'] . ' ' . NombreDiagnostico($conn, $array[$i]['prescripcion']['CodDxRel2']); ?></td>
                            <td><small><strong>Requiere soporte nutricional:</strong></small><br>
                                <?php echo SiNoRefMipres($array[$i]['prescripcion']['SopNutricional']); ?></td>
                        </tr>
                        <tr>
                            <td colspan="3"><small><strong>Documento madre del recien nacido:</strong></small><br>
                                <?php echo $array[$i]['prescripcion']['TipoIDMadrePaciente'] . ' ' . $array[$i]['prescripcion']['NroIDMadrePaciente']; ?></td>
                            <td colspan="2"><small><strong>Documento del donante vivo:</strong></small><br>
                                <?php echo $array[$i]['prescripcion']['TipoIDDonanteVivo'] . ' ' . $array[$i]['prescripcion']['NroIDDonanteVivo']; ?></td>
                        </tr>
                        <tr>
                            <th colspan="5" class="table-active"><center>PROFESIONAL TRATANTE</center></th>
                        </tr>
                        <tr>
                            <td colspan="3"><small><strong>Documento de identificacion:</strong></small><br>
                                <?php echo $array[$i]['prescripcion']['TipoIDProf'] . ' ' . $array[$i]['prescripcion']['NumIDProf']; ?></td>
                            <td colspan="2"><small><strong>Registro profesional:</strong></small><br>
                                <?php echo $array[$i]['prescripcion']['RegProfS']; ?></td>
                        </tr>
                        <tr>
                            <td colspan="5"><small><strong>Nombre:</strong></small><br>
                                <?php echo $array[$i]['prescripcion']['PNProfS'] . ' ' . $array[$i]['prescripcion']['SNProfS'] . ' ' . $array[$i]['prescripcion']['PAProfS'] . ' ' . $array[$i]['prescripcion']['SAProfS']; ?></td>
                        </tr>

                        </tbody>
                    </table>	
                </div>






                <!-- PROCEDIMIENTOS -->

                <div class="list-group">
                    <a  onclick="javascript:tabla_procedimientos();" class="list-group-item list-group-item-action list-group-item-info"><span class="badge badge-info badge-pill"><?php echo sizeof($array[0]['procedimientos']); ?></span> Procedimientos</a>
                </div>

                <?php
                if (sizeof($array[$i]['procedimientos']) <> 0) {
                    ?>
                    <div class="table-responsive" id="tabla_procedimientos">
                        <table class="table table-hover table-sm">
                            <tr class="table-active">
                                <th><small><strong>Orden</strong></small></th>
                                <th><small><strong>Presentacion</strong></small></th>
                                <th><small><strong>Procedimieto</strong></small></th>
                                <th><small><strong>Indicaciones</strong></small></th>
                                <th><small><strong>Cantidad</strong></small></th>
                                <th><small><strong>Frecuencia Uso</strong></small></th>
                                <th><small><strong>Diracion</strong></small></th>
                                <th><small><strong>Cantidad Total</strong></small></th>
                                <th><small><strong>Estado JM</strong></small></th>
                            </tr>
                            <?php
                            for ($p = 0, $size_Pro = sizeof($array[$i]['procedimientos']); $p < $size_Pro; ++$p) {
                                echo '<tr>';
                                ?>
                                <td>
                                <center>
                                    <button type="button" class="btn btn-outline-success"  
                                            onclick="javascript:mostrar_modal('<?php echo $array[$i]['prescripcion']['NoPrescripcion']; ?>', '<?php echo 'P'; ?>', '<?php echo $array[$i]['procedimientos'][$p]['ConOrden']; ?>', '<?php echo $array[$i]['prescripcion']['TipoIDPaciente']; ?>', '<?php echo $array[$i]['prescripcion']['NroIDPaciente']; ?>', '<?php echo $array[$i]['procedimientos'][$p]['CodCUPS']; ?>'
                                                            );">
                                                <?php echo $array[$i]['procedimientos'][$p]['ConOrden']; ?> 
                                    </button>
                                </center>
                                </td>
                                <?php
                                echo '<td><small>' . ValorRefMipres($conn, 'PROCEDIMIENTOS', 'TIPOPREST', $array[$i]['procedimientos'][$p]['TipoPrest']) . '</small></td>
             <td><small>' . $array[$i]['procedimientos'][$p]['CodCUPS'] . ' ' . NombreProcedimiento($conn, $array[$i]['procedimientos'][$p]['CodCUPS']) . '</small></td>
             <td><small>' . $array[$i]['procedimientos'][$p]['IndRec'] . '</small></td>
             <td><small>' . $array[$i]['procedimientos'][$p]['CanForm'] . '</small></td>
             <td><small>' . $array[$i]['procedimientos'][$p]['CadaFreUso'] . ' ' . ValorRefMipres($conn, 'PROCEDIMIENTOS', 'CODFREUSO', $array[$i]['procedimientos'][$p]['CodFreUso']) . '</small></td>
             <td><small>' . $array[$i]['procedimientos'][$p]['Cant'] . ' ' . ValorRefMipres($conn, 'PROCEDIMIENTOS', 'CODPERDURTRAT', $array[$i]['procedimientos'][$p]['CodPerDurTrat']) . '</small></td>
             <td><small>' . $array[$i]['procedimientos'][$p]['CantTotal'] . '</small></td>
             <td><small>' . ValorRefMipres($conn, 'PROCEDIMIENTOS', 'ESTJM', $array[$i]['procedimientos'][$p]['EstJM']) . '</small></td>
   </tr>';
                            }
                            ?>  
                        </table>
                    </div>
                    <?php
                }
                ?>


                <!-- FIN PROCEDIMIENTOS -->



                <!-- MEDICAMENTOS -->
                <div class="list-group">
                    <a  onclick="javascript:tabla_medicamentos();" class="list-group-item list-group-item-action list-group-item-info"><span class="badge badge-info badge-pill"><?php echo sizeof($array[0]['medicamentos']); ?></span> Medicamentos</a>
                </div>

                <?php
                if (sizeof($array[$i]['medicamentos']) <> 0) {
                    ?>
                    <div class="table-responsive" id="tabla_medicamentos">
                        <table class="table table-hover table-sm">
                            <tr class="table-active">
                                <th><small><strong>Orden</strong></small></th>
                                <th><small><strong>Presentacion</strong></small></th>
                                <th><small><strong>Medicamento</strong></small></th>
                                <th><small><strong>Forma Farm.</strong></small></th>
                                <th><small><strong>Dosis</strong></small></th>
                                <th><small><strong>Via</strong></small></th>
                                <th><small><strong>Frecuencia</strong></small></th>
                                <th><small><strong>Indicaciones</strong></small></th>
                                <th><small><strong>Duracion</strong></small></th>
                                <th><small><strong>Total</strong></small></th>
                                <th><small><strong>Estado JM</strong></small></th>
                            </tr>
                            <?php
                            for ($p = 0, $size_Pro = sizeof($array[$i]['medicamentos']); $p < $size_Pro; ++$p) {
                                echo '<tr>
             <td><small>' . $array[$i]['medicamentos'][$p]['ConOrden'] . '</small></td>
             <td><small>' . ValorRefMipres($conn, 'MEDICAMENTOS', 'TIPOPREST', $array[$i]['medicamentos'][$p]['TipoPrest']) . '</small></td>
             <td><small>' . $array[$i]['medicamentos'][$p]['DescMedPrinAct'] . '</small></td>
             <td><small>' . ValorRefMipres($conn, 'MEDICAMENTOS', 'CodFF', $array[$i]['medicamentos'][$p]['CodFF']) . '</small></td>
             <td><small>' . $array[$i]['medicamentos'][$p]['Dosis'] . ' ' . ValorRefMipres($conn, 'MEDICAMENTOS', 'DOSISUM', $array[$i]['medicamentos'][$p]['DosisUM']) . '</small></td>
             <td><small>' . ValorRefMipres($conn, 'MEDICAMENTOS', 'CodVA', $array[$i]['medicamentos'][$p]['CodVA']) . '</small></td>
             <td><small>' . $array[$i]['medicamentos'][$p]['NoFAdmon'] . ' ' . ValorRefMipres($conn, 'MEDICAMENTOS', 'CODFREADMON', $array[$i]['medicamentos'][$p]['CodFreAdmon']) . '</small></td>
             <td><small>' . ValorRefMipres($conn, 'MEDICAMENTOS', 'INDESP', $array[$i]['medicamentos'][$p]['IndEsp']) . '</small></td>
             <td><small>' . $array[$i]['medicamentos'][$p]['CanTrat'] . ' ' . ValorRefMipres($conn, 'MEDICAMENTOS', 'DURTRAT', $array[$i]['medicamentos'][$p]['DurTrat']) . '</small></td>
             <td><small>' . $array[$i]['medicamentos'][$p]['CantTotalF'] . ' ' . ValorRefMipres($conn, 'MEDICAMENTOS', 'UFCantTotal', $array[$i]['medicamentos'][$p]['UFCantTotal']) . '</small></td>
             <td><small>' . ValorRefMipres($conn, 'MEDICAMENTOS', 'ESTJM', $array[$i]['medicamentos'][$p]['EstJM']) . '</small></td>
   </tr>';
                            }
                            ?>  
                        </table>
                    </div>
                    <?php
                }
                ?>



                <!-- FIN MEDICAMENTOS -->


                <!-- NUTRICIONALES  -->
                <div class="list-group">
                    <a onclick="javascript:tabla_productos();" class="list-group-item list-group-item-action list-group-item-info"><span class="badge badge-info badge-pill"><?php echo sizeof($array[0]['productosnutricionales']); ?></span> Productos Nutricionales</a>
                </div>


                <?php
                if (sizeof($array[$i]['productosnutricionales']) <> 0) {
                    ?>
                    <div class="table-responsive" id="tabla_productos">
                        <table class="table table-hover table-sm">
                            <tr class="table-active">
                                <th><small><strong>Orden</strong></small></th>
                                <th><small><strong>Presentacion</strong></small></th>
                                <th><small><strong>Tipo Producto</strong></small></th>
                                <th><small><strong>Producto</strong></small></th>
                                <th><small><strong>Forma</strong></small></th>
                                <th><small><strong>Dosis</strong></small></th>
                                <th><small><strong>Via</strong></small></th>
                                <th><small><strong>Frecuencia</strong></small></th>
                                <th><small><strong>Indicaciones</strong></small></th>
                                <th><small><strong>Duracion</strong></small></th>
                                <th><small><strong>Total</strong></small></th>
                                <th><small><strong>Estado JM</strong></small></th>
                            </tr>
                            <?php
                            for ($p = 0, $size_Pro = sizeof($array[$i]['productosnutricionales']); $p < $size_Pro; ++$p) {
                                echo '<tr>
             <td><small>' . $array[$i]['productosnutricionales'][$p]['ConOrden'] . '</small></td>
             <td><small>' . ValorRefMipres($conn, 'NATURALES', 'TIPOPREST', $array[$i]['productosnutricionales'][$p]['TipoPrest']) . '</small></td>
             <td><small>' . ValorRefMipres($conn, 'NATURALES', 'TIPPPRONUT', $array[$i]['productosnutricionales'][$p]['TippProNut']) . '</small></td>
             <td><small>' . ValorRefMipres($conn, 'NATURALES', 'DESCPRODNUTR', $array[$i]['productosnutricionales'][$p]['DescProdNutr']) . '</small></td>
             <td><small>' . ValorRefMipres($conn, 'NATURALES', 'CODFORMA', $array[$i]['productosnutricionales'][$p]['CodForma']) . '</small></td>
             <td><small>' . $array[$i]['productosnutricionales'][$p]['Dosis'] . ' ' . ValorRefMipres($conn, 'NATURALES', 'DOSISUM', $array[$i]['productosnutricionales'][$p]['DosisUM']) . '</small></td>
             <td><small>' . ValorRefMipres($conn, 'NATURALES', 'CODVIAADMON', $array[$i]['productosnutricionales'][$p]['CodViaAdmon']) . '</small></td>
             <td><small>' . $array[$i]['productosnutricionales'][$p]['NoFAdmon'] . ' ' . ValorRefMipres($conn, 'NATURALES', 'CODFREADMON', $array[$i]['productosnutricionales'][$p]['CodFreAdmon']) . '</small></td>
             <td><small>' . ValorRefMipres($conn, 'NATURALES', 'INDESP', $array[$i]['productosnutricionales'][$p]['IndEsp']) . '</small></td>
             <td><small>' . $array[$i]['productosnutricionales'][$p]['CanTrat'] . ' ' . ValorRefMipres($conn, 'NATURALES', 'DURTRAT', $array[$i]['productosnutricionales'][$p]['DurTrat']) . '</small></td>
             <td><small>' . $array[$i]['productosnutricionales'][$p]['CantTotalF'] . ' ' . ValorRefMipres($conn, 'NATURALES', 'UFCANTTOTAL', $array[$i]['productosnutricionales'][$p]['UFCantTotal']) . '</small></td>
             <td><small>' . ValorRefMipres($conn, 'NATURALES', 'ESTJM', $array[$i]['productosnutricionales'][$p]['EstJM']) . '</small></td>
   </tr>';
                            }
                            ?>  
                        </table>
                    </div>
                    <?php
                }
                ?>

                <!-- FIN NUTRICIONALES  -->




                <!-- COMPLEMENTARIOS  -->

                <div class="list-group">
                    <a  onclick="javascript:tabla_complementarios();" class="list-group-item list-group-item-action list-group-item-info"><span class="badge badge-info badge-pill"><?php echo sizeof($array[0]['serviciosComplementarios']); ?></span> Servicios Complementarios</a>
                </div>
                <?php
                if (sizeof($array[$i]['serviciosComplementarios']) <> 0) {
                    ?>
                    <div class="table-responsive" id="tabla_complementarios">
                        <table class="table table-hover table-sm">
                            <tr class="table-active">
                                <th><small><strong>Orden</strong></small></th>
                                <th><small><strong>Presentacion</strong></small></th>
                                <th><small><strong>Servicio</strong></small></th>
                                <th><small><strong>Tipo Transporte</strong></small></th>
                                <th><small><strong>Indicaciones</strong></small></th>
                                <th><small><strong>Cantidad</strong></small></th>
                                <th><small><strong>Frecuencia</strong></small></th>
                                <th><small><strong>Duracion</strong></small></th>
                                <th><small><strong>Total</strong></small></th>
                                <th><small><strong>Estado JM</strong></small></th>
                            </tr>
                            <?php
                            for ($p = 0, $size_Pro = sizeof($array[$i]['serviciosComplementarios']); $p < $size_Pro; ++$p) {
                                echo '<tr>
             <td><small>' . $array[$i]['serviciosComplementarios'][$p]['ConOrden'] . '</small></td>
             <td><small>' . ValorRefMipres($conn, 'COMPLEMENTARIOS', 'TIPOPREST', $array[$i]['serviciosComplementarios'][$p]['TipoPrest']) . '</small></td>
             <td><small>' . ValorRefMipres($conn, 'COMPLEMENTARIOS', 'CODSERCOMP', $array[$i]['serviciosComplementarios'][$p]['CodSerComp']) . '</small></td>
             <td><small>' . ValorRefMipres($conn, 'COMPLEMENTARIOS', 'TIPOTRANS', $array[$i]['serviciosComplementarios'][$p]['TipoTrans']) . '</small></td>
             <td><small>' . $array[$i]['serviciosComplementarios'][$p]['IndRec'] . '</small></td>
             <td><small>' . $array[$i]['serviciosComplementarios'][$p]['CanForm'] . '</small></td>
             <td><small>' . $array[$i]['serviciosComplementarios'][$p]['CanForm'] . ' ' . ValorRefMipres($conn, 'COMPLEMENTARIOS', 'CODFREUSO', $array[$i]['serviciosComplementarios'][$p]['CodFreUso']) . '</small></td>
             <td><small>' . $array[$i]['serviciosComplementarios'][$p]['Cant'] . ' ' . ValorRefMipres($conn, 'COMPLEMENTARIOS', 'CODPERDURTRAT', $array[$i]['serviciosComplementarios'][$p]['CodPerDurTrat']) . '</small></td>
             <td><small>' . $array[$i]['serviciosComplementarios'][$p]['CantTotal'] . '</small></td>
             <td><small>' . ValorRefMipres($conn, 'COMPLEMENTARIOS', 'ESTJM', $array[$i]['serviciosComplementarios'][$p]['EstJM']) . '</small></td>
   </tr>';
                            }
                            ?>  
                        </table>
                    </div>
                    <?php
                }
                ?>
                <!-- FIN COMPLEMENTARIOS  -->



                <!-- DISPOSITIVOS -->
                <div class="list-group">
                    <a   onclick="javascript:tabla_dispositivos();" class="list-group-item list-group-item-action list-group-item-info"><span class="badge badge-info badge-pill"><?php echo sizeof($array[0]['dispositivos']); ?></span> Dispositivos</a>
                </div>

                <?php
                if (sizeof($array[$i]['dispositivos']) <> 0) {
                    ?>
                    <div class="table-responsive" id="tabla_dispositivos">
                        <table class="table table-hover table-sm">
                            <tr class="table-active">
                                <th><small><strong>Orden</strong></small></th>
                                <th><small><strong>Presentacion</strong></small></th>
                                <th><small><strong>Dispositivo</strong></small></th>
                                <th><small><strong>Cantidad</strong></small></th>
                                <th><small><strong>Frecuencia</strong></small></th>
                                <th><small><strong>Duracion</strong></small></th>
                                <th><small><strong>Total</strong></small></th>
                                <th><small><strong>Indicaciones</strong></small></th>
                                <th><small><strong>Estado JM</strong></small></th>
                            </tr>
                            <?php
                            for ($p = 0, $size_Pro = sizeof($array[$i]['dispositivos']); $p < $size_Pro; ++$p) {
                                echo '<tr>
   <td><small>' . $array[$i]['dispositivos'][$p]['ConOrden'] . '</small></td>
   <td><small>' . ValorRefMipres($conn, 'DISPOSITIVOS', 'TIPOPREST', $array[$i]['dispositivos'][$p]['TipoPrest']) . '</small></td>
   <td><small>' . ValorRefMipres($conn, 'DISPOSITIVOS', 'CODDISP', $array[$i]['dispositivos'][$p]['CodDisp']) . '</small></td>
   <td><small>' . $array[$i]['dispositivos'][$p]['CanForm'] . '</small></td>
   <td><small>' . $array[$i]['dispositivos'][$p]['CadaFreUso'] . ' ' . ValorRefMipres($conn, 'DISPOSITIVOS', 'CODFREUSO', $array[$i]['dispositivos'][$p]['CodFreUso']) . '</small></td>
   <td><small>' . $array[$i]['dispositivos'][$p]['Cant'] . ' ' . ValorRefMipres($conn, 'DISPOSITIVOS', 'CODPERDURTRAT', $array[$i]['dispositivos'][$p]['CodPerDurTrat']) . '</small></td>
   <td><small>' . $array[$i]['dispositivos'][$p]['CantTotal'] . '</small></td>
   <td><small>' . $array[$i]['dispositivos'][$p]['IndRec'] . '</small></td>
   <td><small>' . ValorRefMipres($conn, 'DISPOSITIVOS', 'ESTJM', $array[$i]['dispositivos'][$p]['EstJM']) . '</small></td>
   </tr>';
                            }
                            ?>  
                        </table>
                    </div>
                    <?php
                }
                ?>



                <!-- FIN DISPOSITIVOS -->


                <?php
            } else {

                if ($_POST['var_Reg'] == 'Subsidiado') {
                    echo "<script type='text/javascript'>ListarPrescripcion('C');</script>";
                } else
                if ($_POST['var_Reg'] == 'Contributivo') {
                    ?>
                    <div class="alert alert-warning alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert">&times;</button>
                        No se encontraron resultados, por favor verificar el numero de prescripcion.
                    </div>
                    <?php
                }
            }
        }
    }



    sqlsrv_free_stmt($stmt);
} else {
    echo "<div class='alert alert-danger alert-dismissible'>";
    echo "<button type='button' class='close' data-dismiss='alert'>&times;</button>";
    echo "<strong>Alerta!</strong> Por favor diligenciar el numero de prescripcion</div>";
}
?>


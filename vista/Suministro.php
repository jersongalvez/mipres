<div class="col-md-12 sm-12">
    <div class="card shadow">
        <div class="card-header">
            <H4>Reporte de Suministro</H4>
        </div>
        <div class="card-body">

            <form action="index.php?x=040&y=001" method="post">
                <div class="form-row">
                    <div class="col-md-4 sm-12">
                        <input type="number" class="form-control" id="radicado" name="radicado" required placeholder="Número de Prescripción" autofocus value="">
                    </div>
                    <div class="col-md-2 sm-12">
                        <button 
                            class="btn btn-outline-dark btn-block" type="submit" >Buscar</button> 
                        <br>
                    </div>
                </div>    
            </form>

        </div>
    </div>
</div>
<br>
<div class="col-md-12 sm-12">
    <div class="card shadow">
        <ul class="nav nav-tabs" role="tablist">
            <li class="nav-item">
                <a class="nav-link active" data-toggle="tab" href="#home">Prescripción</a>
            </li>
        </ul>
        <?php
          if (isset($_GET["y"])) {
            switch ($_GET["y"]) {
              case '001':
                $radicado = trim($_POST["radicado"]);
        ?>
          <script type="text/javascript">
            document.getElementById("radicado").value = '<?php echo $radicado; ?>';
           </script>
           <?php
             break;
            }
        }
           ?>
        <div class="col-md-12 sm-12">
            <div class="tab-content">
                <div id="home" class="tab-pane active"><br>
                    <?php
                    if (!empty($radicado)) {

                        $sql = "
                            SELECT DISTINCT NOPRESCRIPCION, CODEPS, IIF(REPORTMIPRES='NOPRESCRIPCION','PRESCRIPCION','TUTELA') REPORTMIPRES,
                            FPRESCRIPCION, TIPOIDPACIENTE+' '+NROIDPACIENTE IDENTIFICACION,  REPLACE(PNPACIENTE+' '+SNPACIENTE+' '+PAPACIENTE+' '+SAPACIENTE, '  ', ' ') NOMBRE, dbo.fnc_valor_mipres('PRESCRIPCION','CODAMBATE',CODAMBATE) CODAMBATE, (SELECT DES_TEM_TOKEN FROM PRS_TEM_TOKEN WHERE TIP_TEM_TOKEN =  IIF(CODEPS= 'EPSI06','S','C')) TOKEN
                            FROM  MIPRES_PRESCRIPCION
                            WHERE NOPRESCRIPCION = '" . $radicado . "' ";
                        $stmt2 = sqlsrv_query($conn, $sql, array());

                        if ($stmt2 !== NULL) {
                            $rows2 = sqlsrv_has_rows($stmt2);

                            if ($rows2 === true) {
                                ?>
                                <br>
                                <div class="row">
                                    <div class="col">
                                        <div class="card shadow">
                                            <div class="card-body">
                                                <div class="row">
                                                    <div class="col">              
                                                        <table class="table">
                                                            <thead class="thead-light">
                                                                <tr>
                                                                    <th>NO. PRESCRIPCIÓN</th>
                                                                    <th>TIPO REPORTE</th>
                                                                    <th>FEC. PRESCRIPCIÓN</th>
                                                                    <th>IDENTIFICACIÓN</th>
                                                                    <th>NOMBRE AFILIADO</th>
                                                                    <th>AMBITO</th>
                                                                    <th>EPS</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <?php
                                                                while ($row2 = sqlsrv_fetch_array($stmt2, SQLSRV_FETCH_ASSOC)) {
                                                                    ?>							<tr>
                                                                        <td><button class="btn btn-outline-secondary" type="button" id="BtnRelacionar" onclick="javascript:Modal('<?php echo $row2['NOPRESCRIPCION']; ?>', '<?php echo $row2['TOKEN']; ?>');"><?php echo $row2['NOPRESCRIPCION']; ?></button></td>
                                                                        <td><?php echo $row2['REPORTMIPRES']; ?></td>
                                                                        <td><?php echo $row2['FPRESCRIPCION']->format('d/m/Y'); ?></td>
                                                                        <td><?php echo $row2['IDENTIFICACION']; ?></td>
                                                                        <td><?php echo utf8_encode($row2['NOMBRE']); ?></td>
                                                                        <td><?php echo utf8_encode($row2['CODAMBATE']); ?></td>
                                                                        <td><?php echo utf8_encode($row2['CODEPS']); ?></td>
                                                                    </tr>

                                                                    <?php
                                                                }
                                                                ?>

                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <?php
                            } else {
                                echo "<BR>\nNo se encuentran prescripciones relacionadas en las autorizaciones cobradas de la factura con número de radicado " . $radicado . " \n<br><br>";
                            }
                        }
                    }
                    ?>
                    <br>
                </div>
            </div>
        </div>
    </div>
</div>
<br>

<div class="modal fade" data-backdrop="static" id="Ven_Direccionamiento">
    <div class="modal-dialog modal-dialog-centered modal-xl" >
        <div class="modal-content" >
            <div class="modal-header">
                <h5 class="modal-title" id="titulo_modal"></h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="container">
                <div id="Info"><center><div class='spinner-border text-success'></div></center></div>
            </div> 
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>

<!-- TICKET 670 JERSON GALVEZ  -->

<div class="modal fade" data-backdrop="static" id="Asociar_Suministro">
    <div class="modal-dialog modal-dialog-centered modal-xl" >
        <div class="modal-content" >
            <div class="modal-header">
                <h5 class="modal-title" id="titulo_modal">ASOCIAR SIMINISTROS A LA FACTURA</h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="container">

                <div id="Info2"><center><div class='spinner-border text-success'></div></center></div>

            </div> 
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>
<!-- END TICKET-->

<div class="col-md-12 sm-12">
    <div class="card shadow">
        <div class="card-body">
            <form class="" action="index.php?x=045" method="post" >
                <input type="hidden" class="form-control" id="TokenSuministro" name="TokenSuministro" required readonly>
                <input type="hidden" class="form-control" id="NoPrescripcion" name="NoPrescripcion" required readonly>
                <input type="hidden" class="form-control" id="TipoTec" name="TipoTec" required readonly>
                <input type="hidden" class="form-control" id="ConTec" name="ConTec" required readonly>
                <input type="hidden" class="form-control" id="TipoIDPaciente" name="TipoIDPaciente" required readonly>
                <input type="hidden" class="form-control" id="NoIDPaciente" name="NoIDPaciente" required readonly>
                <input type="hidden" class="form-control" id="NoEntrega" name="NoEntrega" required readonly>
                <div class="form-row">
                    <div class="col-md-4 sm-12">
                        <label>Identificador</label>
                    </div>
                    <div class="col-md-8 sm-12">
                        <div class="input-group mb-3">
                            <input type="text" class="form-control" id="Identificador" name="Identificador" required readonly>
                        </div>
                    </div>
                </div>	
                <div class="form-row">
                    <div class="col-md-4 sm-12">
                        <label>Última Entrega</label>
                    </div>
                    <div class="col-md-8 sm-12">
                        <select class="form-control" id="UltEntrega" name="UltEntrega" required >
                            <option></option>
                            <option value="0">NO</option>
                            <option value="1">SI</option>
                        </select>
                    </div>
                </div>
                <div class="form-row">
                    <div class="col-md-4 sm-12">
                        <label>Entrega Completa</label>
                    </div>
                    <div class="col-md-8 sm-12">
                        <select class="form-control" id="EntregaCompleta" name="EntregaCompleta" required >
                            <option></option>
                            <option value="0">NO</option>
                            <option value="1">SI</option>
                        </select>
                    </div>
                </div>
                <div class="form-row">
                    <div class="col-md-4 sm-12">
                        <label>Causas de no entrega</label>
                    </div>

                    <div class="col-md-8 sm-12" id="div_CausaNoEntrega">
                        <select class="form-control" id="CausaNoEntrega" name="CausaNoEntrega" readonly>
                        </select>
                    </div>
                </div>
                <div class="form-row">
                    <div class="col-md-4 sm-12">
                        <label>Número Prescripción asociada</label>
                    </div>
                    <div class="col-md-8 sm-12">
                        <input type="text" class="form-control" id="NoPrescripcionAsociada" name="NoPrescripcionAsociada" required readonly>
                    </div>
                </div>
                <div class="form-row">
                    <div class="col-md-4 sm-12">
                        <label>Consecutivo Orden asociada</label>
                    </div>
                    <div class="col-md-8 sm-12">
                        <input type="text" class="form-control" id="ConTecAsociada" name="ConTecAsociada" required readonly> 
                    </div>
                </div>
                <div class="form-row">
                    <div class="col-md-4 sm-12">
                        <label>Cantidad Total Entregada</label>
                    </div>  
                    <div class="col-md-8 sm-12">
                        <input type="text" class="form-control" id="CantTotEntregada" name="CantTotEntregada" required readonly> 
                    </div>
                </div>
                <div class="form-row">
                    <div class="col-md-4 sm-12">
                        <label>Lote entregado</label>
                    </div>
                    <div class="col-md-8 sm-12">
                        <input type="text" class="form-control" id="NoLote" name="NoLote" required readonly > 
                    </div>
                </div>
                <div class="form-row">
                    <div class="col-md-4 sm-12">
                        <label>Valor de la entrega facturado</label>
                    </div>
                    <div class="col-md-8 sm-12">
                        <input type="text" class="form-control" id="ValorEntregado" name="ValorEntregado" required readonly> 
                    </div>
                </div>
                <div class="form-row" >
                    <div class="col-md-4 sm-12">
                        <label>No solicitud</label>
                    </div>
                    <div class="col-md-8 sm-12">
                        <input type="text" class="form-control" id="NoSolicitud" name="NoSolicitud" required readonly> 
                    </div>
                </div>
                <div class="form-row" >
                    <div class="col-md-4 sm-12">
                        <label>tabla</label>
                    </div>
                    <div class="col-md-8 sm-12">
                        <input type="text" class="form-control" id="CodigoTabla" name="CodigoTabla" required readonly> 
                    </div>
                </div>
                <div class="form-row" >
                    <div class="col-md-4 sm-12">
                        <label>Codigo servicio</label>
                    </div>
                    <div class="col-md-8 sm-12">
                        <input type="text" class="form-control" id="CodigoServicio" name="CodigoServicio" required readonly> 
                    </div>
                </div>
                <div class="form-row" >
                    <div class="col-md-4 sm-12">
                        <label>ID Trazabilidad</label>
                    </div>
                    <div class="col-md-8 sm-12">
                        <input type="text" class="form-control" id="IdTrazabiliad" name="IdTrazabiliad" required readonly> 
                    </div>
                </div>
                <br>

                <div class="form-row">
                    <div class="col-md-3 sm-3"></div>
                    <div class="col-md-6 sm-6">
                        <button  class="btn btn-outline-dark btn-block" type="submit" >Generar reporte suministro</button> 
                    </div>
                    <div class="col-md-3 sm-3"></div>
                </div>
            </form>
        </div>
    </div>
</div>
<br>
<script type="text/javascript">

    function Modal(NoPrescripcion, Token) {
        document.getElementById("TokenSuministro").value = Token;
        document.getElementById("titulo_modal").innerHTML = "Número de prescripción " + NoPrescripcion;
        $('#Ven_Direccionamiento').modal('show');
        $.post("vista/templates/EntregaPrescripcion.php", {NoPrescripcion: NoPrescripcion}, function (data) {
            $("#Info").html(data);
        });
    }

    function RelacionarEntrega(ID, ValorEntregado, NoPrescripcionAsociada, ConTecAsociada, CantTotEntregada, CausaNoEntrega, TipoTec, TipoIDPaciente, NoIDPaciente, NoEntrega) {
        document.getElementById("Identificador").value = ID;
        document.getElementById("ValorEntregado").value = ValorEntregado;
        //document.getElementById("NoLote").value = NoLote;
        document.getElementById("NoPrescripcionAsociada").value = NoPrescripcionAsociada;
        document.getElementById("NoPrescripcion").value = NoPrescripcionAsociada;
        document.getElementById("ConTecAsociada").value = ConTecAsociada;
        document.getElementById("CantTotEntregada").value = CantTotEntregada;
        document.getElementById("TipoTec").value = TipoTec;
        document.getElementById("ConTec").value = ConTecAsociada;
        document.getElementById("TipoIDPaciente").value = TipoIDPaciente;
        document.getElementById("NoIDPaciente").value = NoIDPaciente;
        document.getElementById("NoEntrega").value = NoEntrega;
        $("#IdTrazabiliad").val(ID);
        document.getElementById('div_CausaNoEntrega').innerHTML = "<center><div class='spinner-border text-success'></div></center>";
        $.post("vista/templates/CausaNoEntrega.php", {CausaNoEntrega: CausaNoEntrega, TipoTec: TipoTec}, function (data) {
            $("#div_CausaNoEntrega").html(data);
        });
        $('#Ven_Direccionamiento').modal('hide');
        modalSuministros(NoPrescripcionAsociada);
    }

    // TIQUET 670 JERSON GALVEZ
    function modalSuministros(NoPrescripcion) 
    {
        $('#Asociar_Suministro').modal("show");
        $.post("vista/templates/AsociarSuministroPrescripcion.php", {NoPrescripcion: NoPrescripcion}, function (data) {
            $("#Info2").html(data);
            
        });
    }

    function AsociarSuministros(solicitud, tabla, servicio) 
    {   
        $("#NoSolicitud").val(solicitud);
        $("#CodigoServicio").val(servicio);
        $("#CodigoTabla").val(tabla);
        $('#Asociar_Suministro').modal("hide");
    }

    //END
</script>
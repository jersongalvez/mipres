<?php
require_once('modelo/conexion-sql.php');
if ((!empty($_POST['NO_SOLICITUD'])) and (!empty($_POST['TABLA'])) and (!empty($_POST['CD_SERVICIO']))) {
  $NO_SOLICITUD = $_POST['NO_SOLICITUD'];
  $TABLA = $_POST['TABLA'];
  $CD_SERVICIO = $_POST['CD_SERVICIO'];
  $_POST['NUM_COMITECTC'];
  RelacionarServicioMipres($conn, $_POST['NUM_COMITECTC'], $NO_SOLICITUD, $TABLA, $CD_SERVICIO);
  $sql = "SELECT (SELECT DES_TEM_TOKEN FROM PRS_TEM_TOKEN WHERE TIP_TEM_TOKEN = AUT.TIP_REGIMEN) AS DES_TEM_TOKEN, AUT.*, SER.*, PRE.TIP_IDENTIFICACION, CEN.NUM_DEPARTAMENTO, CEN.NUM_CIUDAD FROM AUTORIZACION AS AUT INNER JOIN SERVICIOS_AUTORIZADOS AS SER ON AUT.NO_SOLICITUD = SER.NO_SOLICITUD LEFT JOIN PRESTADORES AS PRE ON AUT.NR_IDENT_PREST_IPS = PRE.NIT_PRESTADOR LEFT JOIN CENTROATENCIPS AS CEN ON AUT.NR_IDENT_PREST_IPS+AUT.NR_IDENT_PREST = CEN.NIT_PRESTADOR+CEN.PUN_ATENCION WHERE AUT.NO_SOLICITUD = '" . $NO_SOLICITUD . "' AND SER.TABLA = '" . $TABLA . "' AND SER.CD_SERVICIO = '" . $CD_SERVICIO . "' ";
  $params = array();
  $options = array("Scrollable" => SQLSRV_CURSOR_KEYSET);
  $stmt = sqlsrv_query($conn, $sql, $params, $options);
  $row_count = sqlsrv_num_rows($stmt);
  if ($row_count == 0) {
    echo "<div class='alert alert-warning alert-dismissible'>";
    echo "<button type='button' class='close' data-dismiss='alert'>&times;</button>";
    echo "<strong>Alerta!</strong> No se encuentran resultados.</div>";
  } else {
  $row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC);
  $fecha_autorizacion = $row['FEC_AUTORIZACION']->format('Y-m-d');
  $FecMaxEnt = date("Y-m-d", strtotime($fecha_autorizacion . "+ " . FecMaxEnt($conn, $_POST['NO_SOLICITUD']) . " days"));
  $FecMaxEnt = date("Y-m-d", strtotime($FecMaxEnt . "- 1 days"));
?>
  <div class="row">
    <div class="col-md-3 sm-12">
      <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
        <a
          class="btn btn-outline-dark btn-block"
          id="v-pills-profile-tab"
          href="index.php?x=007&y=001&TI=<?php echo $row['TP_IDENT_AFILIA']; ?>&NI=<?php echo $row['NR_IDENT_AFILIA']; ?>"
          ><center>Regresar por Usuario</center>
        </a>
        <a
          class="btn btn-outline-dark btn-block"
          id="v-pills-profile-tab"
          href="index.php?x=035"><center>Ser. sin Direccionar</center>
        </a>
        <a
          class="btn btn-outline-dark btn-block"
          id="v-pills-profile-tab"
          href="index.php?x=007"><center>Cancelar</center>
        </a>
        <br>
        <button
          class='btn btn-outline-dark btn-block'
          type='button'
          onclick="javascript:HistoricoEntregas();"
        >
          Historico de Entregas
        </button>
      </div>
    </div>
    <div class="col-md-9 sm-12">
      <div class="tab-content" id="v-pills-tabContent">
        <div class="card shadow">
          <div class="card-header">
            <h4>Nuevo Direccionamiento</h4>
          </div>
          <div class="card-body">
            <form class="" action="index.php?x=009" method="post" >
              <input
                type="hidden"
                class="form-control"
                id="NO_SOLICITUD"
                name="NO_SOLICITUD"
                required
                value="<?php echo $NO_SOLICITUD; ?>"
              >
              <input
                type="hidden"
                class="form-control"
                id="TABLA"
                name="TABLA"
                required
                value="<?php echo $TABLA; ?>"
              >
              <input
                type="hidden"
                class="form-control"
                id="CD_SERVICIO"
                name="CD_SERVICIO"
                required
                value="<?php echo cd_medicamento1($TABLA, $CD_SERVICIO); ?>"
              >
              <input
                type="hidden"
                class="form-control"
                id="DES_TEM_TOKEN"
                name="DES_TEM_TOKEN"
                required
                value="<?php echo $row['DES_TEM_TOKEN']; ?>"
              >
              <div class="form-row">
                <div class="col-md-4 sm-12">
                  <label>Prescripción</label>
                </div>
                <div class="col-md-8 sm-12">
                  <div class="input-group mb-3">
                    <input
                      type="number"
                      class="form-control"
                      id="NoPrescripcion"
                      name="NoPrescripcion"
                      required
                      readonly
                      value="<?php echo $row['NUM_COMITECTC']; ?>"
                    >
                    <div class="input-group-append">
                      <button
                        class="btn btn-outline-secondary"
                        type="button"
                        id="BtnRelacionar"
                        onclick="javascript:ServiciosSolicitados();"
                      > Relacionar Servicio
                      </button>
                     </div>
                   </div>
                 </div>
                </div>
                <div class="form-row">
                  <div class="col-md-4 sm-12">
                    <label>Regimen</label>
                  </div>
                  <div class="col-md-8 sm-12">
                    <input
                      type="text"
                      class="form-control"
                      id="Regimen_s"
                      name="Regimen_s"
                      required readonly value="<?php echo $row['TIP_REGIMEN']; ?>"
                    >
                  </div>
                  </div>
                  <div class="form-row">
                    <div class="col-md-4 sm-12">
                      <label>Servicio o Tecnología</label>
                    </div>
                  <div class="col-md-8 sm-12">
                    <input
                      type="text"
                      class="form-control"
                      id="TipoTec"
                      name="TipoTec"
                      required
                      readonly
                      value="<?php echo $row['TIPOTEC']; ?>"
                      >
                  </div>
                </div>
                <div class="form-row">
                  <div class="col-md-4 sm-12">
                    <label>Consecutivo Orden</label>
                  </div>
                <div class="col-md-8 sm-12">
                  <input
                    type="number"
                    class="form-control"
                    id="ConTec"
                    name="ConTec"
                    required
                    readonly
                    value="<?php echo $row['CONTEC']; ?>"
                  >
                </div>
              </div>
              <div class="form-row">
                <div class="col-md-4 sm-12">
                  <label>Código servicio</label>
                </div>
                <div class="col-md-8 sm-12">
                  <input
                    type="text"
                    class="form-control"
                    id="CodSerTecAEntregar"
                    name="CodSerTecAEntregar"
                    required
                    readonly
                    value="<?php echo cd_medicamento1($TABLA, $row['CODSERTEC']); ?>"
                  >
                </div>
              </div>
              <div class="form-row">
                <div class="col-md-4 sm-12">
                  <label>Tipo de Documento</label>
                </div>
                <div class="col-md-8 sm-12">
                  <input
                    type="text"
                    class="form-control"
                    id="TipoIDPaciente"
                    name="TipoIDPaciente"
                    required
                    readonly
                    value="<?php echo ($row['TP_IDENT_AFILIA'] === 'CN') ? "NV" : $row['TP_IDENT_AFILIA']; ?>"
                  >
                </div>
              </div>
              <div class="form-row">
                <div class="col-md-4 sm-12">
                  <label>Nro. de Documento</label>
                </div>
                <div class="col-md-8 sm-12">
                  <input
                    type="number"
                    class="form-control"
                    id="NoIDPaciente"
                    name="NoIDPaciente"
                    required
                    readonly
                    value="<?php echo $row['NR_IDENT_AFILIA']; ?>"
                  >
                </div>
              </div>
              <div class="form-row">
                <div class="col-md-4 sm-12">
                  <label>Número Entrega</label>
                </div>
                <div class="col-md-8 sm-12">
                  <select  id="NoEntrega" class="form-control" name="NoEntrega" required>
                    <option value="1" <?php echo $row['SECUENCIA'] == "1"  ? 'selected' : ''; ?>>1</option>
                    <option value="2" <?php echo $row['SECUENCIA'] == "2"  ? 'selected' : ''; ?>>2</option>
                    <option value="3" <?php echo $row['SECUENCIA'] == "3"  ? 'selected' : ''; ?>>3</option>
                    <option value="4" <?php echo $row['SECUENCIA'] == "4"  ? 'selected' : ''; ?>>4</option>
                    <option value="5" <?php echo $row['SECUENCIA'] == "5"  ? 'selected' : ''; ?>>5</option>
                    <option value="6" <?php echo $row['SECUENCIA'] == "6"  ? 'selected' : ''; ?>>6</option>
                    <option value="7" <?php echo $row['SECUENCIA'] == "7"  ? 'selected' : ''; ?>>7</option>
                    <option value="8" <?php echo $row['SECUENCIA'] == "8"  ? 'selected' : ''; ?>>8</option>
                    <option value="9" <?php echo $row['SECUENCIA'] == "9"  ? 'selected' : ''; ?>>9</option>
                    <option value="10"<?php echo $row['SECUENCIA'] == "10" ? 'selected' : ''; ?>>10</option>
                    <option value="11"<?php echo $row['SECUENCIA'] == "11" ? 'selected' : ''; ?>>11</option>
                    <option value="12"<?php echo $row['SECUENCIA'] == "12" ? 'selected' : ''; ?>>12</option>
                  </select>
                </div>
              </div>
              <div class="form-row">
                <div class="col-md-4 sm-12">
                  <label>Total Sub Entrega</label>
                </div>
                <div class="col-md-8 sm-12">
                  <input type="text" id="NoSubEntrega" value="0" class="form-control" name="NoSubEntrega" required readonly>
                </div>
              </div>
              <div class="form-row">
                <div class="col-md-4 sm-12">
                  <label>Tipo Proveedor</label>
                </div>
                <div class="col-md-8 sm-12">
                  <input
                    type="text"
                    class="form-control"
                    id="TipoIDProv"
                    name="TipoIDProv"
                    required
                    readonly
                    value="<?php echo ValorRefMipres($conn, 'DIRECCIONAMIENTO', 'TipoIDProv', $row['TIP_IDENTIFICACION']); ?>"
                  >
                </div>
              </div>
              <div class="form-row">
                <div class="col-md-4 sm-12">
                  <label>Número Proveedor</label>
                </div>
                <div class="col-md-8 sm-12">
                  <input
                    type="number"
                    class="form-control"
                    id="NoIDProv"
                    name="NoIDProv"
                    required
                    readonly
                    value="<?php echo QuitarCerosIzquierda($row['NR_IDENT_PREST_IPS']); ?>"
                   >
                </div>
              </div>
              <div class="form-row">
                <div class="col-md-4 sm-12">
                  <label>Lugar de Entrega</label>
                </div>
                <div class="col-md-8 sm-12">
                  <div class="input-group">
                    <input
                      type="text"
                      class="form-control"
                      id="CodMunEnt"
                      name="CodMunEnt"
                      required
                      readonly
                      value="<?php echo $row['NUM_DEPARTAMENTO'] . $row['NUM_CIUDAD']; ?>"
                    >
                    <input
                      type="text"
                      class="form-control"
                      readonly value="<?php echo NombreDepartamento($conn, $row['NUM_DEPARTAMENTO'] . $row['NUM_CIUDAD']); ?>"
                    >
                    <input
                      type="text"
                      class="form-control"
                      readonly
                      value="<?php echo NombreMunicipio($conn, $row['NUM_DEPARTAMENTO'] . $row['NUM_CIUDAD']); ?>"
                    >
                  </div>
                </div>
                </div>
                  <div class="form-row">
                    <div class="col-md-4 sm-12">
                      <label>Fecha Máxima</label>
                    </div>
                    <div class="col-md-8 sm-12">
                      <input
                        type="date"
                        class="form-control"
                        id="FecMaxEnt"
                        name="FecMaxEnt"
                        value="<?php echo $FecMaxEnt; ?>"
                        required
                        readonly
                       >
                    </div>
                  </div>
                  <div class="form-row">
                    <div class="col-md-4 sm-12">
                      <label>Cantidad Total</label>
                    </div>
                    <div class="col-md-8 sm-12">
                      <input
                        type="number"
                        class="form-control"
                        id="CantTotAEntregar"
                        name="CantTotAEntregar"
                        required
                        readonly
                        value="<?php echo $row['CANTIDAD']; ?>"
                      >
                    </div>
                  </div>
                  <div class="form-row">
                    <div class="col-md-4 sm-12">
                      <label>Dirección del Paciente</label>
                    </div>
                    <div class="col-md-8 sm-12">
                      <input type="text" class="form-control" id="DirPaciente" name="DirPaciente"  required readonly value="<?php
                      if (($row['DIR_AFILIADO'] <> '') or (empty(!$row['DIR_AFILIADO']))) {
                            echo utf8_encode($row['DIR_AFILIADO']);
                      } else {
                            echo NombreMunicipio($conn, $row['NUM_DEPARTAMENTO'] . $row['NUM_CIUDAD']);
                      }
                      ?>"
                      >
                      </div>
                    </div>
                    <br>
                    <div class="form-row">
                      <div class="col-md-12 sm-12">
                        <div id="ValidarRelacion"></div>
                          <div id="ProcesoDireccionamiento">
                          <?php
                            if ($row['IDDIRECCIONAMIENTO'] <> "") {
                          ?>
                          <script>document.getElementById("BtnRelacionar").disabled = true;</script>
                        <div class="row">
                          <div class="col-md-12 sm-12">
                            <div class="card">
                              <div class="card-body">
                                <div class="form-row">
                                  <div class="col-md-4 sm-12">
                                    <label>Identificador</label>
                                  </div>
                                  <div class="col-md-8 sm-12">
                                    <input
                                      type="number"
                                      class="form-control"
                                      id="Id"
                                      name="Id"
                                      required
                                      readonly
                                      value="<?php echo $row['IDENTIFICADOR']; ?>"
                                    >
                                   </div>
                                </div>
                                <div class="form-row">
                                  <div class="col-md-4 sm-12">
                                    <label>Id Direccionamiento</label>
                                  </div>
                                  <div class="col-md-8 sm-12">
                                    <input
                                      type="number"
                                      class="form-control"
                                      id="IdDireccionamiento"
                                      name="IdDireccionamiento"
                                      required readonly value="<?php echo $row['IDDIRECCIONAMIENTO']; ?>"
                                    >
                                  </div>
                                </div>
                                <div class="form-row">
                                  <div class="col-md-12 sm-12">
                                    <small id="usu"><?php echo $row['DIREC_USUARIO'] ?></small>
                                    <small id="fec"><?php echo $row['DIREC_FECHA']->format('d/m/Y'); ?></small>
                                  </div>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                        <?php
                        } else {
                        ?>
                          <button
                            class='btn btn-outline-dark btn-block'
                            type='submit'
                            onclick="javascript:progreso('Consultando');"
                           >
                            Generar Direccionamiento
                          </button>
                        <?php
                          }
                        ?>
                       </div>
                     </div>
                    </div>
                  </form>
                </div>
              </div>
            </div>
         </div>
      </div>
      <?php
    }
      sqlsrv_free_stmt($stmt);
    } else {
      echo "<div class='alert alert-danger alert-dismissible'>";
      echo "<button type='button' class='close' data-dismiss='alert'>&times;</button>";
      echo "<strong>Alerta!</strong> Ha ocurrido un error, por favor intentelo nuevamente.</div>";
    }
?>
<div class="modal fade" data-backdrop="static" id="Ven_Direccionamiento">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Servicios solicitados en <?php echo $row['NUM_COMITECTC']; ?></h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <div id="DataDireccionamiento"></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" data-backdrop="static" id="HistoricoEntregas">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Direccionamientos Previos</h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <div id="DataHistoricoEntregas"></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    function ServiciosSolicitados() {
        document.getElementById('DataDireccionamiento').innerHTML = "<center><div class='spinner-border text-success'></div></center>";
        $('#Ven_Direccionamiento').modal('show');
        var NUM_COMITECTC = document.getElementById("NoPrescripcion").value;
        var NO_SOLICITUD = "<?php echo $NO_SOLICITUD ?>";
        var TABLA = "<?php echo $TABLA; ?>";
        var CD_SERVICIO = "<?php echo $CD_SERVICIO ?>";
        $.post("vista/templates/ServiciosSolicitados.php", {NUM_COMITECTC: NUM_COMITECTC, NO_SOLICITUD: NO_SOLICITUD, TABLA: TABLA, CD_SERVICIO: CD_SERVICIO}, function (data) {
            $("#DataDireccionamiento").html(data);
        });
    }

    function Relacionar(TipoTec, ConTec, CodSerTecAEntregar) {
        document.getElementById('ValidarRelacion').innerHTML = "<center><div class='spinner-border text-success'></div></center>";
        $('#Ven_Direccionamiento').modal('hide');
        document.getElementById("TipoTec").value = TipoTec;
        document.getElementById("ConTec").value = ConTec;
        document.getElementById("CodSerTecAEntregar").value = CodSerTecAEntregar;
        var NO_SOLICITUD = "<?php echo $NO_SOLICITUD ?>";
        var TABLA = "<?php echo $TABLA ?>";
        var CD_SERVICIO = "<?php echo $CD_SERVICIO ?>";
        $.post("vista/templates/ValidarRelacion.php", {TipoTec: TipoTec, ConTec: ConTec, NO_SOLICITUD: NO_SOLICITUD, TABLA: TABLA, CD_SERVICIO: CD_SERVICIO, CODSERTEC: CodSerTecAEntregar}, function (data) {
            $("#ValidarRelacion").html(data);
        });
    }

    function HistoricoEntregas() {
        document.getElementById('DataHistoricoEntregas').innerHTML = "<center><div class='spinner-border text-success'></div></center>";
        $('#HistoricoEntregas').modal('show');
        var NoPrescripcion = document.getElementById("NoPrescripcion").value;
        var TipoTec = '<?php echo $row['TIPOTEC']; ?>';
        var ConTec = '<?php echo $row['CONTEC']; ?>';
        $.post("vista/templates/HistoricoEntregas.php", {NoPrescripcion: NoPrescripcion, TipoTec: TipoTec, ConTec: ConTec}, function (data) {
            $("#DataHistoricoEntregas").html(data);
        });
    }
</script>
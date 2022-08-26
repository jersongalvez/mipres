<?php
require_once('modelo/conexion-sql.php');

if ((!empty($_POST['NO_SOLICITUD'])) and (!empty($_POST['TABLA'])) and (!empty($_POST['CD_SERVICIO']))) {
  $NO_SOLICITUD = $_POST['NO_SOLICITUD'];
  $TABLA = $_POST['TABLA'];
  $CD_SERVICIO = $_POST['CD_SERVICIO'];
  //echo $NO_SOLICITUD.'<br>';
  //echo $TABLA.'<br>';
  //echo $CD_SERVICIO.'<br>';
?>
  <div class="row">
    <div class="col-md-3 sm-12">
      <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
        <a
          class="btn btn-outline-dark btn-block"
          id="v-pills-profile-tab"
          href="index.php"><center>Volver al Inicio</center>
        </a>
        <a
          class="btn btn-outline-dark btn-block"
          id="v-pills-profile-tab"
          href="index.php?x=010"><center>Anular Direccionamiento</center>
        </a>
        <a
          class="btn btn-outline-dark btn-block"
          id="v-pills-profile-tab"
          href="index.php?x=036"><center>Servicios por Anular</center>
        </a>
      </div>
    </div>
    <div class="col-md-9 sm-12">
      <div class="tab-content" id="v-pills-tabContent">
        <div class="card ">
          <div class="card-header">
            <h4>Anular Direccionamiento</h4>
          </div>
          <div class="card-body">
            <div id="ProcesoDireccionamiento"><center><div class='spinner-border text-success'></div></center></div>
              <?php
                if (isset($_GET["x"])) {
                  switch ($_GET["x"]) {
                    case '0011':
                      require_once("services/PUT-api-AnularDireccionamiento-nit-token.php");
                    if (!curl_errno($ch)) {
                    switch ($http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE)) {
                      case 200:  # OK
                        $sql = "UPDATE SERVICIOS_AUTORIZADOS SET IDENTIFICADOR = NULL, IDDIRECCIONAMIENTO = NULL, DIREC_USUARIO = NULL, DIREC_FECHA = NULL WHERE NO_SOLICITUD = '" . $_POST['NO_SOLICITUD'] . "' AND TABLA = '" . $_POST['TABLA'] . "' AND CD_SERVICIO = '" . $_POST['CD_SERVICIO'] . "'; ";
                        $params = array();
                        $options = array("Scrollable" => SQLSRV_CURSOR_KEYSET);
                        $stmt = sqlsrv_query($conn, $sql, $params, $options);
                        if ($stmt === FALSE) {
                          echo "<div class='alert alert-danger alert-dismissible'>";
                          echo "<button type='button' class='close' data-dismiss='alert'>&times;</button>";
                          echo "<strong>Error!</strong> Se hizo la anulación, pero no se pudo proceder con la solucitud en la base de datos, por favor intente de nuevo.</div>";
                        } else {
                          echo "<div class='alert alert-success alert-dismissible'>";
                          echo "<button type='button' class='close' data-dismiss='alert'>&times;</button>";
                          echo "<strong>Mensaje:</strong> Se ha realizado la anulación del Direccionamiento " . $_POST['IDDIRECCIONAMIENTO'] . "</div>";
                          $sql2 = "UPDATE [dbo].[MIPRES_DIRECCIONAMIENTOS] SET [EstDireccionamiento] = '0',[FecAnulacion] = CURRENT_TIMESTAMP WHERE [IDDireccionamiento] = '" . $_POST['IDDIRECCIONAMIENTO'] . "'; ";
                          sql($conn, $sql2);
                          //Enviar sin recortar el cero
                          $clave = "(Codigo: " . $_POST['CD_SERVICIO'] . ", ID: " . $_POST['IDENTIFICADOR'] . ", IDDireccionamiento: " . $_POST['IDDIRECCIONAMIENTO'] . ")";
                          $clave_cortada = str_replace($clave, "", $_POST['OBSERVACIONES']);
                          $sql3 = "UPDATE AUTORIZACION SET OBSERVACIONES = '" . $clave_cortada . "' WHERE NO_SOLICITUD = '" . $_POST['NO_SOLICITUD'] . "' ";
                          sql($conn, $sql3);
                          //Enviar recortando el cero
                          $cod_servicio = cd_medicamento1($TABLA, $CD_SERVICIO);
                          $clave1 = "(Codigo: " . $cod_servicio . ", ID: " . $_POST['IDENTIFICADOR'] . ", IDDireccionamiento: " . $_POST['IDDIRECCIONAMIENTO'] . ")";
                          $clave_cortada1 = str_replace($clave1, "", $_POST['OBSERVACIONES']);
                          $sql4 = "UPDATE AUTORIZACION SET OBSERVACIONES = '" . $clave_cortada1 . "' WHERE NO_SOLICITUD = '" . $_POST['NO_SOLICITUD'] . "' ";
                          sql($conn, $sql4);
                        }
                          sqlsrv_free_stmt($stmt);
                          break;
                        }
                      ?>
                      <div class="form-row" >
                        <div class="col-md-12 sm-12">
                            <label>Resultado MIPRES:</label>
                        </div>
                      </div>
                      <div class="form-row" >
                        <div class="col-md-12 sm-12">
                          <textarea id="resultado_mipres" class="form-control"  rows="7" readonly></textarea>
                        </div>
                      </div>
                    <?php
                      $info = curl_getinfo($ch);
                      $mensaje_mipres = "Tiempo de ejecución de la consulta: " . $info['total_time'] . " ms, a solicitud de la IP: " . $info['local_ip'] . " codigo de respuesta: " . $http_code . " resultado de la transacción: " . $result;
                    ?>
                    <script type="text/javascript">
                      document.getElementById("resultado_mipres").value = '<?php echo $mensaje_mipres ?>';
                      document.getElementById('ProcesoDireccionamiento').innerHTML = "";
                    </script>
                    <?php
                    }
                    curl_close($ch);
                      break;
                    }
                  }
                }
               ?>
            </div>
          </div>
        </div>
     </div>
   </div>
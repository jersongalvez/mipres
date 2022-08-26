<?php
require_once('modelo/conexion-sql.php');
  if (/* (!empty($_POST['NO_SOLICITUD'])) and */ (!empty($_POST['TABLA'])) and (!empty($_POST['CD_SERVICIO'])) and (!empty($_POST['IDNODireccionamiento'])) and (!empty($_POST['REGIMEN'])) and (!empty($_POST['TipoIDPaciente'])) and (!empty($_POST['NoIDPaciente']))) {
    //$NO_SOLICITUD = $_POST['NO_SOLICITUD'];
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
            href="index.php?x=021"
          > <center>Anular No Direccionamiento</center>
          </a>
        </div>
      </div>
      <div class="col-md-9 sm-12">
        <div class="tab-content" id="v-pills-tabContent">
          <div class="card shadow">
            <div class="card-header">
              <h4> Anular No Direccionamiento</h4>
            </div>
          <div class="card-body">
            <div id="ProcesoDireccionamiento"><center><div class='spinner-border text-success'></div></center></div>
            <?php
              if (isset($_GET["x"])) {
                switch ($_GET["x"]) {
                  case '023':
                require_once("services/PUT-api-AnularNoDireccionamiento-nit-token.php");
                if (!curl_errno($ch)) {
                  switch ($http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE)) {
                    case 200:  # OK
                      $sql = "UPDATE MIPRES_NO_DIRECCIONAMIENTOS SET EstNODireccionamiento = '0', FecAnulacion = CURRENT_TIMESTAMP WHERE IDNODireccionamiento = '" . $_POST['IDNODireccionamiento'] . "'; ";
                      $params = array();
                      $options = array("Scrollable" => SQLSRV_CURSOR_KEYSET);
                      $stmt = sqlsrv_query($conn, $sql, $params, $options);
                      if ($stmt === FALSE) {
                        echo "<div class='alert alert-danger alert-dismissible'>";
                        echo "<button type='button' class='close' data-dismiss='alert'>&times;</button>";
                        echo "<strong>Error!</strong> Se hizo la anulaci�n, pero no se pudo proceder con la solucitud en la base de datos, por favor intente de nuevo.</div>";
                      } else {
                        echo "<div class='alert alert-success alert-dismissible'>";
                        echo "<button type='button' class='close' data-dismiss='alert'>&times;</button>";
                        echo "<strong>Mensaje:</strong> Se ha realizado la anulaci�n del No Direccionamiento " . $_POST['IDNODireccionamiento'] . "</div>";
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
                        $mensaje_mipres = "Tiempo de ejecución de la consulta: " . $info['total_time'] . " ms, a solicitud de la IP: " . $info['local_ip'] . " codigo de respuesta: " . $http_code . " resultado de la transacci�n: " . $result;
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
                    } else {
                      echo "<div class='card-body'>";
                      echo "<div class='alert alert-danger alert-dismissible'>";
                      echo "<button type='button' class='close' data-dismiss='alert'>&times;</button>";
                      echo "<strong>Error!</strong> No se puede completar la solucitud por datos incompletos, por favor solicite ayuda.</div>";
                      echo "</div>";
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>

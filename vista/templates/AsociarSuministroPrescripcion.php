<br>
<?php
require_once('../../modelo/conexion-sql.php');
$NoPrescripcion = $_POST['NoPrescripcion'];
if (!empty($NoPrescripcion)) {
  $sql = "SELECT S.*, A.NUM_COMITECTC, A.FEC_AUTORIZACION FROM SERVICIOS_AUTORIZADOS S
  LEFT JOIN AUTORIZACION A ON  A.NO_SOLICITUD = S.NO_SOLICITUD
  WHERE A.NUM_COMITECTC = '" . $NoPrescripcion . "' ORDER BY NO_SOLICITUD ASC ";
  $stmt2 = sqlsrv_query($conn, $sql, array());
    if ($stmt2 !== NULL) {
      $rows2 = sqlsrv_has_rows($stmt2);
    if ($rows2 === true) {
?>
  <div class="table-responsive">
    <table class="table table-sm ">
      <thead class="thead-light">
        <tr>
          <th>FECHA</th>
          <th>NO SOLUCITUD</th>
          <th>PRESCRIPCION</th>
          <th>CODIGO</th>
          <th>SERVICIO</th>
          <th></th>
        </tr>
      </thead>
      <tbody>
      <?php
        while ($row2 = sqlsrv_fetch_array($stmt2, SQLSRV_FETCH_ASSOC)) {
      ?>
        <tr>
          <td><?php  echo $row2["FEC_AUTORIZACION"]->format('d/m/Y'); ?></td>
          <td><?php  echo $row2["NO_SOLICITUD"]; ?></td>
          <td><?php  echo $row2["NUM_COMITECTC"]; ?></td>
          <td><?php  echo $row2["CD_SERVICIO"]; ?></td>
          <td><?php  echo $row2["OBSERVACION"]; ?></td>
          <td>
            <button
              class="btn btn-outline-danger btn-sm"
              type="button"
              id="BtnAsociar"
              onclick="javascript:AsociarSuministros('<?php echo $row2['NO_SOLICITUD']; ?>', '<?php echo $row2['TABLA']; ?>', '<?php echo $row2['CD_SERVICIO']; ?>');">
              Asociar
            </button>
          </td>
        </tr>
      <?php
        }
      ?>
      </tbody>
    </table>
  </div>
  <?php
  } else {
    echo "<br>\nNo se encuentran reportes de entrega del proveedor, por favor actualizar  \n<br><br>";
  }
 }
}
?>
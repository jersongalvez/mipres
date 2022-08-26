<?php
require_once('../../modelo/conexion-sql.php');
header("Content-Type: text/html; charset=iso-8859-1");
  if (!empty($_POST['NUM_COMITECTC'])) {
    $NUM_COMITECTC = $_POST['NUM_COMITECTC'];
    $NO_SOLICITUD = $_POST['NO_SOLICITUD'];
    $TABLA = $_POST['TABLA'];
    $CD_SERVICIO = $_POST['CD_SERVICIO'];
    //echo $NUM_COMITECTC;
    $sql = "SELECT 'M' AS TIPOTEC, M.CONORDEN, 'MEDICAMENTO' AS TIPO, M.DESCMEDPRINACT AS NOMBRE, (SELECT CD_SERVICIO FROM  SERVICIOS_AUTORIZADOS WHERE NO_SOLICITUD = '" . $NO_SOLICITUD . "' AND TABLA = '" . $TABLA . "' AND CD_SERVICIO = '" . $CD_SERVICIO . "') AS COD_MIPRES FROM MIPRES_MEDICAMENTOS AS M WHERE M.NOPRESCRIPCION = '" . $NUM_COMITECTC . "' UNION
    SELECT 'P' AS TIPOTEC, P.CONORDEN, 'PROCEDIMIENTO' AS TIPO, (SELECT TOP 1 DESCRIPCION FROM PROCEDIMIENTOS WHERE EST_PROCEDIMIENTO = '0' AND CODIGO = P.CODCUPS) AS NOMBRE, (SELECT CD_SERVICIO FROM  SERVICIOS_AUTORIZADOS WHERE NO_SOLICITUD = '" . $NO_SOLICITUD . "' AND TABLA = '" . $TABLA . "' AND CD_SERVICIO = '" . $CD_SERVICIO . "')  AS COD_MIPRES  FROM MIPRES_PROCEDIMIENTOS AS P WHERE NOPRESCRIPCION = '" . $NUM_COMITECTC . "' UNION
    SELECT 'D' AS TIPOTEC, D.CONORDEN, 'DISPOSITIVO MEDICO' AS TIPO, (SELECT TOP 1 MVP_DESCRIPCION FROM MIPRES_VALORES_PERMITIDOS WHERE  MVP_ITEM = 'DISPOSITIVOS' AND MVP_VARIABLE = 'CODDISP' AND MVP_VALOR = D.CODDISP) AS NOMBRE, D.CODDISP AS COD_MIPRES  FROM MIPRES_DISPOSITIVOS AS D WHERE NOPRESCRIPCION = '" . $NUM_COMITECTC . "' UNION
    SELECT 'N' AS TIPOTEC, N.CONORDEN, 'PRODUCTO NUTRICIONAL' AS TIPO, (SELECT TOP 1 MVP_DESCRIPCION FROM MIPRES_VALORES_PERMITIDOS WHERE  MVP_ITEM = 'NATURALES' AND MVP_VARIABLE = 'DESCPRODNUTR' AND MVP_VALOR = N.DESCPRODNUTR) AS NOMBRE, CONVERT(VARCHAR, N.DESCPRODNUTR) AS COD_MIPRES  FROM MIPRES_NUTRICIONALES AS N WHERE NOPRESCRIPCION = '" . $NUM_COMITECTC . "' UNION
    SELECT 'S' AS TIPOTEC, S.CONORDEN, 'SERVICIO COMPLEMENTARIO' AS TIPO, (SELECT TOP 1 MVP_DESCRIPCION FROM MIPRES_VALORES_PERMITIDOS WHERE  MVP_ITEM = 'COMPLEMENTARIOS' AND MVP_VARIABLE = 'CODSERCOMP' AND MVP_VALOR = S.CODSERCOMP) AS NOMBRE, CONVERT(VARCHAR, S.CODSERCOMP) AS COD_MIPRES  FROM MIPRES_COMPLEMENTARIOS AS S WHERE NOPRESCRIPCION = '" . $NUM_COMITECTC . "' ";
    $params = array();
    $options = array("Scrollable" => SQLSRV_CURSOR_KEYSET);
    $stmt = sqlsrv_query($conn, $sql, $params, $options);
    $row_count = sqlsrv_num_rows($stmt);
    if ($row_count == 0) {
      echo "<div class='alert alert-warning alert-dismissible'>";
      echo "<button type='button' class='close' data-dismiss='alert'>&times;</button>";
      echo "<strong>Alerta!</strong> No se encuentran resultados segun el filtro diligenciado.</div>";
    } else {
?>
    <div class="table-responsive" id="tabla_autorizaciones">
      <table class="table table-hover table-sm">
        <thead class="thead-active">
          <tr>
            <th><small><strong>TIPO DEL SERVICIO</strong></small></th>
            <th><small><strong>NOMBRE DEL SERVICIO</strong></small></th>
            <th><small><strong>COD. MIPRES</strong></small></th>
            <th><small><strong></strong></small></th>
            <th></th>
          </tr>
        </thead>
        <tbody>
          <?php
            while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
          ?>
          <tr>
            <td><small><?php echo $row['TIPO']; ?></small></td>
            <td><small><?php echo $row['NOMBRE']; ?></small></td>
            <td><small><?php echo cd_medicamento1(substr($row['TIPO'], 0, 3), $row['COD_MIPRES']); ?></small></td>
            <td>
              <button
                class="btn btn-outline-dark btn-block"
                type="submit"
                onclick="javascript:Relacionar('<?php echo $row['TIPOTEC']; ?>', '<?php echo $row['CONORDEN']; ?>', '<?php echo cd_medicamento1(substr($row['TIPO'], 0, 3), $row['COD_MIPRES']); ?>');">
                Relacionar
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
    }
    sqlsrv_free_stmt($stmt);
    } else {
      echo "<div class='alert alert-danger alert-dismissible'>";
      echo "<button type='button' class='close' data-dismiss='alert'>&times;</button>";
      echo "<strong>Alerta!</strong> Debe de diligenciar todos los campos</div>";
    }
?>
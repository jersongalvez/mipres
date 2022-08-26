<?php
require_once('../../modelo/conexion-sql.php');
header("Content-Type: text/html; charset=iso-8859-1");
if (!empty($_POST['NOPRESCRIPCION']) AND!empty($_POST['TI']) AND!empty($_POST['NI'])) {
    $NOPRESCRIPCION = $_POST['NOPRESCRIPCION'];
    $TI = $_POST['TI'];
    $NI = $_POST['NI'];

//echo $NUM_COMITECTC;
$sql = "SELECT 'M' AS TIPOTEC, M.CONORDEN, 'MEDICAMENTO' AS TIPO, M.DESCMEDPRINACT AS NOMBRE  FROM MIPRES_MEDICAMENTOS AS M WHERE M.NOPRESCRIPCION = '" . $NOPRESCRIPCION . "' UNION 
SELECT 'P' AS TIPOTEC, P.CONORDEN, 'PROCEDIMIENTO' AS TIPO, (SELECT TOP 1 DESCRIPCION FROM PROCEDIMIENTOS WHERE EST_PROCEDIMIENTO = '0' AND CODIGO = P.CODCUPS) AS NOMBRE  FROM MIPRES_PROCEDIMIENTOS AS P WHERE NOPRESCRIPCION = '" . $NOPRESCRIPCION . "' UNION 
SELECT 'D' AS TIPOTEC, D.CONORDEN, 'DISPOSITIVO MEDICO' AS TIPO, (SELECT TOP 1 MVP_DESCRIPCION FROM MIPRES_VALORES_PERMITIDOS WHERE  MVP_ITEM = 'DISPOSITIVOS' AND MVP_VARIABLE = 'CODDISP' AND MVP_VALOR = D.CODDISP) AS NOMBRE  FROM MIPRES_DISPOSITIVOS AS D WHERE NOPRESCRIPCION = '" . $NOPRESCRIPCION . "' UNION 
SELECT 'N' AS TIPOTEC, N.CONORDEN, 'PRODUCTO NUTRICIONAL' AS TIPO, (SELECT TOP 1 MVP_DESCRIPCION FROM MIPRES_VALORES_PERMITIDOS WHERE  MVP_ITEM = 'NATURALES' AND MVP_VARIABLE = 'DESCPRODNUTR' AND MVP_VALOR = N.DESCPRODNUTR) AS NOMBRE FROM MIPRES_NUTRICIONALES AS N WHERE NOPRESCRIPCION = '" . $NOPRESCRIPCION . "' UNION 
SELECT 'S' AS TIPOTEC, S.CONORDEN, 'SERVICIO COMPLEMENTARIO' AS TIPO, (SELECT TOP 1 MVP_DESCRIPCION FROM MIPRES_VALORES_PERMITIDOS WHERE  MVP_ITEM = 'COMPLEMENTARIOS' AND MVP_VARIABLE = 'CODSERCOMP' AND MVP_VALOR = S.CODSERCOMP) AS NOMBRE  FROM MIPRES_COMPLEMENTARIOS AS S WHERE NOPRESCRIPCION = '" . $NOPRESCRIPCION . "' ";

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
                            <td>
                                <form class="" action="index.php?x=017" method="post" >
                                    <input type="hidden" class="form-control" id="TIPOTEC" name="TIPOTEC" value="<?php echo $row['TIPOTEC']; ?>">
                                    <input type="hidden" class="form-control" id="CONORDEN" name="CONORDEN" value="<?php echo $row['CONORDEN']; ?>">
                                    <input type="hidden" class="form-control" id="NOPRESCRIPCION" name="NOPRESCRIPCION" value="<?php echo $NOPRESCRIPCION; ?>">
                                    <input type="hidden" class="form-control" id="TI" name="TI" value="<?php echo $TI; ?>">
                                    <input type="hidden" class="form-control" id="NI" name="NI" value="<?php echo $NI; ?>">
                                    <button class="btn btn-outline-dark btn-block" type="submit">Ir</button>
                                </form>
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

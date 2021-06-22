<?php
require_once('../../modelo/conexion-sql.php');
header("Content-Type: text/html; charset=iso-8859-1");
if ((!empty($_POST['var_TI'])) and (!empty($_POST['var_NI']))) {
    $var_TI = $_POST['var_TI'];
    $var_NI = $_POST['var_NI'];
//echo $var_TI;
//echo $var_NI;


    $sql = "SELECT * FROM MIPRES_NO_DIRECCIONAMIENTOS  AS NP INNER JOIN MIPRES_PRESCRIPCION AS PR ON NP.NoPrescripcion =  PR.NoPrescripcion WHERE  PR.TIPOIDPACIENTE = '" . $var_TI . "' AND PR.NROIDPACIENTE = '" . $var_NI . "' AND EstNODireccionamiento <> 0 ";
    $params = array();
    $options = array("Scrollable" => SQLSRV_CURSOR_KEYSET);
    $stmt = sqlsrv_query($conn, $sql, $params, $options);
    $row_count = sqlsrv_num_rows($stmt);
    if ($row_count == 0) {
        echo "<div class='alert alert-warning alert-dismissible'>";
        echo "<button type='button' class='close' data-dismiss='alert'>&times;</button>";
        echo "<strong>Alerta!</strong> No se encuentran resultados.</div>";
    } else {
        ?>
        <div class="table-responsive" id="tabla_autorizaciones">
            <table class="table table-hover table-sm">
                <thead class="thead-active">
                    <tr>
                        <th><small><strong>Fecha</strong></small></th>
                        <th><small><strong>Prescripcion</strong></small></th>
                        <th><small><strong>Tipo Tec</strong></small></th>
                        <th><small><strong>Orden</strong></small></th>
                        <th><small><strong>ID No Direccionamiento</strong></small></th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
                        ?>
                        <tr>
                            <td><small><?php echo $row['FecNODireccionamiento']->format('d/m/Y'); ?></small></td>
                            <td><small><?php echo $row['NoPrescripcion']; ?></small></td>
                            <td><small><?php echo TipoTec($row['TipoTec']); ?></small></td>
                            <td><small><?php echo $row['ConTec']; ?></small></td>
                            <td><small><?php echo $row['IDNODireccionamiento']; ?></small></td>					        
                            <td>
                                <form class="" action="index.php?x=022" method="post" >
                                    <!-- <input type="hidden" class="form-control" id="NO_SOLICITUD" name="NO_SOLICITUD" value="<?php //echo $row['NO_SOLICITUD']; ?>">-->
                                    <input type="hidden" class="form-control" id="TABLA" name="TABLA" value="<?php echo $row['TipoTec']; ?>">
                                    <input type="hidden" class="form-control" id="CD_SERVICIO" name="CD_SERVICIO" value="<?php echo $row['ConTec']; ?>">
                                    <input type="hidden" class="form-control" id="IDNODireccionamiento" name="IDNODireccionamiento" value="<?php echo $row['IDNODireccionamiento']; ?>">
                                    <input type="hidden" class="form-control" id="REGIMEN" name="REGIMEN" value="<?php
                                    if ($row['CODEPS'] == 'EPSI06') {
                                        echo 'S';
                                    } else
                                    if ($row['CODEPS'] == 'EPSIC6') {
                                        echo 'C';
                                    }
                                    ?>">

                                    <input type="hidden" class="form-control" id="TipoIDPaciente" name="TipoIDPaciente" value="<?php echo $row['TipoIDPaciente']; ?>">
                                    <input type="hidden" class="form-control" id="NoIDPaciente" name="NoIDPaciente" value="<?php echo $row['NoIDPaciente']; ?>">

                                    <button class="btn btn-outline-success btn-block" type="submit">Ir</button>  
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

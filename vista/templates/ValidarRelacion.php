<?php
require_once('../../modelo/conexion-sql.php');
$NO_SOLICITUD=$_POST['NO_SOLICITUD'];
$TABLA=$_POST['TABLA'];
$CD_SERVICIO=$_POST['CD_SERVICIO'];
$TIPOTEC=$_POST['TipoTec'];
$CONTEC=$_POST['ConTec'];
$CODSERTEC=$_POST['CODSERTEC'];

$sql = "UPDATE SERVICIOS_AUTORIZADOS SET TIPOTEC = ?, CONTEC = ?, CODSERTEC = ? WHERE NO_SOLICITUD = '".$NO_SOLICITUD."' AND TABLA = '".$TABLA."' AND CD_SERVICIO = '".$CD_SERVICIO."'; ";
$params = array($TIPOTEC, $CONTEC, $CODSERTEC);
$options =  array( "Scrollable" => SQLSRV_CURSOR_KEYSET );
$stmt = sqlsrv_query( $conn, $sql, $params, $options);
if($stmt === FALSE) {
echo "<div class='alert alert-danger alert-dismissible'>";
echo "<button type='button' class='close' data-dismiss='alert'>&times;</button>";
echo "<strong>Error!</strong> No se pudo proceder con la solucitud, por favor intente de nuevo.</div>";
}else
{
?>
<script type="text/javascript">
document.getElementById('ValidarRelacion').innerHTML = "";	
</script>
<?php
}
sqlsrv_free_stmt($stmt);
?>


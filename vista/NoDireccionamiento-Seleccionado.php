<?php
require_once('modelo/conexion-sql.php');


if ((!empty($_POST['TIPOTEC'])) and (!empty($_POST['CONORDEN'])) and (!empty($_POST['NOPRESCRIPCION'])) and (!empty($_POST['TI'])) and (!empty($_POST['NI']))){
$TIPOTEC=$_POST['TIPOTEC'];
$CONORDEN=$_POST['CONORDEN'];
$NOPRESCRIPCION=$_POST['NOPRESCRIPCION'];
$TI=$_POST['TI'];
$NI=$_POST['NI'];


switch ($TIPOTEC) {
    case 'M':
         $sql = "SELECT (SELECT IIF(CODEPS='EPSI06','S',IIF(CODEPS='EPSIC6','C',NULL)) FROM MIPRES_PRESCRIPCION WHERE NOPRESCRIPCION = '".$NOPRESCRIPCION."') AS REGIMEN, * FROM MIPRES_CAUSAS_NO_ENTREGA WHERE TIPO = 'NODIRECCIONAMIENTO' AND MEDICAMENTOS = '0' ORDER BY DESCRIPCION ASC ";
        break;
    case 'P':
        $sql = "SELECT (SELECT IIF(CODEPS='EPSI06','S',IIF(CODEPS='EPSIC6','C',NULL)) FROM MIPRES_PRESCRIPCION WHERE NOPRESCRIPCION = '".$NOPRESCRIPCION."') AS REGIMEN, * FROM MIPRES_CAUSAS_NO_ENTREGA WHERE TIPO = 'NODIRECCIONAMIENTO' AND PROCEDIMIENTOS = '0' ORDER BY DESCRIPCION ASC";
        break;
    case 'D':
        $sql = "SELECT (SELECT IIF(CODEPS='EPSI06','S',IIF(CODEPS='EPSIC6','C',NULL)) FROM MIPRES_PRESCRIPCION WHERE NOPRESCRIPCION = '".$NOPRESCRIPCION."') AS REGIMEN, * FROM MIPRES_CAUSAS_NO_ENTREGA WHERE TIPO = 'NODIRECCIONAMIENTO' AND DISPOSITIVOS = '0' ORDER BY DESCRIPCION ASC";
        break;
    case 'N':
        $sql = "SELECT (SELECT IIF(CODEPS='EPSI06','S',IIF(CODEPS='EPSIC6','C',NULL)) FROM MIPRES_PRESCRIPCION WHERE NOPRESCRIPCION = '".$NOPRESCRIPCION."') AS REGIMEN, * FROM MIPRES_CAUSAS_NO_ENTREGA WHERE TIPO = 'NODIRECCIONAMIENTO' AND NUTRICIONALES = '0' ORDER BY DESCRIPCION ASC";
        break;
    case 'S':
        $sql = "SELECT (SELECT IIF(CODEPS='EPSI06','S',IIF(CODEPS='EPSIC6','C',NULL)) FROM MIPRES_PRESCRIPCION WHERE NOPRESCRIPCION = '".$NOPRESCRIPCION."') AS REGIMEN, * FROM MIPRES_CAUSAS_NO_ENTREGA WHERE TIPO = 'NODIRECCIONAMIENTO' AND COMPLEMENTARIOS = '0' ORDER BY DESCRIPCION ASC";
        break;
}
    $params = array();
    $options =  array( "Scrollable" => SQLSRV_CURSOR_KEYSET );
    $stmt = sqlsrv_query( $conn, $sql, $params, $options);
    $row_count = sqlsrv_num_rows( $stmt );
    $row_dos = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC);

?>
<div class="row">
  <div class="col-md-3 sm-12">
    <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
      <a class="btn btn-outline-dark btn-block" id="v-pills-profile-tab" href="index.php?x=013&y=001&TI=<?php echo $TI; ?>&NI=<?php echo $NI; ?>"><center>Regresar</center></a>
    </div>
  </div>

  <div class="col-md-9 sm-12">
  <div class="tab-content" id="v-pills-tabContent">

<div class="card shasow">
  <div class="card-header">
    <H4>
    No Direccionamiento
  </H4>
  </div>
  <div class="card-body">

<form class="" action="index.php?x=020" method="post" >
<div class="form-row">
<div class="col-md-4 sm-12">
<label>Prescripción</label>
</div>
<div class="col-md-8 sm-12">
<input type="number" class="form-control" id="NoPrescripcion" name="NoPrescripcion" required readonly value="<?php echo $NOPRESCRIPCION; ?>">
</div>
</div>
<div class="form-row">
<div class="col-md-4 sm-12">
<label>Servicio o Tecnología</label>
</div>
<div class="col-md-8 sm-12">
<input type="text" class="form-control" id="TipoTec" name="TipoTec" required readonly value="<?php echo $TIPOTEC; ?>">
</div>
</div>
<div class="form-row">
<div class="col-md-4 sm-12">
<label>Consecutivo Orden</label>
</div>
<div class="col-md-8 sm-12">
<input type="number" class="form-control" id="ConTec" name="ConTec" required readonly value="<?php echo $CONORDEN; ?>">
</div>
</div>
<div class="form-row">
<div class="col-md-4 sm-12">
<label>Tipo de Documento</label>
</div>
<div class="col-md-8 sm-12">

<?php $nacidovivo = $TI == "CN" ? 'NV' : $TI; ?>

<input type="text" class="form-control" id="TipoIDPaciente" name="TipoIDPaciente" required readonly value="<?php echo $nacidovivo; ?>">
</div>
</div>
<div class="form-row">
<div class="col-md-4 sm-12">
<label>Nro. de Documento</label>
</div>
<div class="col-md-8 sm-12">
<input type="text" class="form-control" id="NoIDPaciente" name="NoIDPaciente" required readonly value="<?php echo $NI; ?>">
</div>
</div>
<div class="form-row">
<div class="col-md-4 sm-12">
<label>Causas de no entrega</label>
</div>
<div class="col-md-8 sm-12">
      <select class="form-control" id="CausaNoEntrega" name="CausaNoEntrega" required>
        <option></option>
        <?php
while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) )
{
echo "<option value= '".$row['COD_CAUSA']."'>".utf8_encode ($row['DESCRIPCION'])."</option>";
}
        ?>
      </select>
</div>
</div>
<div class="form-row">
<div class="col-md-4 sm-12">
<label>Número Prescripción asociada</label>
</div>
<div class="col-md-8 sm-12">
<input type="number" class="form-control" id="NoPrescripcionAsociada" name="NoPrescripcionAsociada">
</div>
</div>
<div class="form-row">
<div class="col-md-4 sm-12">
<label>Consecutivo Orden servicio o tecnología asociada</label>
</div>
<div class="col-md-8 sm-12">
<input type="number" class="form-control" id="ConTecAsociada" name="ConTecAsociada">
</div>
</div>
<input type="hidden" class="form-control" id="REGIMEN" name="REGIMEN"  value="<?php echo $row_dos['REGIMEN']; ?>">
<?php
$sql2 = "SELECT * FROM MIPRES_NO_DIRECCIONAMIENTOS WHERE NoPrescripcion = '".$NOPRESCRIPCION."' AND TipoTec = '".$TIPOTEC."' AND ConTec = '".$CONORDEN."' AND (FecAnulacion IS NULL OR FecAnulacion = '')";
    $params2 = array();
    $options2 =  array( "Scrollable" => SQLSRV_CURSOR_KEYSET );
    $stmt2 = sqlsrv_query( $conn, $sql2, $params2, $options2);
    $row_count2 = sqlsrv_num_rows( $stmt2 );
    $row_dos2 = sqlsrv_fetch_array( $stmt2, SQLSRV_FETCH_ASSOC);
    if ($row_count2 == 1
    ){
?>
<div class="row">
    <div class="col-md-12 sm-12">
      <div class="card">
        <div class="card-body">
              <div class="form-row">
          <div class="col-md-4 sm-12">
          <label>Identificador</label>
          </div>
          <div class="col-md-8 sm-12">
          <input type="number" class="form-control" id="Id" name="Id" required readonly value="<?php echo $row_dos2['ID']; ?>">
          </div>
          </div>
          <div class="form-row">
          <div class="col-md-4 sm-12">
          <label>Id No Direccionamiento</label>
          </div>
          <div class="col-md-8 sm-12">
          <input type="number" class="form-control" id="IdDireccionamiento" name="IdDireccionamiento" required readonly value="<?php echo $row_dos2['IDNODireccionamiento']; ?>"> 
          </div>
          </div>
          <div class="form-row">
          <div class="col-md-12 sm-12">
          <small id="usu"><?php echo $row_dos2['USUARIO_NO_DIRECCIONAMIENTO'] ?></small>
                    <small id="fec"><?php echo $row_dos2['FECHA_NO_DIRECCIONAMIENTO']->format('d/m/Y'); ?></small>
          </div>
          </div>
        </div>
      </div>
    </div>
  </div>
<?php
}else
{
?>
<button class='btn btn-outline-dark btn-block' type='submit'>Generar No Direccionamiento</button>
<?php
}
?>
</form>
<!---  Fin Body --->
  </div>
</div>
    </div>
  </div>
</div>
<?php
}else{
echo "<div class='alert alert-danger alert-dismissible'>";
echo "<button type='button' class='close' data-dismiss='alert'>&times;</button>";
echo "<strong>Alerta!</strong> Ha ocurrido un error, por favor intentelo nuevamente.</div>";
}
?>
  <!-- The Modal -->
  <div class="modal fade" data-backdrop="static" id="Ven_Direccionamiento">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <!-- Modal Header -->
        <div class="modal-header">
          <h5 class="modal-title">Servicios solicitados en <?php echo $row['NUM_COMITECTC']; ?></h5>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <!-- Modal body -->
        <div class="modal-body">
		<div id="DataDireccionamiento"></div>
        </div>
        <!-- Modal footer -->
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
        </div>
      </div>
    </div>
  </div>
<script type="text/javascript">

function ServiciosSolicitados(){
document.getElementById('DataDireccionamiento').innerHTML = "<center><div class='spinner-border text-success'></div></center>";
$('#Ven_Direccionamiento').modal('show');
var NUM_COMITECTC = document.getElementById("NoPrescripcion").value;
var NO_SOLICITUD = "<?php echo $NO_SOLICITUD ?>";
var TABLA = "<?php echo $TABLA ?>";
var CD_SERVICIO = "<?php echo $CD_SERVICIO ?>";
$.post("vista/templates/ServiciosSolicitados.php", {NUM_COMITECTC: NUM_COMITECTC, NO_SOLICITUD:NO_SOLICITUD, TABLA:TABLA, CD_SERVICIO:CD_SERVICIO}, function(data){
$("#DataDireccionamiento").html(data);
});
}

</script>


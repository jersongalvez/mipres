<?php
 $TIPOTEC=$_POST['TipoTec'];
 $CONORDEN=$_POST['ConTec'];
 $NOPRESCRIPCION=$_POST['NoPrescripcion'];
 $TI=$_POST['TipoIDPaciente'];
 $NI=$_POST['NoIDPaciente'];
 $CausaNoEntrega=$_POST['CausaNoEntrega'];
 $REGIMEN=$_POST['REGIMEN'];
 $NoPrescripcionAsociada=$_POST['NoPrescripcionAsociada'];
 $ConTecAsociada=$_POST['ConTecAsociada'];
?>
<div class="row">
  <div class="col-md-3 sm-12">
    <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
      <a class="btn btn-light" id="v-pills-profile-tab" href="index.php?x=013"><center>No Direccionamiento</center></a>
    </div>
  </div>
  <div class="col-md-9 sm-12">
    <div class="tab-content" id="v-pills-tabContent">
      <div class="card shadow">
        <div class="card-header">
          <h4>
            No Direccionamiento
          </h4>
        </div>
        <div class="card-body">
          <div id="ProcesoDireccionamiento"><center><div class='spinner-border text-success'></div></center></div>
<?php
require_once('modelo/conexion-sql.php');
  if ( (!empty($_POST['TipoTec'])) and (!empty($_POST['ConTec'])) and (!empty($_POST['NoPrescripcion'])) and (!empty($_POST['TipoIDPaciente'])) and (!empty($_POST['NoIDPaciente'])) and (!empty($_POST['CausaNoEntrega'])) and (!empty($_POST['REGIMEN'])) ){
  if (isset($_GET["x"])) {
    switch ($_GET["x"]) {
      case '020':
        require_once("services/PUT-api-NoDireccionamiento-nit-token.php");
          if (!curl_errno($ch)) {
            switch ($http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE)) {
            case 200:  # OK
   $sql = "INSERT INTO [dbo].[MIPRES_NO_DIRECCIONAMIENTOS]([ID],[IDNODireccionamiento],[NoPrescripcion],[TipoTec],[ConTec],[TipoIDPaciente],[NoIDPaciente],[USUARIO_NO_DIRECCIONAMIENTO],[FECHA_NO_DIRECCIONAMIENTO]) VALUES (?,?,?,?,?,?,?,?,CURRENT_TIMESTAMP)";

   $registro = $result;
   $registro = json_decode($registro, true);
   $Id = $registro[0]["Id"];
   $IdNoDireccionamiento = $registro[0]["IdNoDireccionamiento"];
   $params = array($Id, $IdNoDireccionamiento,$_POST['NoPrescripcion'],$_POST['TipoTec'],$_POST['ConTec'], $_POST['TipoIDPaciente'], $_POST['NoIDPaciente'], $_SESSION["usuario"]);
   $options =  array( "Scrollable" => SQLSRV_CURSOR_KEYSET );
   $stmt = sqlsrv_query( $conn, $sql, $params, $options);
   if($stmt === FALSE) {
     echo "<div class='alert alert-danger alert-dismissible'>";
     echo "<button type='button' class='close' data-dismiss='alert'>&times;</button>";
     echo "<strong>Error!</strong> No se pudo proceder con la solucitud, por favor intente de nuevo.</div>";
   }else
   {
?>
<div class="row">
  <div class="col-md-12 sm-12">
    <div class="form-row">
      <div class="col-md-4 sm-12">
        <label>Id</label>
      </div>
      <div class="col-md-8 sm-12">
        <input type="number" class="form-control" id="Id" name="Id" required readonly value="<?php echo $Id ?>">
      </div>
    </div>
    <div class="form-row">
      <div class="col-md-4 sm-12">
        <label>Id No Direccionamiento</label>
      </div>
      <div class="col-md-8 sm-12">
        <input type="number" class="form-control" id="IdNoDireccionamiento" name="IdNoDireccionamiento" required readonly value="<?php echo $IdNoDireccionamiento ?>"> 
      </div>
    </div>
  </div>
</div>
<?php
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
  $mensaje_mipres = "Tiempo de ejecución de la consulta: ".$info['total_time']." ms, a solicitud de la IP: ".$info['local_ip']." codigo de respuesta: ".$http_code.", resultado de la transacción: ".$result;
?>
<script type="text/javascript">
  document.getElementById("resultado_mipres").value='<?php echo $mensaje_mipres ?>';
  document.getElementById('ProcesoDireccionamiento').innerHTML = "";
</script>
<?php
}
curl_close($ch);
  break;
  }
}
}else{
?>
<script type="text/javascript">
document.getElementById('ProcesoDireccionamiento').innerHTML = "";
</script>
<?php
echo "<div class='alert alert-warning alert-dismissible'>";
echo "<button type='button' class='close' data-dismiss='alert'>&times;</button>";
echo "<strong>Alerta!</strong> Existen campos vacíos, por favor intentelo nuevamente sin dejar campos vacíos</div>";
}
?>
<!---  fin body --->
        </div>
      </div>
    </div>
  </div>
</div>
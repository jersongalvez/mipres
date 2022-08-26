<?php
  require_once('modelo/conexion-sql.php');

function actualizar($conn){
  $sql = "SELECT *, CONVERT(VARCHAR(20),FEC_TEM_TOKEN,120) AS FEC_CONSULTA  FROM  PRS_TEM_TOKEN WHERE COD_TEM_TOKEN = '2';";
  $params = array();
  $options =  array( "Scrollable" => SQLSRV_CURSOR_KEYSET );
  $stmt = sqlsrv_query( $conn, $sql, $params, $options);
    if ($stmt === false){
      echo "<div class='alert alert-danger alert-dismissible'>";
      echo "<button type='button' class='close' data-dismiss='alert'>&times;</button>";
      echo "<strong>Error!</strong> No se ha logrado llamar los datos de ultimo token generado, error: ERROR0002</div>";
    }
    else{
      $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC);
?>
<script type="text/javascript">
  $(document).ready(function(){
    $("#token_con").val('<?php echo $row['DES_TEM_TOKEN']; ?>');
    document.getElementById('usu').innerHTML = '<?php echo $row['USU_TEM_TOKEN']; ?>';
    document.getElementById('fec').innerHTML = '<?php echo $row['FEC_CONSULTA']; ?>';
  });
</script>
<?php
  sqlsrv_free_stmt($stmt);
  }
}
actualizar($conn);
?>
<div class="row">
  <div class="col-md-3 sm-12">
    <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
      <a class="btn btn-outline-dark btn-block" id="v-pills-profile-tab" href="index.php"><center>Volver al Inicio</center></a>
    </div>
  </div>
  <div class="col-md-9 sm-12">
	  <div class="tab-content" id="v-pills-tabContent">
      <div class="card shadow">
        <div class="card-header">
          <h4>Token Temporal Subsidiado</H4>
        </div>
        <div class="card-body">
          <form class="" action="index.php?x=002&y=001" method="post" >
          <div class="input-group">
            <div class="input-group-prepend">
              <span class="input-group-text" id="basic-addon1">Token</span>
            </div>
              <input type="text" class="form-control" id="token_con" name="token_con" disabled>
          </div>
          <small id="usu"></small>
          <small id="fec"></small>
          <br>
          <br>
            <button class="btn btn-outline-dark btn-block" type="submit">Refrescar Token</button>  
          </form>
        </div>
      </div>
      <br>
      <div class="form-group">
        <center>
          <input type="hidden" id="mostrar" name="boton1" value="Respuesta servidor MIPRES" class="btn btn-info btn-block">  
        </center>
      </div>
      <br>
      <div class="form-group" id="target" style = 'display:none;'>
        <textarea id="resultado_mipres" class="form-control"  rows="6" disabled></textarea>
      </div>
  		<?php
      if (isset($_GET["y"])) {
      ?>
      <script type="text/javascript">
      document.getElementById('target').style.display = 'none';
      document.getElementById('target').value = '';
      </script>
      <?php

  if (isset($_GET["y"])) {
    switch ($_GET["y"]) {
      case '001':
        require_once("services/GET-api-GenerarToken-nit-token.php");
        if (!curl_errno($ch)) {
        switch ($http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE)) {
      case 200:  # OK
        $sql = "UPDATE PRS_TEM_TOKEN SET DES_TEM_TOKEN = ?, USU_TEM_TOKEN = ?, FEC_TEM_TOKEN = CURRENT_TIMESTAMP WHERE COD_TEM_TOKEN = '2';";
        $cadena = preg_replace('/"/', '', $result);
        $params = array($cadena, $_SESSION["usuario"]);
        $options =  array( "Scrollable" => SQLSRV_CURSOR_KEYSET );
        $stmt = sqlsrv_query( $conn, $sql, $params, $options);
        if($stmt === FALSE) {
          echo "<div class='alert alert-danger alert-dismissible'>";
          echo "<button type='button' class='close' data-dismiss='alert'>&times;</button>";
          echo "<strong>Error!</strong> No se actualizó el token en el servidor, por favor vuelva a intentarlo, si el error persiste, solicite soporte al administrador, error: ERROR0003</div>";
        }
        actualizar($conn);
        sqlsrv_free_stmt($stmt);
        break;
      default:
    ?>
    <script type="text/javascript">
      $('#target').show(500);
      $('.target').show("slow");
    </script>
    <?php
   }
       $info = curl_getinfo($ch);
       $mensaje_mipres = "Tiempo de ejecución de la consulta: ".$info['total_time']." a solicitud de la IP: ".$info['local_ip']." codigo de respuesta: ".$http_code." resultado de la transacción: ".$result;
    ?>
    <script type="text/javascript">
      document.getElementById("resultado_mipres").value='<?php echo $mensaje_mipres ?>';
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

<script type="text/javascript">
  $(document).ready(function(){
    $("#mostrar").click(function(){
      $('#target').toggle(500);
      $('.target').toggle("slow");
    });
  });
</script>
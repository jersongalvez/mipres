<style type="text/css">
#global {
  height: 300px;
  width: 100%;
  border: 1px solid #ddd;
  background: #f1f1f1;
  overflow-y: scroll;
}
#mensajes {
  height: auto;
}
.texto {
  padding:4px;
  background:#fff;
}
</style>
<div class="container-fluid" style="margin-top:80px">

<nav aria-label="breadcrumb">
  <ol class="breadcrumb">
    <li class="breadcrumb-item">Descargar</li>
    <li class="breadcrumb-item"><a  href="index.php?x=028">Junta Profesionales por Fecha</a></li>
  </ol>
</nav>


<div class="container">

<div class="row">
  <div class="col-md-3 sm-12">
    <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
      <a class="btn btn-light" id="v-pills-profile-tab" href="index.php?x=028"><center>Regresar</center></a>
    </div>
    <br>
    <center><div id="barra" class="spinner-border text-success" style = 'display:none;'></div></center>
  </div>
  <div class="col-md-9 sm-12">
  <div class="tab-content" id="v-pills-tabContent">

<div class="card ">
  <div class="card-header">
    <H4>Junta Profesionales por Fecha</H4>
  </div>
  <div class="card-body">      

<?php
set_time_limit(1000);
//ERROR0006
  if (!empty($_SESSION['NIT_EPS'])){   


     $sql = "SELECT * FROM PRS_URL_SERVICES WHERE COD_URL = '11' ";
    $params = array();
    $options =  array( "Scrollable" => SQLSRV_CURSOR_KEYSET );
    $stmt = sqlsrv_query( $conn, $sql, $params, $options);
    $row_count = sqlsrv_num_rows( $stmt );
      if ($row_count === false){
      echo "<div class='alert alert-danger alert-dismissible'>";
      echo "<button type='button' class='close' data-dismiss='alert'>&times;</button>";
      echo "<strong>Error!</strong> No se encuentra el recurso solicitado, error: ERROR0006</div>";
      }  
      else{
            while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC))  
            {  

        if ($_POST['var_regimen'] === 'S') {
        $url = $row['DES_URL'].$_SESSION['NIT_EPS'].'/'.$_SESSION['PRETOCKENSUB'].'/'.$_POST['var_fecha'];
        }
        elseif ($_POST['var_regimen'] === 'C') {
        $url = $row['DES_URL'].$_SESSION['NIT_EPS'].'/'.$_SESSION['PRETOCKEN'].'/'.$_POST['var_fecha'];
        }

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json; charset=utf-8'));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
        $result = curl_exec($ch);
            }  
          }
    sqlsrv_free_stmt($stmt); 
  }else{
      echo "<div class='alert alert-danger alert-dismissible'>";
      echo "<button type='button' class='close' data-dismiss='alert'>&times;</button>";
      echo "<strong>Error!</strong> No se ha logrado autenticar los datos de la compañia, error: ERROR0004</div>";
  }





if (!curl_errno($ch)) {
switch ($http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE)) {
        case 200:  # OK
        $tamaño_array = json_decode($result, true);
        $info = curl_getinfo($ch);
        if(count($tamaño_array)<>0){           
        $result = json_decode($result, true);
        ?>  
        <div class="list-group">
        <a class="list-group-item list-group-item-action list-group-item-info"><span class="badge badge-info badge-pill"><?php echo count($tamaño_array); ?></span> Juntas Profesionales encontradas <?php echo  $_POST['var_fecha'];?></a>
        </div>
        <div id="global">
        <div id="mensajes">
        <div class="texto">
        <?php

echo "<br>";

echo $mensaje_mipres = "Tiempo de ejecución de la consulta: ".$info['total_time']." ms, a solicitud de la IP: ".$info['local_ip']." codigo de respuesta: ".$http_code;

echo "<br>";
echo "<br>";


for($i = 0, $size = count($result); $i < $size; ++$i) {
    $sql = "IF NOT EXISTS (SELECT NOPRESCRIPCION FROM MIPRES_JUNTAPROFESIONAL WHERE NOPRESCRIPCION = '".$result[$i]['junta_profesional']['NoPrescripcion']."' AND FPRESCRIPCION = '".$result[$i]['junta_profesional']['FPrescripcion']."' AND  CONSECUTIVO = ".Valor(str_replace(",", ".",$result[$i]['junta_profesional']['Consecutivo']))." )
    BEGIN 

    INSERT INTO [dbo].[MIPRES_JUNTAPROFESIONAL]
    ([NOPRESCRIPCION],[FPRESCRIPCION],[TIPTECNOLOGIA],[CONSECUTIVO],[ESTJM],[CODENTPROC],[OBSERVACIONES],[JUSTIFICACIONTECNICA],[MODALIDAD],[NOACTA],[FECHAACTA],[FPROCESO],[TIPOIDPACIENTE],[NROIDPACIENTE],[CODENTJM],[USU_CARGUE],[FEC_CRUCE])
    VALUES
    ('".$result[$i]['junta_profesional']['NoPrescripcion']."' 
    ,'".$result[$i]['junta_profesional']['FPrescripcion']."'
    ,'".$result[$i]['junta_profesional']['TipoTecnologia']."'
    ,".Valor(str_replace(",", ".",$result[$i]['junta_profesional']['Consecutivo']))."
    ,".Valor(str_replace(",", ".",$result[$i]['junta_profesional']['EstJM']))."
    ,'".$result[$i]['junta_profesional']['CodEntProc']."'
    ,'".$result[$i]['junta_profesional']['Observaciones']."'
    ,'".$result[$i]['junta_profesional']['JustificacionTecnica']."'
    ,".Valor(str_replace(",", ".",$result[$i]['junta_profesional']['Modalidad']))."
    ,'".$result[$i]['junta_profesional']['NoActa']."'
    ,'".$result[$i]['junta_profesional']['FechaActa']."'
    ,'".$result[$i]['junta_profesional']['FProceso']."'
    ,'".$result[$i]['junta_profesional']['TipoIDPaciente']."'
    ,'".$result[$i]['junta_profesional']['NroIDPaciente']."'
    ,'".$result[$i]['junta_profesional']['CodEntJM']."'
    ,'".$_SESSION["usuario"]."'
    ,CURRENT_TIMESTAMP)
    END ELSE BEGIN 

    UPDATE [dbo].[MIPRES_JUNTAPROFESIONAL]
    SET [NOPRESCRIPCION] = '".$result[$i]['junta_profesional']['NoPrescripcion']."' 
    ,[FPRESCRIPCION] = '".$result[$i]['junta_profesional']['FPrescripcion']."'
    ,[TIPTECNOLOGIA] = '".$result[$i]['junta_profesional']['TipoTecnologia']."'
    ,[CONSECUTIVO] = ".Valor(str_replace(",", ".",$result[$i]['junta_profesional']['Consecutivo']))."
    ,[ESTJM] = ".Valor(str_replace(",", ".",$result[$i]['junta_profesional']['EstJM']))."
    ,[CODENTPROC] = '".$result[$i]['junta_profesional']['CodEntProc']."'
    ,[OBSERVACIONES] = '".$result[$i]['junta_profesional']['Observaciones']."'
    ,[JUSTIFICACIONTECNICA] = '".$result[$i]['junta_profesional']['JustificacionTecnica']."'
    ,[MODALIDAD] = ".Valor(str_replace(",", ".",$result[$i]['junta_profesional']['Modalidad']))."
    ,[NOACTA] = '".$result[$i]['junta_profesional']['NoActa']."'
    ,[FECHAACTA] = '".$result[$i]['junta_profesional']['FechaActa']."'
    ,[FPROCESO] = '".$result[$i]['junta_profesional']['FProceso']."'
    ,[TIPOIDPACIENTE] = '".$result[$i]['junta_profesional']['TipoIDPaciente']."'
    ,[NROIDPACIENTE] = '".$result[$i]['junta_profesional']['NroIDPaciente']."'
    ,[CODENTJM] = '".$result[$i]['junta_profesional']['CodEntJM']."'
    ,[USU_CARGUE] = '".$_SESSION["usuario"]."'
    ,[FEC_CRUCE] = CURRENT_TIMESTAMP
    WHERE NOPRESCRIPCION = '".$result[$i]['junta_profesional']['NoPrescripcion']."' AND FPRESCRIPCION = '".$result[$i]['junta_profesional']['FPrescripcion']."' AND  CONSECUTIVO = ".Valor(str_replace(",", ".",$result[$i]['junta_profesional']['Consecutivo']))."

    END";

echo "Junta: ".$result[$i]['junta_profesional']['NoPrescripcion']." Consecutivo: ".$result[$i]['junta_profesional']['Consecutivo']." Resultado: ".sql($conn,$sql)."<br>";
}
echo "<br>";
echo "<br>";
?>

        <pre>
        <?php print_r($result); ?>  
        </pre>
        </div>
        </div>
        </div>
<?php
}            else
            {
              ?>
            <div class="alert alert-warning alert-dismissible">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            <strong>Solicitud con exito!</strong> No se encontraron Juntas de Profesionales.
            </div>
            <?php
            }

            break;

            default:
            
            ?>
            <textarea id="resultado_mipres" class="form-control"  rows="7" disabled></textarea>            
      <?php
              ?>
              <script type="text/javascript">
              document.getElementById("resultado_mipres").value='<?php echo $mensaje_mipres ?>';
              </script>
              <?php
            break;

            }    
}
?>

  </div>
</div>


    </div>
  </div>
</div>
</div>


</div>


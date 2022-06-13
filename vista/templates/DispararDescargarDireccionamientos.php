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
    <li class="breadcrumb-item"><a  href="index.php?x=012">Direccionamientos por Fecha</a></li>
  </ol>
</nav>


<div class="container">

<div class="row">
  <div class="col-md-3 sm-12">
    <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
      <a class="btn btn-light" id="v-pills-profile-tab" href="index.php?x=012"><center>Regresar</center></a>
    </div>
    <br>
    <center><div id="barra" class="spinner-border text-success" style = 'display:none;'></div></center>
  </div>
  <div class="col-md-9 sm-12">
	<div class="tab-content" id="v-pills-tabContent">

<div class="card ">
  <div class="card-header">
    <H4>Direccionamientos por Fecha</H4>
  </div>
  <div class="card-body">      

<?php
set_time_limit(1000);
//ERROR0006
  if (!empty($_SESSION['NIT_EPS'])){   


    $sql = "SELECT (SELECT DES_TEM_TOKEN FROM PRS_TEM_TOKEN WHERE TIP_TEM_TOKEN = '".$_POST['var_regimen']."') AS DES_TEM_TOKEN,* FROM PRS_URL_SERVICES WHERE COD_URL = '7' ";
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
			    $url = $row['DES_URL'].$_SESSION['NIT_EPS'].'/'.$row['DES_TEM_TOKEN'].'/'.$_POST['var_fecha'];
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
	            if(count($tamaño_array)<>0){            
				$result = json_decode($result, true);
				?>	
				<div class="list-group">
				<a class="list-group-item list-group-item-action list-group-item-info"><span class="badge badge-info badge-pill"><?php echo count($tamaño_array); ?></span> Direccionamientos encontrados</a>
				</div>
				<div id="global">
				<div id="mensajes">
				<div class="texto">
				<pre>
				<?php print_r($result); ?>	
				</pre>
				</div>
				</div>
				</div>
				<br>
				<?php
					for($i = 0, $size = count($result); $i < $size; ++$i) {
					$sql = "IF NOT EXISTS (SELECT * FROM MIPRES_DIRECCIONAMIENTOS WHERE ID = '".$result[$i]['ID']."' AND IDDIRECCIONAMIENTO = '".$result[$i]['IDDireccionamiento']."') BEGIN INSERT INTO [MIPRES_DIRECCIONAMIENTOS]([ID],[IDDireccionamiento],[NoPrescripcion],[TipoTec],[ConTec],[TipoIDPaciente],[NoIDPaciente],[NoEntrega],[NoSubEntrega],[TipoIDProv],[NoIDProv],[CodMunEnt],[FecMaxEnt],[CantTotAEntregar],[DirPaciente],[CodSerTecAEntregar],[NoIDEPS],[CodEPS],[FecDireccionamiento],[EstDireccionamiento],[FecAnulacion]) VALUES ('".$result[$i]['ID']."','".$result[$i]['IDDireccionamiento']."','".$result[$i]['NoPrescripcion']."','".$result[$i]['TipoTec']."','".$result[$i]['ConTec']."','".$result[$i]['TipoIDPaciente']."','".$result[$i]['NoIDPaciente']."','".$result[$i]['NoEntrega']."','".$result[$i]['NoSubEntrega']."','".$result[$i]['TipoIDProv']."','".$result[$i]['NoIDProv']."','".$result[$i]['CodMunEnt']."','".$result[$i]['FecMaxEnt']."','".$result[$i]['CantTotAEntregar']."','".$result[$i]['DirPaciente']."','".$result[$i]['CodSerTecAEntregar']."','".$result[$i]['NoIDEPS']."','".$result[$i]['CodEPS']."','".$result[$i]['FecDireccionamiento']."','".$result[$i]['EstDireccionamiento']."','".$result[$i]['FecAnulacion']."') END ELSE BEGIN UPDATE [MIPRES_DIRECCIONAMIENTOS] SET [ID] = '".$result[$i]['ID']."',[IDDireccionamiento] = '".$result[$i]['IDDireccionamiento']."',[NoPrescripcion] = '".$result[$i]['NoPrescripcion']."',[TipoTec] = '".$result[$i]['TipoTec']."',[ConTec] = '".$result[$i]['ConTec']."',[TipoIDPaciente] = '".$result[$i]['TipoIDPaciente']."',[NoIDPaciente] = '".$result[$i]['NoIDPaciente']."',[NoEntrega] = '".$result[$i]['NoEntrega']."',[NoSubEntrega] = '".$result[$i]['NoSubEntrega']."',[TipoIDProv] = '".$result[$i]['TipoIDProv']."',[NoIDProv] = '".$result[$i]['NoIDProv']."',[CodMunEnt] = '".$result[$i]['CodMunEnt']."',[FecMaxEnt] = '".$result[$i]['FecMaxEnt']."',[CantTotAEntregar] = '".$result[$i]['CantTotAEntregar']."',[DirPaciente] = '".$result[$i]['DirPaciente']."',[CodSerTecAEntregar] = '".$result[$i]['CodSerTecAEntregar']."',[NoIDEPS] = '".$result[$i]['NoIDEPS']."',[CodEPS] = '".$result[$i]['CodEPS']."',[FecDireccionamiento] = '".$result[$i]['FecDireccionamiento']."',[EstDireccionamiento] = '".$result[$i]['EstDireccionamiento']."',[FecAnulacion] = '".$result[$i]['FecAnulacion']."' WHERE ID = '".$result[$i]['ID']."' AND IDDIRECCIONAMIENTO = '".$result[$i]['IDDireccionamiento']."' END";
		            $params = array();
		            $options =  array( "Scrollable" => SQLSRV_CURSOR_KEYSET );
		            $stmt = sqlsrv_query( $conn, $sql, $params, $options);
		            if($stmt === FALSE) {
		            echo "<div class='alert alert-danger alert-dismissible'>";
		            echo "<button type='button' class='close' data-dismiss='alert'>&times;</button>";
		            echo "<strong>Error!</strong> Error al guardar el IDDireccionamiento ".$result[$i]['IDDireccionamiento']."</div>";
		            }else
		            {
		           echo "<div class='alert alert-success alert-dismissible'>";
		           echo "<button type='button' class='close' data-dismiss='alert'>&times;</button>";
		           echo "<strong>Mensaje:</strong> Se ha completado con exito  ".$result[$i]['IDDireccionamiento']."</div>";
		            }
		            sqlsrv_free_stmt($stmt);
				    }
				?>


				<?php
	            }
            else
            {
              ?>
            <div class="alert alert-warning alert-dismissible">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            <strong>Solicitud con exito!</strong> No se encontraron Direccionamientos.
            </div>
            <?php
            }
            break;

            default:
            $info = curl_getinfo($ch);
            ?>
            <textarea id="resultado_mipres" class="form-control"  rows="7" disabled></textarea>            
			<?php
              $mensaje_mipres = "Tiempo de ejecución de la consulta: ".$info['total_time']." ms, a solicitud de la IP: ".$info['local_ip']." codigo de respuesta: ".$http_code.", resultado de la transacción: ".$result;
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



<div class="container-fluid" style="margin-top:80px">



<nav aria-label="breadcrumb">
  <ol class="breadcrumb">
    <li class="breadcrumb-item">Consultas</li>
    <li class="breadcrumb-item"><a  href="index.php?x=004" >Prescripciones por Fecha y Paciente</a></li>
  </ol>
</nav>


<div class="container">

<div class="row">
  <div class="col-md-3 sm-12">
    <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
      <a class="btn btn-light" id="v-pills-profile-tab" href="index.php"><center>Volver al Inicio</center></a>
    </div>
    <br>
    <center><div id="barra" class="spinner-border text-success" style = 'display:none;'></div></center>
  </div>
  <div class="col-md-9 sm-12">
	<div class="tab-content" id="v-pills-tabContent">

<div class="card ">
  <div class="card-header">
    <H4>Prescripciones por Fecha y Paciente</H4>
  </div>
  <div class="card-body">      
      <form class="" action="index.php?x=004&y=001" method="post"  >

			<div class="form-row">
			<div class="col-md-6 sm-12">
			<label for="validationCustom01">Régimen</label>
			<select id="var_regimen" class="form-control" name="var_regimen" required>
			<option selected>Subsidiado</option>
			<option>Contributivo</option>
			</select>
			</div>
			<div class="col-md-6 sm-12">
			<label for="validationCustom02">Fecha</label>
			<input type="date" class="form-control" id="var_fecha" name="var_fecha" value="<?php echo date("Y-m-d");?>"  required>
			</div>
			</div>
      <div class="form-row">
      <div class="col-md-6 sm-12">
      <label for="validationCustom01">Tipo Identificación</label>
      <select id="var_TI" class="form-control" name="var_TI" required>
      <option selected>CC</option>
      <option>RC</option>
      <option>TI</option>
      <option>CE</option>
      <option>PA</option>
      <option>NV</option>
      <option>CD</option>
      <option>SC</option>
      <option>PR</option>
      <option>PE</option>
      <option>AS</option>
      <option>MS</option>
      </select>
      </div>
      <div class="col-md-6 sm-12">
      <label for="validationCustom02">Numero de Identificación</label>
      <input type="number" class="form-control" id="var_NI" name="var_NI"  required>
      </div>
      </div>

		    <br>
		    <button 
		    class="btn btn-outline-success btn-block" type="submit" onclick="document.getElementById('barra').style.display = 'block';">Consultar a MIPRES</button>  
      </form>
  </div>
</div>



      <br>
      <div class="form-group">
      <input type="button" id="mostrar" name="boton1" value="Respuesta servidor MIPRES" class="btn btn-info btn-block">  
      </div>
      <br>
      <div class="form-group" id="target" style = 'display:none;'>
      <textarea id="resultado_mipres" class="form-control"  rows="6" disabled></textarea>
      </div>
      <br>
      <div class="form-group">
<?php  
if (isset($_GET["y"])){ 
$var_regimen = $_REQUEST['var_regimen'];
$var_fecha = $_REQUEST['var_fecha'];
$var_TI = $_REQUEST['var_TI'];
$var_NI = $_REQUEST['var_NI'];

?>
<script type="text/javascript">
document.getElementById("var_regimen").value='<?php echo $var_regimen; ?>';
document.getElementById("var_fecha").value='<?php echo $var_fecha; ?>';
document.getElementById("var_TI").value='<?php echo $var_TI; ?>';
document.getElementById("var_NI").value='<?php echo $var_NI; ?>';
document.getElementById('target').style.display = 'none';
document.getElementById('target').value = '';
document.getElementById('barra').style.display = 'none';
</script>
<?php

      switch ($_GET["y"]) {
        case '001':
          require_once("services/GET-api-Prescripcion-nit-fecha-token-TDPaciente-NroDocPaciente.php");
          if (!curl_errno($ch)) {
            switch ($http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE)) {
            case 200:  # OK
            $tamaño_array = json_decode($result, true);
            if(count($tamaño_array)<>0){
            $JSON_codificado = urlencode($result);
              ?>
              <form action='vista/templates/prescripcion.php' method='post'>
              <input type='hidden' name='data' value="<?php echo $JSON_codificado ?>">
              <input type='hidden' name='nombre_archivo' value="<?php echo $var_regimen.'-'.$var_fecha.'-'.$var_TI.'-'.$var_NI; ?>">
              <input type='submit' value="<?php echo $var_regimen.'-'.$var_fecha.'-'.$var_TI.'-'.$var_NI; ?>" class="btn btn-success btn-block">
              </form>
              <?php
            }else
            {
              ?>
              <div class="alert alert-warning alert-dismissible">
              <button type="button" class="close" data-dismiss="alert">&times;</button>
              No se encontraron resultados con el filtro seleccionado.
              </div>
              <?php
            }    
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
?>
      </div>


    </div>
  </div>
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


<?php
set_time_limit(1000000000000000000);
require_once('modelo/conexion-sql.php');

$sql = "SELECT * FROM PRS_URL_SERVICES WHERE SERVICIO = 'GET' ORDER BY DESCRIPCION ASC";

$params = array();
$options =  array( "Scrollable" => SQLSRV_CURSOR_KEYSET );
$stmt = sqlsrv_query( $conn, $sql, $params, $options);
$row_count = sqlsrv_num_rows( $stmt );
$row_dos = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC);

?>    


<div class="row">
  <div class="col-md-3 sm-12">
    <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
      <a class="btn btn-outline-dark btn-block" id="v-pills-profile-tab" href="index.php"><center>Volver al Inicio</center></a>
    </div>
    <br>
    <center><div id="barra" class="spinner-border text-success" style = 'display:none;'></div></center>
  </div>
  <div class="col-md-9 sm-12">
  <div class="tab-content" id="v-pills-tabContent">

<div class="card shadow">
  <div class="card-header">
    <H4>Consumir Servicios</H4>
  </div>
  <div class="card-body">      
      <form class="" action="index.php?x=037&y=001" method="post">
      <div class="form-row">
      <div class="col-md-4 sm-4">
      <label>Servicio</label>
      <select class="form-control" id="COD_URL" name="COD_URL" required>
      <option></option>
      <option value= '1'>Prescripciones</option>
      <option value= '7'>Novedades Prescripciones</option>
      <option value= '5'>Tutelas</option> 
      <option value= '8'>Junta de Profesionales</option>
      <option value= '2'>Direccionamientos</option> 
      <option value= '6'>No Direccionamientos</option>  
      <option value= '3'>Reporte Proveedor</option>   
      <option value= '4'>Reporte Suministro (EPS)</option>   
      </select>
      </div>
      <div class="col-md-3 sm-3">
      <label for="validationCustom02">Fecha Inicial</label>
      <input type="date" class="form-control" id="fechaInicio" name="fechaInicio" value="<?php echo date("Y-m-d");?>"  required>
      </div>
      <div class="col-md-3 sm-3">
      <label for="validationCustom02">Fecha Final</label>
      <input type="date" class="form-control" id="fechaFin" name="fechaFin" value="<?php echo date("Y-m-d");?>"  required>
      </div>
      <div class="col-md-2 sm-2">
      <hr>
      <button class="btn btn-outline-dark btn-block" type="submit">Consultar</button>  
      </div>
      </div>
      </form>


  </div>
</div>


    </div>
  </div>
</div>


<?php
if (isset($_GET["y"])) {
      switch ($_GET["y"]) {
        case '001':
        $fechaInicio=strtotime($_POST["fechaInicio"]);
        $fechaFin=strtotime($_POST["fechaFin"]);
?>
<br>
<div class="card shadow">
  <div class="card-header">
    <H4>Resultados</H4>
  </div>
  <div class="card-body">  
    
<?php

        switch ($_POST["COD_URL"]) {


            case '1': # PRESCRIPCIONES            
            for($i=$fechaInicio; $i<=$fechaFin; $i+=86400){
            $fecha = date("Y-m-d", $i);
            echo "<br>Prescripciones Subsidiadas ".$fecha.": <br>";
            $handle = curl_init();
            $url =  $_SESSION['RUTA_PROYECTO']."/WebService/Prescripcion.php?link=https://wsmipres.sispro.gov.co/wsmipresnopbs/api/Prescripcion/".$_SESSION['NIT_EPS'].'/'.$fecha.'/'.$_SESSION['PRETOCKENSUB'];
            curl_setopt($handle, CURLOPT_URL, $url);
            curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($handle, CURLOPT_SSL_VERIFYPEER, false);
            $output = curl_exec($handle);
            curl_close($handle);
            echo $output;
            echo "<br>Prescripciones Contributivas ".$fecha.": <br>";
            $handle = curl_init(); 
            $url  =  $_SESSION['RUTA_PROYECTO']."/WebService/Prescripcion.php?link=https://wsmipres.sispro.gov.co/wsmipresnopbs/api/Prescripcion/".$_SESSION['NIT_EPS'].'/'.$fecha.'/'.$_SESSION['PRETOCKEN'];
            curl_setopt($handle, CURLOPT_URL, $url);
            curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($handle, CURLOPT_SSL_VERIFYPEER, false);
            $output = curl_exec($handle);
            curl_close($handle);
            echo $output;
            }
            break;




            case '2': # DIRECCIONAMIENTOS
            for($i=$fechaInicio; $i<=$fechaFin; $i+=86400){
            $fecha = date("Y-m-d", $i);
            echo "<br>Direccionamientos Subsidiados ".$fecha.": <br>";
            $handle = curl_init();
            $url =  $_SESSION['RUTA_PROYECTO']."/WebService/Direccionamiento.php?link=https://wsmipres.sispro.gov.co/WSSUMMIPRESNOPBS/api/DireccionamientoXFecha/".$_SESSION['NIT_EPS'].'/'.token_temporal($conn,'S').'/'.$fecha;
            curl_setopt($handle, CURLOPT_URL, $url);
            curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($handle, CURLOPT_SSL_VERIFYPEER, false);
            $output = curl_exec($handle);
            curl_close($handle);
            echo $output;
            echo "<br>Direccionamientos Contributivos ".$fecha.": <br>";
            $handle = curl_init(); 
            $url  =  $_SESSION['RUTA_PROYECTO']."/WebService/Direccionamiento.php?link=https://wsmipres.sispro.gov.co/WSSUMMIPRESNOPBS/api/DireccionamientoXFecha/".$_SESSION['NIT_EPS'].'/'.token_temporal($conn,'C').'/'.$fecha;
            curl_setopt($handle, CURLOPT_URL, $url);
            curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($handle, CURLOPT_SSL_VERIFYPEER, false);
            $output = curl_exec($handle);
            curl_close($handle);
            echo $output;
            }
            break;
      
           case '3': # REPORTE PROVEEDOR
            for($i=$fechaInicio; $i<=$fechaFin; $i+=86400){
            $fecha = date("Y-m-d", $i);
            echo "<br>Reporte Proveedor Subsidiados ".$fecha.": <br>";
            $handle = curl_init();
            $url =  $_SESSION['RUTA_PROYECTO']."/WebService/ReporteProveedor.php?link=https://wsmipres.sispro.gov.co/WSSUMMIPRESNOPBS/api/ReporteEntregaXFecha/".$_SESSION['NIT_EPS'].'/'.token_temporal($conn,'S').'/'.$fecha;
            curl_setopt($handle, CURLOPT_URL, $url);
            curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($handle, CURLOPT_SSL_VERIFYPEER, false);
            $output = curl_exec($handle);
            curl_close($handle);
            echo $output;
            echo "<br>Reporte Proveedor Contributivos ".$fecha.": <br>";
            $handle = curl_init(); 
            $url =  $_SESSION['RUTA_PROYECTO']."/WebService/ReporteProveedor.php?link=https://wsmipres.sispro.gov.co/WSSUMMIPRESNOPBS/api/ReporteEntregaXFecha/".$_SESSION['NIT_EPS'].'/'.token_temporal($conn,'C').'/'.$fecha;
            curl_setopt($handle, CURLOPT_URL, $url);
            curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($handle, CURLOPT_SSL_VERIFYPEER, false);
            $output = curl_exec($handle);
            curl_close($handle);
            echo $output;
            }
              break;
          

            case '4': # REPORTE SUMINISTRO (EPS)
            for($i=$fechaInicio; $i<=$fechaFin; $i+=86400){
            $fecha = date("Y-m-d", $i);
            echo "<br>Reporte Suministro Subsidiados ".$fecha.": <br>";
            $handle = curl_init();
            $url =  $_SESSION['RUTA_PROYECTO']."/WebService/Suministro.php?link=https://wsmipres.sispro.gov.co/WSSUMMIPRESNOPBS/api/SuministroXFecha/".$_SESSION['NIT_EPS'].'/'.token_temporal($conn,'S').'/'.$fecha;
            curl_setopt($handle, CURLOPT_URL, $url);
            curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($handle, CURLOPT_SSL_VERIFYPEER, false);
            $output = curl_exec($handle);
            curl_close($handle);
            echo $output;
            echo "<br>Reporte Suministro Contributivos ".$fecha.": <br>";
            $handle = curl_init(); 
            $url =  $_SESSION['RUTA_PROYECTO']."/WebService/Suministro.php?link=https://wsmipres.sispro.gov.co/WSSUMMIPRESNOPBS/api/SuministroXFecha/".$_SESSION['NIT_EPS'].'/'.token_temporal($conn,'C').'/'.$fecha;
            curl_setopt($handle, CURLOPT_URL, $url);
            curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($handle, CURLOPT_SSL_VERIFYPEER, false);
            $output = curl_exec($handle);
            curl_close($handle);
            echo $output;
            }
              break;


            case '5': # TUTELAS            
            for($i=$fechaInicio; $i<=$fechaFin; $i+=86400){
            $fecha = date("Y-m-d", $i);
            echo "<br>Tutelas Subsidiadas ".$fecha.": <br>";
            $handle = curl_init();
            $url =  $_SESSION['RUTA_PROYECTO']."/WebService/Tutelas.php?link=https://wsmipres.sispro.gov.co/wsmipresnopbs/api/Tutelas/".$_SESSION['NIT_EPS'].'/'.$fecha.'/'.$_SESSION['PRETOCKENSUB'];
            curl_setopt($handle, CURLOPT_URL, $url);
            curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($handle, CURLOPT_SSL_VERIFYPEER, false);
            $output = curl_exec($handle);
            curl_close($handle);
            echo $output;
            echo "<br>Tutelas Contributivas ".$fecha.": <br>";
            $handle = curl_init(); 
            $url  =  $_SESSION['RUTA_PROYECTO']."/WebService/Tutelas.php?link=https://wsmipres.sispro.gov.co/wsmipresnopbs/api/Tutelas/".$_SESSION['NIT_EPS'].'/'.$fecha.'/'.$_SESSION['PRETOCKEN'];
            curl_setopt($handle, CURLOPT_URL, $url);
            curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($handle, CURLOPT_SSL_VERIFYPEER, false);
            $output = curl_exec($handle);
            curl_close($handle);
            echo $output;
            }
            break;


            case '6': # NO DIRECCIONAMIENTOS
            for($i=$fechaInicio; $i<=$fechaFin; $i+=86400){
            $fecha = date("Y-m-d", $i);
            echo "<br>No Direccionamientos Subsidiados ".$fecha.": <br>";
            $handle = curl_init();
            $url =  $_SESSION['RUTA_PROYECTO']."/WebService/NoDireccionamiento.php?link=https://wsmipres.sispro.gov.co/WSSUMMIPRESNOPBS/api/NODireccionamientoXFecha/".$_SESSION['NIT_EPS'].'/'.token_temporal($conn,'S').'/'.$fecha;
            curl_setopt($handle, CURLOPT_URL, $url);
            curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($handle, CURLOPT_SSL_VERIFYPEER, false);
            $output = curl_exec($handle);
            curl_close($handle);
            echo $output;
            echo "<br>No Direccionamientos Contributivos ".$fecha.": <br>";
            $handle = curl_init(); 
            $url  =  $_SESSION['RUTA_PROYECTO']."/WebService/NoDireccionamiento.php?link=https://wsmipres.sispro.gov.co/WSSUMMIPRESNOPBS/api/NODireccionamientoXFecha/".$_SESSION['NIT_EPS'].'/'.token_temporal($conn,'C').'/'.$fecha;
            curl_setopt($handle, CURLOPT_URL, $url);
            curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($handle, CURLOPT_SSL_VERIFYPEER, false);
            $output = curl_exec($handle);
            curl_close($handle);
            echo $output;
            }
              break;


            case '7': # NOVEDADES PRESCRIPCION 
            for($i=$fechaInicio; $i<=$fechaFin; $i+=86400){
            $fecha = date("Y-m-d", $i);
            echo "<br>Novedades Prescripción Subsidiados ".$fecha.": <br>";
            $handle = curl_init();
            $url =  $_SESSION['RUTA_PROYECTO']."/WebService/NovedadesPrescripcion.php?link=https://wsmipres.sispro.gov.co/wsmipresnopbs/api/NovedadesPrescripcion/".$_SESSION['NIT_EPS'].'/'.$fecha.'/'.$_SESSION['PRETOCKENSUB'];
            curl_setopt($handle, CURLOPT_URL, $url);
            curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($handle, CURLOPT_SSL_VERIFYPEER, false);
            $output = curl_exec($handle);
            curl_close($handle);
            echo $output;
            echo "<br>Novedades Prescripción Contributivos ".$fecha.": <br>";
            $handle = curl_init(); 
            $url  =  $_SESSION['RUTA_PROYECTO']."/WebService/NovedadesPrescripcion.php?link=https://wsmipres.sispro.gov.co/wsmipresnopbs/api/NovedadesPrescripcion/".$_SESSION['NIT_EPS'].'/'.$fecha.'/'.$_SESSION['PRETOCKEN'];
            curl_setopt($handle, CURLOPT_URL, $url);
            curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($handle, CURLOPT_SSL_VERIFYPEER, false);
            $output = curl_exec($handle);
            curl_close($handle);
            echo $output;
            }
              break;


            case '8': # JUNTA DE PROFESIOANLES
            for($i=$fechaInicio; $i<=$fechaFin; $i+=86400){
            $fecha = date("Y-m-d", $i);
            echo "<br>Junta Profesionales Subsidiados ".$fecha.": <br>";
            $handle = curl_init();
            $url =  $_SESSION['RUTA_PROYECTO']."/WebService/JuntaProfesional.php?link=https://wsmipres.sispro.gov.co/wsmipresnopbs/api/JuntaProfesionalXFecha/".$_SESSION['NIT_EPS'].'/'.$_SESSION['PRETOCKENSUB'].'/'.$fecha;
            curl_setopt($handle, CURLOPT_URL, $url);
            curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($handle, CURLOPT_SSL_VERIFYPEER, false);
            $output = curl_exec($handle);
            curl_close($handle);
            echo $output;
            echo "<br>Junta Profesionales Contributivos ".$fecha.": <br>";
            $handle = curl_init(); 
            $url  =  $_SESSION['RUTA_PROYECTO']."/WebService/JuntaProfesional.php?link=https://wsmipres.sispro.gov.co/wsmipresnopbs/api/JuntaProfesionalXFecha/".$_SESSION['NIT_EPS'].'/'.$_SESSION['PRETOCKEN'].'/'.$fecha;
            curl_setopt($handle, CURLOPT_URL, $url);
            curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($handle, CURLOPT_SSL_VERIFYPEER, false);
            $output = curl_exec($handle);
            curl_close($handle);
            echo $output;
            }
              break;


          default:
            echo "Algo no salio bien, intentelo nuevamente";
            break;


        }

        break;

?>
  </div>
</div>
<br>
<br>
<?php

            }

        }
?>

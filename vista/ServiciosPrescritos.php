<?php
set_time_limit(1000000000000000000);
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
    <H4>Servicios Prescritos</H4>
  </div>
  <div class="card-body">      
      <form class="" action="index.php?x=044&y=001" method="post">
      <div class="form-row">
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
        $fechaInicio = date("d/m/Y",strtotime(substr($_POST["fechaInicio"], 0, 10)));
        $fechaFin = date("d/m/Y",strtotime(substr($_POST["fechaFin"], 0, 10)));
 
$sql = " exec dbo.sp_servicios_prescritos '".$fechaInicio."','".$fechaFin."' ";
$stmt2 = sqlsrv_query( $conn, $sql , array());  
  
if ($stmt2 !== NULL) {  
      $rows2 = sqlsrv_has_rows( $stmt2 );  
  
      if ($rows2 === true)  {
?>
<br>
<div class="card shadow">
<div class="card-body">
      <div class="row">
        <div class="col">       
          <table class="table table-bordered table-responsive table-sm" height="500px">
          <thead class="thead-light"  position: fixed>
            <tr>
              <th>REPORTMIPRES</th>
              <th>NOPRESCRIPCION</th>
              <th>FPRESCRIPCION</th>
              <th>HPRESCRIPCION</th>
              <th>NROIDIPS</th>
              <th>NOM_PRESTADOR</th>
              <th>CODHABIPS</th>
              <th>CODDANEMUNIPS</th>
              <th>DEPARTAMENTO_PRESTADOR</th>
              <th>MUNICIPIO_PRESTADOR</th>
              <th>TIPOIDPROF</th>
              <th>NUMIDPROF</th>
              <th>NOM_PROFESIONAL</th>
              <th>TIPOIDPACIENTE</th>
              <th>NROIDPACIENTE</th>
              <th>NOM_PACIENTE</th>
              <th>CODAMBATE</th>
              <th>CODDXPPAL</th>
              <th>CODDXREL1</th>
              <th>CODDXREL2</th>
              <th>CODEPS</th>
              <th>MADRE_PACIENTE</th>
              <th>TIPOTRANSC</th>
              <th>REFAMBATE</th>
              <th>PACCOVID19</th>
              <th>ESTADO</th>
              <th>TIPO</th>
              <th>CONORDEN</th>
              <th>COD_MIPRES</th>
              <th>NOMBRE</th>
              <th>FRECUENCIA</th>
              <th>DURACION_TRATAMIENTO</th>
              <th>CANTIDAD_TOTAL</th>
              <th>ESTJM</th>
            </tr>
          </thead>
          <tbody>
<?php
            while( $row2 = sqlsrv_fetch_array( $stmt2, SQLSRV_FETCH_ASSOC))  
            {  
?>
              <tr>
               <td><?php echo utf8_encode($row2['REPORTMIPRES']);  ?></td>
               <td><?php echo utf8_encode($row2['NOPRESCRIPCION']);  ?></td>
               <td><?php echo $row2['FPRESCRIPCION']->format('d/m/Y'); ?></td>
               <td><?php echo utf8_encode($row2['HPRESCRIPCION']);  ?></td>
               <td><?php echo utf8_encode($row2['NROIDIPS']);  ?></td>
               <td><?php echo utf8_encode($row2['NOM_PRESTADOR']);  ?></td>
               <td><?php echo utf8_encode($row2['CODHABIPS']);  ?></td>
               <td><?php echo utf8_encode($row2['CODDANEMUNIPS']);  ?></td>
               <td><?php echo utf8_encode($row2['DEPARTAMENTO_PRESTADOR']);  ?></td>
               <td><?php echo utf8_encode($row2['MUNICIPIO_PRESTADOR']);  ?></td>
               <td><?php echo utf8_encode($row2['TIPOIDPROF']);  ?></td>
               <td><?php echo utf8_encode($row2['NUMIDPROF']);  ?></td>
               <td><?php echo utf8_encode($row2['NOM_PROFESIONAL']);  ?></td>
               <td><?php echo utf8_encode($row2['TIPOIDPACIENTE']);  ?></td>
               <td><?php echo utf8_encode($row2['NROIDPACIENTE']);  ?></td>
               <td><?php echo utf8_encode($row2['NOM_PACIENTE']);  ?></td>
               <td><?php echo utf8_encode($row2['CODAMBATE']);  ?></td>
               <td><?php echo utf8_encode($row2['CODDXPPAL']);  ?></td>
               <td><?php echo utf8_encode($row2['CODDXREL1']);  ?></td>
               <td><?php echo utf8_encode($row2['CODDXREL2']);  ?></td>
               <td><?php echo utf8_encode($row2['CODEPS']);  ?></td>
               <td><?php echo utf8_encode($row2['MADRE_PACIENTE']);  ?></td>
               <td><?php echo utf8_encode($row2['TIPOTRANSC']);  ?></td>
               <td><?php echo utf8_encode($row2['REFAMBATE']);  ?></td>
               <td><?php echo utf8_encode($row2['PACCOVID19']);  ?></td>
               <td><?php echo utf8_encode($row2['ESTADO']);  ?></td>

               <td><?php echo utf8_encode($row2['TIPO']);  ?></td>
               <td><?php echo utf8_encode($row2['CONORDEN']);  ?></td>
               <td><?php echo utf8_encode($row2['COD_MIPRES']);  ?></td>
               <td><?php echo utf8_encode($row2['NOMBRE']);  ?></td>
               <td><?php echo utf8_encode($row2['FRECUENCIA']);  ?></td>
               <td><?php echo utf8_encode($row2['DURACION_TRATAMIENTO']);  ?></td>
               <td><?php echo utf8_encode($row2['CANTIDAD_TOTAL']);  ?></td>
               <td><?php echo utf8_encode($row2['ESTJM']);  ?></td>
              </tr>
<?php
            }
?>

          </tbody>
          </table>
        </div>
      </div>



<?php
    }
      else   {
         echo "<BR><BR><BR><center>\nNo se encuentran prescripciones para las fechas establecidas \n</center><BR>";  
      }
   }



?>
</div>
</div>
<br>
<?php

  }
}





?>


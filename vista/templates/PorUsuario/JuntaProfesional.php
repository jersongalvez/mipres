<style type="text/css">
#global1 {
	height: 450px;
	width: 100%;
	border: 1px solid #ddd;
	background: #f1f1f1;
	overflow-y: scroll;
}
#mensajes1 {
	height: auto;
}
.texto1 {
	padding:4px;
	background:#fff;
}
</style>

<?php
require_once('../../../modelo/conexion-sql.php');
$NOPRESCRIPCION = trim($_POST["NOPRESCRIPCION"]);
$sql = "SELECT  TIPTECNOLOGIA, CONSECUTIVO, ESTJM, CODENTPROC, OBSERVACIONES, JUSTIFICACIONTECNICA, MODALIDAD, NOACTA, FECHAACTA, FPROCESO,  CODENTJM  FROM  MIPRES_JUNTAPROFESIONAL WHERE NOPRESCRIPCION   = '".$NOPRESCRIPCION."' order by FPROCESO desc  ";

   $stmt2 = sqlsrv_query( $conn, $sql , array());  
  
   if ($stmt2 !== NULL) {  
      $rows2 = sqlsrv_has_rows( $stmt2 );  
  
      if ($rows2 === true)  {
?>

<div id="global1">
  <div id="mensajes1">

		  <div class="row">
		    <div class="col">				
					<table class="table table-bordered  table-sm">
					<thead class="thead-light">
					  <tr>
					    <th>TIPO TECNOLOGIA</th>
					    <th>CONSECUTIVO</th>
					    <th>ESTADO JUNTA PROF.</th>
					    <th>OBSERVACIONES</th>
					    <th>JUSTIFICACIÓN TÉCNICA</th>
					    <th>MODALIDAD</th>
					    <th>NO. ACTA</th>
					    <th>FEC. ACTA</th>
					    <th>FEC. PROCESO</th>
					  </tr>
					</thead>
					<tbody>
<?php
						while( $row2 = sqlsrv_fetch_array( $stmt2, SQLSRV_FETCH_ASSOC))  
						{  
?>
						  <tr>
						    <td><?php echo $row2['TIPTECNOLOGIA'];  ?></td>
						    <td><?php echo $row2['CONSECUTIVO'];  ?></td>
						    <td><?php 
						    if($row2['ESTJM']=='1'){
						    	echo "No requiere junta de profesionales";
						    }elseif ($row2['ESTJM']=='2') {
						    	echo "Requiere junta de profesionales y pendiente evaluación";
						    }elseif ($row2['ESTJM']=='3') {
						    	echo "Evaluada por la junta de profesionales y fue aprobada";
						    }elseif ($row2['ESTJM']=='4') {
						    	echo "Evaluada por la junta de profesionales y no fue aprobada";
						    }
						    ?></td>
						    <td><?php echo $row2['OBSERVACIONES'];  ?></td>
						    <td><?php echo $row2['JUSTIFICACIONTECNICA'];  ?></td>
						    <td><?php 
						    if($row2['MODALIDAD']=='1'){
						    	echo "Presencial";
						    }elseif ($row2['MODALIDAD']=='2') {
						    	echo "Virtual";
						    }?></td>
						    <td><?php echo $row2['NOACTA'];  ?></td>
						    <td><?php echo $row2['FECHAACTA']->format('d/m/Y');  ?></td>
						    <td><?php echo $row2['FPROCESO']->format('d/m/Y');  ?></td>
						  </tr>
<?php
						}
?>

					</tbody>
					</table>
		    </div>
		  </div>

   </div>
</div>

<?php
	  }
      else   {
         echo "<BR>\nNo se encuentra junta profesional para la prescripción \n<BR>";  
      }
   }

?>
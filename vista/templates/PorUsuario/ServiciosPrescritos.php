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
 $sql = " SELECT * FROM  MIPRES_SERVICIOS_PRESCRIPCION WHERE NOPRESCRIPCION = '".$NOPRESCRIPCION."' ";

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
					    <th>TIPO SERVICIO</th>
					    <th>ORDEN</th>
					    <th>DESCRIPCIÓN</th>
					    <th>COD. MIPRES</th>
					    <th>ESTADO</th>
					  </tr>
					</thead>
					<tbody>
<?php
						while( $row2 = sqlsrv_fetch_array( $stmt2, SQLSRV_FETCH_ASSOC))  
						{  
?>
						  <tr>
						    <td><?php echo $row2['TIPO'];  ?></td>
						    <td><?php echo $row2['CONORDEN'];  ?></td>
						    <td><?php echo utf8_encode ($row2['NOMBRE']);  ?></td>
						    <td><?php echo $row2['COD_MIPRES']; ?></td>
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
         echo "<BR>\nNo se encuentran servicios autorizados para la prescripción \n<BR>";  
      }
   }

?>



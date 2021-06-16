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
 $sql = "
SELECT CE.DES_CAUSAS, AU.NO_SOLICITUD, FEC_AUTORIZA, FEC_AUTORIZACION, TABLA, CD_SERVICIO, CANTIDAD, OBSERVACION, SE.IDENTIFICADOR, SE.IDDIRECCIONAMIENTO, SE.CODSERTEC, AU.ESTADO FROM AUTORIZACION AU INNER JOIN SERVICIOS_AUTORIZADOS SE
ON AU.NO_SOLICITUD = SE.NO_SOLICITUD  INNER JOIN CAUSA_EXTERNA  CE ON AU.CAUSA_EXTERNA = CE.COD_CAUSAS  WHERE 
ESTADO IN ('AU', 'CO', 'NC', 'AN' ) AND NUM_COMITECTC = '".$NOPRESCRIPCION."' ORDER BY FEC_AUTORIZA DESC";

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
					    <th>NO. SOLICITUD</th>
					    <th>FEC. GENERACIÓN</th>
					    <th>FEC. AUTORIZACIÓN</th>
					    <th>ESTADO</th>
					    <th>TARIFARIO</th>
					    <th>COD. SERVICIO</th>
					    <th>DESCRIPCIÓN</th>
					    <th>CANTIDAD</th>
					    <th>IDENTIFICADOR</th>
					    <th>DIRECCIONAMIENTO</th>
					    <th>CODSERTEC</th>
					  </tr>
					</thead>
					<tbody>
<?php
						while( $row2 = sqlsrv_fetch_array( $stmt2, SQLSRV_FETCH_ASSOC))  
						{  
?>
						  <tr>
						    <td><?php echo $row2['NO_SOLICITUD'];  ?></td>
						    <td><?php echo $row2['FEC_AUTORIZA']->format('d/m/Y'); ?></td>
						    <td><?php echo $row2['FEC_AUTORIZACION']->format('d/m/Y'); ?></td>
						    <td><?php echo $row2['ESTADO']; ?></td>
						    <td><?php echo $row2['TABLA'];  ?></td>
						    <td><?php echo $row2['CD_SERVICIO'];  ?></td>
						    <td><?php echo utf8_encode ($row2['OBSERVACION']);  ?></td>
						    <td><?php echo $row2['CANTIDAD'];  ?></td>
						    <td><?php echo $row2['IDENTIFICADOR'];  ?></td>
						    <td><?php echo $row2['IDDIRECCIONAMIENTO'];  ?></td>
						    <td><?php echo $row2['CODSERTEC'];  ?></td>
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
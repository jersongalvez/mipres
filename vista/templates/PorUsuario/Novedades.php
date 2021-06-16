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
$sql = "SELECT * FROM MIPRES_NOVEDADES WHERE NOPRESCRIPCION   = '".$NOPRESCRIPCION."' order by FNov desc  ";

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
					    <th>TIPO NOVEDAD</th>
					    <th>NO. PRES. INICIAL</th>
					    <th>NO. PRES. FINAL</th>
					    <th>FEC. NOVEDAD</th>
					  </tr>
					</thead>
					<tbody>
<?php
						while( $row2 = sqlsrv_fetch_array( $stmt2, SQLSRV_FETCH_ASSOC))  
						{  
?>
						  <tr>
						    <td><?php 
							if($row2['TipoNov']=='1'){
						    	echo "Modificación";
						    }elseif ($row2['TipoNov']=='2') {
						    	echo "Anulación";
						    }elseif ($row2['TipoNov']=='3') {
						    	echo "Transcripción";
						    }  ?></td>
						    <td><?php echo $row2['NoPrescripcion'];  ?></td>
						    <td><?php echo $row2['NoPrescripcionF'];  ?></td>
						    <td><?php echo $row2['FNov']->format('d/m/Y');  ?></td>
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
         echo "<BR>\nNo se encuentran novedades para la prescripción \n<BR>";  
      }
   }

?>
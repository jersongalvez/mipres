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
$sql = "SELECT *,
(SELECT DESCRIPCION FROM MIPRES_CAUSAS_NO_ENTREGA WHERE TIPO = 'NODIRECCIONAMIENTO' AND COD_CAUSA = CAUSANOENTREGA) DESCRIPCION
FROM MIPRES_NO_DIRECCIONAMIENTOS WHERE NOPRESCRIPCION   = '".$NOPRESCRIPCION."' order by FecNODireccionamiento desc  ";

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
					    <th>ID</th>
					    <th>NO DIRECCIONAMIENTO</th>
					    <th>TIPO TEC.</th>
					    <th>CON. TEC.</th>
					    <th>PRESCIPCIÓN ASOCIADA</th>
					    <th>TEC. ASOCIADA</th>
					    <th>CAUSA NO ENTREGA</th>
					    <th>FEC. NO DIRECCIONAMIENTO</th>
					    <th>FEC. ANULACIÓN</th>
					    <th>ESTADO</th>
					  </tr>
					</thead>
					<tbody>
<?php
						while( $row2 = sqlsrv_fetch_array( $stmt2, SQLSRV_FETCH_ASSOC))  
						{  
?>
						  <tr>
						    <td><?php echo $row2['ID'];  ?></td>
						    <td><?php echo $row2['IDNODireccionamiento'];  ?></td>
						    <td><?php echo $row2['TipoTec'];  ?></td>
						    <td><?php echo $row2['ConTec'];  ?></td>
						    <td><?php echo $row2['NoPrescripcionAsociada'];  ?></td>
						    <td><?php echo $row2['ConTecAsociada'];  ?></td>
						    <td><?php echo '('.$row2['CausaNoEntrega'].') '.$row2['DESCRIPCION'];  ?></td>
						    <td><?php echo $row2['FecNODireccionamiento']->format('d/m/Y'); ?></td>
						    <td><?php echo $row2['FecAnulacion']->format('d/m/Y'); ?></td>
						    <td><?php 
						    if($row2['EstNODireccionamiento']=='0'){
						    	echo "Anulado";
						    }elseif ($row2['EstNODireccionamiento']=='1') {
						    	echo "Activo";
						    }elseif ($row2['EstNODireccionamiento']=='2') {
						    	echo "Procesado";
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
         echo "<BR>\nNo se encuentran no direccionamientos para la prescripción \n<BR>";  
      }
   }

?>
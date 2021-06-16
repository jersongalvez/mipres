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
$sql = "SELECT 
ID, IDDireccionamiento, TipoTec, ConTec, NoEntrega, NoSubEntrega, TipoIDProv, NoIDProv, 
CodMunEnt, FecMaxEnt, CantTotAEntregar, CodSerTecAEntregar, FecDireccionamiento, EstDireccionamiento, FecAnulacion
FROM MIPRES_DIRECCIONAMIENTOS WHERE NOPRESCRIPCION  = '".$NOPRESCRIPCION."' order by FecMaxEnt desc  ";

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
					    <th>DIRECCIONAMIENTO</th>
					    <th>TIPO TEC.</th>
					    <th>CON. TEC.</th>
					    <th>ENTREGA</th>
					    <th>PRESTADOR</th>
					    <th>FEC. MAX. ENTREGA</th>
					    <th>CANTIDAD ENTREGAR</th>
					    <th>SERVICIO ENTREGAR</th>
					    <th>FEC. DIRECCIONAMIENTO</th>
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
						    <td><?php echo $row2['IDDireccionamiento'];  ?></td>
						    <td><?php echo $row2['TipoTec'];  ?></td>
						    <td><?php echo $row2['ConTec'];  ?></td>
						    <td><?php echo $row2['NoEntrega'].'/'.$row2['NoSubEntrega'];  ?></td>
						    <td><?php echo $row2['TipoIDProv'].$row2['NoIDProv'];  ?></td>
						    <td><?php echo $row2['FecMaxEnt']->format('d/m/Y');  ?></td>
						    <td><?php echo $row2['CantTotAEntregar'];  ?></td>
						    <td><?php echo $row2['CodSerTecAEntregar']; ?></td>
						    <td><?php echo $row2['FecDireccionamiento']->format('d/m/Y'); ?></td>
						    <td><?php echo $row2['FecAnulacion']->format('d/m/Y'); ?></td>
						    <td><?php 
						    if($row2['EstDireccionamiento']=='0'){
						    	echo "Anulado";
						    }elseif ($row2['EstDireccionamiento']=='1') {
						    	echo "Activo";
						    }elseif ($row2['EstDireccionamiento']=='2') {
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
         echo "<BR>\nNo se encuentran direccionamientos para la prescripción \n<BR>";  
      }
   }

?>
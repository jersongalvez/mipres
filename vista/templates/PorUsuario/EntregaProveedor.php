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
(SELECT DESCRIPCION FROM MIPRES_CAUSAS_NO_ENTREGA WHERE  COD_CAUSA = CAUSANOENTREGA) DESCRIPCION
FROM MIPRES_ENTREGA_PROVEEDOR WHERE NOPRESCRIPCION   = '".$NOPRESCRIPCION."' order by FecRepEntrega desc  ";

   $stmt2 = sqlsrv_query( $conn, $sql , array());  
  
   if ($stmt2 !== NULL) {  
      $rows2 = sqlsrv_has_rows( $stmt2 );  
  
      if ($rows2 === true)  {
?>

<div id="global1">
  <div id="mensajes1">

		  <div class="row">
		    <div class="col">				
					<table class="table table-bordered ">
					<thead class="thead-light">
					  <tr>
					    <th>ID</th>
					    <th>NO. REPORTE ENTREGA</th>
					    <th>TIPO TEC.</th>
					    <th>CON. TEC.</th>
					    <th>NO. ENTREGA</th>
					    <th>ESTADO ENTREGA</th>
					    <th>CAUSA NO ENTREGA</th>
					    <th>VALOR ENTREGA</th>
					    <th>TEC. ENTREGADA</th>
					    <th>CANTIDAD ENTREGADA</th>
					    <th>NO. LOTE</th>
					    <th>FEC. ENTREGA</th>
					    <th>FEC. REPORTE ENTREGA</th>
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
						    <td><?php echo $row2['IDReporteEntrega'];  ?></td>
						    <td><?php echo $row2['TipoTec'];  ?></td>
						    <td><?php echo $row2['ConTec'];  ?></td>
						    <td><?php echo $row2['NoEntrega'];  ?></td>
						    <td><?php 
						 	if($row2['EstadoEntrega']=='0'){
						    	echo "No se entrega";
						    }elseif ($row2['EstadoEntrega']=='1') {
						    	echo "Se entregó";
						    }?></td>
						    <td><?php echo '('.$row2['CausaNoEntrega'].') '.$row2['DESCRIPCION'];  ?></td>
						    <td><?php echo '$ '.number_format($row2['ValorEntregado']);  ?></td>
						    <td><?php echo $row2['CodTecEntregado'];  ?></td>
						    <td><?php echo $row2['CantTotEntregada'];  ?></td>
						    <td><?php echo $row2['NoLote'];  ?></td>
						    <td><?php echo $row2['FecEntrega']->format('d/m/Y'); ?></td>
						    <td><?php echo $row2['FecRepEntrega']->format('d/m/Y'); ?></td>
						    <td><?php echo $row2['FecAnulacion']->format('d/m/Y'); ?></td>
						    <td><?php 
						    if($row2['EstRepEntrega']=='0'){
						    	echo "Anulado";
						    }elseif ($row2['EstRepEntrega']=='1') {
						    	echo "Activo";
						    }elseif ($row2['EstRepEntrega']=='2') {
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
         echo "<BR>\nNo se encuentran reportes de entrega del proveedor para la prescripción \n<BR>";  
      }
   }

?>
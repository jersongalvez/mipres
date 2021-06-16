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
$sql = "SELECT (SELECT DESCRIPCION FROM MIPRES_CAUSAS_NO_ENTREGA WHERE  COD_CAUSA = CausaNoEntrega) DESCRIPCION, ID, IDSuministro, TipoTec, ConTec, NoEntrega, UltEntrega, EntregaCompleta, CausaNoEntrega, CantTotEntregada, NoLote, ValorEntregado, FecSuministro, EstSuministro, FecAnulacion
FROM MIPRES_SUMINISTRO WHERE NOPRESCRIPCION  = '".$NOPRESCRIPCION."' order by FecSuministro desc  ";

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
					    <th>ID SUMINISTRO</th>
					    <th>TIPO TEC.</th>
					    <th>CON. TEC.</th>
					    <th>NO. ENTREGA</th>
					    <th>ULTIMA ENTREGA</th>
					    <th>ENTREGA COMPLETA</th>
					    <th>CAUSA NO ENTREGA</th>
					    <th>CANTIDAD ENTREGADA</th>
					    <th>NO. LOTE</th>
					    <th>VALOR ENTREGADO</th>
					    <th>FEC. SUMINISTRO</th>
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
						    <td><?php echo $row2['IDSuministro'];  ?></td>
						    <td><?php echo $row2['TipoTec'];  ?></td>
						    <td><?php echo $row2['ConTec'];  ?></td>
						    <td><?php echo $row2['NoEntrega'];  ?></td>
						    <td><?php 
						    if($row2['UltEntrega']=='0'){
						    	echo "NO";
						    }else {
						    	echo "SI";
						    }
						    ?></td>
						    <td><?php 
						    if($row2['EntregaCompleta']=='0'){
						    	echo "NO";
						    }else {
						    	echo "SI";
						    } ?></td>
						    <td><?php echo '('.$row2['CausaNoEntrega'].') '.$row2['DESCRIPCION'];  ?></td>
						    <td><?php echo $row2['CantTotEntregada']; ?></td>
						    <td><?php echo $row2['NoLote']; ?></td>
						    <td><?php echo '$ '.number_format($row2['ValorEntregado']); ?></td>
						    <td><?php echo $row2['FecSuministro']->format('d/m/Y'); ?></td>
						    <td><?php echo $row2['FecAnulacion']->format('d/m/Y'); ?></td>
						    <td><?php 
						    if($row2['EstSuministro']=='0'){
						    	echo "Anulado";
						    }elseif ($row2['EstSuministro']=='1') {
						    	echo "Activo";
						    }elseif ($row2['EstSuministro']=='2') {
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
         echo "<BR>\nNo se encuentran reporte de suministro para la prescripción \n<BR>";  
      }
   }

?>
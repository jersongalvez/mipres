<?php
 require_once('../../modelo/conexion-sql.php');
 header("Content-Type: text/html; charset=iso-8859-1");
if ((!empty($_POST['fechainicial'])) and (!empty($_POST['fechafinal']))){
 $fechainicial=$_POST['fechainicial'];
 $fechafinal=$_POST['fechafinal'];



 $sql = "
SELECT
MS.NOPRESCRIPCION,
SUBSTRING(REPORTMIPRES,3,15) REPORTMIPRES, MS.NOPRESCRIPCION, MP.FPRESCRIPCION,
ISNULL(dbo.fnc_mipres_descripcion('PRESCRIPCION','CODAMBATE',CODAMBATE),'NO APLICA') AMBITO,
ISNULL(dbo.fnc_mipres_descripcion('PROCEDIMIENTOS','ESTJM',ESTJM),'NO APLICA') ESTADO_JM,
TIPO, CONORDEN, COD_MIPRES, NOMBRE,
(SELECT IIF(MAX(NoSubEntrega)>MAX(NoEntrega),MAX(NoSubEntrega),MAX(NoEntrega))  FROM MIPRES_DIRECCIONAMIENTOS WHERE NoPrescripcion = MS.NOPRESCRIPCION 
AND EstDireccionamiento <> 0 AND TipoTec	=  MS.TIPOTEC AND ConTec = MS.CONORDEN) NoSubEntrega,
dbo.fnc_ObtenerDireccionamiento(MS.NOPRESCRIPCION,'1',MS.TIPOTEC, MS.CONORDEN) '1_DIRECCIONAMIENTO',
dbo.fnc_ObtenerDireccionamiento(MS.NOPRESCRIPCION,'2',MS.TIPOTEC, MS.CONORDEN) '2_DIRECCIONAMIENTO',
dbo.fnc_ObtenerDireccionamiento(MS.NOPRESCRIPCION,'3',MS.TIPOTEC, MS.CONORDEN) '3_DIRECCIONAMIENTO',
dbo.fnc_ObtenerDireccionamiento(MS.NOPRESCRIPCION,'4',MS.TIPOTEC, MS.CONORDEN) '4_DIRECCIONAMIENTO',
dbo.fnc_ObtenerDireccionamiento(MS.NOPRESCRIPCION,'5',MS.TIPOTEC, MS.CONORDEN) '5_DIRECCIONAMIENTO',
dbo.fnc_ObtenerDireccionamiento(MS.NOPRESCRIPCION,'6',MS.TIPOTEC, MS.CONORDEN) '6_DIRECCIONAMIENTO',
dbo.fnc_ObtenerDireccionamiento(MS.NOPRESCRIPCION,'7',MS.TIPOTEC, MS.CONORDEN) '7_DIRECCIONAMIENTO',
dbo.fnc_ObtenerDireccionamiento(MS.NOPRESCRIPCION,'8',MS.TIPOTEC, MS.CONORDEN) '8_DIRECCIONAMIENTO',
dbo.fnc_ObtenerDireccionamiento(MS.NOPRESCRIPCION,'9',MS.TIPOTEC, MS.CONORDEN) '9_DIRECCIONAMIENTO',
dbo.fnc_ObtenerDireccionamiento(MS.NOPRESCRIPCION,'10',MS.TIPOTEC, MS.CONORDEN) '10_DIRECCIONAMIENTO',
dbo.fnc_ObtenerDireccionamiento(MS.NOPRESCRIPCION,'11',MS.TIPOTEC, MS.CONORDEN) '11_DIRECCIONAMIENTO',
dbo.fnc_ObtenerDireccionamiento(MS.NOPRESCRIPCION,'12',MS.TIPOTEC, MS.CONORDEN) '12_DIRECCIONAMIENTO'
FROM MIPRES_SERVICIOS_PRESCRIPCION MS INNER JOIN [MIPRES_PRESCRIPCION ] MP
ON MS.NOPRESCRIPCION = MP.NOPRESCRIPCION
WHERE FPRESCRIPCION >= '".date("d/m/Y",strtotime($fechainicial))."' AND FPRESCRIPCION <= '".date("d/m/Y",strtotime($fechafinal))."' ORDER BY NoSubEntrega  DESC";

    $params = array();
    $options =  array( "Scrollable" => SQLSRV_CURSOR_KEYSET );
    $stmt = sqlsrv_query( $conn, $sql, $params, $options);
    $row_count = sqlsrv_num_rows( $stmt );
	    if ($row_count == 0){
	    echo "<div class='alert alert-warning alert-dismissible'>";
	    echo "<button type='button' class='close' data-dismiss='alert'>&times;</button>";
	    echo "<strong>Alerta!</strong> No se encuentran resultados.</div>";
	    }  
	    else{
		?>
<br>



<style type="text/css">
table {
  display: block;
  overflow-x: auto;
  max-height: 500px;
}

thead tr th { 
	position: sticky;
	top: 0;
	z-index: 10;
	background-color: #ffffff;
}
</style>
					<table class="table-bordered table-sm" >
				    <thead class="thead-active">
				      <tr>
				        <th>Numero</th>
				        <th>Fecha</th>
				        <th>Reporte</th>
				        <th>Ambito</th>
				        <th>Estado Junta</th>
				        <th>Tecnologia</th>
				        <th>Orden</th>
				        <th>Codigo</th>
				        <th>Descripcion</th>
				        <th>Entregas</th>
				        <th>1_DIRECCIONAMIENTO</th>
				        <th>2_DIRECCIONAMIENTO</th>
				        <th>3_DIRECCIONAMIENTO</th>
				        <th>4_DIRECCIONAMIENTO</th>
				        <th>5_DIRECCIONAMIENTO</th>
				        <th>6_DIRECCIONAMIENTO</th>
				        <th>7_DIRECCIONAMIENTO</th>
				        <th>8_DIRECCIONAMIENTO</th>
				        <th>9_DIRECCIONAMIENTO</th>
				        <th>10_DIRECCIONAMIENTO</th>
				        <th>11_DIRECCIONAMIENTO</th>
				        <th>12_DIRECCIONAMIENTO</th>
				      </tr>
				    </thead>
				    <tbody>
				<?php
	          while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) )  
	          { 

				?>
				      <tr>
				      	<td><small><?php echo $row['NOPRESCRIPCION']; ?></small></td>
				      	<td><small><?php echo $row['FPRESCRIPCION']->format('d/m/Y'); ?></small></td>
				      	<td><small><?php echo $row['REPORTMIPRES']; ?></small></td>
				      	<td><small><?php echo $row['AMBITO']; ?></small></td>
				      	<td><small><?php echo $row['ESTADO_JM']; ?></small></td>
				      	<td><small><?php echo $row['TIPO']; ?></small></td>
				      	<td><small><?php echo $row['CONORDEN']; ?></small></td>
				      	<td><small><?php echo $row['COD_MIPRES']; ?></small></td>
				      	<td><small><?php echo $row['NOMBRE']; ?></small></td>
				      	<td><small><?php echo $row['NoSubEntrega']; ?></small></td>
				      	<td><small><?php echo $row['1_DIRECCIONAMIENTO']; ?></small></td>
				      	<td><small><?php echo $row['2_DIRECCIONAMIENTO']; ?></small></td>
				      	<td><small><?php echo $row['3_DIRECCIONAMIENTO']; ?></small></td>
				      	<td><small><?php echo $row['4_DIRECCIONAMIENTO']; ?></small></td>
				      	<td><small><?php echo $row['5_DIRECCIONAMIENTO']; ?></small></td>
				      	<td><small><?php echo $row['6_DIRECCIONAMIENTO']; ?></small></td>
				      	<td><small><?php echo $row['7_DIRECCIONAMIENTO']; ?></small></td>
				      	<td><small><?php echo $row['8_DIRECCIONAMIENTO']; ?></small></td>
				      	<td><small><?php echo $row['9_DIRECCIONAMIENTO']; ?></small></td>
				      	<td><small><?php echo $row['10_DIRECCIONAMIENTO']; ?></small></td>
				      	<td><small><?php echo $row['11_DIRECCIONAMIENTO']; ?></small></td>
				      	<td><small><?php echo $row['12_DIRECCIONAMIENTO']; ?></small></td>
				      </tr>
				<?php
	          }
	          ?>
	          	</tbody>
				</table>
			  <?php  
	        }
    sqlsrv_free_stmt($stmt); 



}else{
echo "<div class='alert alert-danger alert-dismissible'>";
echo "<button type='button' class='close' data-dismiss='alert'>&times;</button>";
echo "<strong>Alerta!</strong> Debe de diligenciar todos los campos</div>";
}



?>




<br>










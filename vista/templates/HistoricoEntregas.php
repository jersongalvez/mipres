<?php
 require_once('../../modelo/conexion-sql.php');
 header("Content-Type: text/html; charset=iso-8859-1");


if (!empty($_POST['NoPrescripcion']) and !empty($_POST['TipoTec'])  and !empty($_POST['ConTec'])  ){
$NoPrescripcion=$_POST['NoPrescripcion'];
$TipoTec=$_POST['TipoTec'];
$ConTec=$_POST['ConTec'];

$sql = "SELECT ID, IDDireccionamiento, NoEntrega, NoSubEntrega, FecMaxEnt, CantTotAEntregar, FecDireccionamiento  
FROM MIPRES_DIRECCIONAMIENTOS D
WHERE NoPrescripcion = '".$NoPrescripcion."' 
AND TipoTec = '".$TipoTec."' 
AND ConTec = '".$ConTec."' 
AND EstDireccionamiento <> '0'
ORDER BY NoPrescripcion DESC, NoSubEntrega ASC";

    $params = array();
    $options =  array( "Scrollable" => SQLSRV_CURSOR_KEYSET );
    $stmt = sqlsrv_query( $conn, $sql, $params, $options);
    $row_count = sqlsrv_num_rows( $stmt );
	    if ($row_count == 0){
	    echo "<div class='alert alert-warning alert-dismissible'>";
	    echo "<button type='button' class='close' data-dismiss='alert'>&times;</button>";
	    echo "Sin historial de Direccionamientos previos.</div>";
	    }  
	    else{
		?>
			  	<div class="table-responsive" id="tabla_autorizaciones">
					<table class="table table-hover table-sm">
				    <thead class="thead-active">
				      <tr>
				        <th><small><strong>ID</strong></small></th>
				        <th><small><strong>Direccionamiento</strong></small></th>
				        <th><small><strong>Entrega</strong></small></th>
				        <th><small><strong>Fec. MaxEnt</strong></small></th>
				        <th><small><strong>Cantidad</strong></small></th>
				        <th><small><strong>Fec. Direc</strong></small></th>
				      </tr>
				    </thead>
				    <tbody>
				<?php
	          while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) )  
	          { 

				?>
				      <tr>
				        <td><small><?php echo $row['ID']; ?></small></td>
				        <td><small><?php echo $row['IDDireccionamiento']; ?></small></td>
				        <td><small><?php echo $row['NoEntrega']."/".$row['NoSubEntrega']; ?></small></td>
				        <td><small><?php echo $row['FecMaxEnt']->format('d/m/Y'); ?></small></td>
				        <td><small><?php echo $row['CantTotAEntregar']; ?></small></td>
				        <td><small><?php echo $row['FecDireccionamiento']->format('d/m/Y'); ?></small></td>
				      </tr>
				<?php
	          }
	          ?>
	          	</tbody>
				</table>
				</div>
			  <?php  
	        }
    sqlsrv_free_stmt($stmt); 



}else{
echo "<div class='alert alert-danger alert-dismissible'>";
echo "<button type='button' class='close' data-dismiss='alert'>&times;</button>";
echo "<strong>Alerta!</strong> Relacione el servicio del Direccionamiento.</div>";
}



?>

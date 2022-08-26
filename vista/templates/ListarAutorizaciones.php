<?php
 require_once('../../modelo/conexion-sql.php');
 header("Content-Type: text/html; charset=iso-8859-1");
if ((!empty($_POST['var_TI'])) and (!empty($_POST['var_NI']))){
$var_TI=$_POST['var_TI'];
$var_NI=$_POST['var_NI'];
  
    $sql = "SELECT * FROM AUTORIZACION AU INNER JOIN SERVICIOS_AUTORIZADOS SE ON AU.NO_SOLICITUD = SE.NO_SOLICITUD WHERE CAUSA_EXTERNA IN ('11', '12') AND TP_IDENT_AFILIA ='".$var_TI."' AND NR_IDENT_AFILIA = '".$var_NI."' ORDER BY FEC_AUTORIZACION DESC ";
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
		<div class="card shadow" id="global">
		<div id="mensajes">
		<div class="texto">
				  	<div class="table-responsive" id="tabla_autorizaciones">
					<table class="table table-hover table-sm">
				    <thead class="thead-active">
				      <tr>
				        <th><small><strong>Fecha</strong></small></th>
				        <th><small><strong>Entrega</strong></small></th>
				        <th><small><strong>Solicitud</strong></small></th>
				        <th><small><strong>Estado</strong></small></th>
				        <th><small><strong>Prescripcion</strong></small></th>
				        <th><small><strong>Codigo</strong></small></th>
				        <th><small><strong>Servicio</strong></small></th>
				        <th><small><strong>Direccionamiento</strong></small></th>
				        <th></th>
				      </tr>
				    </thead>
				    <tbody>
				<?php
	          while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) )  
	          { 

				?>
				      <tr>
				        <td><small><?php echo $row['FEC_AUTORIZACION']->format('d/m/Y'); ?></small></td>
				        <td><small><?php echo $row['SECUENCIA']."/".$row['NUM_ENTREGAS']; ?></small></td>
				        <td><small><?php echo $row['NO_SOLICITUD']; ?></small></td>
				        <td><small><?php echo $row['ESTADO']; ?></small></td>
				        <td><small><?php echo $row['NUM_COMITECTC']; ?></small></td>
				        <td><small><?php echo $row['CD_SERVICIO']; ?></small></td>
				        <td><small><?php echo $row['OBSERVACION']; ?></small></td>
						<td>
						<?php
						if (($row['IDDIRECCIONAMIENTO']==NULL) and ($row['ESTADO']<>'AN') and ($row['ESTADO']<>'CO') ) {
					    ?>
						<form class="" action="index.php?x=008" method="post" >
						<input type="hidden" class="form-control" id="NO_SOLICITUD" name="NO_SOLICITUD" value="<?php echo $row['NO_SOLICITUD']; ?>">
						<input type="hidden" class="form-control" id="NUM_COMITECTC" name="NUM_COMITECTC" value="<?php echo $row['NUM_COMITECTC']; ?>">
						<input type="hidden" class="form-control" id="TABLA" name="TABLA" value="<?php echo $row['TABLA']; ?>">
						<input type="hidden" class="form-control" id="CD_SERVICIO" name="CD_SERVICIO" value="<?php echo $row['CD_SERVICIO']; ?>">
						<button class="btn btn-outline-dark btn-block" type="submit">Ir</button>
						</form>
						<?php
						}else{
						echo "<small>".$row['IDDIRECCIONAMIENTO']."</small>";
						}
						?>
						</td>
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
echo "<strong>Alerta!</strong> Debe de diligenciar todos los campos</div>";
}



?>

</div>
</div>
</div>
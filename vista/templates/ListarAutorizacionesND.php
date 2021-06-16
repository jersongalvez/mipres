<?php
 require_once('../../modelo/conexion-sql.php');
 header("Content-Type: text/html; charset=iso-8859-1");
if ((!empty($_POST['var_TI'])) and (!empty($_POST['var_NI']))){
$var_TI=$_POST['var_TI'];
$var_NI=$_POST['var_NI'];
//echo $var_TI;
//echo $var_NI;

  
    $sql = "SELECT * FROM [MIPRES_PRESCRIPCION ] WHERE TIPOIDPACIENTE = '".$var_TI."' AND NROIDPACIENTE = '".$var_NI."' ORDER BY FPRESCRIPCION DESC";
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
				  	<div class="table-responsive" id="tabla_autorizaciones">
					<table class="table table-hover table-sm">
				    <thead class="thead-active">
				      <tr>
				        <th><small><strong>Prescripcion</strong></small></th>
				        <th><small><strong>Fecha</strong></small></th>
				        <th><small><strong>IPS</strong></small></th>
				        <th><small><strong>Municipio</strong></small></th>				        
				        <th><small><strong></strong></small></th>
				        <th></th>
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
				        <td><small><?php echo NombrePrestador($conn,$row['NROIDIPS']); ?></small></td>
				        <td><small><?php echo NombreMunicipio($conn,$row['CODDANEMUNIPS']); ?></small></td>		      
						<td><button class="btn btn-outline-dark btn-block" type="submit" onclick="javascript:ServiciosSolicitados('<?php echo $row['NOPRESCRIPCION']; ?>','<?php echo $var_TI; ?>','<?php echo $var_NI; ?>');">Servicios</button></td>
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



  <!-- The Modal -->
  <div class="modal fade" data-backdrop="static" id="Ven_Direccionamiento">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
      
        <!-- Modal Header -->
        <div class="modal-header">
          <h5 class="modal-title" id="titulo_modal"></h5>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        
        <!-- Modal body -->
        <div class="modal-body">     
		<div id="DataDireccionamiento"></div>
        </div>
        
        <!-- Modal footer -->
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
        </div>
        
      </div>
    </div>
  </div>


<script language="javascript">

function ServiciosSolicitados(NOPRESCRIPCION,TI,NI){ 
document.getElementById('DataDireccionamiento').innerHTML = "<center><div class='spinner-border text-success'></div></center>";
$('#Ven_Direccionamiento').modal('show');
var NUM_COMITECTC = NOPRESCRIPCION; 
var TI = TI; 
var NI = NI;   
document.getElementById('titulo_modal').innerHTML = 'Servicios solicitados en '+NOPRESCRIPCION; 
$.post("vista/templates/ServiciosSolicitadosND.php", {NOPRESCRIPCION: NOPRESCRIPCION, TI:TI, NI:NI}, function(data){
$("#DataDireccionamiento").html(data);
}); 
}

</script>
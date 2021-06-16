<?php
 require_once('../../modelo/conexion-sql.php');
 header("Content-Type: text/html; charset=iso-8859-1");
if ((!empty($_POST['fechainicial'])) and (!empty($_POST['fechafinal']))){
 $fechainicial=$_POST['fechainicial'];
 $fechafinal=$_POST['fechafinal'];



 $sql = "SELECT SUBSTRING(REPORTMIPRES,3,15) REPORTMIPRES, TABLA, CODAMBATE, ISNULL(dbo.fnc_mipres_descripcion('PRESCRIPCION','CODAMBATE',CODAMBATE),'NO APLICA') AMBITO,FEC_AUTORIZA, NUM_ENTREGAS, SECUENCIA, FEC_AUTORIZACION, AU.NO_SOLICITUD, NUM_COMITECTC, CD_SERVICIO, OBSERVACION, TP_IDENT_AFILIA+' '+NR_IDENT_AFILIA AS TIP, PRI_NOMBRE+' '+SEG_NOMBRE+' '+PRI_APELLIDO+' '+SEG_APELLIDO AS NOM FROM AUTORIZACION AU INNER JOIN SERVICIOS_AUTORIZADOS SE  ON AU.NO_SOLICITUD = SE.NO_SOLICITUD INNER JOIN MIPRES_PRESCRIPCION MP ON MP.NOPRESCRIPCION =  NUM_COMITECTC WHERE CAUSA_EXTERNA IN ('11', '12') AND CODAMBATE NOT IN ('22','30') AND  ESTADO = 'AU' AND ((FEC_AUTORIZA >= '".date("d/m/Y",strtotime($fechainicial))."' AND FEC_AUTORIZA <= '".date("d/m/Y",strtotime($fechafinal))."') OR (FEC_AUTORIZACION >= '".date("d/m/Y",strtotime($fechainicial))."' AND FEC_AUTORIZACION <= '".date("d/m/Y",strtotime($fechafinal))."')) AND SE.IDDIRECCIONAMIENTO IS NULL ORDER BY FEC_AUTORIZA DESC, PRI_NOMBRE ASC, SOL_RELACIONADA DESC, SECUENCIA ASC ";

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
<input type="text" id="myInput" onkeyup="myFunction()" placeholder="Buscar por nombre..." title="Buscar por Nombre">

		<div id="global">
		<div id="mensajes">
		<div class="texto">
				  	<div class="table-responsive" id="tabla_autorizaciones">
					<table class="table table-hover table-sm" id="myTable">
				    <thead class="thead-active">
				      <tr>
				      	<th><small><strong>Reporte</strong></small></th>
				      	<th><small><strong>Ambito</strong></small></th>
				      	<th><small><strong>Digitacion</strong></small></th>
				      	<th><small><strong>Entrega</strong></small></th>
				        <th><small><strong>Fecha Aut</strong></small></th>
				        <th><small><strong>Solicitud</strong></small></th>
				        <th><small><strong>Prescripcion</strong></small></th>
				        <th></th>
				      </tr>
				    </thead>
				    <tbody>
				<?php
	          while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) )  
	          { 

				?>
				      <tr>
				      	<td><small><?php echo $row['REPORTMIPRES']; ?></small></td>
				      	<td><small><?php echo $row['AMBITO']; ?></small></td>
				      	<td><small><?php echo $row['FEC_AUTORIZA']->format('d/m/Y'); ?></small></td>
				      	<td><small><?php echo $row['SECUENCIA']."/".$row['NUM_ENTREGAS']; ?></small></td>
				        <td><small><?php echo $row['FEC_AUTORIZACION']->format('d/m/Y'); ?></small></td>
				        <td><small><?php echo $row['NO_SOLICITUD']; ?></small></td>
				        <td><small><?php echo $row['NUM_COMITECTC']; ?></small></td>			        
						<td>
						<form class="" action="index.php?x=008" method="post" >
						<input type="hidden" class="form-control" id="NO_SOLICITUD" name="NO_SOLICITUD" value="<?php echo $row['NO_SOLICITUD']; ?>">
						<input type="hidden" class="form-control" id="NUM_COMITECTC" name="NUM_COMITECTC" value="<?php echo $row['NUM_COMITECTC']; ?>">
						<input type="hidden" class="form-control" id="TABLA" name="TABLA" value="<?php echo $row['TABLA']; ?>">
						<input type="hidden" class="form-control" id="CD_SERVICIO" name="CD_SERVICIO" value="<?php echo $row['CD_SERVICIO']; ?>">
						<button class="btn btn-outline-dark btn-block" type="submit">Ir</button>  
						</form>
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




<style>
* {
  box-sizing: border-box;
}

#myInput {
  background-image: url('/css/searchicon.png');
  background-position: 10px 10px;
  background-repeat: no-repeat;
  width: 100%;
  font-size: 16px;
  padding: 12px 20px 12px 40px;
  border: 1px solid #ddd;
  margin-bottom: 12px;
}

#myTable {
  border-collapse: collapse;
  width: 100%;
  border: 1px solid #ddd;
  font-size: 18px;
}

#myTable th, #myTable td {
  text-align: left;
  padding: 12px;
}

#myTable tr {
  border-bottom: 1px solid #ddd;
}

#myTable tr.header, #myTable tr:hover {
  background-color: #f1f1f1;
}
</style>



<script>
function myFunction() {
  var input, filter, table, tr, td, i, txtValue;
  input = document.getElementById("myInput");
  filter = input.value.toUpperCase();
  table = document.getElementById("myTable");
  tr = table.getElementsByTagName("tr");
  for (i = 0; i < tr.length; i++) {
    td = tr[i].getElementsByTagName("td")[2];
    if (td) {
      txtValue = td.textContent || td.innerText;
      if (txtValue.toUpperCase().indexOf(filter) > -1) {
        tr[i].style.display = "";
      } else {
        tr[i].style.display = "none";
      }
    }       
  }
}


</script>






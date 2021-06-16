<?php
$file="Direccionamientos ".$_POST['fechainicial']." - ".$_POST['fechafinal'].".xls";
header("Content-Type: application/vnd.ms-excel charset=iso-8859-1");
header("Content-Disposition: attachment; filename=$file");

 require_once('../../modelo/conexion-sql.php');
if ((!empty($_POST['fechainicial'])) and (!empty($_POST['fechafinal']))){
 $fechainicial=$_POST['fechainicial'];
 $fechafinal=$_POST['fechafinal'];
 
$sql = "
SELECT * FROM MIPRES_DIRECCIONAMIENTOS
WHERE  
FecDireccionamiento >= '".date("d/m/Y",strtotime($fechainicial))."'
AND FecDireccionamiento <= '".date("d/m/Y",strtotime($fechafinal))."'
ORDER BY FecDireccionamiento DESC";


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
 <div class="table-responsive" id="tabla_autorizaciones" >
					<table class="table table-hover table-sm" border="1">
				    <thead class="thead-active">
				      <tr>
				        <th><small><strong>ID</strong></small></th>
				        <th><small><strong>IDDireccionamiento</strong></small></th>
				        <th><small><strong>NoPrescripcion.</strong></small></th>
				        <th><small><strong>TipoTec</strong></small></th>
				        <th><small><strong>ConTec</strong></small></th>
				        <th><small><strong>TipoIDPaciente</strong></small></th>
				        <th><small><strong>NoIDPaciente</strong></small></th>
				        <th><small><strong>NombrePaciente</strong></small></th>
				        <th><small><strong>NoEntrega</strong></small></th>
				        <th><small><strong>NoSubEntrega</strong></small></th>
				        <th><small><strong>TipoIDProv</strong></small></th>
				        <th><small><strong>NoIDProv</strong></small></th>
				        <th><small><strong>CodMunEnt</strong></small></th>
				        <th><small><strong>FecMaxEnt</strong></small></th> 
				        <th><small><strong>CodSerTecAEntregar</strong></small></th>
				        <th><small><strong>CantTotAEntregar</strong></small></th>
				        <th><small><strong>NoIDEPS</strong></small></th>
				        <th><small><strong>CodEPS</strong></small></th>
				        <th><small><strong>FecDireccionamiento</strong></small></th>
				        <th><small><strong>EstDireccionamiento</strong></small></th>
				        <th><small><strong>FecAnulacion</strong></small></th>
				        <th><small><strong>FechaIngreso</strong></small></th>
				        <th><small><strong>No_Solicitud_Aut</strong></small></th>
				        <th><small><strong>Fecha_Aut.</strong></small></th>
				        <th><small><strong>Digitacion_Aut.</strong></small></th>
				        <th><small><strong>No_Autorizacion</strong></small></th>
				        <th><small><strong>Estado_Aut.</strong></small></th>
				        <th><small><strong>Nit_Prestador_Aut.</strong></small></th>
				        <th><small><strong>Nom_Prestador_Aut</strong></small></th>
				        <th><small><strong>Regimen_Aut</strong></small></th>
				        <th><small><strong>No_Entregas_Aut</strong></small></th>
				        <th><small><strong>No_Secuencia_Aut</strong></small></th>
				        <th><small><strong>Cod_Servicio_Aut</strong></small></th>
				        <th><small><strong>Des_Servicio_Aut</strong></small></th>
				        <th><small><strong>Cantidad_Aut</strong></small></th>
				      </tr>
				    </thead>
				    <tbody>
				<?php
while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) )  
{ 

$sql2 = "
SELECT 
AU.NO_SOLICITUD,
AU.FEC_AUTORIZACION,
AU.FEC_AUTORIZA,
AU.NO_AUTORIZACION,
AU.ESTADO ESTADO_AUT,
AU.NR_IDENT_PREST_IPS NIT_PRESTADOR, 
(SELECT NOM_PRESTADOR FROM PRESTADORES WHERE NIT_PRESTADOR = AU.NR_IDENT_PREST_IPS) NOM_PRESTADOR,
AU.TIP_REGIMEN REGIMEN,
AU.NUM_ENTREGAS NUM_ENTREGAS_AUT,
AU.SECUENCIA SECUENCIA_AUT,
SE.CD_SERVICIO COD_SERVICIO, 
SE.OBSERVACION DESCRIPCION, 
SE.CANTIDAD
FROM  AUTORIZACION AU
INNER JOIN SERVICIOS_AUTORIZADOS SE
ON AU.NO_SOLICITUD = SE.NO_SOLICITUD
WHERE AU.NUM_COMITECTC = '".$row['NoPrescripcion']."'
AND SE.IDENTIFICADOR = '".$row['ID']."'
AND AU.CAUSA_EXTERNA IN ('11', '12')
 ";
    $params2 = array();
    $options2 =  array( "Scrollable" => SQLSRV_CURSOR_KEYSET );
    $stmt2 = sqlsrv_query( $conn, $sql2, $params2, $options2);
    $row_count2 = sqlsrv_num_rows( $stmt2 );
      if ($row_count2 == 0){
echo  "<tr>
	      	<td>".$row['ID']."</td>	
	      	<td>".$row['IDDireccionamiento']."</td>	
	      	<td>[".$row['NoPrescripcion']."]</td>	
	      	<td>".$row['TipoTec']."</td>	
	      	<td>".$row['ConTec']."</td>	
	      	<td>".$row['TipoIDPaciente']."</td>	
	      	<td>".$row['NoIDPaciente']."</td>
	      	<td>".NombreAfiliado($conn,$row['TipoIDPaciente'],$row['NoIDPaciente'])."</td>	
	      	<td>".$row['NoEntrega']."</td>	
	      	<td>".$row['NoSubEntrega']."</td>	
	      	<td>".$row['TipoIDProv']."</td>	
	      	<td>".$row['NoIDProv']."</td>	
	      	<td>".$row['CodMunEnt']."</td>	
	      	<td>".$row['FecMaxEnt']->format('d/m/Y')."</td>	
	      	<td>".$row['CodSerTecAEntregar']."</td>
	      	<td>".$row['CantTotAEntregar']."</td>		
	      	<td>".$row['NoIDEPS']."</td>	
	      	<td>".$row['CodEPS']."</td>	
	      	<td>".$row['FecDireccionamiento']->format('d/m/Y')."</td>	
	      	<td>".$row['EstDireccionamiento']."</td>	
	      	<td>".$row['FecAnulacion']->format('d/m/Y')."</td>	
	      	<td>".$row['FechaIngreso']->format('d/m/Y')."</td>
	        <td></td>
	      	<td></td>
	      	<td></td>
	      	<td></td>
	      	<td></td>
	      	<td></td>
	      	<td></td>
	      	<td></td>
	      	<td></td>
	      	<td></td>
	      	<td></td>
	      	<td></td>
	      	<td></td>	
	      	</tr>		        
	";     
      }  
      else{
      	 while( $row2 = sqlsrv_fetch_array( $stmt2, SQLSRV_FETCH_ASSOC) )  
            { 

echo  "<tr>
	      	<td>".$row['ID']."</td>	
	      	<td>".$row['IDDireccionamiento']."</td>	
	      	<td>[".$row['NoPrescripcion']."]</td>	
	      	<td>".$row['TipoTec']."</td>	
	      	<td>".$row['ConTec']."</td>	
	      	<td>".$row['TipoIDPaciente']."</td>	
	      	<td>".$row['NoIDPaciente']."</td>
	      	<td>".NombreAfiliado($conn,$row['TipoIDPaciente'],$row['NoIDPaciente'])."</td>	
	      	<td>".$row['NoEntrega']."</td>	
	      	<td>".$row['NoSubEntrega']."</td>	
	      	<td>".$row['TipoIDProv']."</td>	
	      	<td>".$row['NoIDProv']."</td>	
	      	<td>".$row['CodMunEnt']."</td>	
	      	<td>".$row['FecMaxEnt']->format('d/m/Y')."</td>	
	      	<td>".$row['CodSerTecAEntregar']."</td>	
	        <td>".$row['CantTotAEntregar']."</td>	
	      	<td>".$row['NoIDEPS']."</td>	
	      	<td>".$row['CodEPS']."</td>	
	      	<td>".$row['FecDireccionamiento']->format('d/m/Y')."</td>	
	      	<td>".$row['EstDireccionamiento']."</td>	
	      	<td>".$row['FecAnulacion']->format('d/m/Y')."</td>	
	      	<td>".$row['FechaIngreso']->format('d/m/Y')."</td>
	        <td>[".$row2['NO_SOLICITUD']."]</td>
	      	<td>".$row2['FEC_AUTORIZACION']->format('d/m/Y')."</td>
	      	<td>".$row2['FEC_AUTORIZA']->format('d/m/Y')."</td>
	      	<td>[".$row2['NO_AUTORIZACION']."]</td>
	      	<td>".$row2['ESTADO_AUT']."</td>
	      	<td>[".$row2['NIT_PRESTADOR']."]</td>
	      	<td>".$row2['NOM_PRESTADOR']."</td>
	      	<td>".$row2['REGIMEN']."</td>
	      	<td>".$row2['NUM_ENTREGAS_AUT']."</td>
	      	<td>".$row2['SECUENCIA_AUT']."</td>
	      	<td>".$row2['COD_SERVICIO']."</td>
	      	<td>".$row2['DESCRIPCION']."</td>
	      	<td>".$row2['CANTIDAD']."</td>	
	      	</tr>		        
	";

}  
}


}
}	           
?>
	          	</tbody>
				</table>
				</div>
			  <?php 



}



?>



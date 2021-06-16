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
error_reporting(0);
require_once('../../../modelo/conexion-sql.php');
$NOPRESCRIPCION = trim($_POST["NOPRESCRIPCION"]);
$sql = "SELECT NOPRESCRIPCION, FPRESCRIPCION, HPRESCRIPCION, CODHABIPS, TIPOIDIPS, NROIDIPS, CODDANEMUNIPS, DIRSEDEIPS, TELSEDEIPS, TIPOIDPROF, NUMIDPROF, PNPROFS, SNPROFS, PAPROFS, SAPROFS, 
                         REGPROFS, TIPOIDPACIENTE, NROIDPACIENTE, PNPACIENTE, SNPACIENTE, PAPACIENTE, SAPACIENTE, CODAMBATE, ENFHUERFANA, CODENFHUERFANA, CODDXPPAL, CODDXREL1, CODDXREL2, SOPNUTRICIONAL, 
                         CODEPS, TIPOIDMADREPACIENTE, NROIDMADREPACIENTE, TIPOTRANSC, TIPOIDDONANTEVIVO, NROIDDONANTEVIVO, ESTPRES, MIDORDENITEM, USU_CARGUE, FEC_CRUCE, MIP_NO_SOLICITUD, MIP_OBSERVACIONES, 
                         MIP_ESTADO, NroFallo, FFalloTutela, F1Instan, F2Instan, FCorte, FDesacato, AclFalloTut, CodDxMotS1, CodDxMotS2, CodDxMotS3, CritDef1CC, CritDef2CC, CritDef3CC, CritDef4CC, EstTut, IIF(REPORTMIPRES='NOPRESCRIPCION','PRESCRIPCION','TUTELA') REPORTMIPRES , FFALLOADIC, 
                         NROFALLOADIC, JUSTIFMED, REGIMEN, REFAMBATE, PACCOVID19
FROM            [MIPRES_PRESCRIPCION ] WHERE NOPRESCRIPCION   = '".$NOPRESCRIPCION."'  ";

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
					  	    <th>REPORTE</th>
						    <th>NOPRESCRIPCION</th>
						    <th>FPRESCRIPCION</th>
						    <th>HPRESCRIPCION</th>
						    <th>CODHABIPS</th>
						    <th>TIPOIDIPS</th>
						    <th>NROIDIPS</th>
						    <th>DIRSEDEIPS</th>
						    <th>TELSEDEIPS</th>
						    <th>IDENTIFICACIÓN PROFESIONAL</th>
						    <th>NOMBRE PROFESIONAL</th>
						    <th>REGPROFS</th>
							<th>IDENTIFICACIÓN PACIENTE</th>
						    <th>NOMBRE PACIENTE</th>
						    <th>CODAMBATE</th>
						    <th>REFAMBATE</th>
						    <th>PACCOVID19</th>
						    <th>ENFHUERFANA</th>
						    <th>CODDXPPAL</th>
						    <th>CODDXREL1</th>
						    <th>CODDXREL2</th>
						    <th>SOPNUTRICIONAL</th>
						    <th>CODEPS</th>
						    <th>TIPOIDMADREPACIENTE</th>
						    <th>NROIDMADREPACIENTE</th>
						    <th>TIPOTRANSC</th>
						    <th>TIPOIDDONANTEVIVO</th>
						    <th>NROIDDONANTEVIVO</th>
						    <th>ESTPRES</th>
						    <th>MIP_NO_SOLICITUD</th>
						    <th>MIP_OBSERVACIONES</th>
						    <th>MIP_ESTADO</th>
						    <th>NROFALLO</th>
						    <th>FFALLOTUTELA</th>
						    <th>F1INSTAN</th>
						    <th>F2INSTAN</th>
						    <th>FCORTE</th>
						    <th>FDESACATO</th>
						    <th>ACLFALLOTUT</th>
						    <th>CODDXMOTS1</th>
						    <th>CODDXMOTS2</th>
						    <th>CODDXMOTS3</th>
						    <th>CRIthEF1CC</th>
						    <th>CRIthEF2CC</th>
						    <th>CRIthEF3CC</th>
						    <th>CRIthEF4CC</th>
						    <th>ESTTUT</th>
						    <th>FFALLOADIC</th>
						    <th>NROFALLOADIC</th>
						    <th>JUSTIFMED</th>
						    <th>REGIMEN</th>
						  </tr>
					</thead>
					<tbody>
<?php
						while( $row2 = sqlsrv_fetch_array( $stmt2, SQLSRV_FETCH_ASSOC))  
						{  
?>
						  <tr>
						    <td><?php echo $row2['REPORTMIPRES'];  ?></td>
						    <td><?php echo $row2['NOPRESCRIPCION'];  ?></td>
						    <td><?php echo $row2['FPRESCRIPCION']->format('d/m/Y');  ?></td>
						    <td><?php echo $row2['HPRESCRIPCION'];  ?></td>
						    <td><?php echo $row2['CODHABIPS'];  ?></td>
						    <td><?php echo $row2['TIPOIDIPS'];  ?></td>
						    <td><?php echo $row2['NROIDIPS'];  ?></td>
						    <td><?php echo $row2['DIRSEDEIPS'];  ?></td>
						    <td><?php echo $row2['TELSEDEIPS'];  ?></td>
						    <td><?php echo $row2['TIPOIDPROF'].' '.$row2['NUMIDPROF'];  ?></td>
						    <td><?php echo utf8_encode($row2['PNPROFS']).' '.utf8_encode($row2['SNPROFS']).' '.utf8_encode($row2['PAPROFS']).' '.utf8_encode($row2['SAPROFS']);  ?></td>
						    <td><?php echo $row2['REGPROFS'];  ?></td>
						    <td><?php echo $row2['TIPOIDPACIENTE'].' '.$row2['NROIDPACIENTE'];  ?></td>
						    <td><?php echo utf8_encode($row2['PNPACIENTE']).' '.utf8_encode($row2['SNPACIENTE']).' '.utf8_encode($row2['PAPACIENTE']).' '.utf8_encode($row2['SAPACIENTE']);  ?></td>
						    <td><?php echo utf8_encode(ValorRefMipres($conn,'PRESCRIPCION','CODAMBATE',$row2['CODAMBATE']));  ?></td>
						    <td><?php echo SiNoRefMipres($row2['REFAMBATE']);  ?></td>
						    <td><?php echo SiNoRefMipres($row2['PACCOVID19']);  ?></td>
						    <td><?php echo SiNoRefMipres($row2['ENFHUERFANA']);  ?></td>
						    <td><?php echo $row2['CODDXPPAL'];  ?></td>
						    <td><?php echo $row2['CODDXREL1'];  ?></td>
						    <td><?php echo $row2['CODDXREL2'];  ?></td>
						    <td><?php echo SiNoRefMipres($row2['SOPNUTRICIONAL']);  ?></td>
						    <td><?php echo $row2['CODEPS'];  ?></td>
						    <td><?php echo $row2['TIPOIDMADREPACIENTE'];  ?></td>
						    <td><?php echo $row2['NROIDMADREPACIENTE'];  ?></td>
						    <td><?php echo utf8_encode(ValorRefMipres($conn,'PRESCRIPCION','TIPOTRANSC',$row2['TIPOTRANSC']));  ?></td>
						    <td><?php echo $row2['TIPOIDDONANTEVIVO'];  ?></td>
						    <td><?php echo $row2['NROIDDONANTEVIVO'];  ?></td>
						    <td><?php echo ValorRefMipres($conn,'PRESCRIPCION','ESTPRES',$row2['ESTPRES']);  ?></td>
						    <td><?php echo $row2['MIP_NO_SOLICITUD'];  ?></td>
						    <td><?php echo $row2['MIP_OBSERVACIONES'];  ?></td>
						    <td><?php echo $row2['MIP_ESTADO'];  ?></td>
						    <td><?php echo $row2['NroFallo'];  ?></td>
						    <td><?php echo $row2['FFalloTutela']->format('d/m/Y');  ?></td>
						    <td><?php echo $row2['F1Instan']->format('d/m/Y');  ?></td>
						    <td><?php echo $row2['F2Instan']->format('d/m/Y');  ?></td>
						    <td><?php echo $row2['FCorte']->format('d/m/Y');  ?></td>
						    <td><?php echo $row2['FDesacato']->format('d/m/Y');  ?></td>
						    <td><?php echo $row2['AclFalloTut'];  ?></td>
						    <td><?php echo $row2['CodDxMotS1'];  ?></td>
						    <td><?php echo $row2['CodDxMotS2'];  ?></td>
						    <td><?php echo $row2['CodDxMotS3'];  ?></td>
						    <td><?php echo $row2['CritDef1CC'];  ?></td>
						    <td><?php echo $row2['CritDef2CC'];  ?></td>
						    <td><?php echo $row2['CritDef3CC'];  ?></td>
						    <td><?php echo $row2['CritDef4CC'];  ?></td>
						    <td><?php echo $row2['EstTut'];  ?></td>
						    <td><?php echo $row2['FFALLOADIC'];  ?></td>
						    <td><?php echo $row2['NROFALLOADIC'];  ?></td>
						    <td><?php echo $row2['JUSTIFMED'];  ?></td>
						    <td><?php echo $row2['REGIMEN'];  ?></td>
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
         echo "<BR>\nNo se encuentran novedades para la prescripción \n<BR>";  
      }
   }

?>
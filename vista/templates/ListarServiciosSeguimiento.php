<?php
set_time_limit(10000000);
$file="ServiciosPrescritos ".$_POST['fechainicial']." - ".$_POST['fechafinal'].".xls";
header("Content-Type: application/vnd.ms-excel charset=iso-8859-1");
header("Content-Disposition: attachment; filename=$file");

 require_once('../../modelo/conexion-sql.php');
if ((!empty($_POST['fechainicial'])) and (!empty($_POST['fechafinal']))){
 $fechainicial=$_POST['fechainicial'];
 $fechafinal=$_POST['fechafinal'];
 
  $sql = "
DECLARE @FecInicial Date = '".date("d/m/Y",strtotime($fechainicial))."'
DECLARE @FecFinal Date = '".date("d/m/Y",strtotime($fechafinal))."' 
--- PROCEDIMENTOS
SELECT
  M.NOPRESCRIPCION,
  M.FPRESCRIPCION,
  M.NROIDIPS,
  (SELECT
    NOM_PRESTADOR
  FROM PRESTADORES
  WHERE NIT_PRESTADOR = M.NROIDIPS)
  AS NOMIDIPS,
  M.CODDANEMUNIPS,
  M.CODHABIPS,
  M.REPORTMIPRES,
  M.CODAMBATE,
  M.CODEPS,
  M.ESTPRES,
  M.ESTTUT,
  M.TIPOIDPROF,
  M.NUMIDPROF,
  M.PNPROFS,
  M.SNPROFS,
  M.PAPROFS,
  M.SAPROFS,
  M.REGPROFS,
  M.TIPOIDPACIENTE,
  M.NROIDPACIENTE,
  M.PNPACIENTE,
  M.SNPACIENTE,
  M.PAPACIENTE,
  M.SAPACIENTE,
  M.CODDXPPAL,
  M.CODDXREL1,
  M.CODDXREL2,
  --(SELECT  TOP 1 FEC_NACIMIENTO FROM AFILIADOSSUB WHERE TIP_DOCUMENTO_BEN+NUM_DOCUMENTO_BEN = M.TIPOIDPACIENTE+M.NROIDPACIENTE AND EST_AFILIADO = '1') FEC_NACIMIENTO,
  --(SELECT  TOP 1 SEXO FROM AFILIADOSSUB WHERE TIP_DOCUMENTO_BEN+NUM_DOCUMENTO_BEN = M.TIPOIDPACIENTE+M.NROIDPACIENTE AND EST_AFILIADO = '1') SEXO,
  'P' SER_TEC,
  P.CONORDEN,
  P.TIPOPREST,
  P.CODCUPS CODIGO,
  ISNULL((SELECT TOP 1
    DESCRIPCION
  FROM PROCEDIMIENTOS
  WHERE EST_PROCEDIMIENTO = '0'
  AND CODIGO = P.CODCUPS), 'VALOR NO PARAMETRIZADO - TABLAS DE REFERENCIA') AS DESCRIPCION,
  P.CANTTOTAL,
  (SELECT TOP 1
    IDNODIRECCIONAMIENTO
  FROM MIPRES_NO_DIRECCIONAMIENTOS
  WHERE NOPRESCRIPCION = M.NOPRESCRIPCION
  AND TIPOTEC = 'P'
  AND CONTEC = CONVERT(varchar, P.CONORDEN)
  AND ESTNODIRECCIONAMIENTO <> '0')
  NO_DIRECCIONAMIENTO,
  D.*
FROM MIPRES_PRESCRIPCION M
INNER JOIN MIPRES_PROCEDIMIENTOS P
  ON M.NOPRESCRIPCION = P.NOPRESCRIPCION
LEFT JOIN MIPRES_DIRECCIONAMIENTOS D
  ON M.NOPRESCRIPCION + 'P' + CONVERT(varchar, P.CONORDEN) = D.NOPRESCRIPCION + D.TIPOTEC + D.CONTEC
WHERE M.FPRESCRIPCION >= @FecInicial
AND M.FPRESCRIPCION <= @FecFinal

UNION

--- MEDICAMENTOS
SELECT
  M.NOPRESCRIPCION,
  M.FPRESCRIPCION,
  M.NROIDIPS,
  (SELECT
    NOM_PRESTADOR
  FROM PRESTADORES
  WHERE NIT_PRESTADOR = M.NROIDIPS)
  AS NOMIDIPS,
  M.CODDANEMUNIPS,
  M.CODHABIPS,
  M.REPORTMIPRES,
  M.CODAMBATE,
  M.CODEPS,
  M.ESTPRES,
  M.ESTTUT,
  M.TIPOIDPROF,
  M.NUMIDPROF,
  M.PNPROFS,
  M.SNPROFS,
  M.PAPROFS,
  M.SAPROFS,
  M.REGPROFS,
  M.TIPOIDPACIENTE,
  M.NROIDPACIENTE,
  M.PNPACIENTE,
  M.SNPACIENTE,
  M.PAPACIENTE,
  M.SAPACIENTE,
  M.CODDXPPAL,
  M.CODDXREL1,
  M.CODDXREL2,
  --(SELECT  TOP 1 FEC_NACIMIENTO FROM AFILIADOSSUB WHERE TIP_DOCUMENTO_BEN+NUM_DOCUMENTO_BEN = M.TIPOIDPACIENTE+M.NROIDPACIENTE AND EST_AFILIADO = '1') FEC_NACIMIENTO,
  --(SELECT  TOP 1 SEXO FROM AFILIADOSSUB WHERE TIP_DOCUMENTO_BEN+NUM_DOCUMENTO_BEN = M.TIPOIDPACIENTE+M.NROIDPACIENTE AND EST_AFILIADO = '1') SEXO,
  'M' SER_TEC,
  ME.CONORDEN,
  ME.TIPOPREST,
  ME.CodFF CODIGO,
  ISNULL(ME.DESCMEDPRINACT, 'VALOR NO PARAMETRIZADO - TABLAS DE REFERENCIA') AS DESCRIPCION,
  ME.CANTTOTALF,
  (SELECT TOP 1
    IDNODIRECCIONAMIENTO
  FROM MIPRES_NO_DIRECCIONAMIENTOS
  WHERE NOPRESCRIPCION = M.NOPRESCRIPCION
  AND TIPOTEC = 'M'
  AND CONTEC = CONVERT(varchar, ME.CONORDEN)
  AND ESTNODIRECCIONAMIENTO <> '0')
  NO_DIRECCIONAMIENTO,
  D.*
FROM MIPRES_PRESCRIPCION M
INNER JOIN MIPRES_MEDICAMENTOS ME
  ON M.NOPRESCRIPCION = ME.NOPRESCRIPCION
LEFT JOIN MIPRES_DIRECCIONAMIENTOS D
  ON M.NOPRESCRIPCION + 'M' + CONVERT(varchar, ME.CONORDEN) = D.NOPRESCRIPCION + D.TIPOTEC + D.CONTEC
WHERE M.FPRESCRIPCION >= @FecInicial
AND M.FPRESCRIPCION <= @FecFinal

UNION

--- DISPOSITIVOS
SELECT
  M.NOPRESCRIPCION,
  M.FPRESCRIPCION,
  M.NROIDIPS,
  (SELECT
    NOM_PRESTADOR
  FROM PRESTADORES
  WHERE NIT_PRESTADOR = M.NROIDIPS)
  AS NOMIDIPS,
  M.CODDANEMUNIPS,
  M.CODHABIPS,
  M.REPORTMIPRES,
  M.CODAMBATE,
  M.CODEPS,
  M.ESTPRES,
  M.ESTTUT,
  M.TIPOIDPROF,
  M.NUMIDPROF,
  M.PNPROFS,
  M.SNPROFS,
  M.PAPROFS,
  M.SAPROFS,
  M.REGPROFS,
  M.TIPOIDPACIENTE,
  M.NROIDPACIENTE,
  M.PNPACIENTE,
  M.SNPACIENTE,
  M.PAPACIENTE,
  M.SAPACIENTE,
  M.CODDXPPAL,
  M.CODDXREL1,
  M.CODDXREL2,
  --(SELECT  TOP 1 FEC_NACIMIENTO FROM AFILIADOSSUB WHERE TIP_DOCUMENTO_BEN+NUM_DOCUMENTO_BEN = M.TIPOIDPACIENTE+M.NROIDPACIENTE AND EST_AFILIADO = '1') FEC_NACIMIENTO,
  --(SELECT  TOP 1 SEXO FROM AFILIADOSSUB WHERE TIP_DOCUMENTO_BEN+NUM_DOCUMENTO_BEN = M.TIPOIDPACIENTE+M.NROIDPACIENTE AND EST_AFILIADO = '1') SEXO,
  'D' SER_TEC,
  DI.CONORDEN,
  DI.TIPOPREST,
  DI.CODDISP CODIGO,
  ISNULL((SELECT TOP 1
    MVP_DESCRIPCION
  FROM MIPRES_VALORES_PERMITIDOS
  WHERE MVP_ITEM = 'DISPOSITIVOS'
  AND MVP_VARIABLE = 'CODDISP'
  AND MVP_VALOR = DI.CODDISP), 'VALOR NO PARAMETRIZADO - TABLAS DE REFERENCIA') AS DESCRIPCION,
  DI.CANTTOTAL,
  (SELECT TOP 1
    IDNODIRECCIONAMIENTO
  FROM MIPRES_NO_DIRECCIONAMIENTOS
  WHERE NOPRESCRIPCION = M.NOPRESCRIPCION
  AND TIPOTEC = 'D'
  AND CONTEC = CONVERT(varchar, DI.CONORDEN)
  AND ESTNODIRECCIONAMIENTO <> '0')
  NO_DIRECCIONAMIENTO,
  D.*
FROM MIPRES_PRESCRIPCION M
INNER JOIN MIPRES_DISPOSITIVOS DI
  ON M.NOPRESCRIPCION = DI.NOPRESCRIPCION
LEFT JOIN MIPRES_DIRECCIONAMIENTOS D
  ON M.NOPRESCRIPCION + 'D' + CONVERT(varchar, DI.CONORDEN) = D.NOPRESCRIPCION + D.TIPOTEC + D.CONTEC
WHERE M.FPRESCRIPCION >= @FecInicial
AND M.FPRESCRIPCION <= @FecFinal


UNION

--- PRODUCTO NUTRICIONAL
SELECT
  M.NOPRESCRIPCION,
  M.FPRESCRIPCION,
  M.NROIDIPS,
  (SELECT
    NOM_PRESTADOR
  FROM PRESTADORES
  WHERE NIT_PRESTADOR = M.NROIDIPS)
  AS NOMIDIPS,
  M.CODDANEMUNIPS,
  M.CODHABIPS,
  M.REPORTMIPRES,
  M.CODAMBATE,
  M.CODEPS,
  M.ESTPRES,
  M.ESTTUT,
  M.TIPOIDPROF,
  M.NUMIDPROF,
  M.PNPROFS,
  M.SNPROFS,
  M.PAPROFS,
  M.SAPROFS,
  M.REGPROFS,
  M.TIPOIDPACIENTE,
  M.NROIDPACIENTE,
  M.PNPACIENTE,
  M.SNPACIENTE,
  M.PAPACIENTE,
  M.SAPACIENTE,
  M.CODDXPPAL,
  M.CODDXREL1,
  M.CODDXREL2,
  --(SELECT  TOP 1 FEC_NACIMIENTO FROM AFILIADOSSUB WHERE TIP_DOCUMENTO_BEN+NUM_DOCUMENTO_BEN = M.TIPOIDPACIENTE+M.NROIDPACIENTE AND EST_AFILIADO = '1') FEC_NACIMIENTO,
  --(SELECT  TOP 1 SEXO FROM AFILIADOSSUB WHERE TIP_DOCUMENTO_BEN+NUM_DOCUMENTO_BEN = M.TIPOIDPACIENTE+M.NROIDPACIENTE AND EST_AFILIADO = '1') SEXO,
  'N' SER_TEC,
  NU.CONORDEN,
  NU.TIPOPREST,
  CONVERT(varchar, NU.DESCPRODNUTR) CODIGO,
  ISNULL((SELECT TOP 1
    MVP_DESCRIPCION
  FROM MIPRES_VALORES_PERMITIDOS
  WHERE MVP_ITEM = 'NATURALES'
  AND MVP_VARIABLE = 'DESCPRODNUTR'
  AND MVP_VALOR = NU.DESCPRODNUTR), 'VALOR NO PARAMETRIZADO - TABLAS DE REFERENCIA') AS DESCRIPCION,
  NU.CANTTOTALF,
  (SELECT TOP 1
    IDNODIRECCIONAMIENTO
  FROM MIPRES_NO_DIRECCIONAMIENTOS
  WHERE NOPRESCRIPCION = M.NOPRESCRIPCION
  AND TIPOTEC = 'N'
  AND CONTEC = CONVERT(varchar, NU.CONORDEN)
  AND ESTNODIRECCIONAMIENTO <> '0')
  NO_DIRECCIONAMIENTO,
  D.*
FROM MIPRES_PRESCRIPCION M
INNER JOIN MIPRES_NUTRICIONALES NU
  ON M.NOPRESCRIPCION = NU.NOPRESCRIPCION
LEFT JOIN MIPRES_DIRECCIONAMIENTOS D
  ON M.NOPRESCRIPCION + 'N' + CONVERT(varchar, NU.CONORDEN) = D.NOPRESCRIPCION + D.TIPOTEC + D.CONTEC
WHERE M.FPRESCRIPCION >= @FecInicial
AND M.FPRESCRIPCION <= @FecFinal

UNION

--- SERVICIO COMPLEMENTARIO
SELECT
  M.NOPRESCRIPCION,
  M.FPRESCRIPCION,
  M.NROIDIPS,
  (SELECT
    NOM_PRESTADOR
  FROM PRESTADORES
  WHERE NIT_PRESTADOR = M.NROIDIPS)
  AS NOMIDIPS,
  M.CODDANEMUNIPS,
  M.CODHABIPS,
  M.REPORTMIPRES,
  M.CODAMBATE,
  M.CODEPS,
  M.ESTPRES,
  M.ESTTUT,
  M.TIPOIDPROF,
  M.NUMIDPROF,
  M.PNPROFS,
  M.SNPROFS,
  M.PAPROFS,
  M.SAPROFS,
  M.REGPROFS,
  M.TIPOIDPACIENTE,
  M.NROIDPACIENTE,
  M.PNPACIENTE,
  M.SNPACIENTE,
  M.PAPACIENTE,
  M.SAPACIENTE,
  M.CODDXPPAL,
  M.CODDXREL1,
  M.CODDXREL2,
  --(SELECT  TOP 1 FEC_NACIMIENTO FROM AFILIADOSSUB WHERE TIP_DOCUMENTO_BEN+NUM_DOCUMENTO_BEN = M.TIPOIDPACIENTE+M.NROIDPACIENTE AND EST_AFILIADO = '1') FEC_NACIMIENTO,
  --(SELECT  TOP 1 SEXO FROM AFILIADOSSUB WHERE TIP_DOCUMENTO_BEN+NUM_DOCUMENTO_BEN = M.TIPOIDPACIENTE+M.NROIDPACIENTE AND EST_AFILIADO = '1') SEXO,
  'S' SER_TEC,
  SE.CONORDEN,
  SE.TIPOPREST,
  CONVERT(varchar, SE.CODSERCOMP) CODIGO,
  ISNULL((SELECT TOP 1
    MVP_DESCRIPCION
  FROM MIPRES_VALORES_PERMITIDOS
  WHERE MVP_ITEM = 'COMPLEMENTARIOS'
  AND MVP_VARIABLE = 'CODSERCOMP'
  AND MVP_VALOR = SE.CODSERCOMP), 'VALOR NO PARAMETRIZADO - TABLAS DE REFERENCIA') AS DESCRIPCION,
  SE.CANTTOTAL,
  (SELECT TOP 1
    IDNODIRECCIONAMIENTO
  FROM MIPRES_NO_DIRECCIONAMIENTOS
  WHERE NOPRESCRIPCION = M.NOPRESCRIPCION
  AND TIPOTEC = 'S'
  AND CONTEC = CONVERT(varchar, SE.CONORDEN)
  AND ESTNODIRECCIONAMIENTO <> '0')
  NO_DIRECCIONAMIENTO,
  D.*
FROM MIPRES_PRESCRIPCION M
INNER JOIN MIPRES_COMPLEMENTARIOS SE
  ON M.NOPRESCRIPCION = SE.NOPRESCRIPCION
LEFT JOIN MIPRES_DIRECCIONAMIENTOS D
  ON M.NOPRESCRIPCION + 'S' + CONVERT(varchar, SE.CONORDEN) = D.NOPRESCRIPCION + D.TIPOTEC + D.CONTEC
WHERE M.FPRESCRIPCION >= @FecInicial
AND M.FPRESCRIPCION <= @FecFinal
";

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
    <th><small><strong>Numero Prs/Tut</strong></small></th>
    <th><small><strong>Fecha_Prs/Tut</strong></small></th>
    <th><small><strong>Nit IPS Solicitante</strong></small></th>
    <th><small><strong>Nombre IPS Solicitante</strong></small></th>
    <th><small><strong>Municipio IPS Solicitante</strong></small></th>
    <th><small><strong>Cod. Habilitacion IPS</strong></small></th>
    <th><small><strong>Tipo de Reporte</strong></small></th>
    <th><small><strong>Cod. Ambito</strong></small></th>
    <th><small><strong>Cod. EPS</strong></small></th>
    <th><small><strong>Estado Prescripcion</strong></small></th>
    <th><small><strong>Estado Tutela</strong></small></th>
    <th><small><strong>Tipo Id. Profesional</strong></small></th>
    <th><small><strong>Num. Id. Profesional</strong></small></th>
    <th><small><strong>Primer Nom. Profesional</strong></small></th>
    <th><small><strong>Segundo Nom. Profesional</strong></small></th>
    <th><small><strong>Primer Ape. Profesional</strong></small></th>
    <th><small><strong>Segundo Ape. Profesional</strong></small></th>
    <th><small><strong>Tipo Id. Paciente</strong></small></th>
    <th><small><strong>Num. Id. Paciente</strong></small></th>
    <th><small><strong>Primer Nom. Paciente</strong></small></th>
    <th><small><strong>Segundo Nom. Paciente</strong></small></th>
    <th><small><strong>Primer Ape. Paciente</strong></small></th>
    <th><small><strong>Segundo Ape. Paciente</strong></small></th>
    <th><small><strong>DX Principal</strong></small></th>
    <th><small><strong>DX1</strong></small></th>
    <th><small><strong>DX2</strong></small></th>
    <th><small><strong>Servicio/Tecnologia</strong></small></th>
    <th><small><strong>Orden</strong></small></th>
    <th><small><strong>Presentacion</strong></small></th>
    <th><small><strong>Codigo</strong></small></th>
    <th><small><strong>Descripcion</strong></small></th>
  <tr>
</thead>
<tbody>
				<?php
while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) )  
{ 

?>
  <tr>
  	<td>[<?php echo $row['NOPRESCRIPCION']; ?>]</td>
    <td><?php echo $row['FPRESCRIPCION']->format('d/m/Y'); ?></td>
    <td>[<?php echo $row['NROIDIPS']; ?>]</td>
    <td><?php echo $row['NOMIDIPS']; ?></td>
    <td><?php echo $row['CODDANEMUNIPS']; ?></td>
    <td>[<?php echo $row['CODHABIPS']; ?>]</td>
    <td><?php echo $row['REPORTMIPRES']; ?></td>
    <td><?php echo $row['CODAMBATE']; ?></td>
    <td><?php echo $row['CODEPS']; ?></td>
    <td><?php echo $row['ESTPRES']; ?></td>
    <td><?php echo $row['ESTTUT']; ?></td>
    <td><?php echo $row['TIPOIDPROF']; ?></td>
    <td><?php echo $row['NUMIDPROF']; ?></td>
    <td><?php echo $row['PNPROFS']; ?></td>
    <td><?php echo $row['SNPROFS']; ?></td>
    <td><?php echo $row['PAPROFS']; ?></td>
    <td><?php echo $row['SAPROFS']; ?></td>
    <td><?php echo $row['TIPOIDPACIENTE']; ?></td>
    <td><?php echo $row['NROIDPACIENTE']; ?></td>
    <td><?php echo $row['PNPACIENTE']; ?></td>
    <td><?php echo $row['SNPACIENTE']; ?></td>
    <td><?php echo $row['PAPACIENTE']; ?></td>
    <td><?php echo $row['SAPACIENTE']; ?></td>
    <td><?php echo $row['CODDXPPAL']; ?></td>
    <td><?php echo $row['CODDXREL1']; ?></td>
    <td><?php echo $row['CODDXREL2']; ?></td>
    <td><?php echo $row['SER_TEC']; ?></td>
    <td><?php echo $row['CONORDEN']; ?></td>
    <td><?php echo $row['TIPOPREST']; ?></td>
    <td><?php echo $row['CODIGO']; ?></td>
    <td><?php echo $row['DESCRIPCION']; ?></td>
   <tr>	
<?php


}
?>
</tbody>
</table>
</div>
<?php 
}
}	           
?>




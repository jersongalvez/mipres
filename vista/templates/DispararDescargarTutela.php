<style type="text/css">
#global {
  height: 300px;
  width: 100%;
  border: 1px solid #ddd;
  background: #f1f1f1;
  overflow-y: scroll;
}
#mensajes {
  height: auto;
}
.texto {
  padding:4px;
  background:#fff;
}
</style>
<div class="container-fluid" style="margin-top:80px">

<nav aria-label="breadcrumb">
  <ol class="breadcrumb">
    <li class="breadcrumb-item">Descargar</li>
    <li class="breadcrumb-item"><a  href="index.php?x=026">Tutelas por Fecha</a></li>
  </ol>
</nav>


<div class="container">

<div class="row">
  <div class="col-md-3 sm-12">
    <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
      <a class="btn btn-light" id="v-pills-profile-tab" href="index.php?x=026"><center>Regresar</center></a>
    </div>
    <br>
    <center><div id="barra" class="spinner-border text-success" style = 'display:none;'></div></center>
  </div>
  <div class="col-md-9 sm-12">
  <div class="tab-content" id="v-pills-tabContent">

<div class="card ">
  <div class="card-header">
    <H4>Tutelas por Fecha</H4>
  </div>
  <div class="card-body">      

<?php
set_time_limit(1000);
//ERROR0006
  if (!empty($_SESSION['NIT_EPS'])){   


     $sql = "SELECT * FROM PRS_URL_SERVICES WHERE COD_URL = '12' ";
    $params = array();
    $options =  array( "Scrollable" => SQLSRV_CURSOR_KEYSET );
    $stmt = sqlsrv_query( $conn, $sql, $params, $options);
    $row_count = sqlsrv_num_rows( $stmt );
      if ($row_count === false){
      echo "<div class='alert alert-danger alert-dismissible'>";
      echo "<button type='button' class='close' data-dismiss='alert'>&times;</button>";
      echo "<strong>Error!</strong> No se encuentra el recurso solicitado, error: ERROR0006</div>";
      }  
      else{
            while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC))  
            {  

        if ($_POST['var_regimen'] === 'S') {
        $url = $row['DES_URL'].$_SESSION['NIT_EPS'].'/'.$_POST['var_fecha'].'/'.$_SESSION['PRETOCKENSUB'];
        }
        elseif ($_POST['var_regimen'] === 'C') {
        $url = $row['DES_URL'].$_SESSION['NIT_EPS'].'/'.$_POST['var_fecha'].'/'.$_SESSION['PRETOCKEN'];
        }

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json; charset=utf-8'));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
        $result = curl_exec($ch);
            }  
          }
    sqlsrv_free_stmt($stmt); 
  }else{
      echo "<div class='alert alert-danger alert-dismissible'>";
      echo "<button type='button' class='close' data-dismiss='alert'>&times;</button>";
      echo "<strong>Error!</strong> No se ha logrado autenticar los datos de la compañia, error: ERROR0004</div>";
  }





if (!curl_errno($ch)) {
switch ($http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE)) {
case 200:  # OK
$result = json_decode($result, true);
$info = curl_getinfo($ch);
if(count($result)<>0){ 
        ?>  
        <div class="list-group">
        <a class="list-group-item list-group-item-action list-group-item-info"><span class="badge badge-info badge-pill"><?php echo count($result); ?></span> Tutelas encontradas <?php echo  $_POST['var_fecha'];?></a>
        </div>
        <div id="global">
        <div id="mensajes">
        <div class="texto">
        <pre>
        <?php 
echo "<br>";

echo $mensaje_mipres = "Tiempo de ejecución de la consulta: ".$info['total_time']." ms, a solicitud de la IP: ".$info['local_ip']." codigo de respuesta: ".$http_code;

echo "<br>";
echo "<br>";

for($i = 0, $size = count($result); $i < $size; ++$i) {
$sql = "
    IF NOT EXISTS (SELECT NOPRESCRIPCION FROM MIPRES_PRESCRIPCION WHERE NOPRESCRIPCION = '".$result[$i]['tutela']['NoTutela']."' )
    BEGIN 
    INSERT INTO [dbo].[MIPRES_PRESCRIPCION ]
    ([NOPRESCRIPCION],[FPRESCRIPCION],[HPRESCRIPCION],[TIPOIDIPS],[NROIDIPS],[TIPOIDPROF],[NUMIDPROF],[PNPROFS],[SNPROFS],[PAPROFS],[SAPROFS],[REGPROFS],[TIPOIDPACIENTE],[NROIDPACIENTE],[PNPACIENTE],[SNPACIENTE],[PAPACIENTE],[SAPACIENTE],[ENFHUERFANA],[CODENFHUERFANA],[CODDXPPAL],[CODDXREL1],[CODDXREL2],[CODEPS],[TIPOIDMADREPACIENTE],[NROIDMADREPACIENTE],[MIDORDENITEM],[USU_CARGUE],[FEC_CRUCE],[REGIMEN],REPORTMIPRES,[NroFallo],[FFalloTutela],[F1Instan],[F2Instan],[FCorte],[FDesacato],[AclFalloTut],[CodDxMotS1],[CodDxMotS2],[CodDxMotS3],[CritDef1CC],[CritDef2CC],[CritDef3CC],[CritDef4CC],[EstTut],[JUSTIFMED])
    VALUES
    ('".$result[$i]['tutela']['NoTutela']."'
    ,'".$result[$i]['tutela']['FTutela']."'
    ,'".$result[$i]['tutela']['HTutela']."'
    ,'".$result[$i]['tutela']['TipoIDEPS']."'
    ,'".CompletarCeros($result[$i]['tutela']['NroIDEPS'], 15)."'
    ,'".$result[$i]['tutela']['TipoIDProf']."'
    ,".Valor(str_replace(",", ".",$result[$i]['tutela']['NumIDProf']))."
    ,'".$result[$i]['tutela']['PNProfS']."'
    ,'".$result[$i]['tutela']['SNProfS']."'
    ,'".$result[$i]['tutela']['PAProfS']."'
    ,'".$result[$i]['tutela']['SAProfS']."'
    ,'".$result[$i]['tutela']['RegProfS']."'
    ,'".$result[$i]['tutela']['TipoIDPaciente']."'
    ,'".$result[$i]['tutela']['NroIDPaciente']."'
    ,'".$result[$i]['tutela']['PNPaciente']."'
    ,'".$result[$i]['tutela']['SNPaciente']."'
    ,'".$result[$i]['tutela']['PAPaciente']."'
    ,'".$result[$i]['tutela']['SAPaciente']."'
    ,".Valor(str_replace(",", ".",$result[$i]['tutela']['EnfHuerfana']))."
    ,".Valor(str_replace(",", ".",$result[$i]['tutela']['CodEnfHuerfana']))."
    ,'".$result[$i]['tutela']['CodDxPpal']."'
    ,'".$result[$i]['tutela']['CodDxRel1']."'
    ,'".$result[$i]['tutela']['CodDxRel2']."'
    ,'".$result[$i]['tutela']['CodEPS']."'
    ,'".$result[$i]['tutela']['TipoIDMadrePaciente']."'
    ,'".$result[$i]['tutela']['NroIDMadrePaciente']."'
    ,".Valor(IDORDENITEM($conn,$result[$i]['tutela']['TipoIDPaciente'],$result[$i]['tutela']['NroIDPaciente']))."
    ,'".$_SESSION["usuario"]."'
    ,CURRENT_TIMESTAMP
    ,'".$_POST['var_regimen']."'
    ,'NOTUTELA'
    ,'".$result[$i]['tutela']['NroFallo']."'
    ,'".$result[$i]['tutela']['FFalloTutela']."'
    ,'".$result[$i]['tutela']['F1Instan']."'
    ,'".$result[$i]['tutela']['F2Instan']."'
    ,'".$result[$i]['tutela']['FCorte']."'
    ,'".$result[$i]['tutela']['FDesacato']."'
    ,'".$result[$i]['tutela']['AclFalloTut']."'
    ,'".$result[$i]['tutela']['CodDxMotS1']."'
    ,'".$result[$i]['tutela']['CodDxMotS2']."'
    ,'".$result[$i]['tutela']['CodDxMotS3']."'
    ,".Valor(str_replace(",", ".",$result[$i]['tutela']['CritDef1CC']))."
    ,".Valor(str_replace(",", ".",$result[$i]['tutela']['CritDef2CC']))."
    ,".Valor(str_replace(",", ".",$result[$i]['tutela']['CritDef3CC']))."
    ,".Valor(str_replace(",", ".",$result[$i]['tutela']['CritDef4CC']))."
    ,".Valor(str_replace(",", ".",$result[$i]['tutela']['EstTut']))."
    ,'".$result[$i]['tutela']['JustifMed']."'
    )

    END ELSE BEGIN 

    UPDATE [dbo].[MIPRES_PRESCRIPCION ]
    SET [NOPRESCRIPCION] = '".$result[$i]['tutela']['NoTutela']."'
    ,[FPRESCRIPCION] = '".$result[$i]['tutela']['FTutela']."'
    ,[HPRESCRIPCION] = '".$result[$i]['tutela']['HTutela']."'
    ,[TIPOIDIPS] = '".$result[$i]['tutela']['TipoIDEPS']."'
    ,[NROIDIPS] = '".CompletarCeros($result[$i]['tutela']['NroIDEPS'], 15)."'
    ,[TIPOIDPROF] = '".$result[$i]['tutela']['TipoIDProf']."'
    ,[NUMIDPROF] = ".Valor(str_replace(",", ".",$result[$i]['tutela']['NumIDProf']))."
    ,[PNPROFS] = '".$result[$i]['tutela']['PNProfS']."'
    ,[SNPROFS] = '".$result[$i]['tutela']['SNProfS']."'
    ,[PAPROFS] = '".$result[$i]['tutela']['PAProfS']."'
    ,[SAPROFS] = '".$result[$i]['tutela']['SAProfS']."'
    ,[REGPROFS] = '".$result[$i]['tutela']['RegProfS']."'
    ,[TIPOIDPACIENTE] = '".$result[$i]['tutela']['TipoIDPaciente']."'
    ,[NROIDPACIENTE] = '".$result[$i]['tutela']['NroIDPaciente']."'
    ,[PNPACIENTE] = '".$result[$i]['tutela']['PNPaciente']."'
    ,[SNPACIENTE] = '".$result[$i]['tutela']['SNPaciente']."'
    ,[PAPACIENTE] = '".$result[$i]['tutela']['PAPaciente']."'
    ,[SAPACIENTE] = '".$result[$i]['tutela']['SAPaciente']."'
    ,[ENFHUERFANA] = ".Valor(str_replace(",", ".",$result[$i]['tutela']['EnfHuerfana']))."
    ,[CODENFHUERFANA] = ".Valor(str_replace(",", ".",$result[$i]['tutela']['CodEnfHuerfana']))."
    ,[CODDXPPAL] = '".$result[$i]['tutela']['CodDxPpal']."'
    ,[CODDXREL1] = '".$result[$i]['tutela']['CodDxRel1']."'
    ,[CODDXREL2] = '".$result[$i]['tutela']['CodDxRel2']."'
    ,[CODEPS] = '".$result[$i]['tutela']['CodEPS']."'
    ,[TIPOIDMADREPACIENTE] = '".$result[$i]['tutela']['TipoIDMadrePaciente']."'
    ,[NROIDMADREPACIENTE] = '".$result[$i]['tutela']['NroIDMadrePaciente']."'
    ,[MIDORDENITEM] = ".Valor(IDORDENITEM($conn,$result[$i]['tutela']['TipoIDPaciente'],$result[$i]['tutela']['NroIDPaciente']))."
    ,[USU_CARGUE] = '".$_SESSION["usuario"]."'
    ,[FEC_CRUCE] = CURRENT_TIMESTAMP
    ,[REGIMEN] = '".$_POST['var_regimen']."'
    ,[NroFallo] = '".$result[$i]['tutela']['NroFallo']."'
    ,[FFalloTutela] = '".$result[$i]['tutela']['FFalloTutela']."'
    ,[F1Instan] = '".$result[$i]['tutela']['F1Instan']."'
    ,[F2Instan] = '".$result[$i]['tutela']['F2Instan']."'
    ,[FCorte] = '".$result[$i]['tutela']['FCorte']."'
    ,[FDesacato] = '".$result[$i]['tutela']['FDesacato']."'
    ,[AclFalloTut] = '".$result[$i]['tutela']['AclFalloTut']."'
    ,[CodDxMotS1] = '".$result[$i]['tutela']['CodDxMotS1']."'
    ,[CodDxMotS2] = '".$result[$i]['tutela']['CodDxMotS2']."'
    ,[CodDxMotS3] = '".$result[$i]['tutela']['CodDxMotS3']."'
    ,[CritDef1CC] = ".Valor(str_replace(",", ".",$result[$i]['tutela']['CritDef1CC']))."
    ,[CritDef2CC] = ".Valor(str_replace(",", ".",$result[$i]['tutela']['CritDef2CC']))."
    ,[CritDef3CC] = ".Valor(str_replace(",", ".",$result[$i]['tutela']['CritDef3CC']))."
    ,[CritDef4CC] = ".Valor(str_replace(",", ".",$result[$i]['tutela']['CritDef4CC']))."
    ,[EstTut] = ".Valor(str_replace(",", ".",$result[$i]['tutela']['EstTut']))."
    ,[JUSTIFMED] = '".$result[$i]['tutela']['JustifMed']."'
    WHERE NOPRESCRIPCION = '".$result[$i]['tutela']['NoTutela']."'
    END";
echo "Núm. Tutela: ".$result[$i]['tutela']['NoTutela']." Resultado: ".sql($conn,$sql)."<br>";
}

for($i = 0, $size = count($result); $i < $size; ++$i) {
if (sizeof($result[$i]['procedimientos'])<>0){
for($p = 0, $size_Pro = sizeof($result[$i]['procedimientos']); $p < $size_Pro; ++$p) {
$sql_procedimientos = "
    IF NOT EXISTS (SELECT NOPRESCRIPCION FROM [MIPRES_PROCEDIMIENTOS] WHERE NOPRESCRIPCION = '".$result[$i]['tutela']['NoTutela']."' AND CONORDEN = '".$result[$i]['procedimientos'][$p]['ConOrden']."')
    BEGIN 

    INSERT INTO [dbo].[MIPRES_PROCEDIMIENTOS]
    ([NOPRESCRIPCION],[CONORDEN],[TIPOPREST],[CODCUPS],[CANFORM],[CODFREUSO],[CANT] ,[CODPERDURTRAT],[JUSTNOPBS],[INDREC])
    VALUES
    ('".$result[$i]['tutela']['NoTutela']."'
    ,".Valor(str_replace(",", ".",$result[$i]['procedimientos'][$p]['ConOrden']))."
    ,".Valor(str_replace(",", ".",$result[$i]['procedimientos'][$p]['TipoPrest']))."
    ,'".$result[$i]['procedimientos'][$p]['CodCUPS']."'
    ,".Valor(str_replace(",", ".",$result[$i]['procedimientos'][$p]['CanForm']))."
    ,".Valor(str_replace(",", ".",$result[$i]['procedimientos'][$p]['CodFreUso']))."
    ,".Valor(str_replace(",", ".",$result[$i]['procedimientos'][$p]['Cant']))."
    ,".Valor(str_replace(",", ".",$result[$i]['procedimientos'][$p]['CodPerDurTrat']))."
    ,'".$result[$i]['procedimientos'][$p]['JustNoPBS']."'
    ,'".$result[$i]['procedimientos'][$p]['IndRec']."'
    )

    END ELSE BEGIN 

    UPDATE [dbo].[MIPRES_PROCEDIMIENTOS]
    SET [NOPRESCRIPCION] = '".$result[$i]['tutela']['NoTutela']."'
    ,[CONORDEN] = ".Valor(str_replace(",", ".",$result[$i]['procedimientos'][$p]['ConOrden']))."
    ,[TIPOPREST] = ".Valor(str_replace(",", ".",$result[$i]['procedimientos'][$p]['TipoPrest']))."
    ,[CODCUPS] = '".$result[$i]['procedimientos'][$p]['CodCUPS']."'
    ,[CANFORM] = ".Valor(str_replace(",", ".",$result[$i]['procedimientos'][$p]['CanForm']))."
    ,[CODFREUSO] = ".Valor(str_replace(",", ".",$result[$i]['procedimientos'][$p]['CodFreUso']))."
    ,[CANT] = ".Valor(str_replace(",", ".",$result[$i]['procedimientos'][$p]['Cant']))."
    ,[CODPERDURTRAT] = ".Valor(str_replace(",", ".",$result[$i]['procedimientos'][$p]['CodPerDurTrat']))."
    ,[JUSTNOPBS] = '".$result[$i]['procedimientos'][$p]['JustNoPBS']."'
    ,[INDREC] = '".$result[$i]['procedimientos'][$p]['IndRec']."'
    WHERE NOPRESCRIPCION = '".$result[$i]['tutela']['NoTutela']."' AND CONORDEN = '".$result[$i]['procedimientos'][$p]['ConOrden']."'
    END";
echo "Procedimiento: ".$result[$i]['tutela']['NoTutela']." Consecutivo: ".$result[$i]['procedimientos'][$p]['ConOrden']." Resultado: ".sql($conn,$sql_procedimientos)."<br>";
}
}
}

for($i = 0, $size = count($result); $i < $size; ++$i){
if (sizeof($result[$i]['productosnutricionales'])<>0){
for($f = 0, $size_Nutr = sizeof($result[$i]['productosnutricionales']); $f < $size_Nutr; ++$f){
$sql_nutricionales = "
    IF NOT EXISTS (SELECT NOPRESCRIPCION FROM [MIPRES_NUTRICIONALES] WHERE NOPRESCRIPCION = '".$result[$i]['tutela']['NoTutela']."' AND CONORDEN = '".$result[$i]['productosnutricionales'][$f]['ConOrden']."')
    BEGIN 

    INSERT INTO [dbo].[MIPRES_NUTRICIONALES]
    ([NOPRESCRIPCION],[CONORDEN],[TIPOPREST],[TIPPPRONUT],[DESCPRODNUTR],[CODFORMA],[CODVIAADMON],[JUSTNOPBS],[DOSIS],[DOSISUM],[NOFADMON],[CODFREADMON],[CANTRAT],[DURTRAT],[CANTTOTALF],[UFCANTTOTAL],[INDREC],[INDESP])
    VALUES
    ('".$result[$i]['tutela']['NoTutela']."'
    ,".Valor(str_replace(",", ".",$result[$i]['productosnutricionales'][$f]['ConOrden']))."
    ,".Valor(str_replace(",", ".",$result[$i]['productosnutricionales'][$f]['TipoPrest']))."
    ,".Valor(str_replace(",", ".",$result[$i]['productosnutricionales'][$f]['TippProNut']))."
    ,".Valor(str_replace(",", ".",$result[$i]['productosnutricionales'][$f]['DescProdNutr']))."
    ,".Valor(str_replace(",", ".",$result[$i]['productosnutricionales'][$f]['CodForma']))."
    ,".Valor(str_replace(",", ".",$result[$i]['productosnutricionales'][$f]['CodViaAdmon']))."
    ,'".$result[$i]['productosnutricionales'][$f]['JustNoPBS']."'
    ,".Valor(str_replace(",",".",$result[$i]['productosnutricionales'][$f]['Dosis']))."
    ,'".$result[$i]['productosnutricionales'][$f]['DosisUM']."'
    ,".Valor(str_replace(",", ".",$result[$i]['productosnutricionales'][$f]['NoFAdmon']))."
    ,".Valor(str_replace(",", ".",$result[$i]['productosnutricionales'][$f]['CodFreAdmon']))."
    ,".Valor(str_replace(",", ".",$result[$i]['productosnutricionales'][$f]['CanTrat']))."
    ,".Valor(str_replace(",", ".",$result[$i]['productosnutricionales'][$f]['DurTrat']))."
    ,".Valor(str_replace(",", ".",$result[$i]['productosnutricionales'][$f]['CantTotalF']))."
    ,".Valor(str_replace(",", ".",$result[$i]['productosnutricionales'][$f]['UFCantTotal']))."
    ,'".$result[$i]['productosnutricionales'][$f]['IndRec']."'
    ,".Valor(str_replace(",", ".",$result[$i]['productosnutricionales'][$f]['IndEsp']))."
    )

    END ELSE BEGIN 

    UPDATE [dbo].[MIPRES_NUTRICIONALES]
    SET [NOPRESCRIPCION] = '".$result[$i]['tutela']['NoTutela']."'
    ,[CONORDEN] = ".Valor(str_replace(",", ".",$result[$i]['productosnutricionales'][$f]['ConOrden']))."
    ,[TIPOPREST] = ".Valor(str_replace(",", ".",$result[$i]['productosnutricionales'][$f]['TipoPrest']))."
    ,[TIPPPRONUT] = ".Valor(str_replace(",", ".",$result[$i]['productosnutricionales'][$f]['TippProNut']))."
    ,[DESCPRODNUTR] = ".Valor(str_replace(",", ".",$result[$i]['productosnutricionales'][$f]['DescProdNutr']))."
    ,[CODFORMA] = ".Valor(str_replace(",", ".",$result[$i]['productosnutricionales'][$f]['CodForma']))."
    ,[CODVIAADMON] = ".Valor(str_replace(",", ".",$result[$i]['productosnutricionales'][$f]['CodViaAdmon']))."
    ,[JUSTNOPBS] = '".$result[$i]['productosnutricionales'][$f]['JustNoPBS']."'
    ,[DOSIS] = ".Valor(str_replace(",", ".",$result[$i]['productosnutricionales'][$f]['Dosis']))."
    ,[DOSISUM] = '".$result[$i]['productosnutricionales'][$f]['DosisUM']."'
    ,[NOFADMON] = ".Valor(str_replace(",", ".",$result[$i]['productosnutricionales'][$f]['NoFAdmon']))."
    ,[CODFREADMON] = ".Valor(str_replace(",", ".",$result[$i]['productosnutricionales'][$f]['CodFreAdmon']))."
    ,[CANTRAT] = ".Valor(str_replace(",", ".",$result[$i]['productosnutricionales'][$f]['CanTrat']))."
    ,[DURTRAT] = ".Valor(str_replace(",", ".",$result[$i]['productosnutricionales'][$f]['DurTrat']))."
    ,[CANTTOTALF] = ".Valor(str_replace(",", ".",$result[$i]['productosnutricionales'][$f]['CantTotalF']))."
    ,[UFCANTTOTAL] = ".Valor(str_replace(",", ".",$result[$i]['productosnutricionales'][$f]['UFCantTotal']))."
    ,[INDREC] = '".$result[$i]['productosnutricionales'][$f]['IndRec']."'
    ,[INDESP] = ".Valor(str_replace(",", ".",$result[$i]['productosnutricionales'][$f]['IndEsp']))."
    WHERE NOPRESCRIPCION = '".$result[$i]['tutela']['NoTutela']."' AND CONORDEN = '".$result[$i]['productosnutricionales'][$f]['ConOrden']."'
    END";

echo "Prod. Nutricional: ".$result[$i]['tutela']['NoTutela']." Consecutivo: ".$result[$i]['productosnutricionales'][$f]['ConOrden']." Resultado: ".sql($conn,$sql_nutricionales)."<br>";
}
}  
}


for($i = 0, $size = count($result); $i < $size; ++$i){
if (sizeof($result[$i]['serviciosComplementarios'])<>0){
for($p = 0, $size_Comp = sizeof($result[$i]['serviciosComplementarios']); $p < $size_Comp; ++$p) {
$sql_complementarios = "
    IF NOT EXISTS (SELECT NOPRESCRIPCION FROM [MIPRES_COMPLEMENTARIOS] WHERE NOPRESCRIPCION = '".$result[$i]['tutela']['NoTutela']."' AND CONORDEN = '".$result[$i]['serviciosComplementarios'][$p]['ConOrden']."')
    BEGIN 

    INSERT INTO [dbo].[MIPRES_COMPLEMENTARIOS]
    ([NOPRESCRIPCION],[CONORDEN],[TIPOPREST],[CODSERCOMP],[DESCSERCOMP],[CANFORM],[CODFREUSO],[CANT],[CODPERDURTRAT],[JUSTNOPBS],[INDREC])
    VALUES
    ('".$result[$i]['tutela']['NoTutela']."'
    ,".Valor(str_replace(",", ".",$result[$i]['serviciosComplementarios'][$p]['ConOrden']))."
    ,".Valor(str_replace(",", ".",$result[$i]['serviciosComplementarios'][$p]['TipoPrest']))."
    ,".Valor(str_replace(",", ".",$result[$i]['serviciosComplementarios'][$p]['CodSerComp']))."
    ,'".$result[$i]['serviciosComplementarios'][$p]['DescSerComp']."'
    ,".Valor(str_replace(",", ".",$result[$i]['serviciosComplementarios'][$p]['CanForm']))."
    ,".Valor(str_replace(",", ".",$result[$i]['serviciosComplementarios'][$p]['CodFreUso']))."
    ,".Valor(str_replace(",", ".",$result[$i]['serviciosComplementarios'][$p]['Cant']))."
    ,".Valor(str_replace(",", ".",$result[$i]['serviciosComplementarios'][$p]['CodPerDurTrat']))."
    ,'".$result[$i]['serviciosComplementarios'][$p]['JustNoPBS']."'
    ,'".$result[$i]['serviciosComplementarios'][$p]['IndRec']."'
    ) 
    END ELSE BEGIN 

    UPDATE [dbo].[MIPRES_COMPLEMENTARIOS]
    SET [NOPRESCRIPCION] = '".$result[$i]['tutela']['NoTutela']."'
    ,[CONORDEN] = ".Valor(str_replace(",", ".",$result[$i]['serviciosComplementarios'][$p]['ConOrden']))."
    ,[TIPOPREST] = ".Valor(str_replace(",", ".",$result[$i]['serviciosComplementarios'][$p]['TipoPrest']))."
    ,[CODSERCOMP] = ".Valor(str_replace(",", ".",$result[$i]['serviciosComplementarios'][$p]['CodSerComp']))."
    ,[DESCSERCOMP] = '".$result[$i]['serviciosComplementarios'][$p]['DescSerComp']."'
    ,[CANFORM] = ".Valor(str_replace(",", ".",$result[$i]['serviciosComplementarios'][$p]['CanForm']))."
    ,[CODFREUSO] = ".Valor(str_replace(",", ".",$result[$i]['serviciosComplementarios'][$p]['CodFreUso']))."
    ,[CANT] = ".Valor(str_replace(",", ".",$result[$i]['serviciosComplementarios'][$p]['Cant']))."
    ,[CODPERDURTRAT] = ".Valor(str_replace(",", ".",$result[$i]['serviciosComplementarios'][$p]['CodPerDurTrat']))."
    ,[JUSTNOPBS] = '".$result[$i]['serviciosComplementarios'][$p]['JustNoPBS']."'
    ,[INDREC] = '".$result[$i]['serviciosComplementarios'][$p]['IndRec']."'
    WHERE NOPRESCRIPCION = '".$result[$i]['tutela']['NoTutela']."' AND CONORDEN = '".$result[$i]['serviciosComplementarios'][$p]['ConOrden']."'

    END";

echo "Serv. Complementarios: ".$result[$i]['tutela']['NoTutela']." Consecutivo: ".$result[$i]['serviciosComplementarios'][$p]['ConOrden']." Resultado: ".sql($conn,$sql_complementarios)."<br>";
}
}
}


for($i = 0, $size = count($result); $i < $size; ++$i){
if (sizeof($result[$i]['dispositivos'])<>0){
for($p = 0, $size_Dispo = sizeof($result[$i]['dispositivos']); $p < $size_Dispo; ++$p) {
$sql_dispositivos = "
    IF NOT EXISTS (SELECT NOPRESCRIPCION FROM [MIPRES_DISPOSITIVOS] WHERE NOPRESCRIPCION = '".$result[$i]['tutela']['NoTutela']."' AND CONORDEN = '".$result[$i]['dispositivos'][$p]['ConOrden']."')
    BEGIN 

    INSERT INTO [dbo].[MIPRES_DISPOSITIVOS]
    ([NOPRESCRIPCION],[CONORDEN],[TIPOPREST],[CODDISP],[CANFORM],[CODFREUSO],[CANT],[CODPERDURTRAT],[JUSTNOPBS],[INDREC])
    VALUES
    ('".$result[$i]['tutela']['NoTutela']."'
    ,".Valor(str_replace(",", ".",$result[$i]['dispositivos'][$p]['ConOrden']))."
    ,".Valor(str_replace(",", ".",$result[$i]['dispositivos'][$p]['TipoPrest']))."
    ,'".$result[$i]['dispositivos'][$p]['CodDisp']."'
    ,".Valor(str_replace(",", ".",$result[$i]['dispositivos'][$p]['CanForm']))."
    ,".Valor(str_replace(",", ".",$result[$i]['dispositivos'][$p]['CodFreUso']))."
    ,".Valor(str_replace(",", ".",$result[$i]['dispositivos'][$p]['Cant']))."
    ,".Valor(str_replace(",", ".",$result[$i]['dispositivos'][$p]['CodPerDurTrat']))."
    ,'".$result[$i]['dispositivos'][$p]['JustNoPBS']."'
    ,'".$result[$i]['dispositivos'][$p]['IndRec']."'
    )
    END ELSE BEGIN 

    UPDATE [dbo].[MIPRES_DISPOSITIVOS]
    SET [NOPRESCRIPCION] = '".$result[$i]['tutela']['NoTutela']."'
    ,[CONORDEN] = ".Valor(str_replace(",", ".",$result[$i]['dispositivos'][$p]['ConOrden']))."
    ,[TIPOPREST] = ".Valor(str_replace(",", ".",$result[$i]['dispositivos'][$p]['TipoPrest']))."
    ,[CODDISP] = '".$result[$i]['dispositivos'][$p]['CodDisp']."'
    ,[CANFORM] = ".Valor(str_replace(",", ".",$result[$i]['dispositivos'][$p]['CanForm']))."
    ,[CODFREUSO] = ".Valor(str_replace(",", ".",$result[$i]['dispositivos'][$p]['CodFreUso']))."
    ,[CANT] = ".Valor(str_replace(",", ".",$result[$i]['dispositivos'][$p]['Cant']))."
    ,[CODPERDURTRAT] = ".Valor(str_replace(",", ".",$result[$i]['dispositivos'][$p]['CodPerDurTrat']))."
    ,[JUSTNOPBS] = '".$result[$i]['dispositivos'][$p]['JustNoPBS']."'
    ,[INDREC] = '".$result[$i]['dispositivos'][$p]['IndRec']."'
    WHERE NOPRESCRIPCION = '".$result[$i]['tutela']['NoTutela']."' AND CONORDEN = '".$result[$i]['dispositivos'][$p]['ConOrden']."'

    END";
echo "Disp. Medicos: ".$result[$i]['tutela']['NoTutela']." Consecutivo: ".$result[$i]['dispositivos'][$p]['ConOrden']." Resultado: ".sql($conn,$sql_dispositivos)."<br>";
}
}
}


for($i = 0, $size = count($result); $i < $size; ++$i){
if (sizeof($result[$i]['medicamentos'])<>0){
for($p = 0, $size_med= sizeof($result[$i]['medicamentos']); $p < $size_med; ++$p) {
$sql_medicamento = "
    IF NOT EXISTS (SELECT NOPRESCRIPCION FROM [MIPRES_MEDICAMENTOS ] WHERE NOPRESCRIPCION = '".$result[$i]['tutela']['NoTutela']."' AND CONORDEN = '".$result[$i]['medicamentos'][$p]['ConOrden']."')
    BEGIN 

    INSERT INTO [dbo].[MIPRES_MEDICAMENTOS ]
    ([NOPRESCRIPCION],[CONORDEN],[TIPOMED],[TIPOPREST],[CODFF],[CODVA],[JUSTNOPBS],[DOSIS],[DOSISUM],[NOFADMON],[CODFREADMON],[INDESP],[CANTRAT],[DURTRAT],[CANTTOTALF],[UFCANTTOTAL],[INDREC])
    VALUES
    ('".$result[$i]['tutela']['NoTutela']."'
    ,".Valor(str_replace(",", ".",$result[$i]['medicamentos'][$p]['ConOrden']))."
    ,".Valor(str_replace(",", ".",$result[$i]['medicamentos'][$p]['TipoMed']))."
    ,".Valor(str_replace(",", ".",$result[$i]['medicamentos'][$p]['TipoPrest']))."
    ,'".$result[$i]['medicamentos'][$p]['CodFF']."'
    ,'".$result[$i]['medicamentos'][$p]['CodVA']."'
    ,'".$result[$i]['medicamentos'][$p]['JustNoPBS']."'
    ,".Valor(str_replace(",", ".",$result[$i]['medicamentos'][$p]['Dosis']))."
    ,'".$result[$i]['medicamentos'][$p]['DosisUM']."'
    ,".Valor(str_replace(",", ".",$result[$i]['medicamentos'][$p]['NoFAdmon']))."
    ,".Valor(str_replace(",", ".",$result[$i]['medicamentos'][$p]['CodFreAdmon']))."
    ,".Valor(str_replace(",", ".",$result[$i]['medicamentos'][$p]['IndEsp']))."
    ,".Valor(str_replace(",", ".",$result[$i]['medicamentos'][$p]['CanTrat']))."
    ,".Valor(str_replace(",", ".",$result[$i]['medicamentos'][$p]['DurTrat']))."
    ,".Valor(str_replace(",", ".",$result[$i]['medicamentos'][$p]['CantTotalF']))."
    ,'".$result[$i]['medicamentos'][$p]['UFCantTotal']."'
    ,'".$result[$i]['medicamentos'][$p]['IndRec']."'
    )

    END ELSE BEGIN 

    UPDATE [dbo].[MIPRES_MEDICAMENTOS ]
    SET [NOPRESCRIPCION] = '".$result[$i]['tutela']['NoTutela']."'
    ,[CONORDEN] = ".Valor(str_replace(",", ".",$result[$i]['medicamentos'][$p]['ConOrden']))."
    ,[TIPOMED] = ".Valor(str_replace(",", ".",$result[$i]['medicamentos'][$p]['TipoMed']))."
    ,[TIPOPREST] = ".Valor(str_replace(",", ".",$result[$i]['medicamentos'][$p]['TipoPrest']))."
    ,[CODFF] = '".$result[$i]['medicamentos'][$p]['CodFF']."'
    ,[CODVA] = '".$result[$i]['medicamentos'][$p]['CodVA']."'
    ,[JUSTNOPBS] = '".$result[$i]['medicamentos'][$p]['JustNoPBS']."'
    ,[DOSIS] = ".Valor(str_replace(",", ".",$result[$i]['medicamentos'][$p]['Dosis']))."
    ,[DOSISUM] = '".$result[$i]['medicamentos'][$p]['DosisUM']."'
    ,[NOFADMON] = ".Valor(str_replace(",", ".",$result[$i]['medicamentos'][$p]['NoFAdmon']))."
    ,[CODFREADMON] = ".Valor(str_replace(",", ".",$result[$i]['medicamentos'][$p]['CodFreAdmon']))."
    ,[INDESP] = ".Valor(str_replace(",", ".",$result[$i]['medicamentos'][$p]['IndEsp']))."
    ,[CANTRAT] = ".Valor(str_replace(",", ".",$result[$i]['medicamentos'][$p]['CanTrat']))."
    ,[DURTRAT] = ".Valor(str_replace(",", ".",$result[$i]['medicamentos'][$p]['DurTrat']))."
    ,[CANTTOTALF] = ".Valor(str_replace(",", ".",$result[$i]['medicamentos'][$p]['CantTotalF']))."
    ,[UFCANTTOTAL] = '".$result[$i]['medicamentos'][$p]['UFCantTotal']."'
    ,[INDREC] = '".$result[$i]['medicamentos'][$p]['IndRec']."'
    WHERE NOPRESCRIPCION = '".$result[$i]['tutela']['NoTutela']."' AND CONORDEN = '".$result[$i]['medicamentos'][$p]['ConOrden']."'

    END";

echo "Medicamento: ".$result[$i]['tutela']['NoTutela']." Consecutivo: ".$result[$i]['medicamentos'][$p]['ConOrden']." Resultado: ".sql($conn,$sql_medicamento)."<br>";
}
}
}


for($i = 0, $size = count($result); $i < $size; ++$i){
  if (sizeof($result[$i]['medicamentos'])<>0){
    for($p = 0, $size_med= sizeof($result[$i]['medicamentos']); $p < $size_med; ++$p) {
      if (sizeof($result[$i]['medicamentos'][$p]['PrincipiosActivos'])<>0){
        for($u = 0, $size_Pact = sizeof($result[$i]['medicamentos'][$p]['PrincipiosActivos']); $u < $size_Pact; ++$u) {
    $sql_principio = "
    IF NOT EXISTS (SELECT NOPRESCRIPCION FROM [MIPRES_PRINCIPOACTIVO ] WHERE NOPRESCRIPCION = '".$result[$i]['tutela']['NoTutela']."' AND CONORDEN = '".$result[$i]['medicamentos'][$p]['PrincipiosActivos'][$u]['ConOrden']."')
    BEGIN 

    INSERT INTO [dbo].[MIPRES_PRINCIPOACTIVO ]
    ([NOPRESCRIPCION],[CONORDEN],[CODPRIACT],[CONCCANT],[UMEDCONC],[CANTCONT],[UMEDCANTCONT])
    VALUES
    ('".$result[$i]['tutela']['NoTutela']."'
    ,".Valor(str_replace(",", ".",$result[$i]['medicamentos'][$p]['PrincipiosActivos'][$u]['ConOrden']))."
    ,'".$result[$i]['medicamentos'][$p]['PrincipiosActivos'][$u]['CodPriAct']."'
    ,'".$result[$i]['medicamentos'][$p]['PrincipiosActivos'][$u]['ConcCant']."'
    ,'".$result[$i]['medicamentos'][$p]['PrincipiosActivos'][$u]['UMedConc']."'
    ,'".$result[$i]['medicamentos'][$p]['PrincipiosActivos'][$u]['CantCont']."'
    ,'".$result[$i]['medicamentos'][$p]['PrincipiosActivos'][$u]['UMedCantCont']."'
    )

    END ELSE BEGIN 

    UPDATE [dbo].[MIPRES_PRINCIPOACTIVO ]
    SET [NOPRESCRIPCION] = '".$result[$i]['tutela']['NoTutela']."'
    ,[CONORDEN] = ".Valor(str_replace(",", ".",$result[$i]['medicamentos'][$p]['PrincipiosActivos'][$u]['ConOrden']))."
    ,[CODPRIACT] = '".$result[$i]['medicamentos'][$p]['PrincipiosActivos'][$u]['CodPriAct']."'
    ,[CONCCANT] = '".$result[$i]['medicamentos'][$p]['PrincipiosActivos'][$u]['ConcCant']."'
    ,[UMEDCONC] = '".$result[$i]['medicamentos'][$p]['PrincipiosActivos'][$u]['UMedConc']."'
    ,[CANTCONT] = '".$result[$i]['medicamentos'][$p]['PrincipiosActivos'][$u]['CantCont']."'
    ,[UMEDCANTCONT] = '".$result[$i]['medicamentos'][$p]['PrincipiosActivos'][$u]['UMedCantCont']."'
    WHERE NOPRESCRIPCION = '".$result[$i]['tutela']['NoTutela']."' AND CONORDEN = '".$result[$i]['medicamentos'][$p]['PrincipiosActivos'][$u]['ConOrden']."'

    END"; 

echo "Prin. Activo: ".$result[$i]['tutela']['NoTutela']." Consecutivo Medicamento: ".$result[$i]['medicamentos'][$p]['ConOrden']." Consecutivo: ".$result[$i]['medicamentos'][$p]['PrincipiosActivos'][$u]['ConOrden']." Resultado: ".sql($conn,$sql_principio)."<br>";         
        }
      }
    }
  }
}



for($i = 0, $size = count($result); $i < $size; ++$i){
if (sizeof($result[$i]['fallosAdicionales'])<>0){
for($p = 0, $size_med= sizeof($result[$i]['fallosAdicionales']); $p < $size_med; ++$p) {
$sql_fallo = "
    IF NOT EXISTS (SELECT NOPRESCRIPCION FROM [MIPRES_FALLOTUTELASADI] WHERE NOPRESCRIPCION = '".$result[$i]['tutela']['NoTutela']."' AND FFALLOADIC = '".$result[$i]['fallosAdicionales'][$p]['FFalloAdic']."')
    BEGIN 

    INSERT INTO [dbo].[MIPRES_FALLOTUTELASADI]
    ([NOPRESCRIPCION],[FFALLOADIC],[NROFALLOADIC])
    VALUES
    ('".$result[$i]['tutela']['NoTutela']."'
    ,'".$result[$i]['fallosAdicionales'][$p]['FFalloAdic']."'
    ,'".$result[$i]['fallosAdicionales'][$p]['NroFalloAdic']."'
    )

    END ELSE BEGIN 
    UPDATE [dbo].[MIPRES_FALLOTUTELASADI]
    SET [NOPRESCRIPCION] = '".$result[$i]['tutela']['NoTutela']."'
    ,[FFALLOADIC] = '".$result[$i]['fallosAdicionales'][$p]['FFalloAdic']."'
    ,[NROFALLOADIC] = '".$result[$i]['fallosAdicionales'][$p]['NroFalloAdic']."'
    WHERE NOPRESCRIPCION = '".$result[$i]['tutela']['NoTutela']."' AND FFALLOADIC = '".$result[$i]['fallosAdicionales'][$p]['FFalloAdic']."'

    END";

echo "Fallo Adicional: ".$result[$i]['tutela']['NoTutela']." Fecha: ".$result[$i]['fallosAdicionales'][$p]['FFalloAdic']." Resultado: ".sql($conn,$sql_fallo)."<br>";
}
}
}


echo "<br>";
echo "<br>";

        print_r($result); 
        ?>  
        </pre>
        </div>
        </div>
        </div>
        <br>

<?php
}else
{
?>
<div class="alert alert-warning alert-dismissible">
<button type="button" class="close" data-dismiss="alert">&times;</button>
<strong>Solicitud con exito!</strong> No se encontraron Prescripciones.
</div>
<?php
}
break;

default:
            
            ?>
            <textarea id="resultado_mipres" class="form-control"  rows="7" disabled></textarea>            
      <?php
              
              ?>
              <script type="text/javascript">
              document.getElementById("resultado_mipres").value='<?php echo $mensaje_mipres ?>';
              </script>
              <?php
            break;

  }
}
?>

  </div>
</div>


    </div>
  </div>
</div>
</div>


</div>




    <script> 
    $( window ).on( "load", function() {
        $('#resultado_pr').modal('show');
    });
    </script>
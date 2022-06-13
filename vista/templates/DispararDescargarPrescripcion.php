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
    <li class="breadcrumb-item"><a  href="index.php?x=024">Prescripciones por Fecha</a></li>
  </ol>
</nav>


<div class="container">

<div class="row">
  <div class="col-md-3 sm-12">
    <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
      <a class="btn btn-light" id="v-pills-profile-tab" href="index.php?x=024"><center>Regresar</center></a>
    </div>
    <br>
    <center><div id="barra" class="spinner-border text-success" style = 'display:none;'></div></center>
  </div>
  <div class="col-md-9 sm-12">
  <div class="tab-content" id="v-pills-tabContent">

<div class="card ">
  <div class="card-header">
    <H4>Prescripciones por Fecha</H4>
  </div>
  <div class="card-body">      

<?php
set_time_limit(1000);
//ERROR0006
  if (!empty($_SESSION['NIT_EPS'])){   


     $sql = "SELECT * FROM PRS_URL_SERVICES WHERE COD_URL = '2' ";
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
        <a class="list-group-item list-group-item-action list-group-item-info"><span class="badge badge-info badge-pill"><?php echo count($result); ?></span> Prescripciones encontradas <?php echo  $_POST['var_fecha'];?></a>
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
    IF NOT EXISTS (SELECT NOPRESCRIPCION FROM MIPRES_PRESCRIPCION WHERE NOPRESCRIPCION = '".$result[$i]['prescripcion']['NoPrescripcion']."' )
    BEGIN 
    INSERT INTO [dbo].[MIPRES_PRESCRIPCION ]
    ([NOPRESCRIPCION],[FPRESCRIPCION],[HPRESCRIPCION],[CODHABIPS],[TIPOIDIPS],[NROIDIPS],[CODDANEMUNIPS],[DIRSEDEIPS],[TELSEDEIPS],[TIPOIDPROF],[NUMIDPROF],[PNPROFS],[SNPROFS],[PAPROFS],[SAPROFS],[REGPROFS],[TIPOIDPACIENTE],[NROIDPACIENTE],[PNPACIENTE],[SNPACIENTE],[PAPACIENTE],[SAPACIENTE],[CODAMBATE],[ENFHUERFANA],[CODENFHUERFANA],[CODDXPPAL],[CODDXREL1],[CODDXREL2],[SOPNUTRICIONAL],[CODEPS],[TIPOIDMADREPACIENTE],[NROIDMADREPACIENTE],[TIPOTRANSC],[TIPOIDDONANTEVIVO],[NROIDDONANTEVIVO],[ESTPRES],[MIDORDENITEM],[USU_CARGUE],[FEC_CRUCE],[REGIMEN],REPORTMIPRES)
    VALUES
    ('".$result[$i]['prescripcion']['NoPrescripcion']."'
    ,'".$result[$i]['prescripcion']['FPrescripcion']."'
    ,'".$result[$i]['prescripcion']['HPrescripcion']."'
    ,".Valor(str_replace(",", ".",$result[$i]['prescripcion']['CodHabIPS']))."
    ,'".$result[$i]['prescripcion']['TipoIDIPS']."'
    ,'".CompletarCeros($result[$i]['prescripcion']['NroIDIPS'], 15)."'
    ,'".$result[$i]['prescripcion']['CodDANEMunIPS']."'
    ,'".$result[$i]['prescripcion']['DirSedeIPS']."'
    ,'".$result[$i]['prescripcion']['TelSedeIPS']."'
    ,'".$result[$i]['prescripcion']['TipoIDProf']."'
    ,".Valor(str_replace(",", ".",$result[$i]['prescripcion']['NumIDProf']))."
    ,'".$result[$i]['prescripcion']['PNProfS']."'
    ,'".$result[$i]['prescripcion']['SNProfS']."'
    ,'".$result[$i]['prescripcion']['PAProfS']."'
    ,'".$result[$i]['prescripcion']['SAProfS']."'
    ,'".$result[$i]['prescripcion']['RegProfS']."'
    ,'".$result[$i]['prescripcion']['TipoIDPaciente']."'
    ,'".$result[$i]['prescripcion']['NroIDPaciente']."'
    ,'".$result[$i]['prescripcion']['PNPaciente']."'
    ,'".$result[$i]['prescripcion']['SNPaciente']."'
    ,'".$result[$i]['prescripcion']['PAPaciente']."'
    ,'".$result[$i]['prescripcion']['SAPaciente']."'
    ,".Valor(str_replace(",", ".",$result[$i]['prescripcion']['CodAmbAte']))."
    ,".Valor(str_replace(",", ".",$result[$i]['prescripcion']['EnfHuerfana']))."
    ,".Valor(str_replace(",", ".",$result[$i]['prescripcion']['CodEnfHuerfana']))."
    ,'".$result[$i]['prescripcion']['CodDxPpal']."'
    ,'".$result[$i]['prescripcion']['CodDxRel1']."'
    ,'".$result[$i]['prescripcion']['CodDxRel2']."'
    ,".Valor(str_replace(",", ".",$result[$i]['prescripcion']['SopNutricional']))."
    ,'".$result[$i]['prescripcion']['CodEPS']."'
    ,'".$result[$i]['prescripcion']['TipoIDMadrePaciente']."'
    ,'".$result[$i]['prescripcion']['NroIDMadrePaciente']."'
    ,".Valor(str_replace(",", ".",$result[$i]['prescripcion']['TipoTransc']))."
    ,'".$result[$i]['prescripcion']['TipoIDDonanteVivo']."'
    ,'".$result[$i]['prescripcion']['NroIDDonanteVivo']."'
    ,".Valor(str_replace(",", ".",$result[$i]['prescripcion']['EstPres']))."
    ,".Valor(IDORDENITEM($conn,$result[$i]['prescripcion']['TipoIDPaciente'],$result[$i]['prescripcion']['NroIDPaciente']))."
    ,'".$_SESSION["usuario"]."'
    ,CURRENT_TIMESTAMP
    ,'".$_POST['var_regimen']."'
    ,'NOPRESCRIPCION')
    END ELSE BEGIN 
    UPDATE [dbo].[MIPRES_PRESCRIPCION ]
    SET [NOPRESCRIPCION] = '".$result[$i]['prescripcion']['NoPrescripcion']."'
    ,[FPRESCRIPCION] = '".$result[$i]['prescripcion']['FPrescripcion']."'
    ,[HPRESCRIPCION] = '".$result[$i]['prescripcion']['HPrescripcion']."'
    ,[CODHABIPS] = ".Valor(str_replace(",", ".",$result[$i]['prescripcion']['CodHabIPS']))."
    ,[TIPOIDIPS] = '".$result[$i]['prescripcion']['TipoIDIPS']."'
    ,[NROIDIPS] = '".CompletarCeros($result[$i]['prescripcion']['NroIDIPS'], 15)."'
    ,[CODDANEMUNIPS] = '".$result[$i]['prescripcion']['CodDANEMunIPS']."'
    ,[DIRSEDEIPS] = '".$result[$i]['prescripcion']['DirSedeIPS']."'
    ,[TELSEDEIPS] = '".$result[$i]['prescripcion']['TelSedeIPS']."'
    ,[TIPOIDPROF] = '".$result[$i]['prescripcion']['TipoIDProf']."'
    ,[NUMIDPROF] = ".Valor(str_replace(",", ".",$result[$i]['prescripcion']['NumIDProf']))."
    ,[PNPROFS] = '".$result[$i]['prescripcion']['PNProfS']."'
    ,[SNPROFS] = '".$result[$i]['prescripcion']['SNProfS']."'
    ,[PAPROFS] = '".$result[$i]['prescripcion']['PAProfS']."'
    ,[SAPROFS] = '".$result[$i]['prescripcion']['SAProfS']."'
    ,[REGPROFS] = '".$result[$i]['prescripcion']['RegProfS']."'
    ,[TIPOIDPACIENTE] = '".$result[$i]['prescripcion']['TipoIDPaciente']."'
    ,[NROIDPACIENTE] = '".$result[$i]['prescripcion']['NroIDPaciente']."'
    ,[PNPACIENTE] = '".$result[$i]['prescripcion']['PNPaciente']."'
    ,[SNPACIENTE] = '".$result[$i]['prescripcion']['SNPaciente']."'
    ,[PAPACIENTE] = '".$result[$i]['prescripcion']['PAPaciente']."'
    ,[SAPACIENTE] = '".$result[$i]['prescripcion']['SAPaciente']."'
    ,[CODAMBATE] = ".Valor(str_replace(",", ".",$result[$i]['prescripcion']['CodAmbAte']))."
    ,[ENFHUERFANA] = ".Valor(str_replace(",", ".",$result[$i]['prescripcion']['EnfHuerfana']))."
    ,[CODENFHUERFANA] = ".Valor(str_replace(",", ".",$result[$i]['prescripcion']['CodEnfHuerfana']))."
    ,[CODDXPPAL] = '".$result[$i]['prescripcion']['CodDxPpal']."'
    ,[CODDXREL1] = '".$result[$i]['prescripcion']['CodDxRel1']."'
    ,[CODDXREL2] = '".$result[$i]['prescripcion']['CodDxRel2']."'
    ,[SOPNUTRICIONAL] = ".Valor(str_replace(",", ".",$result[$i]['prescripcion']['SopNutricional']))."
    ,[CODEPS] = '".$result[$i]['prescripcion']['CodEPS']."'
    ,[TIPOIDMADREPACIENTE] = '".$result[$i]['prescripcion']['TipoIDMadrePaciente']."'
    ,[NROIDMADREPACIENTE] = '".$result[$i]['prescripcion']['NroIDMadrePaciente']."'
    ,[TIPOTRANSC] = ".Valor(str_replace(",", ".",$result[$i]['prescripcion']['TipoTransc']))."
    ,[TIPOIDDONANTEVIVO] = '".$result[$i]['prescripcion']['TipoIDDonanteVivo']."'
    ,[NROIDDONANTEVIVO] = '".$result[$i]['prescripcion']['NroIDDonanteVivo']."'
    ,[ESTPRES] = ".Valor(str_replace(",", ".",$result[$i]['prescripcion']['EstPres']))."
    ,[MIDORDENITEM] = ".Valor(IDORDENITEM($conn,$result[$i]['prescripcion']['TipoIDPaciente'],$result[$i]['prescripcion']['NroIDPaciente']))."
    ,[USU_CARGUE] = '".$_SESSION["usuario"]."'
    ,[FEC_CRUCE] = CURRENT_TIMESTAMP
    ,[REGIMEN] = '".$_POST['var_regimen']."'
    WHERE NOPRESCRIPCION = '".$result[$i]['prescripcion']['NoPrescripcion']."'
    END";
echo "Prescripción: ".$result[$i]['prescripcion']['NoPrescripcion']." Resultado: ".sql($conn,$sql)."<br>";
}

for($i = 0, $size = count($result); $i < $size; ++$i) {
if (sizeof($result[$i]['procedimientos'])<>0){
for($p = 0, $size_Pro = sizeof($result[$i]['procedimientos']); $p < $size_Pro; ++$p) {
$sql_procedimientos = "
    IF NOT EXISTS (SELECT NOPRESCRIPCION FROM [MIPRES_PROCEDIMIENTOS] WHERE NOPRESCRIPCION = '".$result[$i]['prescripcion']['NoPrescripcion']."' AND CONORDEN = '".$result[$i]['procedimientos'][$p]['ConOrden']."')
    BEGIN 

    INSERT INTO [dbo].[MIPRES_PROCEDIMIENTOS]
    ([NOPRESCRIPCION],[CONORDEN],[TIPOPREST],[CAUSAS11],[CAUSAS12],[CAUSAS2],[CAUSAS3],[CAUSAS4],[PROPBSUTILIZADO],[CAUSAS5],[PROPBSDESCARTADO],[RZNCAUSAS51],[DESCRZN51],[RZNCAUSAS52],[DESCRZN52],[CAUSAS6],[CAUSAS7],[CODCUPS],[CANFORM],[CODFREUSO],[CANT] ,[CODPERDURTRAT],[JUSTNOPBS],[INDREC],[ESTJM])
    VALUES
    ('".$result[$i]['prescripcion']['NoPrescripcion']."'
    ,".Valor(str_replace(",", ".",$result[$i]['procedimientos'][$p]['ConOrden']))."
    ,".Valor(str_replace(",", ".",$result[$i]['procedimientos'][$p]['TipoPrest']))."
    ,".Valor(str_replace(",", ".",$result[$i]['procedimientos'][$p]['CausaS11']))."
    ,".Valor(str_replace(",", ".",$result[$i]['procedimientos'][$p]['CausaS12']))."
    ,".Valor(str_replace(",", ".",$result[$i]['procedimientos'][$p]['CausaS2']))."
    ,".Valor(str_replace(",", ".",$result[$i]['procedimientos'][$p]['CausaS3']))."
    ,".Valor(str_replace(",", ".",$result[$i]['procedimientos'][$p]['CausaS4']))."
    ,'".$result[$i]['procedimientos'][$p]['ProPBSUtilizado']."'
    ,".Valor(str_replace(",", ".",$result[$i]['procedimientos'][$p]['CausaS5']))."
    ,'".$result[$i]['procedimientos'][$p]['ProPBSDescartado']."'
    ,".Valor(str_replace(",", ".",$result[$i]['procedimientos'][$p]['RznCausaS51']))."
    ,'".$result[$i]['procedimientos'][$p]['DescRzn51']."'
    ,".Valor(str_replace(",", ".",$result[$i]['procedimientos'][$p]['RznCausaS52']))."
    ,'".$result[$i]['procedimientos'][$p]['DescRzn52']."'
    ,".Valor(str_replace(",", ".",$result[$i]['procedimientos'][$p]['CausaS6']))."
    ,".Valor(str_replace(",", ".",$result[$i]['procedimientos'][$p]['CausaS7']))."
    ,'".$result[$i]['procedimientos'][$p]['CodCUPS']."'
    ,".Valor(str_replace(",", ".",$result[$i]['procedimientos'][$p]['CanForm']))."
    ,".Valor(str_replace(",", ".",$result[$i]['procedimientos'][$p]['CodFreUso']))."
    ,".Valor(str_replace(",", ".",$result[$i]['procedimientos'][$p]['Cant']))."
    ,".Valor(str_replace(",", ".",$result[$i]['procedimientos'][$p]['CodPerDurTrat']))."
    ,'".$result[$i]['procedimientos'][$p]['JustNoPBS']."'
    ,'".$result[$i]['procedimientos'][$p]['IndRec']."'
    ,".Valor(str_replace(",", ".",$result[$i]['procedimientos'][$p]['EstJM']))."
    )

    END ELSE BEGIN 

    UPDATE [dbo].[MIPRES_PROCEDIMIENTOS]
    SET [NOPRESCRIPCION] = '".$result[$i]['prescripcion']['NoPrescripcion']."'
    ,[CONORDEN] = ".Valor(str_replace(",", ".",$result[$i]['procedimientos'][$p]['ConOrden']))."
    ,[TIPOPREST] = ".Valor(str_replace(",", ".",$result[$i]['procedimientos'][$p]['TipoPrest']))."
    ,[CAUSAS11] = ".Valor(str_replace(",", ".",$result[$i]['procedimientos'][$p]['CausaS11']))."
    ,[CAUSAS12] = ".Valor(str_replace(",", ".",$result[$i]['procedimientos'][$p]['CausaS12']))."
    ,[CAUSAS2] = ".Valor(str_replace(",", ".",$result[$i]['procedimientos'][$p]['CausaS2']))."
    ,[CAUSAS3] = ".Valor(str_replace(",", ".",$result[$i]['procedimientos'][$p]['CausaS3']))."
    ,[CAUSAS4] = ".Valor(str_replace(",", ".",$result[$i]['procedimientos'][$p]['CausaS4']))."
    ,[PROPBSUTILIZADO] = '".$result[$i]['procedimientos'][$p]['ProPBSUtilizado']."'
    ,[CAUSAS5] = ".Valor(str_replace(",", ".",$result[$i]['procedimientos'][$p]['CausaS5']))."
    ,[PROPBSDESCARTADO] = '".$result[$i]['procedimientos'][$p]['ProPBSDescartado']."'
    ,[RZNCAUSAS51] = ".Valor(str_replace(",", ".",$result[$i]['procedimientos'][$p]['RznCausaS51']))."
    ,[DESCRZN51] = '".$result[$i]['procedimientos'][$p]['DescRzn51']."'
    ,[RZNCAUSAS52] = ".Valor(str_replace(",", ".",$result[$i]['procedimientos'][$p]['RznCausaS52']))."
    ,[DESCRZN52] = '".$result[$i]['procedimientos'][$p]['DescRzn52']."'
    ,[CAUSAS6] = ".Valor(str_replace(",", ".",$result[$i]['procedimientos'][$p]['CausaS6']))."
    ,[CAUSAS7] = ".Valor(str_replace(",", ".",$result[$i]['procedimientos'][$p]['CausaS7']))."
    ,[CODCUPS] = '".$result[$i]['procedimientos'][$p]['CodCUPS']."'
    ,[CANFORM] = ".Valor(str_replace(",", ".",$result[$i]['procedimientos'][$p]['CanForm']))."
    ,[CODFREUSO] = ".Valor(str_replace(",", ".",$result[$i]['procedimientos'][$p]['CodFreUso']))."
    ,[CANT] = ".Valor(str_replace(",", ".",$result[$i]['procedimientos'][$p]['Cant']))."
    ,[CODPERDURTRAT] = ".Valor(str_replace(",", ".",$result[$i]['procedimientos'][$p]['CodPerDurTrat']))."
    ,[JUSTNOPBS] = '".$result[$i]['procedimientos'][$p]['JustNoPBS']."'
    ,[INDREC] = '".$result[$i]['procedimientos'][$p]['IndRec']."'
    ,[ESTJM] = ".Valor(str_replace(",", ".",$result[$i]['procedimientos'][$p]['EstJM']))."
    WHERE NOPRESCRIPCION = '".$result[$i]['prescripcion']['NoPrescripcion']."' AND CONORDEN = '".$result[$i]['procedimientos'][$p]['ConOrden']."'
    END";
echo "Procedimiento: ".$result[$i]['prescripcion']['NoPrescripcion']." Consecutivo: ".$result[$i]['procedimientos'][$p]['ConOrden']." Resultado: ".sql($conn,$sql_procedimientos)."<br>";
}
}
}

for($i = 0, $size = count($result); $i < $size; ++$i){
if (sizeof($result[$i]['productosnutricionales'])<>0){
for($f = 0, $size_Nutr = sizeof($result[$i]['productosnutricionales']); $f < $size_Nutr; ++$f){
$sql_nutricionales = "
    IF NOT EXISTS (SELECT NOPRESCRIPCION FROM [MIPRES_NUTRICIONALES] WHERE NOPRESCRIPCION = '".$result[$i]['prescripcion']['NoPrescripcion']."' AND CONORDEN = '".$result[$i]['productosnutricionales'][$f]['ConOrden']."')
    BEGIN 

    INSERT INTO [dbo].[MIPRES_NUTRICIONALES]
    ([NOPRESCRIPCION],[CONORDEN],[TIPOPREST],[CAUSAS1],[CAUSAS2],[CAUSAS3],[CAUSAS4],[PRONUTUTILIZADO],[RZNCAUSAS41],[DESCRZN41],[RZNCAUSAS42],[DESCRZN42],[CAUSAS5],[PRONUTDESCARTADO],[RZNCAUSAS51],[DESCRZN51],[RZNCAUSAS52],[DESCRZN52],[RZNCAUSAS53],[DESCRZN53],[RZNCAUSAS54],[DESCRZN54],[TIPPPRONUT],[DESCPRODNUTR],[CODFORMA],[CODVIAADMON],[JUSTNOPBS],[DOSIS],[DOSISUM],[NOFADMON],[CODFREADMON],[CANTRAT],[DURTRAT],[CANTTOTALF],[UFCANTTOTAL],[INDREC],[NOPRESCASO],[ESTJM],[DXENFHUER],[DXVIH],[DXCAPAL],[DXENFRCEV],[INDESP])
    VALUES
    ('".$result[$i]['prescripcion']['NoPrescripcion']."'
    ,".Valor(str_replace(",", ".",$result[$i]['productosnutricionales'][$f]['ConOrden']))."
    ,".Valor(str_replace(",", ".",$result[$i]['productosnutricionales'][$f]['TipoPrest']))."
    ,".Valor(str_replace(",", ".",$result[$i]['productosnutricionales'][$f]['CausaS1']))."
    ,".Valor(str_replace(",", ".",$result[$i]['productosnutricionales'][$f]['CausaS2']))."
    ,".Valor(str_replace(",", ".",$result[$i]['productosnutricionales'][$f]['CausaS3']))."
    ,".Valor(str_replace(",", ".",$result[$i]['productosnutricionales'][$f]['CausaS4']))."
    ,'".$result[$i]['productosnutricionales'][$f]['ProNutUtilizado']."'
    ,".Valor(str_replace(",", ".",$result[$i]['productosnutricionales'][$f]['RznCausaS41']))."
    ,'".$result[$i]['productosnutricionales'][$f]['DescRzn41']."'
    ,".Valor(str_replace(",", ".",$result[$i]['productosnutricionales'][$f]['RznCausaS42']))."
    ,'".$result[$i]['productosnutricionales'][$f]['DescRzn42']."'
    ,".Valor(str_replace(",", ".",$result[$i]['productosnutricionales'][$f]['CausaS5']))."
    ,'".$result[$i]['productosnutricionales'][$f]['ProNutDescartado']."'
    ,".Valor(str_replace(",", ".",$result[$i]['productosnutricionales'][$f]['RznCausaS51']))."
    ,'".$result[$i]['productosnutricionales'][$f]['DescRzn51']."'
    ,".Valor(str_replace(",", ".",$result[$i]['productosnutricionales'][$f]['RznCausaS52']))."
    ,'".$result[$i]['productosnutricionales'][$f]['DescRzn52']."'
    ,".Valor(str_replace(",", ".",$result[$i]['productosnutricionales'][$f]['RznCausaS53']))."
    ,'".$result[$i]['productosnutricionales'][$f]['DescRzn53']."'
    ,".Valor(str_replace(",", ".",$result[$i]['productosnutricionales'][$f]['RznCausaS54']))."
    ,'".$result[$i]['productosnutricionales'][$f]['DescRzn54']."'
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
    ,'".$result[$i]['productosnutricionales'][$f]['NoPrescAso']."'
    ,".Valor(str_replace(",", ".",$result[$i]['productosnutricionales'][$f]['EstJM']))."
    ,'".$result[$i]['productosnutricionales'][$f]['DXEnfHuer']."'
    ,'".$result[$i]['productosnutricionales'][$f]['DXVIH']."'
    ,'".$result[$i]['productosnutricionales'][$f]['DXCaPal']."'
    ,'".$result[$i]['productosnutricionales'][$f]['DXEnfRCEV']."'
    ,".Valor(str_replace(",", ".",$result[$i]['productosnutricionales'][$f]['IndEsp']))."
    )

    END ELSE BEGIN 

    UPDATE [dbo].[MIPRES_NUTRICIONALES]
    SET [NOPRESCRIPCION] = '".$result[$i]['prescripcion']['NoPrescripcion']."'
    ,[CONORDEN] = ".Valor(str_replace(",", ".",$result[$i]['productosnutricionales'][$f]['ConOrden']))."
    ,[TIPOPREST] = ".Valor(str_replace(",", ".",$result[$i]['productosnutricionales'][$f]['TipoPrest']))."
    ,[CAUSAS1] = ".Valor(str_replace(",", ".",$result[$i]['productosnutricionales'][$f]['CausaS1']))."
    ,[CAUSAS2] = ".Valor(str_replace(",", ".",$result[$i]['productosnutricionales'][$f]['CausaS2']))."
    ,[CAUSAS3] = ".Valor(str_replace(",", ".",$result[$i]['productosnutricionales'][$f]['CausaS3']))."
    ,[CAUSAS4] = ".Valor(str_replace(",", ".",$result[$i]['productosnutricionales'][$f]['CausaS4']))."
    ,[PRONUTUTILIZADO] = '".$result[$i]['productosnutricionales'][$f]['ProNutUtilizado']."'
    ,[RZNCAUSAS41] = ".Valor(str_replace(",", ".",$result[$i]['productosnutricionales'][$f]['RznCausaS41']))."
    ,[DESCRZN41] = '".$result[$i]['productosnutricionales'][$f]['DescRzn41']."'
    ,[RZNCAUSAS42] = ".Valor(str_replace(",", ".",$result[$i]['productosnutricionales'][$f]['RznCausaS42']))."
    ,[DESCRZN42] = '".$result[$i]['productosnutricionales'][$f]['DescRzn42']."'
    ,[CAUSAS5] = ".Valor(str_replace(",", ".",$result[$i]['productosnutricionales'][$f]['CausaS5']))."
    ,[PRONUTDESCARTADO]='".$result[$i]['productosnutricionales'][$f]['ProNutDescartado']."'
    ,[RZNCAUSAS51] = ".Valor(str_replace(",", ".",$result[$i]['productosnutricionales'][$f]['RznCausaS51']))."
    ,[DESCRZN51] = '".$result[$i]['productosnutricionales'][$f]['DescRzn51']."'
    ,[RZNCAUSAS52] = ".Valor(str_replace(",", ".",$result[$i]['productosnutricionales'][$f]['RznCausaS52']))."
    ,[DESCRZN52] = '".$result[$i]['productosnutricionales'][$f]['DescRzn52']."'
    ,[RZNCAUSAS53] = ".Valor(str_replace(",", ".",$result[$i]['productosnutricionales'][$f]['RznCausaS53']))."
    ,[DESCRZN53] = '".$result[$i]['productosnutricionales'][$f]['DescRzn53']."'
    ,[RZNCAUSAS54] = ".Valor(str_replace(",", ".",$result[$i]['productosnutricionales'][$f]['RznCausaS54']))."
    ,[DESCRZN54] = '".$result[$i]['productosnutricionales'][$f]['DescRzn54']."'
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
    ,[NOPRESCASO] = '".$result[$i]['productosnutricionales'][$f]['NoPrescAso']."'
    ,[ESTJM] = ".Valor(str_replace(",", ".",$result[$i]['productosnutricionales'][$f]['EstJM']))."
    ,[DXENFHUER] = '".$result[$i]['productosnutricionales'][$f]['DXEnfHuer']."'
    ,[DXVIH] = '".$result[$i]['productosnutricionales'][$f]['DXVIH']."'
    ,[DXCAPAL] = '".$result[$i]['productosnutricionales'][$f]['DXCaPal']."'
    ,[DXENFRCEV] = '".$result[$i]['productosnutricionales'][$f]['DXEnfRCEV']."'
    ,[INDESP] = ".Valor(str_replace(",", ".",$result[$i]['productosnutricionales'][$f]['IndEsp']))."
    WHERE NOPRESCRIPCION = '".$result[$i]['prescripcion']['NoPrescripcion']."' AND CONORDEN = '".$result[$i]['productosnutricionales'][$f]['ConOrden']."'
    END";

echo "Prod. Nutricional: ".$result[$i]['prescripcion']['NoPrescripcion']." Consecutivo: ".$result[$i]['productosnutricionales'][$f]['ConOrden']." Resultado: ".sql($conn,$sql_nutricionales)."<br>";
}
}  
}


for($i = 0, $size = count($result); $i < $size; ++$i){
if (sizeof($result[$i]['serviciosComplementarios'])<>0){
for($p = 0, $size_Comp = sizeof($result[$i]['serviciosComplementarios']); $p < $size_Comp; ++$p) {
$sql_complementarios = "
    IF NOT EXISTS (SELECT NOPRESCRIPCION FROM [MIPRES_COMPLEMENTARIOS] WHERE NOPRESCRIPCION = '".$result[$i]['prescripcion']['NoPrescripcion']."' AND CONORDEN = '".$result[$i]['serviciosComplementarios'][$p]['ConOrden']."')
    BEGIN 

    INSERT INTO [dbo].[MIPRES_COMPLEMENTARIOS]
    ([NOPRESCRIPCION],[CONORDEN],[TIPOPREST],[CAUSAS1],[CAUSAS2],[CAUSAS3],[CAUSAS4],[DESCCAUSAS4],[CAUSAS5],[CODSERCOMP],[DESCSERCOMP],[CANFORM],[CODFREUSO],[CANT],[CODPERDURTRAT],[JUSTNOPBS],[INDREC],[ESTJM])
    VALUES
    ('".$result[$i]['prescripcion']['NoPrescripcion']."'
    ,".Valor(str_replace(",", ".",$result[$i]['serviciosComplementarios'][$p]['ConOrden']))."
    ,".Valor(str_replace(",", ".",$result[$i]['serviciosComplementarios'][$p]['TipoPrest']))."
    ,".Valor(str_replace(",", ".",$result[$i]['serviciosComplementarios'][$p]['CausaS1']))."
    ,".Valor(str_replace(",", ".",$result[$i]['serviciosComplementarios'][$p]['CausaS2']))."
    ,".Valor(str_replace(",", ".",$result[$i]['serviciosComplementarios'][$p]['CausaS3']))."
    ,".Valor(str_replace(",", ".",$result[$i]['serviciosComplementarios'][$p]['CausaS4']))."
    ,'".$result[$i]['serviciosComplementarios'][$p]['DescCausaS4']."'
    ,".Valor(str_replace(",", ".",$result[$i]['serviciosComplementarios'][$p]['CausaS5']))."
    ,".Valor(str_replace(",", ".",$result[$i]['serviciosComplementarios'][$p]['CodSerComp']))."
    ,'".$result[$i]['serviciosComplementarios'][$p]['DescSerComp']."'
    ,".Valor(str_replace(",", ".",$result[$i]['serviciosComplementarios'][$p]['CanForm']))."
    ,".Valor(str_replace(",", ".",$result[$i]['serviciosComplementarios'][$p]['CodFreUso']))."
    ,".Valor(str_replace(",", ".",$result[$i]['serviciosComplementarios'][$p]['Cant']))."
    ,".Valor(str_replace(",", ".",$result[$i]['serviciosComplementarios'][$p]['CodPerDurTrat']))."
    ,'".$result[$i]['serviciosComplementarios'][$p]['JustNoPBS']."'
    ,'".$result[$i]['serviciosComplementarios'][$p]['IndRec']."'
    ,".Valor(str_replace(",", ".",$result[$i]['serviciosComplementarios'][$p]['EstJM']))."
    ) 
    END ELSE BEGIN 

    UPDATE [dbo].[MIPRES_COMPLEMENTARIOS]
    SET [NOPRESCRIPCION] = '".$result[$i]['prescripcion']['NoPrescripcion']."'
    ,[CONORDEN] = ".Valor(str_replace(",", ".",$result[$i]['serviciosComplementarios'][$p]['ConOrden']))."
    ,[TIPOPREST] = ".Valor(str_replace(",", ".",$result[$i]['serviciosComplementarios'][$p]['TipoPrest']))."
    ,[CAUSAS1] = ".Valor(str_replace(",", ".",$result[$i]['serviciosComplementarios'][$p]['CausaS1']))."
    ,[CAUSAS2] = ".Valor(str_replace(",", ".",$result[$i]['serviciosComplementarios'][$p]['CausaS2']))."
    ,[CAUSAS3] = ".Valor(str_replace(",", ".",$result[$i]['serviciosComplementarios'][$p]['CausaS3']))."
    ,[CAUSAS4] = ".Valor(str_replace(",", ".",$result[$i]['serviciosComplementarios'][$p]['CausaS4']))."
    ,[DESCCAUSAS4] = '".$result[$i]['serviciosComplementarios'][$p]['DescCausaS4']."'
    ,[CAUSAS5] = ".Valor(str_replace(",", ".",$result[$i]['serviciosComplementarios'][$p]['CausaS5']))."
    ,[CODSERCOMP] = ".Valor(str_replace(",", ".",$result[$i]['serviciosComplementarios'][$p]['CodSerComp']))."
    ,[DESCSERCOMP] = '".$result[$i]['serviciosComplementarios'][$p]['DescSerComp']."'
    ,[CANFORM] = ".Valor(str_replace(",", ".",$result[$i]['serviciosComplementarios'][$p]['CanForm']))."
    ,[CODFREUSO] = ".Valor(str_replace(",", ".",$result[$i]['serviciosComplementarios'][$p]['CodFreUso']))."
    ,[CANT] = ".Valor(str_replace(",", ".",$result[$i]['serviciosComplementarios'][$p]['Cant']))."
    ,[CODPERDURTRAT] = ".Valor(str_replace(",", ".",$result[$i]['serviciosComplementarios'][$p]['CodPerDurTrat']))."
    ,[JUSTNOPBS] = '".$result[$i]['serviciosComplementarios'][$p]['JustNoPBS']."'
    ,[INDREC] = '".$result[$i]['serviciosComplementarios'][$p]['IndRec']."'
    ,[ESTJM] = ".Valor(str_replace(",", ".",$result[$i]['serviciosComplementarios'][$p]['EstJM']))."
    WHERE NOPRESCRIPCION = '".$result[$i]['prescripcion']['NoPrescripcion']."' AND CONORDEN = '".$result[$i]['serviciosComplementarios'][$p]['ConOrden']."'

    END";

echo "Serv. Complementarios: ".$result[$i]['prescripcion']['NoPrescripcion']." Consecutivo: ".$result[$i]['serviciosComplementarios'][$p]['ConOrden']." Resultado: ".sql($conn,$sql_complementarios)."<br>";
}
}
}


for($i = 0, $size = count($result); $i < $size; ++$i){
if (sizeof($result[$i]['dispositivos'])<>0){
for($p = 0, $size_Dispo = sizeof($result[$i]['dispositivos']); $p < $size_Dispo; ++$p) {
$sql_dispositivos = "
    IF NOT EXISTS (SELECT NOPRESCRIPCION FROM [MIPRES_DISPOSITIVOS] WHERE NOPRESCRIPCION = '".$result[$i]['prescripcion']['NoPrescripcion']."' AND CONORDEN = '".$result[$i]['dispositivos'][$p]['ConOrden']."')
    BEGIN 

    INSERT INTO [dbo].[MIPRES_DISPOSITIVOS]
    ([NOPRESCRIPCION],[CONORDEN],[TIPOPREST],[CAUSAS1],[CODDISP],[CANFORM],[CODFREUSO],[CANT],[CODPERDURTRAT],[JUSTNOPBS],[INDREC],[ESTJM])
    VALUES
    ('".$result[$i]['prescripcion']['NoPrescripcion']."'
    ,".Valor(str_replace(",", ".",$result[$i]['dispositivos'][$p]['ConOrden']))."
    ,".Valor(str_replace(",", ".",$result[$i]['dispositivos'][$p]['TipoPrest']))."
    ,".Valor(str_replace(",", ".",$result[$i]['dispositivos'][$p]['CausaS1']))."
    ,'".$result[$i]['dispositivos'][$p]['CodDisp']."'
    ,".Valor(str_replace(",", ".",$result[$i]['dispositivos'][$p]['CanForm']))."
    ,".Valor(str_replace(",", ".",$result[$i]['dispositivos'][$p]['CodFreUso']))."
    ,".Valor(str_replace(",", ".",$result[$i]['dispositivos'][$p]['Cant']))."
    ,".Valor(str_replace(",", ".",$result[$i]['dispositivos'][$p]['CodPerDurTrat']))."
    ,'".$result[$i]['dispositivos'][$p]['JustNoPBS']."'
    ,'".$result[$i]['dispositivos'][$p]['IndRec']."'
    ,".Valor(str_replace(",", ".",$result[$i]['dispositivos'][$p]['EstJM']))."
    )
    END ELSE BEGIN 

    UPDATE [dbo].[MIPRES_DISPOSITIVOS]
    SET [NOPRESCRIPCION] = '".$result[$i]['prescripcion']['NoPrescripcion']."'
    ,[CONORDEN] = ".Valor(str_replace(",", ".",$result[$i]['dispositivos'][$p]['ConOrden']))."
    ,[TIPOPREST] = ".Valor(str_replace(",", ".",$result[$i]['dispositivos'][$p]['TipoPrest']))."
    ,[CAUSAS1] = ".Valor(str_replace(",", ".",$result[$i]['dispositivos'][$p]['CausaS1']))."
    ,[CODDISP] = '".$result[$i]['dispositivos'][$p]['CodDisp']."'
    ,[CANFORM] = ".Valor(str_replace(",", ".",$result[$i]['dispositivos'][$p]['CanForm']))."
    ,[CODFREUSO] = ".Valor(str_replace(",", ".",$result[$i]['dispositivos'][$p]['CodFreUso']))."
    ,[CANT] = ".Valor(str_replace(",", ".",$result[$i]['dispositivos'][$p]['Cant']))."
    ,[CODPERDURTRAT] = ".Valor(str_replace(",", ".",$result[$i]['dispositivos'][$p]['CodPerDurTrat']))."
    ,[JUSTNOPBS] = '".$result[$i]['dispositivos'][$p]['JustNoPBS']."'
    ,[INDREC] = '".$result[$i]['dispositivos'][$p]['IndRec']."'
    ,[ESTJM] = ".Valor(str_replace(",", ".",$result[$i]['dispositivos'][$p]['EstJM']))."
    WHERE NOPRESCRIPCION = '".$result[$i]['prescripcion']['NoPrescripcion']."' AND CONORDEN = '".$result[$i]['dispositivos'][$p]['ConOrden']."'

    END";
echo "Disp. Medicos: ".$result[$i]['prescripcion']['NoPrescripcion']." Consecutivo: ".$result[$i]['dispositivos'][$p]['ConOrden']." Resultado: ".sql($conn,$sql_dispositivos)."<br>";
}
}
}


for($i = 0, $size = count($result); $i < $size; ++$i){
if (sizeof($result[$i]['medicamentos'])<>0){
for($p = 0, $size_med= sizeof($result[$i]['medicamentos']); $p < $size_med; ++$p) {
$sql_medicamento = "
    IF NOT EXISTS (SELECT NOPRESCRIPCION FROM [MIPRES_MEDICAMENTOS ] WHERE NOPRESCRIPCION = '".$result[$i]['prescripcion']['NoPrescripcion']."' AND CONORDEN = '".$result[$i]['medicamentos'][$p]['ConOrden']."')
    BEGIN 

    INSERT INTO [dbo].[MIPRES_MEDICAMENTOS ]
    ([NOPRESCRIPCION],[CONORDEN],[TIPOMED],[TIPOPREST],[CAUSAS1],[CAUSAS2],[CAUSAS3],[MEDPBSUTILIZADO],[RZNCAUSAS31],[DESCRZN31],[RZNCAUSAS32],[DESCRZN32],[CAUSAS4],[MEDPBSDESCARTADO],[RZNCAUSAS41],[DESCRZN41],[RZNCAUSAS42],[DESCRZN42],[RZNCAUSAS43],[DESCRZN43],[RZNCAUSAS44],[DESCRZN44],[CAUSAS5],[RZNCAUSAS5],[CAUSAS6],[DESCMEDPRINACT],[CODFF],[CODVA],[JUSTNOPBS],[DOSIS],[DOSISUM],[NOFADMON],[CODFREADMON],[INDESP],[CANTRAT],[DURTRAT],[CANTTOTALF],[UFCANTTOTAL],[INDREC],[ESTJM])
    VALUES
    ('".$result[$i]['prescripcion']['NoPrescripcion']."'
    ,".Valor(str_replace(",", ".",$result[$i]['medicamentos'][$p]['ConOrden']))."
    ,".Valor(str_replace(",", ".",$result[$i]['medicamentos'][$p]['TipoMed']))."
    ,".Valor(str_replace(",", ".",$result[$i]['medicamentos'][$p]['TipoPrest']))."
    ,".Valor(str_replace(",", ".",$result[$i]['medicamentos'][$p]['CausaS1']))."
    ,".Valor(str_replace(",", ".",$result[$i]['medicamentos'][$p]['CausaS2']))."
    ,".Valor(str_replace(",", ".",$result[$i]['medicamentos'][$p]['CausaS3']))."
    ,'".$result[$i]['medicamentos'][$p]['MedPBSUtilizado']."'
    ,".Valor(str_replace(",", ".",$result[$i]['medicamentos'][$p]['RznCausaS31']))."
    ,'".$result[$i]['medicamentos'][$p]['DescRzn31']."'
    ,".Valor(str_replace(",", ".",$result[$i]['medicamentos'][$p]['RznCausaS32']))."
    ,'".$result[$i]['medicamentos'][$p]['DescRzn32']."'
    ,".Valor(str_replace(",", ".",$result[$i]['medicamentos'][$p]['CausaS4']))."
    ,'".$result[$i]['medicamentos'][$p]['MedPBSDescartado']."'
    ,".Valor(str_replace(",", ".",$result[$i]['medicamentos'][$p]['RznCausaS41']))."
    ,'".$result[$i]['medicamentos'][$p]['DescRzn41']."'
    ,".Valor(str_replace(",", ".",$result[$i]['medicamentos'][$p]['RznCausaS42']))."
    ,'".$result[$i]['medicamentos'][$p]['DescRzn42']."'
    ,".Valor(str_replace(",", ".",$result[$i]['medicamentos'][$p]['RznCausaS43']))."
    ,'".$result[$i]['medicamentos'][$p]['DescRzn43']."'
    ,".Valor(str_replace(",", ".",$result[$i]['medicamentos'][$p]['RznCausaS44']))."
    ,'".$result[$i]['medicamentos'][$p]['DescRzn44']."'
    ,".Valor(str_replace(",", ".",$result[$i]['medicamentos'][$p]['CausaS5']))."
    ,".Valor(str_replace(",", ".",$result[$i]['medicamentos'][$p]['RznCausaS5']))."
    ,".Valor(str_replace(",", ".",$result[$i]['medicamentos'][$p]['CausaS6']))."
    ,'".$result[$i]['medicamentos'][$p]['DescMedPrinAct']."'
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
    ,".Valor(str_replace(",", ".",$result[$i]['medicamentos'][$p]['EstJM']))."
    )

    END ELSE BEGIN 

    UPDATE [dbo].[MIPRES_MEDICAMENTOS ]
    SET [NOPRESCRIPCION] = '".$result[$i]['prescripcion']['NoPrescripcion']."'
    ,[CONORDEN] = ".Valor(str_replace(",", ".",$result[$i]['medicamentos'][$p]['ConOrden']))."
    ,[TIPOMED] = ".Valor(str_replace(",", ".",$result[$i]['medicamentos'][$p]['TipoMed']))."
    ,[TIPOPREST] = ".Valor(str_replace(",", ".",$result[$i]['medicamentos'][$p]['TipoPrest']))."
    ,[CAUSAS1] = ".Valor(str_replace(",", ".",$result[$i]['medicamentos'][$p]['CausaS1']))."
    ,[CAUSAS2] = ".Valor(str_replace(",", ".",$result[$i]['medicamentos'][$p]['CausaS2']))."
    ,[CAUSAS3] = ".Valor(str_replace(",", ".",$result[$i]['medicamentos'][$p]['CausaS3']))."
    ,[MEDPBSUTILIZADO] = '".$result[$i]['medicamentos'][$p]['MedPBSUtilizado']."'
    ,[RZNCAUSAS31] = ".Valor(str_replace(",", ".",$result[$i]['medicamentos'][$p]['RznCausaS31']))."
    ,[DESCRZN31] = '".$result[$i]['medicamentos'][$p]['DescRzn31']."'
    ,[RZNCAUSAS32] = ".Valor(str_replace(",", ".",$result[$i]['medicamentos'][$p]['RznCausaS32']))."
    ,[DESCRZN32] = '".$result[$i]['medicamentos'][$p]['DescRzn32']."'
    ,[CAUSAS4] = ".Valor(str_replace(",", ".",$result[$i]['medicamentos'][$p]['CausaS4']))."
    ,[MEDPBSDESCARTADO] = '".$result[$i]['medicamentos'][$p]['MedPBSDescartado']."'
    ,[RZNCAUSAS41] = ".Valor(str_replace(",", ".",$result[$i]['medicamentos'][$p]['RznCausaS41']))."
    ,[DESCRZN41] = '".$result[$i]['medicamentos'][$p]['DescRzn41']."'
    ,[RZNCAUSAS42] = ".Valor(str_replace(",", ".",$result[$i]['medicamentos'][$p]['RznCausaS42']))."
    ,[DESCRZN42] = '".$result[$i]['medicamentos'][$p]['DescRzn42']."'
    ,[RZNCAUSAS43] = ".Valor(str_replace(",", ".",$result[$i]['medicamentos'][$p]['RznCausaS43']))."
    ,[DESCRZN43] = '".$result[$i]['medicamentos'][$p]['DescRzn43']."'
    ,[RZNCAUSAS44] = ".Valor(str_replace(",", ".",$result[$i]['medicamentos'][$p]['RznCausaS44']))."
    ,[DESCRZN44] = '".$result[$i]['medicamentos'][$p]['DescRzn44']."'
    ,[CAUSAS5] = ".Valor(str_replace(",", ".",$result[$i]['medicamentos'][$p]['CausaS5']))."
    ,[RZNCAUSAS5] = ".Valor(str_replace(",", ".",$result[$i]['medicamentos'][$p]['RznCausaS5']))."
    ,[CAUSAS6] = ".Valor(str_replace(",", ".",$result[$i]['medicamentos'][$p]['CausaS6']))."
    ,[DESCMEDPRINACT] = '".$result[$i]['medicamentos'][$p]['DescMedPrinAct']."'
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
    ,[ESTJM] = ".Valor(str_replace(",", ".",$result[$i]['medicamentos'][$p]['EstJM']))."
    WHERE NOPRESCRIPCION = '".$result[$i]['prescripcion']['NoPrescripcion']."' AND CONORDEN = '".$result[$i]['medicamentos'][$p]['ConOrden']."'

    END";

echo "Medicamento: ".$result[$i]['prescripcion']['NoPrescripcion']." Consecutivo: ".$result[$i]['medicamentos'][$p]['ConOrden']." Resultado: ".sql($conn,$sql_medicamento)."<br>";
}
}
}


for($i = 0, $size = count($result); $i < $size; ++$i){
  if (sizeof($result[$i]['medicamentos'])<>0){
    for($p = 0, $size_med= sizeof($result[$i]['medicamentos']); $p < $size_med; ++$p) {
      if (sizeof($result[$i]['medicamentos'][$p]['PrincipiosActivos'])<>0){
        for($u = 0, $size_Pact = sizeof($result[$i]['medicamentos'][$p]['PrincipiosActivos']); $u < $size_Pact; ++$u) {
    $sql_principio = "
    IF NOT EXISTS (SELECT NOPRESCRIPCION FROM [MIPRES_PRINCIPOACTIVO ] WHERE NOPRESCRIPCION = '".$result[$i]['prescripcion']['NoPrescripcion']."' AND CONORDEN = '".$result[$i]['medicamentos'][$p]['PrincipiosActivos'][$u]['ConOrden']."')
    BEGIN 

    INSERT INTO [dbo].[MIPRES_PRINCIPOACTIVO ]
    ([NOPRESCRIPCION],[CONORDEN],[CODPRIACT],[CONCCANT],[UMEDCONC],[CANTCONT],[UMEDCANTCONT])
    VALUES
    ('".$result[$i]['prescripcion']['NoPrescripcion']."'
    ,".Valor(str_replace(",", ".",$result[$i]['medicamentos'][$p]['PrincipiosActivos'][$u]['ConOrden']))."
    ,'".$result[$i]['medicamentos'][$p]['PrincipiosActivos'][$u]['CodPriAct']."'
    ,'".$result[$i]['medicamentos'][$p]['PrincipiosActivos'][$u]['ConcCant']."'
    ,'".$result[$i]['medicamentos'][$p]['PrincipiosActivos'][$u]['UMedConc']."'
    ,'".$result[$i]['medicamentos'][$p]['PrincipiosActivos'][$u]['CantCont']."'
    ,'".$result[$i]['medicamentos'][$p]['PrincipiosActivos'][$u]['UMedCantCont']."'
    )

    END ELSE BEGIN 

    UPDATE [dbo].[MIPRES_PRINCIPOACTIVO ]
    SET [NOPRESCRIPCION] = '".$result[$i]['prescripcion']['NoPrescripcion']."'
    ,[CONORDEN] = ".Valor(str_replace(",", ".",$result[$i]['medicamentos'][$p]['PrincipiosActivos'][$u]['ConOrden']))."
    ,[CODPRIACT] = '".$result[$i]['medicamentos'][$p]['PrincipiosActivos'][$u]['CodPriAct']."'
    ,[CONCCANT] = '".$result[$i]['medicamentos'][$p]['PrincipiosActivos'][$u]['ConcCant']."'
    ,[UMEDCONC] = '".$result[$i]['medicamentos'][$p]['PrincipiosActivos'][$u]['UMedConc']."'
    ,[CANTCONT] = '".$result[$i]['medicamentos'][$p]['PrincipiosActivos'][$u]['CantCont']."'
    ,[UMEDCANTCONT] = '".$result[$i]['medicamentos'][$p]['PrincipiosActivos'][$u]['UMedCantCont']."'
    WHERE NOPRESCRIPCION = '".$result[$i]['prescripcion']['NoPrescripcion']."' AND CONORDEN = '".$result[$i]['medicamentos'][$p]['PrincipiosActivos'][$u]['ConOrden']."'

    END"; 

echo "Prin. Activo: ".$result[$i]['prescripcion']['NoPrescripcion']." Consecutivo Medicamento: ".$result[$i]['medicamentos'][$p]['ConOrden']." Consecutivo: ".$result[$i]['medicamentos'][$p]['PrincipiosActivos'][$u]['ConOrden']." Resultado: ".sql($conn,$sql_principio)."<br>";         
        }
      }
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




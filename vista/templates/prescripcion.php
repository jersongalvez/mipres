<?php
$file=$_POST['nombre_archivo'].".xls";
header("Content-Type: application/vnd.ms-excel charset=iso-8859-1");
header("Content-Disposition: attachment; filename=$file");
$JSON_decodificado = urldecode($_POST['data']);
$array = json_decode($JSON_decodificado, true);
?>


<html>
<head>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

</head>
<body>                                                               
  
    <table class="table table-bordered table-sm" border="1">
      <thead>
        <tr class="table-primary">
          <th rowspan="2">NoPrescripcion</th>
          <th rowspan="2">FPrescripcion</th>
          <th rowspan="2">HPrescripcion</th>
          <th rowspan="2">CodHabIPS</th>
          <th rowspan="2">TipoIDIPS</th>
          <th rowspan="2">NroIDIPS</th>
          <th rowspan="2">CodDANEMunIPS</th>
          <th rowspan="2">DirSedeIPS</th>
          <th rowspan="2">TelSedeIPS</th>
          <th rowspan="2">TipoIDProf</th>
          <th rowspan="2">PNProfS</th>
          <th rowspan="2">SNProfS</th>
          <th rowspan="2">SNProfS</th>
          <th rowspan="2">PAProfS</th>
          <th rowspan="2">SAProfS</th>
          <th rowspan="2">RegProfS</th>
          <th rowspan="2">TipoIDPaciente</th>
          <th rowspan="2">NroIDPaciente</th>
          <th rowspan="2">PNPaciente</th>
          <th rowspan="2">SNPaciente</th>
          <th rowspan="2">PAPaciente</th>
          <th rowspan="2">SAPaciente</th>
          <th rowspan="2">CodAmbAte</th>
          <th rowspan="2">RefAmbAte</th>
          <th rowspan="2">EnfHuerfana</th>
          <th rowspan="2">CodEnfHuerfana</th>
          <th rowspan="2">EnfHuerfanaDX</th>
          <th rowspan="2">CodDxPpal</th>
          <th rowspan="2">CodDxRel1</th>
          <th rowspan="2">CodDxRel2</th>
          <th rowspan="2">SopNutricional</th>
          <th rowspan="2">CodEPS</th>
          <th rowspan="2">TipoIDMadrePaciente</th>
          <th rowspan="2">NroIDMadrePaciente</th>
          <th rowspan="2">TipoTransc</th>
          <th rowspan="2">TipoIDDonanteVivo</th>
          <th rowspan="2">NroIDDonanteVivo</th>
          <th rowspan="2">EstPres</th>
          <th colspan="0" class="table-success">Procedimientos</th>
          <th colspan="0" class="table-warning">Medicamentos</th>
          <th colspan="0" class="table-info"   >productosnutricionales</th>
          <th colspan="0" class="table-danger" >serviciosComplementarios</th>
          <th colspan="0" class="table-secondary">dispositivos</th>
        </tr>
        <tr>
          <th colspan="0" class="table-success">
                <table border="1">
                <tr>
                <th>ConOrden</th>
                <th>TipoPrest</th>
                <th>CausaS11</th>
                <th>CausaS12</th>
                <th>CausaS2</th>
                <th>CausaS3</th>
                <th>CausaS4</th>
                <th>ProPBSUtilizado</th>
                <th>CausaS5</th>
                <th>ProPBSDescartado</th>
                <th>RznCausaS51</th>
                <th>DescRzn51</th>
                <th>DescRzn52</th>
                <th>CausaS6</th>
                <th>CausaS7</th>
                <th>CodCUPS</th>
                <th>CanForm</th>
                <th>CadaFreUso</th>
                <th>CodFreUso</th>
                <th>Cant</th>
                <th>CantTotal</th>
                <th>CodPerDurTrat</th>
                <th>JustNoPBS</th>
                <th>IndRec</th>
                <th>EstJM</th>
                </tr>
                </table>
          </th>
          <th colspan="0" class="table-warning">
                <table border="1">
                <tr>
                <th>ConOrden</th>
                <th>TipoMed</th>
                <th>TipoPrest</th>
                <th>CausaS1</th>
                <th>CausaS2</th>
                <th>CausaS3</th>
                <th>MedPBSUtilizado</th>
                <th>RznCausaS31</th>
                <th>DescRzn31</th>
                <th>RznCausaS32</th>
                <th>DescRzn32</th>
                <th>CausaS4</th>
                <th>MedPBSDescartado</th>
                <th>RznCausaS41</th>
                <th>DescRzn41</th>
                <th>RznCausaS42</th>
                <th>DescRzn42</th>
                <th>RznCausaS43</th>
                <th>DescRzn43</th>
                <th>RznCausaS44</th>
                <th>DescRzn44</th>
                <th>CausaS5</th>
                <th>RznCausaS5</th>
                <th>CausaS6</th>
                <th>DescMedPrinAct</th>
                <th>CodFF</th>
                <th>CodVA</th>
                <th>JustNoPBS</th>
                <th>Dosis</th>
                <th>DosisUM</th>
                <th>NoFAdmon</th>
                <th>CodFreAdmon</th>
                <th>IndEsp</th>
                <th>CanTrat</th>
                <th>DurTrat</th>
                <th>CantTotalF</th>
                <th>UFCantTotal</th>
                <th>IndRec</th>
                <th>EstJM</th>
                <th>PrincipiosActivos</th>
                <th>IndicacionesUNIRS</th>
                </tr>
                </table>
          </th>
          <th colspan="0" class="table-info">
                <table border="1">
                <tr>
                <th>ConOrden</th>
                <th>TipoPrest</th>
                <th>CausaS1</th>
                <th>CausaS2</th>
                <th>CausaS3</th>
                <th>CausaS4</th>
                <th>ProNutUtilizado</th>
                <th>RznCausaS41</th>
                <th>DescRzn41</th>
                <th>RznCausaS42</th>
                <th>DescRzn42</th>
                <th>CausaS5</th>
                <th>ProNutDescartado</th>
                <th>RznCausaS51</th>
                <th>DescRzn51</th>
                <th>RznCausaS52</th>
                <th>DescRzn52</th>
                <th>RznCausaS53</th>
                <th>DescRzn53</th>
                <th>RznCausaS54</th>
                <th>DescRzn54</th>
                <th>DXEnfHuer</th>
                <th>DXVIH</th>
                <th>DXCaPal</th>
                <th>DXEnfRCEV</th>
                <th>DXDesPro</th>
                <th>TippProNut</th>
                <th>DescProdNutr</th>
                <th>CodForma</th>
                <th>CodViaAdmon</th>
                <th>JustNoPBS</th>
                <th>Dosis</th>
                <th>DosisUM</th>
                <th>NoFAdmon</th>
                <th>CodFreAdmon</th>
                <th>IndEsp</th>
                <th>CanTrat</th>
                <th>DurTrat</th>
                <th>CantTotalF</th>
                <th>UFCantTotal</th>
                <th>IndRec</th>
                <th>NoPrescAso</th>
                <th>EstJM</th>
                </tr>
                </table>
          </th>
          <th colspan="0" class="table-danger">
                <table border="1">
                <tr>
                <th>ConOrden</th>
                <th>TipoPrest</th>
                <th>CausaS1</th>
                <th>CausaS2</th>
                <th>CausaS3</th>
                <th>CausaS4</th>
                <th>DescCausaS4</th>
                <th>CausaS5</th>
                <th>CodSerComp</th>
                <th>DescSerComp</th>
                <th>CanForm</th>
                <th>CadaFreUso</th>
                <th>CodFreUso</th>
                <th>Cant</th>
                <th>CantTotal</th>
                <th>CodPerDurTrat</th>
                <th>TipoTrans</th>
                <th>ReqAcom</th>
                <th>TipoIDAcomAlb</th>
                <th>NroIDAcomAlb</th>
                <th>ParentAcomAlb</th>
                <th>NombAlb</th>
                <th>CodMunOriAlb</th>
                <th>CodMunDesAlb</th>
                <th>JustNoPBS</th>
                <th>IndRec</th>
                <th>EstJM</th>
                </tr>
                </table>
          </th>
          <th colspan="0" class="table-secondary">
                <table border="1">
                <tr>
                <th>ConOrden</th>
                <th>TipoPrest</th>
                <th>CausaS1</th>
                <th>CodDisp</th>
                <th>CanForm</th>
                <th>CadaFreUso</th>
                <th>CodFreUso</th>
                <th>Cant</th>
                <th>CodPerDurTrat</th>
                <th>CantTotal</th>
                <th>JustNoPBS</th>
                <th>IndRec</th>
                <th>EstJM</th>
                </tr>
                </table>
          </th>
        </tr>
      </thead>
          <?php
          for($i = 0, $size = count($array); $i < $size; ++$i) {
          echo '<tr>
          <td>['.$i.']'.$array[$i]['prescripcion']['NoPrescripcion'].'</td>
          <td>'.$array[$i]['prescripcion']['FPrescripcion'].'</td>
          <td>'.$array[$i]['prescripcion']['HPrescripcion'].'</td>
          <td>['.$i.']'.$array[$i]['prescripcion']['CodHabIPS'].'</td>
          <td>'.$array[$i]['prescripcion']['TipoIDIPS'].'</td>
          <td>'.$array[$i]['prescripcion']['NroIDIPS'].'</td>
          <td>'.$array[$i]['prescripcion']['CodDANEMunIPS'].'</td>
          <td>'.$array[$i]['prescripcion']['DirSedeIPS'].'</td>
          <td>'.$array[$i]['prescripcion']['TelSedeIPS'].'</td>
          <td>'.$array[$i]['prescripcion']['TipoIDProf'].'</td>
          <td>'.$array[$i]['prescripcion']['NumIDProf'].'</td>
          <td>'.$array[$i]['prescripcion']['PNProfS'].'</td>
          <td>'.$array[$i]['prescripcion']['SNProfS'].'</td>
          <td>'.$array[$i]['prescripcion']['PAProfS'].'</td>
          <td>'.$array[$i]['prescripcion']['SAProfS'].'</td>
          <td>'.$array[$i]['prescripcion']['RegProfS'].'</td>
          <td>'.$array[$i]['prescripcion']['TipoIDPaciente'].'</td>
          <td>'.$array[$i]['prescripcion']['NroIDPaciente'].'</td>
          <td>'.$array[$i]['prescripcion']['PNPaciente'].'</td>
          <td>'.$array[$i]['prescripcion']['SNPaciente'].'</td>
          <td>'.$array[$i]['prescripcion']['PAPaciente'].'</td>
          <td>'.$array[$i]['prescripcion']['SAPaciente'].'</td>
          <td>'.$array[$i]['prescripcion']['CodAmbAte'].'</td>
          <td>'.$array[$i]['prescripcion']['RefAmbAte'].'</td>
          <td>'.$array[$i]['prescripcion']['EnfHuerfana'].'</td>
          <td>'.$array[$i]['prescripcion']['CodEnfHuerfana'].'</td>
          <td>'.$array[$i]['prescripcion']['EnfHuerfanaDX'].'</td>
          <td>'.$array[$i]['prescripcion']['CodDxPpal'].'</td>
          <td>'.$array[$i]['prescripcion']['CodDxRel1'].'</td>
          <td>'.$array[$i]['prescripcion']['CodDxRel2'].'</td>
          <td>'.$array[$i]['prescripcion']['SopNutricional'].'</td>
          <td>'.$array[$i]['prescripcion']['CodEPS'].'</td>
          <td>'.$array[$i]['prescripcion']['TipoIDMadrePaciente'].'</td>
          <td>'.$array[$i]['prescripcion']['NroIDMadrePaciente'].'</td>
          <td>'.$array[$i]['prescripcion']['TipoTransc'].'</td>
          <td>'.$array[$i]['prescripcion']['TipoIDDonanteVivo'].'</td>
          <td>'.$array[$i]['prescripcion']['NroIDDonanteVivo'].'</td>
          <td>'.$array[$i]['prescripcion']['EstPres'].'</td>';
          ?>




<!--- INICIO PROCEDIMIENTOS  --->
          <th>
<?php
if (sizeof($array[$i]['procedimientos'])<>0){
?>
 <table border="1">
<?php
for($p = 0, $size_Pro = sizeof($array[$i]['procedimientos']); $p < $size_Pro; ++$p) {
   echo '<tr>
             <td>'.$array[$i]['procedimientos'][$p]['ConOrden'].'</td>
             <td>'.$array[$i]['procedimientos'][$p]['TipoPrest'].'</td>
             <td>'.$array[$i]['procedimientos'][$p]['CausaS11'].'</td>
             <td>'.$array[$i]['procedimientos'][$p]['CausaS12'].'</td>
             <td>'.$array[$i]['procedimientos'][$p]['CausaS2'].'</td>
             <td>'.$array[$i]['procedimientos'][$p]['CausaS3'].'</td>
             <td>'.$array[$i]['procedimientos'][$p]['CausaS4'].'</td>
             <td>'.$array[$i]['procedimientos'][$p]['ProPBSUtilizado'].'</td>
             <td>'.$array[$i]['procedimientos'][$p]['ProPBSDescartado'].'</td>
             <td>'.$array[$i]['procedimientos'][$p]['CausaS5'].'</td>
             <td>'.$array[$i]['procedimientos'][$p]['ProPBSDescartado'].'</td>
             <td>'.$array[$i]['procedimientos'][$p]['RznCausaS51'].'</td>
             <td>'.$array[$i]['procedimientos'][$p]['DescRzn51'].'</td>
             <td>'.$array[$i]['procedimientos'][$p]['DescRzn52'].'</td>
             <td>'.$array[$i]['procedimientos'][$p]['CausaS6'].'</td>
             <td>'.$array[$i]['procedimientos'][$p]['CausaS7'].'</td>
             <td>'.$array[$i]['procedimientos'][$p]['CodCUPS'].'</td>
             <td>'.$array[$i]['procedimientos'][$p]['CanForm'].'</td>
             <td>'.$array[$i]['procedimientos'][$p]['CadaFreUso'].'</td>
             <td>'.$array[$i]['procedimientos'][$p]['CodFreUso'].'</td>
             <td>'.$array[$i]['procedimientos'][$p]['Cant'].'</td>
             <td>'.$array[$i]['procedimientos'][$p]['CodPerDurTrat'].'</td>
             <td>'.$array[$i]['procedimientos'][$p]['JustNoPBS'].'</td>
             <td>'.$array[$i]['procedimientos'][$p]['IndRec'].'</td>
             <td>'.$array[$i]['procedimientos'][$p]['EstJM'].'</td>
   </tr>';
}
?>
    </table>
<?php
}
?>
          </th>
<!---  FIN PROCEDIMIENTOS  --->

<!--- INICIO MEDICAMENTOS  --->
          <th>
<?php
if (sizeof($array[$i]['medicamentos'])<>0){
?>
 <table border="1">
<?php
for($p = 0, $size_med= sizeof($array[$i]['medicamentos']); $p < $size_med; ++$p) {
   echo '<tr>
   <td>'.$array[$i]['medicamentos'][$p]['ConOrden'].'</td>
   <td>'.$array[$i]['medicamentos'][$p]['TipoMed'].'</td>
   <td>'.$array[$i]['medicamentos'][$p]['TipoPrest'].'</td>
   <td>'.$array[$i]['medicamentos'][$p]['CausaS1'].'</td>
   <td>'.$array[$i]['medicamentos'][$p]['CausaS2'].'</td>
   <td>'.$array[$i]['medicamentos'][$p]['CausaS3'].'</td>
   <td>'.$array[$i]['medicamentos'][$p]['MedPBSUtilizado'].'</td>
   <td>'.$array[$i]['medicamentos'][$p]['RznCausaS31'].'</td>
   <td>'.$array[$i]['medicamentos'][$p]['DescRzn31'].'</td>
   <td>'.$array[$i]['medicamentos'][$p]['RznCausaS32'].'</td>
   <td>'.$array[$i]['medicamentos'][$p]['DescRzn32'].'</td>
   <td>'.$array[$i]['medicamentos'][$p]['CausaS4'].'</td>
   <td>'.$array[$i]['medicamentos'][$p]['MedPBSDescartado'].'</td>
   <td>'.$array[$i]['medicamentos'][$p]['RznCausaS41'].'</td>
   <td>'.$array[$i]['medicamentos'][$p]['DescRzn41'].'</td>
   <td>'.$array[$i]['medicamentos'][$p]['RznCausaS42'].'</td>
   <td>'.$array[$i]['medicamentos'][$p]['DescRzn42'].'</td>
   <td>'.$array[$i]['medicamentos'][$p]['RznCausaS43'].'</td>
   <td>'.$array[$i]['medicamentos'][$p]['DescRzn43'].'</td>
   <td>'.$array[$i]['medicamentos'][$p]['RznCausaS44'].'</td>
   <td>'.$array[$i]['medicamentos'][$p]['DescRzn44'].'</td>
   <td>'.$array[$i]['medicamentos'][$p]['CausaS5'].'</td>
   <td>'.$array[$i]['medicamentos'][$p]['RznCausaS5'].'</td>
   <td>'.$array[$i]['medicamentos'][$p]['CausaS6'].'</td>
   <td>'.$array[$i]['medicamentos'][$p]['DescMedPrinAct'].'</td>
   <td>'.$array[$i]['medicamentos'][$p]['CodFF'].'</td>
   <td>'.$array[$i]['medicamentos'][$p]['CodVA'].'</td>
   <td>'.$array[$i]['medicamentos'][$p]['JustNoPBS'].'</td>
   <td>'.$array[$i]['medicamentos'][$p]['Dosis'].'</td>
   <td>'.$array[$i]['medicamentos'][$p]['DosisUM'].'</td>
   <td>'.$array[$i]['medicamentos'][$p]['NoFAdmon'].'</td>
   <td>'.$array[$i]['medicamentos'][$p]['CodFreAdmon'].'</td>
   <td>'.$array[$i]['medicamentos'][$p]['IndEsp'].'</td>
   <td>'.$array[$i]['medicamentos'][$p]['CanTrat'].'</td>
   <td>'.$array[$i]['medicamentos'][$p]['DurTrat'].'</td>
   <td>'.$array[$i]['medicamentos'][$p]['CantTotalF'].'</td>
   <td>'.$array[$i]['medicamentos'][$p]['UFCantTotal'].'</td>
   <td>'.$array[$i]['medicamentos'][$p]['IndRec'].'</td>
   <td>'.$array[$i]['medicamentos'][$p]['EstJM'].'</td>';
   ?>

    <td>
    <table border="1">
    <tr>
    <th>ConOrden</th>
    <th>CodPriAct</th>
    <th>ConcCant</th>
    <th>UMedConc</th>
    <th>CantCont</th>
    <th>UMedCantCont</th>
    </tr>
<?php
if (sizeof($array[$i]['medicamentos'][$p]['PrincipiosActivos'])<>0){
?>
<?php
for($u = 0, $size_Pact = sizeof($array[$i]['medicamentos'][$p]['PrincipiosActivos']); $u < $size_Pact; ++$u) {
   echo '<tr>
   <td>'.$array[$i]['medicamentos'][$p]['PrincipiosActivos'][$u]['ConOrden'].'</td>
   <td>'.$array[$i]['medicamentos'][$p]['PrincipiosActivos'][$u]['CodPriAct'].'</td>
   <td>'.$array[$i]['medicamentos'][$p]['PrincipiosActivos'][$u]['ConcCant'].'</td>
   <td>'.$array[$i]['medicamentos'][$p]['PrincipiosActivos'][$u]['UMedConc'].'</td>
   <td>'.$array[$i]['medicamentos'][$p]['PrincipiosActivos'][$u]['CantCont'].'</td>
   <td>'.$array[$i]['medicamentos'][$p]['PrincipiosActivos'][$u]['UMedCantCont'].'</td>
   </tr>';
}
}
?>
   </table>
   </td>


    <td>
    <table border="1">
    <tr>
    <th>ConOrden</th>
    <th>CodIndicacion</th>
    </tr>
<?php
if (sizeof($array[$i]['medicamentos'][$p]['IndicacionesUNIRS'])<>0){
?>
<?php
for($u = 0, $size_Unir = sizeof($array[$i]['medicamentos'][$p]['IndicacionesUNIRS']); $u < $size_Unir; ++$u) {
   echo '<tr>
   <td>'.$array[$i]['medicamentos'][$p]['IndicacionesUNIRS'][$u]['ConOrden'].'</td>
   <td>'.$array[$i]['medicamentos'][$p]['IndicacionesUNIRS'][$u]['CodIndicacion'].'</td>
   </tr>';
}
}
?>
   </table>
   </td>


   <?php
   echo '</tr>';
}
?>
    </table>
<?php
}
?>
          </th>
<!---  FIN MEDICAMENTOS  --->

<!--- INICIO productosnutricionales  --->
          <th>
<?php
if (sizeof($array[$i]['productosnutricionales'])<>0){
?>
 <table border="1"> 
<?php
for($p = 0, $size_Nutr = sizeof($array[$i]['productosnutricionales']); $p < $size_Nutr; ++$p) {
   echo '<tr>
   <td>'.$array[$i]['productosnutricionales'][$p]['ConOrden'].'</td>
   <td>'.$array[$i]['productosnutricionales'][$p]['TipoPrest'].'</td>
   <td>'.$array[$i]['productosnutricionales'][$p]['CausaS1'].'</td>
   <td>'.$array[$i]['productosnutricionales'][$p]['CausaS2'].'</td>
   <td>'.$array[$i]['productosnutricionales'][$p]['CausaS3'].'</td>
   <td>'.$array[$i]['productosnutricionales'][$p]['CausaS4'].'</td>
   <td>'.$array[$i]['productosnutricionales'][$p]['ProNutUtilizado'].'</td>
   <td>'.$array[$i]['productosnutricionales'][$p]['RznCausaS41'].'</td>
   <td>'.$array[$i]['productosnutricionales'][$p]['DescRzn41'].'</td>
   <td>'.$array[$i]['productosnutricionales'][$p]['RznCausaS42'].'</td>
   <td>'.$array[$i]['productosnutricionales'][$p]['DescRzn42'].'</td>
   <td>'.$array[$i]['productosnutricionales'][$p]['CausaS5'].'</td>
   <td>'.$array[$i]['productosnutricionales'][$p]['ProNutDescartado'].'</td>
   <td>'.$array[$i]['productosnutricionales'][$p]['RznCausaS51'].'</td>
   <td>'.$array[$i]['productosnutricionales'][$p]['DescRzn51'].'</td>
   <td>'.$array[$i]['productosnutricionales'][$p]['RznCausaS52'].'</td>
   <td>'.$array[$i]['productosnutricionales'][$p]['DescRzn52'].'</td>
   <td>'.$array[$i]['productosnutricionales'][$p]['RznCausaS53'].'</td>
   <td>'.$array[$i]['productosnutricionales'][$p]['DescRzn53'].'</td>
   <td>'.$array[$i]['productosnutricionales'][$p]['RznCausaS54'].'</td>
   <td>'.$array[$i]['productosnutricionales'][$p]['DescRzn54'].'</td>
   <td>'.$array[$i]['productosnutricionales'][$p]['DXEnfHuer'].'</td>
   <td>'.$array[$i]['productosnutricionales'][$p]['DXVIH'].'</td>
   <td>'.$array[$i]['productosnutricionales'][$p]['DXCaPal'].'</td>
   <td>'.$array[$i]['productosnutricionales'][$p]['DXEnfRCEV'].'</td>
   <td>'.$array[$i]['productosnutricionales'][$p]['DXDesPro'].'</td>
   <td>'.$array[$i]['productosnutricionales'][$p]['TippProNut'].'</td>
   <td>'.$array[$i]['productosnutricionales'][$p]['DescProdNutr'].'</td>
   <td>'.$array[$i]['productosnutricionales'][$p]['CodForma'].'</td>
   <td>'.$array[$i]['productosnutricionales'][$p]['CodViaAdmon'].'</td>
   <td>'.$array[$i]['productosnutricionales'][$p]['JustNoPBS'].'</td>
   <td>'.$array[$i]['productosnutricionales'][$p]['Dosis'].'</td>
   <td>'.$array[$i]['productosnutricionales'][$p]['DosisUM'].'</td>
   <td>'.$array[$i]['productosnutricionales'][$p]['NoFAdmon'].'</td>
   <td>'.$array[$i]['productosnutricionales'][$p]['CodFreAdmon'].'</td>
   <td>'.$array[$i]['productosnutricionales'][$p]['IndEsp'].'</td>
   <td>'.$array[$i]['productosnutricionales'][$p]['CanTrat'].'</td>
   <td>'.$array[$i]['productosnutricionales'][$p]['DurTrat'].'</td>
   <td>'.$array[$i]['productosnutricionales'][$p]['CantTotalF'].'</td>
   <td>'.$array[$i]['productosnutricionales'][$p]['UFCantTotal'].'</td>
   <td>'.$array[$i]['productosnutricionales'][$p]['IndRec'].'</td>
   <td>'.$array[$i]['productosnutricionales'][$p]['NoPrescAso'].'</td>
   <td>'.$array[$i]['productosnutricionales'][$p]['EstJM'].'</td>
   </tr>';
}
?>
    </table>
<?php
}
?>
          </th>
<!---  FIN productosnutricionales  --->



<!--- INICIO serviciosComplementarios  --->
          <th>
<?php
if (sizeof($array[$i]['serviciosComplementarios'])<>0){
?>
 <table border="1">
<?php
for($p = 0, $size_Comp = sizeof($array[$i]['serviciosComplementarios']); $p < $size_Comp; ++$p) {
   echo '<tr>
   <td>'.$array[$i]['serviciosComplementarios'][$p]['ConOrden'].'</td>
   <td>'.$array[$i]['serviciosComplementarios'][$p]['TipoPrest'].'</td>
   <td>'.$array[$i]['serviciosComplementarios'][$p]['CausaS1'].'</td>
   <td>'.$array[$i]['serviciosComplementarios'][$p]['CausaS2'].'</td>
   <td>'.$array[$i]['serviciosComplementarios'][$p]['CausaS3'].'</td>
   <td>'.$array[$i]['serviciosComplementarios'][$p]['CausaS4'].'</td>
   <td>'.$array[$i]['serviciosComplementarios'][$p]['DescCausaS4'].'</td>
   <td>'.$array[$i]['serviciosComplementarios'][$p]['CausaS5'].'</td>
   <td>'.$array[$i]['serviciosComplementarios'][$p]['CodSerComp'].'</td>
   <td>'.$array[$i]['serviciosComplementarios'][$p]['DescSerComp'].'</td>
   <td>'.$array[$i]['serviciosComplementarios'][$p]['CanForm'].'</td>
   <td>'.$array[$i]['serviciosComplementarios'][$p]['CadaFreUso'].'</td>
   <td>'.$array[$i]['serviciosComplementarios'][$p]['CodFreUso'].'</td>
   <td>'.$array[$i]['serviciosComplementarios'][$p]['Cant'].'</td>
   <td>'.$array[$i]['serviciosComplementarios'][$p]['CantTotal'].'</td>
   <td>'.$array[$i]['serviciosComplementarios'][$p]['CodPerDurTrat'].'</td>
   <td>'.$array[$i]['serviciosComplementarios'][$p]['TipoTrans'].'</td>
   <td>'.$array[$i]['serviciosComplementarios'][$p]['ReqAcom'].'</td>
   <td>'.$array[$i]['serviciosComplementarios'][$p]['TipoIDAcomAlb'].'</td>
   <td>'.$array[$i]['serviciosComplementarios'][$p]['NroIDAcomAlb'].'</td>
   <td>'.$array[$i]['serviciosComplementarios'][$p]['ParentAcomAlb'].'</td>
   <td>'.$array[$i]['serviciosComplementarios'][$p]['NombAlb'].'</td>
   <td>'.$array[$i]['serviciosComplementarios'][$p]['CodMunOriAlb'].'</td>
   <td>'.$array[$i]['serviciosComplementarios'][$p]['CodMunDesAlb'].'</td>
   <td>'.$array[$i]['serviciosComplementarios'][$p]['JustNoPBS'].'</td>
   <td>'.$array[$i]['serviciosComplementarios'][$p]['IndRec'].'</td>
   <td>'.$array[$i]['serviciosComplementarios'][$p]['EstJM'].'</td>
   </tr>';
}
?>
    </table>
<?php
}
?>
          </th>
<!---  FIN serviciosComplementarios  --->


<!--- INICIO serviciosComplementarios  --->
          <th>
<?php
if (sizeof($array[$i]['dispositivos'])<>0){
?>
 <table border="1">
<?php
for($p = 0, $size_Dispo = sizeof($array[$i]['dispositivos']); $p < $size_Dispo; ++$p) {
   echo '<tr>
   <td>'.$array[$i]['dispositivos'][$p]['ConOrden'].'</td>
   <td>'.$array[$i]['dispositivos'][$p]['TipoPrest'].'</td>
   <td>'.$array[$i]['dispositivos'][$p]['CausaS1'].'</td>
   <td>'.$array[$i]['dispositivos'][$p]['CodDisp'].'</td>
   <td>'.$array[$i]['dispositivos'][$p]['CanForm'].'</td>
   <td>'.$array[$i]['dispositivos'][$p]['CadaFreUso'].'</td>
   <td>'.$array[$i]['dispositivos'][$p]['CodFreUso'].'</td>
   <td>'.$array[$i]['dispositivos'][$p]['Cant'].'</td>
   <td>'.$array[$i]['dispositivos'][$p]['CodPerDurTrat'].'</td>
   <td>'.$array[$i]['dispositivos'][$p]['CantTotal'].'</td>
   <td>'.$array[$i]['dispositivos'][$p]['JustNoPBS'].'</td>
   <td>'.$array[$i]['dispositivos'][$p]['IndRec'].'</td>
   <td>'.$array[$i]['dispositivos'][$p]['EstJM'].'</td>
   </tr>';
}
?>
    </table>
<?php
}
?>
          </th>
<!---  FIN serviciosComplementarios  --->
          <?php
          echo '</tr>';
          }
          ?> 
    </table>
</body>






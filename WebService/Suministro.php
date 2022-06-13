<?php
set_time_limit(10000000);
require_once("../modelo/conexion-sql.php");
?>
<?php

$ch = curl_init($_GET["link"]);
curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json; charset=utf-8'));
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
$result = curl_exec($ch);
if (!curl_errno($ch)) {
    $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    $info = curl_getinfo($ch);
    echo $mensaje_mipres = "Tiempo de ejecución de la consulta: ".$info['total_time']." ms, codigo de respuesta: ".$http_code."<br>";
    switch ($http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE)) {
        case 200:  # OK
        $info = curl_getinfo($ch);  
        $result = json_decode($result, true); 

for($i = 0, $size = count($result); $i < $size; ++$i) {
 $sql = "IF NOT EXISTS (SELECT * FROM MIPRES_SUMINISTRO WHERE ID = '".$result[$i]['ID']."') 

  BEGIN 

INSERT INTO [dbo].[MIPRES_SUMINISTRO]
           ([ID]
           ,[IDSuministro]
           ,[NoPrescripcion]
           ,[TipoTec]
           ,[ConTec]
           ,[TipoIDPaciente]
           ,[NoIDPaciente]
           ,[NoEntrega]
           ,[UltEntrega]
           ,[EntregaCompleta]
           ,[CausaNoEntrega]
           ,[NoPrescripcionAsociada]
           ,[ConTecAsociada]
           ,[CantTotEntregada]
           ,[NoLote]
           ,[ValorEntregado]
           ,[FecSuministro]
           ,[EstSuministro]
           ,[FecAnulacion]
           )
     VALUES
           ('".$result[$i]['ID']."'
           ,'".$result[$i]['IDSuministro']."'
           ,'".$result[$i]['NoPrescripcion']."'
           ,'".$result[$i]['TipoTec']."'
           ,'".$result[$i]['ConTec']."'
           ,'".$result[$i]['TipoIDPaciente']."'
           ,'".$result[$i]['NoIDPaciente']."'
           ,'".$result[$i]['NoEntrega']."'
           ,'".$result[$i]['UltEntrega']."'
           ,'".$result[$i]['EntregaCompleta']."'
           ,'".$result[$i]['CausaNoEntrega']."'
           ,'".$result[$i]['NoPrescripcionAsociada']."'
           ,'".$result[$i]['ConTecAsociada']."'
           ,'".$result[$i]['CantTotEntregada']."'
           ,'".$result[$i]['NoLote']."'
           ,'".$result[$i]['ValorEntregado']."'
           ,'".date("d/m/Y",strtotime(substr($result[$i]['FecSuministro'], 0, 10)))."'
           ,'".$result[$i]['EstSuministro']."'
           ,'".date("d/m/Y",strtotime(substr($result[$i]['FecAnulacion'], 0, 10)))."'
            )

  END ELSE BEGIN 


UPDATE [dbo].[MIPRES_SUMINISTRO]
   SET [ID] = '".$result[$i]['ID']."'
      ,[IDSuministro] = '".$result[$i]['IDSuministro']."'
      ,[NoPrescripcion] = '".$result[$i]['NoPrescripcion']."'
      ,[TipoTec] = '".$result[$i]['TipoTec']."'
      ,[ConTec] = '".$result[$i]['ConTec']."'
      ,[TipoIDPaciente] = '".$result[$i]['TipoIDPaciente']."'
      ,[NoIDPaciente] = '".$result[$i]['NoIDPaciente']."'
      ,[NoEntrega] = '".$result[$i]['NoEntrega']."'
      ,[UltEntrega] = '".$result[$i]['UltEntrega']."'
      ,[EntregaCompleta] = '".$result[$i]['EntregaCompleta']."'
      ,[CausaNoEntrega] = '".$result[$i]['CausaNoEntrega']."'
      ,[NoPrescripcionAsociada] = '".$result[$i]['NoPrescripcionAsociada']."'
      ,[ConTecAsociada] = '".$result[$i]['ConTecAsociada']."'
      ,[CantTotEntregada] = '".$result[$i]['CantTotEntregada']."'
      ,[NoLote] = '".$result[$i]['NoLote']."'
      ,[ValorEntregado] ='".$result[$i]['ValorEntregado']."'
      ,[FecSuministro] = '".date("d/m/Y",strtotime(substr($result[$i]['FecSuministro'], 0, 10)))."'
      ,[EstSuministro] = '".$result[$i]['EstSuministro']."'
      ,[FecAnulacion] = '".date("d/m/Y",strtotime(substr($result[$i]['FecAnulacion'], 0, 10)))."'
 WHERE ID = '".$result[$i]['ID']."'


  END";  


 echo "Reporte de Suministro: ".$result[$i]['ID']." Resultado: ".sql($conn,$sql)."<br>";
            }
}
}
    
?>






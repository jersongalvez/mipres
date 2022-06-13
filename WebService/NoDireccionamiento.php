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

$sql = "IF NOT EXISTS (SELECT * FROM MIPRES_NO_DIRECCIONAMIENTOS WHERE ID = '".$result[$i]['ID']."' AND IDNODIRECCIONAMIENTO = '".$result[$i]['IDNODireccionamiento']."' ) BEGIN
INSERT INTO [dbo].[MIPRES_NO_DIRECCIONAMIENTOS]
           ([ID]
           ,[IDNODireccionamiento]
           ,[NoPrescripcion]
           ,[TipoTec]
           ,[ConTec]
           ,[TipoIDPaciente]
           ,[NoIDPaciente]
           ,[NoPrescripcionAsociada]
           ,[ConTecAsociada]
           ,[CausaNoEntrega]
           ,[FecNODireccionamiento]
           ,[EstNODireccionamiento]
           ,[FecAnulacion]
           ,[USUARIO_NO_DIRECCIONAMIENTO]
           ,[FECHA_NO_DIRECCIONAMIENTO])
     VALUES
           ('".$result[$i]['ID']."'
           ,'".$result[$i]['IDNODireccionamiento']."'
           ,'".$result[$i]['NoPrescripcion']."'
           ,'".$result[$i]['TipoTec']."'
           ,'".$result[$i]['ConTec']."'
           ,'".$result[$i]['TipoIDPaciente']."'
           ,'".$result[$i]['NoIDPaciente']."'
           ,'".$result[$i]['NoPrescripcionAsociada']."'
           ,'".$result[$i]['ConTecAsociada']."'
           ,'".$result[$i]['CausaNoEntrega']."'
           ,'".date("d/m/Y",strtotime(substr($result[$i]['FecNODireccionamiento'], 0, 10)))."'
           ,'".$result[$i]['EstNODireccionamiento']."'
           ,'".date("d/m/Y",strtotime(substr($result[$i]['FecAnulacion'], 0, 10)))."'
           ,'N/A'
           ,CURRENT_TIMESTAMP)
END ELSE BEGIN 
UPDATE [dbo].[MIPRES_NO_DIRECCIONAMIENTOS]
   SET 
       [NoPrescripcion] = '".$result[$i]['NoPrescripcion']."'
      ,[TipoTec] = '".$result[$i]['TipoTec']."'
      ,[ConTec] = '".$result[$i]['ConTec']."'
      ,[TipoIDPaciente] = '".$result[$i]['TipoIDPaciente']."'
      ,[NoIDPaciente] = '".$result[$i]['NoIDPaciente']."'
      ,[NoPrescripcionAsociada] = '".$result[$i]['NoPrescripcionAsociada']."'
      ,[ConTecAsociada] = '".$result[$i]['ConTecAsociada']."'
      ,[CausaNoEntrega] = '".$result[$i]['CausaNoEntrega']."'
      ,[FecNODireccionamiento] = '".date("d/m/Y",strtotime(substr($result[$i]['FecNODireccionamiento'], 0, 10)))."'
      ,[EstNODireccionamiento] = '".$result[$i]['EstNODireccionamiento']."'
      ,[FecAnulacion] = '".date("d/m/Y",strtotime(substr($result[$i]['FecAnulacion'], 0, 10)))."'
 WHERE ID = '".$result[$i]['ID']."' AND IDNODIRECCIONAMIENTO = '".$result[$i]['IDNODireccionamiento']."'
END";

echo "No Direccionamiento: ".$result[$i]['ID']." Resultado: ".sql($conn,$sql)."<br>";


      
            }
}
}
    
?>






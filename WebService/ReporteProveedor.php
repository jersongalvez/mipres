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
          $sql = "IF NOT EXISTS (SELECT * FROM MIPRES_ENTREGA_PROVEEDOR WHERE ID = '".$result[$i]['ID']."') 

  BEGIN 


  INSERT INTO [dbo].[MIPRES_ENTREGA_PROVEEDOR]
  ([ID]
  ,[IDReporteEntrega]
  ,[NoPrescripcion]
  ,[TipoTec]
  ,[ConTec]
  ,[TipoIDPaciente]
  ,[NoIDPaciente]
  ,[NoEntrega]
  ,[EstadoEntrega]
  ,[CausaNoEntrega]
  ,[ValorEntregado]
  ,[CodTecEntregado]
  ,[CantTotEntregada]
  ,[NoLote]
  ,[FecEntrega]
  ,[FecRepEntrega]
  ,[EstRepEntrega]
  ,[FecAnulacion])
  VALUES
  ('".$result[$i]['ID']."'
  ,'".$result[$i]['IDReporteEntrega']."'
  ,'".$result[$i]['NoPrescripcion']."'
  ,'".$result[$i]['TipoTec']."'
  ,'".$result[$i]['ConTec']."'
  ,'".$result[$i]['TipoIDPaciente']."'
  ,'".$result[$i]['NoIDPaciente']."'
  ,'".$result[$i]['NoEntrega']."'
  ,'".$result[$i]['EstadoEntrega']."'
  ,'".$result[$i]['CausaNoEntrega']."'
  ,'".$result[$i]['ValorEntregado']."'
  ,'".$result[$i]['CodTecEntregado']."'
  ,'".$result[$i]['CantTotEntregada']."'
  ,'".$result[$i]['NoLote']."'
  ,'".date("d/m/Y",strtotime(substr($result[$i]['FecEntrega'], 0, 10)))."'
  ,'".date("d/m/Y",strtotime(substr($result[$i]['FecRepEntrega'], 0, 10)))."'
  ,'".$result[$i]['EstRepEntrega']."'
  ,'".date("d/m/Y",strtotime(substr($result[$i]['FecAnulacion'], 0, 10)))."'
  )


  END ELSE BEGIN 


UPDATE [dbo].[MIPRES_ENTREGA_PROVEEDOR]
   SET [ID] = '".$result[$i]['ID']."'
      ,[IDReporteEntrega] = '".$result[$i]['IDReporteEntrega']."'
      ,[NoPrescripcion] = '".$result[$i]['NoPrescripcion']."'
      ,[TipoTec] = '".$result[$i]['TipoTec']."'
      ,[ConTec] = '".$result[$i]['ConTec']."'
      ,[TipoIDPaciente] = '".$result[$i]['TipoIDPaciente']."'
      ,[NoIDPaciente] = '".$result[$i]['NoIDPaciente']."'
      ,[NoEntrega] = '".$result[$i]['NoEntrega']."'
      ,[EstadoEntrega] = '".$result[$i]['EstadoEntrega']."'
      ,[CausaNoEntrega] = '".$result[$i]['CausaNoEntrega']."'
      ,[ValorEntregado] = '".$result[$i]['ValorEntregado']."'
      ,[CodTecEntregado] = '".$result[$i]['CodTecEntregado']."'
      ,[CantTotEntregada] = '".$result[$i]['CantTotEntregada']."'
      ,[NoLote] = '".$result[$i]['NoLote']."'
      ,[FecEntrega] = '".date("d/m/Y",strtotime(substr($result[$i]['FecEntrega'], 0, 10)))."'
      ,[FecRepEntrega] = '".date("d/m/Y",strtotime(substr($result[$i]['FecRepEntrega'], 0, 10)))."'
      ,[EstRepEntrega] = '".$result[$i]['EstRepEntrega']."'
      ,[FecAnulacion] = '".date("d/m/Y",strtotime(substr($result[$i]['FecAnulacion'], 0, 10)))."'
 WHERE ID = '".$result[$i]['ID']."'


  END";  


 echo "Reporte de Entrega: ".$result[$i]['ID']." Resultado: ".sql($conn,$sql)."<br>";
            }
}
}
    
?>






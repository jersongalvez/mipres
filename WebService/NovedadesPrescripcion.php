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

    $sql = "IF NOT EXISTS (SELECT NoPrescripcion FROM MIPRES_NOVEDADES WHERE NoPrescripcion = '".$result[$i]['prescripcion_novedades']['NoPrescripcion']."' AND NoPrescripcionF = '".$result[$i]['prescripcion_novedades']['NoPrescripcionF']."' )
    BEGIN 

    INSERT INTO [dbo].[MIPRES_NOVEDADES]
    ([TipoNov],[NoPrescripcion],[NoPrescripcionF],[FNov])
    VALUES
    ('".$result[$i]['prescripcion_novedades']['TipoNov']."'
    ,'".$result[$i]['prescripcion_novedades']['NoPrescripcion']."'
    ,'".$result[$i]['prescripcion_novedades']['NoPrescripcionF']."'
    ,'".$result[$i]['prescripcion_novedades']['FNov']."'
    )

    END ELSE BEGIN 

    UPDATE [dbo].[MIPRES_NOVEDADES]
    SET [TipoNov] = '".$result[$i]['prescripcion_novedades']['TipoNov']."'
    ,[NoPrescripcion] = '".$result[$i]['prescripcion_novedades']['NoPrescripcion']."'
    ,[NoPrescripcionF] = '".$result[$i]['prescripcion_novedades']['NoPrescripcionF']."'
    ,[FNov] = '".$result[$i]['prescripcion_novedades']['FNov']."'
    WHERE NoPrescripcion = '".$result[$i]['prescripcion_novedades']['NoPrescripcion']."' AND NoPrescripcionF = '".$result[$i]['prescripcion_novedades']['NoPrescripcionF']."'

    END";

echo "Novedad: ".$result[$i]['prescripcion_novedades']['NoPrescripcion']." Fecha: ".$result[$i]['prescripcion_novedades']['FNov']." Resultado: ".sql($conn,$sql)."<br>";

}

for($i = 0, $size = count($result); $i < $size; ++$i) { 
  if ($result[$i]['prescripcion_novedades']['TipoNov']<>3){
     $sql = "UPDATE [dbo].[MIPRES_PRESCRIPCION ] SET [ESTPRES] = '".$result[$i]['prescripcion_novedades']['TipoNov']."' WHERE [NOPRESCRIPCION] = '".$result[$i]['prescripcion_novedades']['NoPrescripcion']."' ";
    
    echo "Prescripción actualizada: ".$result[$i]['prescripcion_novedades']['NoPrescripcion']." Fecha: ".$result[$i]['prescripcion_novedades']['FNov']." Resultado: ".sql($conn,$sql)."<br>";
  }
}


}
}
    
?>






<?php
set_time_limit(10000000);
require_once("../modelo/conexion-sql.php");
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

   
    $sql = "IF NOT EXISTS (SELECT NOPRESCRIPCION FROM MIPRES_JUNTAPROFESIONAL WHERE NOPRESCRIPCION = '".$result[$i]['junta_profesional']['NoPrescripcion']."' AND CONSECUTIVO = ".Valor(str_replace(",", ".",$result[$i]['junta_profesional']['Consecutivo']))." )
    BEGIN 

    INSERT INTO [dbo].[MIPRES_JUNTAPROFESIONAL]
    ([NOPRESCRIPCION],[FPRESCRIPCION],[TIPTECNOLOGIA],[CONSECUTIVO],[ESTJM],[CODENTPROC],[OBSERVACIONES],[JUSTIFICACIONTECNICA],[MODALIDAD],[NOACTA],[FECHAACTA],[FPROCESO],[TIPOIDPACIENTE],[NROIDPACIENTE],[CODENTJM],[USU_CARGUE],[FEC_CRUCE])
    VALUES
    ('".$result[$i]['junta_profesional']['NoPrescripcion']."' 
    ,'".date("d/m/Y",strtotime(substr($result[$i]['junta_profesional']['FPrescripcion'], 0, 10)))."' 
    ,'".$result[$i]['junta_profesional']['TipoTecnologia']."'
    ,".Valor(str_replace(",", ".",$result[$i]['junta_profesional']['Consecutivo']))."
    ,".Valor(str_replace(",", ".",$result[$i]['junta_profesional']['EstJM']))."
    ,'".$result[$i]['junta_profesional']['CodEntProc']."'
    ,'".$result[$i]['junta_profesional']['Observaciones']."'
    ,'".$result[$i]['junta_profesional']['JustificacionTecnica']."'
    ,".Valor(str_replace(",", ".",$result[$i]['junta_profesional']['Modalidad']))."
    ,'".$result[$i]['junta_profesional']['NoActa']."'
    ,'".date("d/m/Y",strtotime(substr($result[$i]['junta_profesional']['FechaActa'], 0, 10)))."' 
    ,'".date("d/m/Y",strtotime(substr($result[$i]['junta_profesional']['FProceso'], 0, 10)))."' 
    ,'".$result[$i]['junta_profesional']['TipoIDPaciente']."'
    ,'".$result[$i]['junta_profesional']['NroIDPaciente']."'
    ,'".$result[$i]['junta_profesional']['CodEntJM']."'
    ,'SA'
    ,CURRENT_TIMESTAMP)
    END ELSE BEGIN 

    UPDATE [dbo].[MIPRES_JUNTAPROFESIONAL]
    SET [NOPRESCRIPCION] = '".$result[$i]['junta_profesional']['NoPrescripcion']."' 
    ,[FPRESCRIPCION] = '".date("d/m/Y",strtotime(substr($result[$i]['junta_profesional']['FPrescripcion'], 0, 10)))."'
    ,[TIPTECNOLOGIA] = '".$result[$i]['junta_profesional']['TipoTecnologia']."'
    ,[CONSECUTIVO] = ".Valor(str_replace(",", ".",$result[$i]['junta_profesional']['Consecutivo']))."
    ,[ESTJM] = ".Valor(str_replace(",", ".",$result[$i]['junta_profesional']['EstJM']))."
    ,[CODENTPROC] = '".$result[$i]['junta_profesional']['CodEntProc']."'
    ,[OBSERVACIONES] = '".$result[$i]['junta_profesional']['Observaciones']."'
    ,[JUSTIFICACIONTECNICA] = '".$result[$i]['junta_profesional']['JustificacionTecnica']."'
    ,[MODALIDAD] = ".Valor(str_replace(",", ".",$result[$i]['junta_profesional']['Modalidad']))."
    ,[NOACTA] = '".$result[$i]['junta_profesional']['NoActa']."'
    ,[FECHAACTA] = '".date("d/m/Y",strtotime(substr($result[$i]['junta_profesional']['FechaActa'], 0, 10)))."'
    ,[FPROCESO] = '".date("d/m/Y",strtotime(substr($result[$i]['junta_profesional']['FProceso'], 0, 10)))."'
    ,[TIPOIDPACIENTE] = '".$result[$i]['junta_profesional']['TipoIDPaciente']."'
    ,[NROIDPACIENTE] = '".$result[$i]['junta_profesional']['NroIDPaciente']."'
    ,[CODENTJM] = '".$result[$i]['junta_profesional']['CodEntJM']."'
    ,[USU_CARGUE] = 'SA'
    ,[FEC_CRUCE] = CURRENT_TIMESTAMP
    WHERE NOPRESCRIPCION = '".$result[$i]['junta_profesional']['NoPrescripcion']."' AND  CONSECUTIVO = ".Valor(str_replace(",", ".",$result[$i]['junta_profesional']['Consecutivo']))."

    END";

echo "Junta: ".$result[$i]['junta_profesional']['NoPrescripcion']." Consecutivo: ".$result[$i]['junta_profesional']['Consecutivo']." Resultado: ".sql($conn,$sql)."<br>";
            }
}
}
    
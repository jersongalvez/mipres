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
    echo $mensaje_mipres = "Tiempo de ejecución de la consulta: " . $info['total_time'] . " ms, codigo de respuesta: " . $http_code . "<br>";
    switch ($http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE)) {
        case 200:  # OK
            $info = curl_getinfo($ch);
            $result = json_decode($result, true);

            for ($i = 0, $size = count($result); $i < $size; ++$i) {
                $sql = "IF NOT EXISTS (SELECT * FROM MIPRES_DIRECCIONAMIENTOS WHERE ID = '" . $result[$i]['ID'] . "' AND IDDIRECCIONAMIENTO = '" . $result[$i]['IDDireccionamiento'] . "') BEGIN INSERT INTO [MIPRES_DIRECCIONAMIENTOS]([ID],[IDDireccionamiento],[NoPrescripcion],[TipoTec],[ConTec],[TipoIDPaciente],[NoIDPaciente],[NoEntrega],[NoSubEntrega],[TipoIDProv],[NoIDProv],[CodMunEnt],[FecMaxEnt],[CantTotAEntregar],[DirPaciente],[CodSerTecAEntregar],[NoIDEPS],[CodEPS],[FecDireccionamiento],[EstDireccionamiento],[FecAnulacion]) VALUES ('" . $result[$i]['ID'] . "','" . $result[$i]['IDDireccionamiento'] . "','" . $result[$i]['NoPrescripcion'] . "','" . $result[$i]['TipoTec'] . "','" . $result[$i]['ConTec'] . "','" . $result[$i]['TipoIDPaciente'] . "','" . $result[$i]['NoIDPaciente'] . "','" . $result[$i]['NoEntrega'] . "','" . $result[$i]['NoSubEntrega'] . "','" . $result[$i]['TipoIDProv'] . "','" . $result[$i]['NoIDProv'] . "','" . $result[$i]['CodMunEnt'] . "','" . date("d/m/Y", strtotime(substr($result[$i]['FecMaxEnt'], 0, 10))) . "','" . $result[$i]['CantTotAEntregar'] . "','" . $result[$i]['DirPaciente'] . "','" . $result[$i]['CodSerTecAEntregar'] . "','" . $result[$i]['NoIDEPS'] . "','" . $result[$i]['CodEPS'] . "','" . date("d/m/Y", strtotime(substr($result[$i]['FecDireccionamiento'], 0, 10))) . "','" . $result[$i]['EstDireccionamiento'] . "','" . date("d/m/Y", strtotime(substr($result[$i]['FecAnulacion'], 0, 10))) . "') END ELSE BEGIN UPDATE [MIPRES_DIRECCIONAMIENTOS] SET [ID] = '" . $result[$i]['ID'] . "',[IDDireccionamiento] = '" . $result[$i]['IDDireccionamiento'] . "',[NoPrescripcion] = '" . $result[$i]['NoPrescripcion'] . "',[TipoTec] = '" . $result[$i]['TipoTec'] . "',[ConTec] = '" . $result[$i]['ConTec'] . "',[TipoIDPaciente] = '" . $result[$i]['TipoIDPaciente'] . "',[NoIDPaciente] = '" . $result[$i]['NoIDPaciente'] . "',[NoEntrega] = '" . $result[$i]['NoEntrega'] . "',[NoSubEntrega] = '" . $result[$i]['NoSubEntrega'] . "',[TipoIDProv] = '" . $result[$i]['TipoIDProv'] . "',[NoIDProv] = '" . $result[$i]['NoIDProv'] . "',[CodMunEnt] = '" . $result[$i]['CodMunEnt'] . "',[FecMaxEnt] = '" . date("d/m/Y", strtotime(substr($result[$i]['FecMaxEnt'], 0, 10))) . "',[CantTotAEntregar] = '" . $result[$i]['CantTotAEntregar'] . "',[DirPaciente] = '" . $result[$i]['DirPaciente'] . "',[CodSerTecAEntregar] = '" . $result[$i]['CodSerTecAEntregar'] . "',[NoIDEPS] = '" . $result[$i]['NoIDEPS'] . "',[CodEPS] = '" . $result[$i]['CodEPS'] . "',[FecDireccionamiento] = '" . date("d/m/Y", strtotime(substr($result[$i]['FecDireccionamiento'], 0, 10))) . "',[EstDireccionamiento] = '" . $result[$i]['EstDireccionamiento'] . "',[FecAnulacion] = '" . date("d/m/Y", strtotime(substr($result[$i]['FecAnulacion'], 0, 10))) . "' WHERE ID = '" . $result[$i]['ID'] . "' AND IDDIRECCIONAMIENTO = '" . $result[$i]['IDDireccionamiento'] . "' END";

                echo "Direccionamiento: " . $result[$i]['ID'] . " Resultado: " . sql($conn, $sql) . "<br>";
            }
    }
}
?>






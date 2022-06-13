<?php

if (!empty($_SESSION['NIT_EPS'])) {
    $sql = "SELECT (SELECT TOP 1 DES_TEM_TOKEN FROM PRS_TEM_TOKEN WHERE TIP_TEM_TOKEN = '" . $REGIMEN . "') AS DES_TEM_TOKEN, * FROM PRS_URL_SERVICES WHERE COD_URL = '9'";
    $params = array();
    $options = array("Scrollable" => SQLSRV_CURSOR_KEYSET);
    $stmt = sqlsrv_query($conn, $sql, $params, $options);
    $row_count = sqlsrv_num_rows($stmt);
    
    
    
    if ($row_count === false) {
        echo "<div class='alert alert-danger alert-dismissible'>";
        echo "<button type='button' class='close' data-dismiss='alert'>&times;</button>";
        echo "<strong>Error!</strong> No se encuentra el recurso solicitado, error: ERROR0002</div>";
        
    } else {
        
        while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
            $url = $row['DES_URL'] . $_SESSION['NIT_EPS'] . '/' . $row['DES_TEM_TOKEN'];

            $ch = curl_init($url);

            $data = array();
            $data["NoPrescripcion"] = $NOPRESCRIPCION;
            $data["TipoTec"] = $TIPOTEC;
            $data["ConTec"] = $CONORDEN;
            $data["TipoIDPaciente"] = $TI;
            $data["NoIDPaciente"] = $NI;
            $data["CausaNoEntrega"] = $CausaNoEntrega;
            $data["NoPrescripcionAsociada"] = $NoPrescripcionAsociada;
            $data["ConTecAsociada"] = $ConTecAsociada;
            //print_r($data);


            $payload = json_encode($data);
            curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json; charset=utf-8'));
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PUT');
            curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);

            $result = curl_exec($ch);
        }
    }
    sqlsrv_free_stmt($stmt);
} else {
    echo "<div class='alert alert-danger alert-dismissible'>";
    echo "<button type='button' class='close' data-dismiss='alert'>&times;</button>";
    echo "<strong>Error!</strong> No se ha logrado autenticar los datos de la compañia, error: ERROR0001</div>";
}
?>
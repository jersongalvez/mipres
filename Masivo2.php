<?php
set_time_limit(1000000000000000000);
require_once('modelo/conexion-sql.php');
?>

<body style="background-color:#F0F0F0;">








<?php


$sql = "SELECT MP.NOPRESCRIPCION 
FROM MIPRES_DIRECCIONAMIENTOS MP
WHERE YEAR(MP.FecDireccionamiento) >= 2020
AND NOT EXISTS (
SELECT 
'X'
FROM AUTORIZACION AUX 
WHERE 
CAST(AUX.FEC_AUTORIZACION AS DATE) between '01/01/2020' and '20/01/2021'
AND AUX.ESTADO IN ('AU','CO')
AND AUX.NUM_COMITECTC = MP.NOPRESCRIPCION)";

    $params = array();
    $options =  array( "Scrollable" => SQLSRV_CURSOR_KEYSET );
    $stmt = sqlsrv_query( $conn, $sql, $params, $options);
    $row_count = sqlsrv_num_rows( $stmt );
        if ($row_count == 0){
        }  
        else{

              while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) )  
              { 
                    echo $row['NOPRESCRIPCION'];
                    echo "<br>"; 
                    echo "<br>Direccionamientos Subsidiados <br>";
                    $handle = curl_init();
                    $url = "http://localhost/SISTEMA_MIPRESv2/WebService/Direccionamiento.php?link=https://wsmipres.sispro.gov.co/WSSUMMIPRESNOPBS/api/DireccionamientoXPrescripcion/809008362/".token_temporal($conn,'S').'/'.$row['NOPRESCRIPCION'];
                    curl_setopt($handle, CURLOPT_URL, $url);
                    curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);
                    curl_setopt($handle, CURLOPT_SSL_VERIFYPEER, false);
                    $output = curl_exec($handle);
                    curl_close($handle);
                    echo $output;
                    echo "<br>Direccionamientos Contributivos <br>";
                    $handle = curl_init(); 
                    $url = "http://localhost/SISTEMA_MIPRESv2/WebService/Direccionamiento.php?link=https://wsmipres.sispro.gov.co/WSSUMMIPRESNOPBS/api/DireccionamientoXPrescripcion/809008362/".token_temporal($conn,'C').'/'.$row['NOPRESCRIPCION'];
                    curl_setopt($handle, CURLOPT_URL, $url);
                    curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);
                    curl_setopt($handle, CURLOPT_SSL_VERIFYPEER, false);
                    $output = curl_exec($handle);
                    curl_close($handle);
                    echo $output;


                    echo "<br>Reporte Proveedor Subsidiados <br>";
                    $handle = curl_init();
                    $url = "http://localhost/SISTEMA_MIPRESv2/WebService/ReporteProveedor.php?link=https://wsmipres.sispro.gov.co/WSSUMMIPRESNOPBS/api/ReporteEntregaXPrescripcion/809008362/".token_temporal($conn,'S').'/'.$row['NOPRESCRIPCION'];
                    curl_setopt($handle, CURLOPT_URL, $url);
                    curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);
                    curl_setopt($handle, CURLOPT_SSL_VERIFYPEER, false);
                    $output = curl_exec($handle);
                    curl_close($handle);
                    echo $output;
                    echo "<br>Reporte Proveedor Contributivos <br>";
                    $handle = curl_init(); 
                    $url = "http://localhost/SISTEMA_MIPRESv2/WebService/ReporteProveedor.php?link=https://wsmipres.sispro.gov.co/WSSUMMIPRESNOPBS/api/ReporteEntregaXPrescripcion/809008362/".token_temporal($conn,'C').'/'.$row['NOPRESCRIPCION'];
                    curl_setopt($handle, CURLOPT_URL, $url);
                    curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);
                    curl_setopt($handle, CURLOPT_SSL_VERIFYPEER, false);
                    $output = curl_exec($handle);
                    curl_close($handle);
                    echo $output;


              }

            }

    sqlsrv_free_stmt($stmt); 







?>



</body>


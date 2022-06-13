<?php
set_time_limit(300);

$url = 'https://wsmipres.sispro.gov.co/WSSUMMIPRESNOPBS/api/DireccionamientoXFecha/809008362/LrzNtbQ2z2ituGjwLwNN8JE0drGaL98i0y7INW4S0UI=/2020-03-06';

$ch = curl_init($url);


curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json; charset=utf-8'));
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');

$result = curl_exec($ch);




print($result);


// Cerrar el manejador
curl_close($ch);

?>


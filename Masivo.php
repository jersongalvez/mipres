<?php
set_time_limit(1000000000000000000);
require_once('modelo/conexion-sql.php');
?>

<body onload="startTime()" style="background-color:#F0F0F0;">

<div id="clockdate">
  <div class="clockdate-wrapper">
    <div id="clock"></div>
    <div id="date"></div>
  </div>
</div>

<style type="text/css">
  .clockdate-wrapper {
    background-color: #333;
    padding:25px;
    max-width:350px;
    width:100%;
    text-align:center;
    border-radius:5px;
    margin:0 auto;
    margin-top:15%;
}
#clock{
    background-color:#333;
    font-family: sans-serif;
    font-size:60px;
    text-shadow:0px 0px 1px #fff;
    color:#fff;
}
#clock span {
    color:#888;
    text-shadow:0px 0px 1px #333;
    font-size:30px;
    position:relative;
    top:-27px;
    left:-10px;
}
#date {
    letter-spacing:10px;
    font-size:14px;
    font-family:arial,sans-serif;
    color:#fff;
}

</style>

<script type="text/javascript">

function startTime() {
    var today = new Date();
    var hr = today.getHours();
    var min = today.getMinutes();
    var sec = today.getSeconds();
    ap = (hr < 12) ? "<span>AM</span>" : "<span>PM</span>";
    hr = (hr == 0) ? 12 : hr;
    hr = (hr > 12) ? hr - 12 : hr;
    //Add a zero in front of numbers<10
    hr = checkTime(hr);
    min = checkTime(min);
    sec = checkTime(sec);
    document.getElementById("clock").innerHTML = hr + ":" + min + ":" + sec + " " + ap;
    
    var dd=today.getDate();
    var mm=today.getMonth();
    var aa=today.getFullYear(); 
    var dd=checkTime(dd);
    var mm=checkTime(mm+1);
    var date = dd+"/"+mm+"/"+aa;

    document.getElementById("date").innerHTML = date;

    if (min == '50' && sec == '00'){
      document.location.reload()
    }

    if (min == '20' && sec == '00'){
      document.location.reload()
    }

    var time = setTimeout(function(){ startTime() }, 500);
}
function checkTime(i) {
    if (i < 10) {
        i = "0" + i;
    }
    return i;
}
</script>


<?php
// Establecer la zona horaria predeterminada a usar. Disponible desde PHP 5.1
date_default_timezone_set('America/Bogota');


echo  $hoy = date("Y-m-d H:i:s")."<br>";

$fecha = date("Y-m-d");


echo "<br>Prescripciones Subsidiadas ".$fecha.": <br>";
$handle = curl_init();
$url = "http://localhost/SISTEMA_MIPRESv2/WebService/Prescripcion.php?link=https://wsmipres.sispro.gov.co/wsmipresnopbs/api/Prescripcion/809008362".'/'.$fecha.'/'."2FF21E1A-BAD1-4B18-9E2E-DF8D9F66F5A8";
curl_setopt($handle, CURLOPT_URL, $url);
curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);
curl_setopt($handle, CURLOPT_SSL_VERIFYPEER, false);
$output = curl_exec($handle);
curl_close($handle);
echo $output;
echo "<br>Prescripciones Contributivas ".$fecha.": <br>";
$handle = curl_init(); 
$url  = "http://localhost/SISTEMA_MIPRESv2/WebService/Prescripcion.php?link=https://wsmipres.sispro.gov.co/wsmipresnopbs/api/Prescripcion/809008362".'/'.$fecha.'/'."C62D7406-E4FC-4BAE-AD9E-32812963A826";
curl_setopt($handle, CURLOPT_URL, $url);
curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);
curl_setopt($handle, CURLOPT_SSL_VERIFYPEER, false);
$output = curl_exec($handle);
curl_close($handle);
echo $output;

echo "<br>Direccionamientos Subsidiados ".$fecha.": <br>";
$handle = curl_init();
$url = "http://localhost/SISTEMA_MIPRESv2/WebService/Direccionamiento.php?link=https://wsmipres.sispro.gov.co/WSSUMMIPRESNOPBS/api/DireccionamientoXFecha/809008362".'/'.token_temporal($conn,'S').'/'.$fecha;
curl_setopt($handle, CURLOPT_URL, $url);
curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);
curl_setopt($handle, CURLOPT_SSL_VERIFYPEER, false);
$output = curl_exec($handle);
curl_close($handle);
echo $output;
echo "<br>Direccionamientos Contributivos ".$fecha.": <br>";
$handle = curl_init(); 
$url  = "http://localhost/SISTEMA_MIPRESv2/WebService/Direccionamiento.php?link=https://wsmipres.sispro.gov.co/WSSUMMIPRESNOPBS/api/DireccionamientoXFecha/809008362".'/'.token_temporal($conn,'C').'/'.$fecha;
curl_setopt($handle, CURLOPT_URL, $url);
curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);
curl_setopt($handle, CURLOPT_SSL_VERIFYPEER, false);
$output = curl_exec($handle);
curl_close($handle);
echo $output;

echo "<br>Reporte Proveedor Subsidiados ".$fecha.": <br>";
$handle = curl_init();
$url = "http://localhost/SISTEMA_MIPRESv2/WebService/ReporteProveedor.php?link=https://wsmipres.sispro.gov.co/WSSUMMIPRESNOPBS/api/ReporteEntregaXFecha/809008362".'/'.token_temporal($conn,'S').'/'.$fecha;
curl_setopt($handle, CURLOPT_URL, $url);
curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);
curl_setopt($handle, CURLOPT_SSL_VERIFYPEER, false);
$output = curl_exec($handle);
curl_close($handle);
echo $output;
echo "<br>Reporte Proveedor Contributivos ".$fecha.": <br>";
$handle = curl_init(); 
$url = "http://localhost/SISTEMA_MIPRESv2/WebService/ReporteProveedor.php?link=https://wsmipres.sispro.gov.co/WSSUMMIPRESNOPBS/api/ReporteEntregaXFecha/809008362".'/'.token_temporal($conn,'C').'/'.$fecha;
curl_setopt($handle, CURLOPT_URL, $url);
curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);
curl_setopt($handle, CURLOPT_SSL_VERIFYPEER, false);
$output = curl_exec($handle);
curl_close($handle);
echo $output;

echo "<br>Reporte Suministro Subsidiados ".$fecha.": <br>";
$handle = curl_init();
$url = "http://localhost/SISTEMA_MIPRESv2/WebService/Suministro.php?link=https://wsmipres.sispro.gov.co/WSSUMMIPRESNOPBS/api/SuministroXFecha/809008362".'/'.token_temporal($conn,'S').'/'.$fecha;
curl_setopt($handle, CURLOPT_URL, $url);
curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);
curl_setopt($handle, CURLOPT_SSL_VERIFYPEER, false);
$output = curl_exec($handle);
curl_close($handle);
echo $output;
echo "<br>Reporte Suministro Contributivos ".$fecha.": <br>";
$handle = curl_init(); 
$url = "http://localhost/SISTEMA_MIPRESv2/WebService/Suministro.php?link=https://wsmipres.sispro.gov.co/WSSUMMIPRESNOPBS/api/SuministroXFecha/809008362".'/'.token_temporal($conn,'C').'/'.$fecha;
curl_setopt($handle, CURLOPT_URL, $url);
curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);
curl_setopt($handle, CURLOPT_SSL_VERIFYPEER, false);
$output = curl_exec($handle);
curl_close($handle);
echo $output;

echo "<br>Tutelas Subsidiadas ".$fecha.": <br>";
$handle = curl_init();
$url = "http://localhost/SISTEMA_MIPRESv2/WebService/Tutelas.php?link=https://wsmipres.sispro.gov.co/wsmipresnopbs/api/Tutelas/809008362".'/'.$fecha.'/'."2FF21E1A-BAD1-4B18-9E2E-DF8D9F66F5A8";
curl_setopt($handle, CURLOPT_URL, $url);
curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);
curl_setopt($handle, CURLOPT_SSL_VERIFYPEER, false);
$output = curl_exec($handle);
curl_close($handle);
echo $output;
echo "<br>Tutelas Contributivas ".$fecha.": <br>";
$handle = curl_init(); 
$url  = "http://localhost/SISTEMA_MIPRESv2/WebService/Tutelas.php?link=https://wsmipres.sispro.gov.co/wsmipresnopbs/api/Tutelas/809008362".'/'.$fecha.'/'."C62D7406-E4FC-4BAE-AD9E-32812963A826";
curl_setopt($handle, CURLOPT_URL, $url);
curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);
curl_setopt($handle, CURLOPT_SSL_VERIFYPEER, false);
$output = curl_exec($handle);
curl_close($handle);
echo $output;

echo "<br>No Direccionamientos Subsidiados ".$fecha.": <br>";
$handle = curl_init();
$url = "http://localhost/SISTEMA_MIPRESv2/WebService/NoDireccionamiento.php?link=https://wsmipres.sispro.gov.co/WSSUMMIPRESNOPBS/api/NODireccionamientoXFecha/809008362".'/'.token_temporal($conn,'S').'/'.$fecha;
curl_setopt($handle, CURLOPT_URL, $url);
curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);
curl_setopt($handle, CURLOPT_SSL_VERIFYPEER, false);
$output = curl_exec($handle);
curl_close($handle);
echo $output;
echo "<br>No Direccionamientos Contributivos ".$fecha.": <br>";
$handle = curl_init(); 
$url  = "http://localhost/SISTEMA_MIPRESv2/WebService/NoDireccionamiento.php?link=https://wsmipres.sispro.gov.co/WSSUMMIPRESNOPBS/api/NODireccionamientoXFecha/809008362".'/'.token_temporal($conn,'C').'/'.$fecha;
curl_setopt($handle, CURLOPT_URL, $url);
curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);
curl_setopt($handle, CURLOPT_SSL_VERIFYPEER, false);
$output = curl_exec($handle);
curl_close($handle);
echo $output;

echo "<br>Novedades Prescripción Subsidiados ".$fecha.": <br>";
$handle = curl_init();
$url = "http://localhost/SISTEMA_MIPRESv2/WebService/NovedadesPrescripcion.php?link=https://wsmipres.sispro.gov.co/wsmipresnopbs/api/NovedadesPrescripcion/809008362".'/'.$fecha.'/'."2FF21E1A-BAD1-4B18-9E2E-DF8D9F66F5A8";
curl_setopt($handle, CURLOPT_URL, $url);
curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);
curl_setopt($handle, CURLOPT_SSL_VERIFYPEER, false);
$output = curl_exec($handle);
curl_close($handle);
echo $output;
echo "<br>Novedades Prescripción Contributivos ".$fecha.": <br>";
$handle = curl_init(); 
$url  = "http://localhost/SISTEMA_MIPRESv2/WebService/NovedadesPrescripcion.php?link=https://wsmipres.sispro.gov.co/wsmipresnopbs/api/NovedadesPrescripcion/809008362".'/'.$fecha.'/'."C62D7406-E4FC-4BAE-AD9E-32812963A826";
curl_setopt($handle, CURLOPT_URL, $url);
curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);
curl_setopt($handle, CURLOPT_SSL_VERIFYPEER, false);
$output = curl_exec($handle);
curl_close($handle);
echo $output;

echo "<br>Junta Profesionales Subsidiados ".$fecha.": <br>";
$handle = curl_init();
$url = "http://localhost/SISTEMA_MIPRESv2/WebService/JuntaProfesional.php?link=https://wsmipres.sispro.gov.co/wsmipresnopbs/api/JuntaProfesionalXFecha/809008362".'/'."2FF21E1A-BAD1-4B18-9E2E-DF8D9F66F5A8".'/'.$fecha;
curl_setopt($handle, CURLOPT_URL, $url);
curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);
curl_setopt($handle, CURLOPT_SSL_VERIFYPEER, false);
$output = curl_exec($handle);
curl_close($handle);
echo $output;
echo "<br>Junta Profesionales Contributivos ".$fecha.": <br>";
$handle = curl_init(); 
$url  = "http://localhost/SISTEMA_MIPRESv2/WebService/JuntaProfesional.php?link=https://wsmipres.sispro.gov.co/wsmipresnopbs/api/JuntaProfesionalXFecha/809008362".'/'."C62D7406-E4FC-4BAE-AD9E-32812963A826".'/'.$fecha;
curl_setopt($handle, CURLOPT_URL, $url);
curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);
curl_setopt($handle, CURLOPT_SSL_VERIFYPEER, false);
$output = curl_exec($handle);
curl_close($handle);
echo $output;

?>




</body>


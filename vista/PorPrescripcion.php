
<div class="row">
  <div class="col-md-3 sm-12">
    <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
      <a class="btn btn-outline-dark btn-block" id="v-pills-profile-tab" href="index.php"><center>Volver al Inicio</center></a>
    </div>
    <br>
    <center><div id="barra" class="spinner-border text-success" style = 'display:none;'></div></center>
  </div>

		 <div class="col-md-9 sm-12">
			<div class="card shadow">
			  <div class="card-header">
			    <H4>Prescripciones por número</H4>
			  </div>
			  <div class="card-body">
					
					<form action="index.php?x=043&y=001" method="post">
					<div class="form-row">
					<div class="col-md-6 sm-12">
					<label for="validationCustom02">Numero de Prescripción</label>
					<input type="number" class="form-control" id="var_NO" name="var_NO" required 
                    value="" autofocus>
					</div>
					<div class="col-md-2 sm-12">
					<label for="validationCustom02"><br></label>
					<button 
					class="btn btn-outline-dark btn-block" type="submit">Buscar</button>   
                    <br>                 
					</div>
					</div>	
					</form>

			  </div>
			</div>
		</div>
 
  
  
</div>
  





<?php
if (isset($_GET["y"]))
{
    switch ($_GET["y"])
    {
        case '001':
         $NO = trim($_POST["var_NO"]);
    ?>
      <script type="text/javascript">
        $(document).ready(function()
        {
        $("#var_NO").val('<?php echo $NO; ?>');
        });
      </script>
    <?php
        break;
    }
}
?>




<br>

<div>
    <div class="card shadow">

<ul class="nav nav-tabs" role="tablist">
    <li class="nav-item">
      <a class="nav-link active" data-toggle="tab" href="#home">Prescripción</a>
    </li>
  </ul>


 <div class="col-md-12 sm-12">
  <div class="tab-content">
    <div id="home" class="tab-pane active"><br>
        <?php
if (!empty($NO)) {
    
    $sql = "
	SELECT
    TIPOIDPACIENTE,  NROIDPACIENTE,
	NOPRESCRIPCION,
	FPRESCRIPCION,
	IIF(CODAMBATE='11','AMBULATORIO-PRIORIZADO',IIF(CODAMBATE='12','AMBULATORIO-NO PRIORIZADO',
	IIF(CODAMBATE='21','HOSPITALARIO-DOMICILIARIO',IIF(CODAMBATE='22','HOSPITALARIO-INTERNACION',
	IIF(CODAMBATE='30','URGENCIAS','NO APLICA'))))) CODAMBATE,
	IIF(REPORTMIPRES='NOPRESCRIPCION','PRESCRIPCION','TUTELA') REPORTMIPRES,
	IIF(IIF(REPORTMIPRES='NOPRESCRIPCION',ESTPRES,ESTTUT)=1,'MODIFICADO',
	IIF(IIF(REPORTMIPRES='NOPRESCRIPCION',ESTPRES,ESTTUT)=2,'ANULADO',
	IIF(IIF(REPORTMIPRES='NOPRESCRIPCION',ESTPRES,ESTTUT)=4,'ACTIVO','DESCONOCIDO')))  EST
	FROM [MIPRES_PRESCRIPCION ]
	WHERE NOPRESCRIPCION like '".$NO."%'
	ORDER BY 2 DESC ";
    $stmt2 = sqlsrv_query($conn, $sql, array());
    
    if ($stmt2 !== NULL) {
        $rows2 = sqlsrv_has_rows($stmt2);
        
        if ($rows2 === true) {
?>

          <br>
          <div class="row">
            <div class="col">
                <div class="card shadow">
                <div class="card-body">
          <div class="row">
            <div class="col">              
                    <table class="table">
                    <thead class="thead-light">
                      <tr>
                        <th>NO. PRESCRIPCIÓN</th>
                        <th>FEC. PRESCRIPCIÓN</th>
                        <th>AMBITO</th>
                        <th>TIPO REPORTE</th>
                        <th>ESTADO</th>
                        <th>ACCIONES</th>
                        <th>POR USUARIO</th>
                      </tr>
                    </thead>
                    <tbody>
<?php
            while ($row2 = sqlsrv_fetch_array($stmt2, SQLSRV_FETCH_ASSOC)) {


?>							<tr>
                            <td><?php echo $row2['NOPRESCRIPCION'];  ?></td>
                            <td><?php echo $row2['FPRESCRIPCION']->format('d/m/Y');  ?></td>
                            <td><?php echo $row2['CODAMBATE'];  ?></td>
							<td><?php echo $row2['REPORTMIPRES'];  ?></td>
                            <td><?php echo $row2['EST'];  ?></td>
                            <td>
							 <div class="input-group">
							  <input type="hidden" class="form-control" aria-label="Text input with segmented dropdown button">
							  <div class="input-group-append">
							    <button type="button" class="btn btn-outline-secondary" onclick="javascript:ServiciosSolicitados('<?php echo $row2['NOPRESCRIPCION'];  ?>');">Ver</button>
							    <button type="button" class="btn btn-outline-secondary dropdown-toggle dropdown-toggle-split" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
							      <span class="sr-only">Toggle Dropdown</span>
							    </button>
							    <div class="dropdown-menu">
                  <form class="" action="index.php?x=043&y=001&z=001" method="post">
                  <input type="hidden" class="form-control" name="prs" value="<?php echo trim($row2['NOPRESCRIPCION']);?>"  required>
                  <input type="hidden" class="form-control" name="var_NO" value="<?php echo trim($NO);?>"  required>
                  <button class="dropdown-item" type="submit">Actualizar</button>  
                  </form>
							    </div>
							  </div>
                            </td>
                            <td>
                  <form class="" action="index.php?x=041&y=001" method="post">
                  <input type="hidden" class="form-control" name="var_TI" value="<?php echo trim($row2['TIPOIDPACIENTE']);?>"  required>
                  <input type="hidden" class="form-control" name="var_NI" value="<?php echo trim($row2['NROIDPACIENTE']);?>"  required>
                  <button 
                    class="btn btn-outline-dark btn-block" type="submit"><?php echo trim($row2['TIPOIDPACIENTE']).'-'.trim($row2['NROIDPACIENTE']);?></button>
                  </form>
                            </td>
                            </tr>

<?php
            }
?>

                    </tbody>
                    </table>
            </div>
          </div>

                </div>
                </div>
            </div>
          </div>
<?php
        } else {
            echo "<BR>\nNo se encuentran prescripciones para el afiliado \n<br><br>";
        }
    }   
}


?>
</div>
</div>
</div>

</div>
</div>


<?php
if (isset($_GET["z"]))
{
    switch ($_GET["z"])
    {
    case '001':
    ?>
    <br>
    <div class="card shadow" style = 'display:block;'>
    <div class="card-header">
    <?php  
    $prs = trim($_POST["prs"]);

    echo "<br>Prescripciones Subsidiadas ".$prs.": <br>";
    $handle = curl_init();
    $url = $_SESSION['RUTA_PROYECTO']."WebService/Prescripcion.php?link=https://wsmipres.sispro.gov.co/wsmipresnopbs/api/PrescripcionXNumero/".$_SESSION['NIT_EPS'].'/'.$_SESSION['PRETOCKENSUB'].'/'.$prs;
    curl_setopt($handle, CURLOPT_URL, $url);
    curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($handle, CURLOPT_SSL_VERIFYPEER, false);
    $output = curl_exec($handle);
    curl_close($handle);
    echo $output;
    echo "<br>Prescripciones Contributivas ".$prs.": <br>";
    $handle = curl_init(); 
    $url  = $_SESSION['RUTA_PROYECTO']."WebService/Prescripcion.php?link=https://wsmipres.sispro.gov.co/wsmipresnopbs/api/PrescripcionXNumero/".$_SESSION['NIT_EPS'].'/'.$_SESSION['PRETOCKEN'].'/'.$prs;
    curl_setopt($handle, CURLOPT_URL, $url);
    curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($handle, CURLOPT_SSL_VERIFYPEER, false);
    $output = curl_exec($handle);
    curl_close($handle);
    echo $output;

    echo "<br>Direccionamientos Subsidiados ".$prs.": <br>";
    $handle = curl_init();
    $url = $_SESSION['RUTA_PROYECTO']."WebService/Direccionamiento.php?link=https://wsmipres.sispro.gov.co/WSSUMMIPRESNOPBS/api/DireccionamientoXPrescripcion/".$_SESSION['NIT_EPS'].'/'.token_temporal($conn,'S').'/'.$prs;
    curl_setopt($handle, CURLOPT_URL, $url);
    curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($handle, CURLOPT_SSL_VERIFYPEER, false);
    $output = curl_exec($handle);
    curl_close($handle);
    echo $output;
    echo "<br>Direccionamientos Contributivos ".$prs.": <br>";
    $handle = curl_init();
    $url = $_SESSION['RUTA_PROYECTO']."WebService/Direccionamiento.php?link=https://wsmipres.sispro.gov.co/WSSUMMIPRESNOPBS/api/DireccionamientoXPrescripcion/".$_SESSION['NIT_EPS'].'/'.token_temporal($conn,'C').'/'.$prs;
    curl_setopt($handle, CURLOPT_URL, $url);
    curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($handle, CURLOPT_SSL_VERIFYPEER, false);
    $output = curl_exec($handle);
    curl_close($handle);
    echo $output;


    echo "<br>Reporte Proveedor Subsidiados ".$prs.": <br>";
    $handle = curl_init();
    $url = $_SESSION['RUTA_PROYECTO']."WebService/ReporteProveedor.php?link=https://wsmipres.sispro.gov.co/WSSUMMIPRESNOPBS/api/ReporteEntregaXPrescripcion/".$_SESSION['NIT_EPS'].'/'.token_temporal($conn,'S').'/'.$prs;
    curl_setopt($handle, CURLOPT_URL, $url);
    curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($handle, CURLOPT_SSL_VERIFYPEER, false);
    $output = curl_exec($handle);
    curl_close($handle);
    echo $output;
    echo "<br>Reporte Proveedor Contributivos ".$prs.": <br>";
    $handle = curl_init(); 
    $url  = $_SESSION['RUTA_PROYECTO']."WebService/ReporteProveedor.php?link=https://wsmipres.sispro.gov.co/WSSUMMIPRESNOPBS/api/ReporteEntregaXPrescripcion/".$_SESSION['NIT_EPS'].'/'.token_temporal($conn,'C').'/'.$prs;
    curl_setopt($handle, CURLOPT_URL, $url);
    curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($handle, CURLOPT_SSL_VERIFYPEER, false);
    $output = curl_exec($handle);
    curl_close($handle);
    echo $output;
    

    echo "<br>Reporte Suministro Subsidiados ".$prs.": <br>";
    $handle = curl_init();
    $url = $_SESSION['RUTA_PROYECTO']."WebService/Suministro.php?link=https://wsmipres.sispro.gov.co/WSSUMMIPRESNOPBS/api/SuministroXPrescripcion/".$_SESSION['NIT_EPS'].'/'.token_temporal($conn,'S').'/'.$prs;
    curl_setopt($handle, CURLOPT_URL, $url);
    curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($handle, CURLOPT_SSL_VERIFYPEER, false);
    $output = curl_exec($handle);
    curl_close($handle);
    echo $output;
    echo "<br>Reporte Suministro Contributivos ".$prs.": <br>";
    $handle = curl_init(); 
    $url  = $_SESSION['RUTA_PROYECTO']."WebService/Suministro.php?link=https://wsmipres.sispro.gov.co/WSSUMMIPRESNOPBS/api/SuministroXPrescripcion/".$_SESSION['NIT_EPS'].'/'.token_temporal($conn,'C').'/'.$prs;
    curl_setopt($handle, CURLOPT_URL, $url);
    curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($handle, CURLOPT_SSL_VERIFYPEER, false);
    $output = curl_exec($handle);
    curl_close($handle);
    echo $output;


    echo "<br>Tutelas Subsidiadas ".$prs.": <br>";
    $handle = curl_init();
    $url = $_SESSION['RUTA_PROYECTO']."WebService/Tutelas.php?link=https://wsmipres.sispro.gov.co/wsmipresnopbs/api/TutelaXNumero/".$_SESSION['NIT_EPS'].'/'.$_SESSION['PRETOCKENSUB'].'/'.$prs;
    curl_setopt($handle, CURLOPT_URL, $url);
    curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($handle, CURLOPT_SSL_VERIFYPEER, false);
    $output = curl_exec($handle);
    curl_close($handle);
    echo $output;
    echo "<br>Tutelas Contributivas ".$prs.": <br>";
    $handle = curl_init(); 
    $url  = $_SESSION['RUTA_PROYECTO']."WebService/Tutelas.php?link=https://wsmipres.sispro.gov.co/wsmipresnopbs/api/TutelaXNumero/".$_SESSION['NIT_EPS'].'/'.$_SESSION['PRETOCKEN'].'/'.$prs;
    curl_setopt($handle, CURLOPT_URL, $url);
    curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($handle, CURLOPT_SSL_VERIFYPEER, false);
    $output = curl_exec($handle);
    curl_close($handle);
    echo $output;

    echo "<br>No Direccionamientos Subsidiados ".$prs.": <br>";
    $handle = curl_init();
    $url = $_SESSION['RUTA_PROYECTO']."WebService/NoDireccionamiento.php?link=https://wsmipres.sispro.gov.co/WSSUMMIPRESNOPBS/api/NODireccionamientoXPrescripcion/".$_SESSION['NIT_EPS'].'/'.token_temporal($conn,'S').'/'.$prs;
    curl_setopt($handle, CURLOPT_URL, $url);
    curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($handle, CURLOPT_SSL_VERIFYPEER, false);
    $output = curl_exec($handle);
    curl_close($handle);
    echo $output;
    echo "<br>No Direccionamientos Contributivos ".$prs.": <br>";
    $handle = curl_init(); 
    $url  = $_SESSION['RUTA_PROYECTO']."WebService/NoDireccionamiento.php?link=https://wsmipres.sispro.gov.co/WSSUMMIPRESNOPBS/api/NODireccionamientoXPrescripcion//".$_SESSION['NIT_EPS'].'/'.token_temporal($conn,'C').'/'.$prs;
    curl_setopt($handle, CURLOPT_URL, $url);
    curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($handle, CURLOPT_SSL_VERIFYPEER, false);
    $output = curl_exec($handle);
    curl_close($handle);
    echo $output;

    echo "<br>Junta Profesionales Subsidiados ".$prs.": <br>";
    $handle = curl_init();
    $url = $_SESSION['RUTA_PROYECTO']."WebService/JuntaProfesional.php?link=https://wsmipres.sispro.gov.co/wsmipresnopbs/api/JuntaProfesional/".$_SESSION['NIT_EPS'].'/'.$_SESSION['PRETOCKENSUB'].'/'.$prs;
    curl_setopt($handle, CURLOPT_URL, $url);
    curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($handle, CURLOPT_SSL_VERIFYPEER, false);
    $output = curl_exec($handle);
    curl_close($handle);
    echo $output;
    echo "<br>Junta Profesionales Contributivos ".$prs.": <br>";
    $handle = curl_init(); 
    $url  = $_SESSION['RUTA_PROYECTO']."WebService/JuntaProfesional.php?link=https://wsmipres.sispro.gov.co/wsmipresnopbs/api/JuntaProfesional/".$_SESSION['NIT_EPS'].'/'.$_SESSION['PRETOCKEN'].'/'.$prs;
    curl_setopt($handle, CURLOPT_URL, $url);
    curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($handle, CURLOPT_SSL_VERIFYPEER, false);
    $output = curl_exec($handle);
    curl_close($handle);
    echo $output;

    ?>
    </div>
    </div>
    <script type="text/javascript">
    $(function() {
    ServiciosSolicitados('<?php echo $prs;  ?>');
    }); 
    </script>
    <?php  
    break;
    }
}
?>


  <div class="modal fade" data-backdrop="static" id="Ven_Direccionamiento">
    <div class="modal-dialog modal-dialog-centered modal-xl" >
      <div class="modal-content" >
      
        <!-- Modal Header -->
        <div class="modal-header">
          <h5 class="modal-title" id="titulo_modal"></h5>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        
        <!-- Modal body -->

<div class="container">
	<br>
  <!-- Nav tabs -->

  <div class="row">
  	<div class="col-md-3 sm-3">
  <ul class="nav flex-column" role="tablist">
    <li class="nav-item">
      <a class="btn btn-outline-dark btn-block" data-toggle="tab" href="#menu9">Información</a>
    </li>
    <li class="nav-item">
      <a class="btn btn-outline-dark btn-block" data-toggle="tab" href="#menu1">Serivicios Prescritos</a>
    </li>
    <li class="nav-item">
      <a class="btn btn-outline-dark btn-block" data-toggle="tab" href="#menu2">Servicios Autorizados</a>
    </li>
	<li class="nav-item">
	  <a class="btn btn-outline-dark btn-block" data-toggle="tab" href="#menu3">Direccionamientos</a>
	</li>
	<li class="nav-item">
	  <a class="btn btn-outline-dark btn-block" data-toggle="tab" href="#menu4">No Direccionamientos</a>
	</li>
		<li class="nav-item">
	  <a class="btn btn-outline-dark btn-block" data-toggle="tab" href="#menu5">Entrega Proveedor</a>
	</li>
	<li class="nav-item">
	  <a class="btn btn-outline-dark btn-block" data-toggle="tab" href="#menu6">Reporte Suministro</a>
	</li>
	<li class="nav-item">
	  <a class="btn btn-outline-dark btn-block" data-toggle="tab" href="#menu7">Novedades Prescripción</a>
	</li>
	<li class="nav-item">
	  <a class="btn btn-outline-dark btn-block" data-toggle="tab" href="#menu8">Junta Profesionales</a>
	</li>
  </ul>
 </div>

  <!-- Tab panes -->
 <div class="col-md-9 sm-9">
  <div class="tab-content">
    <div id="menu9" class="container tab-pane active">
      <h3>Información de la Prescripción</h3>
      <div id="Prescripcion"></div>
    </div>
    <div id="menu1" class="container tab-pane fade">
      <h3>Servicios Prescritos</h3>
      <div id="ServiciosPrescritos"></div>
    </div>
    <div id="menu2" class="container tab-pane fade">
      <h3>Servicios Autorizados</h3>
      <div id="ServiciosAutorizados"></div>
    </div>
    <div id="menu3" class="container tab-pane fade">
      <h3>Direccionamientos</h3>
      <div id="Direccionamientos"></div>
    </div>
    <div id="menu4" class="container tab-pane fade">
      <h3>No Direccionamientos</h3>
      <div id="NoDireccionamientos"></div>
    </div>
    <div id="menu5" class="container tab-pane fade">
      <h3>Entrega Proveedor</h3>
      <div id="EntregaProveedor"></div>
    </div>
    <div id="menu6" class="container tab-pane fade">
      <h3>Entrega Suministro por parte de la EPS</h3>
      <div id="EntregaSuministro"></div>
    </div>
    <div id="menu7" class="container tab-pane fade">
      <h3>Novedades de la prescripción</h3>
      <div id="Novedades"></div>
    </div>
    <div id="menu8" class="container tab-pane fade">
      <h3>Junta de profesionales</h3>
      <div id="JuantaProfesional"></div>
    </div>
  </div>
</div>


</div> 
</div>
<br> 


        <!-- Modal footer -->
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
        </div>
        
      </div>
    </div>
  </div>


 <script type="text/javascript">

function ServiciosSolicitados(NOPRESCRIPCION){ 
document.getElementById("titulo_modal").innerHTML = "Número de prescripción "+NOPRESCRIPCION;
$('#Ven_Direccionamiento').modal('show'); 
Prescripcion(NOPRESCRIPCION);     
ServiciosPrescritos(NOPRESCRIPCION);
ServiciosAutorizados(NOPRESCRIPCION);
Direccionamientos(NOPRESCRIPCION);
NoDireccionamientos(NOPRESCRIPCION);
EntregaProveedor(NOPRESCRIPCION);
EntregaSuministro(NOPRESCRIPCION);
Novedades(NOPRESCRIPCION);
JuantaProfesional(NOPRESCRIPCION);
}

function Prescripcion(NOPRESCRIPCION){ 
document.getElementById('Prescripcion').innerHTML = "<center><div class='spinner-border text-success'></div></center>";
$.post("vista/templates/PorUsuario/Prescripcion.php", {NOPRESCRIPCION: NOPRESCRIPCION}, function(data){
$("#Prescripcion").html(data);
});  
}

function ServiciosPrescritos(NOPRESCRIPCION){ 
document.getElementById('ServiciosPrescritos').innerHTML = "<center><div class='spinner-border text-success'></div></center>";
$.post("vista/templates/PorUsuario/ServiciosPrescritos.php", {NOPRESCRIPCION: NOPRESCRIPCION}, function(data){
$("#ServiciosPrescritos").html(data);
});  
}

function ServiciosAutorizados(NOPRESCRIPCION){ 
document.getElementById('ServiciosAutorizados').innerHTML = "<center><div class='spinner-border text-success'></div></center>";
$.post("vista/templates/PorUsuario/ServiciosAutorizados.php", {NOPRESCRIPCION: NOPRESCRIPCION}, function(data){
$("#ServiciosAutorizados").html(data);
});  
}

function Direccionamientos(NOPRESCRIPCION){ 
document.getElementById('Direccionamientos').innerHTML = "<center><div class='spinner-border text-success'></div></center>";
$.post("vista/templates/PorUsuario/Direccionamientos.php", {NOPRESCRIPCION: NOPRESCRIPCION}, function(data){
$("#Direccionamientos").html(data);
});  
}

function NoDireccionamientos(NOPRESCRIPCION){ 
document.getElementById('NoDireccionamientos').innerHTML = "<center><div class='spinner-border text-success'></div></center>";
$.post("vista/templates/PorUsuario/NoDireccionamientos.php", {NOPRESCRIPCION: NOPRESCRIPCION}, function(data){
$("#NoDireccionamientos").html(data);
});  
}

function EntregaProveedor(NOPRESCRIPCION){ 
document.getElementById('EntregaProveedor').innerHTML = "<center><div class='spinner-border text-success'></div></center>";
$.post("vista/templates/PorUsuario/EntregaProveedor.php", {NOPRESCRIPCION: NOPRESCRIPCION}, function(data){
$("#EntregaProveedor").html(data);
});  
}

function EntregaSuministro(NOPRESCRIPCION){ 
document.getElementById('EntregaSuministro').innerHTML = "<center><div class='spinner-border text-success'></div></center>";
$.post("vista/templates/PorUsuario/EntregaSuministro.php", {NOPRESCRIPCION: NOPRESCRIPCION}, function(data){
$("#EntregaSuministro").html(data);
});  
}

function Novedades(NOPRESCRIPCION){ 
document.getElementById('Novedades').innerHTML = "<center><div class='spinner-border text-success'></div></center>";
$.post("vista/templates/PorUsuario/Novedades.php", {NOPRESCRIPCION: NOPRESCRIPCION}, function(data){
$("#Novedades").html(data);
});  
}

function JuantaProfesional(NOPRESCRIPCION){ 
document.getElementById('JuantaProfesional').innerHTML = "<center><div class='spinner-border text-success'></div></center>";
$.post("vista/templates/PorUsuario/JuntaProfesional.php", {NOPRESCRIPCION: NOPRESCRIPCION}, function(data){
$("#JuantaProfesional").html(data);
});  
}
</script>



<script type="text/javascript" src="code.jquery.com/jquery-3.2.1.min.js"></script> 

<script>
 var var1 = $("#var1").val(); 
 var var2 = $("#var2").val(); 
$.ajax({ 
url:'recibo.php', 
data:{var1:var1,var2:var2}, 
type:'POST', 
datatype:'json' 
})
</script> 



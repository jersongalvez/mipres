
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
			    <H4>Nuevo Direccionamiento</H4>
			  </div>
			  <div class="card-body">
					<div class="form-row">
					<div class="col-md-4 sm-12">
					<label for="validationCustom01">Tipo Identificación</label>
					<select  id="var_TI" class="form-control" name="var_TI" required autofocus>
					<option></option>
					<option value="CC">CC</option>
					<option value="RC">RC</option>
					<option value="TI">TI</option>
					<option value="CE">CE</option>
					<option value="PA">PA</option>
					<option value="NV">NV</option>
					<option value="CD">CD</option>
					<option value="SC">SC</option>
					<option value="PR">PR</option>
					<option value="PE">PE</option>
					<option value="PT">PT</option>
					<option value="AS">AS</option>
					<option value="MS">MS</option>
					<option value="CN">CN</option>
					</select>
					</div>
					<div class="col-md-6 sm-12">
					<label for="validationCustom02">Numero de Identificación</label>
					<input type="number" class="form-control" id="var_NI" name="var_NI" required value="">
					</div>
					<div class="col-md-2 sm-12">
					<label for="validationCustom02"><br></label>
					<button
					class="btn btn-outline-dark btn-block" type="submit" onclick="javascript:ListarAutorizaciones();">Buscar</button> 
					<br>
					</div>
					</div>
			  </div>
			</div>
		</div>
</div>
<div class="col-md-12 sm-12">
<br>
<div id="ListarAutorizaciones"></div>
</div>
<script language="javascript">
function ListarAutorizaciones(){
  document.getElementById('ListarAutorizaciones').innerHTML = "<center><div class='spinner-border text-success'></center></div>";
	var var_TI = document.getElementById("var_TI").value;
	var var_NI = document.getElementById("var_NI").value;
	$.post("vista/templates/ListarAutorizaciones.php", {var_TI: var_TI,var_NI:var_NI}, function(data){
	$("#ListarAutorizaciones").html(data);
  });
}

function tabla_autorizaciones(){
  $( "#tabla_autorizaciones" ).toggle( "blind" );
}

</script>
<?php
if (isset($_GET["y"]))
{
    switch ($_GET["y"])
    {
        case '001':
?>
		<script type="text/javascript">
		document.getElementById("var_NI").value='<?php echo $_GET['NI']; ?>';
		document.getElementById("var_TI").value='<?php echo $_GET['TI']; ?>';
		ListarAutorizaciones();
		</script>
		<?php
        break;
    }
}
?>

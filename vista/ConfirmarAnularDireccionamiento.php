<div class="row">
  <div class="col-md-3 sm-12">
    <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
      <a class="btn btn-outline-dark btn-block" id="v-pills-profile-tab" href="index.php"><center>Volver al Inicio</center></a>
      <a class="btn btn-outline-dark btn-block" id="v-pills-profile-tab" href="index.php?x=010&y=001&TI=<?php echo $_POST['TipoIDPaciente']; ?>&NI=<?php echo $_POST['NoIDPaciente']; ?>"><center>Regresar por Usuario</center></a>
      <a class="btn btn-outline-dark btn-block" id="v-pills-profile-tab" href="index.php?x=036"><center>Servicios por Anular</center></a>
    </div>
    <br>
    <center><div id="barra" class="spinner-border text-success" style = 'display:none;'></div></center>
  </div>

		 <div class="col-md-9 sm-12">
			<div class="card shadow">
			  <div class="card-header">
			    <H4> Anular Direccionamiento</H4>
			  </div>
			  <div class="card-body">
			  	<center><H4>¿Esta seguro de Anular el Direccionamiento <?php echo $_POST['IDDIRECCIONAMIENTO']; ?>?</H4></center><br>
				<form class="" action="index.php?x=011" method="post" >
				<input type="hidden" class="form-control" id="NO_SOLICITUD" name="NO_SOLICITUD" value="<?php echo $_POST['NO_SOLICITUD']; ?>">
				<input type="hidden" class="form-control" id="TABLA" name="TABLA" value="<?php echo $_POST['TABLA']; ?>">
				<input type="hidden" class="form-control" id="CD_SERVICIO" name="CD_SERVICIO" value="<?php echo $_POST['CD_SERVICIO']; ?>">
				<input type="hidden" class="form-control" id="OBSERVACIONES" name="OBSERVACIONES" value="<?php echo $_POST['OBSERVACIONES']; ?>">
				<input type="hidden" class="form-control" id="IDENTIFICADOR" name="IDENTIFICADOR" value="<?php echo $_POST['IDENTIFICADOR']; ?>">
				<input type="hidden" class="form-control" id="IDDIRECCIONAMIENTO" name="IDDIRECCIONAMIENTO" value="<?php echo $_POST['IDDIRECCIONAMIENTO']; ?>">
				<input type="hidden" class="form-control" id="DES_TEM_TOKEN" name="DES_TEM_TOKEN" value="<?php echo $_POST['DES_TEM_TOKEN']; ?>">

				<input type="hidden" class="form-control" id="TipoIDPaciente" name="TipoIDPaciente" value="<?php echo $_POST['TipoIDPaciente']; ?>">
				<input type="hidden" class="form-control" id="NoIDPaciente" name="NoIDPaciente" value="<?php echo $_POST['NoIDPaciente']; ?>">

				<button class="btn btn-outline-dark btn-block" type="submit">Si, estoy seguro</button>  
				</form>
			  </div>
			</div>
		</div>
</div>


 



<div class="row">
    <div class="col-md-3 sm-12">
        <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
            <a class="btn btn-outline-dark btn-block" id="v-pills-profile-tab" href="index.php?x=021&y=001&TI=<?php echo $_POST['TipoIDPaciente']; ?>&NI=<?php echo $_POST['NoIDPaciente']; ?>"><center>Regresar</center></a>
        </div>
        <br>
        <center><div id="barra" class="spinner-border text-success" style = 'display:none;'></div></center>
    </div>

    <div class="col-md-9 sm-12">
        <div class="card shadow">
            <div class="card-header">
                <H4> Anular No Direccionamiento</H4>
            </div>
            <div class="card-body">
                <center><H4>¿Esta seguro de Anular el No Direccionamiento <?php echo $_POST['IDNODireccionamiento']; ?>?</H4></center><br>
                <form class="" action="index.php?x=023" method="post" >
                    <!--<input type="hidden" class="form-control" id="NO_SOLICITUD" name="NO_SOLICITUD" value="<?php //echo $_POST['NO_SOLICITUD']; ?>">-->
                    <input type="hidden" class="form-control" id="TABLA" name="TABLA" value="<?php echo $_POST['TABLA']; ?>">
                    <input type="hidden" class="form-control" id="CD_SERVICIO" name="CD_SERVICIO" value="<?php echo $_POST['CD_SERVICIO']; ?>">
                    <input type="hidden" class="form-control" id="IDNODireccionamiento" name="IDNODireccionamiento" value="<?php echo $_POST['IDNODireccionamiento']; ?>">
                    <input type="hidden" class="form-control" id="REGIMEN" name="REGIMEN" value="<?php echo $_POST['REGIMEN']; ?>">

                    <input type="hidden" class="form-control" id="TipoIDPaciente" name="TipoIDPaciente" value="<?php echo $_POST['TipoIDPaciente']; ?>">
                    <input type="hidden" class="form-control" id="NoIDPaciente" name="NoIDPaciente" value="<?php echo $_POST['NoIDPaciente']; ?>">

                    <button class="btn btn-outline-dark btn-block" type="submit">Si, estoy seguro</button>  
                </form>
            </div>
        </div>
    </div>
</div>

 



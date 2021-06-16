<?php
$fechafinal = date('Y-m-d');
$fechafinal = strtotime('+2 day', strtotime($fechafinal));
$fechafinal = date('Y-m-d', $fechafinal);
?>

<div class="container-fluid" style="margin-top:80px">



    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">Reportes</li>
            <li class="breadcrumb-item"><a  href="index.php?x=039">Direccionamientos / Servicios Autorizados</a></li>
        </ol>
    </nav>

    <div class="container">

        <div class="row">

            <div class="col-md-12 sm-12">
                <div class="card">
                    <div class="card-header">
                        <H4>Direccionamientos / Servicios Autorizados</H4>
                    </div>
                    <div class="card-body">

                        <form class="" action="vista/templates/ListarDireccionamientoSeguimiento.php" method="post">
                            <div class="form-row">
                                <div class="col-md-3 sm-12">
                                    <label for="validationCustom01">Fecha Inicial</label>
                                    <input type="date" class="form-control" id="fechainicial" name="fechainicial" value="<?php echo date('Y-m') . "-01"; ?>"  required>
                                </div>
                                <div class="col-md-3 sm-12">
                                    <label for="validationCustom02">Fecha final</label>
                                    <input type="date" class="form-control" id="fechafinal" name="fechafinal" value="<?php echo $fechafinal; ?>"  required>
                                </div>
                                <div class="col-md-3 sm-12">
                                    <label for="validationCustom02"><br></label>
                                    <button 
                                        class="btn btn-outline-success btn-block" type="submit" target="_blank">Descargar</button> 
                                </div>
                            </div>
                        </form>
                        <!--
                        <button class="btn btn-outline-success btn-block" onclick="javascript:ListarAutorizaciones();">Visualizar</button> 		
                        <br>
                        <div id="ListarAutorizaciones"></div>	-->				
                    </div>
                </div>
            </div>
        </div>



    </div>

</div>


<script language="javascript">
    function ListarAutorizaciones() {
        document.getElementById('ListarAutorizaciones').innerHTML = "<center><div class='spinner-border text-success'></center></div>";
        var fechainicial = document.getElementById("fechainicial").value;
        var fechafinal = document.getElementById("fechafinal").value;
        $.post("vista/templates/ListarDireccionamientoSeguimiento.php", {fechainicial: fechainicial, fechafinal: fechafinal}, function (data) {
            $("#ListarAutorizaciones").html(data);
        });
    }


    function tabla_autorizaciones() {
        $("#tabla_autorizaciones").toggle("blind");
    }


    $(document).ready(function () {

    });
</script>


<?php
if (isset($_GET["y"])) {
    switch ($_GET["y"]) {
        case '001':
            ?>
            <script type="text/javascript">
                document.getElementById("var_NI").value = '<?php echo $_GET['NI']; ?>';
                document.getElementById("var_TI").value = '<?php echo $_GET['TI']; ?>';
                ListarAutorizaciones();
            </script>
            <?php
            break;
    }
}
?>

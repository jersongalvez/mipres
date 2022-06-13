<div class="row">
    <div class="col-md-3 sm-12">
        <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
            <a class="btn btn-outline-dark btn-block" id="v-pills-profile-tab" href="index.php?x=007&y=001&TI=<?php echo $_POST['TipoIDPaciente']; ?>&NI=<?php echo $_POST['NoIDPaciente']; ?>"><center>Regresar por Usuario</center></a>
            <a class="btn btn-outline-dark btn-block" id="v-pills-profile-tab" href="index.php?x=035"><center>Ser. sin Direccionar</center></a>
            <a class="btn btn-outline-dark btn-block" id="v-pills-profile-tab" href="index.php?x=007"><center>Nuevo Direccionamiento</center></a>
        </div>
    </div>
    <div class="col-md-9 sm-12">
        <div class="tab-content" id="v-pills-tabContent">

            <div class="card shadow">
                <div class="card-header">
                    <H4>
                        Nuevo Direccionamiento
                    </H4>
                </div>
                <div class="card-body">
                    <div id="ProcesoDireccionamiento"><center><div class='spinner-border text-success'></div></center></div>

                    <?php
                    require_once('modelo/conexion-sql.php');


                    if ((!empty($_POST['NO_SOLICITUD'])) and (!empty($_POST['TABLA'])) and (!empty($_POST['CD_SERVICIO'])) and (!empty($_POST['DES_TEM_TOKEN'])) and (!empty($_POST['NoPrescripcion'])) and (!empty($_POST['TipoTec'])) and (!empty($_POST['ConTec'])) and (!empty($_POST['CodSerTecAEntregar'])) and (!empty($_POST['TipoIDPaciente'])) and (!empty($_POST['NoIDPaciente'])) and (!empty($_POST['NoEntrega']))  and (!empty($_POST['TipoIDProv'])) and (!empty($_POST['NoIDProv'])) and (!empty($_POST['CodMunEnt'])) and (!empty($_POST['FecMaxEnt'])) and (!empty($_POST['CantTotAEntregar'])) and (!empty($_POST['DirPaciente']))) {

                        $NO_SOLICITUD = $_POST['NO_SOLICITUD'];
                        $TABLA = $_POST['TABLA'];
                        $CD_SERVICIO = $_POST['CD_SERVICIO'];
                        //echo $NO_SOLICITUD.'<br>';
                        //echo $TABLA.'<br>';
                        //echo $CD_SERVICIO.'<br>';


                        if (isset($_GET["x"])) {
                            switch ($_GET["x"]) {
                                case '009':
                                    require_once("services/PUT-api-Direccionamiento-nit-token.php");
                                    if (!curl_errno($ch)) {
                                        switch ($http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE)) {

                                            case 200:  # OK
                                            
                                                //$sql = "UPDATE SERVICIOS_AUTORIZADOS SET IDENTIFICADOR = ?, IDDIRECCIONAMIENTO = ?, DIREC_USUARIO = ?, DIREC_FECHA = CURRENT_TIMESTAMP WHERE NO_SOLICITUD = '" . $_POST['NO_SOLICITUD'] . "' AND TABLA = '" . $_POST['TABLA'] . "' AND CD_SERVICIO LIKE '%" . $_POST['CD_SERVICIO'] . "%'; ";
                                                $sql = "UPDATE SERVICIOS_AUTORIZADOS SET IDENTIFICADOR = ?, IDDIRECCIONAMIENTO = ?, DIREC_USUARIO = ?, DIREC_FECHA = CURRENT_TIMESTAMP "
                                                        . "WHERE NO_SOLICITUD = '" . $_POST['NO_SOLICITUD'] . "' AND TABLA = '" . $_POST['TABLA'] . "'";

                                                $registro = $result;
                                                $registro = json_decode($registro, true);
                                                $Id = $registro[0]["Id"];
                                                $IdDireccionamiento = $registro[0]["IdDireccionamiento"];
                                                $params = array($Id, $IdDireccionamiento, $_SESSION["usuario"]);
                                                $options = array("Scrollable" => SQLSRV_CURSOR_KEYSET);
                                                $stmt = sqlsrv_query($conn, $sql, $params, $options);
                                                if ($stmt === FALSE) {
                                                    echo "<div class='alert alert-danger alert-dismissible'>";
                                                    echo "<button type='button' class='close' data-dismiss='alert'>&times;</button>";
                                                    echo "<strong>Error!</strong> No se pudo proceder con la solucitud, por favor intente de nuevo.</div>";
                                                } else {
                                                    ?>
                                                    <div class="row">
                                                        <div class="col-md-12 sm-12">
                                                            <div class="form-row">
                                                                <div class="col-md-4 sm-12">
                                                                    <label>Id</label>
                                                                </div>
                                                                <div class="col-md-8 sm-12">
                                                                    <input type="number" class="form-control" id="Id" name="Id" required readonly value="<?php echo $Id ?>">
                                                                </div>
                                                            </div>
                                                            <div class="form-row">
                                                                <div class="col-md-4 sm-12">
                                                                    <label>Id Direccionamiento</label>
                                                                </div>
                                                                <div class="col-md-8 sm-12">
                                                                    <input type="number" class="form-control" id="IdDireccionamiento" name="IdDireccionamiento" required readonly value="<?php echo $IdDireccionamiento ?>"> 
                                                                </div>
                                                            </div>                   
                                                        </div>
                                                    </div>
                                                    <?php
                                                    $sql1 = "INSERT INTO [dbo].[MIPRES_DIRECCIONAMIENTOS]([ID],[IDDireccionamiento])VALUES('" . $registro[0]["Id"] . "','" . $registro[0]["IdDireccionamiento"] . "'); ";
                                                    sql($conn, $sql1);

                                                    $sql2 = "UPDATE AUTORIZACION SET OBSERVACIONES = OBSERVACIONES+' (Codigo: '+'" . $_POST['CD_SERVICIO'] . "'+', ID: '+'" . $Id . "'+', IDDireccionamiento: '+'" . $IdDireccionamiento . "'+')' WHERE NO_SOLICITUD = '" . $_POST['NO_SOLICITUD'] . "' ";
                                                    sql($conn, $sql2);
                                                }
                                                sqlsrv_free_stmt($stmt);


                                                break;
                                        }
                                        ?>
                                        <div class="form-row" >
                                            <div class="col-md-12 sm-12">
                                                <label>Resultado MIPRES:</label>
                                            </div>
                                        </div>
                                        <div class="form-row" >
                                            <div class="col-md-12 sm-12">
                                                <textarea id="resultado_mipres" class="form-control"  rows="7" readonly></textarea> 
                                            </div>
                                        </div>
                                        <?php
                                        $info = curl_getinfo($ch);
                                        $mensaje_mipres = "Tiempo de ejecución de la consulta: " . $info['total_time'] . " ms, a solicitud de la IP: " . $info['local_ip'] . " codigo de respuesta: " . $http_code . ", resultado de la transacción: " . $result;
                                        ?>
                                        <script type="text/javascript">
                                            document.getElementById("resultado_mipres").value = '<?php echo $mensaje_mipres ?>';
                                            document.getElementById('ProcesoDireccionamiento').innerHTML = "";
                                        </script>
                                        <?php
                                    }
                                    curl_close($ch);

                                    break;
                            }
                        }
                    } else {
                        ?>
                        <script type="text/javascript">
                            document.getElementById('ProcesoDireccionamiento').innerHTML = "";
                        </script>
                        <?php
                        echo "<div class='alert alert-warning alert-dismissible'>";
                        echo "<button type='button' class='close' data-dismiss='alert'>&times;</button>";
                        echo "<strong>Alerta!</strong> Existen campos vacíos, por favor intentelo nuevamente sin dejar campos vacíos</div>";
                    }
                    ?>



                    <!---  Fin Body --->
                </div>
            </div>



        </div>
    </div>
</div>

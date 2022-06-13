<?php
require_once('modelo/conexion-sql.php');
require_once("vista/AnularSuministro.php");


if (!empty($_SESSION['NIT_EPS'])) {
    $sql = "SELECT * FROM PRS_URL_SERVICES WHERE COD_URL = '16'";
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
            $url = $row['DES_URL'] . $_SESSION['NIT_EPS'] . '/' . $_POST['token'] . '/' . $_POST['IDSuministro'];

            $ch = curl_init($url);

            $data = array();

            $data["IdSuministro"] = $_POST['IDSuministro'];


//print_r($data);

            $payload = json_encode($data);
            curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json; charset=utf-8'));
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PUT');
            curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
            $result = curl_exec($ch);
            ?>


            <div class="modal fade" data-backdrop="static" id="Ven_Direccionamiento2">
                <div class="modal-dialog modal-dialog-centered modal-md" >
                    <div class="modal-content" >

                        <!-- Modal Header -->
                        <div class="modal-header">
                            <h5 class="modal-title" id="titulo_modal"></h5>
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                        </div>


                        <div class="container">


                            <?php
                            if (!curl_errno($ch)) {

                                switch ($http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE)) {
                                    case 200:  # OK

                                        $sql = " UPDATE MIPRES_SUMINISTRO SET EstSuministro = '0', FecAnulacion = GETDATE(), [COD_USUARIO] = '" . $_SESSION["usuario"] . "', [FEC_PROCESADO]= GETDATE() WHERE IDSuministro = '" . $_POST['IDSuministro'] . "';";

                                        sql($conn, $sql);
                                        ?>

                                        <br>

                                        <div class="row">
                                            <div class="col-md-12 sm-12">

                                                <center><strong>Se ha anulado el suministro correctamente</strong></center>

                                            </div>
                                        </div>
                                        <br>
                                        <?php
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


                            </div> 
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                            </div>

                        </div>
                    </div>
                </div>


                <?php
                $info = curl_getinfo($ch);
                $mensaje_mipres = "Tiempo de ejecución de la consulta: " . $info['total_time'] . " ms, a solicitud de la IP: " . $info['local_ip'] . " codigo de respuesta: " . $http_code . ", resultado de la transacción: " . $result;
                ?>
                <script type="text/javascript">
                    document.getElementById("resultado_mipres").value = '<?php echo $mensaje_mipres ?>';



                    $('document').ready(function () {

                        $('#Ven_Direccionamiento2').modal('show');

                    });

                </script>
                <?php
            }

            curl_close($ch);
        }
    }
}
?>



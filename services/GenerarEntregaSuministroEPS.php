

<?php
require_once('modelo/conexion-sql.php');
require_once("vista/Suministro.php");


if (!empty($_SESSION['NIT_EPS'])) {
    $sql = "SELECT * FROM PRS_URL_SERVICES WHERE COD_URL = '15'";
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
            $url = $row['DES_URL'] . $_SESSION['NIT_EPS'] . '/' . $_POST['TokenSuministro'];

            $ch = curl_init($url);

            $data = array();

            $data["ID"] = $_POST['Identificador'];
            $data["UltEntrega"] = $_POST['UltEntrega'];
            $data["EntregaCompleta"] = $_POST['EntregaCompleta'];
            $data["CausaNoEntrega"] = $_POST['CausaNoEntrega'];
            $data["NoPrescripcionAsociada"] = $_POST['NoPrescripcionAsociada'];
            $data["ConTecAsociada"] = $_POST['ConTecAsociada'];
            $data["CantTotEntregada"] = $_POST['CantTotEntregada'];
            $data["NoLote"] = $_POST['NoLote'];
            $data["ValorEntregado"] = $_POST['ValorEntregado'];

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


                                        $registro = $result;
                                        $registro = json_decode($registro, true);
                                        $Id = $registro[0]["Id"];
                                        $IdSuministro = $registro[0]["IdSuministro"];


                                        $sql = "IF NOT EXISTS (SELECT 'X' FROM [dbo].[MIPRES_SUMINISTRO] WHERE [ID] = '" . $Id . "' AND [IDSuministro] = '" . $IdSuministro . "') BEGIN ";
                                        $sql .= "INSERT INTO [dbo].[MIPRES_SUMINISTRO]([ID],[IDSuministro],[NoPrescripcion],[TipoTec],[ConTec],[TipoIDPaciente],[NoIDPaciente],[NoEntrega],[UltEntrega],[EntregaCompleta],[CausaNoEntrega],[NoPrescripcionAsociada],[ConTecAsociada],[CantTotEntregada],[NoLote],[ValorEntregado],[FecSuministro],[EstSuministro],[FecAnulacion],[FechaIngreso],[COD_USUARIO],[FEC_PROCESADO]) VALUES ";
                                        $sql .= "('" . $Id . "','" . $IdSuministro . "','" . $_POST['NoPrescripcion'] . "','" . $_POST['TipoTec'] . "','" . $_POST['ConTec'] . "','" . $_POST['TipoIDPaciente'] . "','" . $_POST['NoIDPaciente'] . "','" . $_POST['NoEntrega'] . "','" . $_POST['UltEntrega'] . "','" . $_POST['EntregaCompleta'] . "','" . $_POST['CausaNoEntrega'] . "','" . $_POST['NoPrescripcionAsociada'] . "','" . $_POST['ConTecAsociada'] . "','" . $_POST['CantTotEntregada'] . "','" . $_POST['NoLote'] . "','" . $_POST['ValorEntregado'] . "',GETDATE(),'1','01/01/1970',GETDATE(),'" . $_SESSION["usuario"] . "', GETDATE())  END ELSE BEGIN ";
                                        $sql .= "UPDATE [dbo].[MIPRES_SUMINISTRO] SET [NoPrescripcion] = '" . $_POST['NoPrescripcion'] . "',[TipoTec]= '" . $_POST['TipoTec'] . "',[ConTec]= '" . $_POST['ConTec'] . "',[TipoIDPaciente]= '" . $_POST['TipoIDPaciente'] . "',[NoIDPaciente]= '" . $_POST['NoIDPaciente'] . "',[NoEntrega]= '" . $_POST['NoEntrega'] . "',[UltEntrega]= '" . $_POST['UltEntrega'] . "',[EntregaCompleta]= '" . $_POST['EntregaCompleta'] . "',[CausaNoEntrega]= '" . $_POST['CausaNoEntrega'] . "',[NoPrescripcionAsociada]= '" . $_POST['NoPrescripcionAsociada'] . "',	[ConTecAsociada]= '" . $_POST['ConTecAsociada'] . "',[CantTotEntregada]= '" . $_POST['CantTotEntregada'] . "',[NoLote]= '" . $_POST['NoLote'] . "',[ValorEntregado]= '" . $_POST['ValorEntregado'] . "',
                                                [FecSuministro]= GETDATE(),[EstSuministro]= '1',[FecAnulacion]= '01/01/1970',[FechaIngreso]= GETDATE(),[COD_USUARIO] = '" . $_SESSION["usuario"] . "',[FEC_PROCESADO]= GETDATE()
                                                WHERE [ID] = '" . $Id . "' AND [IDSuministro] = '" . $IdSuministro . "' END ";

                                        sql($conn, $sql);
                                        ?>

                                        <br>

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
                                                        <label>Id Suministro</label>
                                                    </div>
                                                    <div class="col-md-8 sm-12">
                                                        <input type="number" class="form-control" id="IdDireccionamiento" name="IdDireccionamiento" required readonly value="<?php echo $IdSuministro ?>"> 
                                                    </div>
                                                </div>                   
                                            </div>
                                        </div>
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



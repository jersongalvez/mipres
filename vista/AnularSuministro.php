<div class="col-md-12 sm-12">
    <div class="card shadow">
        <div class="card-header">
            <H4>Número de Suministro</H4>
        </div>
        <div class="card-body">

            <form action="index.php?x=046&y=001" method="post">
                <div class="form-row">
                    <div class="col-md-3 sm-12">
                        <input type="number" class="form-control" id="radicado" name="radicado" required placeholder="Número de Suministro" autofocus value="">
                    </div>
                    <div class="col-md-2 sm-12">
                        <button 
                            class="btn btn-outline-dark btn-block" type="submit" >Buscar</button> 
                        <br>
                    </div>
                </div>    
            </form>

        </div>
    </div>
</div>


<br>

<?php
if (isset($_GET["y"])) {
    switch ($_GET["y"]) {
        case '001':
            $radicado = trim($_POST["radicado"]);
            ?>

            <script type="text/javascript">
                document.getElementById("radicado").value = '<?php echo $radicado; ?>';
            </script>

            <?php
            break;
    }
}
?>
<?php
if (!empty($radicado)) {
    ?>
    <div class="col-md-12 sm-12">
        <div class="card shadow">
            <div class="card-body">
                <?php
                $sql = "SELECT ID, IDSuministro, MS.NoPrescripcion, TipoTec, ConTec, MS.TipoIDPaciente, 
                NoIDPaciente, NoEntrega, CantTotEntregada, ValorEntregado, FecSuministro, 
                EstSuministro, (SELECT DES_TEM_TOKEN FROM PRS_TEM_TOKEN WHERE TIP_TEM_TOKEN =  IIF(CODEPS= 'EPSI06','S','C')) TOKEN 
                FROM MIPRES_SUMINISTRO MS INNER JOIN [MIPRES_PRESCRIPCION ] MP
                ON MS.NoPrescripcion = MP.NoPrescripcion WHERE ( IDSuministro = '" . $radicado . "' or MS.ID = '" . $radicado . "' ) ";
                $stmt2 = sqlsrv_query($conn, $sql, array());

                if ($stmt2 !== NULL) {
                    $rows2 = sqlsrv_has_rows($stmt2);

                    if ($rows2 === true) {
                        ?>           
                        <table class="table tabLe-sm tabLe-responsive">
                            <thead class="thead-light">
                                <tr>
                                    <th>ID</th>
                                    <th>NO. SUMINISTRO</th>
                                    <th>NO. PRESCRIPCIÓN</th>
                                    <th>TIPO TEC.</th>
                                    <th>CON. TEC.</th>
                                    <th>PACIENTE</th>
                                    <th>NO. ENTREGA</th>
                                    <th>CANTIDAD ENTREGADA</th>
                                    <th>VALOR SUMINISTRO</th>
                                    <th>FEC. SUMINISTRO</th>
                                    <th>ESTADO SUMINISTRO</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                while ($row2 = sqlsrv_fetch_array($stmt2, SQLSRV_FETCH_ASSOC)) {
                                    ?>							<tr>
                                        <td><?php echo $row2['ID']; ?></td>
                                        <td><?php echo $row2['IDSuministro']; ?></td>
                                        <td><?php echo $row2['NoPrescripcion']; ?></td>
                                        <td><?php echo $row2['TipoTec']; ?></td>
                                        <td><?php echo $row2['ConTec']; ?></td>
                                        <td><?php echo $row2['TipoIDPaciente'] . ' ' . $row2['NoIDPaciente']; ?></td>
                                        <td><?php echo $row2['NoEntrega']; ?></td>
                                        <td><?php echo $row2['CantTotEntregada']; ?></td>
                                        <td><?php echo '$ ' . number_format($row2['ValorEntregado']); ?></td>
                                        <td><?php echo $row2['FecSuministro']->format('d/m/Y'); ?></td>
                                        <td><?php
                                            if ($row2['EstSuministro'] == '0') {
                                                echo "Anulado";
                                            } elseif ($row2['EstSuministro'] == '1') {
                                                ?>
                                                <button class="btn btn-outline-secondary" type="button" id="BtnRelacionar" onclick="javascript:ConfirmarAnularSuministro('<?php echo $row2['IDSuministro']; ?>', '<?php echo $row2['TOKEN']; ?>');">Anular</button>

                                                <?php
                                            } elseif ($row2['EstSuministro'] == '2') {
                                                echo "Procesado";
                                            }
                                            ?></td>
                                    </tr>

                                    <?php
                                }
                                ?>

                            </tbody>
                        </table>
                        <?php
                    } else {
                        echo "<BR>\nNo se encuentran suministros relacionadas con el número  " . $radicado . " \n<br><br>";
                    }
                }
                ?>    
            </div>
        </div>
    </div>   
    <?php
}
?>




<div class="modal fade" data-backdrop="static" id="Ven_Direccionamiento3">
    <div class="modal-dialog modal-dialog-centered modal-md" >
        <div class="modal-content" >

            <!-- Modal Header -->
            <div class="modal-header">
                <h5 class="modal-title" id="titulo_modal"></h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>


            <div class="container">
                <br>
                <center><strong><div id="pregunta">¿Desea anular el suministro número 	?</div></strong></center>


                <form class="" action="index.php?x=047" method="post" >

                    <input type="hidden" class="form-control" id="IDSuministro" name="IDSuministro" required readonly>
                    <input type="hidden" class="form-control" id="token" name="token" required readonly>
                    <br>

                    <div class="form-row">
                        <div class="col-md-3 sm-3"></div>
                        <div class="col-md-6 sm-6">
                            <button  class="btn btn-outline-dark btn-block" type="submit" >Anular suministro</button> 
                        </div>
                        <div class="col-md-3 sm-3"></div>
                    </div>

                </form>






            </div> 
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
            </div>

        </div>
    </div>
</div>


<script type="text/javascript">
    function ConfirmarAnularSuministro(IDSuministro, Token) {
        document.getElementById('pregunta').innerHTML = "¿Desea anular el suministro número " + IDSuministro + "?";
        document.getElementById("IDSuministro").value = IDSuministro;
        document.getElementById("token").value = Token;
        $('#Ven_Direccionamiento3').modal('show');


    }




</script>
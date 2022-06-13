<br>
<?php
require_once('../../modelo/conexion-sql.php');

$NoPrescripcion = $_POST['NoPrescripcion'];

if (!empty($NoPrescripcion)) {

    $sql = "
SELECT MP.NoPrescripcion,
MP.ID,  IDReporteEntrega,   MP.NoPrescripcion,  MP.TipoTec, MP.ConTec, MP.TipoIDPaciente,   MP.NoIDPaciente,    
MP.NoEntrega,   EstadoEntrega,  MP.CausaNoEntrega,  MP.ValorEntregado,  CodTecEntregado,    MP.CantTotEntregada,    
MP.NoLote,  FecEntrega, FecRepEntrega,  EstRepEntrega,  MS.ID ID_Suministro,    IDSuministro No_Suministro
FROM MIPRES_ENTREGA_PROVEEDOR MP LEFT JOIN MIPRES_SUMINISTRO MS
ON  MP.ID = MS.ID and MS.EstSuministro <> '0'
WHERE MP.NoPrescripcion = '" . $NoPrescripcion . "'
AND MP.EstRepEntrega <> '0'  
order by MP.NoEntrega desc";

    $stmt2 = sqlsrv_query($conn, $sql, array());

    if ($stmt2 !== NULL) {
        $rows2 = sqlsrv_has_rows($stmt2);

        if ($rows2 === true) {
            ?>


            <table class="table table-sm table-responsive">
                <thead class="thead-light">
                    <tr>
                        <th>ID</th>
                        <th>NO. REPORTE ENTREGA</th>
                        <th>TIPO TEC.</th>
                        <th>CON. TEC.</th>
                        <th>NO. ENTREGA</th>
                        <th>ESTADO ENTREGA</th>
                        <th>VALOR ENTREGA</th>
                        <th>TEC. ENTREGADA</th>
                        <th>CANTIDAD ENTREGADA</th>
                        <th>FEC. ENTREGA</th>
                        <th>FEC. REPORTE ENTREGA</th>
                        <th>NO. SUMINISTRO</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    while ($row2 = sqlsrv_fetch_array($stmt2, SQLSRV_FETCH_ASSOC)) {
                        ?>
                        <tr>
                            <td><?php echo $row2['ID']; ?></td>
                            <td><?php echo $row2['IDReporteEntrega']; ?></td>
                            <td><?php echo $row2['TipoTec']; ?></td>
                            <td><?php echo $row2['ConTec']; ?></td>
                            <td><?php echo $row2['NoEntrega']; ?></td>
                            <td><?php
                                if ($row2['EstadoEntrega'] == '0') {
                                    echo "No se entrega";
                                } elseif ($row2['EstadoEntrega'] == '1') {
                                    echo "Se entregó";
                                }
                                ?></td>
                            <td><?php echo ($row2['ValorEntregado'] == '') ? '' : '$ ' . number_format($row2['ValorEntregado'])?></td>
                            <td><?php echo $row2['CodTecEntregado']; ?></td>
                            <td><?php echo $row2['CantTotEntregada']; ?></td>
                            <td><?php echo $row2['FecEntrega']->format('d/m/Y'); ?></td>
                            <td><?php echo $row2['FecRepEntrega']->format('d/m/Y'); ?></td>
                            <td>
                                <?php
                                if (($row2['No_Suministro'] <> "") or ($row2['No_Suministro'] <> NULL)) {
                                    echo $row2['No_Suministro'];
                                } else {
                                    ?>
                                    <button class="btn btn-outline-secondary" type="button" id="BtnRelacionar" onclick="javascript:RelacionarEntrega('<?php echo $row2['ID']; ?>', '<?php echo $row2['ValorEntregado']; ?>',  '<?php echo $row2['NoPrescripcion']; ?>', '<?php echo $row2['ConTec']; ?>', '<?php echo $row2['CantTotEntregada']; ?>', '<?php echo $row2['CausaNoEntrega']; ?>', '<?php echo $row2['TipoTec']; ?>', '<?php echo $row2['TipoIDPaciente']; ?>', '<?php echo $row2['NoIDPaciente']; ?>', '<?php echo $row2['NoEntrega']; ?>');">Relacionar</button>

                                    <?php
                                }
                                ?>
                            </td> 
                        </tr>
                        <?php
                    }
                    ?>

                </tbody>
            </table>

            <?php
        } else {
            echo "<BR>\nNo se encuentran reportes de entrega del proveedor, por favor actualizar  \n<br><br>";
        }
    }
}
?>
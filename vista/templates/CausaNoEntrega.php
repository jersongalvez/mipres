<?php
require_once('../../modelo/conexion-sql.php');
if (!empty($_POST['TipoTec']) ) {
  $CausaNoEntrega=$_POST['CausaNoEntrega'];
  $TipoTec=$_POST['TipoTec'];
  switch ($TipoTec) {
    case 'M':
         $sql = "SELECT * FROM MIPRES_CAUSAS_NO_ENTREGA WHERE TIPO = 'NODIRECCIONAMIENTO' AND MEDICAMENTOS = '0' ORDER BY DESCRIPCION ASC ";
        break;
    case 'P':
        $sql = "SELECT  * FROM MIPRES_CAUSAS_NO_ENTREGA WHERE TIPO = 'NODIRECCIONAMIENTO' AND PROCEDIMIENTOS = '0' ORDER BY DESCRIPCION ASC";
        break;
    case 'D':
        $sql = "SELECT  * FROM MIPRES_CAUSAS_NO_ENTREGA WHERE TIPO = 'NODIRECCIONAMIENTO' AND DISPOSITIVOS = '0' ORDER BY DESCRIPCION ASC";
        break;
    case 'N':
        $sql = "SELECT * FROM MIPRES_CAUSAS_NO_ENTREGA WHERE TIPO = 'NODIRECCIONAMIENTO' AND NUTRICIONALES = '0' ORDER BY DESCRIPCION ASC";
        break;
    case 'S':
        $sql = "SELECT  * FROM MIPRES_CAUSAS_NO_ENTREGA WHERE TIPO = 'NODIRECCIONAMIENTO' AND COMPLEMENTARIOS = '0' ORDER BY DESCRIPCION ASC";
        break;
}
    $params = array();
    $options =  array( "Scrollable" => SQLSRV_CURSOR_KEYSET );
    $stmt = sqlsrv_query( $conn, $sql, $params, $options);
    $row_count = sqlsrv_num_rows( $stmt );
    $row_dos = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC);
}
?>

<select class="form-control" id="CausaNoEntrega" name="CausaNoEntrega" >
  <option></option>
  <?php
    while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) )
    {
  ?>
    <option value= '<?php echo $row['COD_CAUSA']; ?>'   <?php echo $row['COD_CAUSA'] == $CausaNoEntrega ? 'selected' : ''; ?>  >  <?php echo utf8_encode ($row['DESCRIPCION']); ?>  </option>
  <?php
    }
  ?>
</select>



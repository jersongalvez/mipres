<?php
$serverName = "192.168.20.250"; //serverName\instanceName
$connectionInfo = array("Database" => "gemaeps", "UID" => "WEB", "PWD" => "Web_4826*");
$conn = sqlsrv_connect($serverName, $connectionInfo);
if ($conn) {
?>
  <!-- 
    https://wsmipres.sispro.gov.co/WSSUMMIPRESNOPBS/Swagger/ui/index (VERSION 2),
    https://wsmipres.sispro.gov.co/WSMIPRESNOPBS/Swagger/ui/index (VERSION 1)
  -->
<?php
} else {
?>
  <div class="alert alert-danger alert-dismissible">
    <button type="button" class="close" data-dismiss="alert">&times;</button>
      <strong>Error!</strong> No estas conectado al servidor.<br>
        <div class="modal-footer">
          <?php die(print_r(sqlsrv_errors(), true)); ?>
        </div>
    </div>
 <?php
}
?>
<?php
function NombreMunicipio($conn, $Codigo) {
  $sql = "SELECT TOP 1 NOM_CIUDAD FROM CIUDADES WHERE COD_DEPARTAMENTO+COD_CIUDAD = '" . $Codigo . "' ";
  $params = array();
  $options = array("Scrollable" => SQLSRV_CURSOR_KEYSET);
  $stmt = sqlsrv_query($conn, $sql, $params, $options);
  $row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC);
  return $resultado = $row['NOM_CIUDAD'];
  sqlsrv_free_stmt($stmt);
}
//echo NombreMunicipio($conn,'73001');
function NombreDepartamento($conn, $Codigo) {
  $Codigo = substr($Codigo, 0, 2);
  $sql = "SELECT TOP 1 NOM_DEPARTAMENTO FROM DEPARTAMENTOS WHERE COD_DEPARTAMENTO = '" . $Codigo . "' ";
  $params = array();
  $options = array("Scrollable" => SQLSRV_CURSOR_KEYSET);
  $stmt = sqlsrv_query($conn, $sql, $params, $options);
  $row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC);
  return $resultado = $row['NOM_DEPARTAMENTO'];
  sqlsrv_free_stmt($stmt);
}
//echo NombreDepartamento($conn,'73001');
function NombrePrestador($conn, $Codigo) {
  $Codigo = str_pad($Codigo, 15, "0", STR_PAD_LEFT);
  $sql = "SELECT TOP 1 NOM_PRESTADOR FROM PRESTADORES WHERE NIT_PRESTADOR = '" . $Codigo . "' ";
  $params = array();
  $options = array("Scrollable" => SQLSRV_CURSOR_KEYSET);
  $stmt = sqlsrv_query($conn, $sql, $params, $options);
  $row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC);
  if (!empty($row['NOM_PRESTADOR'])) {
    return $resultado = $row['NOM_PRESTADOR'];
  } else {
    return "Prestador no registrado.";
  }
  sqlsrv_free_stmt($stmt);
}
// echo NombrePrestador($conn,'816000810');
function ValorRefMipres($conn, $ITEM, $VARIABLE, $VALOR) {
  $sql = "SELECT TOP 1 MVP_DESCRIPCION FROM MIPRES_VALORES_PERMITIDOS WHERE  MVP_ITEM = '" . $ITEM . "' AND MVP_VARIABLE = '" . $VARIABLE . "' AND MVP_VALOR = '" . $VALOR . "' ";
  $params = array();
  $options = array("Scrollable" => SQLSRV_CURSOR_KEYSET);
  $stmt = sqlsrv_query($conn, $sql, $params, $options);
  $row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC);
  if (!empty($row['MVP_DESCRIPCION'])) {
    return $resultado = $row['MVP_DESCRIPCION'];
  } else {
        return $VALOR;
  }
  sqlsrv_free_stmt($stmt);
}
// ValorRefMipres($conn,'PRESCRIPCION','CODAMBATE','12');
function SiNoRefMipres($Codigo) {
  if (!empty($Codigo)) {
    if ($Codigo == '0') {
      return 'NO';
    } else {
      return "SI";
    }
  }
}
// echo SiNoRefMipres(0);
function NombreDiagnostico($conn, $Codigo) {
  $sql = "SELECT TOP 1 NOM_DIAGNSOTICO FROM DIAGNOSTICOS WHERE EST_DIAGNOSTICO = '0' AND COD_DIAGNOSTICO = '" . $Codigo . "' ";
  $params = array();
  $options = array("Scrollable" => SQLSRV_CURSOR_KEYSET);
  $stmt = sqlsrv_query($conn, $sql, $params, $options);
  $row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC);
  return $resultado = $row['NOM_DIAGNSOTICO'];
  sqlsrv_free_stmt($stmt);
}
//echo NombreDiagnostico($conn,'H401');
function FormatoFechaMipres($Codigo) {
  return $resultado = str_replace("T00:00:00", "", $Codigo);
}

// echo FormatoFechaMipres("2019-10-01T00:00:00");
function NombreProcedimiento($conn, $Codigo) {
  $sql = "SELECT TOP 1 DESCRIPCION FROM PROCEDIMIENTOS WHERE EST_PROCEDIMIENTO = '0' AND CODIGO = '" . $Codigo . "' ";
  $params = array();
  $options = array("Scrollable" => SQLSRV_CURSOR_KEYSET);
  $stmt = sqlsrv_query($conn, $sql, $params, $options);
  $row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC);
  return $resultado = $row['DESCRIPCION'];
  sqlsrv_free_stmt($stmt);
}

// echo NombreProcedimiento($conn,'906841');
function QuitarCerosIzquierda($Codigo) {
  return $resultado = (int) $Codigo;
}
// echo QuitarCerosIzquierda("0000055254");
function TipoTec($Codigo) {
  switch ($Codigo) {
    case 'M':
      $resultado = "Medicamento";
      break;
    case 'P':
      $resultado = "Procedimientos";
      break;
    case 'D':
      $resultado = "Dispositivo Medico";
      break;
    case 'N':
       $resultado = "Producto Nutricional";
       break;
    case 'S':
       $resultado = "Servicio Complementario";
       break;
 }
    return $resultado;
}

function Valor($Codigo) {
  $resultado = ($Codigo <> '') ? $Codigo : 'NULL';
  return $resultado;
}

function CompletarCeros($valor, $long = 0) {
  return str_pad($valor, $long, '0', STR_PAD_LEFT);
}

function IDORDENITEM($conn, $ti, $ni) {
  $sql = "SELECT TOP 1 IDORDENITEM FROM AFILIADOSSUB WHERE TIP_DOCUMENTO_BEN = '" . $ti . "' AND NUM_DOCUMENTO_BEN = '" . $ni . "' AND EST_AFILIADO = '1' ";
  $params = array();
  $options = array("Scrollable" => SQLSRV_CURSOR_KEYSET);
  $stmt = sqlsrv_query($conn, $sql, $params, $options);
  $row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC);
  return $resultado = $row['IDORDENITEM'];
  sqlsrv_free_stmt($stmt);
}

function token_temporal($conn, $reg) {
  $sql = "SELECT DES_TEM_TOKEN FROM PRS_TEM_TOKEN WHERE TIP_TEM_TOKEN = '" . $reg . "' ";
  $params = array();
  $options = array("Scrollable" => SQLSRV_CURSOR_KEYSET);
  $stmt = sqlsrv_query($conn, $sql, $params, $options);
  $row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC);
  return $resultado = $row['DES_TEM_TOKEN'];
  sqlsrv_free_stmt($stmt);
}

function sql($conn, $sql) {
  $params = array();
  $options = array("Scrollable" => SQLSRV_CURSOR_KEYSET);
  $stmt = sqlsrv_query($conn, $sql, $params, $options);
  $sql_result = 'Ok';
  if ($stmt === false) {
    if (($errors = sqlsrv_errors() ) != null) {
      foreach ($errors as $error) {
        $sql_error = "INSERT INTO [dbo].[MIPRES_ERRORES]([CODIGO],[MENSAJE],[SENTENCIA])VALUES(?,?,?)";
        $params = array($error['code'], $error['message'], $sql);
        $options = array("Scrollable" => SQLSRV_CURSOR_KEYSET);
        $stmt = sqlsrv_query($conn, $sql_error, $params, $options);
      }
        $sql_result = 'Error';
    }
  }
    return $sql_result;
}

function RelacionarServicioMipres($conn, $noprescripcion, $no_solicitud, $tabla, $servicio) {
  $servicio = cd_medicamento1($tabla, $servicio);
  $sql = "
DECLARE @cantidad integer
DECLARE @noprescripcion varchar(50)
DECLARE @tipotec varchar(50)
DECLARE @conorden varchar(50)
DECLARE @cod_mipres varchar(50)
DECLARE @no_solicitud varchar(50)
DECLARE @tabla varchar(50)
DECLARE @servicio varchar(50)
set @noprescripcion  = '" . $noprescripcion . "'
set @no_solicitud = '" . $no_solicitud . "'
set @tabla = '" . $tabla . "'
set @servicio = '" . $servicio . "'
set @cantidad = (select
(select count(noprescripcion) from MIPRES_PROCEDIMIENTOS where noprescripcion = @noprescripcion)+
(select count(noprescripcion) from [MIPRES_MEDICAMENTOS ] where noprescripcion = @noprescripcion)+
(select count(noprescripcion) from MIPRES_complementarios where noprescripcion = @noprescripcion)+
(select count(noprescripcion) from MIPRES_NUTRICIONALES where noprescripcion = @noprescripcion)+ 
(select count(noprescripcion) from MIPRES_dispositivos where noprescripcion = @noprescripcion) 
from mipres_prescripcion  prs where prs.noprescripcion = @noprescripcion)
IF
@cantidad = 1
begin
  if exists (select * from MIPRES_PROCEDIMIENTOS where noprescripcion = @noprescripcion)
  begin
    SELECT
    @tipotec = 'P',
    @conorden = CONORDEN,
    @cod_mipres = @servicio
    FROM MIPRES_PROCEDIMIENTOS
    WHERE NOPRESCRIPCION = @noprescripcion
  end
  else
  if exists (select * from MIPRES_medicamentos where noprescripcion = @noprescripcion)
  begin
    SELECT
    @tipotec = 'M',
    @conorden = CONORDEN,
    @cod_mipres = @servicio
    FROM MIPRES_medicamentos
    WHERE NOPRESCRIPCION = @noprescripcion
  end
  else
  if exists (select * from MIPRES_complementarios where noprescripcion = @noprescripcion)
  begin
    SELECT
    @tipotec = 'S',
    @conorden = CONORDEN,
    @cod_mipres = CONVERT(VARCHAR, CODSERCOMP)
    FROM MIPRES_COMPLEMENTARIOS
    WHERE NOPRESCRIPCION = @noprescripcion
  end
  else
  if exists (select * from MIPRES_NUTRICIONALES where noprescripcion = @noprescripcion)
  begin
    SELECT
    @tipotec = 'N',
    @conorden = CONORDEN,
    @cod_mipres = CONVERT(VARCHAR, DESCPRODNUTR)
    FROM MIPRES_NUTRICIONALES
    WHERE NOPRESCRIPCION = @noprescripcion
  end
  else
  if exists (select * from MIPRES_dispositivos where noprescripcion = @noprescripcion)
  begin
    SELECT
    @tipotec = 'D',
    @conorden = CONORDEN,
    @cod_mipres = CODDISP
    FROM MIPRES_DISPOSITIVOS
    WHERE NOPRESCRIPCION = @noprescripcion
  end


  UPDATE SERVICIOS_AUTORIZADOS SET TIPOTEC =  @tipotec, CONTEC = @conorden, CODSERTEC = @cod_mipres
  WHERE NO_SOLICITUD = @no_solicitud AND TABLA =  @tabla;


end";

    sql($conn, $sql);
}

function NombreAfiliado($conn, $ti, $ni) {
  $sqln = "SELECT TOP 1 PRI_APELLIDO+' '+SEG_APELLIDO+' '+PRI_NOMBRE+' '+NOM_NOMBRE AS NOMBRE FROM AFILIADOSSUB WHERE TIP_DOCUMENTO_BEN = '" . $ti . "' AND NUM_DOCUMENTO_BEN = '" . $ni . "' AND EST_AFILIADO = '1' ";
  $paramsn = array();
  $optionsn = array("Scrollable" => SQLSRV_CURSOR_KEYSET);
  $stmtn = sqlsrv_query($conn, $sqln, $paramsn, $optionsn);
  $rown = sqlsrv_fetch_array($stmtn, SQLSRV_FETCH_ASSOC);
  return $resultadon = $rown['NOMBRE'];
  sqlsrv_free_stmt($stmtn);
}

function FecMaxEnt($conn, $NoSolicitud) {
  $sqln = " Select s.TABLA,s.CD_SERVICIO,s.CANTIDAD,VALOR,s.NIVEL,VALOR_TOTAL,DESCRIPCION,CP_CM,CP_CM_RS,PRO_QUIRURGICO,p.POSS
  from SERVICIOS_AUTORIZADOS s, procedimientos p
where NO_SOLICITUD = '" . $NoSolicitud . "'
and s.TABLA = 'CUP'
and s.TABLA = p.TABLA
and s.CD_SERVICIO = p.CODIGO";
  $paramsn = array();
  $optionsn = array(
    "Scrollable" => SQLSRV_CURSOR_KEYSET
  );
  $stmtn = sqlsrv_query($conn, $sqln, $paramsn, $optionsn);
  $rown = sqlsrv_fetch_array($stmtn, SQLSRV_FETCH_ASSOC);
  $row_countn = sqlsrv_num_rows($stmtn);
  if ($row_countn > 0) {
    if ($rown['TABLA'] = 'CUP') {
      if ($rown['POSS'] = 'N') {
        $dias = 90;
      } else {
        $dias = 180;
      }
    }
  } else {
    $dias = 30;
  }
    return $resultadon = $dias;
    sqlsrv_free_stmt($stmtn);
}
########################
/**
 * Metodo que elimina los ceros ('0') en el codigo de medicamentos
 * @param String $tipo_tec
 * @param String $cd_servicio
 * @return string
 */
function cd_medicamento1($tipo_tec, $cd_servicio) {
  $salida = $cd_servicio;
  if ($tipo_tec === 'MED') {
    $var = explode("-", $cd_servicio);
    if (count($var) === 2) {
      $codigo = (String) ((int) $var[0]);
      $expediente = (String) ((int) $var[1]);
            $salida = $codigo . '-' . $expediente;
        }
    }
   return $salida;
}
#######################
?>
<script type="text/javascript">
  function progreso(titulo) {
    document.getElementById('progreso_titulo').innerHTML = titulo + ".";
    document.getElementById('progreso_data').innerHTML = "<center><div class='spinner-border text-success' style='width: 4rem; height: 4rem;'></div></center>";
    $('#progreso').modal('show');
      setTimeout(function () {
      contador2(titulo);
    }, 1500);
  }

  function contador1(titulo) {
    document.getElementById('progreso_data').innerHTML = "<center><div class='spinner-border text-success' style='width: 4rem; height: 4rem;'></div></center>";
    document.getElementById('progreso_titulo').innerHTML = titulo + ".";
    document.getElementById('progreso_pie').innerHTML = "Por favor espere...";
      setTimeout(function () {
        contador2(titulo);
      }, 1500);
    }

    function contador2(titulo) {
      document.getElementById('progreso_data').innerHTML = "<center><div class='spinner-border text-secondary' style='width: 4rem; height: 4rem;'></div></center>";
      document.getElementById('progreso_titulo').innerHTML = titulo + "..";
      setTimeout(function () {
        contador3(titulo);
      }, 1500);
    }

    function contador3(titulo) {
      document.getElementById('progreso_data').innerHTML = "<center><div class='spinner-border text-primary' style='width: 4rem; height: 4rem;'></div></center>";
      document.getElementById('progreso_titulo').innerHTML = titulo + "...";
      document.getElementById('progreso_pie').innerHTML = "Esto puede tardar unos minutos";
        setTimeout(function () {
          contador1(titulo);
        }, 1500);
    }
</script>
<!--
<div class="container-fluid" style="margin-top:80px">
 <div class="modal fade" data-backdrop="static" id="progreso">
   <div class="modal-dialog modal-dialog-centered modal-sm">
     <div class="modal-content">
       <div class="modal-header">
         <h5 class="modal-title"><div id="progreso_titulo">Consultando.</div></h5>
       </div>
       <div class="modal-body">
   <div id="progreso_data"></div>
       </div>
       <div class="modal-footer">
       <small><div id="progreso_pie">Por favor espere...</div></small>
       </div>
     </div>
   </div>
 </div>
 </div>
-->
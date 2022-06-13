<?php

////////////////////////////////////////////////////////////////////////////////
/////////////////////////         SISTEMA RIPS         /////////////////////////
/////////////////////////      PIJAOS SALUD EPSI      //////////////////////////
///////////////////    CONTROLADOR CONSULTA_AUTORIZACION      //////////////////
/////////////////////////  DEPARTAMENTO DE DESARROLLO  /////////////////////////
//////////////      AMBITO: FILTRADO DE DATOS DE AUTORIZACIONES  ///////////////
////////////////////////////////////////////////////////////////////////////////
//Validamos si existe o no la sesión, para guardar el usuario logueado
if (strlen(session_id()) < 1) {
    session_start();
}

require_once '../modelo/Facturacion.php';


$facturacion = new Facturacion();

//Busqueda de prescripciones
$valor = isset($_POST["valor"]) ? limpiarCadena($_POST["valor"]) : "";
$IDFacturacion = isset($_POST["IDFacturacion"]) ? limpiarCadena($_POST["IDFacturacion"]) : "";

//Insercion de datos WS
$token = isset($_POST["n_token"]) ? limpiarCadena($_POST["n_token"]) : "";

$ID            = isset($_POST["ID"]) ? limpiarCadena($_POST["ID"]) : "";
$CompAdm       = isset($_POST["CompAdm"]) ? limpiarCadena($_POST["CompAdm"]) : "";
$CodCompAdm    = isset($_POST["CodCompAdm"]) ? limpiarCadena($_POST["CodCompAdm"]) : "";
$CodHom        = isset($_POST["CodHom"]) ? limpiarCadena($_POST["CodHom"]) : "";
$UniCompAdm    = isset($_POST["UniCompAdm"]) ? limpiarCadena($_POST["UniCompAdm"]) : "";
$UniDispHom    = isset($_POST["UniDispHom"]) ? limpiarCadena($_POST["UniDispHom"]) : "";
$ValUnMiCon    = isset($_POST["ValUnMiCon"]) ? limpiarCadena($_POST["ValUnMiCon"]) : "";
$CantTotEnt    = isset($_POST["CantTotEnt"]) ? limpiarCadena($_POST["CantTotEnt"]) : "";
$ValTotCompAdm = isset($_POST["ValTotCompAdm"]) ? limpiarCadena($_POST["ValTotCompAdm"]) : "";
$ValTotHom     = isset($_POST["ValTotHom"]) ? limpiarCadena($_POST["ValTotHom"]) : "";

$IDDatosFacturado = isset($_POST["IDDatosFacturado"]) ? limpiarCadena($_POST["IDDatosFacturado"]) : "";

//envio de operaciones por medio de peticiones ajax
switch ($_GET["op"]) {

    //Busqueda de un radicado
    case 'consulta_factura':

        $results = $facturacion->get_facturacion($valor, $IDFacturacion);
        $fetch = sqlsrv_fetch_object($results);

        echo json_encode($fetch);
        break;


    //Buscar prestadores de servicios
    case 'buscar_prescripcion':

        $prescripcion = limpiarCadena($_REQUEST["prescripcion"]);

        $consulta = $facturacion->get_prescripcion($prescripcion);

        $data = Array();

        while ($respuesta = sqlsrv_fetch_object($consulta)) {

            $data[] = array(
                "0" => ($respuesta->EstFacturacion == '1') ? "<button type='button' class='btn btn-secondary btn-sm' onclick=buscar_direccionamiento('$respuesta->ID','$respuesta->IDFacturacion','$respuesta->CodEPS')> Buscar </button>" :
                "<button type='button' class='btn btn-light btn-sm' disabled> Buscar </button>",
                "1" => $respuesta->ID,
                "2" => $respuesta->NoFactura,
                "3" => $respuesta->CantUnMinDis,
                "4" => $respuesta->ValorTotFacturado,
                "5" => ($respuesta->EstFacturacion == '0') ? "Anulado" : (($respuesta->EstFacturacion == '1') ? "Activo" : "Procesado")
            );
        }


        $results = array(
            "sEcho" => 1, //Informacion para el datatables
            "iTotalRecords" => count($data), //Enviamos el total de registros al datatable
            "iTotalDisplayRecords" => count($data), //Enviamos el total de registros a visualizar
            "aaData" => $data
        );

        echo json_encode($results);
        break;



    //Carga una factura al Web Service
    case 'put_datosFacturados':

        //Obtener el token temporal en funcion del regimen
        $token_temporal = sqlsrv_fetch_object($facturacion->get_token($token, '17'));

        $url = $token_temporal->DES_URL . $_SESSION['NIT_EPS'] . '/' . $token_temporal->DES_TEM_TOKEN;

        $data = array(
            "ID" => $ID,
            "CompAdm" => intval($CompAdm),
            "CodCompAdm" => $CodCompAdm,
            "CodHom" => $CodHom,
            "UniCompAdm" => $UniCompAdm,
            "UniDispHom" => $UniDispHom,
            "ValUnMiCon" => $ValUnMiCon,
            "CantTotEnt" => $CantTotEnt,
            "ValTotCompAdm" => $ValTotCompAdm,
            "ValTotHom" => $ValTotHom,
        );


        $ch = curl_init($url);
        $payload = json_encode($data);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json; charset=utf-8'));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PUT');
        curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);

        $result = curl_exec($ch);

        $getinfo = curl_getinfo($ch);

        $informe = array(
            "mensaje" => $result,
            "http_code" => $getinfo['http_code'],
            "total_time" => $getinfo['total_time'],
            "local_ip" => $getinfo['local_ip'],
        );

        echo json_encode($informe);

        break;


    //Guarda el log de la url
    case 'actualizar_datosFacturados':
    
        $Id_fac1           = limpiarCadena($_REQUEST["Id_fac1"]);
        $IDDatosFacturado1 = limpiarCadena($_REQUEST["IDDatosFacturado1"]);
        $NoPrescripcion    = limpiarCadena($_REQUEST["NoPrescripcion"]);
        $ID2               = limpiarCadena($_REQUEST["IdWS"]);
        $IDDatosFacturado2 = limpiarCadena($_REQUEST["IDDatosFacturadoWS"]);

        $rspta1 = $facturacion->actualizar_factura($Id_fac1, $IDDatosFacturado1);

        if ($rspta1) {

            $rspta2 = $facturacion->insertar_idWS($ID2, $IDDatosFacturado2, $NoPrescripcion, $_SESSION["usuario"]);
        }

        echo $rspta2 ? true : false;

        break;


    ############################## ANULACION DE FACTURAS #############################
    //Buscar factura para anular
    case 'buscar_datoFacturado':

        $prescripcion_facturada = limpiarCadena($_REQUEST["prescripcion_facturada"]);

        $consulta = $facturacion->buscar_datoFacturado($prescripcion_facturada);

        $data = Array();

        while ($respuesta = sqlsrv_fetch_object($consulta)) {

	    $no_factura = trim(str_replace(" ", "", $respuesta->NoFactura));

            $data[] = array(
                "0" => ($respuesta->EstDatosFacturado == '1') ? "<button type='button' class='btn btn-secondary btn-sm' onclick=asignar_valorAn('$respuesta->IDDatosFacturado','$respuesta->ID','$no_factura')> Anular </button>" :
                "<button type='button' class='btn btn-light btn-sm' disabled> Anular </button>",
                "1" => $respuesta->ID,
                "2" => $respuesta->IDDatosFacturado,
                "3" => $respuesta->NoFactura,
                "4" => ($respuesta->EstDatosFacturado == '0') ? "Anulado" : (($respuesta->EstDatosFacturado == '1') ? "Activo" : "Procesado"),
                "5" => $respuesta->FEC_ACTUALIZACION
            );
        }


        $results = array(
            "sEcho" => 1, //Informacion para el datatables
            "iTotalRecords" => count($data), //Enviamos el total de registros al datatable
            "iTotalDisplayRecords" => count($data), //Enviamos el total de registros a visualizar
            "aaData" => $data
        );

        echo json_encode($results);
        break;



    //Anula una factura en el Web Service
    case 'put_anularDatosFacturados':

        //Obtener el token temporal en funcion del regimen
        $token_temporal = sqlsrv_fetch_object($facturacion->get_token('SUBSIDIADO', '18'));

        $url = $token_temporal->DES_URL . $_SESSION['NIT_EPS'] . '/' . $token_temporal->DES_TEM_TOKEN . '/' . $IDDatosFacturado;

        $data = array(
            "IDDatosFacturado" => $IDDatosFacturado,
        );


        $ch = curl_init($url);
        $payload = json_encode($data);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json; charset=utf-8'));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PUT');
        curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);

        $result = curl_exec($ch);

        $getinfo = curl_getinfo($ch);

        $informe = array(
            "mensaje" => $result,
            "http_code" => $getinfo['http_code'],
            "total_time" => $getinfo['total_time'],
            "local_ip" => $getinfo['local_ip'],
        );

        echo json_encode($informe);

        break;


    //Guarda el log del proceso de anulacion
    case 'anular_datosFacturados':

        $Id               = limpiarCadena($_REQUEST["Id"]);
        $IDDatosFacturado = limpiarCadena($_REQUEST["IDDatosFacturado"]);
        $NoPrescripcion   = limpiarCadena($_REQUEST["NoPrescripcion"]);
        $factura          = limpiarCadena($_REQUEST["factura"]);
        
        
        $rspta1 = $facturacion->actualizar_facturaAnulada($Id, $IDDatosFacturado, $_SESSION["usuario"]);

        if ($rspta1) {

            $rspta2 = $facturacion->activar_factura($Id, $NoPrescripcion, $factura);
        }

        echo $rspta2 ? true : false;
        
        break;
}






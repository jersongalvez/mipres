<?php

////////////////////////////////////////////////////////////////////////////////
/////////////////////////        SISTEMA MIPRES        /////////////////////////
/////////////////////////      PIJAOS SALUD EPSI      //////////////////////////
/////////////////////////     MODELO FACTURACION    ////////////////////////////
/////////////////////////  DEPARTAMENTO DE DESARROLLO  /////////////////////////
///////       CLASE QUE CONTIENE LAS FUNCIONES QUE VALIDAN EL ARCHIVO //////////
//////////////////////////////  DE FACTURACION    //////////////////////////////
////////////////////////////////////////////////////////////////////////////////
//Incluimos inicialmete la conexion a la base de datos
require '../config/Conexion.php';

class Facturacion {

    //Implementamos nuestro constructor
    public function __construct() {
        //se deja vacio para implementar instancias hacia esta clase
        //sin enviar parametro
    }

    /**
     * Metodo que obtiene los identificadores de una prescripcion
     * @param int $prescripcion
     * @return obj
     */
    public function get_prescripcion($prescripcion) {
        $sql = "SET TRANSACTION ISOLATION LEVEL READ UNCOMMITTED "
                . "SELECT ID, IDFacturacion, NoFactura, CodEPS, CantUnMinDis, ValorTotFacturado, EstFacturacion "
                . "FROM MIPRES_FACTURACION WITH (NOLOCK) WHERE NoPrescripcion = '$prescripcion' ";

        return ejecutarConsulta($sql);
    }

    /**
     * Metodo que valida si un ID de facturacion existe
     * @param int $ID
     * @param int $IdFacturacion
     * @return obj
     */
    public function get_facturacion($ID, $IdFacturacion) {
        $sql = "SET TRANSACTION ISOLATION LEVEL READ UNCOMMITTED "
                . "SELECT IDFacturacion, TipoTec, ConTec, NoEntrega, NoSubEntrega, NoFactura, CodSerTecAEntregado, CantUnMinDis, ValorUnitFacturado, "
                . "ValorTotFacturado, CuotaModer, Copago FROM MIPRES_FACTURACION WITH (NOLOCK) WHERE ID = '$ID' AND IDFacturacion = '$IdFacturacion' ";

        return ejecutarConsulta($sql);
    }

    /**
     * Metodo que obtiene el token actual del Web Service
     * @param String $regimen
     * @return obj
     */
    public function get_token($regimen, $codurl) {
        $obtener_token = ($regimen === 'CONTRIBUTIVO') ? "C" : "S";

        $sql = "SET TRANSACTION ISOLATION LEVEL READ UNCOMMITTED "
                . "SELECT T.DES_TEM_TOKEN, U.DES_URL FROM PRS_TEM_TOKEN T, PRS_URL_SERVICES U WITH (NOLOCK) WHERE T.TIP_TEM_TOKEN = '$obtener_token' AND U.COD_URL = '$codurl'";

        return ejecutarConsulta($sql);
    }

    /**
     * Metodo que actualiza el estado de la factura a procesado
     * @param int $Id
     * @param int $IDFacturacion
     * @return obj
     */
    public function actualizar_factura($Id, $IDFacturacion) {
        $sql = "UPDATE MIPRES_FACTURACION WITH (ROWLOCK) SET EstFacturacion = '2' WHERE ID = '$Id' AND IDFacturacion = '$IDFacturacion' ";

        return ejecutarConsulta($sql);
    }

    /**
     * Metodo que registra el ID devuelto por el Web Service
     * @param int $ID
     * @param int $IDDatosFacturado
     * @param int $NoPrescripcion
     * @param String $cod_usuario
     * @return obj
     */
    public function insertar_idWS($ID, $IDDatosFacturado, $NoPrescripcion, $cod_usuario) {

        $sql = "INSERT INTO MIPRES_DATOS_FACTURADOS WITH(ROWLOCK) (ID, IDDatosFacturado, NoPrescripcion, EstDatosFacturado, COD_USUARIO, FEC_PROCESADO) "
                . "VALUES ('$ID','$IDDatosFacturado','$NoPrescripcion','1','$cod_usuario',GETDATE())";

        return ejecutarConsulta($sql);
    }

    /**
     * Metodo que listas las prescripciones para su anulacion
     * @param type $Noprescripcion
     * @return type
     */
    public function buscar_datoFacturado($Noprescripcion) {

        $sql = "SET TRANSACTION ISOLATION LEVEL READ UNCOMMITTED "
                . "SELECT MDF.ID, IDDatosFacturado, EstDatosFacturado, LTRIM(RTRIM(MFAC.NoFactura)) NoFactura, CONVERT(VARCHAR,MDF.FEC_ACTUALIZACION,113) AS FEC_ACTUALIZACION "
                . "FROM MIPRES_DATOS_FACTURADOS MDF WITH (NOLOCK) "
                . "INNER JOIN MIPRES_FACTURACION MFAC ON MDF.NoPrescripcion = MFAC.NoPrescripcion AND MDF.ID = MFAC.ID "
                . "WHERE MDF.NoPrescripcion = '$Noprescripcion' AND MFAC.EstFacturacion = '2' ";

//        $sql = "SET TRANSACTION ISOLATION LEVEL READ UNCOMMITTED "
//                . "SELECT ID, IDDatosFacturado, EstDatosFacturado, CONVERT(VARCHAR,FEC_ACTUALIZACION,113) AS FEC_ACTUALIZACION "
//                . "FROM MIPRES_DATOS_FACTURADOS WITH (NOLOCK) WHERE NoPrescripcion = '$Noprescripcion' ";

        return ejecutarConsulta($sql);
    }

    /**
     * Metodo que anula una factura cambiando su estado a cero(0)
     * @param String $Id
     * @param String $IDDatosFacturado
     * @param String $cod_usuario
     * @return obj
     */
    public function actualizar_facturaAnulada($Id, $IDDatosFacturado, $cod_usuario) {

        $sql = "UPDATE MIPRES_DATOS_FACTURADOS WITH(ROWLOCK) SET EstDatosFacturado = '0', COD_USUARIO = '$cod_usuario', FEC_PROCESADO = GETDATE() "
                . "WHERE ID = '$Id' AND IDDatosFacturado = '$IDDatosFacturado' ";

        return ejecutarConsulta($sql);
    }

    /**
     * Metodo que habilita nuevamente una factura
     * @param int $Id
     * @param int $prescripcion
     * @param String $factura
     * @return obj
     */
    public function activar_factura($Id, $prescripcion, $factura) {

        $sql = "UPDATE MIPRES_FACTURACION WITH(ROWLOCK) SET EstFacturacion = '1' WHERE ID = '$Id' AND NoPrescripcion = '$prescripcion' AND NoFactura = '$factura' ";

        return ejecutarConsulta($sql);
    }

//    public function pruebas() {
//
//        $sql = "INSERT INTO PRS_URL_SERVICES (COD_URL, DES_URL, SERVICIO, DESCRIPCION) VALUES ('18', 'https://wsmipres.sispro.gov.co/WSFACMIPRESNOPBS/api/DatosFacturadosAnular/', 'PUT', 'ANULAR DATOS FACTURADOS')";
//
//        return ejecutarConsulta($sql);
//    }
}

//$a = Facturacion::pruebas();
//var_dump($a);

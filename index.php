<?php
session_start();

require_once ("controlador/controlador.php");
require_once ("modelo/conexion.php");
require_once ("modelo/gestor.php");

$controlador = new Controlador();

if (isset($_SESSION["usuario"]) && isset($_SESSION["codigo"]))
{
    if (isset($_GET["x"]))
    {
        switch ($_GET["x"])
        {

            case 'logout':
                $controlador->Logout();
            break;

            case '001':
                $controlador->verPagina_log("vista/Vista-GET-api-GenerarToken-nit-token.php");
            break;

            case '002':
                $controlador->verPagina_log("vista/Vista-GET-api-GenerarToken-nit-token-sub.php");
            break;

            case '003':
                $controlador->verPagina_log("vista/Vista-GET-api-Prescripcion-nit-fecha-token.php");
            break;

            case '004':
                $controlador->verPagina_log("vista/Vista-GET-api-Prescripcion-nit-fecha-token-TDPaciente-NroDocPaciente.php");
            break;

            case '005':
                $controlador->verPagina_log("vista/Vista-GET-api-Prescripcion-nit-fecha-token-NroPrescripcion.php");
            break;

            case '006':
                $controlador->verPagina_log("vista/Vista-GET-api-DireccionamientoFecha.php");
            break;

            case '007':
                $controlador->verPagina_log("vista/NuevoDireccionamiento.php");
            break;

            case '008':
                $controlador->verPagina_log("vista/templates/direccionamiento.php");
            break;

            case '009':
                $controlador->verPagina_log("vista/templates/DispararDireccionamiento.php");
            break;

            case '010':
                $controlador->verPagina_log("vista/AnularDireccionamiento.php");
            break;

            case '011':
                $controlador->verPagina_log("vista/templates/DispararAnularDireccionamiento.php");
            break;

            case '012':
                $controlador->verPagina_log("vista/DescargarDireccionamientos.php");
            break;

            case '013':
                $controlador->verPagina_log("vista/NoDireccionamiento.php");
            break;

            case '014':
                $controlador->verPagina_log("vista/templates/DispararDescargarDireccionamientos.php");
            break;

            case '015':
                $controlador->verPagina_log("vista/ConfirmarAnularDireccionamiento.php");
            break;

            case '017':
                $controlador->verPagina_log("vista/NoDireccionamiento-Seleccionado.php");
            break;

            case '018':
                $controlador->verPagina_log("vista/DescargarNoDireccionamientos.php");
            break;

            case '019':
                $controlador->verPagina_log("vista/templates/DispararDescargarNoDireccionamientos.php");
            break;

            case '020':
                $controlador->verPagina_log("vista/templates/DispararNoDireccionamiento.php");
            break;

            case '021':
                $controlador->verPagina_log("vista/AnularNoDireccionamiento.php");
            break;

            case '022':
                $controlador->verPagina_log("vista/ConfirmarAnularNoDireccionamiento.php");
            break;

            case '023':
                $controlador->verPagina_log("vista/templates/DispararAnularNoDireccionamiento.php");
            break;

            case '024':
                $controlador->verPagina_log("vista/DescargarPrescripcion.php");
            break;

            case '025':
                $controlador->verPagina_log("vista/templates/DispararDescargarPrescripcion.php");
            break;

            case '026':
                $controlador->verPagina_log("vista/DescargarTutela.php");
            break;

            case '027':
                $controlador->verPagina_log("vista/templates/DispararDescargarTutela.php");
            break;

            case '028':
                $controlador->verPagina_log("vista/DescargarJunta.php");
            break;

            case '029':
                $controlador->verPagina_log("vista/templates/DispararDescargarJunta.php");
            break;

            case '030':
                $controlador->verPagina_log("vista/DescargarNovedad.php");
            break;

            case '031':
                $controlador->verPagina_log("vista/templates/DispararDescargarNovedad.php");
            break;

            case '032':
                $controlador->verPagina_log("vista/DescargarTodo.php");
            break;

            case '033':
                $controlador->verPagina_log("vista/DescargarEntregaProveedor.php");
            break;

            case '034':
                $controlador->verPagina_log("vista/templates/DispararEntregaProveedor.php");
            break;

            case '035':
                $controlador->verPagina_log("vista/ServiciosSinDireccionar.php");
            break;

            case '036':
                $controlador->verPagina_log("vista/ServiciosPorAnular.php");
            break;

            case '037':
                $controlador->verPagina_log("vista/ConsumirServicios.php");
            break;

            case '038':
                $controlador->verPagina_log("vista/RepTrazabilidad.php");
            break;

            case '039':
                $controlador->verPagina_log("vista/RepDireccionamientos.php");
            break;

            case '040':
                $controlador->verPagina_log("vista/Suministro.php");
            break;

            case '041':
                $controlador->verPagina_log("vista/PorUsuario.php");
            break;

            case '042':
                $controlador->verPagina_log("vista/Dashboard.php");
            break;

            case '043':
                $controlador->verPagina_log("vista/PorPrescripcion.php");
            break;

            case '044':
                $controlador->verPagina_log("vista/ServiciosPrescritos.php");
            break;

            case '045':
                $controlador->verPagina_log("services/GenerarEntregaSuministroEPS.php");
            break;

            case '046':
                $controlador->verPagina_log("vista/AnularSuministro.php");
            break;

            case '047':
                $controlador->verPagina_log("services/AnularSuministroEPS.php");
            break;

            case '048':
                $controlador->verPagina_log("vista/TrazabilidadDireccionamiento.php");
            break;
        
            ################   DATOS FACTURADOS   ################ 
            case '049':
                $controlador->verPagina_log("vista/Datos_facturados.php");
            break;
        
            case '050':
                $controlador->verPagina_log("vista/Anular_Datosfacturados.php");
            break;
            ################   FIN DATOS FACTURADOS   ################

            default:
                $controlador->verPagina_log("vista/principal.php");
            break;
        }
    }
    else
    {
        $controlador->verPagina_log("vista/principal.php");
    }
}

else
{
    if (isset($_GET["x"]))
    {
        switch ($_GET["x"])
        {
            case 'login':
                $controlador->login($_POST["user"], $_POST["pass"]);
            break;

            default:
                $controlador->verlogin("vista/login.php");
            break;
        }
    }
    else
    {
        $controlador->verlogin("vista/login.php");
    }
}

?>

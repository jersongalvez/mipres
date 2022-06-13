<?php
require_once ('modelo/conexion-sql.php');
if (empty($_SESSION['NIT_EPS'])) {
    $sql = "SELECT * FROM compania";
    $params = array();
    $options = array(
        "Scrollable" => SQLSRV_CURSOR_KEYSET
    );
    $stmt = sqlsrv_query($conn, $sql, $params, $options);
    $row_count = sqlsrv_num_rows($stmt);
    if ($row_count === false) {
        echo "<div class='alert alert-danger alert-dismissible'>";
        echo "<button type='button' class='close' data-dismiss='alert'>&times;</button>";
        echo "<strong>Error!</strong> No se ha logrado autenticar los datos de la compañia, error: ERROR0001</div>";
    } else {
        while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
            $_SESSION['NIT_EPS'] = $row['NUM_DOCUMENTO'];
            $_SESSION['NOM_EPS'] = $row['NOM_EPS'];
            $_SESSION['PRETOCKENSUB'] = $row['PRETOCKENSUB'];
            $_SESSION['PRETOCKEN'] = $row['PRETOCKEN'];
            $_SESSION['RUTA_PROYECTO'] = 'http://192.168.20.240/MIPRES/';
            //$_SESSION['RUTA_PROYECTO'] = 'http://192.168.20.122:8080/MIPRES/';
        }
    }
    sqlsrv_free_stmt($stmt);
}

$user = $_SESSION["usuario"];
?>

<!DOCTYPE html>
<html lang="en">

    <head>

        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="description" content="">
        <meta name="author" content="">

        <title>Módulo Mipres</title>

        <!-- Custom fonts for this template-->
        <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

        <!-- Custom styles for this template-->
        <link href="css/sb-admin-2.min.css" rel="stylesheet">

<!--        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>-->
        <link href="vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">

        <!--Datatables-->
        <link rel="stylesheet" type="text/css" href="public/datatables/jquery.dataTables.min.css">
        <link rel="stylesheet" type="text/css" href="public/datatables/buttons.dataTables.min.css">
        <link rel="stylesheet" type="text/css" href="public/datatables/responsive.dataTables.min.css">
        <script type="text/javascript" src="public/js/jquery-3.5.1.min.js"></script>

    </head>

    <body id="page-top" >

        <!-- Page Wrapper -->
        <div id="wrapper">

            <!-- Sidebar -->
            <ul class="navbar-nav bg-gradient-dark sidebar sidebar-dark accordion" id="accordionSidebar"  >

                <!-- Sidebar - Brand -->
                <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.php?x=login" style="background-color:#299440;">
                    <img class="rounded" width="60" height="60" src="vista/images/logo.png">
                    <div class="sidebar-brand-text mx-3">Módulo Mipres<sup>v2</sup></div>
                </a>
                <br>
                <br>
                <!-- Divider -->
                <hr class="sidebar-divider my-0">

                <li class="nav-item active">
                    <a class="nav-link" href="index.php?x=042&año=2020">
                        <i class="fas fa-fw fa-tachometer-alt"></i>
                        <span>Tablero</span></a>
                </li>

                <!-- Divider -->
                <hr class="sidebar-divider">

                <!-- Heading -->
                <div class="sidebar-heading">
                    Procesos
                </div>

                <!-- Nav Item - Pages Collapse Menu -->
                <li class="nav-item">
                    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo">
                        <i class="fas fa-fw fa-cog"></i>
                        <span>Parametrización</span>
                    </a>
                    <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                        <div class="bg-white py-2 collapse-inner rounded">
                            <h6 class="collapse-header">Token´s Temporales</h6>
                            <a class="collapse-item" href="index.php?x=001">Contributivo</a>
                            <a class="collapse-item" href="index.php?x=002">Subsidiado</a>
                        </div>
                    </div>
                </li>

                <?php
                if ($user <> 'MCAPERA' and $user <> 'IDIAZ' and $user <> 'HERNANDEZ' and $user <> 'LLGUZMAN' and $user <> 'JDUQUE' and $user <> 'LOROZCO' and $user <> 'LPERDOMO' ) {
                    ?>

                    <!-- Nav Item - Utilities Collapse Menu -->
                    <li class="nav-item">
                        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseDi" aria-expanded="true" aria-controls="collapseUtilities">
                            <i class="fas fa-fw fa-folder"></i>
                            <span>Direccionamientos</span>
                        </a>
                        <div id="collapseDi" class="collapse" aria-labelledby="headingUtilities" data-parent="#accordionSidebar">
                            <div class="bg-white py-2 collapse-inner rounded">
                                <h6 class="collapse-header">Direccionamientos</h6>
                                <a class="collapse-item" href="index.php?x=007">Nuevo</a>
                                <a class="collapse-item" href="index.php?x=035">Ser. sin Direccionamiento</a>
                                <a class="collapse-item" href="index.php?x=010">Anular</a>
                                <a class="collapse-item" href="index.php?x=036">Servicios por Anular</a>
                                <hr>
                                <a class="collapse-item" href="index.php?x=048">Trazabilidad</a>
                            </div>
                        </div>
                    </li>
                <?php }
                ?>
                <li class="nav-item">
                    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseUtilities" aria-expanded="true" aria-controls="collapseUtilities">
                        <i class="fas fa-fw fa-folder"></i>
                        <span>No Direccionamientos</span>
                    </a>
                    <div id="collapseUtilities" class="collapse" aria-labelledby="headingUtilities" data-parent="#accordionSidebar">
                        <div class="bg-white py-2 collapse-inner rounded">
                            <h6 class="collapse-header">No Direccionamientos</h6>
                            <a class="collapse-item" href="index.php?x=013">Nuevo</a>
                            <a class="collapse-item" href="index.php?x=021">Anular</a>
                        </div>
                    </div>
                </li>

                <?php
                if ($user == 'MCAPERA' or $user == 'IDIAZ' or $user == 'HERNANDEZ' or $user == 'LCORTES' or $user == 'LLGUZMAN' or $user == 'JDUQUE' or $user == 'LOROZCO' or $user == 'LPERDOMO'  or $user == 'JGALVEZ' ) {
                    ?>
                    <li class="nav-item">
                        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseUtilities2  " aria-expanded="true" aria-controls="collapseUtilities">
                            <i class="fas fa-fw fa-folder"></i>
                            <span>Suministro</span>
                        </a>
                        <div id="collapseUtilities2" class="collapse" aria-labelledby="headingUtilities" data-parent="#accordionSidebar">
                            <div class="bg-white py-2 collapse-inner rounded">
                                <a class="collapse-item" href="index.php?x=040">Nuevo <small>V2</small></a>
                                <a class="collapse-item" href="index.php?x=046">Anular <small>V2</small></a>
                            </div>
                        </div>
                    </li>
                <?php }
                ?>


                <?php
                if ($user == 'MCAPERA' or $user == 'IDIAZ' or $user == 'HERNANDEZ' or $user == 'LCORTES' or $user == 'LLGUZMAN' or $user == 'JDUQUE' or $user == 'LOROZCO' or $user == 'LPERDOMO' or $user == 'JGALVEZ' ) {
                    ?>                  
                    <li class="nav-item">
                        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseUtilities50" aria-expanded="true" aria-controls="collapseUtilities">
                            <i class="fas fa-fw fa-folder"></i>
                            <span>Facturación</span>
                        </a>
                        <div id="collapseUtilities50" class="collapse" aria-labelledby="headingUtilities" data-parent="#accordionSidebar">
                            <div class="bg-white py-2 collapse-inner rounded">
                                <a class="collapse-item" href="index.php?x=049">Datos facturados</a>
                                <a class="collapse-item" href="index.php?x=050">Anular</a>
                            </div>
                        </div>
                    </li>
                <?php }
                ?>


                <!-- Divider -->
                <hr class="sidebar-divider">

                <li class="nav-item">
                    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseUtilities3" aria-expanded="true" aria-controls="collapseUtilities">
                        <i class="fas fa-cogs"></i>
                        <span>Prescripción en linea</span>
                    </a>
                    <div id="collapseUtilities3" class="collapse" aria-labelledby="headingUtilities" data-parent="#accordionSidebar">
                        <div class="bg-white py-2 collapse-inner rounded">
                            <h6 class="collapse-header">Consultar por</h6>
                            <a class="collapse-item" href="index.php?x=041">Usuario</a>
                            <a class="collapse-item" href="index.php?x=043">Prescripción</a>
                            <!--  <h6 class="collapse-header">Masivas</h6>
                              <a class="collapse-item" href="index.php?x=044">Servicios Prescritos</a>-->
                        </div>
                    </div>
                </li>


                <li class="nav-item">
                    <a class="nav-link collapsed" href="index.php?x=037">
                        <i class="fas fa-list fa-calendar"></i>
                        <span>Consumir Servicios</span>
                    </a>
                </li>

                <hr class="sidebar-divider">

                <!-- Sidebar Toggler (Sidebar) -->
                <li class="nav-item">
                    <a class="nav-link collapsed" target="blank" href="./vista/manual/MANUAL.pdf">
                        <i class="fas fa-book"></i>
                        <span>Manual de Usuario</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link collapsed" href="#">
                        <i class="fas fa-info"></i>
                        <span>Version 2.0.0.0</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link collapsed" href="index.php?x=logout">
                        <i class="fas fa-sign-out-alt"></i>
                        <span>Salir</span>
                    </a>
                </li>



            </ul>
            <!-- End of Sidebar -->

            <!-- Content Wrapper -->
            <div id="content-wrapper" class="d-flex flex-column" style="background-color:#F0F0F0;">

                <!-- Main Content -->
                <div id="content">

                    <!-- Topbar -->
                    <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

                        <div class="d-none d-sm-inline-block form-inline mr-auto ml-md-3 my-2 my-md-0 mw-100 navbar-search">
                            <h1 class="h3 mb-0 text-gray-800"></h1>
                        </div>

                        <!-- Topbar Navbar -->
                        <ul class="navbar-nav ml-auto">

                            <div class="topbar-divider d-none d-sm-block"></div>

                            <!-- Nav Item - User Information -->
                            <li class="nav-item dropdown no-arrow" >
                                <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <span class="mr-2 d-none d-lg-inline text-gray-600 small"> <?php echo $_SESSION["nombre"]; ?> </span>
                                   <!-- <img class="img-profile rounded-circle" src="https://source.unsplash.com/QAB-WJcbgJk/60x60">-->
                                </a>
                                <!-- Dropdown - User Information -->
                                <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
                                    <a class="dropdown-item" href="#">
                                        <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                                        Perfil
                                    </a>
                                </div>
                            </li>

                        </ul>

                    </nav>
                    <!-- End of Topbar -->

                    <!-- Begin Page Content -->
                    <div class="container-fluid">




                        <div class="modal fade" data-backdrop="static" id="CambioContrasena">
                            <div class="modal-dialog modal-dialog-centered modal-md" >
                                <div class="modal-content" >

                                    <!-- Modal Header -->
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="titulo_modal">Cambio de Contraseña</h5> 
                                    </div>
                                    <div class="container">
                                        <div class="modal-body">
                                            <form action="index.php?y=CambioContrasena" method="post">
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <label for="recipient-name" class="col-form-label">Usuario:</label>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <input type="text" class="form-control" id="user" name="user" value="<?php echo strtoupper($_SESSION["usuario"]); ?>" readonly autocomplete="off">
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <label for="recipient-name" class="col-form-label">Nueva Contraseña:</label>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <input type="password" class="form-control" id="pass" name="pass" autocomplete="off" autofocus required>
                                                    </div>
                                                </div>
                                        </div> 
                                    </div>
                                    <div class="modal-footer">
                                        <button  class="btn btn-outline-dark" type="submit">Cambiar Contraseña</button>
                                    </div>
                                    </form>
                                </div>
                            </div>
                        </div>


                        <?php
                        if (isset($_GET["y"])) {
                            switch ($_GET["y"]) {
                                case 'CambioContrasena':
                                    $user = trim($_POST["user"]);
                                    $pass = trim($_POST["pass"]);
                                    $conexion = new Conexion();
                                    $sql1 = "UPDATE `usuario` SET `password`= '" . $pass . "' WHERE `usuario` = '" . $user . "' ";
                                    $conexion->buscar_query($sql1);
                                    $result1 = $conexion->obtener_filas();
                                    if ($result1 > 0) {
                                        echo "<div class='alert alert-success' role='alert'><button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button><h5 class='display-6'>Contraseña actualizada correctamente</h5></div>";
                                        $_SESSION["password"] = $pass;
                                    } else {
                                        echo "<div class='alert alert-danger' role='alert'><button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button><h5 class='display-6'>Error al actualizar la contraseña</h5></div>";
                                    }
                                    break;
                            }
                        }

                        if ($_SESSION["usuario"] == $_SESSION["password"]) {
                            ?>
                            <script type="text/javascript">
                                $('document').ready(function () {
                                    $('#CambioContrasena').modal('show');
                                });
                            </script>
                            <?php
                        }
                        ?>


                        <style type="text/css">
                            #global {
                                height: 500px;
                                width: auto;
                                border: 1px solid #ddd;
                                overflow-y: scroll;
                                overflow-x: scroll;
                            }
                            #mensajes {
                                height: auto;
                            }
                            .texto {
                                padding:4px;
                                background:#fff;
                            }
                        </style>

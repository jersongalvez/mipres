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

</head>

<body style="background-color:#F0F0F0;">

          <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

          <div class="d-none d-sm-inline-block form-inline mr-auto ml-md-3 my-2 my-md-0 mw-100 navbar-search">
            <h1 class="h3 mb-0 text-gray-800"></h1>
          </div>

          <!-- Topbar Navbar -->
          <ul class="navbar-nav ml-auto">

            <div class="topbar-divider d-none d-sm-block"></div>

            <!-- Nav Item - User Information -->
            <li class="nav-item dropdown no-arrow">
              <a class="nav-link dropdown-toggle" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <span class="mr-2 d-none d-lg-inline text-gray-600 small"> AUTENTICACIÓN DE USUARIOS</span>
               <!-- <img class="img-profile rounded-circle" src="https://source.unsplash.com/QAB-WJcbgJk/60x60">-->
              </a>
            </li>

          </ul>

        </nav>

  <div class="container">

    <!-- Outer Row -->
    <div class="row justify-content-center">

      <div class="col-xl-4 col-lg-4 col-md-4">

        <div class="card o-hidden border-0 shadow-lg my-5">
          <div class="card-body p-0">
            <!-- Nested Row within Card Body -->
            <div class="row">
              <div class="col-lg-12">
                <div class="p-5">
                  <div class="text-center">
                    <img class="rounded" width="100" height="100" src="vista/images/logo.png"><br><br>
                    <h1 class="h4 text-gray-900 mb-4">MÓDULO MIPRES</h1>
                  </div>
                  <form class="user" action="index.php?x=login" method="post">
                    <div class="form-group">
                      <input type="text"  style="text-transform: uppercase;" class="form-control form-control-user" placeholder="Usuario" name="user" required autocomplete="off" autofocus>
                    </div>
                    <div class="form-group">
                      <input type="password" class="form-control form-control-user" placeholder="CONTRASEÑA" name="pass"   required>
                    </div>
                    <center><button class="boton_personalizado" type="submit">Iniciar Sesión</button> </center>
                    <hr>
                  </form>

<center>
<?php
if (isset($_GET["error"])) {
    $mensaje = "Error";
    if ($_GET["error"] == 1) {
        $mensaje = "Usuario o contraseña incorrecta";
    }
    if ($_GET["error"] == 2) {
        $mensaje = "Usuario o contraseña incorrecta";
    }
    echo $mensaje; 
}
?>

</center>
                </div>
              </div>
            </div>
          </div>
        </div>

      </div>

    </div>

  </div>

        <footer class="sticky-footer">
        <div class="container my-auto">
          <div class="copyright text-center my-auto">
            <span>Copyright &copy; Pijaos Salud 2020</span>
          </div>
        </div>
      </footer>

  <!-- Bootstrap core JavaScript-->
  <script src="vendor/jquery/jquery.min.js"></script>
  <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

  <!-- Core plugin JavaScript-->
  <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

  <!-- Custom scripts for all pages-->
  <script src="js/sb-admin-2.min.js"></script>

</body>

</html>
    

<style type="text/css">
  .boton_personalizado{
    text-decoration: none;
    padding: 5px;
    font-weight: 600;
    font-size: 18px;
    color: #ffffff;
    background-color: #299440;
    border-radius: 6px;
    border: 1px solid #299440;
  }
  .boton_personalizado:hover{
    color: #299440;
    background-color: #ffffff;
    border: 1px solid #299440;
  }
</style>
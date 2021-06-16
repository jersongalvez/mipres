<?php

class Gestor {

    public function Login($user, $pass) {
        $conexion = new Conexion();
        $sql = "SELECT * FROM usuario WHERE usuario = '$user' AND password = '$pass' ";
        $conexion->buscar_query($sql);
        $existe = $conexion->obtener_filas();
        if ($existe > 0) {
            $result = $conexion->obtener_resultado();
            $filas = $result->fetch();
            $datos = [$filas["usuario"], $filas["codigo"], $filas["nombre"], $filas["password"]];
            return $datos;
        } else {
            $sql2 = "SELECT * FROM usuario WHERE usuario = '$user' AND password = '$pass' ";
            $conexion->buscar_query($sql2);
            $existe2 = $conexion->obtener_filas();

            if ($existe2 > 0) {
                return 1;
            } else {
                return 2;
            }
        }
    }

    public function registrar($usu) {
        $conexion = new Conexion();

        $user = $usu;


        $id = $user->obtenerId();
        $tipo = $user->obtenerTipo();
        $nombre = $user->obtenerNombre();
        $apellido = $user->obtenerApellido();
        $ficha = $user->obtenerFicha();
        $password = $user->obtenerPassword();
        $telefono = $user->obtenerTelefono();
        $regional = $user->obtenerRegional();
        $centro = $user->obtenerCentro();
        $usuario = $user->obtenerUsuario();


        $sql1 = "SELECT usuario FROM usuario WHERE usuario = '$usuario'";
        $conexion->buscar_query($sql1);
        $result1 = $conexion->obtener_filas();

        if ($result1 > 0) {
            return 2;
        } else {
            $sql2 = "INSERT INTO usuario (id, tipo, nombre, apellido, ficha, password, telefono, regional, centro, usuario) VALUES ('$id','$tipo','$nombre','$apellido','$ficha','$password','$telefono','$regional','$centro','$usuario')";
            $result2 = $conexion->ejecutar_query($sql2);

            if ($result2 > 0) {
                return 1;
            } else {
                return 3;
            }
        }
    }

    public function frmEditar() {
        $conexion = new Conexion();
        $sql = "SELECT * FROM usuario WHERE id = '" . $_SESSION['id'] . "'";
        $conexion->buscar_query($sql);
        $result = $conexion->obtener_resultado();
        return $result;
    }

    public function actualizar($usu) {
        $conexion = new Conexion();

        $id = $_SESSION["id"];
        $user = $usu;

        $usuario = $user->obtenerUsuario();
        $password = $user->obtenerPassword();
        $nombre = $user->obtenerNombre();
        $telefono = $user->obtenerTelefono();
        $correo = $user->obtenerCorreo();
        $genero = $user->obtenerGenero();

        $sql = "UPDATE usuario SET password = '$password',nombre = '$nombre',telefono = '$telefono',correo = '$correo',genero = '$genero' WHERE id = '$id' AND usuario = '$usuario' ";
        $result = $conexion->ejecutar_query($sql);

        return $result;
    }

    public function eliminar() {
        $conexion = new Conexion();
        $usuario = $_SESSION["usuario"];
        $id = $_SESSION["id"];
        $sql = "DELETE FROM usuario WHERE id = '$id' AND usuario = '$usuario'";
        $conexion->ejecutar_query($sql);
    }

    public function registrar_capacitacion(Capacitacion $capacitacion) {
        $conexion = new Conexion();
        $titu = $capacitacion->obtenerTitulo();
        $uni = $capacitacion->obtenerUniversidad();
        $tip = $capacitacion->obtenerTipo();
        $usu = $capacitacion->obtenerUsu();

        $sql2 = "INSERT INTO capacitacion (cod, titulo, universidad, tipo, usuario) VALUES ('','$titu','$uni','$tip','$usu')";
        $result2 = $conexion->ejecutar_query($sql2);
    }

}

?>
<?php 
class Controlador{

	public function verlogin($url){
		require_once($url);
	}

	public function verPagina($url){
		require_once($url);
		require_once("vista/encabezado.php");
	}

	public function verPagina_log($url){
		require_once("vista/principal.php");
		require_once($url);
		require_once("vista/encabezado.php");
	}

	public function Login($user, $pass){
		$gestor = new Gestor();
		$result = $gestor->Login($user, $pass);
		if ($result!=1 && $result!=2) {
			$_SESSION["usuario"] = $result[0];
			$_SESSION["codigo"] = $result[1];
			$_SESSION["nombre"] = $result[2];
			$_SESSION["password"] = $result[3];
			require_once("vista/principal.php");
			require_once("vista/encabezado.php");
		}
		if ($result==1) {
			header("Location:index.php?error=1");
		}
		if ($result==2) {
			header("Location:index.php?error=2");
		}
	}

	public function Logout(){
		if (isset($_SESSION["usuario"])) {
			unset($_SESSION["usuario"]);
		}
		session_destroy();
		header("Location:index.php");
	}

	public function registrar($i,$ti,$nom,$ape,$fic,$pass,$tel,$reg,$cen,$usu){
		$usuario = new Usuario($i,$ti,$nom,$ape,$fic,$pass,$tel,$reg,$cen,$usu);
		$gestor = new Gestor();
		$result = $gestor->registrar($usuario);

		if ($result==1) {
			/***   Registro satisfactorio    ***/
			header("Location:index.php?succes");
		}
		elseif ($result==2) {
			/***   Usuario Repetido    ***/
			header("Location:index.php?accion=registro&error=1");
		}
		elseif ($result==3) {
			/***   Error en registro    ***/
			header("Location:index.php?accion=registro&error=2");
		}
	}
	
	public function registrarNuevoUsuario($i,$ti,$nom,$ape,$fic,$pass,$tel,$reg,$cen,$usu){
		$usuario = new Usuario($i,$ti,$nom,$ape,$fic,$pass,$tel,$reg,$cen,$usu);
		$gestor = new Gestor();
		$result = $gestor->registrar($usuario);

		if ($result==1) {
			/***   Registro satisfactorio    ***/
			header("Location:gestorusuario.php");
		}
		elseif ($result==2) {
			/***   Usuario Repetido    ***/
			header("Location:index.php?accion=registro&error=1");
		}
		elseif ($result==3) {
			/***   Error en registro    ***/
			header("Location:index.php?accion=registro&error=2");
		}
	}

	public function editar(){
		$gestor = new Gestor();
		$result = $gestor->frmEditar();
		require_once("vista/vistalogin/editar.php");
	}

	public function actualizar($usu,$nom,$pass,$tel,$corr,$gen){
		$usuario = new Usuario($usu,$nom,$pass,$tel,$corr,$gen);
		$gestor = new Gestor();
		$result = $gestor->actualizar($usuario);
		if ($result > 0) {
			header("Location:index.php?actualizar=succes");	
		}
		else{
			header("Location:index.php?actualizar=succes");
		}
	}

	public function eliminar(){
		$gestor = new Gestor();
		$gestor->eliminar();
		$this->Logout();
	}

	public function registrar_capacitacion($titulo,$universidad,$tipo){
		$usu=$_SESSION["id"];
		$capacitacion = new Capacitacion($titulo,$universidad,$tipo,$usu);
		$gestor = new Gestor();
		$result = $gestor->registrar_capacitacion($capacitacion);

		if ($result==1) {
			/***   Registro satisfactorio    ***/
			header("Location:index.php?accion=capacitacion");
			
		}
		elseif ($result==0) {
			/***     no guardo  ***/
			header("Location:index.php?accion=capacitacion");
		}
		
	}
}

 ?>
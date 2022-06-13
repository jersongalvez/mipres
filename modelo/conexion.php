<?php 
class Conexion{
	private static $db_host = "localhost";
	//private static $db_user = "pijaos";
	//private static $db_password = "Colombia01+";
	private static $db_user = "root";
    private static $db_password = "";
	protected $db_name = "gemapres";

	private $conn;

	public $resultado;
	public $filas;

	private function abrir_conexion(){
		$this->conn = new PDO("mysql:host=".self::$db_host.";dbname=".$this->db_name."",self::$db_user,self::$db_password);
	}

	private function cerrar_conexion(){
		$this->conn = null;
	}

	public function buscar_query($sql){
		$this->abrir_conexion();
		$this->resultado = $this->conn->query($sql);
		$this->filas = $this->resultado->rowCount();
		$this->cerrar_conexion();
	}

	public function obtener_resultado(){
		return $this->resultado;
	} 

	public function obtener_filas(){
		return $this->filas;
	}

	public function ejecutar_query($sql){
		$this->abrir_conexion();
		$result = $this->conn->exec($sql);
		$this->cerrar_conexion();

		return $result;
	}

}

 ?>
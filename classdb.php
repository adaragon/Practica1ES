<?php

//define('APPCONFIG', __DIR__.'\\..\\app\\config.php');
// Datos de configuraci�n.
include_once 'config.php';

/* Clase encargada de gestionar las conexiones a la base de datos */
Class Db {

	private $link;
	private $result;
	private $regActual;

	private static $_instance;

	/*La funci�n construct es privada para evitar que el objeto pueda ser creado mediante new*/
	private function __construct(){
		
		$this->Conectar($GLOBALS['db_conf']);//le pasamos la base de datos
	}

	/*Evitamos el clonaje del objeto. Patr�n Singleton*/
	private function __clone(){ }

	/*Funci�n encargada de crear, si es necesario, el objeto. Esta es la funci�n que debemos llamar desde fuera de la clase para instanciar el objeto, y as�, poder utilizar sus m�todos*/
	public static function getInstance(){
		if (!(self::$_instance instanceof self)){
			self::$_instance=new self();
		}
		return self::$_instance;
	}

	/*Realiza la conexi�n a la base de datos.*/
	private function Conectar($conf)
	{
		if (! is_array($conf))
		{
			echo "<p>Faltan par�metros de configuraci�n</p>";
			var_dump($conf);
			// Puede que no se requiera ser tan 'expeditivos' y que lanzar una excepci�n sea m�s versatil
			exit();			
		}
		$this-> link =new mysqli($conf['servidor'], $conf['usuario'], $conf['password']);

		/* check connection */
		if (! $this->link ) {
			printf("Error de conexi�n: %s\n", mysqli_connect_error());
			// Puede que no se requiera ser tan 'expeditivos' y que lanzar una excepci�n sea m�s versatil
			exit();
		}
		
		$this->link->select_db($conf['base_datos']);
		$this->link->query("SET NAMES 'utf8'");
	}

	
	/**
	 * Ejecuta una consulta SQL y devuelve el resultado de esta
	 * @param string $sql
	 * @return mixed
	 */
	public function Consulta($sql)
	{
		$this->result=$this->link->query($sql);
		return $this->result;
	}

	/**
	 * Devuelve el siguiente registro del result set devuelto por una consulta.
	 * 
	 * @param mixed $result
	 * @return array | NULL
	 */
	public function LeeRegistro($result=NULL)
	{
		if (! $result)
		{
			if (! $this->result)
			{
				return NULL;
			}
			$result=$this->result;
		}
		$this->regActual=$result->fetch_array();;
		return $this->regActual;
	}

	/**
	 * Devuelve el último registro leido
	 */
	public function RegistroActual()
	{
		return $this->regActual;
	}
	

	/**
	 * Devuelve el valor del �ltimo campo autonumérico insertado
	 * @return int
	 */
	public function LastID()
	{
		return $this->link->insert_id;
	}

	/**
	 * Devuelve el primer registro que cumple la condición indicada
	 * @param string $tabla
	 * @param string $condicion
	 * @param string $campos
	 * @return array|NULL
	 */
	public function LeeUnRegistro($tabla, $condicion, $campos='*')
	{
		$sql="select $campos from $tabla where $condicion limit 1";
		$rs=$this->link->query($sql);
		if($rs)
		{
			return $rs->fetch_array();
		}
		else
		{
			return NULL;
		}
	}
	
	public function Insertar($tabla, $tarea){
	
		$values=array();
		$campos=array();
	
		foreach($tarea as $campo => $valor)
		{
			$values[]='"'.addslashes($valor).'"';
			$campos[]='`'.$campo.'`';
		}
		$sql = "INSERT INTO `$tabla`(".implode(',', $campos).")
				 VALUES (".implode(',', $values)."); ";
		
		echo "<p>SQL:</p><pre>$sql</pre>";
	
		$ok=$this->link->query($sql);
		
		if (! $ok)
		{
			echo "<p>Hay error: .".$this->link->error."</p>";
			exit;
		}
	}
	
}

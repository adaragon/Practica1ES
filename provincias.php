<?php
//define('APPCLASSDB', __DIR__.'\\..\\..\\install\\clasdb.php');
/*Incluimos el fichero de la clase*/
include_once 'C:\xampp\htdocs\practica\classdb.php'; 

/**
 * Devuelve un array con los datos de las provincias
 */
function Provincias()
{
	/*Creamos la instancia del objeto. Ya estamos conectados*/
	$bd = Db::getInstance();
	
	/*Creamos una query sencilla*/
	$sql = 'SELECT cod, nombre as nom
					FROM `tbl_provincias`';
	
	/*Ejecutamos la query*/
	$bd->Consulta($sql);
	
	// Creamos el array donde se guardarÃ¡n las provincias
	$Provincias = Array();
	
	/*Realizamos un bucle para ir obteniendo los resultados*/
	while ($reg = $bd->LeeRegistro())
	{
		$Provincias[$reg['cod']] = $reg['nom'];	 
	}
	return $Provincias;
}


/*
// OTRA FORMA que nos permitirá tener más de una consulta abierta

/*Ejecutamos la query*/
//$rs=$bd->Consulta($sql);

/*Realizamos un bucle para ir obteniendo los resultados*/
/*
while ($reg=$bd->LeeRegistro($rs))
{
	echo $reg['NOMBRE'].'<br />';
}
*/
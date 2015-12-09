<?php 

$errores=array();
$Error=false;
$expresion_nom="|^[a-zA-Z]+(\s*[a-zA-Z]*)*[a-zA-Z]+$|";//Solo admite letras y espacios
$expresion_correo ="/^[_a-z0-9-]+(.[_a-z0-9-]+)*@[a-z0-9-]+(.[a-z0-9-]+)*(.[a-z]{2,4})$/";
$expresion_tlfo_es="/^[9|6|7][0-9]{8}$/";
$expresion_cp="/^[00-52]{2}[0-9]{3}$/";
if (! $_POST)
{
	include 'Vistas/formulario_practica.php';
}
else
{
	
	if(isset($_POST['enviar'])) 
	{
		if(empty($_POST["nombre"]))
		{
			$errores["nombre"] = "El campo Nombre no puede estár vacío <br>";
			$Error=true;
			
		}
		else 
			if(! preg_match($expresion_nom,$_POST["nombre"]))
			{
				$errores["nombre"] = "El nombre sólo puede contener letras <br>";
				$Error=true;
				
			}
		if(empty($_POST["apellidos"]))
		{
			$errores["apellidos"] = "El campo Apellidos no puede estar vacío <br>";
			$Error=true;
			
		}
		if(empty($_POST["descripcion"]))
		{
			$errores["descripcion"] = "El campo Descripción no puede estar vacío <br>";
			$Error=true;
			
		}
		if(empty($_POST["telefono"]))
		{
			$errores["telefono"] = "El campo Teléfono no puede estar vacío <br>";
			$Error=true;
		}
		else 
			if(! preg_match($expresion_tlfo_es,$_POST["telefono"]))
			{
				$errores["telefono"] = "El teléfono tiene que empezar por 9, por 6 o por 7 y tener un total de 9 dígitos. <br>";
				$Error=true;
			}
		if(empty($_POST["email"]))
		{
			$errores["email"] = "El campo Correo Electrónico no puede estar vacío <br>";
			$Error=true;
		}
		else
			if(! preg_match($expresion_correo,$_POST["email"]))
			{
				$errores["email"] = "El formato del correo electrónico es incorrecto<br>";
				$Error=true;
			}
		
		if(empty($_POST["direccion"]))
		{
			$errores["direccion"] = "El campo Dirección no puede estar vacía <br>";
			$Error=true;
		}
		if(empty($_POST["poblacion"]))
		{
			$errores["poblacion"] = "El campo Población no puede estar vacío <br>";
			$Error=true;
		}
		if(empty($_POST["cp"]))
		{
			$errores["cp"] = "El campo Código Postal no puede estar vacío <br>";
			$Error=true;
		}
		else 
			if(! preg_match($expresion_cp,$_POST["cp"]))
			{
				$errores["cp"] = "Formato del Código Postal Incorrecto <br>";
				$Error=true;
			}
		if(empty($_POST["operario"]))
		{
			$errores["operario"] = "El campo Operario no puede estar vacío <br>";
			$Error=true;
		}
		if(empty($_POST["fecha_re"]))
		{
			$errores["fecha_re"] = "El campo Fecha de realización no puede estar vacío <br>";
			$Error=true;
		}
		else 
			if($_POST["fecha_re"]<$_POST["fecha_cre"])
			{
				$errores["fecha_re"] = "El campo Fecha de realización no puede ser menor que la fecha de creación <br>";
				$Error=true;
			}
		echo 'errores comprobados';
	
	
	
	
	if ($Error)
	{
		echo 'hay errores';
		include 'Vistas/formulario_practica.php';
	}
	else 
	{
		echo 'no hay errores';
		include('modelo.php');
		
		$tarea=array
		(
			'nombre'=>$_POST['nombre'],
			'apellidos'=> $_POST['apellidos'],
			'descripcion'=> $_POST['descripcion'],
			'telefono'=> $_POST['telefono'],
			'email'=> $_POST['email'],
			'direccion'=> $_POST['direccion'],
			'poblacion'=> $_POST['poblacion'],
			'cp'=> $_POST['cp'],
			'provincias'=> $_POST['tbl_provincias_cod'],
			'fecha_cre'=> $_POST['fecha_cre'],
			'operario'=> $_POST['operario'],
			'fecha_re'=> $_POST['fecha_re'],
			'an_anterior'=> $_POST['an_anterior'],
			'an_posterior'=> $_POST['an_posterior']
		);
		print_r($tarea);
		InsertaTarea($tarea);
		echo "bien";	
	}
	}
	
}

/**
 *
 * @param string $name Nombre del campo
 * @param array $opciones Opciones que tiene el select
 * 			clave array=valor option
 * 			valor array=texto option
 * @param string $valorDefecto Valor seleccionado
 * @return string
 */
	function CreaSelect($name, $Provincias, $valorDefecto='')
	{
		
		$html="\n".'<select class="form-control" name="'.$name.'">';
		foreach($Provincias as $value=>$text)
		{
			if ($value==$valorDefecto)
				$select='selected="selected"';
			else
				$select="";
			$html.= "\n\t<option value=\"$value\" $select>$text</option>";
		}
		$html.="\n</select>";
	
		return $html;
	}

?>

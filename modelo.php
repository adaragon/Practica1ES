<?php
include "classdb.php";

function InsertaTarea($tarea)
{
	$bd = Db::getInstance();
	
	$bd->Insertar('info_tarea', $tarea);
	
}
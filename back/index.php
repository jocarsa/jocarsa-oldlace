<?php

	// Enrutador del back de la aplicación que sirve los datos que se piden en función de la URL

	include "inc/error.php";								// Configuración de mensajes de error				
	include "Classes/ConexionBD.php";					// Importo la clase de conexión a base de datos
																				
	header('Content-Type: application/json');			// Indico que este archivo devuelve json
		
	$conexion = new ConexionBD();							// Creo una nueva instancia de la conexion
	
	if(isset($_GET['tabla'])){								// Si la URL me envía una tabla
		echo $conexion->pideAlgo($_GET['tabla']);		// Llamo al método correspondiente del objeto
	}
	if(isset($_GET['busca'])){								// Si la URL me envía una búsqueda
		echo $conexion->buscaAlgo(					
				$_GET['busca'],
				$_GET['campo'],
				$_GET['dato']
			);														// Llamo al método correspondiente del objeto
	}
	if(isset($_GET['envio'])){
		$datos = json_decode($_GET['envio'], true);
		$archivo = '../basededatos/pedidos/'.date('U').'.json';
		$datosbonitos = json_encode($datos, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
		file_put_contents($archivo, $datosbonitos);
		echo "ok";

	}
	if(isset($_GET['producto'])){
		echo file_get_contents("../basededatos/productos/".$_GET['producto'].".json");
		
	}
	
?>
	
	


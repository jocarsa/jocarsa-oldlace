<?php

	class ConexionBD{
		// Propiedades de la clase
		private $conexion;
		// Métodos de la clase
			// Método constructor
				public function __construct(){
					$this->conexion = mysqli_connect(
						"", 
						"", 
						"", 
						""
					);	
				}
			// Otros métodos que necesito
				function buscaAlgo($tabla,$columna,$dato){
					$peticion = "
					SELECT * 
					FROM ".$tabla."
					WHERE ".$columna." = '".$dato."'
					;";										// Creo una petición
					//echo $peticion;
					$resultado = mysqli_query($this->conexion, $peticion);						// Ejecuto la petición contra el servidor
					$json = [];																			// Creo un array vacio
					while($fila = mysqli_fetch_array($resultado, MYSQLI_ASSOC)){		// Para cada uno de los resultados
						foreach ($fila as $key => $value) {										// Repasamos los campos uno a uno
						  //if (is_string($value) && strlen($value) > 300) { 				// Supongamos que los BLOB son largos
								//$fila[$key] = base64_encode($value);							// Codificalo como base64
						  //}
					 }
					$json[] = $fila;																// Hago un push al array
					}
					return json_encode($json);														// SAco el resultado en formato compatible con json
				}
				
				function pideAlgo($tabla){
					$peticion = "SELECT * FROM ".$tabla.";";										// Creo una petición
					$resultado = mysqli_query($this->conexion, $peticion);						// Ejecuto la petición contra el servidor
					$json = [];																			// Creo un array vacio
					while($fila = mysqli_fetch_array($resultado, MYSQLI_ASSOC)){		// Para cada uno de los resultados
						foreach ($fila as $key => $value) {										// Repasamos los campos uno a uno
						  //if (is_string($value) && strlen($value) > 300) { 				// Supongamos que los BLOB son largos
								//$fila[$key] = base64_encode($value);							// Codificalo como base64
						  //}
					 }
					$json[] = $fila;																// Hago un push al array
					}
					return json_encode($json);														// SAco el resultado en formato compatible con json
				}
	}

?>

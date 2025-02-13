<div id="migasdepan">
<?php include "config.php"; ?>
	<?php
		if($_GET == []){
			//<echo 'Inicio -> ';
		}else if(isset($_GET['cat'])){
			$peticion = "
				SELECT * 
				FROM categorias
				WHERE Identificador = ".$_GET['cat']."
			;";																					// Creo una petición
			$resultado = mysqli_query($conexion, $peticion);						// Ejecuto la petición contra el servidor																						// Creo un array vacio
			while($fila = mysqli_fetch_array($resultado, MYSQLI_ASSOC)){		// Para cada uno de los resultados
				echo '<a href="https://jocarsa.com">Inicio</a> - <a href="?cat='.$fila['Identificador'].'">'.$fila['nombre'].'</a>';
			 }
		}
		else if(isset($_GET['prod'])){
			$peticion = "
				SELECT 
				productos.titulo AS titulo, 
				categorias.nombre AS categoria,
				categorias.Identificador AS idcategoria
				 
				FROM productos
				LEFT JOIN categorias
				ON productos.categorias_nombre = categorias.Identificador
				WHERE titulo = '".$_GET['prod']."'
				
			;";	
			//echo $peticion;																				// Creo una petición
			$resultado = mysqli_query($conexion, $peticion);						// Ejecuto la petición contra el servidor																						// Creo un array vacio
			while($fila = mysqli_fetch_array($resultado, MYSQLI_ASSOC)){		// Para cada uno de los resultados
				echo '<a href="https://jocarsa.com">Inicio</a> - <a href="?cat='.$fila['idcategoria'].'">'.$fila['categoria'].'</a> - <a href="?prod='.$fila['titulo'].'">'.$fila['titulo']."</a>";
			 }
		}
		
		
	?>
</div>
<script>
	<?php include "./modulos/migasdepan/control/migasdepan.js"?>
</script>
<style>
	<?php include "migasdepan.css"?>
</style>

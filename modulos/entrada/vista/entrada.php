<div id="entrada">
<?php include "config.php"; ?>
	<?php
			$peticion = "
					SELECT 
					*
					FROM blog
					WHERE Identificador = '".$_GET['entrada']."'
				
			;";	

			$resultado = mysqli_query($conexion, $peticion);						// Ejecuto la petición contra el servidor																						// Creo un array vacio
			while($fila = mysqli_fetch_array($resultado, MYSQLI_ASSOC)){		// Para cada uno de los resultados
				echo '
					<h3>'.$fila['titulo'].'</h3>
					<time>'.$fila['fecha'].'</time>
					<img src="static/photo/'.$fila['imagen'].'">
					<p>'.$fila['contenido'].'</p>
				';
			}
	?>
</div>
<script>
	<?php include "./modulos/entrada/control/entrada.js"?>
</script>
<style>
	<?php include "entrada.css"?>
</style>

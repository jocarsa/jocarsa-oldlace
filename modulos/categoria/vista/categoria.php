<!-- Listado de bloques en la página de categoría -->
<main>
	<?php include "config.php"; ?>
	<div class="descripcioncategoria">
		
	<?php
		$peticion = "
			SELECT * 
			FROM categorias
			WHERE Identificador = ".$_GET['cat']."
		;";																					// Creo una petición
		$resultado = mysqli_query($conexion, $peticion);						// Ejecuto la petición contra el servidor																						// Creo un array vacio
		while($fila = mysqli_fetch_array($resultado, MYSQLI_ASSOC)){		// Para cada uno de los resultados
			echo '
				<h3>'.$fila['nombre'].'</h3>
				<p>'.$fila['descripcion'].'</p>
				<iframe width="560" height="315" src="https://www.youtube.com/embed/'.$fila['video'].'?si=fLt6ZIhX_AYvaQje" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
			';
		 }
    ?>
		
	</div>
	<div class="rejillaproductos">
   <?php
    
		$peticion = "
			SELECT * 
			FROM productos
			WHERE categorias_nombre = ".$_GET['cat']."
			AND activo = 'si'
		;";																					// Creo una petición
		$resultado = mysqli_query($conexion, $peticion);						// Ejecuto la petición contra el servidor																					// Creo un array vacio
		while($fila = mysqli_fetch_array($resultado, MYSQLI_ASSOC)){		// Para cada uno de los resultados
			echo '
				<article>
					<a href="producto.php?prod='.$fila['titulo'].'">
					';
					if (file_exists("static/logo/".str_replace("jocarsa | ","",$fila['titulo']).".png")) {
						echo'<img src="static/logo/'.str_replace("jocarsa | ","",$fila['titulo']).'.png">';
					}else{
						echo'<img src="static/logo/jocarsa | '.$fila['color'].'.svg">';
					}
					echo '<h4>'.$fila['titulo'].'</h4>
					<p>'.$fila['descripcion'].'</p>
					</a>
				</article>
			';
		 }
    ?>
    </div>
</main>
<script>
    <?php include "./modulos/categoria/control/categoria.js"; ?>
</script>
<style>
    <?php 
    	include "categoria.css"; 
    	?>
</style>

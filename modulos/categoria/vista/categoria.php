<!-- Listado de bloques en la página de categoría -->
<main>
    <?php
    //include "modulos/bloque/vista/bloque.php";											// Incluyo los bloques
    
    include "config.php";	
    
		$peticion = "
		SELECT * 
		FROM productos
		WHERE categorias_nombre = ".$_GET['cat']."
		AND activo = 'si'
		;";																					// Creo una petición
		//echo $peticion;
		$resultado = mysqli_query($conexion, $peticion);						// Ejecuto la petición contra el servidor
																								// Creo un array vacio
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
</main>
<script>
    <?php include "./modulos/categoria/control/categoria.js"; ?>
</script>
<style>
    <?php 
    	include "categoria.css"; 
    	?>
</style>

<!-- 
	En este archivo encontramos la estructura básica 
	del blog de la aplicación jocarsa | oldlace
-->
<nav id="categoriasblog">
	<ul>
		
	</ul>
</nav>
<main id="blog"> 
	<h2>Blog</h2>
	<div id="contienearticulos">
	</div>
</main>
<template id="plantillaentrada">
	<a href="?entrada=x">
		<article>
			<img src="https://media.licdn.com/dms/image/D4D03AQENah8jccRNmg/profile-displayphoto-shrink_200_200/0/1714469770688?e=2147483647&v=beta&t=ZU2DoF-Jwxncu_9PDlfNlijukWObAt8mBpaZ4FycJ0E">
			<div class="texto">

				<h4>Titulo</h4>
				<time>Fecha</time>
				<p></p>
			</div>
		</article>
	</a>
</template>

<script>
	<?php include "./modulos/blog/control/blog.js"?>
</script>
<style>
	<?php include "blog.css"?>
</style>

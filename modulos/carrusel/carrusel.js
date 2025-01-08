let puntos = document.querySelectorAll(".punto")					// Selecciono los puntos
puntos.forEach(function(punto,index){									// PAra cada uno de los puntos
	punto.onclick = function(){											// Cuando haga click en un punto			
		let carrusel1 = document.querySelector("#carrusel1")		// Cojo el carrusel
		carrusel1.classList.remove("animado1")							// Paro la animacion
		carrusel1.style.left = 0-index*1024+"px"						// Le pongo a mano el desfase en base al punto en el cual he hecho click
	}
})

function cargaProductos(){
	fetch("../back/?tabla=productos") 													// Cargo un endpoint en el back
	.then(function(response) { 													// Cuando obtenga respuesta
		 return response.json(); 													// La convierto en json
	})
	.then(function(datos) { 														// Y cuando reciba datos
		 console.log(datos);
		 datos = datos.slice(0, 8)
		 let contenedor = document.querySelector("#carrusel1")
		 let contenedor2 = document.querySelector("#carrusel2")
		 contenedor.innerHTML = ""
		 datos.forEach(function(dato){
		 	contenedor.innerHTML += `
		 		<article style="background:url(`+ruta_static+`/photo/fondonegro.png),url(`+ruta_static+`/photo/maroon.png);background-size:cover;background-position:center center;">
					<h4>`+dato.titulo+`</h4>
					<p>`+dato.descripcion+`</p>
					<a href=""><button>Saber más</button></a>
				</article>
		 	`
		 	contenedor2.innerHTML += `
		 		<article style="background:url(`+ruta_static+`/photo/fondonegro.png),url(`+ruta_static+`/photo/maroon.png);background-size:cover;background-position:center center;">
					<h4>`+dato.titulo+`</h4>
					<p>`+dato.descripcion+`</p>
					<a href=""><button>Saber más</button></a>
				</article>
		 	`
		 })
		 
	})
 }
 cargaProductos()

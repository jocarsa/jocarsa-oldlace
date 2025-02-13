/*
	Controlador de las ofertas en la web
	Asegura que las ofertas se vean en la cabecera si hay ofertas que visualizar
*/
fetch(ruta_back+"?tabla=oferta")										// Cargo un endpoint en el back
.then(function(response){												// Cuando obtenga respuesta
	return response.json()												// La conbierto en json
})
.then(function(datos){													// Y cuando reciba datos
	datos.forEach(function(dato){
		// Solo aparece una oferta si realmente hay ofertas
		document.querySelector("#contieneoferta").innerHTML = ` 
			<section id="oferta">
				<p>	
					`+datos[0].texto+`  - <a href=''>Saber más</a>
				</p>
			</section>
		`
	})
})

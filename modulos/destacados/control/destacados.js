fetch(ruta_back+"?tabla=seisproductosaleatorios")													// Cargo un endpoint en el back
.then(function(response){														// Cuando obtenga respuesta
	return response.json()														// La conbierto en json
})
.then(function(datos){															// Y cuando reciba datos
	console.log(datos)
	let contenedordestacados = document.querySelector("#destacados")
	let plantilladestacado = document.querySelector("#plantilladestacado")
	datos.forEach(function(dato){
		let instancia = plantilladestacado.content.cloneNode(true);
		instancia.querySelector("h3").textContent = dato.titulo
		instancia.querySelector("h4").textContent = dato.descripcion
		instancia.querySelector("article").style.background = "url("+ruta_static+"/photo/fondonegro.png),url("+ruta_static+"/photo/"+dato.imagen+")"
		instancia.querySelector("article").style.backgroundSize = "cover"
		contenedordestacados.appendChild(instancia)
		
	})
})

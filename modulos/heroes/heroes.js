function recogeHeroes(){
	fetch(ruta_back+"?tabla=heroes")													// Cargo un endpoint en el back
	.then(function(response){														// Cuando obtenga respuesta
		return response.json()														// La conbierto en json
	})
	.then(function(datos){															// Y cuando reciba datos
		console.log(datos)
		let contenedorheroes = document.querySelector("#heroes")
		let plantillaheroe = document.querySelector("#plantillaheroe")
		datos.forEach(function(dato){
			let instancia = plantillaheroe.content.cloneNode(true);
			instancia.querySelector("h3").innerHTML = dato.titulo
			instancia.querySelector("h4").innerHTML = dato.subtitulo
			instancia.querySelector("p").innerHTML = dato.texto
			instancia.querySelector("article").style.background = "url("+ruta_static+"/photo/fondonegro.png),url("+ruta_static+"/photo/"+dato.imagen+")"
			instancia.querySelector("article").style.backgroundSize = "cover";
			instancia.querySelector("#enlace1").setAttribute("href",dato.enlace1)
			instancia.querySelector("#enlace2").setAttribute("href",dato.enlace2)
			instancia.querySelector("#boton1").textContent = dato.textoboton1
			instancia.querySelector("#boton2").textContent = dato.textoboton2
			contenedorheroes.appendChild(instancia)
			
		})
	})
}
recogeHeroes();

/*
	La función cargaBlog se conecta a la base de datos
	y recupera todo el contenido de la misma.
	A cotinuación crea una serie de elementos en la estructura HTML de forma dinámica
	con cada uno de los artículos recuperados
*/
function categoriasBlog(){
	fetch(ruta_back+"/?tabla=categoriasblog") 													// Cargo un endpoint en el back
	.then(function(response) { 													// Cuando obtenga respuesta
		 return response.json(); 													// La convierto en json
	})
	.then(function(datos) { 
		let nav2 = document.querySelector("#categoriasblog ul")
		datos.forEach(function(dato){
		console.log("ok")
			let li = document.createElement("li")
			li.textContent = dato.categoria
			li.onclick = function(){
				console.log("ok")
				cargaCategoriaBlog(dato.Identificador)
			}
			nav2.appendChild(li)
		})
	})
}	
function cargaBlog(){
	fetch(ruta_back+"/?tabla=blog") 													// Cargo un endpoint en el back
	.then(function(response) { 													// Cuando obtenga respuesta
		 return response.json(); 													// La convierto en json
	})
	.then(function(datos) { 														// Y cuando reciba datos
		 console.log(datos);
		 let principal = document.querySelector("#contienearticulos")						// Selecciona la etiqueta principal
		 let plantilla = document.querySelector("#plantillaentrada")	// Selecciona el template
		 datos.forEach(function(dato){											// Para cada dato recibido
		 	let instancia = plantilla.content.cloneNode(true);				// Clono la plantilla original
		 	instancia.querySelector("a").setAttribute("href","entrada.php?entrada="+dato.Identificador) 
		 	instancia.querySelector("h4").textContent = dato.titulo		// Introduzco un titulo personalizado
		 	instancia.querySelector("time").textContent = dato.fecha		// Introduzco la fecha personalizada
		 	instancia.querySelector("article").setAttribute("Identificador",dato.Identificador)
		 	instancia.querySelector("img").setAttribute("src","static/photo/"+dato.imagen)
		 	instancia.querySelector("p").innerHTML = dato.contenido.substring(0, 250)+"..."
		 	instancia.querySelector("article").onclick = function(){
		 	
		 		
		 		// Eventos
		 		document.querySelector("#contienemodalpersonalizado").style.display = "block"
		 		document.querySelector("#contienemodalpersonalizado").onclick = function(event){
		 			event.stopPropagation()
		 			this.style.display = "none";
		 		}
		 		document.querySelector("#modalpersonalizado").onclick = function(event){
		 			event.stopPropagation()
		 		}
		 	}
		 	principal.appendChild(instancia)										// Añadimos la instancia al cuerpo
		 })
	 })
 }
 
 function cargaCategoriaBlog(categoria){
 	document.querySelector("#contienearticulos").innerHTML = ""
 	fetch(ruta_back+"/?busca=blog&campo=categoriasblog_categoria&dato="+categoria) 													// Cargo un endpoint en el back
	.then(function(response) { 													// Cuando obtenga respuesta
		 return response.json(); 													// La convierto en json
	})
	.then(function(datos) { 														// Y cuando reciba datos
		 console.log(datos);
		 let principal = document.querySelector("#contienearticulos")						// Selecciona la etiqueta principal
		 let plantilla = document.querySelector("#plantillaentrada")	// Selecciona el template
		 datos.forEach(function(dato){											// Para cada dato recibido
		 	console.log(dato)
		 	let instancia = plantilla.content.cloneNode(true);				// Clono la plantilla original
		 	instancia.querySelector("a").setAttribute("href","entrada.php?entrada="+dato.Identificador) 
		 	instancia.querySelector("h4").textContent = dato.titulo		// Introduzco un titulo personalizado
		 	instancia.querySelector("time").textContent = dato.fecha		// Introduzco la fecha personalizada
		 	instancia.querySelector("article").setAttribute("Identificador",dato.Identificador)
		 	instancia.querySelector("img").setAttribute("src","static/photo/"+dato.imagen)
		 	instancia.querySelector("p").innerHTML = dato.contenido.substring(0, 250)+"..."
		 	instancia.querySelector("article").onclick = function(){
		 	
		 		
		 		// Eventos
		 		document.querySelector("#contienemodalpersonalizado").style.display = "block"
		 		document.querySelector("#contienemodalpersonalizado").onclick = function(event){
		 			event.stopPropagation()
		 			this.style.display = "none";
		 		}
		 		document.querySelector("#modalpersonalizado").onclick = function(event){
		 			event.stopPropagation()
		 		}
		 	}
		 	principal.appendChild(instancia)										// Añadimos la instancia al cuerpo
		 })
	 })
 }
 
 categoriasBlog()
 cargaBlog();

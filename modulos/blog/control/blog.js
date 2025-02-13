/*
	La función cargaBlog se conecta a la base de datos
	y recupera todo el contenido de la misma.
	A cotinuación crea una serie de elementos en la estructura HTML de forma dinámica
	con cada uno de los artículos recuperados
*/

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
		 	instancia.querySelector("h4").textContent = dato.titulo		// Introduzco un titulo personalizado
		 	instancia.querySelector("time").textContent = dato.fecha		// Introduzco la fecha personalizada
		 	instancia.querySelector("article").setAttribute("Identificador",dato.Identificador)
		 	instancia.querySelector("img").setAttribute("src","/static/photo/"+dato.imagen)
		 	instancia.querySelector("p").innerHTML = dato.contenido.substring(0, 250)+"..."
		 	instancia.querySelector("article").onclick = function(){
		 	
		 		// Cargo el artículo del blog
		 		fetch("../back/?busca=blog&campo=Identificador&dato="+this.getAttribute("Identificador")) 													// Cargo un endpoint en el back
					.then(function(response) { 													// Cuando obtenga respuesta
						 return response.json(); 													// La convierto en json
					})
					.then(function(datos) {
						let modal = document.querySelector("#modalpersonalizado")
						modal.innerHTML = ""
						
						let imagen = document.createElement("img")
						imagen.setAttribute("src","../static/"+dato.imagen)
						modal.appendChild(imagen)
						
						let titulo = document.createElement("h3")
						titulo.textContent = dato.titulo
						modal.appendChild(titulo)
						
						let fecha = document.createElement("time")
						fecha.textContent = dato.fecha
						modal.appendChild(fecha)
						
						let contenido = document.createElement("p")
						contenido.innerHTML = dato.contenido
						modal.appendChild(contenido)
						
						
					 })
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
 
 cargaBlog();

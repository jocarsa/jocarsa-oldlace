const prod = new URLSearchParams(window.location.search).get('prod');
fetch("../back/?producto="+prod)
.then(function(response){
	return response.json()
})
.then(function(datos){
	let contenedor = document.querySelector("main")
	let titulo = document.createElement("h1")
	titulo.innerHTML = "<img src='static/logo/"+prod+".svg' class='logo'>"+prod
	contenedor.appendChild(titulo)
	datos.forEach(function(dato){
		console.log(dato)
		let seccion = document.createElement("div")
		seccion.classList.add(dato.tipo)
		seccion.classList.add("bloque")
		
		let titulo = document.createElement("h3")
		titulo.textContent = dato.contenido.titulo
		seccion.appendChild(titulo)
		
		let subtitulo = document.createElement("h4")
		subtitulo.textContent = dato.contenido.subtitulo
		seccion.appendChild(subtitulo)
		
		let texto = document.createElement("p")
		texto.textContent = dato.contenido.texto
		seccion.appendChild(texto)
		if(dato.tipo == "youtube"){
		
			let video = document.createElement("iframe")
			video.setAttribute("src","https://www.youtube.com/embed/"+dato.contenido.url)	
			seccion.appendChild(video)
			
		}
		if(dato.tipo == "doscolumnas"){
			let columnas = document.createElement("section")
			dato.contenido.columnas.forEach(function(columna){
				let articulo = document.createElement("article")
				
				let titulocolumna = document.createElement("h5")
				titulocolumna.textContent = columna.titulo
				articulo.appendChild(titulocolumna)
				
				let subtitulocolumna = document.createElement("h6")
				subtitulocolumna.textContent = columna.subtitulo
				articulo.appendChild(subtitulocolumna)
				
				let textocolumna = document.createElement("p")
				texto.textContent = columna.texto
				articulo.appendChild(texto)
				
				columnas.appendChild(articulo)
			})
			seccion.appendChild(columnas)
		}
		if(dato.tipo == "mosaico"){
			let columnas = document.createElement("section")
			dato.contenido.bloques.forEach(function(columna){
				let articulo = document.createElement("article")
				
				let titulocolumna = document.createElement("h5")
				titulocolumna.textContent = columna.titulo
				articulo.appendChild(titulocolumna)
				
				let subtitulocolumna = document.createElement("h6")
				subtitulocolumna.textContent = columna.subtitulo
				articulo.appendChild(subtitulocolumna)
				
				let textocolumna = document.createElement("p")
				texto.textContent = columna.texto
				articulo.appendChild(texto)
				
				columnas.appendChild(articulo)
			})
			seccion.appendChild(columnas)
		}
		contenedor.appendChild(seccion)
		
	})
})

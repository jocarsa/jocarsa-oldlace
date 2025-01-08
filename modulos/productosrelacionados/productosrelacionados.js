function productosRelacionados(){
	fetch("../back/?tabla=productos") 											// Cargo un endpoint en el back
	.then(function(response) { 													// Cuando obtenga respuesta
		 return response.json(); 													// La convierto en json
	})
	.then(function(datos) { 
		console.log(datos)
		let contenedor = document.querySelector("aside")
		datos.splice(4);
		datos.forEach(function(dato){
			let articulo = document.createElement("article")
			let titulo = document.createElement("h4")
			titulo.textContent = dato.titulo
			let descripcion = document.createElement("p")
			descripcion.textContent = dato.descripcion
			articulo.appendChild(titulo)
			articulo.appendChild(descripcion)
			let boton = document.createElement("button")
			boton.textContent = "Saber más"
			articulo.appendChild(boton)
			contenedor.appendChild(articulo)
			
		})
	})
}

productosRelacionados();

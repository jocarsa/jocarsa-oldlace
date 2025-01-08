function pieDePagina(){
	fetch("../back/?tabla=redessociales")													// Cargo un endpoint en el back
	.then(function(response){														// Cuando obtenga respuesta
		return response.json()														// La conbierto en json
	})
	.then(function(datos){															// Y cuando reciba datos
		console.log(datos)
			let contenedor = document.querySelector("#redes")
			datos.forEach(function(dato){
				contenedor.innerHTML += `
					<li>
						<a href="`+dato.enlace+`">
							<img src="`+dato.icono+`">`+dato.nombre+`
						</a>
					</li>
				`;
			})
	})
	
}
pieDePagina();

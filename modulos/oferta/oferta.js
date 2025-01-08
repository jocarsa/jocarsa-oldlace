fetch("../back/?tabla=oferta")										// Cargo un endpoint en el back
.then(function(response){											// Cuando obtenga respuesta
	return response.json()											// La conbierto en json
})
.then(function(datos){												// Y cuando reciba datos
	let texto = document.querySelector("#oferta p")			// Selecciono el texto
	texto.innerHTML = datos[0].texto+" - <a href=''>Saber más</a>"					// Y le pongo el texto del json
})

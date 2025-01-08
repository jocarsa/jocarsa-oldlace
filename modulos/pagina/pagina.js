function pagina(){
	const urlParams = new URLSearchParams(window.location.search);
	const idpagina = urlParams.get('pagina');
	fetch("../back/?busca=paginas&campo=Identificador&dato="+idpagina)													// Cargo un endpoint en el back
	.then(function(response){														// Cuando obtenga respuesta
		return response.json()														// La conbierto en json
	})
	.then(function(datos){															// Y cuando reciba datos
		console.log(datos)
		datos.forEach(function(dato){
			document.querySelector("#titulopagina").textContent = dato.titulo
			document.querySelector("#contenidopagina").innerHTML = dato.contenido.replace(/\n/g, "<br><br>");
		})	
	})
	
}
pagina();

function difumina(cabecera){											// Cuando entro
	console.log("Has entrado")		
	document.querySelector("main").classList.add("difuminado")		// LE añado una clase css
	document.querySelector("header").classList.add("grande")
	cabecera.style.background = "rgba(255,255,255,0.9)"				// Le pongo transparencia al fondo
}

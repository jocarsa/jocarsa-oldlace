console.log("js ok")

let botones = document.querySelectorAll(".controlador button")
console.log(botones)
botones.forEach(function(boton){
	boton.onclick = function(){
		seleccionaFoto(boton.value)
	}
})

function seleccionaFoto(boton){
	console.log("Ok has seleccionado algo")
	console.log(boton)
	let valor = boton
	console.log(valor)
	document.querySelector(".contenedorpasafotos").style.left = ((0-(valor-1))*800)+"px"
}

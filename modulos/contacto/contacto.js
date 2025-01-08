document.querySelector("#enviar").onclick = function(){
	console.log("Voy a ver si envío un mensaje")
	// Primero recojo los datos de los campos
	let nombre = document.querySelector("#nombre").value
	let email = document.querySelector("#email").value
	let asunto = document.querySelector("#asunto").value
	let mensaje = document.querySelector("#mensaje").value
	let envias = true;
	
	if(nombre == ""){
		document.querySelector("#nombre").classList.add("rojo")
		document.querySelector("#ayudanombre").textContent = "Introduce un nombre"
		envias = false
	}else{
		document.querySelector("#ayudanombre").textContent = ""
		document.querySelector("#nombre").classList.remove("rojo")
	}
	
	if(email == ""){
		document.querySelector("#ayudaemail").textContent = "Introduce un email"
		document.querySelector("#email").classList.add("rojo")
		envias = false
	}else{
		let reg = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/
		if(reg.test(email)){
			document.querySelector("#ayudaemail").textContent = ""
			document.querySelector("#email").classList.remove("rojo")
		}else{
			document.querySelector("#ayudaemail").textContent = "Introduce un email VALIDO"
			document.querySelector("#email").classList.add("rojo")
		}
		
	}
	
	
	
	
	if(asunto == ""){
		document.querySelector("#ayudaasunto").textContent = "Introduce un asunto"
		document.querySelector("#asunto").classList.add("rojo")
		envias = false
	}else{
		document.querySelector("#ayudaasunto").textContent = ""
		document.querySelector("#asunto").classList.remove("rojo")
	}
	
	if(mensaje == ""){
		document.querySelector("#ayudamensaje").textContent = "Introduce un mensaje"
		document.querySelector("#mensaje").classList.add("rojo")
		envias = false
	}else{
		document.querySelector("#ayudamensaje").textContent = ""
		document.querySelector("#mensaje").classList.remove("rojo")
	}
	
	let fecha = new Date();
	let diadehoy = fecha.getDate()
	
	if(
		document.querySelector("#dobledia").value == diadehoy*2
	){
		
	}else{
		envias = false	
	}
	
	// Construyo el paquete que voy a enviar
	if(envias == true){
		let formData = new FormData();
		 formData.append("nombre", nombre);
		 formData.append("email", email);
		 formData.append("asunto", asunto);
		 formData.append("mensaje", mensaje);

		 // Send the form data via POST
		 fetch(ruta_back+"/mail.php", {
		     method: "POST",
		     body: formData,
		 })
		     .then((response) => response.text())
		     .then((data) => {
		         console.log("Respuesta del servidor:", data);
		         document.querySelector("#retroalimentacion").textContent = data;
		     })
		     .catch((error) => {
		         console.error("Error:", error);
		     });
			
		}else{
			console.warn("De momento no se envia el mensaje")
		}
}

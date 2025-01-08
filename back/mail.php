<?php
// Set content type to plain text or HTML for debugging
header("Content-Type: text/plain");

// Check if required fields are set
if (!isset($_POST['nombre']) || !isset($_POST['email']) || !isset($_POST['asunto']) || !isset($_POST['mensaje'])) {
    echo "Todos los campos son obligatorios.";
    exit;
}

// Retrieve form data
$nombre = htmlspecialchars($_POST['nombre']);
$email = htmlspecialchars($_POST['email']);
$asunto = htmlspecialchars($_POST['asunto']);
$mensaje = htmlspecialchars($_POST['mensaje']);

// Validate email
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    echo "El correo electrónico no es válido.";
    exit;
}

// Compose the email
$to = "destinatario@ejemplo.com"; // Replace with your recipient email
$subject = "Nuevo mensaje de contacto: $asunto";
$body = "Nombre: $nombre\nEmail: $email\n\nMensaje:\n$mensaje";
$headers = "From: $email\r\nReply-To: $email\r\n";


// Save to JSON file
$archivo = fopen("mail/".date('U').".json", "w");
fwrite($archivo, json_encode($_POST, JSON_PRETTY_PRINT));
fclose($archivo);

// Attempt to send the email
if (mail($to, $subject, $body, $headers)) {
    echo "El correo se envió correctamente.";
    
    // Prepare data for JSON
    $data = [
        "nombre" => $nombre,
        "email" => $email,
        "asunto" => $asunto,
        "mensaje" => $mensaje,
        "fecha" => date("Y-m-d H:i:s"),
        "epoch" => time()
    ];

    

    

} else {
    echo "Hubo un problema al enviar el correo.";
}

    

?>


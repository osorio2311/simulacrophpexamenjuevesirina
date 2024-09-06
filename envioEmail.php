<?php
// Inicializar array para almacenar errores
$errores = [];

// Validar el formulario solo si se ha enviado
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Validación del nombre
    if (empty($_POST['nombre'])) {
        $errores[] = "El nombre es obligatorio.";
    } elseif (!preg_match("/^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]+$/", $_POST['nombre'])) {
        $errores[] = "El nombre solo debe contener letras y espacios.";
    }

    // Validación del teléfono (formato español)
    if (empty($_POST['telefono'])) {
        $errores[] = "El teléfono es obligatorio.";
    } elseif (!preg_match("/^(?:(?:\+|00)34|34)?[6789]\d{8}$/", $_POST['telefono'])) {
        $errores[] = "El teléfono no tiene un formato válido para España. Debe ser un número de 9 dígitos empezando por 6, 7, 8 o 9, opcionalmente precedido por +34 o 0034.";
    }

    // Validación del email
    if (empty($_POST['email'])) {
        $errores[] = "El correo electrónico es obligatorio.";
    } elseif (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
        $errores[] = "El formato del correo electrónico no es válido.";
    }

    // Validación de la fecha
    if (empty($_POST['fecha'])) {
        $errores[] = "La fecha es obligatoria.";
    } elseif (strtotime($_POST['fecha']) < strtotime('today')) {
        $errores[] = "La fecha no puede ser anterior a hoy.";
    }

    // Validación de la hora
    if (empty($_POST['hora'])) {
        $errores[] = "La hora es obligatoria.";
    }

    // Validación del servicio
    if (empty($_POST['servicio'])) {
        $errores[] = "Debe seleccionar un servicio.";
    }

    // Validación de la política de protección de datos
    if (!isset($_POST['politica'])) {
        $errores[] = "Debe aceptar la política de protección de datos.";
    }

    // Si no hay errores, procesar el formulario y simular el envío de email
    if (empty($errores)) {
        $to = "tucorreo@ejemplo.com"; // Cambia esto por tu correo
        $subject = "Nueva Solicitud de Cita";
        $message = "Se ha recibido una nueva solicitud de cita con los siguientes detalles:\n\n";
        $message .= "Nombre: " . $_POST['nombre'] . "\n";
        $message .= "Email: " . $_POST['email'] . "\n";
        $message .= "Teléfono: " . $_POST['telefono'] . "\n";
        $message .= "Fecha: " . $_POST['fecha'] . "\n";
        $message .= "Hora: " . $_POST['hora'] . "\n";
        $message .= "Servicio: " . $_POST['servicio'] . "\n";
        $message .= "Mensaje: " . $_POST['mensaje'] . "\n";

        $headers = "From: webmaster@ejemplo.com" . "\r\n" .
            "Reply-To: " . $_POST['email'] . "\r\n" .
            "X-Mailer: PHP/" . phpversion();

        // Simular el envío guardando en un archivo
        $archivo = 'emails_simulados.txt';
        $contenido = "Fecha: " . date('Y-m-d H:i:s') . "\n";
        $contenido .= "Para: $to\n";
        $contenido .= "Asunto: $subject\n";
        $contenido .= "Mensaje:\n$message\n";
        $contenido .= "Headers:\n$headers\n\n";

        if(file_put_contents($archivo, $contenido, FILE_APPEND)) {
            $mensajeExito = "Formulario enviado correctamente. En un entorno de producción, se enviaría un email.";
        } else {
            $mensajeError = "Hubo un problema al procesar el formulario. Por favor, inténtalo de nuevo más tarde.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Resultado del Formulario</title>
    <link rel="stylesheet" href="css/resultado.css">
</head>
<body>
<div class="container">
    <h1>Resultado del Formulario</h1>
    <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (!empty($errores)) {
            echo "<div class='error'>";
            echo "<ul>";
            foreach ($errores as $error) {
                echo "<li>$error</li>";
            }
            echo "</ul>";
            echo "</div>";
        } elseif (isset($mensajeExito)) {
            echo "<div class='success'>$mensajeExito</div>";
            echo "<h2>Datos recibidos:</h2>";
            echo "<ul>";
            echo "<li><strong>Nombre:</strong> " . htmlspecialchars($_POST['nombre']) . "</li>";
            echo "<li><strong>Correo electrónico:</strong> " . htmlspecialchars($_POST['email']) . "</li>";
            echo "<li><strong>Teléfono:</strong> " . htmlspecialchars($_POST['telefono']) . "</li>";
            echo "<li><strong>Fecha:</strong> " . htmlspecialchars($_POST['fecha']) . "</li>";
            echo "<li><strong>Hora:</strong> " . htmlspecialchars($_POST['hora']) . "</li>";
            echo "<li><strong>Servicio:</strong> " . htmlspecialchars($_POST['servicio']) . "</li>";
            echo "<li><strong>Mensaje:</strong> " . htmlspecialchars($_POST['mensaje']) . "</li>";
            echo "</ul>";
        } elseif (isset($mensajeError)) {
            echo "<div class='error'>$mensajeError</div>";
        }
    } else {
        echo "<p>No se ha enviado ningún formulario.</p>";
    }
    ?>
    <a href="index.php">Volver al formulario</a>
</div>
</body>
</html>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Solicitud de Cita Previa</title>
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>
<div class="container">
    <h1>Solicitud de Cita Previa</h1>
    <form id="formularioCita" action="envioEmail.php" method="POST">
        <fieldset>
            <legend>Indique el servicio al que desea solicitar la cita</legend>
            <div class="radio-group">
                <label>
                    <input type="radio" name="servicio" value="seguros"> Seguros
                </label>
                <label>
                    <input type="radio" name="servicio" value="consultoria"> Consultoría Jurídica
                </label>
                <label>
                    <input type="radio" name="servicio" value="administracion"> Administración de Comunidades
                </label>
            </div>
        </fieldset>

        <div class="fila-formulario">
            <div class="columna-formulario">
                <label for="fecha">Seleccione la fecha:</label>
                <input type="date" id="fecha" name="fecha" required>
            </div>
            <div class="columna-formulario">
                <label for="hora">Hora:</label>
                <select id="hora" name="hora" required>
                    <option value="">Seleccione</option>
                </select>
            </div>
        </div>

        <div class="fila-formulario">
            <div class="columna-formulario">
                <label for="nombre">Nombre y Apellido:</label>
                <input type="text" id="nombre" name="nombre" required>
            </div>
            <div class="columna-formulario">
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" required>
            </div>
        </div>

        <div class="fila-formulario">
            <div class="columna-formulario">
                <label for="telefono">Teléfono:</label>
                <input type="tel" id="telefono" name="telefono" required>
            </div>
            <div class="columna-formulario">
                <label for="mensaje">Mensaje (opcional):</label>
                <textarea id="mensaje" name="mensaje"></textarea>
            </div>
        </div>

        <div class="fila-formulario politica-privacidad">
            <label>
                <input type="checkbox" name="politica" required id="casilla">
                Acepto la <a href="#" target="_blank">Política de Privacidad</a>
            </label>
        </div>

        <div class="fila-formulario botones">
            <button type="submit">Solicitar Cita</button>
            <button type="reset">Limpiar</button>
        </div>

    </form>
</div>

<script src="js/script.js"></script>
</body>
</html>
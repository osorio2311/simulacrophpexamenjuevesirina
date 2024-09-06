// Función para generar las opciones de hora en el selector
function generarHoras() {
    const selector = document.getElementById('hora');
    const horaInicio = 9;  // Hora de inicio (9 AM)
    const horaFin = 18;    // Hora de fin (6 PM)
    const intervalo = 30;  // Intervalo en minutos entre cada opción

    for (let hora = horaInicio; hora <= horaFin; hora++) {
        for (let minuto = 0; minuto < 60; minuto += intervalo) {
            if (hora === horaFin && minuto > 0) break; // No añadir horas después de las 18:00

            const horaFormateada = hora.toString().padStart(2, '0');
            const minutoFormateado = minuto.toString().padStart(2, '0');
            const tiempo = `${horaFormateada}:${minutoFormateado}`;

            const option = document.createElement('option');
            option.value = tiempo;
            option.textContent = tiempo;
            selector.appendChild(option);
        }
    }
}

// Función para validar el formulario
function validarFormulario() {
    const nombre = document.getElementById('nombre').value;
    const email = document.getElementById('email').value;
    const telefono = document.getElementById('telefono').value;
    const fecha = document.getElementById('fecha').value;
    const hora = document.getElementById('hora').value;
    const servicio = document.querySelector('input[name="servicio"]:checked');

    const nombreValido = /^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]+$/.test(nombre);
    const emailValido = /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email);
    const telefonoValido = /^(?:(?:\+|00)34|34)?[6789]\d{8}$/.test(telefono);
    const fechaValida = new Date(fecha) >= new Date().setHours(0,0,0,0);

    const todoCorrecto = nombreValido && emailValido && telefonoValido && fechaValida &&
        hora && servicio;

// Mostrar mensajes de error
    mostrarError('nombre', nombreValido, 'El nombre solo debe contener letras y espacios');
    mostrarError('email', emailValido, 'Ingrese un correo electrónico válido');
    mostrarError('telefono', telefonoValido, 'Ingrese un número de teléfono español válido');
    mostrarError('fecha', fechaValida, 'Seleccione una fecha futura');
    mostrarError('hora', hora, 'Seleccione una hora');
    mostrarError('servicio', servicio, 'Seleccione un servicio', true);

    return todoCorrecto;
}

// Función para mostrar mensajes de error
function mostrarError(id, condicion, mensaje, esGrupo = false) {
    const elemento = esGrupo ? document.querySelector(`input[name="${id}"]`) : document.getElementById(id);
    const contenedor = esGrupo ? elemento.closest('fieldset') || elemento.parentNode : elemento.parentNode;
    const errorId = `error-${id}`;
    let errorElement = document.getElementById(errorId);

    if (!condicion) {
        if (!errorElement) {
            errorElement = document.createElement('div');
            errorElement.id = errorId;
            errorElement.className = 'error-mensaje';
            contenedor.appendChild(errorElement);
        }
        errorElement.textContent = mensaje;
    } else if (errorElement) {
        errorElement.remove();
    }
}

// Función para actualizar el estado del botón
function actualizarEstadoBoton() {
    const check = document.querySelector('input[name="politica"]');
    const boton = document.querySelector('button[type="submit"]');
    const formularioValido = validarFormulario();

    if (check.checked && formularioValido) {
        boton.disabled = false;
        boton.classList.add('boton-activo');
    } else {
        boton.disabled = true;
        boton.classList.remove('boton-activo');
    }
}

// Evento que se ejecuta cuando el DOM ha sido completamente cargado
document.addEventListener('DOMContentLoaded', function() {
    generarHoras();

    const fechaInput = document.getElementById('fecha');
    const today = new Date().toISOString().split('T')[0];
    fechaInput.min = today;

// Agregar eventos de validación a todos los campos
    const campos = ['nombre', 'email', 'telefono', 'fecha', 'hora'];
    campos.forEach(campo => {
        document.getElementById(campo).addEventListener('input', actualizarEstadoBoton);
    });

// Para los radio buttons y checkbox
    document.querySelectorAll('input[name="servicio"], input[name="politica"]').forEach(input => {
        input.addEventListener('change', actualizarEstadoBoton);
    });

// Validación inicial
    actualizarEstadoBoton();
});

// Prevenir envío si hay errores
document.getElementById('formularioCita').addEventListener('submit', function(event) {
    if (!validarFormulario()) {
        event.preventDefault();
        alert('Por favor, corrija los errores en el formulario antes de enviarlo.');
    }
});
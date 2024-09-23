document.addEventListener("DOMContentLoaded", function() {
    // Manejo de cambio entre formularios
    const contenedor = document.querySelector(".contenedor");
    const btnSingIn = document.getElementById("btn-sing-in");
    const btnSingUp = document.getElementById("btn-sing-up");

    btnSingIn.addEventListener("click", () => {
        contenedor.classList.remove("toggle");
    });

    btnSingUp.addEventListener("click", () => {
        contenedor.classList.add("toggle");
    });

    btnSingIn.addEventListener("click", () => {
        document.querySelector('.sign-in').classList.add('show');
        document.querySelector('.sign-up').classList.remove('show');
    });
    
    btnSingUp.addEventListener("click", () => {
        document.querySelector('.sign-up').classList.add('show');
        document.querySelector('.sign-in').classList.remove('show');
    });

    // Manejo del formulario de registro
    const registrationForm = document.getElementById('registrationForm');
    if (registrationForm) {
        registrationForm.addEventListener('submit', function(event) {
            event.preventDefault(); // Evitar que el formulario se envíe

            const nombre = document.getElementById('nombre').value;
            const usuarioRegistro = document.getElementById('usuario-registro').value;
            const contraseñaRegistro = document.getElementById('contraseña-registro').value;

            // Validar que los campos no estén vacíos
            if (!nombre || !usuarioRegistro || !contraseñaRegistro) {
                alert("Por favor, completa todos los campos.");
                return;
            }

            // Crear los datos para enviar
            const data = new FormData(registrationForm);

            // Enviar los datos a conexion.php
            fetch('conexion.php', {
                method: 'POST',
                body: data
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Error en la red: ' + response.statusText);
                }
                return response.text();
            })
            .then(result => {
                // Mostrar resultado de la reserva o registro
                alert(result);
            })
            .catch(error => {
                console.error('Error:', error);
                alert("Hubo un problema al procesar tu registro. Intenta nuevamente.");
            });
        });
    } else {
        console.error("No se encontró el formulario de registro.");
    }
});

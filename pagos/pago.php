<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Simulador de Pago con PayPal</title>
    <link rel="stylesheet" href="estilos_carrito.css">n
</head>
<body>
    <div class="paypal-simulador-container">
        <div class="paypal-header">
            <img src="https://upload.wikimedia.org/wikipedia/commons/a/a4/Paypal_2014_logo.png" alt="PayPal Logo" class="paypal-logo">
            <h2>Pago por Paypal</h2>
        </div>

        <div class="monto-pago">
            <p>Estás a punto de pagar:</p>
            <p class="total-a-pagar" id="totalAPagar">$0.00</p>
        </div>

        <div class="paypal-form">
            <p>Por favor, ingresa tus datos de PayPal:</p>
            <div class="form-group">
                <label for="email">Correo electrónico o número de teléfono:</label>
                <input type="text" id="email" name="email" placeholder="ejemplo@dominio.com o 3001234567" required>
                <small id="emailError" style="color: red; display: none;">Por favor, ingresa un formato válido de correo o número de teléfono.</small>
            </div>
            <div class="form-group">
                <label for="password">Contraseña:</label>
                <input type="password" id="password" name="password" placeholder="********" required>
            </div>
            <button type="button" class="btn-paypal-login" id="btnPagarSimulado">Iniciar Sesión y Pagar</button>
            
        </div>

        <div id="resultadoPago" class="resultado-pago" style="display:none;">
            <h3>Procesando tu pago...</h3>
            <p id="mensajePago"></p>
            <button class="btn-volver" onclick="window.close()">Cerrar Ventana</button>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const urlParams = new URLSearchParams(window.location.search);
            const total = urlParams.get('total');
            if (total) {
                document.getElementById('totalAPagar').textContent = `$${parseFloat(total).toFixed(2)}`;
            }
        });

        document.getElementById('btnPagarSimulado').addEventListener('click', function() {
            const emailInput = document.getElementById('email');
            const password = document.getElementById('password').value;
            const email = emailInput.value;
            const emailError = document.getElementById('emailError');
            const resultadoPagoDiv = document.getElementById('resultadoPago');
            const mensajePagoP = document.getElementById('mensajePago');

            emailError.style.display = 'none';

            // Validar si el campo de email/teléfono está vacío
            if (email === '' || password === '') {
                alert('Por favor, ingresa un correo/teléfono y contraseña para simular.');
                return;
            }

            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            const phoneRegex = /^\d{7,15}$/; 

            if (!emailRegex.test(email) && !phoneRegex.test(email)) {
                emailError.style.display = 'block';
                return;
            }
            
            mensajePagoP.textContent = 'Verificando tus datos...';
            resultadoPagoDiv.style.display = 'block';

            setTimeout(() => {
                const pagoExitoso = Math.random() > 0.3; 

                if (pagoExitoso) {
                    mensajePagoP.textContent = '¡El Pago ha sido exitoso! Se ha procesado tu orden.';
                    mensajePagoP.style.color = 'green';
                } else {
                    mensajePagoP.textContent = 'Error en el pago. Inténtalo de nuevo o revisa tus "datos".';
                    mensajePagoP.style.color = 'red';
                }
            }, 2000); // Simular un retraso de 2 segundos
        });
    </script>
</body>
</html>
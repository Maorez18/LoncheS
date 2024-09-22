<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Código de Verificación</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
        <style>
            body {
                background-color: #f4f4f4;
            }
            .email-container {
                max-width: 600px;
                margin: 0 auto;
                background-color: #ffffff;
                padding: 20px;
                border-radius: 8px;
                box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
                text-align: center;
            }
            .email-header {
                padding-bottom: 20px;
            }
            .email-header img {
                max-width: 150px;
            }
            .verification-code {
                font-size: 28px;
                font-weight: bold;
                color: #007bff;
                padding: 10px;
                border: 2px solid #007bff;
                border-radius: 5px;
                display: inline-block;
                margin-bottom: 20px;
            }
            .btn-custom {
                background-color: #28a745;
                color: #ffffff;
                padding: 10px 20px;
                border-radius: 5px;
                text-decoration: none;
                font-size: 18px;
                display: inline-block;
            }
            .footer {
                text-align: center;
                font-size: 12px;
                color: #6c757d;
                margin-top: 20px;
            }
            /*.background-image {
                background-image: url('https://lonches.proyectosjevl.com/assets/img/login/double-bubble-outline.webp');
                background-size: cover;
                background-position: center;
                height: 200px;
                border-radius: 8px 8px 0 0;
            }*/
            .icon img {
                max-width: 50px;
            }
        </style>
    </head>
    <body>
        <div class="container email-container">
            <!-- Imagen de fondo en la cabecera -->
{{--            <div class="background-image"></div>--}}
            <div class="email-header">
                <img src="{{asset('assets/img/logos/logo_LoncheS.webp')}}" alt="Logo de la Aplicación">
            </div>
            <div class="email-content">
                <h4>¡Hola {{ $name }}!</h4>
                <p>Gracias por registrarte en LoncheS. Utiliza el siguiente código para verificar tu cuenta:</p>
                <div class="verification-code">{{ $code }}</div>
                <p>O puedes verificar tu cuenta haciendo clic en el siguiente botón:</p>
                <a href="{{ route('verification.verify') }}" class="btn btn-custom">Verificar Cuenta</a>
            </div>
            <div class="icon">
                <img src="{{asset('assets/img/logos/logo_LoncheS.webp')}}" alt="Icono de Verificación">
            </div>
            <div class="footer">
                <p>Si no solicitaste esta verificación, puedes ignorar este correo.</p>
                <p>&copy; {{ date('Y') }} LoncheS. Todos los derechos reservados.</p>
            </div>
        </div>
    </body>
</html>

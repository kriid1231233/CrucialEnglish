<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bienvenido a CrucialEnglish</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
        }
        .header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 30px;
            text-align: center;
            border-radius: 8px 8px 0 0;
        }
        .content {
            background: #f8f9fa;
            padding: 30px;
            border-radius: 0 0 8px 8px;
        }
        .button {
            display: inline-block;
            background: #667eea;
            color: white;
            padding: 12px 30px;
            text-decoration: none;
            border-radius: 5px;
            margin-top: 20px;
        }
        .footer {
            text-align: center;
            margin-top: 20px;
            font-size: 12px;
            color: #6c757d;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>¡Bienvenido a CrucialEnglish!</h1>
    </div>
    <div class="content">
        <p>Hola <strong>{{ $user->name }}</strong>,</p>
        
        <p>¡Gracias por registrarte en CrucialEnglish! Estamos emocionados de tenerte como parte de nuestra comunidad.</p>
        
        <p>Tu cuenta ha sido creada exitosamente y ya puedes acceder a nuestra plataforma para comenzar tu viaje en el aprendizaje del inglés.</p>
        
        <p><strong>¿Qué puedes hacer ahora?</strong></p>
        <ul>
            <li>Explorar nuestros cursos y niveles disponibles</li>
            <li>Inscribirte en clases grupales o individuales</li>
            <li>Acceder a materiales de estudio</li>
            <li>Ver clases pregrabadas</li>
        </ul>
        
        <a href="{{ url('/dashboard') }}" class="button">Ir a Mi Panel</a>
        
        <p style="margin-top: 30px;">Si tienes alguna pregunta, no dudes en contactarnos.</p>
        
        <p>¡Bienvenido y mucho éxito en tu aprendizaje!</p>
        
        <p><strong>El equipo de CrucialEnglish</strong></p>
    </div>
    <div class="footer">
        <p>Este es un correo automático, por favor no responder.</p>
        <p>&copy; {{ date('Y') }} CrucialEnglish. Todos los derechos reservados.</p>
    </div>
</body>
</html>

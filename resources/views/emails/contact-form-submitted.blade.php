<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Nuevo mensaje de contacto</title>
</head>
<body style="font-family: Arial, sans-serif; line-height: 1.6; color: #1a1a1a; max-width: 600px; margin: 0 auto; padding: 24px;">
    <h1 style="color: #005674; font-size: 20px; margin-bottom: 16px;">Nuevo mensaje desde el formulario de contacto</h1>

    <p style="margin: 0 0 8px;"><strong>Nombre:</strong> {{ $data['nombre'] }}</p>
    <p style="margin: 0 0 8px;"><strong>Correo:</strong> <a href="mailto:{{ $data['email'] }}">{{ $data['email'] }}</a></p>
    <p style="margin: 0 0 16px;"><strong>Asunto:</strong> {{ $data['asunto'] }}</p>

    <h2 style="color: #0B4F6C; font-size: 16px; margin-bottom: 8px;">Mensaje</h2>
    <p style="white-space: pre-wrap; background: #f5f8fa; padding: 16px; border-radius: 8px; border: 1px solid #e2e8f0;">{{ $data['mensaje'] }}</p>

    <p style="margin-top: 24px; font-size: 12px; color: #607d8b;">
        Enviado desde el sitio web del IDCBIS el {{ now()->timezone('America/Bogota')->format('d/m/Y H:i') }} (hora Colombia).
    </p>
</body>
</html>

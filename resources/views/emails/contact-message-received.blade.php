<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nuevo mensaje de contacto</title>
</head>

<body style="margin: 0; padding: 0; background-color: #f1f5f9; font-family: Arial, sans-serif;">
    <table role="presentation" style="width: 100%; border-collapse: collapse;">
        <tr>
            <td style="padding: 40px 20px;">
                <table role="presentation"
                    style="max-width: 600px; margin: 0 auto; background-color: #ffffff; border-radius: 8px; overflow: hidden; box-shadow: 0 4px 6px rgba(0,0,0,0.1);">

                    {{-- Header --}}
                    <tr>
                        <td style="background-color: #0f172a; padding: 30px; text-align: center;">
                            <h1 style="margin: 0; color: #ffffff; font-size: 24px; font-weight: bold;">
                                Nuevo mensaje de contacto
                            </h1>
                            <p style="margin: 8px 0 0; color: #94a3b8; font-size: 14px;">
                                Sitio web de Jorge Pinto
                            </p>
                        </td>
                    </tr>

                    {{-- Contenido --}}
                    <tr>
                        <td style="padding: 40px 30px;">

                            {{-- Datos del remitente --}}
                            <table role="presentation" style="width: 100%; border-collapse: collapse;">
                                <tr>
                                    <td style="padding: 12px 0; border-bottom: 1px solid #e2e8f0;">
                                        <strong
                                            style="color: #475569; font-size: 12px; text-transform: uppercase; letter-spacing: 1px;">Nombre</strong>
                                        <p style="margin: 4px 0 0; color: #0f172a; font-size: 16px;">
                                            {{ $contactMessage->name }}
                                        </p>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="padding: 12px 0; border-bottom: 1px solid #e2e8f0;">
                                        <strong
                                            style="color: #475569; font-size: 12px; text-transform: uppercase; letter-spacing: 1px;">Email</strong>
                                        <p style="margin: 4px 0 0; color: #0f172a; font-size: 16px;">
                                            <a href="mailto:{{ $contactMessage->email }}"
                                                style="color: #2563eb; text-decoration: none;">
                                                {{ $contactMessage->email }}
                                            </a>
                                        </p>
                                    </td>
                                </tr>
                                @if ($contactMessage->phone)
                                    <tr>
                                        <td style="padding: 12px 0; border-bottom: 1px solid #e2e8f0;">
                                            <strong
                                                style="color: #475569; font-size: 12px; text-transform: uppercase; letter-spacing: 1px;">Teléfono</strong>
                                            <p style="margin: 4px 0 0; color: #0f172a; font-size: 16px;">
                                                <a href="tel:{{ $contactMessage->phone }}"
                                                    style="color: #2563eb; text-decoration: none;">
                                                    {{ $contactMessage->phone }}
                                                </a>
                                            </p>
                                        </td>
                                    </tr>
                                @endif
                                <tr>
                                    <td style="padding: 12px 0; border-bottom: 1px solid #e2e8f0;">
                                        <strong
                                            style="color: #475569; font-size: 12px; text-transform: uppercase; letter-spacing: 1px;">Asunto</strong>
                                        <p style="margin: 4px 0 0; color: #0f172a; font-size: 16px;">
                                            {{ $contactMessage->subject ?? 'Sin asunto' }}
                                        </p>
                                    </td>
                                </tr>
                            </table>

                            {{-- Mensaje --}}
                            <div style="margin-top: 30px;">
                                <strong
                                    style="color: #475569; font-size: 12px; text-transform: uppercase; letter-spacing: 1px;">Mensaje</strong>
                                <div
                                    style="margin-top: 12px; padding: 20px; background-color: #f8fafc; border-left: 4px solid #2563eb; border-radius: 4px;">
                                    <p
                                        style="margin: 0; color: #0f172a; font-size: 15px; line-height: 1.6; white-space: pre-wrap;">
                                        {{ $contactMessage->message }}
                                    </p>
                                </div>
                            </div>

                            {{-- Info adicional --}}
                            <div style="margin-top: 30px; padding-top: 20px; border-top: 1px solid #e2e8f0;">
                                <p style="margin: 0; color: #94a3b8; font-size: 12px;">
                                    <strong>Recibido:</strong>
                                    {{ $contactMessage->created_at->translatedFormat('l, d \d\e F \d\e Y - H:i') }}
                                </p>
                                <p style="margin: 4px 0 0; color: #94a3b8; font-size: 12px;">
                                    <strong>IP:</strong> {{ $contactMessage->ip_address ?? 'No registrada' }}
                                </p>
                            </div>

                            {{-- Botón de acción --}}
                            <div style="margin-top: 30px; text-align: center;">
                                <a href="{{ url('/admin/contact-messages') }}"
                                    style="display: inline-block; padding: 12px 24px; background-color: #2563eb; color: #ffffff; text-decoration: none; border-radius: 6px; font-weight: bold; font-size: 14px;">
                                    Ver en el panel
                                </a>
                            </div>
                        </td>
                    </tr>

                    {{-- Footer --}}
                    <tr>
                        <td
                            style="background-color: #f8fafc; padding: 20px; text-align: center; border-top: 1px solid #e2e8f0;">
                            <p style="margin: 0; color: #94a3b8; font-size: 12px;">
                                Este mensaje fue enviado desde el formulario de contacto de
                                <a href="{{ config('app.url') }}" style="color: #2563eb; text-decoration: none;">
                                    {{ config('app.name') }}
                                </a>
                            </p>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>

</html>

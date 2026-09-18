<?php

namespace App\Services;

use App\Models\ContactMessage;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class BrevoMailer
{
    /**
     * Enviar notificación de nuevo mensaje de contacto al administrador.
     */
    public static function sendContactNotification(ContactMessage $message): bool
    {
        $brevoKey = config('services.brevo.key');
        $fromEmail = config('services.brevo.from_email');
        $fromName = config('services.brevo.from_name');
        $recipient = config('mail.contact_recipient');

        try {
            $response = Http::withHeaders([
                'accept' => 'application/json',
                'api-key' => $brevoKey,
                'content-type' => 'application/json',
            ])->post('https://api.brevo.com/v3/smtp/email', [
                'sender' => [
                    'email' => $fromEmail,
                    'name' => $fromName,
                ],
                'to' => [
                    [
                        'email' => $recipient,
                        'name' => 'Administrador',
                    ],
                ],
                'replyTo' => [
                    'email' => $message->email,
                    'name' => $message->name,
                ],
                'subject' => '📬 Nuevo mensaje de contacto: ' . ($message->subject ?? 'Sin asunto'),
                'htmlContent' => view('emails.contact-message-received', [
                    'contactMessage' => $message,
                ])->render(),
            ]);

            if ($response->failed()) {
                Log::error('Error al enviar correo por Brevo API', [
                    'status' => $response->status(),
                    'body' => $response->body(),
                ]);
                return false;
            }

            return true;
        } catch (\Exception $e) {
            Log::error('Excepción al enviar correo por Brevo API: ' . $e->getMessage());
            return false;
        }
    }
}

<?php

namespace App\Http\Controllers;

use App\Mail\ContactMessageReceived;
use App\Models\ContactMessage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

class ContactController extends Controller
{
    /**
     * Mostrar formulario de contacto.
     */
    public function index()
    {
        return view('contact.show');
    }

    /**
     * Procesar el envío del formulario.
     */
    public function store(Request $request)
    {
        // 1. Validación
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255'],
            'phone' => ['nullable', 'string', 'max:20'],
            'subject' => ['nullable', 'string', 'max:255'],
            'message' => ['required', 'string', 'min:10', 'max:5000'],
            'consent_given' => ['accepted'],
        ], [
            'name.required' => 'El nombre es obligatorio.',
            'email.required' => 'El correo electrónico es obligatorio.',
            'email.email' => 'El correo electrónico no es válido.',
            'message.required' => 'El mensaje es obligatorio.',
            'message.min' => 'El mensaje debe tener al menos 10 caracteres.',
            'consent_given.accepted' => 'Debes aceptar la política de privacidad.',
        ]);

        // 2. Guardar en la base de datos
        $contactMessage = ContactMessage::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'] ?? null,
            'subject' => $validated['subject'] ?? 'Consulta desde el sitio web',
            'message' => $validated['message'],
            'consent_given' => true,
            'consent_given_at' => now(),
            'status' => 'nuevo',
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
        ]);

        // 3. Enviar correo de notificación
        try {
            Mail::to(config('mail.contact_recipient', 'info@jorgepinto.com'))
                ->send(new ContactMessageReceived($contactMessage));
        } catch (\Exception $e) {
            Log::error('Error al enviar correo de contacto: ' . $e->getMessage());
        }

        // 4. Redirigir con mensaje de éxito
        return redirect()
            ->route('contacto')
            ->with('success', '¡Gracias por escribirnos! Hemos recibido tu mensaje y te responderemos pronto.');
    }
}

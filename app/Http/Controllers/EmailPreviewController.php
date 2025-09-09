<?php

namespace App\Http\Controllers;

use App\Mail\ContactConfirmationMail;
use App\Mail\ContactFormMail;
use Illuminate\Http\Request;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Auth\Notifications\ResetPassword;
use App\Models\User;

class EmailPreviewController extends Controller
{
    public function show(Request $request, string $type)
    {
        // Seulement en développement
        /*if (! app()->environment('local')) {
            abort(404);
        }*/

        return match ($type) {
            'contact-form' => $this->contactForm(),
            'contact-confirmation' => $this->contactConfirmation(),
            'email-verification' => $this->emailVerification(),
            'password-reset' => $this->passwordReset(),
            default => $this->contactForm(),
        };
    }

    private function contactForm()
    {
        $contactData = [
            'name' => 'Jean Dupont',
            'email' => 'jean.dupont@example.com',
            'subject' => 'Demande de devis pour un site web',
            'message' => 'Bonjour,

Je souhaiterais obtenir un devis pour la création d\'un site web vitrine pour mon entreprise. Le site devrait comporter environ 5 pages avec un design moderne et responsive.

Pourriez-vous me faire parvenir une estimation ?

Merci d\'avance.',
            'subject_type' => 'general',
            'sent_at' => now(),
        ];

        $mail = new ContactFormMail($contactData);

        return $mail->render();
    }

    private function contactConfirmation()
    {
        $contactData = [
            'name' => 'Jean Dupont',
            'email' => 'jean.dupont@example.com',
            'subject' => 'Demande de devis pour un site web',
            'message' => 'Bonjour,

Je souhaiterais obtenir un devis pour la création d\'un site web vitrine pour mon entreprise...',
            'subject_type' => 'general',
            'sent_at' => now(),
        ];

        $mail = new ContactConfirmationMail($contactData);

        return $mail->render();
    }

    private function emailVerification()
    {
        // Créer un utilisateur factice pour la démo
        $user = new User([
            'name' => 'Jean Dupont',
            'email' => 'jean.dupont@example.com',
        ]);
        $user->id = 1;
        
        $notification = new VerifyEmail();
        
        return $notification->toMail($user)->render();
    }

    private function passwordReset()
    {
        // Créer un utilisateur factice pour la démo  
        $user = new User([
            'name' => 'Jean Dupont',
            'email' => 'jean.dupont@example.com',
        ]);
        $user->id = 1;
        
        $token = 'sample-token-for-preview';
        $notification = new ResetPassword($token);
        
        return $notification->toMail($user)->render();
    }
}

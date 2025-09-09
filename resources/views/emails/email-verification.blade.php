<x-mail::message>
# Vérifiez votre adresse e-mail

Bonjour,

Merci d'avoir créé votre compte sur {{ config('app.name') }}. Pour des raisons de sécurité, nous devons vérifier votre adresse e-mail avant que vous puissiez commencer à utiliser toutes les fonctionnalités.

<x-mail::panel>
**Pourquoi cette vérification ?**

• Sécuriser votre compte contre les accès non autorisés  
• Vous assurer de recevoir nos communications importantes  
• Respecter les bonnes pratiques de sécurité
</x-mail::panel>

<x-mail::button :url="$actionUrl" color="primary">
Vérifier mon adresse e-mail
</x-mail::button>

## Alternative

Si le bouton ne fonctionne pas, vous pouvez copier et coller le lien suivant dans votre navigateur :

{{ $actionUrl }}

---

**Besoin d'aide ?**

Si vous rencontrez des difficultés, n'hésitez pas à nous contacter.

Si vous n'avez pas créé de compte, vous pouvez ignorer ce message en toute sécurité.

Cordialement,  
L'équipe {{ config('app.name') }}

---

Ce lien de vérification expirera dans 60 minutes pour votre sécurité.  
© {{ date('Y') }} {{ config('app.name') }}. Tous droits réservés.
</x-mail::message>
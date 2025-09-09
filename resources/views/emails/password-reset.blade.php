<x-mail::message>
# Réinitialisation de mot de passe

Bonjour,

Vous avez demandé la réinitialisation de votre mot de passe pour votre compte {{ config('app.name') }}.

<x-mail::panel>
**Informations importantes :**

• Ce lien est valide pendant 60 minutes seulement  
• Il ne peut être utilisé qu'une seule fois  
• Après utilisation, tous vos appareils seront déconnectés
</x-mail::panel>

<x-mail::button :url="$actionUrl" color="primary">
Réinitialiser mon mot de passe
</x-mail::button>

## Conseils pour un mot de passe sécurisé

Lors de la création de votre nouveau mot de passe, assurez-vous qu'il :

• Contient au moins 8 caractères  
• Inclut des lettres majuscules et minuscules  
• Contient au moins un chiffre  
• Inclut un caractère spécial (@, #, $, etc.)

## Alternative

Si le bouton ne fonctionne pas, copiez et collez ce lien dans votre navigateur :

{{ $actionUrl }}

---

**Attention :** Si vous n'avez pas demandé cette réinitialisation, votre compte pourrait être compromis. Dans ce cas, contactez-nous immédiatement.

Si vous n'avez pas demandé de réinitialisation, vous pouvez ignorer ce message en toute sécurité.

Cordialement,  
L'équipe {{ config('app.name') }}

---

Pour votre sécurité, ce lien expirera automatiquement dans 60 minutes.  
© {{ date('Y') }} {{ config('app.name') }}. Tous droits réservés.
</x-mail::message>
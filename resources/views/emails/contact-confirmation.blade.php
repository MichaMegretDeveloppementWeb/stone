<x-mail::message>
# Confirmation de réception

Bonjour {{ $contactData['name'] }},

Nous avons bien reçu votre message concernant "{{ $contactData['subject'] }}" et nous vous en remercions.

## Récapitulatif de votre demande

<x-mail::panel>
**Type de demande :** {{ $subjectTypeLabel }}  
**Sujet :** {{ $contactData['subject'] }}  
**Envoyé le :** {{ $contactData['sent_at']->format('d/m/Y à H:i') }}  
**Référence :** #{{ $contactData['sent_at']->format('YmdHi') }}
</x-mail::panel>

## Votre message

{{ $contactData['message'] }}

## Prochaines étapes

**Notre engagement :**

• **Accusé de réception :** Fait (ce message)  
• **Première réponse :** Sous 24-48 heures ouvrables  
• **Suivi personnalisé :** Selon la nature de votre demande  

**Demande urgente ?** Contactez-nous directement au {{ config('contact.phone.main', '+33 6 87 93 46 47') }}.

<x-mail::button :url="config('app.url')" color="primary">
Retourner sur {{ config('app.name') }}
</x-mail::button>

## Ressources utiles

En attendant notre réponse, vous pouvez consulter :

• [Centre d'aide]({{ route('support.help-center') }}) - FAQ et guides
• [Documentation]({{ route('support.documentation') }}) - Ressources complètes  
• [Communauté]({{ route('support.community') }}) - Forum d'entraide

---

Merci de nous faire confiance et de contribuer à l'amélioration de {{ config('app.name') }}.

Cordialement,  
L'équipe {{ config('app.name') }}

**Référence :** #{{ $contactData['sent_at']->format('YmdHi') }}
</x-mail::message>

<x-mail::message>
# Nouveau message de contact

Vous avez reçu un nouveau message via le formulaire de contact de {{ config('app.name') }}.

**Type de demande :** {{ $subjectTypeLabel }}  
**Reçu le :** {{ $contactData['sent_at']->format('d/m/Y à H:i') }}

## Informations de contact

<x-mail::panel>
**Nom :** {{ $contactData['name'] }}  
**Email :** {{ $contactData['email'] }}  
**Type de demande :** {{ $subjectTypeLabel }}  
**Sujet :** {{ $contactData['subject'] }}
</x-mail::panel>

## Message

{{ $contactData['message'] }}

<x-mail::button :url="'mailto:' . $contactData['email'] . '?subject=Re: ' . urlencode($contactData['subject'])" color="primary">
Répondre directement
</x-mail::button>

## Informations techniques

**Date d'envoi :** {{ $contactData['sent_at']->format('d/m/Y à H:i:s') }}  
**Adresse IP :** {{ request()->ip() ?? 'N/A' }}  
**User Agent :** {{ request()->userAgent() ?? 'N/A' }}  

---

**Action recommandée :** Répondez dans les 24-48 heures pour maintenir une excellente expérience client.

Cordialement,  
Le système {{ config('app.name') }}
</x-mail::message>

@component('mail::message')
# Invitation pour le chef de departement

Vous êtes invité à vous connecter sur notre plateforme dès que possible.

@component('mail::panel')
**Email: <span style="color:rgb(174, 11, 11)">{{ $account->email_dep }}</span><br>
Mot de passe: <span style="color:rgb(174, 11, 11)">{{ $account->password }}</span>**
@endcomponent

@component('mail::button', ['url' => ''])
Connecter
@endcomponent

Merci,<br>
Sous-directeur de personnel
@endcomponent

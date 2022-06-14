@component('mail::message')
# Invitation



### Vous êtes invité à vous connecter sur notre plateforme dès que possible.



@component('mail::panel')
**Email: <span style="color:rgb(174, 11, 11)">{{ $account->email_dep }}</span><br>
Mot de passe: <span style="color:rgb(174, 11, 11)">{{ $account->password }}</span>**
@endcomponent

---

@if ($session = App\Models\Session::where('status','!=','off')->first())
@if ($session->status == 'conformity')

Le temps de confirmation du dossier commence à partir de
<span style="color:green">
    {{ date('d-m-Y', strtotime($session->end_date)) }}
</span>
à
<span style="color:red">
{{ date('d-m-Y', strtotime(Carbon\Carbon::createFromDate($account->start_date)->addDays($account->periode))) }}
</span>
@else
@if ($session->status == 'interview')

Le temps des entretiens commence à partir de
<span style="color:green">
    {{ date('d-m-Y', strtotime($account->start_date)) }}
</span>
à
<span style="color:red">
{{ date('d-m-Y', strtotime(Carbon\Carbon::createFromDate($account->start_date)->addDays($account->periode))) }}
</span>
@else
@if ($session->status == 'sc_works_validation')

Le temps de validation des traveaux scientifiques commence à partir de
<span style="color:green">
    {{ date('d-m-Y', strtotime($account->start_date)) }}
</span>
à
<span style="color:red">
{{ date('d-m-Y', strtotime(Carbon\Carbon::createFromDate($account->start_date)->addDays($account->periode))) }}
</span>
@endif
@endif
@endif
@endif

---

@component('mail::button', ['url' => 'localhost:8000/login'])
Connecter
@endcomponent

Merci,<br>
Sous-directeur de personnel
@endcomponent

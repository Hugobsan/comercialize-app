@component('mail::message')
# Olá {{ $user->name }},

Sua senha foi redefinida. Sua nova senha é: **{{ $newPassword }}**

Por favor, altere sua senha após o login.

@component('mail::button', ['url' => env('APP_URL')])
Ir para a Aplicação
@endcomponent

Atenciosamente,<br>
Sua equipe
@endcomponent

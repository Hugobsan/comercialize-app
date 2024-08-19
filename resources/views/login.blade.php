@extends('layouts.auth')

@section('title', 'Login') 

@section('content')
    <h1>Login</h1>
    <form action="{{ route('autenticar') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="email" class="form-label">E-mail</label>
            <input type="email" class="form-control" id="email" name="email" placeholder="Digite seu e-mail" value="{{old('email')}}" required>
        </div>
        <div class="mb-3">
            <label for="senha" class="form-label">Senha</label>
            <div class="password-container">
                <input type="password" class="form-control" placeholder="Digite sua senha" name="password" id="password"
                    required>
                <i class="fa-solid fa-eye" id="eye"></i>
            </div>
        </div>
        <div class="mb-3 form-check">
            <input type="checkbox" class="form-check-input" id="lembrar" name="remember">
            <label class="form-check-label" for="lembrar">Manter-se conectado</label>
        </div>
        <div class="mb-3">
            <a class="forgot-password" href="#">Esqueci minha senha</a>
        </div>
        <hr>
        <button type="submit">Entrar</button>
    </form>
@endsection

@push('scripts')
@endpush

@extends('layouts.app')

@section('title', 'Usuários')

@push('styles')
    <style>
        .paginator {
            max-width: 100%;
        }
    </style>
@endpush

@section('content')
    <div class="container">
        <div class="d-flex flex-column align-content-center justify-content-center">
            <div class="topo">
                <h1>Usuários</h1>
                @can('create', App\Models\User::class)
                    <a href="{{ route('users.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus"></i> Adicionar usuário
                    </a>
                @endcan
            </div>
            <div>
                <form action="{{ route('users.index') }}" method="GET">
                    @csrf
                    <div class="row">
                        <div class="col-11">
                            <input type="text" class="form-control" name="search" placeholder="Pesquise por nome, função ou e-mail."
                                value="{{ request('search') }}">
                        </div>
                        <div class="col-1">
                            <button type="submit" class="btn-search"><i class="fas fa-search"></i></button>
                        </div>
                    </div>
                </form>
            </div>
            @include('users.components.table', ['users' => $users])
            <div class="paginator d-flex justify-content-center align-self-center">
                {{ $users->links() }}
            </div>
        </div>
    
    </div>
@endsection

@push('scripts')
    <script>
    </script>
@endpush
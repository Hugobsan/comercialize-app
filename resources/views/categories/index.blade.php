@extends('layouts.app')

@section('title', 'Produtos')

@push('styles')
    <style>
        .paginator {
            margin-top: 20px;
            max-width: 100%;
        }
    </style>
@endpush

@section('content')
    <div class="container">
        <div class="d-flex flex-column align-content-center justify-content-center">
            <div class="topo">
                <h1>Categorias</h1>
                @can('create', App\Models\Category::class)
                    <!-- Modal button -->
                    <button type="button" class="btn-new" data-bs-toggle="modal" data-bs-target="#create_category">
                        <i class="fas fa-plus"></i> Nova Categoria
                    </button>
                    <!-- Modal -->
                    @include('categories.components.create')
                @endcan
            </div>
            <div>
                <form action="{{ route('categories.index') }}" method="GET">
                    @csrf
                    <div class="row">
                        <div class="col-11">
                            <input type="text" class="form-control" name="search" placeholder="Pesquise por nome ou código"
                                value="{{ request('search') }}">
                        </div>
                        <div class="col-1">
                            <button type="submit" class="btn-search"><i class="fas fa-search"></i></button>
                        </div>
                    </div>
                </form>
            </div>
            <div class="table-responsive my-2">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Código</th>
                            <th>Nome</th>
                            <th>Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($categories as $category)
                            <tr>
                                <td><i class="{{ $category->icon }}"></i> <span style="color: {{ $category->color }}">{{ $category->code }}</span></td>
                                <td><span style="color: {{ $category->color }}">{{ $category->name }}</span></td>
                                <td>
                                    <div class="dropdown">
                                        <button class="btn btn-primary dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                                            <i class="fas fa-bars"></i>
                                        </button>
                                        <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                                            <li><a class="dropdown-item" href="{{ route('categories.show', $category->id) }}">Ver</a></li>
                                            @can('update', $category)
                                                <li><button class="dropdown-item category-edit" data-id="{{ $category->id }}">Editar</button></li>
                                            @endcan
                                            @can('delete', $category)
                                                <li>
                                                    <hr class="dropdown-divider">
                                                </li>
                                                <li class="btn-danger">
                                                    <form action="{{ route('categories.destroy', $category->id) }}" method="post" style="display: inline;">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="dropdown-item">Excluir</button>
                                                    </form>
                                                </li>
                                            @endcan
                                        </ul>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3">Nenhuma categoria encontrada</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="paginator d-flex justify-content-center align-self-center">
                {{ $categories->links() }}
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        @if ($errors->any())
            $('#create_category').modal('show');
        @endif

        $(document).ready(function() {
            const categories = @json($categories).data;
            $('.category-edit').click(function() {
                let id = $(this).data('id');
                let category = categories.find(category => category.id == id);
                console.log(category);
                editCategory(category);
                $('#createCategoryLabel').text('Editar Categoria');
                $('#create_category').modal('show');
            });
        });
    </script>
@endpush

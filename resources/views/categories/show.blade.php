@extends('layouts.app')

@section('title', $category->name)

@section('content')
    @include('categories.components.create')
    <section class="container my-3 p-3 bg-white rounded shadow">
        <div class="row">
            <div class="col-12 col-lg-9 d-flex flex-column justify-content-between">
                <div>
                    <h1>{{ $category->name }}</h1>
                    <p>{{ $category->description }}</p>
                    <div style="color: {{ $category->color ?? '#33f' }}">
                        <i class="{{ $category->icon }}"></i>
                        {{ $category->name }}
                    </div>

                </div>
            </div>
            <div class="col-md-3 d-flex flex-column justify-content-between">
                <div class="d-flex flex-row justify-content-end">
                    <div class="dropdown">
                        <button class="btn btn-primary dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fas fa-bars"></i>
                        </button>
                        <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                            <li><a class="dropdown-item" href="{{ route('categories.index') }}">Voltar</a></li>
                            @can('update', $category)
                                <li><button class="dropdown-item category-edit" data-id="{{ $category->id }}">Editar</button></li>
                            @endcan
                            @can('delete', $category)
                                <li>
                                    <hr class="dropdown-divider">
                                </li>
                                <li class="btn-danger
                            ">
                                    <form action="{{ route('categories.destroy', $category->id) }}" method="post" style="display: inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="dropdown-item">Excluir</button>
                                    </form>
                                </li>
                            @endcan
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="container my-3 p-3 bg-white rounded shadow">
        <div class="d-flex flex-row justify-content-between my-2">
            <h2>Produtos na categoria</h2>
            <button class="btn btn-danger text-white p-2">
                <i class="fas fa-file-pdf"></i> Exportar relatório
            </button>
        </div>
        <div>
            @php $products = $category->products()->paginate(4); @endphp
            <div class="row">
                @forelse($products as $product)
                    <div class="col-sm-12 col-md-4 col-lg-3">
                        @include('products.components.card_product', ['product' => $product, 'dropdown' => ['show' => true, 'edit' => false, 'delete' => false]])
                    </div>
                @empty
                    <div class="alert alert-warning" role="alert">
                        Nenhum produto vinculado a esta categoria.
                    </div>
                @endforelse
            </div>

            <div class="paginator d-flex justify-content-center align-self-center">
                {{ $products->links() }}
            </div>
        </div>
    </section>

@endsection

@push('scripts')
    <script>
        @if ($errors->any())
            let category = @json($category);
            editCategory(category);
            $('#create_category').modal('show');
        @endif

        $(document).ready(function() {
            $('.category-edit').click(function() {
                let category = @json($category);
                editCategory(category);
                $('#createCategoryLabel').text('Editar Categoria');
                $('#create_category').modal('show');
            });
        });
    </script>
@endpush

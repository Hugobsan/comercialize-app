<div class="card my-3 shadow">
    <img src="{{ $product->photo }}" class="card-img-top" alt="{{ $product->name }}" style="max-height: 36vh">
    <div class="card-body">
        <h5 class="card-title text-truncate">{{ $product->name }}</h5>
        @isset($product->category)
            <div style="color: {{ $product->category->color ?? '#33f' }}">
                <i class="{{ $product->category->icon }}"></i>
                {{ $product->category->name }}
            </div>
        @endisset
        <p class="card-text">R$ {{ $product->price }}</p>
        <p class="card-text {{ $product->quantity <= 5 ? 'text-danger' : '' }}">Estoque: {{ $product->quantity }}</p>
        <div class="d-flex flex-row justify-content-between">
            <div>
                <a href="{{ route('sales.add-to-cart', $product->id) }}" class="btn btn-success" data-bs-toggle="tooltip" title="Adicionar ao carrinho de compras">
                    <i class="fas fa-cart-plus"></i>
                </a>
            </div>
            <div class="dropdown">
                <button class="btn btn-primary dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="fas fa-bars"></i>
                </button>
                <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                    <li><a class="dropdown-item" href="{{ route('products.show', $product->id) }}">Ver</a></li>
                    @can('update', $product)
                        <li><button class="dropdown-item product-edit" data-id="{{ $product->id }}">Editar</button></li>
                    @endcan
                    @can('delete', $product)
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li class="btn-danger">
                            <form action="{{ route('products.destroy', $product->id) }}" method="post" style="display: inline;">
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

@push('scripts')
    <script>
        $(document).ready(function() {
            const products = @json($products).data;
            $('.product-edit').click(function() {
                let id = $(this).data('id');
                let product = products.find(product => product.id == id);
                editProduct(product);
                $('#createProductLabel').text('Editar Produto');
                $('#create_product').modal('show');
            });
        });
    </script>
@endpush

<div class="modal fade" id="addProductModal" tabindex="-1" role="dialog" aria-labelledby="addProductModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createProductLabel">Adicionar Produto</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('cart.add') }}" method="GET">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label for="product">Produto</label>
                        <select class="form-control" id="product" name="product_id">
                            <option value="">Selecione um produto</option>
                            @foreach ($products as $product)
                                <option value="{{ $product->id }}" data-quantity="{{$product->quantity}}">{{ $product->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="quantity">Quantidade</label>
                        <input type="number" class="form-control" id="quantity" name="quantity" min="1" max="{{$product->quantity}}" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                    <button type="submit" class="btn btn-primary" id="addProductBtn">Adicionar</button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
    <script>
        @if ($errors->any())
            $('#addProductModal').modal('show');
        @endif

        // Alterando a quantidade máxima de produtos de acordo com o produto selecionado
        $('#product').change(function() {
            let quantity = $('#product option:selected').data('quantity');
            $('#quantity').attr('max', quantity);
        });
    </script>
@endpush
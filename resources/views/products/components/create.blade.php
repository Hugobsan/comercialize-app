<!-- Modal -->
<div class="modal fade" id="create_product" tabindex="-1" aria-labelledby="createProductLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createProductLabel">Cadastrar Produto</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data" id="product_form">
                    @csrf
                    <div class="row">
                        <div class="col-sm-12 mb-3">
                            <label for="name" class="form-label">Nome</label>
                            <input type="text" class="form-control" id="name" name="name" maxlength="255" required>
                            @error('name')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12 col-md-6 mb-3">
                            <label for="photo" class="form-label">Foto</label>
                            <input type="file" class="form-control" id="photo" name="photo" required accept="image/*">
                            @error('photo')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-sm-12 col-md-6 mb-3">
                            <label for="price" class="form-label">Preço (R$)</label>
                            <input type="number" class="form-control" id="price" name="price" step="0.01" min="0" required>
                            @error('price')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        
                    </div>
                    <div class="row">
                        <div class="col-sm-12 col-md-6 mb-3">
                            <label for="category_id" class="form-label">Categoria</label>
                            <select class="form-select" id="category_id" name="category_id">
                                <option value="" selected>Selecione uma categoria</option>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                @endforeach
                            </select>
                            @error('category_id')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-sm-12 col-md-6 mb-3">
                            <label for="quantity" class="form-label">Quantidade em Estoque</label>
                            <input type="number" class="form-control" id="quantity" name="quantity" min="0" required>
                            @error('quantity')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                        <button type="submit" class="btn btn-primary">Salvar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@push('scripts')
    <script>
        //Função  preparar o modal para editar um produto
        function editProduct(product) {
            let relative_url = 'products/' + product.id;
            let url = '{{ url('') }}/' + relative_url;
            let form = document.getElementById('product_form');
            form.action = url;
            form.method = 'POST';
            form.innerHTML += '<input type="hidden" name="_method" value="PUT">';
            document.getElementById('name').value = product.name;
            document.getElementById('price').value = product.unformatted_price;
            document.getElementById('category_id').value = product.category_id;
            document.getElementById('quantity').value = product.quantity;
            document.getElementById('createProductLabel').innerText = 'Editar Produto';
            document.getElementById('photo').required = false;
            document.getElementById('photo').outerHTML = '<input type="file" class="form-control" id="photo" name="photo" accept="image/*">';
            document.getElementById('create_product').classList.add('show');
            document.getElementById('create_product').style.display = 'block';

            //Fecha o modal de edição sem submeter
            document.getElementById('create_product').addEventListener('hidden.bs.modal', function () {
                form.innerHTML = form.innerHTML.replace('<input type="hidden" name="_method" value="PUT">', '');
                document.getElementById('createProductLabel').innerText = 'Cadastrar Produto';
            });

            document.querySelector('[data-bs-dismiss="modal"]').addEventListener('click', function () {
                form.innerHTML = form.innerHTML.replace('<input type="hidden" name="_method" value="PUT">', '');
                document.getElementById('createProductLabel').innerText = 'Cadastrar Produto';
            });
        }
    </script>
@endpush
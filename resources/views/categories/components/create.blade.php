<!-- Modal -->
<div class="modal fade" id="create_category" tabindex="-1" aria-labelledby="createCategoryLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createCategoryLabel">Cadastrar Categoria</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('categories.store') }}" method="POST" enctype="multipart/form-data" id="category_form">
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
                            <label for="icon" class="form-label">Icone</label>
                            <input type="text" class="form-control" id="icon" name="icon">
                            @error('icon')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-sm-12 col-md-6 mb-3">
                            <label for="color" class="form-label">Cor</label>
                            <input type="color" class="form-control" id="color" name="color" value="#3333ff">
                            @error('color')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12 mb-3">
                            <label for="description" class="form-label">Descrição</label>
                            <textarea class="form-control" id="description" name="description" rows="3"></textarea>
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
</div>

@push('scripts')
    <script>
        //Função  preparar o modal para editar um Categoria
        function editCategory(category) {
            let relative_url = 'categories/' + category.id;
            let url = '{{ url('') }}/' + relative_url;
            let form = document.getElementById('category_form');
            form.action = url;
            form.method = 'POST';
            form.innerHTML += '<input type="hidden" name="_method" value="PUT">';
            document.getElementById('name').value = category.name;
            document.getElementById('icon').value = category.icon;
            document.getElementById('color').value = category.color;
            document.getElementById('description').value = category.description;
        }

        //Fecha o modal de edição sem submeter
        document.getElementById('create_category').addEventListener('hidden.bs.modal', function() {
            form.innerHTML = form.innerHTML.replace('<input type="hidden" name="_method" value="PUT">', '');
            document.getElementById('createCategoryLabel').innerText = 'Cadastrar Categoria';
        });

        document.querySelector('[data-bs-dismiss="modal"]').addEventListener('click', function() {
            form.innerHTML = form.innerHTML.replace('<input type="hidden" name="_method" value="PUT">', '');
            document.getElementById('createCategoryLabel').innerText = 'Cadastrar Categoria';
        });
    </script>
@endpush

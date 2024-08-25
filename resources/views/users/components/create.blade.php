<!-- Modal -->
<div class="modal fade" id="create_user" tabindex="-1" aria-labelledby="createUserLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createUserLabel">Cadastrar Produto</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('users.store') }}" method="POST" enctype="multipart/form-data" id="user_form">
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
                            <label for="email" class="form-label">E-mail</label>
                            <input type="email" class="form-control" id="email" name="email" maxlength="255" required>
                            @error('email')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-sm-12 col-md-6 mb-3">
                            <label for="role" class="form-label">Permissão</label>
                            <select class="form-select" id="role" name="role">
                                <option value="" selected>Selecione uma permissão</option>
                                <option value="admin">Administrador</option>
                                <option value="customer">Cliente</option>
                                <option value="seller">Vendedor</option>
                            </select>
                            @error('role')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12 col-md-6 mb-3">
                            <label for="password" class="form-label">Senha</label>
                            <input type="password" class="form-control" id="password" name="password" autocomplete="off" required>
                            @error('password')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-sm-12 col-md-6 mb-3">
                            <label for="password_confirmation" class="form-label">Confirmação de senha</label>
                            <input type="password" class="form-control" id="password_confirmation" autocomplete="off" name="password_confirmation" required>
                            @error('password_confirmation')
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
        function editUser(user) {
            let relative_url = 'users/' + user.id;
            let url = '{{ url('') }}/' + relative_url;
            let form = document.getElementById('user_form');
            form.action = url;
            form.method = 'POST';
            form.innerHTML += '<input type="hidden" name="_method" value="PUT">';
            document.getElementById('name').value = user.name;
            document.getElementById('email').value = user.email;
            document.getElementById('role').value = user.role;
            //Desabilitando campos de senha
            document.getElementById('password').disabled = true;
            document.getElementById('password_confirmation').disabled = true;

            //Fecha o modal de edição sem submeter
            document.getElementById('create_user').addEventListener('hidden.bs.modal', function() {
                form.innerHTML = form.innerHTML.replace('<input type="hidden" name="_method" value="PUT">', '');
                document.getElementById('createUserLabel').innerText = 'Cadastrar Usuário';
            });

            document.querySelector('[data-bs-dismiss="modal"]').addEventListener('click', function() {
                form.innerHTML = form.innerHTML.replace('<input type="hidden" name="_method" value="PUT">', '');
                document.getElementById('createUserLabel').innerText = 'Cadastrar Usuário';
            });
        }
    </script>
@endpush

<div class="table-responsive my-2">
    <table class="table table-striped table-hover">
        <thead>
            <tr>
                <th scope="col">Nome</th>
                <th scope="col">E-mail</th>
                <th scope="col">Permissões</th>
                <th scope="col">Ações</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($users as $user)
                <tr>
                    <th scope="row">{{ $user->name }}</th>
                    <td>{{ $user->email }}</td>
                    <td class="text-capitalize">{{ trans('default.' . $user->role) }}</td>
                    <td>
                        <div class="dropdown">
                            <button class="btn btn-primary dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="fas fa-bars"></i>
                            </button>
                            <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                                <li><a class="dropdown-item" href="{{ route('users.show', $user->id) }}">Ver</a></li>
                                @can('update', $user)
                                    <li><button class="dropdown-item user-edit" data-id="{{ $user->id }}">Editar</button></li>
                                @endcan
                                @can('update', $user)
                                    {{-- Botão para redefinir senha automaticamente --}}
                                    <li>
                                        <hr class="dropdown-divider">
                                    </li>
                                    <li>
                                        <form action="{{ route('users.reset', $user->id) }}" method="post" style="display: inline;">
                                            @csrf
                                            <button type="submit" class="dropdown-item">Redefinir Senha</button>
                                        </form>
                                    </li>
                                @endcan
                                @can('delete', $user)
                                    <li>
                                        <hr class="dropdown-divider">
                                    </li>
                                    <li class="btn-danger">
                                        <form action="{{ route('users.destroy', $user->id) }}" method="post" style="display: inline;">
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
                    <td colspan="4">Nenhum usuário encontrado</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@push('scripts')
    <script>
        $(document).ready(function() {
            const users = @json($users).data;
            $('.user-edit').click(function() {
                let id = $(this).data('id');
                let user = users.find(user => user.id == id);
                editUser(user);
                $('#createUserLabel').text('Editar Usuário');
                $('#create_user').modal('show');
            });
        });
    </script>
@endpush
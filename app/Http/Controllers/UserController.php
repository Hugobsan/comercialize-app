<?php

namespace App\Http\Controllers;

use App\Events\UserPasswordReset;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (!auth()->user()->can('view', User::class)) {
            toastr()->error('Você não tem permissão para acessar essa página');
            return back();
        }

        $query = request()->query();

        if ($query) {
            $users = User::where('name', 'like', '%' . $query['search'] . '%')
                ->orWhere('role', 'like', '%' . $query['search'] . '%')
                ->orWhere('email', 'like', '%' . $query['search'] . '%')
                ->orderBy('name')
                ->paginate(10)
                ->appends($query);
        } else {
            $users = User::orderBy('name')->paginate(10);
        }

        return view('users.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create() {}

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreUserRequest $request)
    {
        User::create($request->validated());
        toastr()->success('Usuário cadastrado com sucesso');
        return redirect()->route('users.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        return view('users.show', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateUserRequest $request, User $user)
    {
        $user->update($request->validated());
        toastr()->success('Usuário atualizado com sucesso');
        return redirect()->route('users.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        if (!auth()->user()->can('delete', $user)) {
            toastr()->error('Você não tem permissão para deletar esse usuário');
            return back();
        }

        $user->delete();
        toastr()->success('Usuário deletado com sucesso');
        return redirect()->route('users.index');
    }

    public function resetPassword(User $user)
    {
        if (!auth()->user()->can('update', $user)) {
            toastr()->error('Você não tem permissão para resetar a senha desse usuário');
            return back();
        }

        //Gerando senha aleatória
        $new_password = substr(str_shuffle('abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789'), 0, 8);
        $user->password = bcrypt($new_password);
        $user->save();

        // Disparar o evento para enviar o e-mail
        event(new UserPasswordReset($user, $new_password));

        toastr()->success('Senha resetada com sucesso. Um e-mail foi enviado para o usuário com a nova senha');
        return redirect()->route('users.index');
    }
}

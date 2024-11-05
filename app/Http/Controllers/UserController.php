<?php

namespace App\Http\Controllers;

use App\Repositories\UserRepository;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    protected $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function index()
    {
        $users = $this->userRepository->all();
        return response()->json($users);
    }

    public function show($id)
    {
        $user = $this->userRepository->getOne($id);
        return response()->json($user);
    }

    public function create(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'nullable|min:8',
            'role' => 'required|in:admin,teacher,student',
            'provider' => 'nullable|string',
            'provider_id' => 'nullable|string',
            'avatar' => 'nullable|url',
        ]);
        $this->userRepository->create($data);
        return response()->json(['message' => 'Usuario Criado Com sucesso'], 200);
    }

    public function update(Request $request, int $id)
    {
        $user = $this->userRepository->getOne($id);
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'email|unique:users,email,' . $id,
            'password' => 'nullable|min:8'
        ]);
        $this->userRepository->update($user, $data);
        return response()->json(['message' => 'Usuario Atualizado Com sucesso'], 200);
    }

    public function delete(int $id)
    {
        $user = $this->userRepository->getOne($id);
        $this->userRepository->delete($user);
        return response()->json(['message' => 'Usuario Deletado Com sucesso'], 204);
    }
}

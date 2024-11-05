<?php

namespace App\Http\Controllers;

use App\Repositories\UserRepository;
use App\Http\Requests\CreateUserRequest;
use App\Http\Requests\UpdateUserRequest;
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

    public function create(CreateUserRequest $request)
    {
        $data = $request->validated();
        $this->userRepository->create($data);
        return response()->json(['message' => 'Usuario Criado Com sucesso'], 200);
    }

    public function update(UpdateUserRequest $request, int $id)
    {
        $user = $this->userRepository->getOne($id);
        $data = $request->validated();
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

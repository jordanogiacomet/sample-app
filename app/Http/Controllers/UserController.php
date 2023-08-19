<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use Illuminate\Validation\ValidationException;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::query()->get();

        return new JsonResponse([
            'data' => $users
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed'
        ]);

        $user = User::create([
            'name' => $validatedData['name'],
            'email' => $validatedData['email'],
            'password' => Hash::make($validatedData['password'])
        ]);

        Auth::login($user);


        $token = $user->createToken('appToken')->plainTextToken;

        return response()->json(['user' => $user, 'token' => $token], 201);
    }


    public function login(Request $request)
    {
        $validatedData = $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string'
        ]);

        // Erro aqui, você estava usando 'email, password' ao invés de ['email', 'password']
        if (!Auth::attempt($request->only(['email', 'password']))) {
            throw ValidationException::withMessages([
                'email' => [
                    'As credenciais fornecidas estão incorretas.'
                ]
            ]);
        }

        $user = Auth::user();

        // Gere um novo token para o usuário
        $token = $user->createToken('appToken')->plainTextToken;

        return response()->json(['token' => $token], 200);
    }

    public function logout(Request $request) {
        // Obtém o usuário autenticado
        $user = Auth::user();

        // Revoga o token atual
        $user->currentAccessToken()->delete();

        return response()->json(['message' => 'Logout realizado com sucesso!'], 200);
    }


    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        return new JsonResponse([
            'data' => $user
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {

        $updated = $user->update([
            'name' => $request->name ?? $user->name,
            'email' => $request->email ?? $user->email
        ]);


        if(!$updated){
            return new JsonResponse([
                'error' => 'Failed to update model.'
            ], 400);
        }


        return new JsonResponse([
            'data' => $user
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {

        $deleted = $user->forceDelete();


        if(!$deleted){
            return new JsonResponse([
                'error' => 'Could not delete resource.'
            ], 400);
        }

        return new JsonResponse([
            'data' => 'success'
         ], 200);
    }
}

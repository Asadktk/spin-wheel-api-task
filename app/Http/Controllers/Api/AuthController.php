<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\LoginUserRequest;
use App\Http\Requests\Api\RegisterRequest;
use App\Models\User;
use App\Traits\ApiResponses;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Role;


class AuthController extends Controller
{
    use ApiResponses;

    public function login(LoginUserRequest $request)
    {

        $validatedData = $request->validated();

        if (!Auth::attempt($validatedData)) {

            return $this->error('Invalid Credentials', 401);
        }

        $user = User::firstWhere('email', $request->email);

        return $this->ok(
            'Authenticated',
            [
                'token' => $user->createToken(
                    'API token for ' . $user->email,
                    ['*'],
                    now()->addMonth()
                )->plainTextToken
            ]
        );
    }


    public function register(RegisterRequest $request)
    {

        $validated = $request->validated();

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => bcrypt($validated['password']),
        ]);

        $role = Role::where('name', $validated['role'])
            ->where('guard_name', 'api')
            ->first();

        if ($role) {
            $user->assignRole($role);
        } else {
            return $this->error([
                'message' => 'Role does not exist for the specified guard.'
            ], 400);
        }

        $token = $user->createToken(
            'API token for ' . $user->email,
            ['*']
        )->plainTextToken;

        return $this->ok(
            'User registered successfully',
            [
                'token' => $token,
                'user' => $user
            ]
        );
    }


    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return $this->ok('');
    }
}

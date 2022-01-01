<?php

namespace App\Http\Controllers;

use App\Models\User;
use Dingo\Api\Http\Request;
use Dingo\Api\Http\Response;
use Illuminate\Support\Facades\Hash;

class SignupController extends Controller
{
    public function __invoke(Request $request): Response
    {
        $request->validate([
            'name' => ['required', 'string', 'max:50'],
            'email' => ['required', 'email', 'unique:users'],
            'password' => ['required'],
        ]);

        $data = $request->all();
        $this->create($data);

        return $this->response->created();
    }

    private function create(array $data): void
    {
         User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password'])
        ]);
    }
}

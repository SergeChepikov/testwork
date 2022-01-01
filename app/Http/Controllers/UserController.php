<?php

namespace App\Http\Controllers;

use App\Models\User;
use Dingo\Api\Http\Request;
use Dingo\Api\Http\Response;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index(): Response
    {
        return $this->response->array(User::all()->toArray());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request  $request
     * @return Response
     */
    public function store(Request $request): Response
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

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return Response
     */
    public function show(int $id): Response
    {
        $user = User::findOrFail($id);

        return $this->response->array($user->toArray());
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request  $request
     * @param int $id
     * @return Response
     */
    public function update(Request $request, int $id): Response
    {
        $request->validate([
            'name' => ['string', 'max:50'],
            'email' => ['email', 'unique:users'],
        ]);

        $user = User::findOrFail($id);
        $user->update($request->only(['name', 'email']));

        return $this->response->array($user->toArray());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return Response
     */
    public function destroy(int $id): Response
    {
        User::findOrFail($id)->delete();

        return $this->response->noContent();
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

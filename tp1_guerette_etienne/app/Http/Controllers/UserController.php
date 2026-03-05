<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\User;
use App\Http\Resources\UserResource;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class UserController extends Controller
{
    public function store(StoreUserRequest $request)
    {
        try {
            $user = User::create($request->validated());
            return (new UserResource($user))->response()->setStatusCode(201);
        } catch (Exception $ex) {
            abort(500, 'Server error');
        }
    }

    public function update(UpdateUserRequest $request, string $id)
    {
        try {
            $user = User::findOrFail($id);
            $user->update($request->validated());
            return (new UserResource($user))->response()->setStatusCode(200);
        }
        catch (ModelNotFoundException $ex) {
            abort(404, 'Not found');
        }
        catch (Exception $ex) {
            abort(500, 'Server error');
        }
    }
}

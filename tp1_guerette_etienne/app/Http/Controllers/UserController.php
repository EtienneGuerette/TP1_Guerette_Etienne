<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\User;
use App\Http\Resources\UserResource;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use OpenApi\Attributes as OA;

class UserController extends Controller
{
    #[OA\Post(
        path: "/api/users",
        summary: "Créer un utilisateur",
        tags: ["User"],
        responses: [
            new OA\Response(
                response: "201",
                description: "Utilisateur créé"
            )
        ]
    )]
    public function store(StoreUserRequest $request)
    {
        try {
            $user = User::create($request->validated());
            return (new UserResource($user))->response()->setStatusCode(201);
        } catch (Exception $ex) {
            abort(500, 'Server error');
        }
    }

    #[OA\Put(
        path: "/api/users/{id}",
        summary: "Mettre à jour un utilisateur",
        tags: ["User"],
        parameters: [
            new OA\Parameter(
                name: "id",
                description: "User ID",
                in: "path",
                required: true,
                schema: new OA\Schema(type: "integer")
            )
        ],
        responses: [
            new OA\Response(
                response: "200",
                description: "Utilisateur mis à jour"
            ),
            new OA\Response(
                response: "404",
                description: "Utilisateur non trouvé"
            )
        ]
    )]
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

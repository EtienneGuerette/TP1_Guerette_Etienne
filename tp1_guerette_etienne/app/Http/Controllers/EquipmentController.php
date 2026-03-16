<?php

namespace App\Http\Controllers;

use App\Http\Resources\EquipmentResource;
use App\Models\Equipment;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Models\Review;
use OpenApi\Attributes as OA;

class EquipmentController extends Controller
{
    #[OA\Get(
        path: "/api/equipment",
        summary: "Liste de tous les equipments",
        tags: ["Equipment"],
        responses: [
            new OA\Response(
                response: "200",
                description: "OK"
            )
        ]
    )]
    public function index()
    {
        try {
            return EquipmentResource::collection(Equipment::paginate(PAGINATION))->response()->setStatusCode(200);
        } catch (Exception $ex) {
            abort(500, 'Server error');
        }
    }

    #[OA\Get(
        path: "/api/equipment/{id}",
        summary: "Afficher un equipment",
        tags: ["Equipment"],
        parameters: [
            new OA\Parameter(
                name: "id",
                description: "Equipment ID",
                in: "path",
                required: true,
                schema: new OA\Schema(type: "integer")
            )
        ],
        responses: [
            new OA\Response(
                response: "200",
                description: "OK"
            ),
            new OA\Response(
                response: "404",
                description: "Equipment non trouvé"
            )
        ]
    )]
    public function show(string $id)
    {
        try {
            return (new EquipmentResource(Equipment::findOrFail($id)))->response()->setStatusCode(200);
        }
        catch (ModelNotFoundException $ex) {
            abort(404, 'Not found');
        }
        catch (Exception $ex) {
            abort(500, 'Server error');
        }
    }

    #[OA\Get(
        path: "/api/equipment/{id}/popularity",
        summary: "Afficher la popularité d'un equipment",
        tags: ["Equipment"],
        parameters: [
            new OA\Parameter(
                name: "id",
                description: "Equipment ID",
                in: "path",
                required: true,
                schema: new OA\Schema(type: "integer")
            )
        ],
        responses: [
            new OA\Response(
                response: "200",
                description: "OK"
            ),
            new OA\Response(
                response: "404",
                description: "Equipment non trouvé"
            )
        ]
    )]
    public function popularity(string $id)
    {
        try {
            $equipment = Equipment::findOrFail($id);

            $rentals_count = $equipment->rentals()->count();
            $avg_rating = $equipment->rentals->flatMap->reviews->avg('rating') ?? 0;

            $popularity = ($rentals_count * 0.6) + ($avg_rating * 0.4);
            return response()->json(['popularity' => $popularity], 200);
        }
        catch (ModelNotFoundException $ex) {
            abort(404, 'Not found');
        }
        catch (Exception $ex) {
            abort(500, 'Server error');
        }
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Equipment;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use OpenApi\Attributes as OA;

class RentalController extends Controller
{
    #[OA\Get(
        path: "/api/rentals/{id}/average_price",
        summary: "Calculer le prix moyen d'une location",
        tags: ["Rental"],
        parameters: [
            new OA\Parameter(
                name: "id",
                description: "Equipment ID",
                in: "path",
                required: true,
                schema: new OA\Schema(type: "integer")
            ),
            new OA\Parameter(
                name: "minDate",
                description: "Date minimale",
                in: "query",
                required: false,
                schema: new OA\Schema(type: "string", format: "date")
            ),
            new OA\Parameter(
                name: "maxDate",
                description: "Date maximale",
                in: "query",
                required: false,
                schema: new OA\Schema(type: "string", format: "date")
            )
        ],
        responses: [
            new OA\Response(
                response: "200",
                description: "Prix moyen calculé"
            ),
            new OA\Response(
                response: "404",
                description: "Équipement non trouvé"
            )
        ]
    )]
    public function averagePrice($id, $minDate = null, $maxDate = null)
    {
        try {
            $equipment = Equipment::findOrFail($id);

            $rentals = $equipment->rentals();

            if ($minDate) {
                $rentals->where('start_date', '>=', $minDate);
            }

            if ($maxDate) {
                $rentals->where('end_date', '<=', $maxDate);
            }

            $avgPrice = $rentals->avg('total_price');

            return response()->json(['average_price' => $avgPrice], 200);
        }
        catch (ModelNotFoundException $ex) {
            abort(404, 'Not found');
        }
        catch (Exception $ex) {
            abort(500, 'Server error');
        }
    }
}

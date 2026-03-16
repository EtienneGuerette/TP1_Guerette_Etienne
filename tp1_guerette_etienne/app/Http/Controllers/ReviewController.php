<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Models\Review;
use OpenApi\Attributes as OA;

class ReviewController extends Controller
{
    #[OA\Delete(
        path: "/api/review/{id}",
        summary: "Supprimer une critique",
        tags: ["Review"],
        parameters: [
            new OA\Parameter(
                name: "id",
                description: "Review ID",
                in: "path",
                required: true,
                schema: new OA\Schema(type: "integer")
            )
        ],
        responses: [
            new OA\Response(
                response: "204",
                description: "Critique supprimée"
            ),
            new OA\Response(
                response: "404",
                description: "Critique non trouvée"
            )
        ]
    )]
    public function destroy(string $id)
    {
        try {
            $review = Review::findOrFail($id);
            $review->delete();
            return response()->noContent();
        } catch (ModelNotFoundException $ex) {
            abort(404, 'Not found');
        } catch (Exception $ex) {
            abort(500, 'Server error');
        }
    }
}

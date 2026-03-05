<?php

namespace App\Http\Controllers;

use App\Http\Resources\EquipmentResource;
use App\Models\Equipment;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Models\Review;

class EquipmentController extends Controller
{
    public function index()
    {
        try {
            return EquipmentResource::collection(Equipment::paginate(PAGINATION))->response()->setStatusCode(200);
        } catch (Exception $ex) {
            abort(500, 'Server error');
        }
    }

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

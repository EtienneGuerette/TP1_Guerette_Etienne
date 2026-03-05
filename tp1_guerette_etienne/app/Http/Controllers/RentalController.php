<?php

namespace App\Http\Controllers;

use App\Models\Equipment;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class RentalController extends Controller
{
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

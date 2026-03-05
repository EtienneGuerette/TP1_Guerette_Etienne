<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Models\Review;

class ReviewController extends Controller
{
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

<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;






















u
class LocationController extends Controller
{
    //
    public function choose_location(Request $request)
    {

        if ($request->filled("type") && $request->type == "manual") {
        }
    }
}

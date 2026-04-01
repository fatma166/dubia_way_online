<?php
namespace App\Http\Controllers\website;
use App\Http\Controllers\Controller;
use App\Models\Restaurant;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AboutController extends Controller
{
    public function index(Request $request)
    {

     $place= Restaurant::where('id',config('app.default_vendor'))->first();
        return view('website-views.about', compact('place'));
    }

}
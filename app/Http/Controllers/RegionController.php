<?php

namespace App\Http\Controllers;

use App\Models\City;
use App\Models\Province;
use Illuminate\Http\Request;

class RegionController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        $provinces  = Province::orderBy('created_at', 'DESC')->get();
        $cities  = City::orderBy('created_at', 'DESC')->get();

        return view('panel.region.index', compact('provinces', 'cities'));
    }
}

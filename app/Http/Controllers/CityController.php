<?php

namespace App\Http\Controllers;

use App\Models\City;
use App\Models\Province;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class CityController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $data  = City::with('province');

        return DataTables::of($data)
            ->addColumn('action', function ($data) {
                $buttons = '<div class="row">';

                $buttons .= '<div class="col"><a href="/region/cities/'. $data->id .'/edit" class="btn btn-sm btn-block btn-outline-info city-edit" title="Edit '.$data->name.'">Edit</a></div>';
                if(!$data->sale()->exists()){
                    $buttons .= '<div class="col"><a href="/region/cities/'. $data->id .'" class="btn btn-sm btn-outline-danger btn-block city-delete" title="Hapus '.$data->name.'">Hapus</a></div>';
                }

                $buttons .= '</div>';
                
                return $buttons;
            })
            ->addColumn('province', function($data){
                return $data->province->name;
            })
            ->filter(function ($instance) use ($request) {
                if (!empty($request->search)) {
                    $instance->where(function ($w) use ($request) {
                        $search = $request->search;
                        $w->orWhere('name', 'LIKE', "%$search%");
                    });
                }

                return $instance;
            })
            ->rawColumns(['action', 'province'])
            ->make(true);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $city = new City();
        $provinces = Province::pluck('name', 'id');
        return view('include.region.city.form', compact('city', 'provinces'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $messages = [
            'name.required' => 'Nama tidak boleh kosong!',
            'name.string' => ' Nama tidak boleh mengandung simbol!',
            'name.max' => ' Nama tidak boleh melebihi 255 huruf!',
            'province_id.required' => 'Provinsi tidak boleh kosong!'
        ];

        $validatedData = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'province_id' => ['required']
        ], $messages);
        
        $city = City::create($validatedData);

        return $city;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\City  $city
     * @return \Illuminate\Http\Response
     */
    public function edit(City $city)
    {
        $provinces = Province::pluck('name', 'id');
        return view('include.region.city.form', compact('city', 'provinces'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\City  $city
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, City $city)
    {
        $messages = [
            'name.required' => 'Nama tidak boleh kosong!',
            'name.string' => ' Nama tidak boleh mengandung simbol!',
            'name.max' => ' Nama tidak boleh melebihi 255 huruf!',
            'province_id.required' => 'Provinsi tidak boleh kosong!'
        ];

        $validatedData = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'province_id' => ['required']
        ], $messages);
        
        $city->update($validatedData);

        return $city;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\City  $city
     * @return \Illuminate\Http\Response
     */
    public function destroy(City $city)
    {
        return $city->delete();
    }
}

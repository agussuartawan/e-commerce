<?php

namespace App\Http\Controllers;

use App\Models\Province;
use Illuminate\Http\Request;
use DataTables;

class ProvinceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $data  = Province::query();

        return DataTables::of($data)
            ->addColumn('action', function ($data) {
                $buttons = '<div class="row">';

                $buttons .= '<div class="col"><a href="/region/provinces/'. $data->id .'/edit" class="btn btn-sm btn-block btn-outline-info modal-edit" title="Edit '.$data->name.'">Edit</a></div>';
                if(!$data->sale()->exists()){
                    $buttons .= '<div class="col"><a href="/region/provinces/'. $data->id .'" class="btn btn-sm btn-outline-danger btn-block btn-delete" title="Hapus '.$data->name.'">Hapus</a></div>';
                }

                $buttons .= '</div>';
                
                return $buttons;
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
            ->rawColumns(['action'])
            ->make(true);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $province = new Province();
        return view('include.region.province.form', compact('province'));
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
        ];

        $validatedData = $request->validate([
            'name' => ['required', 'string', 'max:255']
        ], $messages);
        
        $province = Province::create($request->all());

        return $province;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Province  $province
     * @return \Illuminate\Http\Response
     */
    public function show(Province $province)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Province  $province
     * @return \Illuminate\Http\Response
     */
    public function edit(Province $province)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Province  $province
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Province $province)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Province  $province
     * @return \Illuminate\Http\Response
     */
    public function destroy(Province $province)
    {
        //
    }
}

<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use DataTables;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('panel.category.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $category = new Category();
        return view('include.category.form', compact('category'));
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
            'name.string' => ' Nama tidak boleh melebihi 255 huruf!',
        ];

        $validatedData = $request->validate([
            'name' => ['required', 'string', 'max:255']
        ], $messages);
        
        $category = Category::create($request->all());

        return $category;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Category $category)
    {
        return view('include.category.form', compact('category'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Category $category)
    {

        $messages = [
            'name.required' => 'Nama tidak boleh kosong!',
            'name.string' => ' Nama tidak boleh mengandung simbol!',
            'name.string' => ' Nama tidak boleh melebihi 255 huruf!',
        ];

        $validatedData = $request->validate([
            'name' => ['required', 'string', 'max:255']
        ], $messages);

        $category->update($request->all());

        return $category;
    }

    public function getCategoryLists()
    {
        $data  = Category::orderBy('created_at', 'DESC')->get();

        return Datatables::of($data)
            ->addColumn('action', function ($data) {
                return '<a href="'. $data .'" class="btn btn-sm btn-block btn-info">Edit</a>';
            })
            ->rawColumns(['action'])
            ->make(true);
    }
}

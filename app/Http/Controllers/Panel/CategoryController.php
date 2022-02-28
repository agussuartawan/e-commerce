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
            'name.max' => ' Nama tidak boleh melebihi 255 huruf!',
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
            'name.max' => ' Nama tidak boleh melebihi 255 huruf!',
        ];

        $validatedData = $request->validate([
            'name' => ['required', 'string', 'max:255']
        ], $messages);

        $category->update($request->all());

        return $category;
    }

    public function destroy(Category $category)
    {
        return $category->delete();
    }

    public function getCategoryLists(Request $request)
    {
        $data  = Category::query();

        return DataTables::of($data)
            ->addColumn('action', function ($data) {
                $buttons = '<div class="row">';

                $buttons .= '<div class="col"><a href="/categories/'. $data->id .'/edit" class="btn btn-sm btn-block btn-outline-info modal-edit" title="Edit '.$data->name.'">Edit</a></div>';
                if(!$data->product()->exists()){
                    $buttons .= '<div class="col"><a href="/categories/'. $data->id .'" class="btn btn-sm btn-outline-danger btn-block btn-delete" title="Hapus '.$data->name.'">Hapus</a></div>';
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

    public function searchCategories(Request $request)
    {
        $search = $request->search;
        return Category::where('name', 'LIKE', "%$search%")->select('id', 'name')->get();
    }
}

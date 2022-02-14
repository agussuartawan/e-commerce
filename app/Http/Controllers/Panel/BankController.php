<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Models\Bank;
use Illuminate\Http\Request;
use DataTables;

class BankController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('panel.bank.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $bank = new Bank();
        return view('include.bank.form', compact('bank'));
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
            'account_number.required' => 'No rekening tidak boleh kosong!',
            'account_number.numeric' => ' No rekening tidak boleh mengandung simbol!',
            'account_number.max' => ' No rekening tidak boleh melebihi 255 huruf!',
            'account_name.required' => 'Nama rekening tidak boleh kosong!',
            'account_name.numeric' => ' Nama rekening tidak boleh mengandung simbol!',
            'account_name.max' => ' Nama rekening tidak boleh melebihi 255 huruf!',
        ];

        $validatedData = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'account_number' => ['required', 'string', 'max:255'],
            'account_name' => ['required', 'string', 'max:255'],
        ], $messages);
        
        $bank = Bank::create($validatedData);

        return $bank;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Bank  $bank
     * @return \Illuminate\Http\Response
     */
    public function edit(Bank $bank)
    {
        return view('include.bank.form', compact('bank'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Bank  $bank
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Bank $bank)
    {
        $messages = [
            'name.required' => 'Nama tidak boleh kosong!',
            'name.string' => ' Nama tidak boleh mengandung simbol!',
            'name.max' => ' Nama tidak boleh melebihi 255 huruf!',
            'account_number.required' => 'No rekening tidak boleh kosong!',
            'account_number.numeric' => ' No rekening tidak boleh mengandung simbol!',
            'account_number.max' => ' No rekening tidak boleh melebihi 255 huruf!',
            'account_name.required' => 'Nama rekening tidak boleh kosong!',
            'account_name.numeric' => ' Nama rekening tidak boleh mengandung simbol!',
            'account_name.max' => ' Nama rekening tidak boleh melebihi 255 huruf!',
        ];

        $validatedData = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'account_number' => ['required', 'string', 'max:255'],
            'account_name' => ['required', 'string', 'max:255'],
        ], $messages);
        
        $bank->update($validatedData);

        return $bank;    
    }

    public function getBankLists(Request $request)
    {
        $data  = Bank::query();

        return DataTables::of($data)
            ->addColumn('action', function ($data) {
                return '<a href="/banks/'. $data->id .'/edit" class="btn btn-sm btn-block btn-outline-info modal-edit" title="Edit '.$data->name.'">Edit</a>';
            })
            ->filter(function ($instance) use ($request) {
                if (!empty($request->search)) {
                    $instance->where(function ($w) use ($request) {
                        $search = $request->search;
                        $w->orWhere('name', 'LIKE', "%$search%")
                            ->orWhere('account_number', 'LIKE', "%$search%");
                    });
                }

                return $instance;
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    public function searchBank(Request $request)
    {
        $search = $request->search;
        return Bank::where('name', 'LIKE', "%$search%")->select('id', 'name')->get();
    }
}

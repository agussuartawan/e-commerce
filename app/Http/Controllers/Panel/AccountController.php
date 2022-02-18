<?php

namespace App\Http\Controllers\Panel;

use App\Models\Account;
use App\Models\AccountType;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AccountController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('panel.account.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        
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
            'account_type_id.required' => 'Tipe Akun tidak boleh kosong!',
            'account_number.required' => 'No Reff tidak boleh kosong!',
            'account_number.max' => 'No Reff tidak boleh lebih dari 255 karakter!',
            'name.required' => 'Nama tidak boleh kosong!',
            'name.max' => 'Nama tidak boleh lebih dari 255 karakter!',
            'description.required' => 'Deskripsi tidak boleh kosong!',
            'description.max' => 'Deskripsi tidak boleh lebih dari 255 karakter!',
        ];
        $validated = $request->validate([
            'account_type_id' => ['required'],
            'account_number' => ['required', 'max:255'],
            'name' => ['required', 'max:255'],
            'description' => ['required', 'max:255'],
        ], $messages);

        $account = Account::create($validated);

        return $account;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Account $account)
    {
        $messages = [
            'account_type_id.required' => 'Tipe Akun tidak boleh kosong!',
            'account_number.required' => 'No Reff tidak boleh kosong!',
            'account_number.max' => 'No Reff tidak boleh lebih dari 255 karakter!',
            'name.required' => 'Nama tidak boleh kosong!',
            'name.max' => 'Nama tidak boleh lebih dari 255 karakter!',
            'description.required' => 'Deskripsi tidak boleh kosong!',
            'description.max' => 'Deskripsi tidak boleh lebih dari 255 karakter!',
        ];
        $validated = $request->validate([
            'account_type_id' => ['required'],
            'account_number' => ['required', 'max:255'],
            'name' => ['required', 'max:255'],
            'description' => ['required', 'max:255'],
        ], $messages);

        $account->update($validated);

        return $validated;
    }

    public function getAccountList(Request $request)
    {
        if(!empty($request->search)){
            $account_types = AccountType::whereHas('account', function($query) use ($request){
                $search = $request->search;
                $query->where('name', 'like', "%$search%")
                ->orWhere('account_number', 'like', "%$search%")
                ->orWhere('description', 'like', "%$search%");
            })
            ->with(['account' => function($query) use ($request){
                $search = $request->search;
                $query->where('name', 'like', "%$search%")
                ->orWhere('account_number', 'like', "%$search%")
                ->orWhere('description', 'like', "%$search%");
            }])->get();
        } else {
            $account_types = AccountType::with('account')->orderBy('account_number', 'ASC')->get();
        }
        return view('include.account.list', compact('account_types'));
    }
}

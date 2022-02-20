<?php

namespace App\Http\Controllers\Panel;

use App\Models\Account;
use App\Models\AccountType;
use App\Models\TrialBalance;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
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
        $trial_balance_exists = TrialBalance::exists();
        return view('panel.account.index', compact('trial_balance_exists'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $account = new Account();
        $account_types = AccountType::pluck('name', 'id');
        $disable = false;
        
        return view('include.account.form', compact('account', 'account_types', 'disable'));
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
            'account_number.unique' => 'No Reff sudah digunakan!',
            'account_number.numeric' => 'No Reff harus berupa angka!',
            'name.required' => 'Nama tidak boleh kosong!',
            'name.max' => 'Nama tidak boleh lebih dari 255 karakter!',
            'description.required' => 'Deskripsi tidak boleh kosong!',
            'description.max' => 'Deskripsi tidak boleh lebih dari 255 karakter!',
        ];
        $validated = $request->validate([
            'account_type_id' => ['required'],
            'account_number' => ['required', 'numeric', 'max:255', 'unique:accounts'],
            'name' => ['required', 'max:255'],
            'description' => ['required', 'max:255'],
        ], $messages);
        $validated['account_number'] = AccountType::find($validated['account_type_id'])->id . '-' . $validated['account_number'];

        $account = Account::create($validated);

        return $account;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Account $account)
    {
        $account_types = AccountType::pluck('name', 'id');
        if($account->accountUsed()){
            $disable = false;
        } else {
            $disable = true;
        }
        return view('include.account.form', compact('account', 'account_types', 'disable'));
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
            'account_number.unique' => 'No Reff sudah digunakan!',
            'name.required' => 'Nama tidak boleh kosong!',
            'name.max' => 'Nama tidak boleh lebih dari 255 karakter!',
            'description.required' => 'Deskripsi tidak boleh kosong!',
            'description.max' => 'Deskripsi tidak boleh lebih dari 255 karakter!',
        ];
        $validated = $request->validate([
            'account_type_id' => ['required'],
            'account_number' => ['required', 'max:255', Rule::unique('accounts')->ignore($account->id)],
            'name' => ['required', 'max:255'],
            'description' => ['required', 'max:255'],
        ], $messages);

        $account->update($validated);

        return $validated;
    }

    public function destroy(Account $account)
    {
        return $account->delete();
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

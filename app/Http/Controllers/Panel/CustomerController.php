<?php

namespace App\Http\Controllers\Panel;

use DataTables;
use App\Models\User;
use App\Models\Customer;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('panel.customer.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $customers = new Customer();
        return view('include.customer.create', compact('customers'));
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
            'fullname.required' => 'Nama tidak boleh kosong!',
            'fullname.string' => ' Nama tidak boleh mengandung simbol!',
            'fullname.max' => ' Nama tidak boleh melebihi 255 huruf!',
            'address.required' => 'Alamat tidak boleh kosong!',
            'phone.required' => 'No telpon tidak boleh kosong!',
            'email.required' => 'Email tidak boleh kosong!',
            'email.email' => 'Email tidak valid!',
            'email.unique' => 'Silahkan coba email lain!' 
        ];

        $validatedData = $request->validate([
            'fullname' => ['required', 'string', 'max:255'],
            'address' => ['required'],
            'phone' => ['required'],
            'email' => ['required', 'email', 'unique:users,email']
        ], $messages);

        $user =  User::create([
            'name' => $validatedData['fullname'],
            'email' => $validatedData['email'],
            'password' => Hash::make($validatedData['email']),
        ]);

        $user->assignRole('Pelanggan');

        $customer = Customer::create([
            'fullname' => $validatedData['fullname'],
            'address' => $validatedData['address'],
            'phone' => $validatedData['phone'],
            'user_id' => $user->id,
        ]);

        return $customer;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function edit(Customer $customer)
    {
        return view('include.customer.edit', compact('customer'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Customer $customer)
    {
        $messages = [
            'fullname.required' => 'Nama tidak boleh kosong!',
            'fullname.string' => ' Nama tidak boleh mengandung simbol!',
            'fullname.max' => ' Nama tidak boleh melebihi 255 huruf!',
            'address.required' => 'Alamat tidak boleh kosong!',
            'phone.required' => 'No telpon tidak boleh kosong!',
        ];

        $validatedData = $request->validate([
            'fullname' => ['required', 'string', 'max:255'],
            'address' => ['required'],
            'phone' => ['required'],
        ], $messages);

        $customer->update($validatedData);

        return $customer;
    }

    public function getCustomerLists(Request $request)
    {
        $data  = Customer::with('user');

        return DataTables::of($data)
            ->addColumn('email', function ($data) {
                return $data->user->email;
            })
            ->addColumn('action', function ($data) {
                $buttons = '<a href="/customers/'. $data->id .'/edit" class="btn btn-sm btn-outline-info btn-block modal-edit" title="Edit '.$data->fullname.'">Edit</a>';

                return $buttons;
            })
            ->filter(function ($instance) use ($request) {
                if (!empty($request->search)) {
                    $instance->join('users', 'users.id', '=','customers.user_id')->where(function ($w) use ($request) {
                        $search = $request->search;
                        $w->orwhere('customers.fullname', 'LIKE', "%$search%")
                            ->orwhere('customers.address', 'LIKE', "%$search%")
                            ->orwhere('customers.phone', 'LIKE', "%$search%")
                            ->orWhere('email', 'LIKE', "%$search%");
                    });
                }

                return $instance;
            })
            ->rawColumns(['action', 'email'])
            ->make(true);
    }

    public function searchCustomer(Request $request)
    {
        $search = $request->search;
        return Customer::where('fullname', 'LIKE', "%$search%")->select('id', 'fullname', 'address')->get();
    }
}

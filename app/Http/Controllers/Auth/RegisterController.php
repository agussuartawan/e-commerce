<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\Models\User;
use App\Models\Customer;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        $messages = [
            'name.required' => 'Username tidak boleh kosong!',
            'name.string' => 'Username harus terdiri dari huruf!',
            'name.max' => 'Username tidak boleh melebihi 255 huruf!',
            'email.email' => 'Format email tidak valid!',
            'email.max' => 'Email tidak boleh melebihi 255 digit!',
            'email.unique' => 'Email tidak tersedia!',
            'password.required' => 'Password tidak boleh kosong!',
            'password.min' => 'Password minimal adalah 6!',
            'password.confirmed' => 'Password tidak cocok!',
        ];
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:6', 'confirmed'],
            'address' => ['required'],
            'phone' => ['required'],
        ], $messages);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    protected function create(array $data)
    {
        $user =  User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);

        Customer::create([
            'fullname' => $data['name'],
            'phone' => $data['phone'],
            'address' => $data['address'],
            'user_id' => $user->id
        ]);

        $user->assignRole('Pelanggan');

        return $user;
    }
}

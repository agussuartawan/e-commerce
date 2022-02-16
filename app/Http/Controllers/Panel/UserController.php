<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Spatie\Permission\Models\Role;
use Yajra\DataTables\Facades\DataTables;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('panel.user.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $user = new User();
        $roles = Role::pluck('name', 'id');
        return view('include.user.create', compact('user', 'roles'));
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
            'name.required' => 'Username tidak boleh kosong!',
            'name.string' => 'Username harus terdiri dari huruf!',
            'name.max' => 'Username tidak boleh melebihi 255 huruf!',
            'email.email' => 'Format email tidak valid!',
            'email.required' => 'Email tidak boleh kosong!',
            'email.max' => 'Email tidak boleh melebihi 255 digit!',
            'email.unique' => 'Email tidak tersedia!',
            'password.required' => 'Password tidak boleh kosong!',
            'password.min' => 'Password minimal adalah 6!',
            'password.confirmed' => 'Password tidak cocok!',
            'role.required' => 'Hak akses tidak boleh kosong!'
        ];

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:6', 'confirmed'],
            'role' => ['required']
        ], $messages);

        $validated['password'] = Hash::make($request->password);

        $user = User::create($validated);
        if($request->role){
            $user->assignRole($validated['role']);
        }

        return $user;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        return view('include.user.show', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        if($user->id == auth()->user()->id){
            return false;
        }
        $roles = Role::pluck('name', 'id');
        return view('include.user.edit', compact('user', 'roles'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        if($user->id == auth()->user()->id){
            return false;
        }
        $messages = [
            'name.required' => 'Username tidak boleh kosong!',
            'name.string' => 'Username harus terdiri dari huruf!',
            'name.max' => 'Username tidak boleh melebihi 255 huruf!',
            'email.email' => 'Format email tidak valid!',
            'email.max' => 'Email tidak boleh melebihi 255 digit!',
            'email.unique' => 'Email tidak tersedia!',
            'role.required' => 'Hak akses tidak boleh kosong!'
        ];

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'role' => ['required']
        ], $messages);

        $user->update($validated);
        if($request->role){
            $user->syncRoles([$validated['role']]);
        }

        return $user;
    }

    public function getUserList(Request $request)
    {
        $data  = User::where('id', '!=', 1)->where('id', '!=',  auth()->user()->id);

        return DataTables::of($data)
            ->addColumn('action', function ($data) {
                $buttons = '<div class="row"><div class="col">';
                $buttons .= '<a href="/users/'. $data->id .'" class="btn btn-sm btn-outline-success btn-block btn-show" title="Detail '.$data->name.'">Detail</a>';
                $buttons .= '</div><div class="col">';
                $buttons .= '<a href="/users/'. $data->id .'/edit" class="btn btn-sm btn-outline-info btn-block modal-edit" title="Edit '.$data->name.'">Edit</a>';
                $buttons .= '</div></div>';

                return $buttons;
            })
            ->addColumn('created_at', function($data){
                return Carbon::parse($data->created_at)->isoFormat('DD MMMM Y');
            })
            ->addColumn('role', function($data){
                return $data->getRoleNames()[0] ?? '';
            })
            ->filter(function ($instance) use ($request) {
                if (!empty($request->search)) {
                    $instance->where(function ($w) use ($request) {
                        $search = $request->search;
                        $w->orwhere('name', 'LIKE', "%$search%")
                            ->orwhere('email', 'LIKE', "%$search%");
                    });
                }

                return $instance;
            })
            ->rawColumns(['action', 'created_at', 'role'])
            ->make(true);
    }

    public function searchRoles(Request $request)
    {
        $search = $request->search;
        return Role::where('name', 'LIKE', "%$search%")->where('id', '!=', '5')->select('id', 'name')->get();
    }
}

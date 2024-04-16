<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\Models\User;
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
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'phone' => ['required', 'numeric', 'min:8'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],

        ]);
    }
    public function permissions_update($request, $user)
    {
        switch ($user->role) {
            case 'admin':
                $request->create_users == null ? $user->givePermissionTo('create_users') : $user->revokePermissionTo("create_users");
                $request->view_users == null ? $user->givePermissionTo('view_users') : $user->revokePermissionTo("view_users");
                $request->update_users == null ? $user->givePermissionTo('update_users') : $user->revokePermissionTo("update_users");
                $request->delete_users == null ? $user->givePermissionTo('delete_users') : $user->revokePermissionTo("delete_users");
                break;
    
            case 'customer':
                $request->view_users == null ? $user->givePermissionTo('view_users') : $user->revokePermissionTo("view_users");
                break;
    
            default:
                return back()->with('error', 'Invalid role.');
        }
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    protected function create(array $data)
    {
        $user = new User();
        $user->name = $data['name'];
        $user->email = $data['email'];
        $user->password = Hash::make($data['password']);
        $user->role = $data['role'];
        $user->phone = $data['phone'];
    
        if ($user->save()) {
            $this->permissions_update(request(), $user);
            return $user;
        }
    
        return redirect('/register')->with('error', 'Something went wrong.');
    }
}

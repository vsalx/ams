<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\DB;

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
    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    function get_enum_values($table, $field)
    {
        //todo maybe make this smarter
        $test=DB::select(DB::raw("show columns from {$table} where field = '{$field}'"));

        preg_match('/^enum\((.*)\)$/', $test[0]->Type, $matches);
        foreach( explode(',', $matches[1]) as $value )
        {
            $typeEnum[] = trim( $value, "'" );
        }

        return $typeEnum;

    }

    //override
    public function showRegistrationForm()
    {
        $enumTypes = $this->get_enum_values('users', 'type');
        return view('auth.register')->with('enumTypes', $enumTypes);
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
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
            'type' => $data['type'],
        ]);
    }

    public function myform()

    {

        $users = User::pluck('name', 'id');

        return view('myForm',compact('users'));

    }
}

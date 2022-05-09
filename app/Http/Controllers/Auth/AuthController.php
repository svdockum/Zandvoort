<?php

namespace App\Http\Controllers\Auth;

use App\User;
use Auth;
use Validator;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ThrottlesLogins;
//use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Registration & Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users, as well as the
    | authentication of existing users. By default, this controller uses
    | a simple trait to add these behaviors. Why don't you explore it?
    |
    */

    use AuthenticatesUsers, ThrottlesLogins;

    /**
     * Where to redirect users after login / registration.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Create a new authentication controller instance.
     *
     * @return void
     */
    public function __construct()
    {
       // $this->middleware('guest', ['except' => 'logout']);

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
            'name' => 'required|max:255',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|confirmed|min:6',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return User
     */
    protected function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
            'role' => $data['role']
        ]);
    }

     protected function createRedirect(Request $request)
    {
        $redirect = $request->input('redirect');
      
        if (empty($request->input('name')) || empty($request->input('email')) || empty($request->input('password')) ) {
         
           return redirect('/user/create');
            //flash error
        }
        else {
        $user = User::firstOrCreate([
            
            'email' => $request->input('email'),
        ]);
        
        $user->name = $request->input('name');
        $user->password = bcrypt($request->input('password'));
        $user->role = $request->input('role');
        $user->save();
       
        return redirect($redirect);
       }
    }

    public function updateUser(Request $request,$id) {

        $redirect = '/user/overview';//$request->input('redirect');
          
        if (empty($request->input('name')) || empty($request->input('email'))) {
         
           return redirect($redirect);
            //flash error
        }
        else {


        $user = User::find($id);
        $user->name = $request->input('name');
        $user->email =  $request->input('email');
        $user->role = $request->input('role');
        $user->save();

        if (!empty($request->input('password'))) {
        $user->password = bcrypt($request->input('password'));
        $user->save();
        }

        return redirect($redirect);
       }


    }

      public function deleteUser(Request $request,$id) {

        $redirect = '/user/overview';//$request->input('redirect');
    
        $ownuser = Auth::user();
        
        if ($ownuser->id != $id) {
            $user = User::find($id);
            $user->delete();
        }
        else {
            //f;ash cant delete yourself
        }

        return redirect($redirect);
    }
}

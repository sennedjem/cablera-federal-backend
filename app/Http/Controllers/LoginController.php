<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use App\Models\User;
use Lang;

/**
 * @resource Auth
 *
 */
class LoginController extends Controller 
{
    use AuthenticatesUsers;

    /**
     * Create a new controller instance.
     */
    public function __construct(){
        //$this -> middleware('tenant.db.transaction') -> only(['login', 'logout']);
    }

    public function username() {
        return 'name';
    }

    /**
     * Login
     *
     * Customer Login using JWT.
     *
     */
    public function login(Request $request) {

        $this->validateLogin($request);

        if ($this->hasTooManyLoginAttempts($request)) {
            $this->fireLockoutEvent($request);

            return $this->sendLockoutResponse($request);
        }

        $credentials = $this->credentials($request);
        $customer = User::where($this->username(), $credentials[$this->username()])->first();

        //dd($customer);

        if ($token = $this->guard()->attempt($credentials)) {
            return $this->sendLoginResponse($request, $token);
        }

        $this->incrementLoginAttempts($request);

        return $this->sendFailedLoginResponse($request);
    }

    /**
     * Logout
     *
     * Customer Logout using JWT.
     *
     */
    public function logout() {
        $this->guard()->logout(); // pass true to blacklist forever
        return response()->json(['message' => 'Logged out']);
    }

    protected function sendLoginResponse(Request $request, $token) {
        $this->clearLoginAttempts($request);
        return $this->authenticated($request, $this->guard()->user(), $token);
    }

    protected function sendFailedLoginResponse(Request $request) {
        return response()->json(['message' => Lang::get('auth.failed')], 401);
    }


    protected function authenticated(Request $request, $user, $token) {
        $userArray = $user->toArray();
        $userArray['token'] = $token;
        return response()->json($userArray);

        /*
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => config('jwt.ttl') * 60 // config value is in minutes
        ]);
        */
    }

}

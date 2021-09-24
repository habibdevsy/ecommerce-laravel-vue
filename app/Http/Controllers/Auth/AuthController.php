<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Role;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    private $scope;

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required',
            'password' => 'required',
            // 'role' => 'required',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password)
        ]);

        $role = new Role();
        $role->role = 'user';
        $user->role()->save($role);
        $token = $user->createToken($user->email.'-'.now())->accessToken;

    	$success['name'] = $user->name;
    	$success['token'] = $user->createToken('MyApp')->accessToken;
    	return response()->json(['success' => $success], 201);
    }

    public function registerAdmin(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required',
            'password' => 'required',
            // 'role' => 'required',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password)
        ]);

        $role = new Role();
        $role->role = 'admin';
        $user->role()->save($role);
        $token = $user->createToken($user->email.'-'.now())->accessToken;

    	$success['name'] = $user->name;
    	$success['token'] = $user->createToken('MyApp')->accessToken;
    	return response()->json(['success' => $success], 200);
    }

    public function login(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'email' => 'required|exists:users',
            'password' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json(['data'=>'this user not found!','msg'=>'error'],200);
           };

        if( Auth::attempt(['email'=>$request->email, 'password'=>$request->password]) ) {
            $user = Auth::user();

            $userRole = $user->role()->first();

            if ($userRole) {
                $this->scope = $userRole->role;
            }

            $token = $user->createToken($user->email.'-'.now(),[$this->scope]);

            // return response()->json([
            //     'token' => $token->accessToken
            // ]);
               return response()->json([
                    'token' => $token->accessToken,
                    'token_type' => 'Bearer',
                    'expires_at' => Carbon::parse(
                        $token->token->expires_at
                    )->toDateTimeString()
                ]);
        }
    }

    public function logout(Request $request)
    {
        $request->user()->token()->revoke();
        return response()->json([
            'message' => 'Successfully logged out'
        ]);
    }

    /**
     * Get the authenticated User
     *
     * @return [json] user object
     */
    public function user(Request $request)
    {
        $request->user()->token();
        return response()->json($request->user());
    }
}

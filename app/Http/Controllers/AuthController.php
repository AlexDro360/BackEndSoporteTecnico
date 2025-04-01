<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Validator;

class AuthController extends Controller
{
    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login', 'register']]);
    }
 
 
    /**
     * Register a User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function register() {
        //$this->authorize("create",User::class);
        $validator = Validator::make(request()->all(), [
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:8',
        ]);
 
        if($validator->fails()){
            return response()->json($validator->errors()->toJson(), 400);
        }
 
        $user = new User;
        $user->name = request()->name;
        $user->email = request()->email;
        $user->password = bcrypt(request()->password);
        $user->save();
 
        return response()->json($user, 201);
    }
 
 
    /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login()
    {
        $credentials = request(['email', 'password']);
 
        if (! $token = auth('api')->attempt($credentials)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }
 
        return $this->respondWithToken($token);
    }
 
    /**
     * Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     */

    /**
    *public function me()
    *{
    *    return response()->json(auth('api')->user());
    *}
    */
 
    public function me() 
{
    $user = auth('api')->user();

    if (!$user) {
        return response()->json(['error' => 'No autenticado'], 401);
    }

    // Buscar el nombre del rol usando el role_id
    $roleName = Role::find($user->role_id)?->name ?? 'Sin rol';

    return response()->json([
        'id' => $user->id,
        'email'=> $user->email,
        'full_name' => $user->name . ' ' . $user->surname,
        'phone'=> $user->phone,
        'role_name' => $roleName,
        'departamento_id'=> $user->departamento ? $user->departamento->nombre : 'Sin departamento',
        'num_empleado'=> $user->num_empleado,
        'avatar' => $user->avatar ? asset("storage/" . $user->avatar) : 'https://static.vecteezy.com/system/resources/previews/000/439/863/original/vector-users-icon.jpg',
        'created_format_at' => $user->created_at->format("Y-m-d h:i A"),
    ]);
}


    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        auth('api')->logout();
 
        return response()->json(['message' => 'Successfully logged out']);
    }
 
    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        return $this->respondWithToken(auth('api')->refresh());
    }
 
    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth('api')->factory()->getTTL() * 60,
            'user' => [
                "full_names" => auth("api")->user()->name.''.auth("api")->user()->surname,
                "email" => auth("api")->user()->email,
                // "avatar"
            ]
        ]);
    }
}

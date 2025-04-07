<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use App\Models\User;
use Illuminate\Support\Facades\Storage;


class UserAccessController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->get("search");

        // $users = User::where("name","like","%".$search."%")->orderBy("id","desc")->paginate(25);
        // $nombreDepartamento = $users->departamento ? $users->departamento->nombre : 'Sin departamento';
        $users = User::with('departamento')
            ->where("name", "like", "%" . $search . "%")
            ->orderBy("id", "desc")
            ->paginate(25);

        return response()->json([
            "total" => $users->total(),
            "users" => $users->map(function ($user) {
                return [
                    "id" => $user->id,
                    'name' => $user->name,
                    'email' => $user->email,
                    'surname' => $user->surname,
                    'full_name' => $user->name . ' ' . $user->surname,
                    'phone' => $user->phone,
                    'role_id' => $user->role_id,
                    'role' => $user->role,
                    'roles' => $user->roles,
                    'departamento_id' =>  $user->departamento ? $user->departamento->nombre : 'Sin departamento',
                    'num_empleado' => $user->num_empleado,
                    //'avatar'=> $user->avatar ? env("APP_URL")."storage/".$user->avatar : 'https://static.vecteezy.com/system/resources/previews/000/439/863/original/vector-users-icon.jpg',
                    'avatar' => $user->avatar ? asset("storage/" . $user->avatar) : 'https://static.vecteezy.com/system/resources/previews/000/439/863/original/vector-users-icon.jpg',
                    'status' => $user->status,
                    'created_format_at' => $user->created_at->format("Y-m-d h:i A"),
                ];
            }),
        ]);
    }

    public function config()
    {
        return response()->json([
            "roles" => Role::all(),
        ]);
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $USER_EXITS = User::where("email", $request->email)->first();
        if ($USER_EXITS) {
            return response()->json([
                "message" => 403,
                "message_text" => "EL USUARIO YA EXISTE"
            ]);
        }

        if ($request->hasFile("imagen")) {
            $path = Storage::putFile("users", $request->file("imagen"));
            $request->request->add(["avatar" => $path]);
        }

        if ($request->password) {
            $request->request->add(["password" => bcrypt($request->password)]);
        }

        $request->request->add(["status" => 1]);
        $role = Role::findOrFail($request->role_id);
        $user = User::create($request->all());
        $user->assignRole($role);

        $user->load('departamento');

        return response()->json([
            "message" => 200,
            "user" => [
                "id" => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'surname' => $user->surname,
                'full_name' => $user->name . ' ' . $user->surname,
                'phone' => $user->phone,
                'role_id' => $user->role_id,
                'role' => $user->role,
                'roles' => $user->roles,
                'departamento_id' => $user->departamento ? $user->departamento->nombre : 'Sin departamento',
                'num_empleado' => $user->num_empleado,
                'avatar' => $user->avatar ? asset("storage/" . $user->avatar) : 'https://static.vecteezy.com/system/resources/previews/000/439/863/original/vector-users-icon.jpg',
                'status' => $user->status,
                'created_format_at' => $user->created_at->format("Y-m-d h:i A"),
            ]
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $USER_EXITS = User::where("email", $request->email)
            ->where("id", "<>", $id)->first();
        if ($USER_EXITS) {
            return response()->json([
                "message" => 403,
                "message_text" => "EL USUARIO YA EXISTE"
            ]);
        }

        $user = User::findOrFail($id);

        if ($request->hasFile("imagen")) {
            if ($user->avatar) {
                Storage::delete($user->avatar);
            }
            $path = Storage::putFile("users", $request->file("imagen"));
            $request->request->add(["avatar" => $path]);
        }

        if ($request->password) {
            $request->request->add(["password" => bcrypt($request->password)]);
        }

        if ($request->role_id != $user->role_id) {
            // EL VIEJO ROL
            $role_old = Role::findOrFail($user->role_id);
            $user->removeRole($role_old);

            // EL NUEVO ROL
            $role = Role::findOrFail($request->role_id);
            $user->assignRole($role);
        }
        $user->load('departamento');

        $user->update($request->all());

        return response()->json([
            "message" => 200,
            "user" => [
                "id" => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'surname' => $user->surname,
                'full_name' => $user->name . ' ' . $user->surname,
                'phone' => $user->phone,
                'role_id' => $user->role_id,
                'role' => $user->role,
                'roles' => $user->roles,
                'departamento_id' => $user->departamento ? $user->departamento->nombre : 'Sin departamento',
                'num_empleado' => $user->num_empleado,
                'avatar' => $user->avatar ? env("APP_URL") . "storage/" . $user->avatar : 'https://static.vecteezy.com/system/resources/previews/000/439/863/original/vector-users-icon.jpg',
                'created_format_at' => $user->created_at->format("Y-m-d h:i A"),
            ]
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request,string $id)
    {
        $user = User::findOrFail($id);

        $user->update(['status' => 0]);

        return response()->json([
            "message" => 200,
            "message_text" => "Usuario desactivado correctamente"
        ]);
    }
}

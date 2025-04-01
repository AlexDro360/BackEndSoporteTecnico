<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
// use Spatie\Permission\Models\Role;
use App\Models\Departamento;
// use Illuminate\Support\Facades\Storage;


class DepartamentoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $departamento=Departamento::all();
        $data=[
            'departamento'=>$departamento,
            'status'=>200
        ];
        return response()->json($data,200);
        // $search = $request->get("search");

        // $departamento = Departamento::where("nombre","like","%".$search."%")->orderBy("id","desc")->paginate(25);

        // return response()->json([
        //     "total" => $departamento->total(),
        //     "departamentos" => $departamentos->map(function($departamento) {
        //         return[
        //             "id" => $departamento->id,
        //             'nombre'=> $departamento->nombre,
        //         ];
        //     }),
        // ]);
    }

    public function config(){
        return response()->json([
            "roles" => Role::all(),
        ]);
    }


    /**
     * Store a newly created resource in storage.
     */
    // public function store(Request $request)
    // {
    //     $DEPARTAMENtO_EXITS = Departamento::where("id", $request->id)->first();
    //     if($DEPARTAMENTO_EXITS){
    //         return response()->json([
    //             "message" => 403,
    //             "message_text" => "EL DEPARTAMENTO YA EXISTE"
    //         ]);
    //     }

    //     return response()->json([
    //         "message" => 200,
    //         "departamento" => [
    //             "id" => $departamento->id,
    //             'nombre'=> $departamento->nombre ,
    //         ]
    //     ]);
    // }

    /**
     * Display the specified resource.
     */
    // public function show(string $id)
    // {
    //     //
    // }

    /**
     * Update the specified resource in storage.
     */
    // public function update(Request $request, string $id)
    // {
    //     $USER_EXITS = User::where("email", $request->email)
    //                     ->where("id","<>",$id)->first();
    //     if($USER_EXITS){
    //         return response()->json([
    //             "message" => 403,
    //             "message_text" => "EL USUARIO YA EXISTE"
    //         ]);
    //     }

    //     $user = User::findOrFail($id);

    //     if($request->hasFile("imagen")){
    //         if($user->avatar){
    //             Storage::delete($user->avatar);
    //         }
    //         $path = Storage::putFile("users", $request->file("imagen"));
    //         $request->request->add(["avatar" => $path]);
    //     }

    //     if($request->password){
    //         $request->request->add(["password" => bcrypt($request->password)]);
    //     }

    //     if($request->role_id != $user->role_id){
    //         // EL VIEJO ROL
    //         $role_old = Role::findOrFail($user->role_id);
    //         $user->removeRole($role_old);

    //         // EL NUEVO ROL
    //         $role = Role::findOrFail($request->role_id);
    //         $user->assignRole($role);
    //     }

    //     $user->update($request->all());

    //     return response()->json([
    //         "message" => 200,
    //         "user" => [
    //             "id" => $user->id,
    //             'name'=> $user->name ,
    //             'email'=> $user->email ,
    //             'surname'=> $user->surname,
    //             'full_name' => $user->name.' '.$user->surname,
    //             'phone'=> $user->phone,
    //             'role_id'=> $user->role_id,
    //             'role'=> $user->role,
    //             'roles'=> $user->roles,
    //             'departamento_id'=> $user->departamento_id,
    //             'num_empleado'=> $user->num_empleado,
    //             'avatar'=> $user->avatar ? env("APP_URL")."storage/".$user->avatar : 'https://static.vecteezy.com/system/resources/previews/000/439/863/original/vector-users-icon.jpg',
    //             'created_format_at' => $user->created_at->format("Y-m-d h:i A"),
    //         ]
    //     ]);
    // }

    /**
     * Remove the specified resource from storage.
     */
    // public function destroy(string $id)
    // {
    //     $user = User::findOrFail($id);
    //     if($user->avatar){
    //         Storage::delete($user->avatar);
    //     }
    //     $user->delete();
    //     return response()->json([
    //         "message" => 200,
    //     ]);
    // }
}

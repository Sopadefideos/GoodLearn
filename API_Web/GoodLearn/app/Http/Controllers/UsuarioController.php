<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\{Usuario, Rol};
use App\Http\Requests\CreateUserRequest;
use App\Http\Requests\UpdateUserRequest;
require_once('lib\prettyPrint.php');

class UsuarioController extends Controller
{
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {   
        $data = Usuario::all();
        $users = prettyUser($data);
        return $users;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateUserRequest $request)
    {
        $input = $request->all();
        $input['password'] = Hash::make($request->password);
        Usuario::create($input);
        return response()->json([
            'res' => true,
            'msg' => 'Usuario creado correctamente'
        ], 200);
    }

    public function byIndex(Usuario $usuario)
    {   
        $data = $usuario;
        $rol_id = $data->rol_id;
        $rol = Rol::find($rol_id);
        $data->rol_id = $rol;
        return $data; 
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        if($request->text){
            $usuarios = Usuario::where('name', 'like', '%' . $request->text . '%')->orWhere('email', 'like', '%' . $request->text . '%')->get();
        }else{
            $usuarios = Usuario::all();
        }

        $usuarios = prettyUser($usuarios);

        return $usuarios;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateUserRequest $request, Usuario $usuario)
    {   
        
        $input = $request->all();
        if($request->password != null){
            $input['password'] = Hash::make($request->password);
        }
        if($request->email == null){
            $input['email'] = $usuario->email;
        }
        
        $usuario->update($input);
        return response()->json([
            'res' => true,
            'msg' => 'Usuario actualizado correctamente'
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Usuario $usuario)
    {   
        $usuario->delete();
        return response()->json([
            'res' => true,
            'msg' => 'Usuario eliminado correctamente'
        ], 200);
    }

    public function login(Request $request){
        if($request->session()->exists('data')){
            return redirect('/');
        }

        $credencials = $this->validate(request(), [
            'email' => 'email|required|string',
            'password' => 'required|string'
        ]);
        
        if(Usuario::where('email', $credencials['email'])->exists()){
            
            $user = Usuario::where('email', $credencials['email'])->get();
            foreach($user as $valor){
                $password = $valor->password;
            }
            if (Hash::check($credencials['password'], $password)) {
                
                foreach($user as $valor){
                    $valores = ['rol' => $valor->rol_id,
                        'name' => $valor->name,
                        'email' => $valor->email
                    ];
                }
                $request->session()->put('data', $valores); 
                return redirect('/');
            }else{
                return 'La contraseña no coincide';
            }  
        }else{
            return 'el email no coincide';
        }

        return 'error en la autenticacion';
         
    }

    public function logout(Request $request){
        session()->forget('data');
        return redirect('/');
        
    }
}

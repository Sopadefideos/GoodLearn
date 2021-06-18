<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use App\Models\{Usuario, Rol};
use App\Http\Requests\CreateUserRequest;
use App\Http\Requests\UpdateUserRequest;
require_once('lib/prettyPrint.php');

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
        if($input['password'] == $input['password2']){
            $input['password'] = Hash::make($request->password);
            Usuario::create($input);
            response()->json([
                'res' => true,
                'msg' => 'Usuario creado correctamente'
            ], 200);
            return redirect()->back()->with('alert', 'Usuario Creado.');
        }else{
            return redirect()->back()->with('alert', 'La contraseña no coincide.');
        }
        
    }

    public function byIndex(Usuario $usuario)
    {   
        return prettyUser($usuario); 
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
            if($input['password'] == $input['password2']){
                $input['password'] = Hash::make($request->password);
            }else{
                response()->json([
                    'res' => true,
                    'msg' => 'Contraseña no coinciden'
                ], 200);
                return redirect()->back()->with('alert', 'La contraseña no coincide.');
            }
        }else{
            $input['password'] = $usuario->password;
        }
        
        if($request->email == null){
            $input['email'] = $usuario->email;
        }

        if($request->name == null){
            $input['name'] = $usuario->name;
        }

        if($request->telefono == null){
            $input['telefono'] = $usuario->telefono;
        }

        if($request->direccion == null){
            $input['direccion'] = $usuario->direccion;
        }

        if($request->rol == null){
            $input['rol'] = $usuario->rol_id;
        }else{
            $newRol = Rol::where('name', 'like', '%' . $input['rol'] . '%')->get();
            $input['rol'] = $newRol[0]['id'];
        }
        $usuario->name = $input['name'];
        $usuario->password = $input['password'];
        $usuario->rol_id = $input['rol'];
        $usuario->direccion = $input['direccion'];
        $usuario->telefono = $input['telefono'];
        $usuario->email = $input['email'];
        $usuario->update();
        response()->json([
            'res' => true,
            'msg' => 'Usuario actualizado correctamente'
        ], 200);
        return redirect()->back()->with('alert', 'Usuario actualizado.');
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
        response()->json([
            'res' => true,
            'msg' => 'Usuario eliminado correctamente'
        ], 200);
        return redirect()->back()->with('alert', 'Usuario eliminado.');
    }

    public function loginAdmin(Request $request){
        if($request->session()->exists('data')){
            return redirect('/');
        }

        $credencials = $this->validate(request(), [
            'email' => 'email|required|string',
            'password' => 'required|string'
        ]);

        $data = Http::get('https://good-learn-jjrdb.ondigitalocean.app/api/usuarios/show?text='.$credencials['email'])->json();

        if(empty($data)){
            return redirect()->back()->with('alert', 'El usuario no existe.');
        }else{
            if($data[0]['rol_id']['id'] == 1){
                if (Hash::check($credencials['password'], $data[0]['password'])) {
                    $valores = ['rol' => $data[0]['rol_id']['id'],
                        'name' => $data[0]['name'],
                        'email' => $data[0]['email']
                    ];
                    $request->session()->put('data', $valores); 
                    return redirect('/home');
                }else{
                    return redirect()->back()->with('alert', 'La contraseña no coincide.');
                }  
            }else{
                return redirect()->back()->with('alert', 'No eres administrador.');
            }
            
        }
         
    }

    public function logout(Request $request){
        session()->forget('data');
        return redirect('admin/login');
    }
}

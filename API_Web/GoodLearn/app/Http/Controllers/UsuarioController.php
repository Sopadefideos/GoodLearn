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
        $input['password'] = Hash::make($request->password);
        Usuario::create($input);
        return response()->json([
            'res' => true,
            'msg' => 'Usuario creado correctamente'
        ], 200);
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

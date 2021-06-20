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
        if (request()->wantsJson()) {
            return $users;
        } else {
            return view('pages.table_list', ['usuarios' => $users]);
        }
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
            return returnSuccess('Usuario creado correctamente', 'home');
        }
        return returnError('La contraseña no coincide.');
    }

    public function byIndex(Usuario $usuario)
    {   
        return prettyUser($usuario); 
    }

    public function edit(Usuario $usuario)
    {   
		$roles = Rol::all();
        return view('pages.formUpdateUser', ['usuario' => $usuario, 'roles' => $roles]);
    }

    public function create()
    {   
        return view('pages.formCreateUser');
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
                $usuario->password = $input['password'];
            }else{
                return returnError('Las contraseñas no coincide.');
            }
        }
        
        if($request->email != null){
            $usuario->email = $input['email'];
        }

        if($request->name != null){
            $usuario->name = $input['name'];
        }

        if($request->telefono != null){
            $usuario->telefono = $input['telefono'];
        }

        if($request->direccion != null){
            $usuario->direccion = $input['direccion'];
        }

        if($request->rol != null){
            $usuario->rol_id = $input['rol'];
        }

        try{
            $usuario->update();
        }catch(\Exception $e){
            return returnError('El usuario no ha sido modificado.');
        }
        return returnSuccess('Usuario modificado correctamente', 'table');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Usuario $usuario)
    {   
        try{
            $usuario->delete();
        }catch(\Exception $e){
            return returnError('El usuario no ha sido eliminado.');
        }
        return returnSuccess('Usuario eliminado correctamente', 'home');
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
            return redirect()->back()->with('error', 'El usuario no existe.');
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
                    return redirect()->back()->with('error', 'La contraseña no coincide.');
                }  
            }else{
                return redirect()->back()->with('error', 'No eres administrador.');
            }
            
        }
         
    }

    public function logout(Request $request){
        session()->forget('data');
        return redirect('admin/login');
    }
}

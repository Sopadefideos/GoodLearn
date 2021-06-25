<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
require_once('lib/prettyPrint.php');
use App\Models\{Comentario_publicacion, Publicacion, Usuario};
use App\Http\Requests\CreateComentarioPublicacion;
use App\Http\Requests\UpdateComentarioPublicacion;
use Illuminate\Support\Facades\File;

class ComentarioPublicacionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Comentario_publicacion::all();
        return prettyComentarioPublicacion($data);
    }

    public function content(Publicacion $publicacion){
        $comentarios = $comentarios = prettyComentarioPublicacion(Comentario_publicacion::where('publicacion_id', '=', $publicacion->id)->get()->sortBy("fecha_creacion"));
        return view('pages.publicaciones.comentarios.comentarios', ['comentarios' => $comentarios, 'publicacion' => $publicacion]); 
    }

    public function edit(Comentario_publicacion $comentario){
        return view('pages.publicaciones.comentarios.formUpdateComentario', ['comentario' => $comentario]); 
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateComentarioPublicacion $request)
    {
        $input = $request->all();
        $comentario = new Comentario_publicacion;
        $comentario->fecha_creacion = date('Y-m-d H:i:s');
        $comentario->fecha_modificacion = date('Y-m-d H:i:s');
        $comentario->usuario_id = $input['usuario_id'];
        $comentario->publicacion_id = $input['publicacion_id'];
        $comentario->comentario = $input['comentario'];

        try{
            $comentario->save();
        }catch(\Exception $e){
            return returnError('El comentario no ha sido creado.');
        }
        return returnSuccess('Comentario añadido correctamente', 'home');
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
            $comentarios = Comentario_publicacion::where('usuario_id', 'like', '%' . $request->text . '%')
            ->orWhere('publicacion_id', 'like', '%' . $request->text . '%')
            ->orWhere('fecha_modificacion', 'like', '%' . $request->text . '%')
            ->orWhere('fecha_creacion', 'like', '%' . $request->text . '%')
            ->orWhere('comentario', 'like', '%' . $request->text . '%')->get();
        }else{
            $comentarios = Comentario_publicacion::all();
        }
        return prettyComentarioPublicacion($comentarios);
    }

    public function byIndex(Comentario_publicacion $comentario)
    {
        return prettyAutorizacion($comentario);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateComentarioPublicacion $request, Comentario_publicacion $comentario)
    {
        $input = $request->all();

        $user = Usuario::where('id', "=", $input['usuario_id'])->get();
        if($user[0]['rol_id'] == 1 or $user[0]['id'] == $comentario->usuario_id){
            $input['publicacion_id'] = $comentario->publicacion_id;
            $input['usuario_id'] = $comentario->usuario_id;
            $input['fecha_modificacion'] = date('Y-m-d H:i:s');
            $input['fecha_creacion'] = $comentario->fecha_creacion;
    
            try{
                $comentario->update($input);
            }catch(\Exception $e){
                return returnError('El comentario no ha sido modificado.');
            }
            return returnSuccess('Comentario modificado correctamente', 'home');
        }else{
            return returnError('No puedes hacer eso.');
        }
        
        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Usuario $user, Comentario_publicacion $comentario)
    {
        if($user->rol_id == 1 or $comentario->usuario_id == $user->id){
            try{
                $comentario->delete();
            }catch(\Exception $e){
                return returnError('El comentario no ha sido eliminada.');
            }
            return returnSuccess('Comentario eliminado correctamente', 'home');
        }else{
            return returnError('No puedes eliminar esta comentario.');
        }
    }
}

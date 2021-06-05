<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
require_once('lib/prettyPrint.php');
use App\Models\{Comentario_publicacion, Publicacion, Usuario};
use App\Http\Requests\CreateComentarioPublicacion;
use App\Http\Requests\UpdateComentarioPublicacion;

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

        $comentario->save();
        return response()->json([
            'res' => true,
            'msg' => 'Comentario creado correctamente'
        ], 200);
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
        
        $input['publicacion_id'] = $comentario->publicacion_id;
        $input['usuario_id'] = $comentario->usuario_id;
        $input['fecha_modificacion'] = date('Y-m-d H:i:s');
        $input['fecha_creacion'] = $comentario->fecha_creacion;

        $comentario->update($input);
        return response()->json([
            'res' => true,
            'msg' => 'Asistencia modificada correctamente'
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Comentario_publicacion $comentario)
    {
        $comentario->delete();
        return response()->json([
            'res' => true,
            'msg' => 'Comentario eliminado correctamente'
        ], 200);
    }
}

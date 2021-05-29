<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\{Usuario, Publicacion};
use App\Http\Requests\CreatePublicacionController;
use App\Http\Requests\UpdatePublicacionController;

class PublicacionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Publicacion::all();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreatePublicacionController $request, Usuario $user)
    {
        $input = $request->all();
        $input['usuario_id'] = $user->id;
        $input['fecha_creacion'] = date('Y-m-d H:i:s');
        $input['fecha_modificacion'] = date('Y-m-d H:i:s');

        $Publicacion = new Publicacion;
        $Publicacion->usuario_id = $input['usuario_id'];
        $Publicacion->fecha_creacion = $input['fecha_creacion'];
        $Publicacion->fecha_modificacion = $input['fecha_modificacion'];
        $Publicacion->titulo = $input['titulo'];
        $Publicacion->url_img = $input['url_img'];
        $Publicacion->save();

        return response()->json([
            'res' => true,
            'msg' => 'Publicacion creado correctamente'
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
            $publicaciones = Publicacion::where('titulo', 'like', '%' . $request->text . '%')
            ->orWhere('fecha_creacion', 'like', '%' . $request->text . '%')
            ->orWhere('fecha_modificacion', 'like', '%' . $request->text . '%')->get();
        }else{
            $publicaciones = Publicacion::all();
        }
        return $publicaciones;
    }


    public function byIndex(Publicacion $publicacion)
    {
        return $publicacion; 
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatePublicacionController $request, Usuario $user, Publicacion $publicacion)
    {
        $input = $request->all();
        $input['fecha_creacion'] = $publicacion->fecha_creacion;
        $input['fecha_modificacion'] = date('Y-m-d H:i:s');
        if($request->usuario_id != null){
            $input['usuario_id'] = $publicacion->usuario_id;
        }

        if($request->titulo != null){
            $input['titulo'] = $publicacion->titulo;
        }

        if($request->url_img != null){
            $input['url_img'] = $publicacion->url_img;
        }
        $publicacion->update($input);
        return response()->json([
            'res' => true,
            'msg' => 'Publicacion actualizado correctamente'
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Usuario $user, Publicacion $publicacion)
    {   
        if($publicacion->usuario_id == $user->id){
            $publicacion->delete();
            return response()->json([
                'res' => true,
                'msg' => 'Publicacion eliminada correctamente'
            ], 200);
        }

        return response()->json([
            'res' => false,
            'msg' => 'Publicacion no eliminada'
        ], 200);
        
    }
}

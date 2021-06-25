<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\{Usuario, Publicacion, Rol};
use App\Http\Requests\CreatePublicacionController;
use App\Http\Requests\UpdatePublicacionController;
require_once('lib/prettyPrint.php');
use Illuminate\Support\Facades\File;

class PublicacionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {   
        $data = prettyPublicacion(Publicacion::all()->sortByDesc("fecha_creacion"));
        if (request()->wantsJson()) {
            return $data;
        } else {
            return view('pages.publicaciones.publicaciones', ['publicaciones' => $data]);
        }
    }

    public function edit(Publicacion $publicacion)
    {   
        return view('pages.publicaciones.formUpdatePublicacion', ['publicacion' => $publicacion]);
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
        $imageExtensions = array('jpg','jpeg', 'gif', 'png', 'apng', 'svg', 'bmp');
        if ($request->hasFile('img')) {
            $file = $request->file('img');
            $ext = $file->extension();
            $exist_format = true;
            if (in_array($ext, $imageExtensions)) {
                try{
                    $destinationPath = 'publicaciones/';
                    $originalFile = $file->getClientOriginalName();
                    $filename=$user->email.strtotime(date('Y-m-d')).$originalFile;
                    $filename = str_replace(' ', '_', $filename);
                    $file->move($destinationPath, $filename);
                }catch(\Exception $e){
                    return returnError('La imagen no ha sido guardado en el servidor correctamente.');
                }
                $publicacion = new Publicacion;
                $publicacion->url_img = $filename;
                $publicacion->fecha_creacion = date('Y-m-d H:i:s');
                $publicacion->fecha_modificacion = date('Y-m-d H:i:s');
                $publicacion->titulo = $input['titulo'];
                $publicacion->usuario_id = $user->id;
                try{
                    $publicacion->save();
                }catch(\Exception $e){
                    return returnError('La publicacion no ha sido creada correctamente.');
                }
                return returnSuccess('Publicacion creada correctamente', 'home');

            }else{
                return returnError('Tiene que ser una imagen: jpg, jpeg, gif, png, apng, svg, bmp.');
            }
        }else{
            return returnError('No se ha introducido ninguna imagen.');
        }
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
        $data = prettyPublicacion($publicaciones);
        return $publicaciones;
    }


    public function byIndex(Publicacion $publicacion)
    {   
        return prettyPublicacion($publicacion); 
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
        if($user->rol_id == 1 or $publicacion->usuario_id == $user->id){
            $input = $request->all();
            if($request->titulo != null){
                $publicacion->titulo = $input['titulo'];
            }
    
            $publicacion->fecha_modificacion = date('Y-m-d H:i:s');
            try{
                $publicacion->update();
            }catch(\Exception $e){
                return returnError('La publicacion no ha sido modificada.');
            }
            return returnSuccess('Publicacion modificada correctamente', 'home');
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
    public function destroy(Usuario $user, Publicacion $publicacion)
    {   
        if($user->rol_id == 1){
            try{
                File::delete('publicaciones/'.$publicacion->url_img);
                $publicacion->delete();
            }catch(\Exception $e){
                return returnError('La publicacion no ha sido eliminada.');
            }
            return returnSuccess('Publicacion eliminada correctamente', 'home');
        }

        if($publicacion->usuario_id == $user->id){
            try{
                File::delete('publicaciones/'.$publicacion->url_img);
                $publicacion->delete();
            }catch(\Exception $e){
                return returnError('La publicacion no ha sido eliminada.');
            }
            return returnSuccess('Publicacion eliminada correctamente', 'home');
        }

        return returnError('No puedes eliminar esta publicacion.');
        
    }
}

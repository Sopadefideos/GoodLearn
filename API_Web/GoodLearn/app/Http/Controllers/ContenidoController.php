<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
require_once('lib/prettyPrint.php');
use App\Models\{Contenido, Asignatura, Curso, Asignatura_curso, Alumnos_curso, Usuario, Notificacion};
use App\Http\Requests\CreateContenido;
use App\Http\Requests\UpdateContenido;
use Illuminate\Support\Facades\File;

class ContenidoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Contenido::all();
        return prettyContenido($data);
    }

    public function create(Asignatura $asignatura)
    {   
        return view('pages.asignatura.contenido.formCreateContenidoAsignatura', ['asignatura' => $asignatura]);
    }

    public function edit(Asignatura $asignatura, Contenido $contenido)
    {   
        return view('pages.asignatura.contenido.formUpdateContenidoAsignatura', ['asignatura' => $asignatura, 'contenido' => $contenido]);
    }

    public function content(Asignatura $asignatura, $url_name)
    {
        return view('pages.asignatura.contenido.pdf.contenido_contenido', ['url_contenido' => $url_name,
         'asignatura' => $asignatura]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateContenido $request)
    {
        if ($request->hasFile('contenido_file')){
            $file = $request->file('contenido_file');
            if($file->extension() == 'pdf'){
                try{
                    $destinationPath = 'contenidos/';
                    $originalFile = $file->getClientOriginalName();
                    $filename=strtotime(date('Y-m-d')).$originalFile;
                    $filename = str_replace(' ', '_', $filename);
                    $file->move($destinationPath, $filename);
                }catch(\Exception $e){
                    return returnError('El contenido no ha sido guardado en el servidor correctamente.');
                }
                $contenido = new Contenido;
                $contenido->fecha_creacion = date('Y-m-d H:i:s');
                $contenido->fecha_modificacion = date('Y-m-d H:i:s');
                $contenido->asignatura_id = $request->asignatura_id;
                $contenido->url_contenido = $filename;

                $asignatura_curso = Asignatura_curso::where('asignatura_id', $request->asignatura_id)->get();
                $alumnos_curso = Alumnos_curso::where('curso_id', $asignatura_curso[0]->curso_id)->get();
                for ($i = 0; $i < count($alumnos_curso); $i++){
                    $notificacion = new Notificacion;
                    $notificacion->usuario_id = $alumnos_curso[$i]->usuario_id;
                    $notificacion->tipo_id = 2;
                    $notificacion->save();
                }

                try{
                    $contenido->save();
                }catch(\Exception $e){
                    return returnError('El contenido no ha sido creado correctamente.');
                }
                return returnSuccess('Contenido creado correctamente', 'asignaturas');
            }else{
                return returnError('Introduce un fichero con extenxion .pdf');
            }
        } else {
            return returnError('No se ha introducido ningun fichero.');
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
            $contenidos = Contenido::where('usuario_id', 'like', '%' . $request->text . '%')
            ->orWhere('url_contenido', 'like', '%' . $request->text . '%')
            ->orWhere('fecha_modificacion', 'like', '%' . $request->text . '%')
            ->orWhere('fecha_creacion', 'like', '%' . $request->text . '%')->get();
        }else{
            $contenidos = Contenido::all();
        }
        return prettyContenido($contenidos);
    }

    public function byIndex(Contenido $contenido)
    {
        return prettyContenido($contenido);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateContenido $request, Contenido $contenido)
    {
        $input = $request->all();
        if($request->asignatura_id != null){
            $contenido->asignatura_id = $input['asignatura_id'];
        }
        if($request->hasFile('contenido_file') == null){
            if ($request->hasFile('contenido_file')) {
                $file = $request->file('contenido_file');
                if($file->extension() == 'pdf'){
                    try{
                        $destinationPath = 'contenidos/';
                        $originalFile = $file->getClientOriginalName();
                        $filename=strtotime(date('Y-m-d')).$originalFile;
                        $filename = str_replace(' ', '_', $filename);
                        $file->move($destinationPath, $filename);
                        File::delete('autorizaciones/'.$contenido->url_contenido);
                        $contenido->url_contenido = $filename;
                    }catch(\Exception $e){
                        return returnError('El contenido no ha sido guardado en el servidor correctamente.');
                    }
                }else{
                    return returnError('Introduce un fichero con extenxion .pdf');
                }
            } else {
                return returnError('No se ha introducido ningun fichero.');
            }
        }
        $input['fecha_modificacion'] = date('Y-m-d H:i:s');

        try{
            $contenido->update();
        }catch(\Exception $e){
            return returnError('El contenido no ha sido modificadaço.');
        }
        return returnSuccess('Contenido modificado correctamente', 'asignaturas');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Contenido $contenido)
    {
        try{
            File::delete('contenidos/'.$contenido->url_contenido);
            $contenido->delete();
        }catch(\Exception $e){
            return returnError('El contenido no ha sido eliminado.');
        }
        return returnSuccess('Contenido eliminado correctamente', 'asignaturas');
    }
}

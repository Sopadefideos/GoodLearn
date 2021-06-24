<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
require_once('lib/prettyPrint.php');
use App\Models\{Autorizacion, Asignatura, Usuario, Alumnos_curso, Asignatura_curso};
use App\Http\Requests\CreateAutorizacion;
use App\Http\Requests\UpdateAutorizacion;
use Illuminate\Support\Facades\File;

class AutorizacionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Autorizacion::all();
        return prettyAutorizacion($data);
    }

    public function create(Asignatura $asignatura)
    {   
        return view('pages.asignatura.autorizaciones.formCreateAutorizacionAsignatura', ['asignatura' => $asignatura]);
    }
    
    public function content(Asignatura $asignatura, $url_name)
    {
        $autorizaciones = prettyAutorizacion(Autorizacion::where('asignatura_id' , '=', $asignatura->id)->where('url_autorizacion' , '=', $url_name)->get());
        return view('pages.asignatura.autorizaciones.pdf.autorizacion_contenido', ['autorizaciones' => $autorizaciones, 'url_autorizacion' => $url_name,
         'asignatura' => $asignatura]);
        
    }

    public function edit(Asignatura $asignatura, Autorizacion $autorizacion)
    {   
        return view('pages.asignatura.autorizaciones.formUpdateAutorizacionAsignatura', ['asignatura' => $asignatura, 'autorizacion' => $autorizacion]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateAutorizacion $request)
    {
        if ($request->hasFile('autorizacion_file')) {
            $file = $request->file('autorizacion_file');
            if($file->extension() == 'pdf'){
                try{
                    $destinationPath = 'autorizaciones/';
                    $originalFile = $file->getClientOriginalName();
                    $filename=strtotime(date('Y-m-d')).$originalFile;
                    $filename = str_replace(' ', '_', $filename);
                    $file->move($destinationPath, $filename);
                }catch(\Exception $e){
                    return returnError('La autorizacion no ha sido guardado en el servidor correctamente.');
                }
                $curso = Asignatura_curso::where('asignatura_id', 'like', '%' . $request->asignatura_id . '%')->get();
                $alumnos = prettyAlumno_curso(Alumnos_curso::where('curso_id', 'like', '%' . $curso[0]['curso_id'] . '%')->get());
                foreach($alumnos as $alumno){
                    $autorizacion = new Autorizacion;
                    $autorizacion->fecha_creacion = date('Y-m-d H:i:s');
                    $autorizacion->fecha_modificacion = date('Y-m-d H:i:s');
                    $autorizacion->asignatura_id = $request->asignatura_id;
                    $autorizacion->url_autorizacion = $filename;
                    $autorizacion->usuario_id = $alumno['usuario_id']['id'];
                    try{
                        $autorizacion->save();
                    }catch(\Exception $e){
                        return returnError('La autorizacion no ha sido creada correctamente.');
                    }
                }
                return returnSuccess('Autorizacion creada correctamente', 'asignaturas');
                
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
            $autorizaciones = Autorizacion::where('usuario_id', 'like', '%' . $request->text . '%')
            ->orWhere('asignatura_id', 'like', '%' . $request->text . '%')
            ->orWhere('url_autorizacion', 'like', '%' . $request->text . '%')
            ->orWhere('fecha_modificacion', 'like', '%' . $request->text . '%')
            ->orWhere('fecha_creacion', 'like', '%' . $request->text . '%')
            ->orWhere('estado', 'like', '%' . $request->text . '%')->get();
        }else{
            $autorizaciones = Autorizacion::all();
        }
        return prettyAutorizacion($autorizaciones);
    }

    public function byIndex(Autorizacion $autorizacion)
    {
        return prettyAutorizacion($autorizacion);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateAutorizacion $request, Autorizacion $autorizacion)
    {
        $input = $request->all();

        if($request->usuario_id != null){
            $autorizacion->usuario_id = $input['usuario_id'];
        }

        if($request->asignatura_id != null){
            $autorizacion->asignatura_id = $input['asignatura_id'];
        }

        if($request->estado != null){
            $autorizacion->estado = $input['estado'];
        }

        $input['fecha_modificacion'] = date('Y-m-d H:i:s');
        if ($request->hasFile('autorizacion_file')) {
            $file = $request->file('autorizacion_file');
            if($file->extension() == 'pdf'){
                try{
                    $destinationPath = 'autorizaciones/';
                    $originalFile = $file->getClientOriginalName();
                    $filename=strtotime(date('Y-m-d')).$originalFile;
                    $filename = str_replace(' ', '_', $filename);
                    $file->move($destinationPath, $filename);
                    File::delete('autorizaciones/'.$autorizacion->url_autorizacion);
                    Autorizacion::where('url_autorizacion', 'like', '%' . $autorizacion->url_autorizacion . '%')->update(['url_autorizacion' => $filename, 'estado' => 0]);
                }catch(\Exception $e){
                    return returnError('La autorizacion no ha sido guardado en el servidor correctamente.');
                }
            }else{
                return returnError('Introduce un fichero con extenxion .pdf');
            }
        } else {
            return returnError('No se ha introducido ningun fichero.');
        }

        try{
            $autorizacion->update();
        }catch(\Exception $e){
            return returnError('La autorizacion no ha sido modificada.');
        }
        return returnSuccess('Autorizacion modificada correctamente', 'asignaturas');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Autorizacion $autorizacion)
    {
        try{
            File::delete('autorizaciones/'.$autorizacion->url_autorizacion);
            Autorizacion::where('url_autorizacion', 'like', '%' . $autorizacion->url_autorizacion . '%')->delete();
        }catch(\Exception $e){
            return returnError('La autorizacion no ha sido eliminada.');
        }
        return returnSuccess('Autorizacion eliminada correctamente', 'asignaturas');
    }
}

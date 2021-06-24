<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
require_once('lib/prettyPrint.php');
use App\Models\{Usuario, Asignatura, Asistencia, Autorizacion, Contenido, Nota};
use App\Http\Requests\CreateAsignaturaRequest;
use App\Http\Requests\UpdateAsignaturaRequest;

class AsignaturaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Asignatura::all()->sortBy("name");
        $asignaturas = prettyAsignatura($data);
        if (request()->wantsJson()) {
            return $asignaturas;
        } else {
            return view('pages.asignatura.asignaturas', ['asignaturas' => $asignaturas]);
        }
    }

    public function content(Asignatura $asignatura)
    {
        $asistencias = prettyAsistencia(Asistencia::where('asignatura_id', 'like', '%' . $asignatura->id . '%')->get()->sortByDesc("fecha_inicio"));
        $notas = prettyNota(Nota::where('asignatura_id', 'like', '%' . $asignatura->id . '%')->get()->sortBy("fecha_creacion"));
        return view('pages.asignatura.asignaturas_contenido', ['asignatura' => $asignatura, 'asistencias' => $asistencias,
            'notas' => $notas]);
        
    }
    

    public function create()
    {   
        $profesores = Usuario::where('rol_id', 'like', '%' . 2 . '%')->get();
        return view('pages.asignatura.formCreateAsignatura', ['profesores' => $profesores]);
    }

    public function edit(Asignatura $asignatura)
    {   
        $profesores = Usuario::where('rol_id', 'like', '%' . 2 . '%')->get();
        return view('pages.asignatura.formUpdateAsignatura', ['profesores' => $profesores, 'asignatura' => $asignatura]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateAsignaturaRequest $request)
    {
        $asignatura = new Asignatura;
        $profesor = Usuario::find($request['usuario_id']);
        if($profesor->rol_id == 2){
            $asignatura->nombre = $request['nombre'];
            $asignatura->usuario_id = $request['usuario_id'];
            try{
                $asignatura->save();
            }catch(\Exception $e){
                return returnError('La asignatura no ha sido creada correctamente.');
            }
            return returnSuccess('Asignatura creada correctamente', 'asignaturas'); 

        }else{
            return returnError('El usuario seleccionado no es profesor.');
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
            $asignaturas = Asignatura::where('usuario_id', 'like', '%' . $request->text . '%')
            ->orWhere('nombre', 'like', '%' . $request->text . '%')->get();
        }else{
            $asignaturas = Asignatura::all();
        }
        return prettyAsignatura($asignaturas);
    }

    public function byIndex(Asignatura $asignatura)
    {   
        return prettyAsignatura($asignatura); 
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateAsignaturaRequest $request, Asignatura $asignatura)
    {
        $input = $request->all();
        if($request->nombre != null){
            $asignatura->nombre = $input['nombre'];
        }

        if($request->usuario_id != null){
            $asignatura->usuario_id = $input['usuario_id'];
        }

        try{
            $asignatura->update();
        }catch(\Exception $e){
            return returnError('La asignatura no ha sido modificado.');
        }
        return returnSuccess('Asignatura modificada correctamente', 'asignaturas');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Asignatura $asignatura)
    {
        try{
            $asignatura->delete();
        }catch(\Exception $e){
            return returnError('La asignatura no ha sido eliminada.');
        }
        return returnSuccess('Asignatura eliminada correctamente', 'home');
    }
}

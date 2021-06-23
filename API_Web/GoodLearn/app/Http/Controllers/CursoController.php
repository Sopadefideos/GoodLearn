<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\{Curso, Alumnos_curso, Asignatura_curso};
use App\Http\Requests\CreateCursoRequest;
use App\Http\Requests\UpdateCursoRequest;
require_once('lib/prettyPrint.php');

class CursoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $cursos = Curso::all()->sortByDesc("fecha_inicio");
        if (request()->wantsJson()) {
            return $cursos;
        } else {
            return view('pages.cursos.cursos', ['cursos' => $cursos]);
        }
    }

    public function content(Curso $curso)
    {
        $asignaturas = Asignatura_curso::where('curso_id', 'like', '%' . $curso->id . '%')->get();
        $asignaturas_pretty = prettyAsignatura_Curso($asignaturas);
        $alumnos = Alumnos_curso::where('curso_id', 'like', '%' . $curso->id . '%')->get();
        $alumnos_pretty = prettyAlumno_curso($alumnos);
        return view('pages.cursos.cursos_contenido', ['asignaturas' => $asignaturas_pretty, 'alumnos' => $alumnos_pretty, 'curso' => $curso]);
        
    }

    public function edit(Curso $curso)
    {   
        return view('pages.cursos.formUpdateCurso', ['curso' => $curso]);
    }

    public function create()
    {   
        return view('pages.cursos.formCreateCurso');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateCursoRequest $request)
    {
        $input = $request->all();
        $curso = new Curso;
        $curso->name = $input['name'];
        $curso->fecha_inicio = $input['fecha_inicio'];
        $curso->fecha_fin = $input['fecha_fin'];

        try{
            $curso->save();
        }catch(\Exception $e){
            return returnError('El curso no ha sido creada correctamente.');
        }

        return returnSuccess('Curso creada correctamente', 'cursos'); 
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
            $cursos = Curso::where('name', 'like', '%' . $request->text . '%')
            ->orWhere('fecha_inicio', 'like', '%' . $request->text . '%')
            ->orWhere('fecha_fin', 'like', '%' . $request->text . '%')->get();
        }else{
            $cursos = Curso::all();
        }
        return $cursos;
    }

    public function byIndex(Curso $curso)
    {
        return $curso; 
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateCursoRequest $request, Curso $curso)
    {
        $input = $request->all();
        
        if($request->name != null){
            $curso->name = $input['name'];
        }

        if($request->fecha_inicio != null){
            $curso->fecha_inicio = $input['fecha_inicio'];
        }

        if($request->fecha_fin != null){
            $curso->fecha_fin = $input['fecha_fin'];
        }

        try{
            $curso->update();
        }catch(\Exception $e){
            return returnError('El curso no ha sido modificado.');
        }
        return returnSuccess('Curso modificado correctamente', 'cursos');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Curso $curso)
    {
        try{
            $curso->delete();
        }catch(\Exception $e){
            return returnError('El curso no ha sido eliminado.');
        }
        return returnSuccess('Curso eliminado correctamente', 'home');
    }
}

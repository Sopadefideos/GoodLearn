<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
require_once('lib/prettyPrint.php');
use App\Models\{Curso, Asignatura, Asignatura_curso};
use App\Http\Requests\UpdateAsignatura_cursoRequest;

class Asignatura_cursoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Asignatura_curso::all();
        return prettyAsignatura_Curso($data);
    }


    public function create(Curso $curso)
    {   
        $asignaturas = prettyAsignatura(Asignatura::all());
        return view('pages.cursos.asignaturas.formCreateAsignaturaCurso', ['curso' => $curso, 'asignaturas' => $asignaturas]);
    }

    public function edit(Curso $curso, Asignatura_curso $asignaturas_cursos)
    {   
        $asignaturas = prettyAsignatura(Asignatura::all());
        return view('pages.cursos.asignaturas.formUpdateAsignaturaCurso', ['curso' => $curso, 'asignaturas_cursos' => $asignaturas_cursos, 'asignaturas' => $asignaturas]);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Curso $curso)
    {
        $input = $request->all();
        $asignatura_curso = new Asignatura_curso;
        $asignatura_curso->curso_id = $curso->id;
        $asignatura_curso->asignatura_id = $input['asignatura_id'];
        
        try{
            $asignatura_curso->save();
        }catch(\Exception $e){
            return returnError('La asignatura no ha sido añadida correctamente.');
        }

        return returnSuccess('La asignatura ha sido añadida correctamente.', 'cursos');
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
            $asignaturas = Asignatura::where('curso_id', 'like', '%' . $request->text . '%')
            ->orWhere('asignatura_id', 'like', '%' . $request->text . '%')->get();
        }else{
            $asignaturas = Asignatura::all();
        }
        return prettyAsignatura($asignaturas);
    }

    public function byIndex(Asignatura_curso $asignaturas_cursos)
    {   
        return prettyAsignatura_Curso($asignaturas_cursos); 
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateAsignatura_cursoRequest $request, Asignatura_curso $asignaturas_cursos)
    {
        $input = $request->all();
        
        if($request->asignatura_id != null){
            $asignaturas_cursos->asignatura_id = $input['asignatura_id'];
        }

        try{
            $asignaturas_cursos->update();
        }catch(\Exception $e){
            return returnError('La asignatura no ha sido modificada.');
        }
        return returnSuccess('Asignatura modificada correctamente', 'cursos');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Asignatura_curso $asignaturas_cursos)
    {
        try{
            $asignaturas_cursos->delete();
        }catch(\Exception $e){
            return returnError('La asignatura no ha sida eliminada del curso.');
        }
        return returnSuccess('Asignatura eliminada del curso correctamente', 'cursos');
    }
}

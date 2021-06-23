<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\{Alumnos_curso, Curso, Usuario};
use App\Http\Requests\UpdateCurso_alumnoRequest;
require_once('lib/prettyPrint.php');

class Alumno_cursoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Alumnos_curso::all();
        return prettyAlumno_curso($data);
    }

    public function create(Curso $curso)
    {   
        $alumnos = prettyUser(Usuario::where('rol_id', 'like', '%' . 3 . '%')->get());
        return view('pages.cursos.alumnos.formCreateAlumnoCurso', ['curso' => $curso, 'alumnos' => $alumnos]);
    }

    public function edit(Curso $curso, Alumnos_curso $curso_alumno)
    {   
        $alumnos = prettyUser(Usuario::where('rol_id', 'like', '%' . 3 . '%')->get());
        return view('pages.cursos.alumnos.formUpdateAlumnoCurso', ['curso' => $curso, 'curso_alumno' => $curso_alumno, 'alumnos' => $alumnos]);
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
        $curso_alumno = new Alumnos_curso;
        $curso_alumno->usuario_id = $input['alumno_id'];
        $curso_alumno->curso_id = $curso->id;

        try{
            $curso_alumno->save();
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
            $cursos_alumnos = Alumnos_curso::where('curso_id', 'like', '%' . $request->text . '%')
            ->orWhere('usuario_id', 'like', '%' . $request->text . '%')->get();
        }else{
            $cursos_alumnos = Alumnos_curso::all();
        }
        return prettyAlumno_curso($cursos_alumnos);
    }

    public function byIndex(Alumnos_curso $curso_alumno)
    {
        return prettyAlumno_curso($curso_alumno);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateCurso_alumnoRequest $request, Alumnos_curso $curso_alumno)
    {
        $input = $request->all();
        
        if($request->alumno_id != null){
            $curso_alumno->usuario_id = $input['alumno_id'];
        }

        try{
            $curso_alumno->update();
        }catch(\Exception $e){
            return returnError('El alumno no ha sido modificado.');
        }
        return returnSuccess('Alumno modificado correctamente', 'cursos');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Alumnos_curso $curso_alumno)
    {
        try{
            $curso_alumno->delete();
        }catch(\Exception $e){
            return returnError('El alumno no ha sido eliminado del curso.');
        }
        return returnSuccess('Alumno eliminado del curso correctamente', 'cursos');
    }
}

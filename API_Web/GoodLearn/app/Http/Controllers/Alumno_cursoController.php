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

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Curso $curso, Usuario $usuario)
    {
        $curso_alumno = new Alumnos_curso;
        $curso_alumno->usuario_id = $usuario->id;
        $curso_alumno->curso_id = $curso->id;
        $curso_alumno->save();

        return response()->json([
            'res' => true,
            'msg' => 'Curso asignado a alumno correctamente'
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

        $usuarios = Usuario::all();
        $ids_user = [];
        foreach($usuarios as $usuario){
            $ids_user[] = $usuario->id; 
        }

        $cursos = Curso::all();
        $ids_cursos = [];
        foreach($cursos as $curso){
            $ids_cursos[] = $curso->id; 
        }
        
        if($request->usuario_id == null){
            $input['usuario_id'] = $curso_alumno->usuario_id;
        }else{
            if(in_array($input['usuario_id'], $ids_user)){
                $curso_alumno->usuario_id = $input['usuario_id'];
            }else{
                return response()->json([
                    'res' => false,
                    'msg' => 'usuario no existe.'
                ], 404);
            }
        }

        if($request->curso_id == null){
            $input['curso_id'] = $curso_alumno->curso_id;
        }else{
            if(in_array($input['curso_id'], $ids_cursos)){
                $curso_alumno->curso_id = $input['curso_id'];
            }else{
                return response()->json([
                    'res' => false,
                    'msg' => 'curso no existe.'
                ], 404);
            }
        }

        $curso_alumno->update();

        return response()->json([
            'res' => true,
            'msg' => 'curso_alumno actualizado correctamente'
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Alumnos_curso $curso_alumno)
    {
        $curso_alumno->delete();
        return response()->json([
            'res' => true,
            'msg' => 'curso_alumno eliminado correctamente'
        ], 200);
    }
}

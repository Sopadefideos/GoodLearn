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

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Asignatura $asignatura, Curso $curso)
    {
        $asignatura_curso = new Asignatura_curso;
        $asignatura_curso->curso_id = $curso->id;
        $asignatura_curso->asignatura_id = $asignatura->id;
        $asignatura_curso->save();

        return response()->json([
            'res' => true,
            'msg' => 'asignatura_curso creada correctamente'
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

        $asignaturas = Asignatura::all();
        $ids_asignaturas = [];
        foreach($asignaturas as $asignatura){
            $ids_asignaturas[] = $asignatura->id; 
        }

        $cursos = Curso::all();
        $ids_cursos = [];
        foreach($cursos as $curso){
            $ids_cursos[] = $curso->id; 
        }
        if($request->asignatura_id == null){
            $input['asignatura_id'] = $asignaturas_cursos->asignatura_id;
        }else{
            if(in_array($input['asignatura_id'], $ids_asignaturas)){
                $asignaturas_cursos->asignatura_id = $input['asignatura_id'];
            }else{
                return response()->json([
                    'res' => false,
                    'msg' => 'asignatura no existe.'
                ], 404);
            }
        }

        if($request->curso_id == null){
            $input['curso_id'] = $asignaturas_cursos->curso_id;
        }else{
            if(in_array($input['curso_id'], $ids_cursos)){
                $asignaturas_cursos->curso_id = $input['curso_id'];
            }else{
                return response()->json([
                    'res' => false,
                    'msg' => 'curso no existe.'
                ], 404);
            }
        }
        
        $asignaturas_cursos->update();
        
        return response()->json([
            'res' => true,
            'msg' => 'Asignatura_curso actualizada correctamente'
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Asignatura_curso $asignaturas_cursos)
    {
        $asignaturas_cursos->delete();
        return response()->json([
            'res' => true,
            'msg' => 'asignatura_curso eliminada correctamente'
        ], 200);
    }
}

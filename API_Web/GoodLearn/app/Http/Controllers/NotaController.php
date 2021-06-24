<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
require_once('lib/prettyPrint.php');
use App\Models\{Nota, Asignatura, Usuario, Alumnos_curso, Asignatura_curso};
use App\Http\Requests\CreateNota;
use App\Http\Requests\UpdateNota;

class NotaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Nota::all();
        return prettyNota($data);
    }

    public function create(Asignatura $asignatura)
    {   
        $curso = Asignatura_curso::where('asignatura_id', 'like', '%' . $asignatura->id . '%')->get();
        $alumnos = prettyAlumno_curso(Alumnos_curso::where('curso_id', 'like', '%' . $curso[0]['curso_id'] . '%')->get());
        return view('pages.asignatura.notas.formCreateNotaAsignatura', ['alumnos' => $alumnos, 'asignatura' => $asignatura]);
    }

    public function edit(Asignatura $asignatura, Nota $nota)
    {   
        $curso = Asignatura_curso::where('asignatura_id', 'like', '%' . $asignatura->id . '%')->get();
        $alumnos = prettyAlumno_curso(Alumnos_curso::where('curso_id', 'like', '%' . $curso[0]['curso_id'] . '%')->get());
        return view('pages.asignatura.notas.formUpdateNotaAsignatura', ['alumnos' => $alumnos, 'asignatura' => $asignatura, 'nota' => $nota]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateNota $request)
    {
        $input = $request->all();
        $nota = new Nota;
        $nota->fecha_creacion = date('Y-m-d H:i:s');
        $nota->fecha_modificacion = date('Y-m-d H:i:s');
        $nota->usuario_id = $input['usuario_id'];
        $nota->asignatura_id = $input['asignatura_id'];
        $nota->nota = $input['nota'];
        $nota->titulo = $input['titulo'];
        $nota->cuerpo = $input['cuerpo'];

        try{
            $nota->save();
        }catch(\Exception $e){
            return returnError('La calificacion no ha sido creada correctamente.');
        }

        return returnSuccess('Calificacion añadida a la asignatura', 'asignaturas'); 
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
            $notas = Nota::where('usuario_id', 'like', '%' . $request->text . '%')
            ->orWhere('asignatura_id', 'like', '%' . $request->text . '%')
            ->orWhere('nota', 'like', '%' . $request->text . '%')
            ->orWhere('titulo', 'like', '%' . $request->text . '%')
            ->orWhere('cuerpo', 'like', '%' . $request->text . '%')
            ->orWhere('fecha_modificacion', 'like', '%' . $request->text . '%')
            ->orWhere('fecha_creacion', 'like', '%' . $request->text . '%')->get();
        }else{
            $notas = Nota::all();
        }
        return prettyNota($notas);
    }

    public function byIndex(Nota $nota)
    {
        return prettyNota($nota);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateNota $request, Nota $nota)
    {
        $input = $request->all();

        if($request->usuario_id != null){
            $nota->usuario_id = $input['usuario_id'];
        }

        if($request->nota != null){
            $nota->nota = $input['nota'];
        }

        if($request->titulo != null){
            $nota->titulo = $input['titulo'];
        }

        if($request->cuerpo != null){
            $nota->cuerpo = $input['cuerpo'];
        }

        $input['fecha_modificacion'] = date('Y-m-d H:i:s');
        $nota->fecha_modificacion = $input['fecha_modificacion'];

        try{
            $nota->update();
        }catch(\Exception $e){
            return returnError('La calificacion no ha sido modificada correctamente.');
        }

        return returnSuccess('Calificacion modificada', 'asignaturas');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Nota $nota)
    {
        try{
            $nota->delete();
        }catch(\Exception $e){
            return returnError('La calificacion no ha sido eliminado.');
        }
        return returnSuccess('Calificacion eliminada correctamente', 'asignaturas');
    }
}

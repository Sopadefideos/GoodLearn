<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
require_once('lib/prettyPrint.php');
use App\Models\{Asistencia, Asignatura, Usuario, Alumnos_curso, Asignatura_curso, Notificacion};
use App\Http\Requests\CreateAsistenciaRequest;
use App\Http\Requests\UpdateAsistenciaRequest;

class AsistenciaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Asistencia::all();
        return prettyAsistencia($data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateAsistenciaRequest $request)
    {
        $input = $request->all();
        $asistencia = new Asistencia;
        $asistencia->fecha_creacion = date('Y-m-d H:i:s');
        $asistencia->fecha_modificacion = date('Y-m-d H:i:s');
        $asistencia->usuario_id = $input['usuario_id'];
        $asistencia->asignatura_id = $input['asignatura_id'];
        $asistencia->fecha_falta = $input['fecha_falta'];

        $notificacion = new Notificacion;
        $notificacion->usuario_id = $input['usuario_id'];
        $notificacion->tipo_id = 5;
        $notificacion->save();

        try{
            $asistencia->save();
        }catch(\Exception $e){
            return returnError('La falta de asistencia no ha sido creada correctamente.');
        }

        return returnSuccess('Falta de asistencia añadida a la asignatura', 'asignaturas'); 

    }

    public function create(Asignatura $asignatura)
    {   
        $curso = Asignatura_curso::where('asignatura_id', 'like', '%' . $asignatura->id . '%')->get();
        $alumnos = prettyAlumno_curso(Alumnos_curso::where('curso_id', 'like', '%' . $curso[0]['curso_id'] . '%')->get());
        return view('pages.asignatura.asistencias.formCreateAsistenciaAsignatura', ['alumnos' => $alumnos, 'asignatura' => $asignatura]);
    }

    public function edit(Asignatura $asignatura, Asistencia $asistencia)
    {   
        $curso = Asignatura_curso::where('asignatura_id', 'like', '%' . $asignatura->id . '%')->get();
        $alumnos = prettyAlumno_curso(Alumnos_curso::where('curso_id', 'like', '%' . $curso[0]['curso_id'] . '%')->get());
        return view('pages.asignatura.asistencias.formUpdateAsistenciaAsignatura', ['alumnos' => $alumnos, 'asignatura' => $asignatura, 'asistencia' => $asistencia]);
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
            $asistencias = Asistencia::where('usuario_id', 'like', '%' . $request->text . '%')
            ->orWhere('asignatura_id', 'like', '%' . $request->text . '%')
            ->orWhere('fecha_creacion', 'like', '%' . $request->text . '%')
            ->orWhere('fecha_modificacion', 'like', '%' . $request->text . '%')
            ->orWhere('fecha_falta', 'like', '%' . $request->text . '%')->get();
        }else{
            $asistencias = Asistencia::all();
        }
        return prettyAsistencia($asistencias);
    }

    public function byIndex(Asistencia $asistencia)
    {
        return prettyAsistencia($asistencia);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateAsistenciaRequest $request, Asistencia $asistencia)
    {
        $input = $request->all();

        if($request->usuario_id != null){
            $asistencia->usuario_id = $input['usuario_id'];
        }

        if($request->fecha_falta != null){
            $asistencia->fecha_falta = $input['fecha_falta'];
        }

        $input['fecha_modificacion'] = date('Y-m-d H:i:s');
        $asistencia->fecha_modificacion = $input['fecha_modificacion'];

        try{
            $asistencia->update();
        }catch(\Exception $e){
            return returnError('La asistencia no ha sido modificada.');
        }
        return returnSuccess('Asistencia modificada correctamente', 'asignaturas');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Asistencia $asistencia)
    {
        try{
            $asistencia->delete();
        }catch(\Exception $e){
            return returnError('La falta de asistencia no ha sido eliminado.');
        }
        return returnSuccess('Falta de asistencia eliminada correctamente', 'asignaturas');
    }
}

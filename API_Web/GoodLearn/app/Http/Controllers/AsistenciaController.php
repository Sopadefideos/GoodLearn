<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
require_once('lib/prettyPrint.php');
use App\Models\{Asistencia, Asignatura, Usuario};
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
        return prettyAsignatura($data);
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

        $asistencia->save();
        return response()->json([
            'res' => true,
            'msg' => 'Asistencia creada correctamente'
        ], 200);

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request){

        if($request->text){
            $asistencias = Asistencia::where('usuario_id', 'like', '%' . $request->text . '%')
            ->orWhere('asignatura_id', 'like', '%' . $request->text . '%')
            ->orWhere('fecha_creacion', 'like', '%' . $request->text . '%')
            ->orWhere('fecha_modificacion', 'like', '%' . $request->text . '%')
            ->orWhere('fecha_falta', 'like', '%' . $request->text . '%')->get();
        }else{
            $asistencias = Asistencia::all();
        }
        return prettyAsignatura($asistencias);
    }

    public function byIndex(Asistencia $asistencia)
    {
        return prettyAsignatura($asistencia);
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

        if($request->usuario_id == null){
            $input['usuario_id'] = $asistencia->usuario_id;
        }

        if($request->asignatura_id == null){
            $input['asignatura_id'] = $asistencia->asignatura_id;
        }

        if($request->fecha_falta == null){
            $input['fecha_falta'] = $asistencia->fecha_falta;
        }

        $input['fecha_modificacion'] = date('Y-m-d H:i:s');
        $input['fecha_creacion'] = $asistencia->fecha_creacion;

        $asistencia->update($input);
        return response()->json([
            'res' => true,
            'msg' => 'Asistencia modificada correctamente'
        ], 200);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Asistencia $asistencia)
    {
        $asignaturas_cursos->delete();
        return response()->json([
            'res' => true,
            'msg' => 'Asistencia eliminada correctamente'
        ], 200);
    }
}

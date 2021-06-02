<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
require_once('lib/prettyPrint.php');
use App\Models\{Usuario, Asignatura};
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
        $data = Asignatura::all();
        return prettyAsignatura($data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateAsignaturaRequest $request, Usuario $usuario)
    {
        $asignatura = new Asignatura;
        $asignatura->usuario_id = $usuario->id;
        $asignatura->nombre = $request['nombre'];
        $asignatura->save();

        return response()->json([
            'res' => true,
            'msg' => 'asignatura creada correctamente'
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
        if($request->nombre == null){
            $input['nombre'] = $asignatura->nombre;
        }else{
            $asignatura->nombre = $input['nombre'];
        }
        if($request->usuario_id == null){
            $input['usuario_id'] = $asignatura->usuario_id;
        }
        
        $asignatura->update($input);
        
        return response()->json([
            'res' => true,
            'msg' => 'Asignatura actualizada correctamente'
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Asignatura $asignatura)
    {
        $asignatura->delete();
        return response()->json([
            'res' => true,
            'msg' => 'asignatura eliminada correctamente'
        ], 200);
    }
}

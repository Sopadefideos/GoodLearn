<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
require_once('lib/prettyPrint.php');
use App\Models\{Autorizacion, Asignatura, Usuario};
use App\Http\Requests\CreateAutorizacion;
use App\Http\Requests\UpdateAutorizacion;

class AutorizacionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Autorizacion::all();
        return prettyAutorizacion($data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateAutorizacion $request)
    {
        $input = $request->all();
        $autorizacion = new Autorizacion;
        $autorizacion->fecha_creacion = date('Y-m-d H:i:s');
        $autorizacion->fecha_modificacion = date('Y-m-d H:i:s');
        $autorizacion->usuario_id = $input['usuario_id'];
        $autorizacion->asignatura_id = $input['asignatura_id'];
        $autorizacion->url_autorizacion = $input['url_autorizacion'];

        $autorizacion->save();
        return response()->json([
            'res' => true,
            'msg' => 'Autorizacion creada correctamente'
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
            $autorizaciones = Autorizacion::where('usuario_id', 'like', '%' . $request->text . '%')
            ->orWhere('asignatura_id', 'like', '%' . $request->text . '%')
            ->orWhere('url_autorizacion', 'like', '%' . $request->text . '%')
            ->orWhere('fecha_modificacion', 'like', '%' . $request->text . '%')
            ->orWhere('fecha_creacion', 'like', '%' . $request->text . '%')
            ->orWhere('estado', 'like', '%' . $request->text . '%')->get();
        }else{
            $autorizaciones = Autorizacion::all();
        }
        return prettyAutorizacion($autorizaciones);
    }

    public function byIndex(Autorizacion $autorizacion)
    {
        return prettyAutorizacion($autorizacion);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateAutorizacion $request, Autorizacion $autorizacion)
    {
        $input = $request->all();

        if($request->usuario_id == null){
            $input['usuario_id'] = $autorizacion->usuario_id;
        }

        if($request->asignatura_id == null){
            $input['asignatura_id'] = $autorizacion->asignatura_id;
        }

        if($request->url_autorizacion == null){
            $input['url_autorizacion'] = $autorizacion->fecha_falta;
        }

        if($request->estado == null){
            $input['estado'] = $autorizacion->estado;
        }

        $input['fecha_modificacion'] = date('Y-m-d H:i:s');
        $input['fecha_creacion'] = $autorizacion->fecha_creacion;

        $autorizacion->update($input);
        return response()->json([
            'res' => true,
            'msg' => 'Autorizacion modificada correctamente'
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Autorizacion $autorizacion)
    {
        $autorizacion->delete();
        return response()->json([
            'res' => true,
            'msg' => 'Autorizacion eliminada correctamente'
        ], 200);
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\{Notificacion, Tipo_notificacion, Usuario};
use App\Http\Requests\CreateNotificacionRequest;
use App\Http\Requests\UpdateNotificacionRequest;
require_once('lib\prettyPrint.php');

class NotificacionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Notificacion::all();
        return prettyNotificacion($data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Usuario $usuario, Tipo_notificacion $tipo)
    {
        $notificacion = new Notificacion;
        $notificacion->usuario_id = $usuario->id;
        $notificacion->tipo_id = $tipo->id;
        $notificacion->save();
        return response()->json([
            'res' => true,
            'msg' => 'Notificacion creada correctamente'
        ], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Usuario $usuario)
    {   
        $id = $usuario->id;
        $data = Notificacion::where('usuario_id', '=', $id)->get();
        return prettyNotificacion($data);
    }

    public function byIndex(Notificacion $notificacion)
    {   
        return prettyNotificacion($notificacion); 
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Notificacion $notificacion)
    {
        if($request['estado'] == 1){
            $notificacion->estado = $request['estado'];
            $notificacion->fecha_lectura = date('Y-m-d H:i:s');
            $notificacion->update();
            return response()->json([
                'res' => true,
                'msg' => 'Notificacion actualizada correctamente'
            ], 200);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Notificacion $notificacion)
    {
        $notificacion->delete();
        return response()->json([
            'res' => true,
            'msg' => 'Notificacion eliminada correctamente'
        ], 200);
    }
}

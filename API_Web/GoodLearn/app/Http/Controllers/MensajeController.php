<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
require_once('lib/prettyPrint.php');
use App\Models\{Mensaje, Usuario, Notificacion};
use App\Http\Requests\CreateMensaje;
use App\Http\Requests\UpdateMensaje;

class MensajeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Mensaje::all();
        return prettyMensaje($data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $input = $request->all();
        $mensaje = new Mensaje;
        $mensaje->fecha_creacion = date('Y-m-d H:i:s');
        $mensaje->fecha_modificacion = date('Y-m-d H:i:s');
        $mensaje->emisor_id = $input['emisor_id'];
        $mensaje->receptor_id = $input['receptor_id'];
        $mensaje->texto = $input['texto'];

        $notificacion = new Notificacion;
        $notificacion->usuario_id = $input['receptor_id'];
        $notificacion->tipo_id = 1;
        
        try{
            $mensaje->save();
            $notificacion->save();
        }catch(\Exception $e){
            return returnError('Mensaje creado correctamente.');
        }
        return returnSuccess('Mensaje creado correctamente', 'home');
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
            $mensajes = Mensaje::where('receptor_id', 'like', '%' . $request->text . '%')
            ->orWhere('emisor_id', 'like', '%' . $request->text . '%')
            ->orWhere('texto', 'like', '%' . $request->text . '%')
            ->orWhere('estado', 'like', '%' . $request->text . '%')
            ->orWhere('fecha_modificacion', 'like', '%' . $request->text . '%')
            ->orWhere('fecha_creacion', 'like', '%' . $request->text . '%')->get();
        }else{
            $mensajes = Mensaje::all();
        }
        return prettyMensaje($mensajes);
    }

    public function byIndex(Mensaje $mensaje)
    {
        return prettyMensaje($mensaje);
    
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Mensaje $mensaje)
    {
        $input = $request->all();

        $mensaje->fecha_modificacion = date('Y-m-d H:i:s');;
        if($request->texto != null){
            $mensaje->texto = $input['texto'];
        }

        if($request->estado != null){
            $mensaje->estado = $input['estado'];
        }

        
        try{
            $mensaje->update();
        }catch(\Exception $e){
            return returnError('Mensaje no moficado correctamente.');
        }
        return returnSuccess('Mensaje modificado correctamente', 'home');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Mensaje $mensaje)
    {
        $mensaje->delete();
        return response()->json([
            'res' => true,
            'msg' => 'Mensaje eliminado correctamente'
        ], 200);
    }
}

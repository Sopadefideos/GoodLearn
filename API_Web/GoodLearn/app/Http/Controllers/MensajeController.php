<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
require_once('lib/prettyPrint.php');
use App\Models\{Mensaje, Usuario};
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
    public function store(CreateMensaje $request)
    {
        $input = $request->all();
        $mensaje = new Mensaje;
        $mensaje->fecha_creacion = date('Y-m-d H:i:s');
        $mensaje->fecha_modificacion = date('Y-m-d H:i:s');
        $mensaje->emisor_id = $input['emisor_id'];
        $mensaje->receptor_id = $input['receptor_id'];
        $mensaje->texto = $input['texto'];

        $mensaje->save();
        return response()->json([
            'res' => true,
            'msg' => 'Mensaje creado correctamente'
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
    public function update(UpdateMensaje $request, Mensaje $mensaje)
    {
        $input = $request->all();

        $mensaje->fecha_modificacion = date('Y-m-d H:i:s');
        $mensaje->texto = $input['texto'];

        if($request->estado != null){
            $mensaje->estado = $input['estado'];
        }

        $mensaje->update();
        return response()->json([
            'res' => true,
            'msg' => 'Mensaje modificado correctamente'
        ], 200);
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

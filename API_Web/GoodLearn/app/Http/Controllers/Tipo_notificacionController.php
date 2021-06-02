<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\{Tipo_notificacion};
use App\Http\Requests\CreateTipoRequest;
use App\Http\Requests\UpdateTipoRequest;


class Tipo_notificacionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Tipo_notificacion::all();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateTipoRequest $request)
    {
        $input = $request->all();
        Tipo_notificacion::create($input);
        return response()->json([
            'res' => true,
            'msg' => 'Tipo de notificacion eliminado correctamente'
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
            $tipo = Tipo_notificacion::where('nombre_tipo', 'like', '%' . $request->text . '%')->orWhere('id', $request->text)->get();
        }else{
            $tipo = Tipo_notificacion::all();
        }
        return $tipo;
    }

    public function byIndex(Tipo_notificacion $tipo)
    {
        return $tipo; 
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateTipoRequest $request, Tipo_notificacion $tipo)
    {
        $input = $request->all();
        if($request->nombre_tipo == null){
            $input['nombre_tipo'] = $tipo->nombre_tipo;

        }elseif($request->titulo == null){
            $input['titulo'] = $tipo->titulo;

        }
        if($request->cuerpo == null){
            $input['cuerpo'] = $tipo->cuerpo;
        }
        $tipo->update($input);
        return response()->json([
            'res' => true,
            'msg' => 'Tipo de notificacion actualizado correctamente'
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Tipo_notificacion $tipo)
    {
        $tipo->delete();
        return response()->json([
            'res' => true,
            'msg' => 'Tipo de notificacion eliminado correctamente'
        ], 200);
    }
}

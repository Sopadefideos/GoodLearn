<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
require_once('lib/prettyPrint.php');
use App\Models\{Contenido, Asignatura};
use App\Http\Requests\CreateContenido;
use App\Http\Requests\UpdateContenido;

class ContenidoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Contenido::all();
        return prettyContenido($data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateContenido $request)
    {
        $input = $request->all();
        $contenido = new Contenido;
        $contenido->fecha_creacion = date('Y-m-d H:i:s');
        $contenido->fecha_modificacion = date('Y-m-d H:i:s');
        $contenido->asignatura_id = $input['asignatura_id'];
        $contenido->url_contenido = $input['url_contenido'];

        $contenido->save();
        return response()->json([
            'res' => true,
            'msg' => 'Contenido creado correctamente'
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
            $contenidos = Contenido::where('usuario_id', 'like', '%' . $request->text . '%')
            ->orWhere('url_contenido', 'like', '%' . $request->text . '%')
            ->orWhere('fecha_modificacion', 'like', '%' . $request->text . '%')
            ->orWhere('fecha_creacion', 'like', '%' . $request->text . '%')->get();
        }else{
            $contenidos = Contenido::all();
        }
        return prettyContenido($contenidos);
    }

    public function byIndex(Contenido $contenido)
    {
        return prettyContenido($contenido);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateContenido $request, Contenido $contenido)
    {
        $input = $request->all();

        if($request->asignatura_id == null){
            $input['asignatura_id'] = $contenido->asignatura_id;
        }

        if($request->url_contenido == null){
            $input['url_contenido'] = $contenido->url_contenido;
        }

        $input['fecha_modificacion'] = date('Y-m-d H:i:s');
        $input['fecha_creacion'] = $contenido->fecha_creacion;

        $contenido->update($input);
        return response()->json([
            'res' => true,
            'msg' => 'Contenido modificado correctamente'
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Contenido $contenido)
    {
        $contenido->delete();
        return response()->json([
            'res' => true,
            'msg' => 'Contenido eliminada correctamente'
        ], 200);
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
require_once('lib/prettyPrint.php');
use App\Models\{Nota, Asignatura, Usuario};
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

        $nota->save();
        return response()->json([
            'res' => true,
            'msg' => 'Nota creada correctamente'
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

        if($request->asignatura_id == null){
            $input['asignatura_id'] = $nota->asignatura_id;
        }

        if($request->usuario_id == null){
            $input['usuario_id'] = $nota->usuario_id;
        }

        if($request->nota == null){
            $input['nota'] = $nota->nota;
        }

        if($request->titulo == null){
            $input['titulo'] = $nota->titulo;
        }

        if($request->cuerpo == null){
            $input['cuerpo'] = $nota->cuerpo;
        }

        $input['fecha_modificacion'] = date('Y-m-d H:i:s');
        $input['fecha_creacion'] = $nota->fecha_creacion;

        $nota->update($input);
        return response()->json([
            'res' => true,
            'msg' => 'Nota modificada correctamente'
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Nota $nota)
    {
        $nota->delete();
        return response()->json([
            'res' => true,
            'msg' => 'Nota eliminada correctamente'
        ], 200);
    }
}

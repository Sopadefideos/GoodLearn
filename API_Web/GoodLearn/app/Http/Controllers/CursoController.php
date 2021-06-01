<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\{Curso};
use App\Http\Requests\CreateCursoRequest;
use App\Http\Requests\UpdateCursoRequest;

class CursoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Curso::all();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateCursoRequest $request)
    {
        $input = $request->all();
        Curso::create($input);
        return response()->json([
            'res' => true,
            'msg' => 'Curso creado correctamente'
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
            $cursos = Curso::where('name', 'like', '%' . $request->text . '%')
            ->orWhere('fecha_inicio', 'like', '%' . $request->text . '%')
            ->orWhere('fecha_fin', 'like', '%' . $request->text . '%')->get();
        }else{
            $cursos = Curso::all();
        }
        return $cursos;
    }

    public function byIndex(Curso $curso)
    {
        return $curso; 
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateCursoRequest $request, Curso $curso)
    {
        $input = $request->all();
        
        if($request->name == null){
            $input['name'] = $curso->name;
        }

        if($request->fecha_inicio == null){
            $input['fecha_inicio'] =  $curso->fecha_inicio;
        }

        if($request->fecha_fin == null){
            $input['fecha_fin'] =  $curso->fecha_fin;
        }

        $curso->update($input);
        return response()->json([
            'res' => true,
            'msg' => 'Curso actualizado correctamente'
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Curso $curso)
    {
        $curso->delete();
        return response()->json([
            'res' => true,
            'msg' => 'Curso eliminado correctamente'
        ], 200);
    }
}

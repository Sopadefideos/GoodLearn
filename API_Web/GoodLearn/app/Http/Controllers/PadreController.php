<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\{Usuario, Rol, Padre};
require_once('lib/prettyPrint.php');


class PadreController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Padre::all();
        return prettyPadre($data);
    }

    public function content(Usuario $padre){
        $padres = prettyPadre(Padre::where('padre_id', $padre['id'])->get());
        return view('pages.usuarios.padres.padres', ['padres' => $padres, 'padre' => $padre]);
    }

    public function create(Usuario $padre){
        $usuarios = prettyUser(Usuario::where('rol_id', "3")->get());
        return view('pages.usuarios.padres.FormCreatePadre', ['padre' => $padre, 'alumnos' => $usuarios]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Usuario $padre)
    {
        $input = $request->all();
        $hijo = new Padre;

        $hijo->padre_id = $padre->id;
        $hijo->alumno_id = $input['alumno_id'];

        try{
            $hijo->save();
        }catch(\Exception $e){
            return returnError('El alumno no ha sido asignado correctamente.');
        }
        return returnSuccess('El alumno ha sido asignado al padre.', 'usuarios');
         
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }


    public function edit(Padre $padre){
        $usuarios = prettyUser(Usuario::where('rol_id', "3")->get());
        return view('pages.usuarios.padres.FormUpdatePadre', ['padre' => $padre, 'alumnos' => $usuarios]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Padre $padre)
    {
        $input = $request->all();

        if($input['alumno_id'] != null){
            $padre->alumno_id = $input['alumno_id'];
        }
    
        try{
            $padre->update();
        }catch(\Exception $e){
            return returnError('El alumno no ha sido editado correctamente.');
        }
        return returnSuccess('El alumno ha sido editado.', 'usuarios');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Padre $padre)
    {
        try{
            $padre->delete();
        }catch(\Exception $e){
            return returnError('El alumno no ha sido eliminado correctamente.');
        }
        return returnSuccess('El alumno ha sido eliminado de la lista del padre.', 'usuarios');
    }
}

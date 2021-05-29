<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Rol;
use App\Http\Requests\CreateRolRequest;
use App\Http\Requests\UpdateRolRequest;

class RolController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Rol::all();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateRolRequest $request)
    {
        $input = $request->all();
        Rol::create($input);
        return response()->json([
            'res' => true,
            'msg' => 'Rol creado correctamente'
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
            $roles = Rol::where('name', 'like', '%' . $request->text . '%')->orWhere('id', $request->text)->get();
        }else{
            $roles = Rol::all();
        }
        return $roles;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function byIndex(Rol $rol)
    {
        return $rol; 
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateRolRequest $request, Rol $rol)
    {
        $input = $request->all();
        $rol->update($input);
        return response()->json([
            'res' => true,
            'msg' => 'Rol actualizado correctamente'
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Rol $rol)
    {   return $rol;
        $rol->delete();
        return response()->json([
            'res' => true,
            'msg' => 'Rol eliminado correctamente'
        ], 200);
    }
}

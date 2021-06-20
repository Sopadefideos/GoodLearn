<?php

function returnError($mensaje){
    if (request()->wantsJson()) {
        return response()->json([
            'res' => true,
            'msg' => $mensaje
        ], 200);
    }
    return redirect()->back()->with('error', $mensaje);
}

function returnSuccess($mensaje, $ruta){
    if (request()->wantsJson()) {
        return response()->json([
            'res' => true,
            'msg' => $mensaje
        ], 200);
    }
    return redirect()->route($ruta)->with('success', $mensaje);
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\tb_gps;
use Illuminate\Support\Facades\Response;

class GpsController extends Controller
{
    public function index(tb_gps $gps)
    {
        return $gps->get();
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        $gps = new tb_gps;

        $gps->direccion = $request->direccion;
        $gps->lat = $request->lat;
        $gps->lon = $request->lon;

        if ($gps->save()) {
            return response()->json($gps, 200);
        }
    }

    public function show($id)
    {
        return tb_gps::where('id', $id)->get();
    }

    public function edit($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        $gps = tb_gps::find($id);

        $gps->direccion = $request->direccion;
        $gps->lat = $request->lat;
        $gps->lon = $request->lon;

        if ($gps->save()) {
            return response()->json($gps, 200);
        }
    }

    public function destroy($id)
    {
        $gps = tb_gps::find($id);
        /*$respuesta = $gps->delete();*/
        if ($gps->delete()) {
            return response()->json('Se ha eliminado', 200);
        }
    }
}

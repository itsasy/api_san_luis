<?php

namespace App\Http\Controllers;

use App\Models\tb_evacuationspoints;
use Illuminate\Http\Request;
use Storage;
use File;
use Exception;

class PointsController extends Controller
{
    public function index()
    {
        return tb_evacuationspoints::get();
    }

    public function store(Request $request, tb_evacuationspoints $places)
    {
        try{
            $places->name_place = $request->get('name_place');
            $places->latitude_place = $request->get('latitude_place');
            $places->length_place = $request->get('length_place');
            $places->address_place = $request->get('address_place');
            
            
            if($request->hasFile('img') && $request->file('img')->isValid())
    		{
        		$image = $request->file('img');
        		$filename = $request->file('img')->getClientOriginalName();
        		
        		Storage::disk('blog')->put($filename,  File::get($image));
        		
        		$places->img = $filename;
    		}
            
            $places->save();
            return response()->json(['type' => 'success', 'message' => 'Se ha registrado', 'id' => $places->id], 200);

        }catch(Exception $e){
            return response()->json(['type' => 'error', 'message' => $e->getMessage()], 500);
        }
    }

    public function show($id)
    {
        try {
            $point = tb_evacuationspoints::where('id', $id)->first();
            if ($point == null){
                throw new Exception('Registro no encontrado');
            }
            return $point;
        } catch (Exception $e) {
            return response()->json(['type' => 'error', 'message' => $e->getMessage()], 500);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $places = tb_evacuationspoints::find($id);
            
            if ($request->has('name_place')) {
                $places->name_place = $request->get('name_place');
            }
            if ($request->has('latitude_place')) {
                $places->latitude_place = $request->get('latitude_place');
            }
            if ($request->has('length_place')) {
                $places->length_place = $request->get('length_place');
            }
            if ($request->has('address_place')) {
                $places->address_place = $request->get('address_place');
            }
            
            if ($request->hasFile('img') && $request->file('img')->isValid()) {
                Storage::disk('blog')->delete($places->img);
                
        		$imagen = $request->file('img');
        		$filename = $request->file('img')->getClientOriginalName();
        		
        		Storage::disk('blog')->put($filename,  File::get($imagen));
        		
        	    $places->img = $filename;

            }
            $places->save();
            return response()->json(['type' => 'success', 'message' => 'Actualización registrada'], 200);
        } catch (Exception $e) {
            return response()->json(['type' => 'error', 'message' => $e->getMessage()], 500);
        }
    }

    public function destroy($id)
    {
        try {
            $places = tb_evacuationspoints::find($id);
            Storage::disk('blog')->delete($places->img);
            if ($places == null) {
                throw new \Exception('Registro no encontrado');
            }
            $places->delete();
            return response()->json(['type' => 'success', 'message' => 'Eliminado correctamente'], 200);
        } catch (Exception $e) {
            return response()->json(['type' => 'error', 'message' => $e->getMessage()], 500);
        }
    }
}

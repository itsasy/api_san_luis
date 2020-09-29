<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\tb_places;
use Storage;
use File;
use Exception;

class PlacesController extends Controller
{
    public function index()
    {
        return tb_places::get();
    }

    public function store(Request $request, tb_places $places)
    {
        try{
            $places->name_place = $request->get('name_place');
            $places->latitude_place = $request->get('latitude_place');
            $places->length_place = $request->get('length_place');
            
            if($request->hasFile('img') && $request->file('img')->isValid())
    		{
        		$image = $request->file('img');
        		$filename = $request->file('img')->getClientOriginalName();
        		
        		Storage::disk('blog')->put($filename,  File::get($image));
        		
        		$places->img = $filename;
    		}

            if($request->has('website')){
                $places->website = $request->get('website');
            }
            
            $places->type_place = $request->get('type_place');
            $places->RUC = $request->get('RUC');
            $places->address_place = $request->get('address_place');
            $places->ubication_maps = $request->get('ubication_maps');

            
            $places->save();
            return response()->json(['type' => 'success', 'message' => 'Se ha registrado', 'id' => $places->id], 200);

        }catch(Exception $e){
            return response()->json(['type' => 'error', 'message' => $e->getMessage()], 500);
        }
    }

    public function show($id)
    {
        return tb_places::where('id', $id)->get();
    }

    public function placesType($type)
    {
        return tb_places::where('type_place', $type)->get();
    }
    
    public function update(Request $request, $id)
    {
        try {
            $places = tb_places::find($id);
            
            if ($request->has('name_place')) {
                $places->name_place = $request->get('name_place');
            }
            if ($request->has('latitude_place')) {
                $places->latitude_place = $request->get('latitude_place');
            }
            if ($request->has('length_place')) {
                $places->length_place = $request->get('length_place');
            }
            if ($request->hasFile('img') && $request->file('img')->isValid()) {
                Storage::disk('blog')->delete($places->img);
                
        		$imagen = $request->file('img');
        		$filename = $request->file('img')->getClientOriginalName();
        		
        		Storage::disk('blog')->put($filename,  File::get($imagen));
        		
        	    $places->img = $filename;
            }
            
            if ($request->has('website')) {
                $places->website = $request->get('website');
            }
            if ($request->has('RUC')) {
                $places->RUC = $request->get('RUC');
            }
            if ($request->has('type_place')) {
                $places->type_place = $request->get('type_place');
            }
            if ($request->has('address_place')) {
                $places->address_place = $request->get('address_place');
            }
            if ($request->has('ubication_maps')) {
                $places->ubication_maps = $request->get('ubication_maps');
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
            $places = tb_places::find($id);
            if ($places == null) {
                throw new \Exception('Registro no encontrado');
            }
            Storage::disk('blog')->delete($places->img);
            $places->delete();
            return response()->json(['type' => 'success', 'message' => 'Eliminado correctamente'], 200);
        } catch (Exception $e) {
            return response()->json(['type' => 'error', 'message' => $e->getMessage()], 500);
        }
   }
}

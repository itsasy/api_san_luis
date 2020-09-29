<?php

namespace App\Http\Controllers;

use App\Models\tb_institutions;
use Illuminate\Http\Request;
use Storage;
use File;
use Exception;

class InstitutionsController extends Controller
{
    public function index()
    {
        return tb_institutions::get();
    }

    public function store(Request $request, tb_institutions $places)
    {
        try{
            $places->name_place = $request->get('name_place');
            $places->latitude_place = $request->get('latitude_place');
            $places->length_place = $request->get('length_place');
            $places->type_place = $request->get('type_place');
            $places->address_place = $request->get('address_place');
            $places->state = $request->get('state');
            
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
            
            $places->save();
            return response()->json(['type' => 'success', 'message' => 'Se ha registrado', 'id' => $places->id], 200);

        }catch(Exception $e){
            return response()->json(['type' => 'error', 'message' => $e->getMessage()], 500);
        }
    }

    public function show($id)
    {
        return tb_institutions::where('id', $id)->get();
    }

    public function update(Request $request, $id)
    {
        try {
            $places = tb_institutions::find($id);
            
            if ($request->has('name_place')) {
                $places->name_place = $request->get('name_place');
            }
            if ($request->has('latitude_place')) {
                $places->latitude_place = $request->get('latitude_place');
            }
            if ($request->has('length_place')) {
                $places->length_place = $request->get('length_place');
            }
            if ($request->has('type_place')) {
                $places->type_place = $request->get('type_place');
            }
            if ($request->has('address_place')) {
                $places->address_place = $request->get('address_place');
            }
            if ($request->has('state')) {
                $places->state = $request->get('state');
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
            
            $places->save();
            return response()->json(['type' => 'success', 'message' => 'Actualización registrada'], 200);
        } catch (Exception $e) {
            return response()->json(['type' => 'error', 'message' => $e->getMessage()], 500);
        }
    
    }

    public function destroy($id)
    {
        try {
            $places = tb_institutions::find($id);
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

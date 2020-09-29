<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Response;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\Exportable;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\Request;
use App\Models\tb_alerts;
use Storage;
use App\Events\NuevaAlerta;

class AlertController extends Controller
{
    public function index()
    {
        return  tb_alerts::with('info_user')->orderBy('date_alert','DESC')->get();
    }
    
    
    // Función generar Alerta
    public function store(Request $request, tb_alerts $alerts)
    {
        date_default_timezone_set('America/Lima');
        $date = date("Y").'-'.date("m").'-'.date("d").' '.(date('H')).':'.date('i').':'.date('s');

        $alerts->code_user_alert = $request->code_user_alert;
        $alerts->address_alert = $request->address_alert;
        $alerts->latitude_alert = $request->latitude_alert;
        $alerts->date_alert = $date;
        $alerts->length_alert = $request->length_alert;
        $alerts->type_alert = $request->type_alert;

        if ($alerts->save()) {
            broadcast(new NuevaAlerta("alertaInsertada"));
            return response()->json($alerts, 200);
        }
    }
    
    // Función agregar Imagen y Comentario
    public function actualizarAlerta(Request $request, tb_alerts $alerts)
    {
        $alerts = tb_alerts::find($request->get('id'));
        
        if($request->has('comentary')){
            $alerts->comentary  = $request->get('comentary');
        }
        
        if($request->hasFile('image') && $request->file('image')->isValid())
    	{
        	$image = $request->file('image');
        	$filename = $request->file('image')->getClientOriginalName();
        	
        	Storage::disk('alerts')->put($filename,  File::get($image));
        		
        	$alerts->image = $filename;
    	}
    	


        if ($alerts->save()) {
            return response()->json($alerts, 200);
        }
    }
    
    public function show($type)
    {
        /*  return tb_alerts::where('id', $id)->get(); */
        return tb_alerts::where('type_alert', 'like', "%{$type}%")->get();
    }
    
    public function unattendedAlert()
    {
        $data = tb_alerts::where('attended_alert', '0')->with('info_user')->get();
        return $data;
    }
    
    
    public function unattendedAlerts_U2()
    {
        $type_alerts = ['MUNSER001' , 'MUNSER002', 'MUNSER003'];
        
        $data = tb_alerts::whereIn('type_alert', $type_alerts)
        ->where('attended_alert', '0')
        ->with('info_user')->get();
        
        return $data;
    }

    public function unattendedAlerts_U3()
    {
        $data = tb_alerts::where('type_alert', 'MUNSER004')->where('attended_alert', '0')->with('info_user')->get();
        return $data;
    }
    public function unattendedAlerts_U4()
    {
        $data = tb_alerts::where('type_alert', 'MUNSER005')->where('attended_alert', '0')->with('info_user')->get();
        return $data;
    }
    
    public function update($id)
    {
        $alerts = tb_alerts::find($id);
        $alerts->attended_alert = 1;

        if ($alerts->save()) {
            broadcast(new NuevaAlerta("cambio-registrado"));
            return response()->json($alerts, 200);
        }
       
    }
    public function destroy($id)
    {
        try{
            $alerts = tb_alerts::find($id);
            if ($alerts == null){
                
                throw new Exception('Registro no encontrado');
            }
        $alerts->delete();
        Storage::disk('alerts')->delete($alerts->image);
        
        return response()->json(['type' => 'success', 'message' => 'Registro eliminado'], 200);
        } catch (Exception $e) {
            return response()->json(['type' => 'error', 'message' => $e->getMessage()], 500);
        }
    }

    public function alertsUser($cod){
        try{
            $alerts = tb_alerts::where('code_user_alert', $cod)->orderBy('date_alert','DESC')->get();
            if($alerts == null){
                throw new Exception('Registro no encontrado');
            }
            return $alerts;
        }catch(Exception $e){
            return response()->json(['type' => 'error', 'message' => $e->getMessage()], 500);
        }
    }
    
    public function image($fileName)
    {
        $path = public_path() . '/images/Alerts/' . $fileName;
        return Response::download($path);
    }
    
    public function CreateExcel($fecha_incio,$fecha_fin) {
        date_default_timezone_set('America/Lima');
        
       $filename = 'Excel_'.date("d").'-'.date("m").'-'.date("Y").' '.(date('H')).':'.date('i').':'.date('s').'.xlsx';
   
       $exc = Excel::store(new ExcelController($fecha_incio,$fecha_fin),$filename,'excel');
       return response()->json(['type'=> 'success', 'message' => $filename], 200);
       //return Excel::download(new ExcelController($fecha_incio,$fecha_fin),$filename);
    //    $ALERTAS = tb_alerts::whereBetween('date_alert', ['2019-11-29 16:56:17', '2019-11-29 19:56:17'])->get();
    }
    
    public function DownloadExcel($opcion, $nombreExcel){
        
        try
        {
            $file = '';  
            if ($opcion == 'excel') {
                $file = public_path()."/excel/".$nombreExcel;
            }
            
            $b64Doc = chunk_split(base64_encode(file_get_contents($file)));
            return response()->json(['type' => 'success','message' => $b64Doc], 200);
            
            
        }
        catch(\Exception $e)
        {
            return response()->json(['type' => 'alert','message' => 'Excel no encontrado'], 200);
        }
    }
    
    // Funciones "comunicación tiempo real"
    
    
    public function testComunication() {
        broadcast(new NuevaAlerta("mensaje"));
        return response()->json(['type' => 'success', 'message' => 'enviado'], 200); 
    }

}

<?php
namespace App\Http\Controllers;

use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\Exportable;
use Illuminate\Contracts\View\View;
use App\Models\tb_alerts;
use App\Models\tb_persons;
use App\Models\tb_municipal_services;


class ExcelController implements FromView{
    
    use Exportable;

    public function __construct($fecha_inicio,$fecha_fin) {
       // $fecha_inicio = $fecha_fin = date('Y-m-d');
        $this->fecha_inicio = $fecha_inicio.' 00:00:00';
        $this->fecha_fin = $fecha_fin.' 23:59:59';

    }

    public function view():View{
        

        $ALERTAS = tb_alerts::whereBetween('date_alert', [$this->fecha_inicio , $this->fecha_fin])->get();
          foreach($ALERTAS as $alertas)
            {
                 $alertas->usuario = tb_persons::where('code_pers', $alertas->code_user_alert)->get();
                 $alertas->municipal = tb_municipal_services::where('code_munser', $alertas->type_alert)->get();

            }

     $exc = view('excel', [
            'data' =>$ALERTAS
        ]);

        return $exc;
        
    }
    
}
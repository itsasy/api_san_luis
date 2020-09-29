<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\tb_alerts;
use Carbon\Carbon;

class stadisticsController extends Controller
{
    //Contadores del tipo de servicio según la alerta para el gráfico
    function MUNSER001($month)
    {
        return  tb_alerts::where('type_alert', 'MUNSER001')->whereMonth('date_alert', $month)->get()->count();
    }
    function MUNSER002($month)
    {
        return  tb_alerts::where('type_alert', 'MUNSER002')->whereMonth('date_alert', $month)->get()->count();
    }
    function MUNSER003($month)
    {
        return  tb_alerts::where('type_alert', 'MUNSER003')->whereMonth('date_alert', $month)->get()->count();
    }
    function MUNSER004($month)
    {
        return  tb_alerts::where('type_alert', 'MUNSER004')->whereMonth('date_alert', $month)->get()->count();
    }
    function MUNSER005($month)
    {
        return  tb_alerts::where('type_alert', 'MUNSER005')->whereMonth('date_alert', $month)->get()->count();
    }
    function MUNSER006($month)
    {
        return  tb_alerts::where('type_alert', 'MUNSER006')->whereMonth('date_alert', $month)->get()->count();
    }
    function MUNSER007($month)
    {
        return  tb_alerts::where('type_alert', 'MUNSER007')->whereMonth('date_alert', $month)->get()->count();
    }
    function MUNSER008($month)
    {
        return  tb_alerts::where('type_alert', 'MUNSER008')->whereMonth('date_alert', $month)->get()->count();
    }
    function alertsMonth()
    {
        $month_array = array();
        $date_alert = tb_alerts::orderBy('date_alert', 'ASC')->pluck('date_alert');
        $date_alert = json_decode($date_alert);

        if (!empty($date_alert)) {
            foreach ($date_alert as $unformatted_date) {
                $date = Carbon::parse($unformatted_date);
                $month_no = $date->format('m');
                $month_name = $date->format('F');
                $month_array[$month_no] = $month_name;
            }
        }
        return $month_array;
    }
    function getMonthlyAlertData()
    {
        //Array para almacenar las alertas según el tipo
        $MUNSER001 = array();
        $MUNSER002 = array();
        $MUNSER003 = array();
        $MUNSER004 = array();
        $MUNSER005 = array();
        $MUNSER006 = array();
        $MUNSER007 = array();
        $MUNSER008 = array();

        $month_array = $this->alertsMonth();
        $month_name_array = array();
        if (!empty($month_array)) {
            foreach ($month_array as $month_nro => $month_name) {
                //Contando las alertas según el mes
                $alert1 = $this->MUNSER001($month_nro);
                $alert2 = $this->MUNSER002($month_nro);
                $alert3 = $this->MUNSER003($month_nro);
                $alert4 = $this->MUNSER004($month_nro);
                $alert5 = $this->MUNSER005($month_nro);
                $alert6 = $this->MUNSER006($month_nro);
                $alert7 = $this->MUNSER007($month_nro);
                $alert8 = $this->MUNSER008($month_nro);

                //Iguala los datos devueltos
                array_push($MUNSER001, $alert1);
                array_push($MUNSER002, $alert2);
                array_push($MUNSER003, $alert3);
                array_push($MUNSER004, $alert4);
                array_push($MUNSER005, $alert5);
                array_push($MUNSER006, $alert6);
                array_push($MUNSER007, $alert7);
                array_push($MUNSER008, $alert8);
                //Iguala los meses al array
                array_push($month_name_array, $month_name);
            }
        }

        //Editar la comparación
        $max_no = tb_alerts::get()->count();

        $max = round(($max_no + 10 / 2) / 10) * 10;

        $monthly_alerts_data_array = array(
            'months' => $month_name_array,
            'alerts_countMun1' => $MUNSER001,
            'alerts_countMun2' => $MUNSER002,
            'alerts_countMun3' => $MUNSER003,
            'alerts_countMun4' => $MUNSER004,
            'alerts_countMun5' => $MUNSER005,
            'alerts_countMun6' => $MUNSER006,
            'alerts_countMun7' => $MUNSER007,
            'alerts_countMun8' => $MUNSER008,
            'max' => $max

        );

        return $monthly_alerts_data_array;
    }
}

<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;

class PolygonController extends Controller{
        
    //OBTENER EL ESULTADO SI ESTA DENTRO DEL POLIGONO
    
    public function obtenerresultados($LATITUD,$LONGITUD){
        try{

           $polygon = array(
         /* "-12.076939 -77.010113" ,"-12.076998 -77.010159" , "-12.077349 -77.010302" , "-12.078120 -77.010350" , "-12.078249 -77.010356" , "-12.079028 -77.009938",
          "-12.079844 -77.008952" ,"-12.080345 -77.007548" , "-12.080734 -77.006296" , "-12.081495 -77.005139" , "-12.082589 -77.004437" , "-12.083294 -77.004228", 
          "-12.084099 -77.004142" ,"-12.083641 -77.000991" , "-12.082587 -76.997619" , "-12.081548 -76.995728" , "-12.081194 -76.994225" , "-12.080982 -76.993576" ,
          "-12.081674 -76.993437" ,"-12.081418 -76.992962" , "-12.081744 -76.992850" , "-12.081661 -76.989592" , "-12.081453 -76.989339" , "-12.079996 -76.987254",
          "-12.074134 -76.991802" ,"-12.072390 -76.988547" , "-12.071961 -76.988723" , "-12.071599 -76.988859" , "-12.071361 -76.988898" , "-12.071189 -76.988908"  ,
          "-12.071046 -76.988878" ,"-12.064034 -76.987185" , "-12.064304 -76.988832" , "-12.064323 -76.990118" , "-12.064124 -76.992367" , "-12.063727 -76.997216" ,
          "-12.063554 -76.998906" ,"-12.063418 -77.000106" , "-12.068340 -76.996338" , "-12.070993 -77.001042" , "-12.075316 -77.008596" , "-12.076946 -77.010119"
        */
         "-12.076939 -77.010113", "-12.076998 -77.010159", "-12.077349 -77.010302", "-12.078120 -77.010350", "-12.078249 -77.010356", 
         "-12.079028 -77.009938", "-12.079844 -77.008952", "-12.080345 -77.007548", "-12.080734 -77.006296", "-12.081495 -77.005139",
         "-12.082589 -77.004437", "-12.083294 -77.004228", "-12.084099 -77.004142", "-12.083641 -77.000991", "-12.082587 -76.997619", 
         "-12.081548 -76.995728", "-12.081194 -76.994225", "-12.080982 -76.993576", "-12.081674 -76.993437", "-12.081418 -76.992962", 
         "-12.081744 -76.992850", "-12.081661 -76.989592", "-12.081453 -76.989339", "-12.079996 -76.987254", "-12.074134 -76.991802", 
         "-12.072390 -76.988547", "-12.071961 -76.988723", "-12.071599 -76.988859", "-12.071361 -76.988898", "-12.071189 -76.988908", 
         "-12.071046 -76.988878", "-12.064034 -76.987185", "-12.064304 -76.988832", "-12.064323 -76.990118", "-12.064124 -76.992367", 
         "-12.063778 -76.996888", "-12.063339 -76.997145", "-12.063003 -76.997552", "-12.062908 -76.997745", "-12.062868 -76.997950", 
         "-12.060861 -76.997884", "-12.060609 -76.998322", "-12.060121 -76.998720", "-12.060269 -76.999557", "-12.060558 -76.999859", 
         "-12.061459 -76.999980", "-12.061727 -77.001131", "-12.061998 -77.001214", "-12.061501 -77.003140", "-12.062437 -77.003435", 
         "-12.062918 -77.002397", "-12.063401 -77.000124", "-12.063418 -77.000106", "-12.068340 -76.996338", "-12.070993 -77.001042", 
         "-12.075316 -77.008596", "-12.076946 -77.010119"
       );
            //$points = LATITUD - LONGITUD
           $points = array("$LATITUD $LONGITUD");
        
            foreach($points as $key => $point) {
             $valor =  $this->pointInPolygon($point,$polygon);
            }
          return response()->json(['type' => 'success', 'message' => $valor ], 200);
            
         }catch(\Exception $e){
            return response()->json(['type' => 'error', 'message' =>  $e->getMessage() ], 500);

         }
    }

    public function pointInPolygon($point, $polygon, $pointOnVertex = true) {
             $pointOnVertex = true; // Check if the point sits exactly on one of the vertices?

            

        $this->pointOnVertex = $pointOnVertex;

        // Transform string coordinates into arrays with x and y values
        $point = $this->pointStringToCoordinates($point);
        $vertices = array(); 
        foreach ($polygon as $vertex) {
            $vertices[] = $this->pointStringToCoordinates($vertex); 
        }

        // Check if the point sits exactly on a vertex
        if ($this->pointOnVertex == true and $this->pointOnVertex($point, $vertices) == true) {
            return "vertex";
        }

        // Check if the point is inside the polygon or on the boundary
        $intersections = 0; 
        $vertices_count = count($vertices);

        for ($i=1; $i < $vertices_count; $i++) {
            $vertex1 = $vertices[$i-1]; 
            $vertex2 = $vertices[$i];
            if ($vertex1['y'] == $vertex2['y'] and $vertex1['y'] == $point['y'] and $point['x'] > min($vertex1['x'], $vertex2['x']) and $point['x'] < max($vertex1['x'], $vertex2['x'])) { // Check if point is on an horizontal polygon boundary
                return "boundary";
            }
            if ($point['y'] > min($vertex1['y'], $vertex2['y']) and $point['y'] <= max($vertex1['y'], $vertex2['y']) and $point['x'] <= max($vertex1['x'], $vertex2['x']) and $vertex1['y'] != $vertex2['y']) { 
                $xinters = ($point['y'] - $vertex1['y']) * ($vertex2['x'] - $vertex1['x']) / ($vertex2['y'] - $vertex1['y']) + $vertex1['x']; 
                if ($xinters == $point['x']) { // Check if point is on the polygon boundary (other than horizontal)
                    return "boundary";
                }
                if ($vertex1['x'] == $vertex2['x'] || $point['x'] <= $xinters) {
                    $intersections++; 
                }
            } 
        } 
        // If the number of edges we passed through is odd, then it's in the polygon. 
        if ($intersections % 2 != 0) {
            return "Dentro del rango";
        } else {
            return "Fuera del rango";
        }
    }

    public function pointOnVertex($point, $vertices) {
        foreach($vertices as $vertex) {
            if ($point == $vertex) {
                return true;
            }
        }

    }

    public function pointStringToCoordinates($pointString) {
        $coordinates = explode(" ", $pointString);
        return array("x" => $coordinates[0], "y" => $coordinates[1]);
    }
}
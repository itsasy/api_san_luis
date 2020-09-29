<?php

namespace App\Http\Controllers;

use App\Models\tb_persons;
use App\Models\tb_users;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function store(Request $request)
    {
        $username = $request->username;

        //Comprueba si existe en la tabla personas
        /*if (tb_persons::where('code_pers', '=', $username)->exists()) {
            //Obtiene el primer dato resultante desde la tabla usuarios
            $Usuario = tb_users::where('code_user', '=', $username)->first();
            //Obtiene el password tras descomprimir el usuario obtenido
            $password = json_decode(json_encode($Usuario), true)['password_user'];
            //Compara el password con el ingresado
            if ($password == $request->password) {
                //Retorna los datos existentes del usuario logeado
                return response()->json(tb_persons::where('code_pers', '=', $username)->first());
            } else {
                return array('error' => 'Credenciales no válidas');
            }
        } else {
            return array('error' => 'El usuario no existe');
        }*/
        
        // if (tb_users::where('username_user', '=', $username)->exists()) {
        //     $Usuario = tb_users::where('username_user', '=', $username)->first();
        //     $password = json_decode(json_encode($Usuario), true)['password_user'];
        //     $cod_pers = json_decode(json_encode($Usuario), true)['code_user'];
        //     if ($password == $request->password) {
        //         return response()->json(tb_persons::where('code_pers', '=', $cod_pers)->with('info_user')->first());
        //     } else {
        //         return array('error' => 'Credenciales no válidas');
        //     }
        // } else {
        //     return array('error' => 'El usuario no existe');
        // }
        

         // Nuevo método
         if (tb_users::where('username_user', '=', $username)->exists()) {
             
            $Usuario = tb_users::where('username_user', '=', $username)->first();
            
            if (Hash::check($request->password, $Usuario->password_user))
            {
                return response()->json(tb_persons::where('code_pers', '=', $Usuario->code_user)->with('info_user')->first());
            }else{
                return array('error' => 'Credenciales no válidas');
            }
            
        } else {
            return array('error' => 'El usuario no existe');
        }
        
        
        
        
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\ValidarFormularioRequest;
use Illuminate\Support\Facades\Hash;
use App\Models\tb_persons;
use App\Models\tb_users;
use App\Models\tb_gender;
use App\Models\tb_userType;
use App\Mail\CorreosMail;
use Illuminate\Support\Facades\Mail;

class PersonsController extends Controller
{
    public function index(tb_persons $persons)
    {
        return $persons->get();
    }

    public function gender()
    {
        return tb_gender::get();
    }
    
    public function userType($id)
    {
        $type = tb_userType::where('id', $id)->get();
        return $type;
    }
    
    public function store(ValidarFormularioRequest $request, tb_persons $persons, tb_users $users)
    {
     
     
        
        // $persona = new tb_persons();   
        //dd($request->all());
        $max_user = tb_persons::max('code_pers');
        
        $num = ltrim(substr($max_user, 3));

        if ($num >= 1 and $num <= 8) {
            $num++;
            $cod_user = 'USR000' . $num;
        } else if ($num >= 9 and $num <= 98) {
            $num++;
            $cod_user = 'USR00' . $num;
        } else if ($num >= 99 and $num <= 998) {
            $num++;
            $cod_user = 'USR0' . $num;
        } else if ($num >= 999 and $num <= 9998) {
            $num++;
            $cod_user = 'USR' . $num;
        } else {
            $cod_user = 'USR0001';
        }

        //Persona
        /*$persons->code_pers = $cod_user;
        $persons->name_pers = $request->name_pers;
        $persons->patname_pers = $request->patname_pers;
        $persons->matname_pers = $request->matname_pers;
        $persons->id_pers = $request->id_pers;
        $persons->phone_pers = $request->phone_pers;*/

        $persons->code_pers = $cod_user;
        $persons->name_pers = $request->name_pers;
        $persons->patname_pers = $request->patname_pers;
        $persons->matname_pers = $request->matname_pers;
        $persons->birthdate = $request->birthdate;
        $persons->gender_id = $request->gender_id;
        $persons->address_persons = $request->address_persons;
        $persons->dni_pers = $request->dni_pers;
        $persons->email = $request->email;
        $persons->phone_pers = $request->phone_pers;
        

        try{
           if ($request->phoneTwo_pers != null)
           {
               $persons->phoneTwo_pers = $request->phoneTwo_pers;
           } 
        }catch(\Exception $e){
            $persons->phoneTwo_pers = 0;
        }
        
        
        //Contraseña
        $users->code_user = $cod_user;
        $users->username_user = $request->dni_pers;
        $auto_password = substr($persons->patname_pers,0,3).substr($request->dni_pers,0,5);
        $users->password_user = bcrypt($auto_password);
        $users->type_id = 5;
        
        //User
        /* $users->password_user = $request->password_user; */
        //Método incompleto, falta el usuario autogenerado y password
                    /*$users->code_user = $cod_user;
                    $users->username_user = $request->username_user;
                    $users->password_user = $request->dni_pers;
                    $users->type_id = 4;
                    */
        // Probar:
        //dd($users->all());
        
        // Probar:
        //dd($persons);
        
        // ENVIO DE CORREO
        //dd($auto_password. " - ".$request->email );
        $this->enviarCorreo($auto_password, $request->email);
        
        if ($users->save() and $persons->save()) {
            return response()->json($persons, 200);
        }
    }
    
    // FUNCION DE ENVIO DE CORREOS
    public function enviarCorreo($contrasena, $correo_usuario)
        {
            Mail::to($correo_usuario)->send(new CorreosMail($contrasena));
        }

    public function show($id)
    {
        return tb_persons::where('id', $id)->get();
    }

    public function update(Request $request, $id)
    {
        $persons = tb_persons::find($id);
        $users = tb_users::where('code_user', $persons->code_pers)->first();


        if ($request->has('name_pers')) {
            $persons->name_pers = $request->name_pers;
        }
        if ($request->has('patname_pers')) {
            $persons->patname_pers = $request->get('patname_pers');
        }
        if ($request->has('matname_pers')) {
            $persons->matname_pers = $request->get('matname_pers');
        }
        if ($request->has('birthdate')) {
            $persons->birthdate = $request->get('birthdate');
        }
        if ($request->has('gender_id')) {
            $persons->gender_id = $request->get('gender_id');
        }
        if ($request->has('address_persons')) {
            $persons->address_persons = $request->get('address_persons');
        }
        if ($request->has('email')) {
            $persons->email = $request->get('email');
        }
        if ($request->has('phone_pers')) {
            $persons->phone_pers = $request->get('phone_pers');
        }
        if ($request->has('phoneTwo_pers')) {
            $persons->phoneTwo_pers = $request->get('phoneTwo_pers');
        }
        if ($request->get('password_user') != null) {
           $users->password_user = bcrypt($request->get('password_user'));
        }
        if ($request->has('type_id')) {
            $users->type_id = $request->get('type_id');
        }
        if ($persons->save() and $users->save()) {
            return response()->json($persons, 200);
        }
    }

    public function destroy($id)
    {
        $persons = tb_persons::find($id);
        $users = tb_users::where('code_user', $persons->code_pers)->first();
        
        if($persons->delete() and $users->delete()){
            return response()->json('Se ha eliminado', 200);
        }
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function testOrm(Request $request){
        $json = User::all();
        $estiloH1='style="color:blue;"';
        $estiloSpan='style="color:green; font-weight:bold;"';
        $mensaje = "<h1 {{ $estiloH1 }}> Si ve el login : <span {{ $estiloSpan }}>".$json[0]['user_login']."</span> se encuentra funcionando el Controlador 'UserController'</h1> <br />";
        echo $mensaje;
    }

    public function registrar (Request $request){
       
        /* -- Prueba con postman para visualizar los datos   
          $name = $request->input('name');
          $surname = $request->input('surname');
          return "Accion de registrar un usuario : $name $surname"; 
        */
  
        // Pasos para registrar un usuario
        
        //   1. Recoger los datos del usuario por post
        
        $json = $request->input('json', null);
        $params = json_decode($json);
        $params_array = json_decode($json,true);

        var_dump($params); die('Fin');
        //var_dump($params_array); die('Fin');  
  
        if(!empty($params) && !empty($params_array)) {
  
                  //   2. Limpiar los datos
  
                  $params_array = array_map('trim',$params_array);
                  
                  //   3. Validar los datos
                  $validate = Validator::make($params_array, [
                      'name'      => 'required|alpha',
                      'surname'   => 'required|alpha',
                      'email'     => 'required|email|unique:users',
                      'password'  => 'required'    
                  ]);
  
                  if ($validate->fails()){
                          $data = array(
                              'status'   => 'error',
                              'code'     => 404,    
                              'message'  => 'Error en alguno de los atributos ...',
                              'errors'   => $validate->errors()   
                          );
                          
                  } else {
                          // SIN ERRORES
  
                          //   4. Cifrar cotraseña 
                          //$pwd = password_hash($params->password, PASSWORD_BCRYPT,['cost' => 4]);
                          $pwd = hash ('SHA256',$params->password);
                          
                          //   5. Validar que el usuario no este duplicado
                          //   R : Ya se tine $validate con la validacion
                          
                          //   6. Crear el usuario y notificar si fue exitoso o no 
                          $Usuario = new User();
                          $Usuario->name = $params_array['name'];
                          $Usuario->surname = $params_array['surname'];
                          $Usuario->role_user = 'ROLE_USUARIO';
                          $Usuario->email = $params_array['email'];
                          $Usuario->password = $pwd;
                           
                          //var_dump($Usuario); die('Fi');
  
                          // 7. Guardar el usuario
                          $Usuario->save();
                          
                          $data = array(
                              'status'   => 'sucess',
                              'code'     => 200,    
                              'message'  => 'El usuario fue creado exitosamente',
                              'Usuario'  => $Usuario 
                          );
                  }
        } else {
          $data = array(
              'status'   => 'error',
              'code'     => 401,    
              'message'  => 'Existen valores incorrectos ...    '  
          );
        }
  
            
        
        return response()->json($data,$data['code']); 
      }

      public function login (Request $request){

        $jwtAuth = new \JwtAuth();

        // Recibir datos por POST
        $json = $request->input('json',null);
        $params = json_decode($json);
        $params_array = json_decode($json,true);

        // Validar esos datos
        $validate = Validator::make($params_array, [
            'email'     => 'required|email',
            'password'  => 'required'    
        ]);

        if ($validate->fails()){
                $data = array(
                    'status'   => 'error',
                    'code'     => 404,    
                    'message'  => 'El usuario no se ha podido idetificar',
                    'errors'   => $validate->errors()   
                );
                
        } else {
            // Cifrar el password
            $pwd = hash ('SHA256',$params->password); 

            // Devolver token o datos
            $signup = $jwtAuth->signup($params->email, $pwd);
            
            if (!empty($params->gettoken)){
                $signup = $jwtAuth->signup($params->email, $pwd, true);
            }
        }   


       return response()->json($signup,200);
    }

    public function update (Request $request){
        // Verificar que el usuario este identificado
        $token = $request->header('Authorization');
                
        $jwtAuth = new \JwtAuth;
        $checkToken = $jwtAuth->checkToken($token);
        
        // Recoger los datos por Post
        $json = $request->input('json',null);
        $params_array = json_decode($json,true);
 

        if($checkToken && !empty($params_array)){

             // Actualizar usuario
             
              
             // Sacar usuario identificado
             $user = $jwtAuth->checkToken($token,true);
            

             // Validar datos
             $validate = Validator::make($params_array, [
                'name'      => 'required|alpha',
                'surname'   => 'required|alpha',
                'email'     => 'required|email|unique:users'.$user->sub
            ]);

             // Quitar los campos que no quiero actualizar
             unset($params_array['id']);
             unset($params_array['role_user']);
             unset($params_array['password']);
             unset($params_array['created_at']);
             unset($params_array['remember_token']);

             // Actualizar usuario en la base de datos
             $user_update = User::where('id',$user->sub)->update($params_array);

             // Devolver array con resultado
             $data = array(
                'code' => 200,
                'status' => 'success',
                'user' => $user,
                'changes' => $params_array
             );

            //echo "<h1>Login Correcto</h1>";
        } else {
                
             $data = array(
                'code' => 400,
                'status' => 'error',
                'message' => 'El usuario no esta identificado'
             );
            //echo "<h1>Login Incorrecto</h1>";
        }

        return response()->json($data,$data['code']);
    }

    public function upload(Request $request){

        //Recoger datos de la peticio
        $image = $request->file('file0');

        // Validacion de imagen

        $validate = \Validator::make($request->all(),[
            'file0' => 'required|mimes:jpg,jpeg,png,gif'
        ]);
        

        //Guardar image
        if(!$image || $validate->fails()){

            $data = array (
                'code'    => 400,
                'status'  => 'error',
                'message' => 'Error al cargar imagen'
            );
            
            
        }else {
            
            $image_name=time().$image->getClientOriginalName();
            
            \Storage::disk('users')->put($image_name, \File::get($image));
            
            $data = array(
                'code'    => 200,
                'status'  => 'success',
                'image' => $image_name
            );
            
        }

        

        return response()->json($data,$data['code']); 
    }

    public function getImage ($filename) {
        $isset = \Storage::disk('users')->exists($filename);
        if($isset){
            $file = \Storage::disk('users')->get($filename);
            return new Response ($file, 200);
        }else {
            $data = array(
                'code'    => 404,
                'status'  => 'ERROR',
                'image' => 'Imagen no existe'
            );

            return response()->json($data,$data['code']); 
        }
        
    }

    public function detail($id){
        $user = User::find($id);

        if (is_object($user)){
            $data = array (
                'code' => 200,
                'status' =>  'success',
                'user' => $user
            );  
        } else {
            $data = array (
                'code' => 404,
                'status' => 'error',
                'message' => 'El usuario o existe'
            );
        };

        return response()->json($data,$data['code']);
    }
}

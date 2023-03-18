<?php

namespace App\Actions;


use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

final class UpsertUserAction
{
    /**
     * @param \Illuminate\Http\Request  $request
     * ? @param int
     * @return array
     * @throws Exception
     */

     public static function execute(Request  $request, ? int $id=null): array
     {
        try{
            $user = User::updateOrCreate(
                ['id' => $id],
                ['name' => $request->name,
                 'last_name' => $request->last_name,
                 'email' => $request->email,
                 'password' => Hash::make($request->password),
                 'phone' => $request->phone,
                 'net_income' => $request->net_income,
                ]
            );

            $token = $user->createToken('auth_token')->plainTextToken;

            $variable="";
            if(isset($id)){
                $variable='editado';
            }else{
                $variable='creado';
            }
           
            $data = [
                'message' => 'Usuario '.$variable.' con éxito.',
                'user' => $user,
                'access_token' => $token,
                'token_type' => 'Bearer'
            ];
            return $data;
        }catch(\Exception $e){
            return ['message' => $e->getMessage()];
        }
     }

}


?>
<?php

namespace App\Actions;

use App\Models\Expert;
use App\Models\User;
use App\Models\Register;
use Exception;
use Illuminate\Http\Request;

final class UpsertRegisterAction
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
            if(is_null(User::find($request->user_id))){
                return ['message' => 'Usuario no encontrado.'];
            }
            $register = Register::updateOrCreate(
                ['id' => $id],
                ['user_id' => $request->user_id,
                 'expert_id' => Expert::all()->random(1)->pluck('id')->first(),
                 'requested_quantity' => $request->requested_quantity,
                 'comunication_time' => $request->comunication_time
                ]
            );
            $variable="";
            if(isset($id)){
                $variable='editado';
            }else{
                $variable='creado';
            }
           
            $data = [
                'message' => 'Registro '.$variable.' con éxito.',
                'register' => $register
            ];
            return $data;
        }catch(\Exception $e){
            return ['message' => $e->getMessage()];
        }
     }

}


?>
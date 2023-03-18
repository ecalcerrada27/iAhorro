<?php

namespace App\Actions;


use App\Models\Expert;
use Exception;
use Illuminate\Http\Request;

final class UpsertExpertAction
{
    /**
     * @param \Illuminate\Http\Request  $request
     * ? @param int $id
     * @return array
     * @throws Exception
     */

     public static function execute(Request  $request, ? int $id=null): array
     {
        try{
            $expert = Expert::updateOrCreate(
                ['id' => $id],
                ['name' => $request->name]
            );
            $variable="";
            if(isset($id)){
                $variable='editado';
            }else{
                $variable='creado';
            }
           
            $data = [
                'message' => 'Experto '.$variable.' con éxito.',
                'expert' => $expert
            ];
            return $data;
        }catch(\Exception $e){
            return ['message' => $e->getMessage()];
        }
     }

}


?>
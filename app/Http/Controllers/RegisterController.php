<?php

namespace App\Http\Controllers;

use App\Models\Register;
use App\Actions\UpsertRegisterAction;
use Illuminate\Http\JsonResponse;
use App\Http\Requests\RegisterFormRequest;
use Symfony\Component\HttpFoundation\Response;

final class RegisterController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(): JsonResponse
    {
        try{
            $experts = Register::leftJoin('users','users.id','=','registers.user_id')
                            ->select('name', 'last_name', 'email','phone', 'net_income', 
                            'requested_quantity', 'registers.created_at', 'comunication_time')
                            ->get();
            return response()->json($experts);
        }catch(\Exception $e){
            return response()->json(['message' => $e->getMessage()]);
        }
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\RegisterFormRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(RegisterFormRequest $request): JsonResponse
    {
        $data=$this->upsert($request);
        return response()->json($data, Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Register $register
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Register $register): JsonResponse
    {
        try{
            $data=$register->getter();
            return response()->json($data);
        }catch(\Exception $e){
            return response()->json(['message' => $e->getMessage()]);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\RegisterFormRequest $request
     * @param  \App\Models\Register $register
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(RegisterFormRequest $request, Register $register): JsonResponse
    {
        $data=$this->upsert($request, $register->id);
        return response()->json($data);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Register $register
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Register $register): JsonResponse
    {
        try{
            $register->delete();
            return response()->json(['message'=>'Eliminado con éxito.', 'register'=>$register], Response::HTTP_NO_CONTENT);
        }catch(\Exception $e){
            return response()->json(['message'=>$e->getMessage()]);
        }
    }

    /**
     * @param \App\Http\Requests\RegisterFormRequest  $request
     * ?@param int
     * @return array
     */
    private function upsert(RegisterFormRequest $request, ? int $id=null): array
    {
        try{
            $data=UpsertRegisterAction::execute($request, $id);
            return $data;
        }catch(\Exception $e){
            return ['message' => $e->getMessage()];
        }
    }
}

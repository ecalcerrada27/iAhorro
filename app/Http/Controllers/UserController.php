<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Actions\UpsertUserAction;
use Illuminate\Http\JsonResponse;
use App\Http\Requests\UserFormRequest;


final class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(): JsonResponse
    {
        try{
            $users = User::all();
            return response()->json($users);
        }catch(\Exception $e){
            return response()->json(['message' => $e->getMessage()]);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\UserFormRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(UserFormRequest $request): JsonResponse
    {
        try{
            $data=$this->upsert($request);
            return response()->json($data);
        }catch(\Exception $e){
            return response()->json(['message' => $e->getMessage()]);
        }
        
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\User $user
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(User $user): JsonResponse
    {
        try{
            $data=$user->getter();
            return response()->json($data);
        }catch(\Exception $e){
            return response()->json(['message' => $e->getMessage()]);
        }

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UserFormRequest $request
     * @param  \App\Models\User $user
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UserFormRequest $request, User $user): JsonResponse
    {
        $data=$this->upsert($request, $user->id);
        return response()->json($data);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user): JsonResponse
    {
        try{
            $user->delete();
            return response()->json(['message'=>'Eliminado con éxito.']);
        }catch(\Exception $e){
            return response()->json(['message'=>$e->getMessage()]);
        }
    }

    /**
     * @param \App\Http\Requests\UserFormRequest $request
     * ?@param int
     * @return array
     */
    private function upsert(UserFormRequest $request, ? int $id=null): array
    {
        try{
            $data=UpsertUserAction::execute($request, $id);
            return $data;
        }catch(\Exception $e){
            return ['message' => $e->getMessage()];
        }
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Expert;
use App\Actions\UpsertExpertAction;
use Illuminate\Http\JsonResponse;
use App\Http\Requests\ExpertFormRequest;

final class ExpertController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(): JsonResponse
    {
        try{
            $experts = Expert::select('name')->get();
            return response()->json($experts);
        }catch(\Exception $e){
            return response()->json(['message' => $e->getMessage()]);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\ExpertFormRequest  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(ExpertFormRequest $request): JsonResponse
    {
        $data=$this->upsert($request);
        return response()->json($data);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Expert $expert
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Expert $expert): JsonResponse
    {
        try{
            $data=$expert->getter();
            return response()->json($data);
        }catch(\Exception $e){
            return response()->json(['message' => $e->getMessage()]);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\ExpertFormRequest  $request
     * @param  \App\Models\Expert $expert
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(ExpertFormRequest $request, Expert $expert): JsonResponse
    {   
        
        $data=$this->upsert($request, $expert->id);
        return response()->json($data);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Expert $expert
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Expert $expert): JsonResponse
    {   
        try{
            $expert->delete();
            return response()->json(['message'=>'Eliminado con éxito.']);
        }catch(\Exception $e){
            return response()->json(['message'=>$e->getMessage()]);
        }
        
    }

    /**
     * @param \App\Http\Requests\ExpertFormRequest  $request
     * ?@param int $id
     * @return array
     */
    private function upsert(ExpertFormRequest $request, ? int $id=null): array
    {
        try{
            $data=UpsertExpertAction::execute($request, $id);
            return $data;
        }catch(\Exception $e){
            return ['message' => $e->getMessage()];
        }
    }
}

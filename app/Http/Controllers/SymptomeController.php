<?php

namespace App\Http\Controllers;

use App\Http\Requests\SymptomeRequest;
use App\Models\symptome;
use App\Traits\ResponseTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use function Symfony\Component\Clock\now;

class SymptomeController extends Controller
{
    use ResponseTrait;
    /**
     * Display a listing of the resource.
     */

    public function index()
    {
        $symptomes = Auth::user()->symptomes()->get();
        return $this->successResponse($symptomes,'voila vos symptomes');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(SymptomeRequest $request)
    {
        try {
            $symptome = Symptome::create([
                'user_id' => Auth::id(),
                'name' => $request->name,
                'niveau' => $request->niveau,
                'description' => $request->description,
                'date_recorded' => now(),
                'notes' => $request->notes,
            ]);
            
            return $this->successResponse($symptome,'symptome crée avec success');
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(symptome $symptome)
    {
        $symp = Symptome::where('id',$symptome->id)->get();
        if ($symp) {
            return $this->successResponse($symp,'Voila les details de la symptome ');
        }else return $this->errorResponse('pas de symptome a ce id');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(symptome $symptome)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, symptome $symptome)
    {
        try {
            $symptome->update($request->only([
                'name',
                'niveau',
                'description',
                'notes',
            ]));
            
            return $this->successResponse($symptome,'symptome modifié avec success');
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(symptome $symptome)
    {
        $symptome->delete();
        return $this->successResponse([],'symptome supprimé');
    }
}

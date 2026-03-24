<?php

namespace App\Http\Controllers;

use App\Models\Doctor;
use Illuminate\Http\Request;
use App\Traits\ResponseTrait;

class DoctorController extends Controller
{
    use ResponseTrait;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $doctors = Doctor::get();
        if($doctors->count()==0)
            return $this->errorResponse('pas de docteurs');
        else 
            return $this->successResponse($doctors,'voila les docteurs disponibles');
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
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Doctor $doctor)
    {
        $doc = Doctor::where('id',$doctor->id)->get();
        if(!$doc)return $this->errorResponse('pas de docteur avec ce Id la');
        else return $this->successResponse($doc,'voila les details de ce docteur');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function search(Request $request)
    {
        $query = Doctor::query();

        $query->when($request->specialty, function ($q) use ($request){
            $q->where('specialty','like' ,'%' . $request->specialty .'%');
        });

        $query->when($request->city , function ($q) use ($request){
            $q->where('city','like' ,'%' . $request->city .'%');
        });

        $doctor = $query->get();
        return $this->successResponse($doctor,'voila les resultats du recherche');

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Doctor $doctor)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Doctor $doctor)
    {
        //
    }
}

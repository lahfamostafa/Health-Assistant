<?php

namespace App\Http\Controllers;

use App\Http\Requests\ReservationRequest;
use App\Models\Reservation;
use App\Traits\ResponseTrait;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReservationController extends Controller
{
    use ResponseTrait;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $reservations = Auth::user()->reservations()->get();
        if($reservations->count()>0)return $this->successResponse($reservations,'Voila vos reservations');
        else return $this->errorResponse('pas de reservations');
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
    public function store(ReservationRequest $request,$doctorId)
    {
        try {
            $reservation = Reservation::create([
                'user_id' => Auth::id(),
                'doctor_id' => $doctorId,
                'reservation_date' => $request->date,
                // 'status' => $request->status,
                'notes' => $request->notes,
            ]);
            
            return $this->successResponse($reservation,'reservation creé avec success');
        } catch (Exception $e) {
            return $this->errorResponse($e->getMessage(),'error hors de la reservation');
        }

    }

    /**
     * Display the specified resource.
     */
    public function show(Reservation $reservation)
    {
        if($reservation->count()>0)return $this->successResponse($reservation,'Voila les details de cette reservation');
        else return $this->errorResponse('pas de reservation');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Reservation $reservation)
    {
        
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ReservationRequest $request, Reservation $reservation)
    {
        try {
            $res = $reservation->update([
                'reservation_date' => $request->date,
                'status' => $request->status,
                'notes' => $request->notes,
            ]);
            return $this->successResponse($res,'reservation modifié avec success');
        } catch (Exception $e) {
            return $this->errorResponse($e->getMessage(),'erreur hors de la modification');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Reservation $reservation)
    {
        $reservation->delete();
        return $this->successResponse('','Reservation supprimé avec success');
    }
}

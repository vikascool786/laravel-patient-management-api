<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use Illuminate\Http\Request;
use App\Http\Resources\AppointmentResource;
use Validator;

class AppointmentController extends Controller
{
     /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $Appointments = Appointment::all();
        return response(['data' => AppointmentResource::collection($Appointments)], 200);
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
        $data = $request->all();

        $validator = Validator::make($data, [
            'patient_id' => 'required',
            'doctor_id' => 'required',
            'appointment_date' => 'required',
            'reason' => 'required'
        ]);

        if ($validator->fails()) {
            return response(['error' => $validator->errors(), 'Validation Error']);
        }

        $Appointment = Appointment::create($data);

        return response(['data' => new AppointmentResource($Appointment), 'message' => 'Appointment created successfully'], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Appointment $Appointment)
    {
        return response(['Appointment' => new AppointmentResource($Appointment)], 200);
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Appointment $Appointment)
    {
        $data = $request->all();

        $validator = Validator::make($data, [
            'patient_id' => 'required',
            'doctor_id' => 'required',
            'appointment_date' => 'required',
            'reason' => 'required',
        ]);

        if ($validator->fails()) {
            return response(['error' => $validator->errors(), 'Validation Error']);
        }

        $Appointment->update($data);

        return response(['data' => new AppointmentResource($Appointment), 'message' => 'Appointment updated successfully']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Appointment $Appointment)
    {
        $Appointment->delete();
        return response(['message' => 'Appointment deleted successfully']);
    }
}

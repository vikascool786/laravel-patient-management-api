<?php

namespace App\Http\Controllers;

use App\Models\MedicalRecord;
use Illuminate\Http\Request;
use App\Http\Resources\MedicalRecordResource;
use Validator;

class MedicalRecordController extends Controller
{
     /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $MedicalRecords = MedicalRecord::all();
        return response(['data' => MedicalRecordResource::collection($MedicalRecords)], 200);
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
            'diagnosis' => 'required',
            'prescription' => 'required',
        ]);
        if ($validator->fails()) {
            return response(['error' => $validator->errors(), 'Validation Error']);
        }

        $MedicalRecord = MedicalRecord::create($data);

        return response(['product' => new MedicalRecordResource($MedicalRecord), 'message' => 'MedicalRecord created successfully'], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(MedicalRecord $MedicalRecord)
    {
        return response(['MedicalRecord' => new MedicalRecordResource($MedicalRecord)], 200);
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
    public function update(Request $request, MedicalRecord $MedicalRecord)
    {
        $data = $request->all();

        $validator = Validator::make($data, [
            'patient_id' => 'required',
            'doctor_id' => 'required',
            'appointment_date' => 'required',
            'diagnosis' => 'required',
            'prescription' => 'required',
        ]);

        if ($validator->fails()) {
            return response(['error' => $validator->errors(), 'Validation Error']);
        }

        $MedicalRecord->update($data);

        return response(['MedicalRecord' => new MedicalRecordResource($MedicalRecord), 'message' => 'MedicalRecord updated successfully']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(MedicalRecord $MedicalRecord)
    {
        $MedicalRecord->delete();
        return response(['message' => 'MedicalRecord deleted successfully']);
    }
}

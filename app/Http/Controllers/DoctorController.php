<?php

namespace App\Http\Controllers;

use App\Models\Doctor;
use Illuminate\Http\Request;
use App\Http\Resources\DoctorResource;
use Validator;

class DoctorController extends Controller
{
     /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $Doctors = Doctor::all();
        return response(['data' => DoctorResource::collection($Doctors)], 200);
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
            'name' => 'required',
            'email' => 'required|email',
            'phone' => 'required',
            'specialty' => 'required',
            'address' => 'required',
        ]);

        if ($validator->fails()) {
            return response(['error' => $validator->errors(), 'Validation Error']);
        }

        $Doctor = Doctor::create($data);

        return response(['data' => new DoctorResource($Doctor), 'message' => 'Doctor created successfully'], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Doctor $Doctor)
    {
        return response(['data' => new DoctorResource($Doctor)], 200);
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
    public function update(Request $request, Doctor $Doctor)
    {
        $data = $request->all();

        $validator = Validator::make($data, [
            'name' => 'required',
            'email' => 'required|email',
            'phone' => 'required',
            'specialty' => 'required',
            'address' => 'required',
        ]);

        if ($validator->fails()) {
            return response(['error' => $validator->errors(), 'Validation Error']);
        }

        $Doctor->update($data);

        return response(['data' => new DoctorResource($Doctor), 'message' => 'Doctor updated successfully']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Doctor $Doctor)
    {
        $Doctor->delete();
        return response(['message' => 'Doctor deleted successfully']);
    }
}

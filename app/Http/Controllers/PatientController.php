<?php

namespace App\Http\Controllers;

use App\Models\Patient;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Resources\PatientResource;
use Validator;

class PatientController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $patients = Patient::all();
        // $patients = Patient::where('id', 1)->with('appointments', 'medicalRecords')->get();
        // return response(['data' => Patient::with('appointments')->get(), 'medicalRecords' => Patient::with('medicalRecords')->get()], 200);
        return response(['data' => PatientResource::collection($patients)], 200);
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
            'dob' => 'required|date',
            'address' => 'required',
        ]);

        if ($validator->fails()) {
            return response(['error' => $validator->errors(), 'Validation Error']);
        }

        $patient = Patient::create($data);

        return response(['data' => new PatientResource($patient), 'message' => 'Patient created successfully'], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Patient $patient)
    {
        return response(['patient' => new PatientResource($patient)], 200);
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
    public function update(Request $request, Patient $patient)
    {
        $data = $request->all();

        $validator = Validator::make($data, [
            'name' => 'required',
            'email' => 'required|email',
            'phone' => 'required',
            'dob' => 'required|date',
            'address' => 'required',
        ]);

        if ($validator->fails()) {
            return response(['error' => $validator->errors(), 'Validation Error']);
        }

        $patient->update($data);

        return response(['data' => new PatientResource($patient), 'message' => 'patient updated successfully']);
    }

    /**
     * Remove the specified resource from storage.
     */
    // public function destroy(Patient $patient)
    // {
    //     $patient->delete();
    //     return response(['message' => 'patient deleted successfully']);
    // }
    public function destroy($id)
    {
        $res = DB::table('patients')->where('id', $id)->first();
        // print_r($res); exit;
        if ($res) {
            DB::table('patients')->where('id', $id)->delete();
            DB::table('appointments')->where('patient_id', $id)->delete();
            return response()->json([
                'message' => "patients & appointments Deleted successfully."
            ], 200);
        } else {
            return response()->json([
                'message' => "Records not deleted!"
            ], 200);
        }
        // try {
        //     if($patient->id){
        //         // $patient->delete();
        //         DB::table('appointments')->where('patient_id', $patient->id)->delete();
        //         // DB::table('appointments')->whereIn('patient_id', $patient->id)->delete();
        //         return response()->json([
        //             'message' => "patients & appointments Deleted successfully."
        //         ], 200);
        //     }else{
        //         return response()->json([
        //             'message' => "no records found."
        //         ], 200);  
        //     }
        // } catch (\Exception $e) {
        //     return response()->json([
        //         'message' =>  $e->getMessage()
        //     ], 200);
        // }

        // $patient->delete();
        // return response(['message' => 'patient deleted successfully']);
    }

    public function getPatientHistoryById($id)
    {
        // $patients = Patient::all();
        $patients = Patient::where('id', $id)->with('appointments', 'medicalRecords')->get();
        // return response(['data' => Patient::with('appointments')->get(), 'medicalRecords' => Patient::with('medicalRecords')->get()], 200);
        return response(['data' => PatientResource::collection($patients)], 200);
    }
}

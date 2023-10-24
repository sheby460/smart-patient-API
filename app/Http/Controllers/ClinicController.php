<?php

namespace App\Http\Controllers;

use App\Models\Clinic;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ClinicController extends Controller
{
    public function __construct(){
        $this->middleware('auth:sanctum');
    }
    public function index(){
     $clinic = Clinic:: all();

     return response()->json([
        'status' => 200,
        'message' => 'Clinic loaded successfully',
        'data' => $clinic,
     ]);
    }       

    public function addClinic(Request $request){
     $validator = Validator::make($request->all(), [
        'clinic_name' => 'required',
        'clinic_status' => 'required'
     ]);
     if($validator->fails()){
        return response()->json([
            'status' => 400,
            'errors' => $validator->errors(),
        ]);
     }

     $clinicCheck = Clinic::where('clinic_name', $request->clinic_name)->first();
     if($clinicCheck){
        return response()->json([
            'status' => 400,
            'message' => 'This cost center exists in the system',
            'data' => $request->all()
        ], 400);
     }

     $clinic = Clinic::create([
        'clinic_name' => $request->input('clinic_name'),
        'clinic_status' => $request->input('clinic_status'),
        'createdBy' => auth()->id(),
     ]);

     return response()->json([
        'status' => 200,
        'message' => 'Clinic created successfully',
        'data' => $clinic,
    ]);
    }

    public function updateClinic(Request $request, $id)
    {
        $clinic = Clinic::find($id);
    
        if (!$clinic) {
            return response()->json([
                'status' => 404,
                'message' => 'Clinic not found',
            ], 404);
        }
    
        $validator = Validator::make($request->all(), [
            'clinic_name' => 'required',
            'clinic_status' => 'required',
        ]);
    
        if ($validator->fails()) {
            return response()->json([
                'status' => 400,
                'errors' => $validator->errors(),
            ]);
        }
        $clinic->update([
            'clinic_name' => $request->input('clinic_name'),
            'clinic_status' => $request->input('clinic_status'),  
        ]);

        return response()->json([
            'status' => 200,
            'message' => 'Clinic updated successfully',
            'data' => $clinic,
        ]);
    }

    public function softDeleteClinic(Request $request)
    {
        $clinicCheck =Clinic::where('id', $request->id)->exists();

        if (!$clinicCheck) {
            return response()->json([
                'status' => 402,
                'message' => 'Clinic id could not found',
                'data' => ''
            ]);
        }
        $clinic =Clinic::where('id', $request->id)->update([
            'status' => 0,
        ]);
        return response()->json([
            'status' => 200,
            'message' => 'Clinic deleted successfully',
            'data' => $clinic
        ]);
    }

}

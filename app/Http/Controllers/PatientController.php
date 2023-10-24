<?php

namespace App\Http\Controllers;

use App\Models\Patient;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PatientController extends Controller
{

    public function __construct(){
        $this->middleware("auth:sanctum");
    }
    public function index(){
        $patients = Patient::all();
        return response()->json([
            'status' => 200,
            'message' => 'Patients loaded successfully',
            'data' => $patients,         
        ]);
    }

    // public function registerPatients(Request $request){
    //     $validator = Validator::make($request->all(), [
    //         'f_name' => 'required',
    //         'l_name' => 'required',
    //         'gender' => 'required',
    //         'occupation' => 'required',
    //         'phisical_address' => 'required',
    //         'phone' => 'required',
    //         'DOB' => 'required',
              
    //     ]);
    //     if($validator->fails()){
    //         return response()->json([
    //             'status'=> 400,
    //             'errors' => $validator->errors(),
    //         ]);
    //     }
    //     $patient = Patient::create([
    //         'f_name' => $request->input('f_name'),
    //         'm_name' => $request->input('m_name'),
    //         'l_name' => $request->input('l_name'),
    //         'gender' => $request->input('gender'),
    //         'occupation' => $request->input('occupation'),
    //         'phisical_address' => $request->input('phisical_address'),
    //         'phone' => $request->input('phone'),
    //         'DOB' => $request->input('DOB'),
    //         'kins_name' => $request->input('kins_name'),
    //         'kins_mobile' => $request->input('kins_mobile'),
    //         'createdBy' => auth()->id(),

    //         // Calculate the next display ID
    //         $latestDisplayId = Patient::max('display_id'),
    //         $nextDisplayId = sprintf('%06d', (intval($latestDisplayId) + 1)),
    //         $patient->display_id = $nextDisplayId;

    //     // Save the patient record
    //         //  $patient->save();
    //     ]);
    //     return response()->json([
    //         'status' => 200,
    //         'message' => 'Patient registed successful 👍',
    //         'data' => $patient
    //     ]);
    // }

    public function registerPatients(Request $request) {
        $validator = Validator::make($request->all(), [
            'f_name' => 'required',
            'l_name' => 'required',
            'gender' => 'required',
            'occupation' => 'required',
            'phisical_address' => 'required',
            'phone' => 'required',
            'DOB' => 'required',
        ]);
    
        if ($validator->fails()) {
            return response()->json([
                'status' => 400,
                'errors' => $validator->errors(),
            ]);
        }
    
        $latestDisplayId = Patient::max('display_id');
    
        if ($latestDisplayId) {
            $nextDisplayId = sprintf('%06d', (intval($latestDisplayId) + 1));
        } else {
            $nextDisplayId = '000001'; // Initial display_id
        }
    
        // Create a new patient record and set the display_id
        $patient = new Patient;
        $patient->f_name = $request->input('f_name');
        $patient->m_name = $request->input('m_name');
        $patient->l_name = $request->input('l_name');
        $patient->gender = $request->input('gender');
        $patient->occupation = $request->input('occupation');
        $patient->phisical_address = $request->input('phisical_address');
        $patient->phone = $request->input('phone');
        $patient->DOB = $request->input('DOB');
        $patient->kins_name = $request->input('kins_name');
        $patient->kins_mobile = $request->input('kins_mobile');
        $patient->display_id = $nextDisplayId;
        $patient->createdBy = auth()->id();
        $patient->save();
    
        return response()->json([
            'status' => 200,
            'message' => 'Patient registered successfully 👍',
            'data' => $patient,
        ]);
    }
    
}

<?php

namespace App\Http\Controllers;

use App\Models\Qualification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class QualificationController extends Controller
{
    public function __construct(){
         $this->middleware('auth:sanctum');
    }

    public function index(){
        $qulif = Qualification::all();
        return response()->json([
            'status' => 200,
            'message' => 'Qualification loaded successfully',
            'data' => $qulif,
         ]);

    }

    public function addQualification(Request $request){
        $validator = Validator::make($request->all(), [
            'qualification_name' => 'required',
        ]);
        if($validator->fails()){
            return response()->json([
                'status' => 400,
                'errors' => $validator->errors(),
            ]);    
        }
        $qualifCheck = Qualification::where('qualification_name', $request->qualification_name)->first();
        if($qualifCheck){
            return response()->json([
                'status' => 400,
                'message' => 'This qualification exists in the system',
                'data' => $request->all()
            ], 400);    
        }
        $qualif = Qualification::create([
           'qualification_name'=> $request->input('qualification_name'),
           'createdBy' => auth()->id(), 
        ]);
        
     return response()->json([
        'status' => 200,
        'message' => 'Clinic created successfully',
        'data' => $qualif,
    ]);
    }

    public function updateQualification(Request $request, $id)
    {
        $qualif = Qualification::find($id);
    
        if (!$qualif) {
            return response()->json([
                'status' => 404,
                'message' => 'Qualification not found',
            ], 404);
        }
    
        $validator = Validator::make($request->all(), [
            'qualification_name' => 'required',
        ]);
    
        if ($validator->fails()) {
            return response()->json([
                'status' => 400,
                'errors' => $validator->errors(),
            ]);
        }
        $qualif->update([
            'qualification_name' => $request->input('qualification_name'),
        ]);

        return response()->json([
            'status' => 200,
            'message' => 'Qalification updated successfully',
            'data' => $qualif,
        ]);
    }

    public function softDeleteQalification(Request $request)
    {
        $qualifCheck =Qualification::where('id', $request->id)->exists();

        if (!$qualifCheck) {
            return response()->json([
                'status' => 402,
                'message' => 'Qalification id could not found',
                'data' => ''
            ]);
        }
        $qualif =Qualification::where('id', $request->id)->update([
            'status' => 0,
        ]);
        return response()->json([
            'status' => 200,
            'message' => 'Qalification deleted successfully',
            'data' => $qualif
        ]);
    }
}

<?php

namespace App\Http\Controllers\API;

use App\Models\Role;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class RoleController extends Controller
{

    //get all role
    public function show(Request $request){
        $role = Role::select('id', 'title', 'description', 'created_at', 'defaultrole')->get();
        return Response([
            'datas' => $role
        ], 200);
    }
    
    //create role
    public function store(Request $request){
        $validator = Validator::make($request->all(), 
            [
                'title' => 'required',
                'description' => 'required',
                'defaultrole' => [
                    'required',
                    'numeric',
                    function ($attribute, $value, $fail) {
                        $list = [1, 2]; // List of numbers to check against
                        if (!in_array($value, $list)) {
                            $fail("Ops Invalid Default ID");
                        }
                    },
                ]
            ],
        );
        if ($validator->fails()) {
            return Response([
                'error' => $validator->errors()
            ], 400);
        }
        else{
            $newROle = Role::create($request->all());
            return Response([
                'data' => $newROle
            ],200);
        }
    }

    //verify first
    public function edit(Request $request, $id){
        //check if admin role
        if($id == 1){
            return Response([
                'error' => 'Cannot be update'
            ], 400) ;
        }else{
            $role = Role::find($id);
            if($role){
                return Response([
                    'data' => $role,
                ], 200);
            }else{
                return Response([
                    'error' => 'not found'
                ], 400) ;
            }
        }
    }

    //update role
    public function update(Request $request, $id){
        $validator = Validator::make($request->all(), 
            [
                'title' => 'required',
                'description' => 'required',
                'defaultrole' => [
                    'required',
                    'numeric',
                    function ($attribute, $value, $fail) {
                        $list = [1, 2]; // List of numbers to check against
                        if (!in_array($value, $list)) {
                            $fail("Ops Invalid Default ID");
                        }
                    },
                ]
            ],
        );
        if ($validator->fails()) {
            return Response([
                'error' => $validator->errors()
            ], 400);
        }
        else{
            $data = $request->only(['title', 'description']);
            $role = Role::findOrFail($id);
            $role->update($data);
            return Response([
                'data' => $role
            ], 200);
        }
    }

    //delete role
    public function destroy(Request $request, $id){
        if($id == 1){
            return Response([
                'error' => 'Cannot Be Deleted!'
            ], 400) ;
        }
        else{
            $role = Role::findOrFail($id);
            $role->delete();   
            return Response([
                'message' => 'Delete Successfully'
            ], 200) ;
        }
    }
}

<?php

namespace App\Http\Controllers\API;
use DB;
use Auth;
use Carbon\Carbon;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    //
    public function index(Request $request){
        $user = Auth::guard('api')->user();
        return Response([
            'user' => $user
        ],200);
    }
    public function isLoginUser(Request $request){
        return Auth::guard('api')->user();
    }
    public function loginUser(Request $request){
        $validator = Validator::make($request->all(), 
            [
                'email' => 'required|email',
                'password' => 'required'
            ],
        );
        if($validator->fails()){
            return Response([
                'error' => $validator->errors()
            ], 400);
        }
        else{
            $check = Auth::attempt($request->all());
            $user = Auth::user();
            if($check){
                return Response([
                    'token' => $user->createToken('example')->accessToken,
                    'userRole' => $user->role
                ], 200);
            }
            else{
                return Response([
                    'error' => [
                        'email' => [
                            'Invalid Credentials'
                        ]
                    ]
                ],400);
            }
        }
    }
    public function logoutUser(Request $request){
        $accessToken = Auth::guard('api')->user()->token();
            DB::table('oauth_refresh_tokens')
                ->where('access_token_id', $accessToken->id);
            $accessToken->delete();
        return Response([
            'message'=> 'logout'
        ], 200);
    }

    public function show(Request $request){
        $user = User::select('id', 'name', 'email', 'role_id', 'created_at' )->get();
        return Response([
            'datas' => $user
        ], 200);
    }
    public function store(Request $request){
        $validator = Validator::make($request->all(), 
            [
                'name' => 'required',
                'email' => 'required|email|unique:users',
                'role' => 'required',
                'password' => 'required'
            ],
            [
                'email.email' => 'Invali Email.', 
            ]
        );
        if ($validator->fails()) {
            return Response([
                'error' => $validator->errors()
            ], 400);
        }
        else{
            $role = Role::find($request->role);
            if($role){
                $newPasswordHash = Hash::make($request->password);
                $userUpload = [
                    'name' => $request->name,
                    'email' => $request->email,
                    'role' => $role->defaultrole,
                    'role_id' => $request->role,
                    'password' => $newPasswordHash,
                    'email_verified_at' => Carbon::now()->format('d-m-Y H:i:s')
                ];
                $newUser = User::create($userUpload);
                return Response([
                    'data' => $newUser
                ],200);
            }
            else{
                return Response([
                    'error' => 'Role Not Found'
                ],400);
            }
        }
    }
    public function edit(Request $request, $id){
        $user = User::find($id);
        if($user->role == 1){
            return Response([
                'error' => 'not found'
            ], 400) ;
        }else{
            if($user){
                return Response([
                    'data' => $user,
                ], 200);
            }else{
                return Response([
                    'error' => 'not found'
                ], 400) ;
            }
        }
    }
    public function update(Request $request, $id){
        $validator = Validator::make($request->all(), 
            [
                'name' => 'required',
                'email' => 'required|email',
                'role' => 'required',
            ],
            [
                'email.email' => 'Invali Email.', 
            ]
        );
        if ($validator->fails()) {
            return Response([
                'error' => $validator->errors()
            ], 400);
        }else{
            $user = User::find($id);
            if($user){
                if($request->password){
                    $newPasswordHash = Hash::make($request->password);
                }else{
                    $newPasswordHash = $user->password;
                }
                $role = Role::find($request->role);
                if($role){
                    $userUpload = [
                        'name' => $request->name,
                        'email' => $request->email,
                        'role' => $role->defaultrole,
                        'role_id' => $request->role,
                        'password' => $newPasswordHash,
                    ];
                    $user->update($userUpload);
                    return Response([
                        'data' => $user
                    ],200);
                }
            }else{
                return Response([
                    'error' => 'User Not Found'
                ], 400);
            }
        }
    }
    public function destroy(Request $request, $id){
        $user = User::find($id);
        if($user->role == 1){
            return Response([
                'error' => 'user is admin cannot be deleted'
            ], 400) ;
        }else{
            if($user){
                $user->delete();   
                return Response([
                    'message' => 'Delete Successfully'
                ], 200) ;
            }
            else{ 
                return Response([
                    'error' => 'user not found'
                ], 400) ;
            }
        }
       
    }
    public function UpatePassword(Request $request){
        $validator = Validator::make($request->all(), 
            [
                'password' => 'required'
            ],
        );
        if ($validator->fails()) {
            return Response([
                'error' => $validator->errors()
            ], 400);
        }else{
            $newPasswordHash = Hash::make($request->password);
            $user = Auth::guard('api')->user();
            $userUpload = [
                'password' => $newPasswordHash,
            ];
            $user->update($userUpload);
            return Response([
                'data' => $user
            ],200);
        }
    }
}

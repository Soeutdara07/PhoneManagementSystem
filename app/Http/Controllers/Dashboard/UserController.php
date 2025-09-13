<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function index(){

        return view('back_end.user');
    }

    //select all user from table in db
    public function list(){
        $users = User::orderBy("id","DESC")->get();
        return response([
           'status' => 200,
           'users' => $users
        ]);
    }

    public function store(Request $request){

        // Validate request
        $validator = Validator::make($request->all(),[
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:4'
        ]);

        if($validator->passes()){
            $user = new User();
            $user->name = $request->name;
            $user->email = $request->email;
            $user->password = Hash::make($request->password);
            $user->role = $request->role;
            $user->save();

            return response()->json([
                'status' => 200,
                'message' => "User Created successful",
            ]);    

        }else{
            return response()->json([
               'status' => 500,
               'message' => "Failed to create user",
               'errors' => $validator->errors()
            ]);
        }

        
    }

    public function destroy(Request $request){
        $user = User::find($request->id);
        
        //checking user not found
        if($user == null){
            return response()->json([
               'status' => 404,
               'message' => "User not found with id "+$request->id
            ]);
        }

        $user->delete();
        
        return response()->json([
           'status' => 200,
           'message' => "User deleted successful",
        ]);
    }
}

<?php

namespace App\Http\Controllers\Auth;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\RegisterRequest;
use App\Http\Requests\LoginRequest;
use App\Models\User;
use Auth;
use DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use League\Flysystem\Filesystem;
class AuthController extends Controller
{
    public function Login(LoginRequest $request){
        try{
            if(Auth::attempt($request->only('email','password'))){
                $user = Auth::user();
                $token=$user->createToken('app')->accessToken;

                return response([
                    'message' => "Successfully Login",
                    'token' => $token,
                    'user' => $user,
                    'success'=>'success'
                ],200);  //Status Code
            }
            else{
                return response()->json([
                    "status" => "200",
                    'message' => 'Invaliiiiiiiid',
                    'success'=>'fail'
                ]);
            }

        }catch(Exception $exception){
            return response([
                'message' => $exception->getMessage(),
                'success'=>'fail'
            ],500);
        }

    }

    public function Register(RegisterRequest $request){
        try{
            $data = [
                'name'=>$request->name,
                'email'=>$request->email,
                'password'=>Hash::make($request->password) ,
                'role'=>$request->role,
                'subscription_id'=>$request->subscription_id,
                'user_type_id'=>$request->user_type_id
            ];
            if($request->has('image')){
                $image=$request->file('image');
                $name= time().'-'.rand().'.'.$image->getClientOriginalExtension();
                $path = Storage::putFile('image', $request->image);
                //$image->storeAs('public/images/',$name);
                $data['image']=$path;
            }

            $user= User::create($data);
            $token = $user->createToken('app')->accessToken;
            dd($user->id);
            return response([
                'message' => 'Registration Successfully',
                'token'=>$token,
                'user'=>$user,
                'imagePath'=>$path,
                'success'=>'reg-success'
            ],200);
        }catch(Exception $exception){
            return response([
                'message' => $exception->getMessage(),
                'success'=>'fail'
            ],500);
        }
    }


    Public function GetAllusers(Request $request){

        $result =  User::Select("*")
            ->with([
                   'subscription' => function ($query){
                                    $query->select('*');
                   },
                   'subscription_translate' => function ($query) use ($request) {
                                    $query->select('*')->where("locale", "=", $request->locale);
                   },
            ])->with([
                'user_type' => function ($query){
                                 $query->select('*');
                },
                'user_type_translate' => function ($query) use ($request) {
                                 $query->select('*')->where("locale", "=", $request->locale);
                },
         ])
            ->get();

        return $result;
    }


public function GetProfileImage($path)

{

    $image = Storage::get($path);
    return response($image, 200)->header('Content-Type', Storage::mimeType($path));


}
}

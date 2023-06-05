<?php
    namespace App\Http\Controllers\User;
    use Illuminate\Http\Request;
    use App\Http\Controllers\API\BaseController as BaseController;
    use App\Models\User;
    use App\Models\Setting\Subscription;
    use Illuminate\Support\Facades\Auth;
    use Illuminate\Validation\ValidationException;
    use Validator;
    class RegisterController extends BaseController
    {
        public function register(Request $request){
            $validator = Validator::make($request->all(),[
                'name'=>'required',
                'email'=>'required|email|unique:users',
                'password'=>'required',
                'c_password'=>'required|same:password',
                'role'=>'required',
                'user_type_id'=>'required',
            ]);

            if($validator->fails()){
                return throw $this->sendError($validator->messages(), 500);
                // Response::json($validation->messages(), 500);
            }
            $input = $request->all();
            $input['password']=bcrypt($input['password']);
            $user=User::create($input);
            $success['token']=$user->createToken('MyApp')->accessToken;
            $success['name']=$user->name;
            return $this->sendResponse($success,'user Register Successfullly');
        }

        Public function GetAllusers(Request $request){
            // $users = User::with('subscription')->get();
            // return  $users;
            $result = User::with(['Subscription' => function ($query) use($request)  {
                $query->select()->where('locale','=',$request->locale);
            }])->with(['UserType' => function ($query) use($request)  {
                $query->select()->where('locale','=',$request->locale);
            }])->get();
            return $result;
        }
    }

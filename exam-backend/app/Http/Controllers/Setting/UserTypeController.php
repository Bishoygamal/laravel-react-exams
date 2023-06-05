<?php
namespace App\Http\Controllers\Setting;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use App\Models\Setting\UserType;
use App\Models\Setting\UserType_Translate;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\API\BaseController as BaseController;
use App\Http\Requests\Setting\UserTypeRequest;
use Illuminate\Support\Str;

class UserTypeController extends BaseController
{
    public function AddNewUserType(UserTypeRequest $request){

        $result=DB::transaction(function() use( $request) {
            //generate sub code
            $type_code ="Type-".Str::random(9);

            $UserType= UserType::create(['type_code'=>$type_code]);
            $type_id = $UserType->id;
            foreach($request->items as $item){
                UserType_Translate::create([
                'user_type_id'=>$type_id,
                'locale' => $item['locale'],
                'userType_name' =>$item['type_name']
                ]);
            }

            return $UserType;


        });
        return $this->sendResponse($result,'User Type added Successfullly');


}

public function AddNewTransUserType(UserTypeRequest $request){

    try{


        $result='';
        foreach($request->items as $item){
        $result= UserType_Translate::create([
            'user_type_id'=>$item['type_id'],
            'locale' => $item['locale'],
            'userType_name' =>$item['type_name'],
           ]);
        }
           return response([
            'message' => 'Translation Added Successfully',
            'result'=>$result,
            'success'=>'type-success'
        ],200);
    }catch(Exception $exception){
        return response([
            'message' => $exception->getMessage(),
            'success'=>'fail'
        ],500);
    }

}

public function updateUserTypeTranslate(Request $request){

    $translatedResult= UserType_Translate::where('id',$request->translatedId)->update([
        'userType_name'=>$request->type_name,

    ]);
    return response([
        'message' => 'Searching Done Successfully',
        'result'=>$translatedResult,
        'success'=>'sub-success'
    ],200);
}

public function searchAllUserTypes(Request $request){
    $result = UserType::select('*')->with(['userType_translate' => function ($query) use ($request) {
        $query->select('*')->where("locale", "=", $request->locale);
        },])->get();
    return $result;
}

public function searchUserTypes(Request $request){
    $result = UserType::join('user_type__translates','user_types.id','=','user_type__translates.user_type_id')
    ->where('user_type__translates.locale','=',$request->locale)
     ->where('user_type__translates.userType_name', 'LIKE','%'.$request->type_name. '%')
    ->paginate(5);
    return $result;
}

public function GetUserTypeById(Request $request){

    $result = UserType::select()->where('id',$request->type_id)
    ->with(['userType_translate' => function ($query) use($request)  {
        $query->select()->where('locale','=',$request->locale);
    }])->get();
    return $result;
}
}

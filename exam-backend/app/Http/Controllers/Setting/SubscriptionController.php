<?php

namespace App\Http\Controllers\Setting;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use App\Models\Setting\Subscription;
use App\Models\Setting\Subscriptions_translate;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\API\BaseController as BaseController;
use App\Http\Requests\Setting\SubscriptionRequest;
use Illuminate\Support\Str;


class SubscriptionController extends BaseController
{

    public function AddNewSubscribtion(SubscriptionRequest $request){

            $result=DB::transaction(function() use( $request) {
                //generate sub code
                $sub_code ="Sub-".Str::random(9);
                $subscribation= Subscription::create(['sub_code'=>$sub_code]);
                $sub_id = $subscribation->id;
                foreach($request->items as $item){
                    Subscriptions_translate::create([
                    'subscription_id'=>$sub_id,
                    'locale' => $item['locale'],
                    'sub_name' =>$item['sub_name'],
                    'sub_type' =>$item['sub_type'],
                    'sub_limit' =>$item['sub_limit']
                    ]);
                }

                return $subscribation;


            });
            return $this->sendResponse($result,'Subscrion added Successfullly');


    }

    public function AddNewTranslcation(SubscriptionRequest $request){

        try{


            $result='';
            foreach($request->items as $item){
            $result= Subscriptions_translate::create([
                'subscription_id'=>$item['subscription_id'],
                'locale' => $item['locale'],
                'sub_name' =>$item['sub_name'],
                'sub_type' =>$item['sub_type'],
                'sub_limit' =>$item['sub_limit']
               ]);
            }
               return response([
                'message' => 'Translation Added Successfully',
                'result'=>$result,
                'success'=>'sub-success'
            ],200);
        }catch(Exception $exception){
            return response([
                'message' => $exception->getMessage(),
                'success'=>'fail'
            ],500);
        }

    }

    public function updateSubscribeTranslate(Request $request){

        $translatedResult= Subscriptions_translate::where('id',$request->translatedId)->update([
            'sub_name'=>$request->sub_name,
            'sub_type'=>$request->sub_type,
            'sub_limit'=>$request->sub_limit
        ]);
        return response([
            'message' => 'Searching Done Successfully',
            'result'=>$translatedResult,
            'success'=>'sub-success'
        ],200);
    }

    public function searchSubscriptions(Request $request){
        $result = Subscription::join('subscriptions_translates','subscriptions.id','=','subscriptions_translates.subscription_id')
        ->where('subscriptions_translates.locale','=',$request->locale)
         ->where('subscriptions_translates.sub_name', 'LIKE','%'.$request->sub_name. '%')
        ->paginate(5);
        return $result;
    }

    public function searchAllSubscriptions(Request $request){
        $result = Subscription::select('*')->with(['sub_translate' => function ($query) use ($request) {
            $query->select('*')->where("locale", "=", $request->locale);
            },])->get();
        return $result;
    }

    public function GetSubscriptionsById(Request $request){

        $result = Subscription::select()->where('id',$request->sub_id)
        ->with(['sub_translate' => function ($query) use($request)  {
            $query->select('*')->where('locale','=',$request->locale);
        }])->get();
        return $result;
    }
}

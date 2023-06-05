<?php

namespace App\Http\Controllers\Setting;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Setting\Organization;
use App\Models\Setting\Organization_Translate;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\API\BaseController as BaseController;
use App\Http\Requests\Setting\OrganizationReuest;
use Illuminate\Support\Str;

class OrganizationController extends BaseController
{
    public function AddNewOrganiztion(OrganizationReuest $request){

        $result=DB::transaction(function() use( $request) {
            //generate sub code
            $org_code ="Org-".Str::random(9);

            $organization= Organization::create(['org_code'=>$org_code]);
            $org_id = $organization->id;
            foreach($request->items as $item){
                Organization_Translate::create([
                'organization_id'=>$org_id,
                'locale' => $item['locale'],
                'org_name' =>$item['org_name'],
                'org_type' =>$item['org_type']
                ]);
            }

            return $organization;


        });
        return $this->sendResponse($result,'Organization added Successfullly');


}
public function AddNewOrgTranslcation(OrganizationReuest $request){

    try{
        $result='';
        foreach($request->items as $item){
        $result= Organization_Translate::create([
            'organization_id'=>$item['organization_id'],
            'locale' => $item['locale'],
            'org_name' =>$item['org_name'],
            'org_type' =>$item['org_type']
           ]);
        }
           return response([
            'message' => 'Translation Added Successfully',
            'result'=>$result,
            'success'=>'org-success'
        ],200);
    }catch(Exception $exception){
        return response([
            'message' => $exception->getMessage(),
            'success'=>'fail'
        ],500);
    }

}
public function updateOrganizationTranslate(Request $request){

    $translatedResult= Organization_Translate::where('id',$request->translatedId)->update([
        'org_name'=>$request->sub_name,
        'org_type'=>$request->sub_type,
    ]);
    return response([
        'message' => 'Organization Done Successfully',
        'result'=>$translatedResult,
        'success'=>'sub-success'
    ],200);
}
public function searchOrganization(Request $request){
    $result = Organization::join('organization__translates','organizations.id','=','organization__translates.organization_id')
    ->where('organization__translates.locale','=',$request->locale)
     ->where('organization__translates.org_name', 'LIKE','%'.$request->org_name. '%')
    ->paginate(5);
    return $result;
}

public function GetOrganizationById(Request $request){

    $result = Organization::select()->where('id',$request->org_id)
    ->with(['org_translate' => function ($query) use($request)  {
        $query->select()->where('locale','=',$request->locale);
    }])->get();
    return $result;
}
}

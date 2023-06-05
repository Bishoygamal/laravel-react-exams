<?php

namespace App\Http\Controllers\Exam;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use App\Models\Exam\Grade;
use Validator;


class GradeSettingController extends BaseController
{
    //
    public function AddNewGrade(Request $request){
        $validator = Validator::make($request->all(),[
            'grade_name'=>'required|unique:grades,grade_name',

        ]);

        if($validator->fails()){
            return $this->sendError('Validator Error',$validator->errors());
        }
        $input = $request->all();
        $grade=Grade::create($input);
        return $this->sendResponse($grade,'Grade added Successfullly');
    }
}

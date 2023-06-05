<?php

namespace App\Http\Controllers\Exam;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use App\Models\Exam\Exam;
use App\Models\Exam\Grade;
use App\Models\Exam\Topic;
use App\Models\User;
use Validator;
use Illuminate\Validation\Rule;

class ExamPreparationController extends BaseController
{
    //
    public function AddNewExam(Request $request){
        $validator = Validator::make($request->all(),[
            'exam_name'=>'required',
            'topic_id'=>'required',
            'user_id'=>'required',
            'grade_id'=>'required',
            'approved'=>'required',
            'description'=>'required',

        ]);

        if($validator->fails()){
            return $this->sendError('Validator Error',$validator->errors());
        }
        $input = $request->all();
        $exam=Exam::create($input);
        return $this->sendResponse($exam,'Exam added Successfullly');
    }

    public function GetAllExams(Request $request){
        $topics = Exam::with('topic')->with('user')->with('grade')->get();
        return  $topics;
    }

}

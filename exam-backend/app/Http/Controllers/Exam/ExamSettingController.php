<?php

namespace App\Http\Controllers\Exam;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use App\Models\Exam\Topic;
use App\Models\Exam\SubTopic;
use Validator;
use Illuminate\Validation\Rule;

class ExamSettingController extends BaseController
{
    //
    public function AddNewTopic(Request $request){
        $validator = Validator::make($request->all(),[
            'topic_name'=>[
                'required',
                Rule::unique('topics')->where('grade_id', request('grade_id'))
            ],
            'grade_id' => [
                'required',
                Rule::unique('topics')->where('topic_name', request('topic_name'))
            ],

        ],[
            'topic_name.unique'    => 'you have entered this Topic name with another grade',
           'grade_id.unique'      => 'you have entered this grade with another Topic',
        ]);

        if($validator->fails()){
            return $this->sendError('Validator Error',$validator->errors());
        }
        $input = $request->all();
        $topic=Topic::create($input);
        return $this->sendResponse($topic,'account added Successfullly');
    }

    public function AddNewSubTopic(Request $request){
        $validator = Validator::make($request->all(),[
            'sub_topic_name'=>
                'required|unique:sub_topics,sub_topic_name'

        ]);

        if($validator->fails()){
            return $this->sendError('Validator Error',$validator->errors());
        }
        $input = $request->all();
        $sub_topic=SubTopic::create($input);
        return $this->sendResponse($sub_topic,'Sub Topic added Successfullly');
    }

    public function GetAllTopics(Request $request){
        $topics = Topic::with('grade')->with('sub_topic')->get();
        return  $topics;
    }
}

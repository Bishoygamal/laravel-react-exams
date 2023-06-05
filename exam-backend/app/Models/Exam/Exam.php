<?php

namespace App\Models\Exam;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Exam extends Model
{
    use HasFactory;
    protected $fillable = [
        'exam_name',
        'topic_id',
        'user_id',
        'grade_id',
        'approved',
        'description'
    ];

    public function topic(){
        return $this->belongsTo(Topic::class,'topic_id','id');
    }
    public function user(){
        return $this->belongsTo('App\Models\User','user_id','id');
    }
    public function grade(){
        return $this->belongsTo(Grade::class,'grade_id','id');
    }

}

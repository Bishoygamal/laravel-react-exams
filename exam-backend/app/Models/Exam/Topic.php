<?php

namespace App\Models\Exam;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Topic extends Model
{
    use HasFactory;
    protected $fillable = [
        'topic_name',
        'grade_id'
    ];

    public function grade(){
        return $this->belongsTo(Grade::class,'grade_id','id');
    }
    public function sub_topic(){
        return $this->hasMany(SubTopic::class);
    }

}

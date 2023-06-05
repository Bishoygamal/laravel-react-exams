<?php

namespace App\Models\Quiz;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuizBank extends Model
{
    use HasFactory;
    protected $fillable = [
        'quiz_title',
        'exam_id',
        'topic_id',
        'sub_topic_id',
        'quiz_type',
        'quiz_default_grade',
        'quiz_image'
    ];

}

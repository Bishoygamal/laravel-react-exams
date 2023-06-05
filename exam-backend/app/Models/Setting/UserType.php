<?php

namespace App\Models\Setting;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserType extends Model
{
    use HasFactory;
    protected $fillable = [
        'type_code'

    ];
    public function userType_translate(){
        return $this->belongsTo(UserType_Translate::class,'id','user_type_id');
    }
}

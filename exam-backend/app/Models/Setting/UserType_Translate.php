<?php

namespace App\Models\Setting;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserType_Translate extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_type_id',
        'locale',
        'userType_name',
    ];
}

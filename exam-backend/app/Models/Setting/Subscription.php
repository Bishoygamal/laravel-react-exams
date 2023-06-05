<?php

namespace App\Models\Setting;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subscription extends Model
{
    use HasFactory;

    protected $fillable = [
        'sub_code'
    ];
    public function sub_translate(){
        return $this->belongsTo(Subscriptions_translate::class,'id','subscription_id');
    }
}

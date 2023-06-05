<?php

namespace App\Models\Setting;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subscriptions_translate extends Model
{
    use HasFactory;
    protected $fillable = [
        'subscription_id',
        'locale',
        'sub_name',
        'sub_type',
        'sub_limit',

    ];
}

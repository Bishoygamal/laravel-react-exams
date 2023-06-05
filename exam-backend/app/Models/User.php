<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;
use App\Models\Setting\Subscription;
use App\Models\Setting\Subscriptions_translate;
use App\Models\Setting\UserType;
use App\Models\Setting\UserType_Translate;


class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'role',
        'type',
        'password',
        'subscription_id',
        "user_type_id",
        'image'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function subscription(){
        return $this->belongsTo(Subscription::class,'subscription_id','id');
    }
    public function subscription_translate(){
        return $this->belongsTo(Subscriptions_translate::class,'subscription_id','subscription_id');
    }
    public function user_type(){
        return $this->belongsTo(UserType::class,'user_type_id','id');
    }
    public function user_type_translate(){
        return $this->belongsTo(UserType_Translate::class,'user_type_id','user_type_id');
    }
}

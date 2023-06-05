<?php

namespace App\Models\Setting;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Organization extends Model
{
    use HasFactory;
    protected $fillable = [
        'org_code'
    ];
    public function org_translate(){
        return $this->hasMany(Organization_Translate::class);
    }
}


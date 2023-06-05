<?php

namespace App\Models\Setting;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Organization_Translate extends Model
{
    use HasFactory;
    protected $fillable = [
        'organization_id',
        'locale',
        'org_name',
        'org_type'

    ];
}

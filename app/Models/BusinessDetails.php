<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BusinessDetails extends Model
{
    use HasFactory;

    protected $fillable = [
        "business_name","CAC_certificate","RC_number"
    ];
}

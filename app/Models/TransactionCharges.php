<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransactionCharges extends Model
{
    use HasFactory;

    protected $fillable = [
        "api_platform","transaction_type","package_type","charge"
    ];
}

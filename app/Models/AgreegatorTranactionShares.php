<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AgreegatorTranactionShares extends Model
{
    use HasFactory;

    protected $fillable = ["agreegator_percentage"];
}

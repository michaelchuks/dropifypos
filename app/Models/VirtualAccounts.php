<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VirtualAccounts extends Model
{
    use HasFactory;
    
    public $table = "virtual_accounts";
    public $timestamps = false;
}
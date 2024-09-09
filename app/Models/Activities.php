<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\VtpassTransactions;

class Activities extends Model
{
    use HasFactory;

    public function user(){
        return $this->belongsTo(User::class,"user_id");
    }
    
    public function vtuTransaction(){
        return $this->belongsTo(VtpassTransactions::class,"platform_table_id");
    }
}

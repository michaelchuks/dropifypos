<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Userpin extends Model
{
    use HasFactory;
    
    public $table = "user_pin";
    
    public $timestamps = false;
    
    public function user(){
        return $this->belongsTo(User::class,"user_id");
    }
    
    
    protected $fillable = [
        "pin"
        ];
}
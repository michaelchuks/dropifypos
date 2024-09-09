<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use App\Models\Transfers;
use App\Models\Deposits;
use App\Models\Withdrawals;
use App\Models\Activities;
use App\Models\BusinessDetails;
use App\Models\Userpin;
use App\Models\Agreegator;
use App\Models\VirtualAccounts;

class User extends Authenticatable
{
    use HasFactory, Notifiable,HasApiTokens;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'pos_serial_number',
        'status',
        'email',
        'password',
        'phone',
        'city',
        'state',
        'address',
        'profile_image',
        "wallet",
        "Mapping_status",
        "agreegator_id"
    ];


    public function businessDetails(){
        return $this->hasOne(BusinessDetails::class,"user_id");
    }
    
    public function transactionPin(){
        return $this->hasOne(Userpin::class,"user_id");
    }


    public function agreegator(){
        return $this->belongsTo(Agreegator::class,"agreegator_id");
    }


    public function accountDetails(){
        return $this->hasOne(VirtualAccounts::class,"user_id");
    }

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
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
}

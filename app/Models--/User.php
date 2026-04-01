<?php

/**
 * Created by Reliese Model.
 */
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
//use Laravel\Passport\HasApiTokens;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Twilio\Rest\Client;
class User extends Authenticatable implements JWTSubject
{
    use HasFactory, Notifiable /*SoftDeletes*/;
    protected $table = 'users';

    protected $casts = [
        'is_phone_verified' => 'bool',
        'email_verified_at' => 'datetime',
        'status' => 'bool',
        'order_count' => 'int',
        'zone_id' => 'int',
        'wallet_balance' => 'float',
        'loyalty_point' => 'float'
    ];

    protected $hidden = [
        'password',
        'email_verification_token',
        'remember_token',
        'cm_firebase_token'
    ];

    protected $fillable = [
        'f_name',
        'l_name',
        'phone',
        'email',
        'image',
        'is_phone_verified',
        'email_verified_at',
        'password',
        'email_verification_token',
        'remember_token',
        'interest',
        'cm_firebase_token',
        'status',
        'order_count',
        'login_medium',
        'social_id',
        'zone_id',
        'wallet_balance',
        'loyalty_point',
        'ref_code'
    ];
    public function userinfo()
    {
        return $this->hasOne(UserInfo::class,'user_id', 'id');
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function addresses(){
        return $this->hasMany(CustomerAddress::class);
    }

    public function loyalty_point_transaction()
    {
        return $this->hasMany(LoyaltyPointTransaction::class);
    }

    public function wallet_transaction()
    {
        return $this->hasMany(WalletTransaction::class);
    }

    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        // TODO: Implement getJWTIdentifier() method.
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        // TODO: Implement getJWTCustomClaims() method.
        return [];
    }
    public function sendToken()
    {

        $token = mt_rand(100000, 999999);
        Session::put('token', $token);
        $twilio = new Client($_ENV['TWILIO_SID'], $_ENV['TWILIO_AUTH_TOKEN']);


        $message = $twilio->messages
            ->create($this->phone, // to
                ["body" => "Your auth token is " . $token, "from" => "+14406893538"]
            );


    }

    public function validateToken($token)
    {
        $validToken = Session::get('token');
        if ($token == $validToken) {
            Session::forget('token');
            //Auth::login($this);
            return true;
        } else {
            return false;
        }
    }
}

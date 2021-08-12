<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasApiTokens, Notifiable, HasFactory;
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    protected $hidden = [
        'password',
    ];

    public function role() {
        return $this->hasOne(UserType::class, 'id', 'user_type_id')->select('name as role')->first();
    }
    public function messagesTo(){
        return $this->hasOne(Message::class, 'to_id')->latest();
    }
    public function messagesFrom()
    {
        return $this->hasOne(Message::class, 'from_id')->latest();
    }

    public function OauthAcessToken(){
        return $this->hasMany('\App\Models\OauthAccessToken');
    }
}

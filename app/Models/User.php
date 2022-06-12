<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Laravel\Passport\HasApiTokens;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class User extends Authenticatable
{
    use HasApiTokens,HasFactory, Notifiable, HasRoles;    

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $table = 'dry_users';

    protected $fillable = [
        'email',
        'block',
        'password',
        'lock_reason',
        'photo',
        'code_activation',
        'access_system',
        'first_use',
        'user_status',
        'user_deleted',
        'user_updated',
        'user_created',
        'role',
        'origin'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    
    public function authAcessToken(){
        return $this->hasMany('\AppModels\OauthAccessToken');
    }

    public function saveUser($request) : self
    {   
        $this->name = $request->name;
        $this->email = $request->email;
        $this->password = bcrypt($request->password);
        $this->save();

        return $this;
    }

    public function logout() : self
    {
        auth()->user()->token()->revoke();

        return $this;
    }
}
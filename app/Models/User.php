<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;


use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;


class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'image',
        'email',
        'password',
    ];

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
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    //write a code for decrypting the password
    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = bcrypt($value);
    }
       
    //If we set anything so its called mutator function 
    protected function password():Attribute{
        return Attribute::make(
            // get: fn($value) => $value,
            set: fn($value) => bcrypt($value)
        );
    
    }
   //Accessor Function for get name and convert into in upper case
    protected function name():Attribute{
        return Attribute::make(
             get: fn($value) => strtoupper($value),
        );
    
    }

    //Write a code for Isadmin accessor
    public function isAdmin():Attribute{
        $value = ['anuradha.smes@gmail.com'];
        return Attribute::make(
             get: fn() => in_array($this->email,$value) == 1 ? true : false,
        );
    }


    //User can have many tickets and write a eloquent relation hastomany
    public function tickets(): HasMany
    {
        return $this->hasMany(Ticket::class);
        
    }
    
        

}

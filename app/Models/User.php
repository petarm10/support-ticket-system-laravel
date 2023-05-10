<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use App\Models\Role;

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
    ];

    public function hasRole($role)
    {
        if ($this->roles()->where('name', $role)->first()) {
            return true;
        }

        return false;
    }

    public function roles()
    {
        return $this->belongsToMany(Role::class);
    }

    public function role()
    {
        return $this->belongsTo(Role::class, 'role');
    }

    protected static function boot()
    {
        parent::boot();

        static::created(function ($user) {
            // Assign the "user" role to new users by default
            $user->roles()->attach(Role::where('name', 'user')->first()->id);
        });

        // // Assign the "agent" role to new users with email suffix "@example.com"
        // if (ends_with($user->email, '@example.com')) {
        //     $user->roles()->attach(Role::where('name', 'agent')->first()->id);
        // }
    }

    public function showRole()
    {
        return $this->role ? $this->role->name : 'Name of the Role is not assigned';
    }
}

<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'username',
        'first_name',
        'last_name',
        'bio',
        'email',
        'avatar_url',
        'password',
    ];

    public function articles(){
        return $this->hasMany(Article::class);
    }

    public function roles(){
        return $this->belongsToMany(Role::class);
    }

    public function user_login(){
        return $this->hasMany(UserLogin::class);
    }

    public function hasPermission($permission)
    {
        // If $permission is a string, convert it to an array
        $permissions = is_array($permission) ? $permission : [$permission];
        
        foreach ($this->roles as $role) {
            if ($role->permissions()->whereIn('action_name', $permissions)->exists()) {
                return true;
            }
        }
        return false;
    }

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
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

<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens;
    use HasFactory;
    use HasProfilePhoto;
    use Notifiable;
    use TwoFactorAuthenticatable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'profile_photo_path',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array<int, string>
     */
    protected $appends = [
        'profile_photo_url',
    ];

    public function getRolAttribute(): string{
        return match($this->role) {
            'admin' => 'Administrador',
            'client' => 'Cliente',
            'seller' => 'Vendedor',
            default => 'sin Rol',
        };
    }

    public function getImageUserAttribute(){
        return $this->profile_photo_path ?? 'img/default-user.png';
    }

    public function scopeSearch($query, $term){
        if($term === ''){
            return;
        }

        return $query->where('name', 'like', "{$term}%")
                     ->orWhere('email', 'like', "{$term}%");
    }

    public function scopeByRole($query, $role){
        if ($role === ''){
            return;
        }
        return $query->where('role', $role);
    }
}

<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;
// use Laragear\TwoFactor\Contracts\TwoFactorAuthenticatable;
// use Laragear\TwoFactor\TwoFactorAuthentication;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */

    protected $guard_name = 'web';
    protected $fillable = [
        'name',
        'email',
        'username',
        'phone',
        'password',
        'profile_picture',
        'two_factor_enabled',
        'two_factor_code',
        'two_factor_expires_at',
        'session_timeout',
        'is_maintenance',
        'maintenance_message',
    ];

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

    public function adminlte_image()
    {
        $path = 'uploads/images/profile/' . $this->profile_picture;

        // If profile picture exists and file actually exists in public folder
        if (!empty($this->profile_picture) && file_exists(public_path($path))) {
            return asset($path);
        }

        // Default image if no profile picture found
        return asset('images/default.jpg');
    }

    public function generateTwoFactorCode()
    {
        $this->two_factor_code = rand(100000, 999999);
        $this->two_factor_expires_at = now()->addMinutes(60);
        $this->save();
    }

    public function resetTwoFactorCode()
    {
        $this->two_factor_code = null;
        $this->two_factor_expires_at = null;
        $this->save();
    }

    public function payments()
    {
        return $this->hasMany(Payment::class, 'paid_by');
    }
}

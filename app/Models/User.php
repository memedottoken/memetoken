<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use App\Traits\HasProfilePhoto;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, HasProfilePhoto;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'address',
        'otp',
        'email_verified_at',
        'otp_expires_at',
        'profile_photo_path',
        'active',
        'banned'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'remember_token',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [
        'profile_photo_url',
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
            'active' => 'boolean',
            'banned' => 'boolean',
        ];
    }

    public function isAdmin()
    {
        return str(config('app.admin', ''))->lower()->contains(strtolower($this->address));
    }

    /**
     * Generate a new OTP for the user.
     *
     * @return string
     */
    public function generateOTP()
    {
        $otp = mt_rand(100000, 999999);
        $this->otp = $otp;
        $this->otp_expires_at = Carbon::now()->addMinutes(10);
        $this->save();

        return $otp;
    }

    /**
     * Verify the given OTP.
     *
     * @param string $otp
     * @return bool
     */
    public function verifyOTP($otp)
    {
        if ($this->otp === $otp && $this->otp_expires_at > Carbon::now()) {
            $this->otp = null;
            $this->otp_expires_at = null;
            $this->save();
            return true;
        }

        return false;
    }

    /**
     * Check if the user has a valid OTP.
     *
     * @return bool
     */
    public function hasValidOTP()
    {
        return $this->otp !== null && $this->otp_expires_at > Carbon::now();
    }

    /**

     * Get the launchpad this model Belongs To.
     *
     */
    public function launchpads(): HasMany
    {
        return $this->hasMany(Launchpad::class, 'user_id', 'id');
    }

    /**

     * Get the launchpad this model Belongs To.
     *
     */
    public function trades(): HasManyThrough
    {
        return $this->hasManyThrough(Trade::class, Launchpad::class);
    }

    /**

     * Get the launchpad this model Belongs To.
     *
     */
    public function msgs(): HasMany
    {
        return $this->hasMany(Msg::class, 'user_id', 'id');
    }

    /**

     * Get the launchpad this model Belongs To.
     *
     */
    public function holders(): HasMany
    {
        return $this->hasMany(Holder::class, 'user_id', 'id');
    }
}

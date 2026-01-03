<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Sanctum\HasApiTokens;

// ✅ Custom eesti keelsed emailid
use App\Notifications\ResetPasswordNotification;
use App\Notifications\VerifyEmailNotification;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens;
    use HasFactory;
    use HasProfilePhoto;
    use Notifiable;
    use TwoFactorAuthenticatable;

    /**
     * ✅ UCP kasutajate tabel
     */
    protected $table = 'users';

    /**
     * ✅ Mass assignable väljad
     */
    protected $fillable = [
        'name',
        'email',
        'password',

        // RP test
        'requires_rp_test',
        'rp_test_passed',
        'rp_test_failed_until',

        // Discord
        'discord_id',
        'discord_username',
        'discord_connected_at',

        // Steam
        'steam_id64',
        'steam_hex',
        'steam_connected_at',
    ];

    /**
     * ✅ Peidetud väljad
     */
    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    /**
     * ✅ Automaatne profile_photo_url (Jetstream)
     */
    protected $appends = [
        'profile_photo_url',
    ];

    /**
     * ✅ Castid
     */
    protected function casts(): array
    {
        return [
            'email_verified_at'    => 'datetime',
            'password'             => 'hashed',

            // RP / verifitseerimine
            'requires_rp_test'     => 'boolean',
            'rp_test_passed'       => 'boolean',
            'rp_test_failed_until' => 'datetime',

            // Ühendused
            'discord_connected_at' => 'datetime',
            'steam_connected_at'   => 'datetime',
        ];
    }

    /**
     * ======================================================
     * ✅ WHITELIST / LIGIPÄÄSULOOGIKA
     * ======================================================
     */
    public function isWhitelisted(): bool
    {
        // Kui RP test on nõutud ja pole läbitud
        if ($this->requires_rp_test && !$this->rp_test_passed) {
            return false;
        }

        // Discord ja Steam peavad olema ühendatud
        return !empty($this->discord_id) && !empty($this->steam_hex);
    }

    /**
     * ======================================================
     * 📧 CUSTOM EMAILID (EESTI KEEL)
     * ======================================================
     */

    /**
     * 🔐 Parooli taastamise email (EST)
     */
    public function sendPasswordResetNotification($token): void
    {
        $this->notify(new ResetPasswordNotification($token));
    }

    /**
     * ✉️ Emaili kinnitamise email (EST)
     */
    public function sendEmailVerificationNotification(): void
    {
        $this->notify(new VerifyEmailNotification());
    }
}

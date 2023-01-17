<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Adrianorosa\GeoLocation\GeoLocation;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    public $appends = ['ip', 'geoLocation'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'google_id',
        'token',
        'refresh_token',
        'nickname',
        'avatar',
        'expires_in'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'token',
        'email_verified_at',
        'provider_id',
        'google_id',
        'refresh_token',
        'nickname',
        'ip',
        'geoLocation'
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
     * User's ip
     *
     * @return string
     */
    public function getIpAttribute(): string
    {
        return $this->attributes['ip'] = request()->ip();
    }

    /**
     * In case user discard browser location and ip isn't local
     *
     * geoLocation: {
     *   city: "Ebeltoft",
     *   region: "Central Jutland",
     *   country: "Denmark",
     *   countryCode: "DK",
     *   latitude: 56.1944,
     *   longitude: 10.6821
     * }
     *
     * @return array
     */
    public function getGeoLocationAttribute(): array
    {
        $local = request()->ip() == ('127.0.0.1' || '0.0.0.0' || null);
        $details = (!$local) ?? GeoLocation::lookup(request()->ip());
        return $this->attributes['geoLocation'] = (!$local && $details->toArray()) ? $details->toArray() : [];
    }
}

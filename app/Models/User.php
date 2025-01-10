<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Traits\HasCreatorUpdater;
use App\Traits\QueryActive;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;


class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
     use HasFactory, Notifiable, HasCreatorUpdater, QueryActive, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'user_name',
        'role_id',
        'email_verified_at',
        'user_first_name',
        'user_middle_name',
        'user_last_name',
        'email',
        'password',
        'user_birth_date',
        'user_gender',
        'user_mobile',
        'user_phone',
        'user_image',
        'user_street_address',
        'user_police_station',
        'user_city',
        'user_zip',
        'user_state',
        'user_country',
        'user_is_active',
        'created_by',
        'updated_by',
        'otp',
        'otp_expire_at',
        'password_updated_at',
        'password_updated_by',
        'password_updated_during',
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
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

}

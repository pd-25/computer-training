<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class SubAdmin extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'subadmin_unique_id',
        'name',
        'email',
        'image',
        'org_name',
        'password',
        'affiliation',
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
    
    public function students()
    {
        return $this->hasMany(Student::class);
    }

    public function wallets()
    {
        return $this->hasMany(wallet::class);
    }

    public function topupRequests()
    {
        return $this->hasMany(TopupRequest::class);
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }
}

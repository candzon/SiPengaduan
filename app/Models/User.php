<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'is_active',
    ];

    protected $hidden = [
        'password',
    ];

    public function isManager()
    {
        return $this->role === 'admin';
    }

    public static function getOperators()
    {
        return static::select('id', 'name', 'email', 'is_active', 'created_at')
            ->where('role', 'pelapor')
            ->get();
    }
}

<?php

namespace App\Models;

use App\Enums\UserRole;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

/**
 * Пользователь системы. Один аккаунт привязан к одному игроку на сервере.
 * Хранит данные для входа (email/пароль), ссылки на Minecraft и Discord аккаунты,
 * а также роль пользователя (игрок, персонал, администратор).
 * Один пользователь может иметь несколько персонажей.
 */
class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'minecraft_uuid',
        'minecraft_name',
        'discord_id',
        'discord_username',
        'role',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'role' => UserRole::class,
        ];
    }

    /** Все персонажи, созданные этим пользователем. */
    public function characters(): HasMany
    {
        return $this->hasMany(Character::class);
    }
}

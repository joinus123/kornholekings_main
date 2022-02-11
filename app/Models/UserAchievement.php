<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserAchievement extends Model
{
    protected $table = 'user_achievements';
    protected $fillable = ['user_id', 'coins_change', 'trophies_change'];
    public const UPDATED_AT = null;

    final public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'user_id');
    }
}

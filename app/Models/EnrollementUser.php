<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class EnrollementUser extends Model
{
    protected $table = 'enrollement_users';
    protected $fillable = ['tournament_inrolment_id', 'player_id'];



}

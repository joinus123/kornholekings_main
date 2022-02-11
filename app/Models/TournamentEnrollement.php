<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TournamentEnrollement extends Model
{
    protected $table = 'tournament_enrollements';
    protected $fillable = ['tournament_id', 'status','count'];



}

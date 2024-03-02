<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ActiveCode extends Model
{
    use HasFactory;
    const CODE_EXPIRATION = 10; // in minutes
    const CODE_LENGTH = 6;

    protected $fillable = [
        'user_id',
        'code',
        'expired_at',
    ];

    // ---------- Relations ---------- //

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}

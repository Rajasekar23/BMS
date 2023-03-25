<?php

namespace App\Models;

use App\Models\Day;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ClassDay extends Model
{
    use HasFactory;

    /**
     * Get the user that owns the phone.
     */
    public function day(): BelongsTo
    {
        return $this->belongsTo(Day::class);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ChecklistItem extends Model
{
    use HasFactory;

    public const STATUS_INCOMPLETE = 'incomplete';

    public const STATUS_COMPLETE = 'complete';

    protected $guarded = [];

    public function checklist(): BelongsTo
    {
        return $this->belongsTo(Checklist::class);
    }

    public function updateStatus(): bool
    {
        return $this->update([
            'status' => $this->status === self::STATUS_INCOMPLETE
                ? self::STATUS_COMPLETE
                : self::STATUS_INCOMPLETE
        ]);
    }
}

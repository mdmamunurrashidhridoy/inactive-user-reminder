<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserReminder extends Model
{
    protected $fillable = [
        "user_id",
        "sent_at",
        "sent_date",
        "channel",
        "message",
    ];

    protected $cast = [
        "sent_at" => "datetime",
        "sent_date" => "date",
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}

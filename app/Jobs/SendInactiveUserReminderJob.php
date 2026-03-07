<?php

namespace App\Jobs;

use App\Models\User;
use App\Models\UserReminder;
use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\Log;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SendInactiveUserReminderJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(public int $userId) {}

    public function handle(): void
    {
        $user = User::find($this->userId);

        if (!$user) {
            return;
        }

        $today = now()->toDateString();

        $alreadySentToday = UserReminder::query()
            ->where("user_id", $user->id)
            ->where("sent_date", $today)
            ->exists();

        if ($alreadySentToday) {
            return;
        }

        $message = sprintf(
            "Reminder sent to inactive user: %s <%s>",
            $user->name,
            $user->email,
        );

        Log::info($message, [
            "user_id" => $user->id,
            "last_login_at" => $user->last_login_at?->toDateTimeString(),
        ]);

        UserReminder::create([
            "user_id" => $user->id,
            "sent_at" => now(),
            "sent_date" => $today,
            "channel" => config("inactive-users.channel", "log"),
            "message" => $message,
        ]);
    }
}

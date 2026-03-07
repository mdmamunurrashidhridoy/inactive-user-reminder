<?php

namespace App\Console\Commands;

use App\Jobs\SendInactiveUserReminderJob;
use App\Models\UserReminder;
use App\Models\User;
use Illuminate\Console\Command;

class ProcessInactiveUsersCommand extends Command
{
    protected $signature = "users:process-inactive";

    protected $description = "Find inactive users and dispatch reminder jobs";

    public function handle(): int
    {
        $inactiveDays = (int) config("inactive-users.days", 7);
        $cutoff = now()->subDays($inactiveDays);
        $today = now()->toDateString();

        $users = User::query()
            ->where(function ($query) use ($cutoff) {
                $query
                    ->whereNull("last_login_at")
                    ->orWhere("last_login_at", "<=", $cutoff);
            })
            ->whereDoesntHave("inactiveReminders", function ($query) use (
                $today,
            ) {
                $query->where("sent_date", $today);
            })
            ->get();

        foreach ($users as $user) {
            SendInactiveUserReminderJob::dispatch($user->id);
        }

        $this->info(
            "Dispatched {$users->count()} inactive user reminder job(s).",
        );

        return self::SUCCESS;
    }
}

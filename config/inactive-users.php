<?php

return [
    "days" => env("INACTIVE_USER_DAYS", 7),
    "channel" => env("INACTIVE_USER_REMINDER_CHANNEL", "log"),
];

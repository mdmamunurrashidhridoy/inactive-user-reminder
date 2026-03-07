# Laravel Inactive User Reminder System

This Laravel application automatically detects users who have been inactive for a configurable number of days and sends them reminder messages using queued jobs.

The system runs a scheduled command daily to identify inactive users and dispatch reminder jobs.

---

# Features

* Detect users inactive for a configurable number of days
* Daily scheduled command using Laravel Scheduler
* Queue jobs to process reminders
* Prevents sending reminders more than once per day
* Logs reminder actions
* Records reminders in database

---

# Tech Stack

* Laravel
* MySQL
* Laravel Queue (Database Driver)
* Laravel Scheduler (Cron)

---

# How the System Works

1. Users log in and their `last_login_at` timestamp is updated.
2. A scheduled command runs every day.
3. The command finds users who have not logged in for the configured number of days.
4. For each inactive user, a queued job is dispatched.
5. The job simulates sending a reminder by logging the message and recording it in the database.

---

# Database

## Users Table

The default Laravel `users` table is used with an additional column:

```
last_login_at (timestamp, nullable)
```

This column tracks when a user last logged in.

---

## inactive_user_reminders Table

Stores reminder history to prevent duplicate reminders.

Columns:

```
id
user_id
sent_at
sent_date
channel
message

```

A unique constraint prevents sending more than one reminder per user per day.

---

# Setup Instructions

Local Development (XAMPP)

If you are using XAMPP, place the project inside the htdocs directory.

Example:
```
C:\xampp\htdocs\inactive-user-reminder
```

## 1. Clone the Repository

```
https://github.com/mdmamunurrashidhridoy/inactive-user-reminder.git
cd inactive-user-reminder
```

---

## 2. Install Dependencies

```
composer install
```

---

## 3. Copy Environment File

```
cp .env.example .env
```

---

## 4. Configure Environment

Update database credentials in `.env`

```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=inactive_user_reminder
DB_USERNAME=root
DB_PASSWORD=
```

Set queue driver:

```
QUEUE_CONNECTION=database
```

Set inactivity configuration:

```
INACTIVE_USER_DAYS=7
INACTIVE_USER_REMINDER_CHANNEL=log
```

---

## 5. Generate Application Key

```
php artisan key:generate
```

---

## 6. Run Migrations

```
php artisan migrate:fresh --seed
```

---

## 7. Create Queue Tables

```
php artisan queue:table
php artisan migrate
```

---

# Running the Application

Start the development server:

```
php artisan serve
```

---

# How to Run the Scheduler

The scheduler runs the command that detects inactive users.

Run locally:

```
php artisan schedule:work
```


---

# How to Run the Queue Worker

The queue worker processes reminder jobs.

Run:

```
php artisan queue:work
```

---

# Manual Testing

You can manually run the inactive user detection command:

```
php artisan users:process-inactive
```

Then process jobs:

```
php artisan queue:work
```

---

# Logs

Reminder messages are written to:

```
storage/logs/laravel.log
```

Example log entry:

```
Reminder sent to inactive user: inactiveUser <inactiveuser@example.com>
```

---

# Example Scenario

| User   | Last Login  | Result        |
| ------ | ----------- | ------------- |
| User A | 2 days ago  | Active        |
| User B | 10 days ago | Reminder Sent |
| User C | 15 days ago | Reminder Sent |

---

# Laravel Concepts Used

* Eloquent ORM
* Migrations
* Queued Jobs
* Artisan Commands
* Laravel Scheduler
* Configuration Files

---



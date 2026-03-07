<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create("user_reminders", function (Blueprint $table) {
            $table->id();
            $table->foreignId("user_id")->constrained()->cascadeOnDelete();
            $table->timestamp("sent_at");
            $table->date("sent_date");
            $table->string('channel')->default('log');
            $table->text('message')->nullable();
            $table->timestamps();

            $table->unique(["user_id", "sent_date"]);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists("user_reminders");
    }
};

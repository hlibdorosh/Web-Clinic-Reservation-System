<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->text('google_calendar_token')->nullable()->after('remember_token');
            $table->timestamp('google_calendar_token_expires_at')->nullable()->after('google_calendar_token');
            $table->text('google_calendar_refresh_token')->nullable()->after('google_calendar_token_expires_at');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['google_calendar_token', 'google_calendar_token_expires_at', 'google_calendar_refresh_token']);
        });
    }
};


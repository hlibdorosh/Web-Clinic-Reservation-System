<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Record when each consent was given, so it can be shown or proven later.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->timestamp('terms_accepted_at')->nullable();
            $table->timestamp('privacy_accepted_at')->nullable();
            $table->timestamp('age_confirmed_at')->nullable();
        });

        Schema::table('patient_info', function (Blueprint $table) {
            $table->timestamp('health_data_consent_at')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('patient_info', function (Blueprint $table) {
            $table->dropColumn('health_data_consent_at');
        });

        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['terms_accepted_at', 'privacy_accepted_at', 'age_confirmed_at']);
        });
    }
};

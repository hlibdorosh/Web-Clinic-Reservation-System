<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('terms', function (Blueprint $table) {
            $table->id();
            $table->foreignId('doc_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('dep_id')->constrained('departments')->onDelete('cascade');
            $table->foreignId('cab_id')->constrained('cabinets')->onDelete('cascade');
            $table->time('start_time');
            $table->time('end_time');
            $table->boolean('is_taken')->default(false);
            $table->text('desc')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('terms');
    }
};

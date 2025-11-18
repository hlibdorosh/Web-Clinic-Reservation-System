<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('cabinets', function (Blueprint $table) {
            $table->id();
            $table->string('number');
            $table->text('desc')->nullable();
            $table->foreignId('dep_id')->constrained('departments')->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('cabinets');
    }
};

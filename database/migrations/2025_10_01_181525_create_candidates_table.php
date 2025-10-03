<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('candidates', function (Blueprint $table) {
            $table->id();
            $table->string('first_name');
            $table->string('last_name');
            $table->foreignId('party_id')->nullable()->constrained('parties')->nullOnDelete();
            $table->foreignId('position_id')->constrained('positions')->cascadeOnDelete();
            $table->string('status')->default('Registered'); // <-- Add this line
            $table->timestamps();

            $table->index('status');
            $table->index('position_id');
            $table->index('party_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('candidates');
    }
};
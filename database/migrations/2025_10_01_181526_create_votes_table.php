<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('votes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('voter_id')->constrained('voters')->cascadeOnDelete();
            $table->foreignId('candidate_id')->constrained('candidates')->cascadeOnDelete();
            $table->string('vote_type')->default('Valid'); // <-- Add this line
            $table->string('ward')->nullable(); // <-- Add this line
            $table->timestamps();

            $table->unique(['voter_id', 'candidate_id']); // optional, prevent double voting per candidate

            $table->index('ward');
            $table->index('vote_type');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('votes');
    }
};
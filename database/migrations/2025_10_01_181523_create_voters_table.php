<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('voters', function (Blueprint $table) {
            $table->id(); // This can be your Count
            $table->string('voter_registration_number')->unique();
            $table->string('last_name');
            $table->string('first_name');
            $table->enum('gender', ['M', 'F']);
            $table->enum('status', ['Registered', 'Not Registered'])->index();
            $table->date('registration_date');
            $table->string('categories')->nullable();
            $table->string('constituency_ward')->nullable();
            $table->timestamps();

            $table->index('gender');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('voters');
    }
};


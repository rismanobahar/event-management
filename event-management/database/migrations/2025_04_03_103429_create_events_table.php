<?php

use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('events', function (Blueprint $table) {
            $table->id(); // Primary key for the events table

            $table->foreignIdFor(User::class); // Foreign key for the user table
            $table->string('name'); // Name of the event
            $table->text('description')->nullable(); // Description of the event

            $table->dateTime('start_time'); // Start time of the event
            $table->dateTime('end_time'); // End time of the event

            $table->timestamps(); // Timestamps for created_at and updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('events');
    }
};

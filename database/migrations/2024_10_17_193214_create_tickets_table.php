<?php

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
        Schema::create('tickets', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description');
            $table->foreignId('requester_id')->constrained('users')->onDelete('cascade')->onUpdate('cascade');
            $table->enum('status', ['Open', 'In Progress', 'On Hold', 'Closed'])->default('Open');
            $table->enum('priority', ['Low', 'Urgent', 'Emergency']);
            $table->foreignId('handler_id')->nullable()->constrained('users')->onDelete('cascade')->onUpdate('cascade');
            $table->text('notes')->nullable();
            $table->timestamps();
            $table->timestamp('resolved_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tickets');
    }
};

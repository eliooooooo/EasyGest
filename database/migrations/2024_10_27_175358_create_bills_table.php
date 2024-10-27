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
        Schema::create('bills', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->foreignId('client_id')->references('id')->on('clients')->onDelete('set null');
            $table->string('number')->unique();
            $table->date('date');
            $table->date('due_date');
            $table->string('status');
            $table->string('currency');
            $table->integer('amount');
            $table->text('notes')->nullable();
            $table->text('items');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bills');
    }
};

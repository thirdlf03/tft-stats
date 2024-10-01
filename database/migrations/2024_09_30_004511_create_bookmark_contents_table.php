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
        Schema::create('bookmark_contents', function (Blueprint $table) {
            $table->id();
            $table->foreignId('bookmark_id')->constrained('bookmarks')->cascadeOnDelete();
            $table->foreignId('result_id')->constrained('results')->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bookmark_contents');
    }
};

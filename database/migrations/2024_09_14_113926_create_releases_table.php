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
        Schema::create('releases', function (Blueprint $table) {
            $table->id();
            $table->string('upc')->nullable();
            $table->string('email');
            $table->string('artist_name');
            $table->string('file_path');
            $table->string('status')->default('review');
            $table->string('title');
            $table->string('featuring')->default('-')->nullable();
            $table->string('image_file_path');
            $table->string('type');
            $table->string('explicit');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('releases');
    }
};

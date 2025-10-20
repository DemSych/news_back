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
        Schema::create('news_container', function (Blueprint $table) {
            $table->id();
            $table->string('title', length: 100);
            $table->string('short_content', length: 400);
            $table->text('content');
            $table->string('news_img', length: 255);
            $table->string('date', length: 255);
            $table->integer('like');
            $table->integer('views');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('news_container');
    }
};

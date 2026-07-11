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
        Schema::create('movies', function (Blueprint $table) {
            $table->id();
            $table->string('title', 255);
            $table->string('slug', 255)->unique();
            $table->text('description');
            // $table->string('director', 255);
            // $table->string('writers', 200);
            // $table->string('stars', 255);
            $table->string('poster', 255);
            $table->datetime('release_date');
            $table->integer('duration');
            $table->string('url_720', 255);
            $table->string('url_1080', 255);
            $table->string('url_4k', 255);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('movies');
    }
};

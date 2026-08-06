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
    Schema::create('news', function (Blueprint $table) {
        $table->id();

        $table->foreignId('website_id')->constrained()->onDelete('cascade');

        $table->foreignId('category_id')->constrained()->onDelete('cascade');

        $table->string('title');

        $table->string('slug')->unique();

        $table->string('featured_image')->nullable();

        $table->longText('description');

        $table->string('meta_title')->nullable();

        $table->text('meta_description')->nullable();

        $table->string('meta_keywords')->nullable();

        $table->dateTime('published_at')->nullable();

        $table->boolean('is_featured')->default(false);

        $table->boolean('status')->default(true);

        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('news');
    }
};

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
        Schema::table('themes', function (Blueprint $table) {

            $table->enum('type', ['free', 'premium'])
             ->default('free')
             ->after('description');

             $table->decimal('price', 10 , 2)
             ->default(0)
             ->after('type');

             $table->unsignedInteger('trial_days')
             ->default(0)
             ->after('price');


             $table->string('preview_image')
             ->nullable()
             ->after('trial_days');

             $table->string('theme_path')
             ->nullable()
             ->after('preview_image');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('themes', function (Blueprint $table) {
            
        $table->dropColumn([
            'type',
            'price',
            'trial_days',
            'preview_image',
            'theme_path',
        ]);
        
        });
    }
};

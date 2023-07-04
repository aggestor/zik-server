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
        Schema::table('users', function(Blueprint $table) {
            // add colomn

            $table->string('firstname');
            $table->string('lastname')->nullable();
            $table->string('postname')->nullable();
            $table->string('phone');
            $table->string('birthPlace');
            $table->date('birthDate');
            $table->string('province')->nullable();
            $table->string('city')->nullable();
            $table->string('image')->nullable();
            $table->text('socialMedia')->nullable();
        });
     
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};

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
        //
        Schema::table('users', function(Blueprint $table) {


            $table->dropColumn('nom');
            $table->dropColumn('postnom');
            $table->dropColumn('prenom');
            $table->dropColumn('tel');
            $table->dropColumn('lieuDeNaissance');
            $table->dropColumn('dateDeNaissance');
            $table->dropColumn('province');
            $table->dropColumn('ville');
            $table->dropColumn('reseauxSociaux');
            $table->dropColumn('photo');
            $table->dropColumn('name');

      

 

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

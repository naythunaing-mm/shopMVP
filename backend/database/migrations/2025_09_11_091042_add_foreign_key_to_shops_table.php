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
        // First, make sure the user_id column exists and is an unsigned big integer
        Schema::table('shops', function (Blueprint $table) {
            $table->unsignedBigInteger('user_id')->change();
        });
        
        // Then add the foreign key constraint
        Schema::table('shops', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->foreign('user_id')
                  ->references('id')
                  ->on('users')
                  ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Drop the foreign key first
        Schema::table('shops', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
        });
        
        // Then change the column back to its original state
        Schema::table('shops', function (Blueprint $table) {
            $table->unsignedInteger('user_id')->change();
        });
    }
};

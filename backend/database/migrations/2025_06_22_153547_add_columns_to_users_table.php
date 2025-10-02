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
        Schema::table('users', function (Blueprint $table) {
            $table->string("default_address")->nullable()->after('email');
            $table->string("phone")->nullable()->after("default_address");
            $table->string("profile_pic")->nullable()->after("phone");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                "default_address",
                "phone",
                "profile_pic"
            ]);
        });
    }
};

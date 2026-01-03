<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('steam_id64', 32)->nullable()->index();
            $table->string('steam_hex', 32)->nullable()->index(); // nt "steam:110000112345678"
            $table->timestamp('steam_connected_at')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['steam_id64', 'steam_hex', 'steam_connected_at']);
        });
    }
};

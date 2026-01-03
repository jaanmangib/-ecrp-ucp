<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->boolean('requires_rp_test')->default(true)->after('email_verified_at');
            $table->boolean('rp_test_passed')->default(false)->after('requires_rp_test');
            $table->timestamp('rp_test_failed_until')->nullable()->after('rp_test_passed');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['requires_rp_test', 'rp_test_passed', 'rp_test_failed_until']);
        });
    }
};
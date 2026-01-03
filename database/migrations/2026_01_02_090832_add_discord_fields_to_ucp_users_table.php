<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {

    private function withoutPrefix(callable $callback): void
    {
        $conn = Schema::getConnection();
        $oldPrefix = $conn->getTablePrefix();

        $conn->setTablePrefix(''); // ✅ force no prefix
        try {
            $callback();
        } finally {
            $conn->setTablePrefix($oldPrefix); // restore
        }
    }

    public function up(): void
    {
        $this->withoutPrefix(function () {
            Schema::table('users', function (Blueprint $table) {
                $table->string('discord_id', 32)->nullable()->index();
                $table->string('discord_username')->nullable();
                $table->string('discord_avatar')->nullable();
                $table->timestamp('discord_connected_at')->nullable();
            });
        });
    }

    public function down(): void
    {
        $this->withoutPrefix(function () {
            Schema::table('users', function (Blueprint $table) {
                $table->dropColumn([
                    'discord_connected_at',
                    'discord_avatar',
                    'discord_username',
                ]);

                $table->dropIndex(['discord_id']);
                $table->dropColumn('discord_id');
            });
        });
    }
};

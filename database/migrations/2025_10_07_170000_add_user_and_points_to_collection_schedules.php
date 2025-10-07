<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('collection_schedules', function (Blueprint $table) {
            if (! Schema::hasColumn('collection_schedules', 'user_id')) {
                $table->foreignId('user_id')
                    ->nullable()
                    ->after('id')
                    ->constrained('users')
                    ->nullOnDelete();
            }

            if (! Schema::hasColumn('collection_schedules', 'type')) {
                $table->string('type')->nullable()->after('address');
            }

            if (! Schema::hasColumn('collection_schedules', 'actual_weight')) {
                $table->decimal('actual_weight', 8, 2)->nullable()->after('estimated_weight');
            }

            if (! Schema::hasColumn('collection_schedules', 'points_awarded')) {
                $table->unsignedInteger('points_awarded')->default(0)->after('actual_weight');
            }
        });
    }

    public function down(): void
    {
        Schema::table('collection_schedules', function (Blueprint $table) {
            if (Schema::hasColumn('collection_schedules', 'points_awarded')) {
                $table->dropColumn('points_awarded');
            }
            if (Schema::hasColumn('collection_schedules', 'actual_weight')) {
                $table->dropColumn('actual_weight');
            }
            if (Schema::hasColumn('collection_schedules', 'type')) {
                $table->dropColumn('type');
            }
            if (Schema::hasColumn('collection_schedules', 'user_id')) {
                $table->dropConstrainedForeignId('user_id');
            }
        });
    }
};


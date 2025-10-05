<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::table('users', function (Blueprint $table) {
            // Datos para registro de cliente
            $table->string('first_name')->nullable()->after('id');
            $table->string('last_name')->nullable()->after('first_name');
            $table->string('phone', 30)->nullable()->after('email');
            $table->string('address')->nullable()->after('phone');
            $table->string('locality')->nullable()->after('address');

            // Tipo de usuario (cliente, empresa, admin)
            $table->string('user_type', 20)->default('cliente')->after('locality');
        });
    }

    public function down(): void {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['first_name','last_name','phone','address','locality','user_type']);
        });
    }
};

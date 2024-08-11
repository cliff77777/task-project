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
        Schema::create('user_roles', function (Blueprint $table) {
            $table->id();
            $table->string('role_name');
            $table->string('role_control');
            $table->string('role_descript');
            $table->foreignId('created_by')->constrained('users');
            $table->foreignId('updated_by')->nullable()->constrained('users');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // 先確保刪除所有引用此表的外鍵約束
        Schema::disableForeignKeyConstraints();
        // 然後刪除表
        Schema::dropIfExists('user_roles');
        // 重新啟用外鍵約束
        Schema::enableForeignKeyConstraints();
        
    }
};

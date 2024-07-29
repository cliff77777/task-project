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
        Schema::create('tasks', function (Blueprint $table) {
            $table->id();
            $table->string('subject');
            $table->text('description');
            $table->decimal('estimated_hours', 5, 1);
            $table->foreignId('created_by')->constrained('users');
            $table->foreignId('assigned_to')->nullable()->constrained('users');
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
        Schema::dropIfExists('tasks');

        // 重新啟用外鍵約束
        Schema::enableForeignKeyConstraints();
    }
};

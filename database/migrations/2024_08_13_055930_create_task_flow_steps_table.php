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
        Schema::create('task_flow_steps', function (Blueprint $table) {
            $table->id();
            $table->foreignId('task_flow_template_id')->constrained('task_flow_template');
            $table->foreignId('to_role')->constrained('user_roles');
            $table->integer('order');
            $table->boolean('sendEmailNotification');
            $table->string('descript');
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
        Schema::dropIfExists('task_flow_steps');
        // 重新啟用外鍵約束
        Schema::enableForeignKeyConstraints();
    }
};
